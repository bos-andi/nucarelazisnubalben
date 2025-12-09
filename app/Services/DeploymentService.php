<?php

namespace App\Services;

use App\Models\SystemUpdate;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;

class DeploymentService
{
    private GitService $gitService;

    public function __construct(GitService $gitService)
    {
        $this->gitService = $gitService;
    }

    /**
     * Deploy updates
     */
    public function deploy(SystemUpdate $update): array
    {
        try {
            $update->update([
                'status' => 'in_progress',
                'started_at' => now()
            ]);

            $log = [];
            
            // Step 1: Pull latest code
            $log[] = "=== PULLING LATEST CODE ===";
            $pullResult = $this->gitService->pullUpdates();
            if (!$pullResult['success']) {
                throw new \Exception("Git pull failed: " . $pullResult['message']);
            }
            $log[] = $pullResult['log'];
            
            // Step 2: Install/Update Composer dependencies
            $log[] = "\n=== UPDATING DEPENDENCIES ===";
            $composerResult = $this->runComposerInstall();
            $log[] = $composerResult['output'];
            
            // Step 3: Run database migrations
            $log[] = "\n=== RUNNING MIGRATIONS ===";
            $migrationResult = $this->runMigrations();
            $log[] = $migrationResult['output'];
            
            // Step 4: Clear and cache config
            $log[] = "\n=== CLEARING CACHE ===";
            $cacheResult = $this->clearAndCacheConfig();
            $log[] = $cacheResult['output'];
            
            // Step 5: Create storage link if needed
            $log[] = "\n=== CREATING STORAGE LINK ===";
            $storageResult = $this->createStorageLink();
            $log[] = $storageResult['output'];
            
            // Step 6: Set permissions (if on Linux/Unix)
            if (!$this->isWindows()) {
                $log[] = "\n=== SETTING PERMISSIONS ===";
                $permissionResult = $this->setPermissions();
                $log[] = $permissionResult['output'];
            }
            
            $update->update([
                'status' => 'completed',
                'completed_at' => now(),
                'log' => implode("\n", $log),
                'commit_hash' => $this->gitService->getCurrentCommit(),
                'changes' => $pullResult['changed_files'] ?? []
            ]);
            
            return ['success' => true, 'message' => 'Deployment completed successfully'];
            
        } catch (\Exception $e) {
            $update->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'log' => implode("\n", $log ?? [])
            ]);
            
            Log::error('Deployment failed: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Rollback to previous version
     */
    public function rollback(SystemUpdate $currentUpdate, string $previousCommitHash): array
    {
        try {
            $log = [];
            
            // Step 1: Git rollback
            $log[] = "=== ROLLING BACK CODE ===";
            $rollbackResult = $this->gitService->rollback($previousCommitHash);
            if (!$rollbackResult['success']) {
                throw new \Exception("Git rollback failed: " . $rollbackResult['message']);
            }
            $log[] = $rollbackResult['output'];
            
            // Step 2: Reinstall dependencies
            $log[] = "\n=== REINSTALLING DEPENDENCIES ===";
            $composerResult = $this->runComposerInstall();
            $log[] = $composerResult['output'];
            
            // Step 3: Clear cache
            $log[] = "\n=== CLEARING CACHE ===";
            $cacheResult = $this->clearAndCacheConfig();
            $log[] = $cacheResult['output'];
            
            $currentUpdate->update([
                'status' => 'rolled_back',
                'log' => implode("\n", $log)
            ]);
            
            return ['success' => true, 'message' => 'Rollback completed successfully'];
            
        } catch (\Exception $e) {
            Log::error('Rollback failed: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Run composer install
     */
    private function runComposerInstall(): array
    {
        // Find composer path based on OS
        $composerPath = $this->findComposerPath();
        
        // Use different flags based on environment
        $flags = app()->environment('production') 
            ? '--no-dev --optimize-autoloader --no-interaction'
            : '--optimize-autoloader --no-interaction';
            
        $command = "{$composerPath} install {$flags}";
        return $this->runCommand($command);
    }

    /**
     * Find Composer executable path
     */
    private function findComposerPath(): string
    {
        if ($this->isWindows()) {
            // Try common Windows paths
            $paths = [
                'composer', // If composer is in PATH
                '"C:\ProgramData\ComposerSetup\bin\composer.bat"',
                '"C:\composer\composer.bat"',
            ];
            
            foreach ($paths as $path) {
                try {
                    $process = Process::timeout(5)->run($path . ' --version');
                    if ($process->successful()) {
                        return $path;
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }
            
            return 'composer'; // Fallback
        }
        
        // For Linux/Unix (Ubuntu, etc.)
        $paths = [
            'composer', // Usually in PATH
            '/usr/local/bin/composer',
            '/usr/bin/composer',
            'php /usr/local/bin/composer.phar',
            'php composer.phar',
        ];
        
        foreach ($paths as $path) {
            try {
                $process = Process::timeout(5)->run($path . ' --version');
                if ($process->successful()) {
                    return $path;
                }
            } catch (\Exception $e) {
                continue;
            }
        }
        
        return 'composer'; // Fallback
    }

    /**
     * Run database migrations
     */
    private function runMigrations(): array
    {
        try {
            Artisan::call('migrate', ['--force' => true]);
            return [
                'success' => true,
                'output' => Artisan::output()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'output' => 'Migration failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Clear and cache configuration
     */
    private function clearAndCacheConfig(): array
    {
        try {
            $output = [];
            
            // Clear caches
            Artisan::call('config:clear');
            $output[] = "Config cache cleared";
            
            Artisan::call('route:clear');
            $output[] = "Route cache cleared";
            
            Artisan::call('view:clear');
            $output[] = "View cache cleared";
            
            // Cache config and routes for production
            if (app()->environment('production')) {
                Artisan::call('config:cache');
                $output[] = "Config cached";
                
                Artisan::call('route:cache');
                $output[] = "Routes cached";
                
                Artisan::call('view:cache');
                $output[] = "Views cached";
            }
            
            return [
                'success' => true,
                'output' => implode("\n", $output)
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'output' => 'Cache operations failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Create storage link
     */
    private function createStorageLink(): array
    {
        try {
            if (!file_exists(public_path('storage'))) {
                Artisan::call('storage:link');
                return [
                    'success' => true,
                    'output' => 'Storage link created'
                ];
            }
            
            return [
                'success' => true,
                'output' => 'Storage link already exists'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'output' => 'Storage link failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Set file permissions (Linux/Unix only)
     */
    private function setPermissions(): array
    {
        try {
            $commands = [
                'chmod -R 755 ' . base_path(),
                'chmod -R 775 ' . storage_path(),
                'chmod -R 775 ' . base_path('bootstrap/cache')
            ];
            
            $output = [];
            foreach ($commands as $command) {
                $result = $this->runCommand($command);
                $output[] = $result['output'];
            }
            
            return [
                'success' => true,
                'output' => implode("\n", $output)
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'output' => 'Permission setting failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Check if running on Windows
     */
    private function isWindows(): bool
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }

    /**
     * Run system command
     */
    private function runCommand(string $command): array
    {
        try {
            // For Linux/Ubuntu, ensure we're using bash for complex commands
            if (!$this->isWindows() && (str_contains($command, '&&') || str_contains($command, '|'))) {
                $command = "bash -c " . escapeshellarg($command);
            }
            
            $process = Process::timeout(60)->run($command);
            
            return [
                'success' => !$process->failed(),
                'output' => $process->output(),
                'error' => $process->errorOutput()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'output' => 'Command failed: ' . $e->getMessage()
            ];
        }
    }
}
