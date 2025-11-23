<?php
/**
 * PHP Configuration Checker
 * Checks if all required extensions are enabled for email functionality
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Configuration Check - Look Back Café</title>
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../resources/css/test-newsletter.css">
    <style>
        .status-good { color: #28a745; font-weight: bold; }
        .status-bad { color: #dc3545; font-weight: bold; }
        .status-warning { color: #ffc107; font-weight: bold; }
        .check-item {
            padding: 15px;
            margin: 10px 0;
            background: #f8f9fa;
            border-radius: 6px;
            border-left: 4px solid #e0e0e0;
        }
        .check-item.good { border-left-color: #28a745; }
        .check-item.bad { border-left-color: #dc3545; }
        .check-item.warning { border-left-color: #ffc107; }
        .check-title {
            font-weight: 600;
            margin-bottom: 5px;
        }
        .check-detail {
            font-size: 14px;
            color: #666;
        }
        .solution-box {
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 20px;
            border-radius: 6px;
            margin-top: 20px;
        }
        .solution-box h3 {
            color: #856404;
            margin-bottom: 10px;
        }
        .solution-box ol {
            margin-left: 20px;
        }
        .solution-box li {
            margin: 8px 0;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔍 PHP Configuration Check</h1>
            <p>Checking if your system is ready for email functionality</p>
        </div>
        
        <div class="content">
            <h2>Extension Status</h2>
            
            <?php
            // Check OpenSSL
            $openssl_loaded = extension_loaded('openssl');
            $openssl_class = $openssl_loaded ? 'good' : 'bad';
            ?>
            <div class="check-item <?php echo $openssl_class; ?>">
                <div class="check-title">
                    <?php if ($openssl_loaded): ?>
                        ✅ OpenSSL Extension: <span class="status-good">ENABLED</span>
                    <?php else: ?>
                        ❌ OpenSSL Extension: <span class="status-bad">DISABLED</span>
                    <?php endif; ?>
                </div>
                <div class="check-detail">
                    <?php if ($openssl_loaded): ?>
                        Version: <?php echo OPENSSL_VERSION_TEXT; ?><br>
                        Status: Ready for secure SMTP connections (TLS/SSL)
                    <?php else: ?>
                        Status: Cannot use secure SMTP connections<br>
                        <strong>Action Required:</strong> Enable OpenSSL in php.ini
                    <?php endif; ?>
                </div>
            </div>

            <?php
            // Check if PHPMailer is available
            $phpmailer_exists = file_exists(__DIR__ . '/../vendor/phpmailer/phpmailer/src/PHPMailer.php');
            $phpmailer_class = $phpmailer_exists ? 'good' : 'bad';
            ?>
            <div class="check-item <?php echo $phpmailer_class; ?>">
                <div class="check-title">
                    <?php if ($phpmailer_exists): ?>
                        ✅ PHPMailer Library: <span class="status-good">INSTALLED</span>
                    <?php else: ?>
                        ❌ PHPMailer Library: <span class="status-bad">MISSING</span>
                    <?php endif; ?>
                </div>
                <div class="check-detail">
                    <?php if ($phpmailer_exists): ?>
                        Location: vendor/phpmailer/phpmailer/<br>
                        Status: Ready to send emails
                    <?php else: ?>
                        Status: Cannot send emails<br>
                        <strong>Action Required:</strong> Install PHPMailer
                    <?php endif; ?>
                </div>
            </div>

            <?php
            // Check mail function
            $mail_function = function_exists('mail');
            $mail_class = $mail_function ? 'good' : 'warning';
            ?>
            <div class="check-item <?php echo $mail_class; ?>">
                <div class="check-title">
                    <?php if ($mail_function): ?>
                        ✅ PHP mail() Function: <span class="status-good">AVAILABLE</span>
                    <?php else: ?>
                        ⚠️ PHP mail() Function: <span class="status-warning">NOT AVAILABLE</span>
                    <?php endif; ?>
                </div>
                <div class="check-detail">
                    <?php if ($mail_function): ?>
                        Status: Can use PHP mail() as fallback<br>
                        Note: SMTP is more reliable
                    <?php else: ?>
                        Status: Must use SMTP for sending emails
                    <?php endif; ?>
                </div>
            </div>

            <h2 style="margin-top: 40px;">PHP Configuration Details</h2>
            
            <div class="config-display">
                <div class="config-item">
                    <div class="config-label">PHP Version:</div>
                    <div class="config-value"><?php echo PHP_VERSION; ?></div>
                </div>
                <div class="config-item">
                    <div class="config-label">Loaded php.ini:</div>
                    <div class="config-value"><?php echo php_ini_loaded_file(); ?></div>
                </div>
                <div class="config-item">
                    <div class="config-label">Server Software:</div>
                    <div class="config-value"><?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?></div>
                </div>
            </div>

            <?php if (!$openssl_loaded): ?>
            <div class="solution-box">
                <h3>🔧 How to Enable OpenSSL Extension</h3>
                <p><strong>For XAMPP on Windows:</strong></p>
                <ol>
                    <li>Open XAMPP Control Panel</li>
                    <li>Click "Config" button next to Apache</li>
                    <li>Select "PHP (php.ini)"</li>
                    <li>Find the line: <code>;extension=openssl</code></li>
                    <li>Remove the semicolon (;) to make it: <code>extension=openssl</code></li>
                    <li>Save the file</li>
                    <li>Stop and restart Apache in XAMPP</li>
                    <li>Refresh this page to verify</li>
                </ol>
                <p style="margin-top: 15px;"><strong>Alternative:</strong> Use PHP mail() function instead</p>
                <p>In <code>config/email.php</code>, change: <code>define('USE_SMTP', false);</code></p>
            </div>
            <?php endif; ?>

            <?php if ($openssl_loaded && $phpmailer_exists): ?>
            <div class="info-box success" style="margin-top: 30px;">
                <h3>✅ All Systems Ready!</h3>
                <p>Your PHP configuration is ready for email functionality.</p>
                <p style="margin-top: 10px;">
                    <strong>Next Steps:</strong>
                </p>
                <ul>
                    <li>Configure SMTP settings in <code>config/email.php</code></li>
                    <li>Test email sending at <a href="test_newsletter.php">test_newsletter.php</a></li>
                </ul>
            </div>
            <?php endif; ?>

            <div class="button-group">
                <a href="test_newsletter.php" class="btn btn-primary">
                    📧 Test Email Sending
                </a>
                <a href="newsletter.php" class="btn btn-secondary">
                    ← Back to Newsletter
                </a>
            </div>

            <div class="info-box" style="margin-top: 30px;">
                <h3>📚 Need More Help?</h3>
                <p>Read the detailed guide: <code>FIX_OPENSSL_ERROR.md</code></p>
                <p>Or check: <code>EMAIL_SETUP_GUIDE.md</code></p>
            </div>
        </div>
    </div>
</body>
</html>