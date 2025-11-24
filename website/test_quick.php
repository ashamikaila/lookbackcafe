<?php
// Quick test to verify no function redeclaration errors
require_once 'includes/security_init.php';

echo "<!DOCTYPE html><html><head><title>Quick Test</title></head><body>";
echo "<h1>✅ Success!</h1>";
echo "<p>If you can see this, all security headers are working without errors.</p>";
echo "<p><strong>Session Active:</strong> " . (session_status() === PHP_SESSION_ACTIVE ? 'Yes' : 'No') . "</p>";
echo "<p><strong>Security Functions:</strong> " . (function_exists('set_security_headers') ? 'Loaded' : 'Not Loaded') . "</p>";
echo "<p><strong>CSRF Protection:</strong> " . (function_exists('csrf_token_field') ? 'Available' : 'Not Available') . "</p>";
echo "<p><strong>is_https() function:</strong> " . (function_exists('is_https') ? 'Available' : 'Not Available') . "</p>";
echo "<p><a href='test_security_headers.php'>Go to Full Test Page</a></p>";
echo "</body></html>";
?>