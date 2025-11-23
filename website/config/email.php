<?php
/**
 * Simple Email Configuration - No SSL Required
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/phpmailer/phpmailer/src/Exception.php';
require __DIR__ . '/../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require __DIR__ . '/../../vendor/phpmailer/phpmailer/src/SMTP.php';

// SMTP Configuration
define('SMTP_HOST', 'smtp-relay.brevo.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'lookbackcafe.dev1@gmail.com');
define('SMTP_PASSWORD', 'xsmtpsib-e6f4090dfca74e1d51c71de90d9ca0548f3f7dae397229c9cc92bfb84377ca64-0ihixZZDILHI5S50');
define('SMTP_FROM_EMAIL', 'lookbackcafe.dev1@gmail.com');
define('SMTP_FROM_NAME', 'Look Back Café');

/**
 * Send email - Simple version
 */
function send_email($to, $subject, $message) {
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME;
        $mail->Password = SMTP_PASSWORD;
        $mail->Port = SMTP_PORT;
        
        // Disable SSL/TLS if OpenSSL not available
        if (!extension_loaded('openssl')) {
            $mail->SMTPSecure = false;
            $mail->SMTPAutoTLS = false;
        } else {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        }
        
        // Recipients
        $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
        $mail->addAddress($to);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        
        $mail->send();
        return true;
        
    } catch (Exception $e) {
        error_log("Email error: {$mail->ErrorInfo}");
        return false;
    }
}

/**
 * Send OTP email
 */
function send_otp_email($email, $otp, $name) {
    $subject = "Password Reset OTP - Look Back Café";
    $message = "
    <h2>Password Reset Request</h2>
    <p>Hello $name,</p>
    <p>Your OTP code is: <strong>$otp</strong></p>
    <p>This code expires in 10 minutes.</p>
    <p>If you didn't request this, ignore this email.</p>
    ";
    
    return send_email($email, $subject, $message);
}

/**
 * Send newsletter to one subscriber
 */
function send_newsletter_email($email, $subject, $content) {
    $message = "
    <h1>Look Back Café Newsletter</h1>
    $content
    <hr>
    <p style='font-size: 12px; color: #666;'>Look Back Café</p>
    ";
    
    return send_email($email, $subject, $message);
}

/**
 * Send newsletter to all subscribers from database
 */
function send_bulk_newsletter($subject, $content) {
    global $conn;
    
    $sent = 0;
    $failed = 0;
    
    // Get all active subscribers from database
    $result = $conn->query("SELECT email FROM newsletter_subscribers WHERE is_active = 1");
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            if (send_newsletter_email($row['email'], $subject, $content)) {
                $sent++;
            } else {
                $failed++;
            }
            
            // Small delay
            usleep(100000);
        }
    }
    
    return ['sent' => $sent, 'failed' => $failed];
}
?>