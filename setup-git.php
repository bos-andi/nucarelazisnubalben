<?php
/**
 * Git Setup Script for Lazisnu Website
 * 
 * This script helps initialize Git repository for the website
 * Run this script once to setup Git for automatic updates
 */

echo "🚀 Lazisnu Website - Git Setup Script\n";
echo "=====================================\n\n";

// Check if Git is installed
echo "1. Checking Git installation...\n";
$gitVersion = shell_exec('git --version 2>&1');
if (strpos($gitVersion, 'git version') !== false) {
    echo "   ✅ Git installed: " . trim($gitVersion) . "\n";
} else {
    echo "   ❌ Git not found! Please install Git first.\n";
    echo "   💡 Download from: https://git-scm.com/downloads\n";
    exit(1);
}

// Check current directory
$currentDir = __DIR__;
echo "\n2. Current directory: {$currentDir}\n";

// Check if already a Git repository
if (is_dir($currentDir . '/.git')) {
    echo "   ✅ Git repository already exists\n";
    
    // Show current status
    $branch = trim(shell_exec('git branch --show-current 2>/dev/null') ?: 'unknown');
    $commit = trim(shell_exec('git rev-parse HEAD 2>/dev/null') ?: 'unknown');
    
    echo "   🌿 Current branch: {$branch}\n";
    echo "   📝 Current commit: " . substr($commit, 0, 8) . "\n";
    
    // Check for remote
    $remote = trim(shell_exec('git remote get-url origin 2>/dev/null') ?: '');
    if ($remote) {
        echo "   🔗 Remote URL: {$remote}\n";
    } else {
        echo "   ⚠️  No remote repository configured\n";
    }
    
} else {
    echo "   ⚠️  No Git repository found\n";
    echo "\n3. Would you like to initialize Git repository? (y/n): ";
    
    $handle = fopen("php://stdin", "r");
    $input = trim(fgets($handle));
    fclose($handle);
    
    if (strtolower($input) === 'y' || strtolower($input) === 'yes') {
        echo "\n   Initializing Git repository...\n";
        
        // Initialize Git
        shell_exec('git init');
        echo "   ✅ Git repository initialized\n";
        
        // Create .gitignore if not exists
        if (!file_exists('.gitignore')) {
            $gitignore = "/node_modules
/public/hot
/public/storage
/storage/*.key
/vendor
.env
.env.backup
.phpunit.result.cache
docker-compose.override.yml
Homestead.json
Homestead.yaml
npm-debug.log
yarn-error.log
/.idea
/.vscode
";
            file_put_contents('.gitignore', $gitignore);
            echo "   ✅ .gitignore created\n";
        }
        
        // Add files
        shell_exec('git add .');
        shell_exec('git commit -m "Initial commit - Lazisnu website"');
        echo "   ✅ Initial commit created\n";
        
        echo "\n   📋 Next steps:\n";
        echo "   1. Create a repository on GitHub/GitLab\n";
        echo "   2. Add remote: git remote add origin <repository-url>\n";
        echo "   3. Push code: git push -u origin main\n";
        echo "   4. Configure in admin panel\n";
    }
}

echo "\n4. Testing Git commands...\n";

// Test git status
$status = shell_exec('git status --porcelain 2>&1');
if ($status !== null) {
    echo "   ✅ Git status command works\n";
} else {
    echo "   ❌ Git status command failed\n";
}

// Check write permissions
echo "\n5. Checking permissions...\n";
$testFile = $currentDir . '/.git-test-' . time();
try {
    file_put_contents($testFile, 'test');
    if (file_exists($testFile)) {
        unlink($testFile);
        echo "   ✅ Write permissions OK\n";
    }
} catch (Exception $e) {
    echo "   ❌ Write permission error: " . $e->getMessage() . "\n";
}

echo "\n🎉 Git setup completed!\n";
echo "\n📋 Summary:\n";
echo "   • Git is properly installed and configured\n";
echo "   • You can now use the System Updates panel in admin\n";
echo "   • Make sure to setup remote repository for automatic updates\n";
echo "\n💡 Admin Panel: /dashboard/system-updates\n";
?>
