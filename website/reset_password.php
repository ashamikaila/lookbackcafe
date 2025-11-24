<?php
session_start();
require_once 'config/db.php';
require_once 'config/security.php';
require_once 'config/email.php';

configure_secure_session(); 

// check OTP verified
if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
    header("Location: forgot_password.php");
    exit();
}

// Handle password reset
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $user_id = $_SESSION['reset_user_id'];

    if ($new_password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match";
        header("Location: reset_password.php");
        exit();
    }

    // optional: validate password (length, complexity)
    if (strlen($new_password) < 12) {
        $_SESSION['error'] = "Password must be at least 12 characters long";
        header("Location: reset_password.php");
        exit();
    }

    $hashed = password_hash($new_password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
    $stmt->bind_param("si", $hashed, $user_id);

    if ($stmt->execute()) {
        // log security event if you have function
        if (function_exists('log_security_event')) {
            log_security_event('password_reset', "Password reset via OTP", $user_id);
        }

        // clear session
        unset($_SESSION['reset_email']);
        unset($_SESSION['reset_user_id']);
        unset($_SESSION['otp_verified']);
        unset($_SESSION['otp_verified_at']);

        $_SESSION['success'] = "Password reset successful! Please login.";
        header("Location: as_user.php"); // redirect to login
        exit();
    } else {
        $_SESSION['error'] = "Failed to reset password";
        header("Location: reset_password.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Red+Hat+Display:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <title>Create New Password - Look Back Café</title>
    <link rel="stylesheet" href="../resources/css/login_as.css">
    <link rel="stylesheet" href="../resources/css/create_new_pass.css">
    <link rel="icon" type="image/jpg" href="../resources/img/favicon.jpg">
</head>
<body>
    <div class="background"></div>
    <div class="background-overlay"></div>
    
    <div class="login-card">
        <div class="logo">
            <img src="../resources/img/LOGIN/logo.jpg" alt="Look Back Café">
        </div>
        
        <h2 class="welcome-text">Create New Password</h2>
        <p class="welcome-subtext">Your new password must be different from previous password.</p>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message" style="font-size: 13px;">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <input type="password" name="new_password" class="form-input" placeholder="New Password" required>
            </div>
            
            <div class="form-group">
                <input type="password" name="confirm_password" class="form-input" placeholder="Confirm Password" required>
            </div>
            
            <button type="submit" name="reset_password" class="submit-button">Create</button>
        </form>
    </div>
</body>
</html>
