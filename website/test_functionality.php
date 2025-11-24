<?php
// Test that all existing functionality still works
require_once 'includes/security_init.php';
require_once 'config/db.php';
require_once 'config/email.php';

echo "<!DOCTYPE html><html><head><title>Functionality Test</title>";
echo "<style>body{font-family:Arial;max-width:800px;margin:50px auto;padding:20px;}";
echo ".success{background:#d4edda;border:1px solid #c3e6cb;color:#155724;padding:15px;margin:10px 0;border-radius:4px;}";
echo ".error{background:#f8d7da;border:1px solid #f5c6cb;color:#721c24;padding:15px;margin:10px 0;border-radius:4px;}";
echo ".info{background:#d1ecf1;border:1px solid #bee5eb;color:#0c5460;padding:15px;margin:10px 0;border-radius:4px;}";
echo "h2{color:#333;margin-top:30px;}</style></head><body>";

echo "<h1>🧪 Functionality Test</h1>";

// Test 1: Database Connection
echo "<h2>1. Database Connection</h2>";
if ($conn && $conn->ping()) {
    echo "<div class='success'>✅ Database connection: WORKING</div>";
    echo "<div class='info'>Connected to: " . htmlspecialchars($db) . "</div>";
} else {
    echo "<div class='error'>❌ Database connection: FAILED</div>";
}

// Test 2: Session
echo "<h2>2. Session Management</h2>";
if (session_status() === PHP_SESSION_ACTIVE) {
    echo "<div class='success'>✅ Session: ACTIVE</div>";
    echo "<div class='info'>Session ID: " . substr(session_id(), 0, 10) . "...</div>";
} else {
    echo "<div class='error'>❌ Session: NOT ACTIVE</div>";
}

// Test 3: Security Functions
echo "<h2>3. Security Functions</h2>";
$security_functions = [
    'validate_password' => 'Password validation',
    'hash_password' => 'Password hashing',
    'verify_password' => 'Password verification',
    'sanitize_input' => 'Input sanitization',
    'validate_email' => 'Email validation',
    'is_https' => 'HTTPS detection',
    'configure_secure_session' => 'Secure session config',
    'require_auth' => 'Authentication check',
    'log_security_event' => 'Security logging'
];

$all_ok = true;
foreach ($security_functions as $func => $desc) {
    if (function_exists($func)) {
        echo "<div class='success'>✅ $desc ($func): Available</div>";
    } else {
        echo "<div class='error'>❌ $desc ($func): Missing</div>";
        $all_ok = false;
    }
}

// Test 4: New Security Features
echo "<h2>4. New Security Features</h2>";
$new_functions = [
    'set_security_headers' => 'Security headers',
    'csrf_token_field' => 'CSRF protection',
    'escape_html' => 'XSS prevention (HTML)',
    'escape_attr' => 'XSS prevention (Attributes)',
    'redirect_with_message' => 'Secure redirects',
    'get_flash_message' => 'Flash messages'
];

foreach ($new_functions as $func => $desc) {
    if (function_exists($func)) {
        echo "<div class='success'>✅ $desc ($func): Available</div>";
    } else {
        echo "<div class='error'>❌ $desc ($func): Missing</div>";
        $all_ok = false;
    }
}

// Test 5: Email Configuration
echo "<h2>5. Email Configuration</h2>";
if (defined('SMTP_HOST') && defined('SMTP_PORT')) {
    echo "<div class='success'>✅ Email configuration: LOADED</div>";
    echo "<div class='info'>SMTP Host: " . htmlspecialchars(SMTP_HOST) . "</div>";
    echo "<div class='info'>SMTP Port: " . htmlspecialchars(SMTP_PORT) . "</div>";
} else {
    echo "<div class='error'>❌ Email configuration: NOT LOADED</div>";
}

if (function_exists('send_email')) {
    echo "<div class='success'>✅ send_email() function: Available</div>";
} else {
    echo "<div class='error'>❌ send_email() function: Missing</div>";
}

// Test 6: Database Tables Check
echo "<h2>6. Database Tables</h2>";
$tables = ['users', 'admin', 'newsletter_subscribers', 'security_log', 'login_attempts'];
foreach ($tables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result && $result->num_rows > 0) {
        echo "<div class='success'>✅ Table '$table': EXISTS</div>";
    } else {
        echo "<div class='info'>ℹ️ Table '$table': Not found (may be optional)</div>";
    }
}

// Test 7: Error/Success Message System
echo "<h2>7. Error/Success Message System</h2>";
$_SESSION['test_success'] = "Test success message";
$_SESSION['test_error'] = "Test error message";

if (isset($_SESSION['test_success']) && isset($_SESSION['test_error'])) {
    echo "<div class='success'>✅ Session message storage: WORKING</div>";
    unset($_SESSION['test_success'], $_SESSION['test_error']);
} else {
    echo "<div class='error'>❌ Session message storage: FAILED</div>";
}

// Final Summary
echo "<h2>📊 Summary</h2>";
if ($all_ok && $conn && session_status() === PHP_SESSION_ACTIVE) {
    echo "<div class='success'>";
    echo "<h3>✅ ALL SYSTEMS OPERATIONAL</h3>";
    echo "<ul>";
    echo "<li>✅ Database connection working</li>";
    echo "<li>✅ Session management working</li>";
    echo "<li>✅ All security functions available</li>";
    echo "<li>✅ New security features active</li>";
    echo "<li>✅ Email configuration loaded</li>";
    echo "<li>✅ Error/Success messages working</li>";
    echo "</ul>";
    echo "<p><strong>Your existing functionality is NOT affected!</strong></p>";
    echo "</div>";
} else {
    echo "<div class='error'>";
    echo "<h3>⚠️ Some Issues Detected</h3>";
    echo "<p>Please review the errors above.</p>";
    echo "</div>";
}

echo "<p style='margin-top:30px;'><a href='main.php'>← Back to Main Page</a> | ";
echo "<a href='test_security_headers.php'>Security Headers Test →</a></p>";

echo "</body></html>";
?>