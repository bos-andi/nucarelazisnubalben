<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemUpdate;
use App\Services\GitService;
use App\Services\DeploymentService;
use App\Services\ManualUpdateService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SystemUpdateController extends Controller
{
    private GitService $gitService;
    private DeploymentService $deploymentService;
    private ManualUpdateService $manualUpdateService;

    public function __construct(
        GitService $gitService, 
        DeploymentService $deploymentService,
        ManualUpdateService $manualUpdateService
    ) {
        $this->gitService = $gitService;
        $this->deploymentService = $deploymentService;
        $this->manualUpdateService = $manualUpdateService;
        
        // Only superadmin can access system updates
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isSuperAdmin()) {
                abort(403, 'Access denied. Only superadmin can manage system updates.');
            }
            return $next($request);
        });
    }

    /**
     * Display system update dashboard
     */
    public function index(): View
    {
        $currentCommit = $this->gitService->getCurrentCommit();
        $currentBranch = $this->gitService->getCurrentBranch();
        $isGitRepo = $this->gitService->isGitRepository();
        $hasRemoteOrigin = $this->gitService->hasRemoteOrigin();
        $remoteOriginUrl = $this->gitService->getRemoteOriginUrl();
        $isUpdating = SystemUpdate::isUpdating();
        
        // Get update history
        $updateHistory = SystemUpdate::getHistory(10);
        
        // Get latest successful update
        $latestUpdate = SystemUpdate::getLatestSuccessful();
        
        // Check for available updates
        $updateCheck = null;
        if ($isGitRepo) {
            try {
                $updateCheck = $this->gitService->checkForUpdates();
            } catch (\Exception $e) {
                $updateCheck = [
                    'success' => false,
                    'message' => 'Error checking updates: ' . $e->getMessage()
                ];
            }
        }
        
        return view('admin.system-updates.index', compact(
            'currentCommit',
            'currentBranch',
            'isGitRepo',
            'hasRemoteOrigin',
            'remoteOriginUrl',
            'isUpdating',
            'updateHistory',
            'latestUpdate',
            'updateCheck'
        ));
    }

    /**
     * Initialize Git repository
     */
    public function initRepository(Request $request): JsonResponse
    {
        $request->validate([
            'repository_url' => 'required|url'
        ]);

        $result = $this->gitService->initRepository($request->repository_url);
        
        return response()->json($result);
    }

    /**
     * Add remote origin
     */
    public function addRemoteOrigin(Request $request): JsonResponse
    {
        $request->validate([
            'repository_url' => 'required|url'
        ]);

        $result = $this->gitService->addRemoteOrigin($request->repository_url);
        
        return response()->json($result);
    }

    /**
     * Check for updates
     */
    public function checkUpdates(): JsonResponse
    {
        if (!$this->gitService->isGitRepository()) {
            return response()->json([
                'success' => false,
                'message' => 'Git repository not initialized'
            ]);
        }

        $result = $this->gitService->checkForUpdates();
        
        return response()->json($result);
    }

    /**
     * Deploy updates
     */
    public function deploy(Request $request): JsonResponse
    {
        try {
            if (SystemUpdate::isUpdating()) {
                return response()->json([
                    'success' => false,
                    'message' => 'System is already updating. Please wait for current update to complete.'
                ]);
            }

            $request->validate([
                'description' => 'nullable|string|max:500'
            ]);

            // Create update record
            $update = SystemUpdate::create([
                'description' => $request->description ?? 'Manual update deployment',
                'branch' => $this->gitService->getCurrentBranch() ?? 'main',
                'updated_by' => auth()->id(),
                'status' => 'pending'
            ]);

            // Deploy in background (in real app, use queue)
            $result = $this->deploymentService->deploy($update);
            
            return response()->json([
                'success' => $result['success'],
                'message' => $result['message'],
                'update_id' => $update->id
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Deployment error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Deployment failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Rollback to previous version
     */
    public function rollback(Request $request): JsonResponse
    {
        $request->validate([
            'commit_hash' => 'required|string'
        ]);

        if (SystemUpdate::isUpdating()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot rollback while system is updating'
            ]);
        }

        $latestUpdate = SystemUpdate::getLatestSuccessful();
        if (!$latestUpdate) {
            return response()->json([
                'success' => false,
                'message' => 'No successful update found to rollback'
            ]);
        }

        $result = $this->deploymentService->rollback($latestUpdate, $request->commit_hash);
        
        return response()->json($result);
    }

    /**
     * Get update status
     */
    public function status(SystemUpdate $update): JsonResponse
    {
        $update->load('updatedBy');
        
        return response()->json([
            'success' => true,
            'update' => $update
        ]);
    }

    /**
     * Get update logs
     */
    public function logs(SystemUpdate $update): JsonResponse
    {
        return response()->json([
            'success' => true,
            'logs' => $update->log ?? 'No logs available'
        ]);
    }

    /**
     * Delete update record
     */
    public function destroy(SystemUpdate $update): RedirectResponse
    {
        if ($update->status === 'in_progress') {
            return back()->with('error', 'Cannot delete update that is in progress');
        }

        $update->delete();
        
        return back()->with('success', 'Update record deleted successfully');
    }

    /**
     * Get changed files for manual update
     */
    public function getChangedFilesForManual(): JsonResponse
    {
        try {
            $result = $this->manualUpdateService->getAllChangedFiles();
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Generate manual update package
     */
    public function generateManualUpdatePackage(Request $request): JsonResponse
    {
        try {
            $fromCommit = $request->input('from_commit');
            
            $result = $this->manualUpdateService->generateUpdatePackage($fromCommit);
            
            if ($result['success']) {
                // Create update record
                SystemUpdate::create([
                    'description' => 'Manual update package generated',
                    'branch' => $this->gitService->getCurrentBranch() ?? 'main',
                    'updated_by' => auth()->id(),
                    'status' => 'completed',
                    'completed_at' => now(),
                    'log' => "Package generated: {$result['filename']}\nFiles: {$result['files_count']}\nMigrations: {$result['migrations_count']}"
                ]);
            }
            
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Download manual update package
     */
    public function downloadManualUpdatePackage(Request $request): BinaryFileResponse
    {
        $filename = $request->query('file');
        
        if (!$filename) {
            abort(400, 'Filename parameter is required');
        }
        
        // Decode filename if URL encoded
        $filename = urldecode($filename);
        
        // Validate filename to prevent directory traversal
        $filename = basename($filename);
        
        if (!str_starts_with($filename, 'update-package-') || !str_ends_with($filename, '.zip')) {
            abort(403, 'Invalid filename format');
        }
        
        $filePath = storage_path('app/temp/' . $filename);
        
        if (!file_exists($filePath)) {
            abort(404, 'Update package not found');
        }

        return response()->download($filePath, $filename)->deleteFileAfterSend(true);
    }

    /**
     * Upload manual update package
     */
    public function uploadManualUpdatePackage(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'package' => 'required|file|mimes:zip|max:102400' // Max 100MB
            ]);

            $package = $request->file('package');
            $originalName = $package->getClientOriginalName();

            // Validate filename format
            if (!str_starts_with($originalName, 'update-package-') || !str_ends_with($originalName, '.zip')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid package format. Package must start with "update-package-" and end with ".zip"'
                ], 400);
            }

            // Store uploaded package
            $tempDir = storage_path('app/temp/uploaded');
            if (!is_dir($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            $filename = 'uploaded-' . date('Y-m-d-His') . '-' . $originalName;
            $packagePath = $package->storeAs('temp/uploaded', $filename);

            // Verify ZIP file
            $zip = new \ZipArchive();
            $fullPath = storage_path('app/' . $packagePath);
            
            if ($zip->open($fullPath) !== TRUE) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid ZIP file or file is corrupted'
                ], 400);
            }

            // Get file list from ZIP
            $fileList = [];
            $hasMigrations = false;
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $filename = $zip->getNameIndex($i);
                if ($filename === 'MIGRATIONS.sql') {
                    $hasMigrations = true;
                } elseif ($filename !== 'README.txt' && $filename !== 'FILES_LIST.txt') {
                    $fileList[] = $filename;
                }
            }
            $zip->close();

            return response()->json([
                'success' => true,
                'message' => 'Package uploaded successfully',
                'filename' => $filename,
                'path' => $packagePath,
                'files_count' => count($fileList),
                'has_migrations' => $hasMigrations,
                'file_list' => $fileList
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Upload package failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Apply manual update package (extract and update files)
     */
    public function applyManualUpdatePackage(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'filename' => 'required|string'
            ]);

            $filename = basename($request->filename); // Prevent directory traversal
            $packagePath = storage_path('app/temp/uploaded/' . $filename);

            if (!file_exists($packagePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Package file not found'
                ], 404);
            }

            // Create update record
            $update = SystemUpdate::create([
                'description' => 'Manual update package applied',
                'branch' => $this->gitService->getCurrentBranch() ?? 'main',
                'updated_by' => auth()->id(),
                'status' => 'in_progress',
                'started_at' => now()
            ]);

            $log = [];
            $log[] = "=== APPLYING MANUAL UPDATE PACKAGE ===";
            $log[] = "Package: {$filename}";
            $log[] = "Started at: " . now()->format('Y-m-d H:i:s');

            // Extract ZIP file
            $zip = new \ZipArchive();
            if ($zip->open($packagePath) !== TRUE) {
                throw new \Exception('Cannot open ZIP file');
            }

            $extractedCount = 0;
            $basePath = base_path();
            $migrationSQL = null;

            // Extract files
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $entryName = $zip->getNameIndex($i);
                
                // Skip directories
                if (substr($entryName, -1) === '/') {
                    continue;
                }

                // Handle special files
                if ($entryName === 'MIGRATIONS.sql') {
                    $migrationSQL = $zip->getFromIndex($i);
                    continue;
                }

                if ($entryName === 'README.txt' || $entryName === 'FILES_LIST.txt') {
                    continue;
                }

                // Extract file
                $targetPath = $basePath . '/' . $entryName;
                $targetDir = dirname($targetPath);

                // Create directory if not exists
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0755, true);
                }

                // Extract file
                $fileContent = $zip->getFromIndex($i);
                if ($fileContent !== false) {
                    file_put_contents($targetPath, $fileContent);
                    $extractedCount++;
                    $log[] = "Extracted: {$entryName}";
                }
            }

            $zip->close();
            $log[] = "\n=== EXTRACTION COMPLETE ===";
            $log[] = "Files extracted: {$extractedCount}";

            // Apply migrations if any
            if ($migrationSQL) {
                $log[] = "\n=== APPLYING MIGRATIONS ===";
                try {
                    DB::unprepared($migrationSQL);
                    $log[] = "Migrations applied successfully";
                } catch (\Exception $e) {
                    $log[] = "Migration error: " . $e->getMessage();
                    // Continue even if migration fails
                }
            }

            // Clear cache
            $log[] = "\n=== CLEARING CACHE ===";
            try {
                Artisan::call('config:clear');
                Artisan::call('cache:clear');
                Artisan::call('view:clear');
                $log[] = "Cache cleared successfully";
            } catch (\Exception $e) {
                $log[] = "Cache clear error: " . $e->getMessage();
            }

            // Delete uploaded package
            @unlink($packagePath);

            // Update record
            $update->update([
                'status' => 'completed',
                'completed_at' => now(),
                'log' => implode("\n", $log)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Update package applied successfully',
                'files_extracted' => $extractedCount,
                'has_migrations' => !empty($migrationSQL)
            ]);

        } catch (\Exception $e) {
            \Log::error('Apply package failed: ' . $e->getMessage());
            
            if (isset($update)) {
                $update->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                    'log' => implode("\n", $log ?? [])
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to apply package: ' . $e->getMessage()
            ], 500);
        }
    }
}