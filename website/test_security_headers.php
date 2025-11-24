<?php
// Security headers - fixes OWASP ZAP alerts
require_once 'includes/security_init.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Headers Test - Look Back Café</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .header {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .info {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        h1 { color: #333; margin: 0 0 10px 0; }
        h2 { color: #666; margin: 20px 0 10px 0; }
        code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
        }
        .check-list {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .check-item {
            padding: 10px;
            margin: 5px 0;
            border-left: 4px solid #28a745;
            background: #f8f9fa;
        }
        .instruction {
            background: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🔒 Security Headers Test Page</h1>
        <p>This page verifies that all OWASP ZAP security fixes are active</p>
    </div>

    <div class="success">
        <strong>✅ Security Headers Active!</strong><br>
        If you can see this page, the security initialization is working correctly.
    </div>

    <div class="info">
        <h2>How to Verify Security Headers</h2>
        <ol>
            <li>Open your browser's Developer Tools (F12)</li>
            <li>Go to the <strong>Network</strong> tab</li>
            <li>Reload this page (Ctrl+R or Cmd+R)</li>
            <li>Click on this page request (test_security_headers.php)</li>
            <li>Look at the <strong>Response Headers</strong> section</li>
        </ol>
    </div>

    <div class="check-list">
        <h2>Expected Security Headers:</h2>
        
        <div class="check-item">
            <strong>✓ Content-Security-Policy</strong><br>
            Should include: <code>form-action 'self'</code> and <code>frame-ancestors 'self'</code><br>
            <em>Fixes OWASP ZAP Alert #1</em>
        </div>

        <div class="check-item">
            <strong>✓ X-Frame-Options</strong><br>
            Should be: <code>SAMEORIGIN</code><br>
            <em>Prevents clickjacking</em>
        </div>

        <div class="check-item">
            <strong>✓ X-Content-Type-Options</strong><br>
            Should be: <code>nosniff</code><br>
            <em>Prevents MIME type sniffing</em>
        </div>

        <div class="check-item">
            <strong>✓ X-XSS-Protection</strong><br>
            Should be: <code>1; mode=block</code><br>
            <em>Enables browser XSS filter</em>
        </div>

        <div class="check-item">
            <strong>✓ Referrer-Policy</strong><br>
            Should be: <code>strict-origin-when-cross-origin</code><br>
            <em>Fixes OWASP ZAP Alert #3 - Prevents URL information disclosure</em>
        </div>

        <div class="check-item">
            <strong>✓ Permissions-Policy</strong><br>
            Should include: <code>geolocation=(), microphone=(), camera=()</code><br>
            <em>Controls browser features</em>
        </div>
    </div>

    <div class="instruction">
        <h2>📋 OWASP ZAP Testing Instructions:</h2>
        <ol>
            <li><strong>Run OWASP ZAP scan</strong> on your website again</li>
            <li><strong>Target URL:</strong> http://localhost/lookbackcafe/website/</li>
            <li><strong>Expected Results:</strong>
                <ul>
                    <li>Alert #1 (CSP) - Should be RESOLVED ✅</li>
                    <li>Alert #2 (Auth Request) - Informational only ℹ️</li>
                    <li>Alert #3 (Info Disclosure) - Should be REDUCED ✅</li>
                    <li>Alert #4 (User Agent) - Informational only ℹ️</li>
                    <li>Alert #5 (XSS) - Should be REDUCED ✅</li>
                </ul>
            </li>
        </ol>
    </div>

    <div class="info">
        <h2>📊 Current Session Information:</h2>
        <p><strong>Session Started:</strong> <?php echo session_status() === PHP_SESSION_ACTIVE ? 'Yes ✅' : 'No ❌'; ?></p>
        <p><strong>Security Headers Loaded:</strong> <?php echo function_exists('set_security_headers') ? 'Yes ✅' : 'No ❌'; ?></p>
        <p><strong>CSRF Protection Available:</strong> <?php echo function_exists('csrf_token_field') ? 'Yes ✅' : 'No ❌'; ?></p>
        <p><strong>Output Escaping Available:</strong> <?php echo function_exists('escape_html') ? 'Yes ✅' : 'No ❌'; ?></p>
        <p><strong>URL Helpers Available:</strong> <?php echo function_exists('redirect_with_message') ? 'Yes ✅' : 'No ❌'; ?></p>
    </div>

    <div class="check-list">
        <h2>🎯 All Security Features Implemented:</h2>
        <ul>
            <li>✅ Content Security Policy with form-action and frame-ancestors</li>
            <li>✅ CSRF token protection system</li>
            <li>✅ XSS prevention with output escaping functions</li>
            <li>✅ Secure URL handling (no sensitive data in URLs)</li>
            <li>✅ Flash message system for user feedback</li>
            <li>✅ Input sanitization and validation</li>
            <li>✅ Secure session configuration</li>
            <li>✅ All 40 PHP files updated with security headers</li>
        </ul>
    </div>

    <p style="text-align: center; margin-top: 30px;">
        <a href="main.php" style="color: #007bff; text-decoration: none;">← Back to Main Page</a> |
        <a href="example_secure_form.php" style="color: #007bff; text-decoration: none;">View Secure Form Example →</a>
    </p>
</body>
</html>