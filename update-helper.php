<?php
/**
 * Helper Script untuk Update Manual
 * 
 * Script ini membantu mengidentifikasi file yang berubah
 * untuk memudahkan proses update manual
 */

// Konfigurasi
$projectPath = __DIR__;
$outputFile = 'update-files-list.txt';

echo "=== UPDATE HELPER SCRIPT ===\n\n";

// Fungsi untuk mendapatkan file yang berubah dari Git
function getChangedFiles($projectPath) {
    $changedFiles = [];
    
    // Get modified files
    $output = shell_exec("cd {$projectPath} && git status --porcelain");
    if ($output) {
        $lines = explode("\n", trim($output));
        foreach ($lines as $line) {
            if (preg_match('/^[AM]\s+(.+)$/', $line, $matches)) {
                $changedFiles[] = $matches[1];
            }
        }
    }
    
    return $changedFiles;
}

// Fungsi untuk mendapatkan file yang berubah dari commit tertentu
function getChangedFilesFromCommit($projectPath, $commitHash = null) {
    if (!$commitHash) {
        // Get last commit
        $lastCommit = trim(shell_exec("cd {$projectPath} && git rev-parse HEAD"));
        $commitHash = $lastCommit;
    }
    
    $output = shell_exec("cd {$projectPath} && git diff --name-only {$commitHash}^..{$commitHash}");
    if ($output) {
        return array_filter(explode("\n", trim($output)));
    }
    
    return [];
}

// Fungsi untuk categorize files
function categorizeFiles($files) {
    $categories = [
        'controllers' => [],
        'models' => [],
        'views' => [],
        'routes' => [],
        'migrations' => [],
        'config' => [],
        'assets' => [],
        'others' => []
    ];
    
    foreach ($files as $file) {
        if (strpos($file, 'app/Http/Controllers') !== false) {
            $categories['controllers'][] = $file;
        } elseif (strpos($file, 'app/Models') !== false) {
            $categories['models'][] = $file;
        } elseif (strpos($file, 'resources/views') !== false) {
            $categories['views'][] = $file;
        } elseif (strpos($file, 'routes/') !== false) {
            $categories['routes'][] = $file;
        } elseif (strpos($file, 'database/migrations') !== false) {
            $categories['migrations'][] = $file;
        } elseif (strpos($file, 'config/') !== false) {
            $categories['config'][] = $file;
        } elseif (strpos($file, 'public/') !== false || strpos($file, 'resources/') !== false) {
            $categories['assets'][] = $file;
        } else {
            $categories['others'][] = $file;
        }
    }
    
    return $categories;
}

// Main process
echo "1. Checking Git status...\n";
$changedFiles = getChangedFiles($projectPath);

if (empty($changedFiles)) {
    echo "   ✓ No uncommitted changes found\n";
    echo "\n2. Checking last commit...\n";
    $changedFiles = getChangedFilesFromCommit($projectPath);
}

if (empty($changedFiles)) {
    echo "   ✓ No changes found\n";
    exit;
}

echo "   ✓ Found " . count($changedFiles) . " changed files\n\n";

// Categorize files
echo "3. Categorizing files...\n";
$categories = categorizeFiles($changedFiles);

// Display results
echo "\n=== FILES TO UPLOAD ===\n\n";

foreach ($categories as $category => $files) {
    if (!empty($files)) {
        echo strtoupper($category) . ":\n";
        foreach ($files as $file) {
            echo "  - {$file}\n";
        }
        echo "\n";
    }
}

// Generate upload list
$uploadList = [];
foreach ($categories as $files) {
    $uploadList = array_merge($uploadList, $files);
}

// Save to file
file_put_contents($outputFile, implode("\n", $uploadList));
echo "✓ File list saved to: {$outputFile}\n\n";

// Check for database migrations
$migrations = $categories['migrations'];
if (!empty($migrations)) {
    echo "⚠️  WARNING: Database migrations detected!\n";
    echo "   You need to run these migrations manually via phpMyAdmin:\n";
    foreach ($migrations as $migration) {
        echo "   - {$migration}\n";
    }
    echo "\n";
}

// Generate FTP upload command (for reference)
echo "=== FTP UPLOAD COMMANDS (for reference) ===\n";
echo "You can use these paths in FileZilla:\n\n";
foreach ($uploadList as $file) {
    $dir = dirname($file);
    echo "mkdir -p {$dir}\n";
    echo "put {$file} {$file}\n";
}

echo "\n=== DONE ===\n";
echo "Next steps:\n";
echo "1. Review the file list above\n";
echo "2. Upload files via FTP/File Manager\n";
echo "3. Run database migrations (if any)\n";
echo "4. Test the website\n";





