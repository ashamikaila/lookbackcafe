<?php
session_start();
require_once 'config/db.php';
require_once 'config/security.php';

configure_secure_session();

if (!isset($_SESSION['verified_user_id'])) {
    header("Location: forgot_password.php");
    exit();
}

// Handle password reset
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $user_id = $_SESSION['verified_user_id'];
    
    if ($new_password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match";
        header("Location: reset_password.php");
        exit();
    }
    
    // Validate password
    $validation = validate_password($new_password);
    if (!$validation['valid']) {
        $_SESSION['error'] = implode(". ", $validation['errors']);
        header("Location: reset_password.php");
        exit();
    }
    
    // Update password
    $hashed = hash_password($new_password);
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
    $stmt->bind_param("si", $hashed, $user_id);
    
    if ($stmt->execute()) {
        log_security_event('password_reset', "Password reset via OTP", $user_id);
        
        // Clear session
        unset($_SESSION['reset_email']);
        unset($_SESSION['verified_user_id']);
        
        $_SESSION['success'] = "Password reset successful! Please login.";
        header("Location: as_user.php");
    } else {
        $_SESSION['error'] = "Failed to reset password";
        header("Location: reset_password.php");
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Look Back Café</title>
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
        
        <h2 class="welcome-text">Reset Password</h2>
        <p class="welcome-subtext">Enter your new password</p>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message" style="font-size: 13px;">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <input type="password" name="new_password" class="form-input" placeholder="New Password (12+ chars)" required>
            </div>
            
            <div class="form-group">
                <input type="password" name="confirm_password" class="form-input" placeholder="Confirm Password" required>
            </div>
            
            <div class="password-requirements">
                <strong>Password must have:</strong>
                • 12+ characters<br>
                • Uppercase & lowercase<br>
                • Number & special character
            </div>
            
            <button type="submit" name="reset_password" class="submit-button">Reset Password</button>
        </form>
    </div>
</body>
</html>