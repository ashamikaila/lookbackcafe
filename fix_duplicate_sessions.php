<?php
/**
 * Fix duplicate session_start() calls
 * Removes session_start() from files that already include security_init.php
 */

$websiteDir = __DIR__ . '/website';

function fixDuplicateSessions($filePath) {
    $content = file_get_contents($filePath);
    
    // Check if file has security_init.php
    if (strpos($content, 'security_init.php') === false) {
        return false;
    }
    
    // Check if file has session_start()
    if (strpos($content, 'session_start()') === false) {
        return false;
    }
    
    // Remove standalone session_start() lines
    $patterns = [
        "/^session_start\(\);\s*\n/m",
        "/^\s*session_start\(\);\s*\n/m",
        "/^<\?php\s+session_start\(\);\s+\?>\s*\n/m",
        "/if \(session_status\(\) === PHP_SESSION_NONE\) \{\s*\n\s*session_start\(\);\s*\n\}\s*\n/m"
    ];
    
    $newContent = $content;
    foreach ($patterns as $pattern) {
        $newContent = preg_replace($pattern, '', $newContent);
    }
    
    if ($newContent !== $content) {
        file_put_contents($filePath, $newContent);
        echo "✓ Fixed: " . basename($filePath) . "\n";
        return true;
    }
    
    return false;
}

function processDirectory($dir) {
    $files = scandir($dir);
    $fixed = 0;
    
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        
        $filePath = $dir . '/' . $file;
        
        if (is_dir($filePath)) {
            if (!in_array(basename($filePath), ['config', 'includes', 'api'])) {
                $fixed += processDirectory($filePath);
            }
        } elseif (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
            if (fixDuplicateSessions($filePath)) {
                $fixed++;
            }
        }
    }
    
    return $fixed;
}

echo "========================================\n";
echo "Fixing Duplicate session_start() Calls\n";
echo "========================================\n\n";

$fixed = processDirectory($websiteDir);

echo "\n========================================\n";
echo "Total files fixed: $fixed\n";
echo "========================================\n";
?>