<?php
session_start();
require_once 'config/db.php';
require_once 'config/security.php';

configure_secure_session();

if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot_password.php");
    exit();
}

// Handle OTP verification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_otp'])) {
    $otp = sanitize_input($_POST['otp']);
    $email = $_SESSION['reset_email'];
    
    // Get user
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE user_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    // Check OTP
    $otp_hash = hash('sha256', $otp);
    $stmt = $conn->prepare("SELECT id FROM password_reset_otps WHERE user_id = ? AND otp_hash = ? AND expires_at > NOW() AND used = 0");
    $stmt->bind_param("is", $user['user_id'], $otp_hash);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // OTP valid - mark as used
        $otp_record = $result->fetch_assoc();
        $stmt = $conn->prepare("UPDATE password_reset_otps SET used = 1 WHERE id = ?");
        $stmt->bind_param("i", $otp_record['id']);
        $stmt->execute();
        
        $_SESSION['verified_user_id'] = $user['user_id'];
        header("Location: reset_password.php");
        exit();
    } else {
        $_SESSION['error'] = "Invalid or expired OTP";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP - Look Back Café</title>
    <link rel="stylesheet" href="../resources/css/login_as.css">
    <link rel="stylesheet" href="../resources/css/forgot-password.css">
    <link rel="icon" type="image/jpg" href="../resources/img/favicon.jpg">
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@400;500;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="background"></div>
    <div class="background-overlay"></div>
    
    <div class="login-card">
        <div class="logo">
            <img src="../resources/img/LOGIN/logo.jpg" alt="Look Back Café">
        </div>
        
        <h2 class="welcome-text">Enter OTP</h2>
        <p class="welcome-subtext">Check your email for the 6-digit code</p>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="success-message">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <input type="text" name="otp" class="form-input otp-input" placeholder="Enter 6-digit OTP" maxlength="6" pattern="[0-9]{6}" required>
            </div>
            
            <button type="submit" name="verify_otp" class="submit-button">Verify OTP</button>
        </form>
        
        <p class="back-link">
            <a href="forgot_password.php">Resend OTP</a>
        </p>
    </div>
</body>
</html>