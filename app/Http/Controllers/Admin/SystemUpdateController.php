<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemUpdate;
use App\Services\GitService;
use App\Services\DeploymentService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SystemUpdateController extends Controller
{
    private GitService $gitService;
    private DeploymentService $deploymentService;

    public function __construct(GitService $gitService, DeploymentService $deploymentService)
    {
        $this->gitService = $gitService;
        $this->deploymentService = $deploymentService;
        
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
}