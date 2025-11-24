<?php
// Security headers - fixes OWASP ZAP alerts
require_once __DIR__ . '/includes/security_init.php';
/**
 * Test Email Setup
 * Verify PHPMailer and email configuration
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html>
<html>
<head>
    <title>Email Setup Test</title>
    <style>
        body { font-family: Arial; max-width: 800px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #8B4513; border-bottom: 3px solid #8B4513; padding-bottom: 10px; }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 15px 0; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 15px 0; }
        .info { background: #e3f2fd; color: #014361; padding: 15px; border-radius: 5px; margin: 15px 0; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; }
        .button { display: inline-block; background: #8B4513; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-top: 15px; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>📧 Email Setup Test</h1>";

// Check 1: PHPMailer files
echo "<h3>1. PHPMailer Installation</h3>";
$phpmailer_path = __DIR__ . '/../vendor/phpmailer/phpmailer/src/PHPMailer.php';
if (file_exists($phpmailer_path)) {
    echo "<div class='success'>✅ PHPMailer is installed correctly</div>";
} else {
    echo "<div class='error'>❌ PHPMailer not found at: $phpmailer_path</div>";
    echo "</div></body></html>";
    exit;
}

// Check 2: Load email config
echo "<h3>2. Email Configuration</h3>";
try {
    require_once __DIR__ . '/config/email.php';
    echo "<div class='success'>✅ Email configuration loaded</div>";
    echo "<div class='info'>";
    echo "<strong>SMTP Host:</strong> " . SMTP_HOST . "<br>";
    echo "<strong>SMTP Port:</strong> " . SMTP_PORT . "<br>";
    echo "<strong>From Email:</strong> " . SMTP_FROM_EMAIL . "<br>";
    echo "<strong>From Name:</strong> " . SMTP_FROM_NAME;
    echo "</div>";
} catch (Exception $e) {
    echo "<div class='error'>❌ Error loading config: " . $e->getMessage() . "</div>";
    echo "</div></body></html>";
    exit;
}

// Check 3: OpenSSL (required for SMTP with TLS)
echo "<h3>3. OpenSSL Extension</h3>";
if (extension_loaded('openssl')) {
    echo "<div class='success'>✅ OpenSSL is loaded</div>";
} else {
    echo "<div class='error'>❌ OpenSSL is NOT loaded - SMTP with TLS will not work</div>";
}

// Check 4: Test email sending
echo "<h3>4. Send Test Email</h3>";
echo "<div class='info'>";
echo "<p>Enter your email to receive a test message:</p>";
echo "<form method='post'>";
echo "<input type='email' name='test_email' placeholder='your@email.com' required style='padding: 10px; width: 300px; border: 1px solid #ddd; border-radius: 5px;'>";
echo "<button type='submit' name='send_test' class='button'>Send Test Email</button>";
echo "</form>";
echo "</div>";

if (isset($_POST['send_test']) && !empty($_POST['test_email'])) {
    $test_email = filter_var($_POST['test_email'], FILTER_VALIDATE_EMAIL);
    
    if ($test_email) {
        echo "<div class='info'><p>Sending test email to: <strong>$test_email</strong></p></div>";
        
        $subject = "Test Email - Look Back Café";
        $message = "
        <!DOCTYPE html>
        <html>
        <body style='font-family: Arial; padding: 20px;'>
            <h2 style='color: #8B4513;'>✅ Email System Working!</h2>
            <p>If you're reading this, your email system is configured correctly.</p>
            <p><strong>Test Time:</strong> " . date('Y-m-d H:i:s') . "</p>
            <p><strong>Server:</strong> " . php_sapi_name() . "</p>
            <hr>
            <p style='color: #666; font-size: 12px;'>Look Back Café Email System</p>
        </body>
        </html>
        ";
        
        if (send_email($test_email, $subject, $message)) {
            echo "<div class='success'>";
            echo "<h3>✅ Success!</h3>";
            echo "<p>Test email sent successfully to: <strong>$test_email</strong></p>";
            echo "<p>Check your inbox (and spam folder).</p>";
            echo "</div>";
        } else {
            echo "<div class='error'>";
            echo "<h3>❌ Failed</h3>";
            echo "<p>Could not send email. Check the error logs.</p>";
            echo "</div>";
        }
    } else {
        echo "<div class='error'>Invalid email address</div>";
    }
}

echo "
        <hr>
        <h3>✅ Setup Complete!</h3>
        <p>If all checks passed and test email works, your email system is ready.</p>
        <p><strong>Next steps:</strong></p>
        <ul>
            <li>Test password reset functionality</li>
            <li>Test newsletter sending</li>
            <li>Delete this test file when done</li>
        </ul>
    </div>
</body>
</html>";
?>