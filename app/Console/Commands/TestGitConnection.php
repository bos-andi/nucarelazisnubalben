<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GitService;

class TestGitConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'git:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Git connection and commands';

    /**
     * Execute the console command.
     */
    public function handle(GitService $gitService): int
    {
        $this->info('🚀 Testing Git Connection...');
        $this->newLine();

        // Test 1: Check if Git is installed
        $this->info('1. Checking if Git is installed...');
        try {
            $result = shell_exec('git --version');
            if ($result) {
                $this->info("   ✅ Git installed: " . trim($result));
            } else {
                $this->error("   ❌ Git not found in PATH");
                return 1;
            }
        } catch (\Exception $e) {
            $this->error("   ❌ Error checking Git: " . $e->getMessage());
            return 1;
        }

        // Test 2: Check current directory
        $this->info('2. Checking current directory...');
        $this->info("   📁 Base path: " . base_path());

        // Test 3: Check if Git repository exists
        $this->info('3. Checking Git repository...');
        if ($gitService->isGitRepository()) {
            $this->info("   ✅ Git repository found");
            
            // Get current branch
            $branch = $gitService->getCurrentBranch();
            $this->info("   🌿 Current branch: " . ($branch ?: 'unknown'));
            
            // Get current commit
            $commit = $gitService->getCurrentCommit();
            $this->info("   📝 Current commit: " . ($commit ? substr($commit, 0, 8) : 'unknown'));
            
        } else {
            $this->warn("   ⚠️  No Git repository found");
            $this->info("   💡 You can initialize one through the admin panel");
        }

        // Test 4: Test basic Git commands
        $this->info('4. Testing basic Git commands...');
        try {
            // Test git status
            $process = \Illuminate\Support\Facades\Process::run('git status --porcelain');
            if (!$process->failed()) {
                $this->info("   ✅ Git status command works");
            } else {
                $this->warn("   ⚠️  Git status failed: " . $process->errorOutput());
            }
        } catch (\Exception $e) {
            $this->error("   ❌ Git command error: " . $e->getMessage());
        }

        // Test 5: Check write permissions
        $this->info('5. Checking write permissions...');
        $testFile = base_path('.git-test-' . time());
        try {
            file_put_contents($testFile, 'test');
            if (file_exists($testFile)) {
                unlink($testFile);
                $this->info("   ✅ Write permissions OK");
            }
        } catch (\Exception $e) {
            $this->error("   ❌ Write permission error: " . $e->getMessage());
        }

        $this->newLine();
        $this->info('🎉 Git connection test completed!');
        
        return 0;
    }
}