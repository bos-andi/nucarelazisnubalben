<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ManualUpdateService
{
    private GitService $gitService;
    private string $basePath;

    public function __construct(GitService $gitService)
    {
        $this->gitService = $gitService;
        $this->basePath = base_path();
    }

    /**
     * Get changed files from Git
     */
    public function getChangedFiles(?string $fromCommit = null): array
    {
        try {
            if (!$this->gitService->isGitRepository()) {
                return [
                    'success' => false,
                    'message' => 'Git repository not found'
                ];
            }

            if ($fromCommit) {
                // Get files changed from specific commit
                $command = "git diff --name-only {$fromCommit}^..{$fromCommit}";
            } else {
                // Get files changed from last commit
                $lastCommit = $this->gitService->getCurrentCommit();
                if (!$lastCommit) {
                    return [
                        'success' => false,
                        'message' => 'No commits found'
                    ];
                }
                $command = "git diff --name-only {$lastCommit}^..{$lastCommit}";
            }

            $result = $this->runCommand($command);
            $files = array_filter(explode("\n", trim($result['output'])));

            // Filter out files that shouldn't be included
            $files = $this->filterFiles($files);

            return [
                'success' => true,
                'files' => $files,
                'count' => count($files)
            ];
        } catch (\Exception $e) {
            Log::error('Get changed files failed: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Get all changed files (uncommitted + last commit)
     */
    public function getAllChangedFiles(): array
    {
        try {
            $allFiles = [];

            // Get uncommitted changes
            $uncommitted = $this->runCommand('git status --porcelain');
            if ($uncommitted['output']) {
                $lines = explode("\n", trim($uncommitted['output']));
                foreach ($lines as $line) {
                    if (preg_match('/^[AM]\s+(.+)$/', $line, $matches)) {
                        $allFiles[] = $matches[1];
                    }
                }
            }

            // Get last commit changes
            $lastCommit = $this->gitService->getCurrentCommit();
            if ($lastCommit) {
                $commitFiles = $this->getChangedFiles($lastCommit);
                if ($commitFiles['success']) {
                    $allFiles = array_merge($allFiles, $commitFiles['files']);
                }
            }

            // Remove duplicates
            $allFiles = array_unique($allFiles);
            $allFiles = $this->filterFiles($allFiles);

            return [
                'success' => true,
                'files' => array_values($allFiles),
                'count' => count($allFiles)
            ];
        } catch (\Exception $e) {
            Log::error('Get all changed files failed: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Generate update package (ZIP file)
     */
    public function generateUpdatePackage(?string $fromCommit = null): array
    {
        try {
            // Get changed files
            $changedFiles = $fromCommit 
                ? $this->getChangedFiles($fromCommit)
                : $this->getAllChangedFiles();

            if (!$changedFiles['success'] || empty($changedFiles['files'])) {
                return [
                    'success' => false,
                    'message' => 'No files to update'
                ];
            }

            // Create ZIP file
            $zipFileName = 'update-package-' . date('Y-m-d-His') . '.zip';
            $zipPath = storage_path('app/temp/' . $zipFileName);

            // Ensure temp directory exists
            if (!is_dir(storage_path('app/temp'))) {
                mkdir(storage_path('app/temp'), 0755, true);
            }

            $zip = new ZipArchive();
            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
                return [
                    'success' => false,
                    'message' => 'Cannot create ZIP file'
                ];
            }

            // Add files to ZIP
            $addedCount = 0;
            foreach ($changedFiles['files'] as $file) {
                $filePath = $this->basePath . '/' . $file;
                if (file_exists($filePath) && is_file($filePath)) {
                    $zip->addFile($filePath, $file);
                    $addedCount++;
                }
            }

            // Add migration SQL if any
            $migrations = $this->getMigrations($changedFiles['files']);
            if (!empty($migrations)) {
                $migrationSQL = $this->generateMigrationSQL($migrations);
                $zip->addFromString('MIGRATIONS.sql', $migrationSQL);
            }

            // Add README with instructions
            $readme = $this->generateReadme($changedFiles['files'], $migrations);
            $zip->addFromString('README.txt', $readme);

            // Add file list
            $fileList = implode("\n", $changedFiles['files']);
            $zip->addFromString('FILES_LIST.txt', $fileList);

            $zip->close();

            return [
                'success' => true,
                'filename' => $zipFileName,
                'path' => $zipPath,
                'size' => filesize($zipPath),
                'files_count' => $addedCount,
                'migrations_count' => count($migrations)
            ];
        } catch (\Exception $e) {
            Log::error('Generate update package failed: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Filter files that shouldn't be included
     */
    private function filterFiles(array $files): array
    {
        $excluded = [
            '.git',
            '.env',
            'node_modules',
            'vendor',
            'storage/logs',
            'storage/framework/cache',
            'storage/framework/sessions',
            'storage/framework/views',
            'bootstrap/cache',
            '.gitignore',
            '.gitattributes',
            'composer.lock',
            'package-lock.json',
            'yarn.lock',
            '.DS_Store',
            'Thumbs.db'
        ];

        return array_filter($files, function($file) use ($excluded) {
            foreach ($excluded as $pattern) {
                if (strpos($file, $pattern) !== false) {
                    return false;
                }
            }
            return true;
        });
    }

    /**
     * Get migration files from changed files
     */
    private function getMigrations(array $files): array
    {
        return array_filter($files, function($file) {
            return strpos($file, 'database/migrations/') !== false;
        });
    }

    /**
     * Generate SQL from migration files
     */
    private function generateMigrationSQL(array $migrations): string
    {
        $sql = "-- Migration SQL Generated on " . date('Y-m-d H:i:s') . "\n";
        $sql .= "-- IMPORTANT: Backup your database before running these queries!\n\n";

        foreach ($migrations as $migration) {
            $sql .= "-- Migration: {$migration}\n";
            $sql .= "-- Note: Please review and run the SQL manually from migration file\n";
            $sql .= "-- File location: {$migration}\n\n";
        }

        $sql .= "\n-- Instructions:\n";
        $sql .= "-- 1. Open each migration file\n";
        $sql .= "-- 2. Copy the SQL statements from the 'up()' method\n";
        $sql .= "-- 3. Run them in phpMyAdmin\n";
        $sql .= "-- 4. Or use Laravel migration if you have access to terminal\n";

        return $sql;
    }

    /**
     * Generate README file
     */
    private function generateReadme(array $files, array $migrations): string
    {
        $readme = "========================================\n";
        $readme .= "MANUAL UPDATE PACKAGE\n";
        $readme .= "Generated: " . date('Y-m-d H:i:s') . "\n";
        $readme .= "========================================\n\n";

        $readme .= "INSTRUCTIONS:\n\n";
        $readme .= "1. BACKUP FIRST!\n";
        $readme .= "   - Backup database via phpMyAdmin\n";
        $readme .= "   - Backup current files via FTP\n\n";

        $readme .= "2. UPLOAD FILES\n";
        $readme .= "   - Extract this ZIP file\n";
        $readme .= "   - Upload all files to your hosting\n";
        $readme .= "   - Replace existing files\n\n";

        if (!empty($migrations)) {
            $readme .= "3. UPDATE DATABASE\n";
            $readme .= "   - Open MIGRATIONS.sql file\n";
            $readme .= "   - Review the SQL statements\n";
            $readme .= "   - Run in phpMyAdmin\n\n";
        }

        $readme .= "4. CLEAR CACHE\n";
        $readme .= "   - Delete bootstrap/cache/* (except .gitignore)\n";
        $readme .= "   - Delete storage/framework/cache/*\n\n";

        $readme .= "5. TEST\n";
        $readme .= "   - Test all features\n";
        $readme .= "   - Check for errors\n\n";

        $readme .= "========================================\n";
        $readme .= "FILES IN THIS PACKAGE:\n";
        $readme .= "========================================\n\n";
        foreach ($files as $file) {
            $readme .= "- {$file}\n";
        }

        if (!empty($migrations)) {
            $readme .= "\n========================================\n";
            $readme .= "MIGRATIONS:\n";
            $readme .= "========================================\n\n";
            foreach ($migrations as $migration) {
                $readme .= "- {$migration}\n";
            }
        }

        return $readme;
    }

    /**
     * Run command
     */
    private function runCommand(string $command): array
    {
        $escapedPath = escapeshellarg($this->basePath);
        $fullCommand = "cd {$escapedPath} && {$command}";

        try {
            $output = shell_exec($fullCommand . ' 2>&1');
            return [
                'success' => true,
                'output' => $output ?? ''
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'output' => $e->getMessage()
            ];
        }
    }
}





