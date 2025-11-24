<?php
/**
 * Script to add security headers to all PHP files
 * Run this once to update all existing PHP files with security headers
 */

$websiteDir = __DIR__ . '/website';
$excludeDirs = ['config', 'includes', 'api'];
$excludeFiles = ['security_init.php', 'headers.php', 'url_helper.php', 'db.php', 'security.php'];

function addSecurityHeaders($filePath) {
    $content = file_get_contents($filePath);
    
    // Check if already has security_init
    if (strpos($content, 'security_init.php') !== false) {
        echo "✓ Skipped (already has security headers): " . basename($filePath) . "\n";
        return false;
    }
    
    // Check if file starts with <?php
    if (strpos($content, '<?php') === 0) {
        // PHP file - add after opening tag
        $pattern = '/^<\?php\s*\n/';
        $replacement = "<?php\n// Security headers - fixes OWASP ZAP alerts\nrequire_once __DIR__ . '/includes/security_init.php';\n";
        
        if (preg_match($pattern, $content)) {
            $newContent = preg_replace($pattern, $replacement, $content, 1);
            file_put_contents($filePath, $newContent);
            echo "✓ Updated: " . basename($filePath) . "\n";
            return true;
        }
    } elseif (strpos($content, '<!DOCTYPE') === 0 || strpos($content, '<html') === 0) {
        // HTML file - add PHP block at the beginning
        $newContent = "<?php\n// Security headers - fixes OWASP ZAP alerts\nrequire_once __DIR__ . '/includes/security_init.php';\n?>\n" . $content;
        file_put_contents($filePath, $newContent);
        echo "✓ Updated: " . basename($filePath) . "\n";
        return true;
    }
    
    echo "⊘ Skipped (no suitable location): " . basename($filePath) . "\n";
    return false;
}

function processDirectory($dir, $excludeDirs, $excludeFiles) {
    $files = scandir($dir);
    $updated = 0;
    
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        
        $filePath = $dir . '/' . $file;
        
        if (is_dir($filePath)) {
            $dirName = basename($filePath);
            if (!in_array($dirName, $excludeDirs)) {
                $updated += processDirectory($filePath, $excludeDirs, $excludeFiles);
            }
        } elseif (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
            if (!in_array($file, $excludeFiles)) {
                if (addSecurityHeaders($filePath)) {
                    $updated++;
                }
            }
        }
    }
    
    return $updated;
}

echo "========================================\n";
echo "Adding Security Headers to PHP Files\n";
echo "========================================\n\n";

$updated = processDirectory($websiteDir, $excludeDirs, $excludeFiles);

echo "\n========================================\n";
echo "Total files updated: $updated\n";
echo "========================================\n";
echo "\nDone! All PHP files now have security headers.\n";
echo "Please restart Apache to apply changes.\n";
?>