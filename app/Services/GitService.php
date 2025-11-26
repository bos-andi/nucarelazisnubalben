<?php

namespace App\Services;

use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Log;

class GitService
{
    private string $repositoryPath;
    private string $branch;
    private string $gitPath;

    public function __construct()
    {
        $this->repositoryPath = base_path();
        $this->branch = config('app.git_branch', 'main');
        
        // Set Git path for Windows
        $this->gitPath = $this->isWindows() 
            ? '"C:\Program Files\Git\cmd\git.exe"'
            : 'git';
    }

    /**
     * Check if git repository exists
     */
    public function isGitRepository(): bool
    {
        return is_dir($this->repositoryPath . '/.git');
    }

    /**
     * Check if remote origin exists
     */
    public function hasRemoteOrigin(): bool
    {
        try {
            $result = $this->runCommand('git remote get-url origin');
            return !empty(trim($result['output']));
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get remote origin URL
     */
    public function getRemoteOriginUrl(): ?string
    {
        try {
            $result = $this->runCommand('git remote get-url origin');
            return trim($result['output']) ?: null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Add remote origin
     */
    public function addRemoteOrigin(string $url): array
    {
        try {
            if ($this->hasRemoteOrigin()) {
                // Remove existing origin first
                $this->runCommand('git remote remove origin');
            }
            
            // Escape URL for shell command
            $escapedUrl = escapeshellarg($url);
            $this->runCommand("git remote add origin {$escapedUrl}");
            
            return [
                'success' => true,
                'message' => 'Remote origin added successfully'
            ];
        } catch (\Exception $e) {
            Log::error('Add remote origin failed: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Initialize git repository
     */
    public function initRepository(string $remoteUrl): array
    {
        try {
            if (!$this->isGitRepository()) {
                $this->runCommand('git init');
                // Escape URL for shell command
                $escapedUrl = escapeshellarg($remoteUrl);
                $this->runCommand("git remote add origin {$escapedUrl}");
            }
            
            return ['success' => true, 'message' => 'Repository initialized successfully'];
        } catch (\Exception $e) {
            Log::error('Git init failed: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Get current commit hash
     */
    public function getCurrentCommit(): ?string
    {
        try {
            $result = $this->runCommand('git rev-parse HEAD');
            return trim($result['output']);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get current branch
     */
    public function getCurrentBranch(): ?string
    {
        try {
            $result = $this->runCommand('git branch --show-current');
            return trim($result['output']);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Check for updates
     */
    public function checkForUpdates(): array
    {
        try {
            // Check if remote origin exists
            if (!$this->hasRemoteOrigin()) {
                return [
                    'success' => false,
                    'message' => 'No remote repository configured. Please add a remote origin to check for updates.',
                    'has_updates' => false,
                    'current_commit' => $this->getCurrentCommit(),
                    'remote_commit' => null,
                    'changes' => []
                ];
            }

            // Fetch latest changes
            $this->runCommand('git fetch origin');
            
            // Get current branch
            $currentBranch = $this->getCurrentBranch();
            $currentCommit = $this->getCurrentCommit();
            
            // Try to get remote commit - handle case where remote branch doesn't exist
            try {
                $remoteResult = $this->runCommand("git rev-parse origin/{$currentBranch}");
                $remoteCommit = trim($remoteResult['output']);
                
                $hasUpdates = $currentCommit !== $remoteCommit;
                
                $changes = [];
                if ($hasUpdates) {
                    $changesResult = $this->runCommand("git log --oneline {$currentCommit}..{$remoteCommit}");
                    $changes = array_filter(explode("\n", $changesResult['output']));
                }
                
                return [
                    'success' => true,
                    'has_updates' => $hasUpdates,
                    'current_commit' => $currentCommit,
                    'remote_commit' => $remoteCommit,
                    'changes' => $changes
                ];
            } catch (\Exception $e) {
                // Remote branch doesn't exist - this is normal for new repositories
                return [
                    'success' => true,
                    'has_updates' => false,
                    'current_commit' => $currentCommit,
                    'remote_commit' => null,
                    'changes' => [],
                    'message' => "Remote branch '{$currentBranch}' not found. You may need to push your local branch first."
                ];
            }
        } catch (\Exception $e) {
            Log::error('Check updates failed: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Pull latest changes
     */
    public function pullUpdates(): array
    {
        try {
            // Check if remote origin exists
            if (!$this->hasRemoteOrigin()) {
                return [
                    'success' => false,
                    'message' => 'No remote repository configured. Cannot pull updates without remote origin.',
                    'log' => 'Error: No remote origin configured'
                ];
            }

            $log = [];
            
            // Stash any local changes
            $stashResult = $this->runCommand('git stash');
            $log[] = "Stash: " . $stashResult['output'];
            
            // Pull latest changes
            $pullResult = $this->runCommand("git pull origin {$this->branch}");
            $log[] = "Pull: " . $pullResult['output'];
            
            // Get changed files
            $changedFiles = $this->getChangedFiles();
            
            return [
                'success' => true,
                'log' => implode("\n", $log),
                'changed_files' => $changedFiles
            ];
        } catch (\Exception $e) {
            Log::error('Git pull failed: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Get changed files in last commit
     */
    public function getChangedFiles(): array
    {
        try {
            $result = $this->runCommand('git diff --name-only HEAD~1 HEAD');
            return array_filter(explode("\n", $result['output']));
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Rollback to previous commit
     */
    public function rollback(string $commitHash): array
    {
        try {
            $result = $this->runCommand("git reset --hard {$commitHash}");
            
            return [
                'success' => true,
                'message' => 'Rollback successful',
                'output' => $result['output']
            ];
        } catch (\Exception $e) {
            Log::error('Git rollback failed: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Get commit history
     */
    public function getCommitHistory(int $limit = 10): array
    {
        try {
            $result = $this->runCommand("git log --oneline -n {$limit}");
            $commits = array_filter(explode("\n", $result['output']));
            
            $history = [];
            foreach ($commits as $commit) {
                if (preg_match('/^([a-f0-9]+)\s+(.+)$/', $commit, $matches)) {
                    $history[] = [
                        'hash' => $matches[1],
                        'message' => $matches[2]
                    ];
                }
            }
            
            return ['success' => true, 'commits' => $history];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Run git command
     */
    private function runCommand(string $command): array
    {
        // Replace 'git' with full path
        $command = str_replace('git ', $this->gitPath . ' ', $command);
        
        // Escape path for Windows
        $escapedPath = escapeshellarg($this->repositoryPath);
        
        // Use proper command separator for Windows/Unix
        $separator = $this->isWindows() ? ' && ' : ' && ';
        $fullCommand = "cd {$escapedPath}{$separator}{$command}";
        
        try {
            $process = Process::run($fullCommand);
            
            if ($process->failed()) {
                throw new \Exception("Command failed: {$command}\nError: " . $process->errorOutput());
            }
            
            return [
                'success' => true,
                'output' => $process->output(),
                'error' => $process->errorOutput()
            ];
        } catch (\Exception $e) {
            Log::error("Git command failed: {$fullCommand}", ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Check if running on Windows
     */
    private function isWindows(): bool
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }
}
