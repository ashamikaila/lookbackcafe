<?php
// Security headers - fixes OWASP ZAP alerts
require_once __DIR__ . '/includes/security_init.php';
require_once 'config/db.php';
require_once 'config/security.php';
require_once 'config/email.php';

configure_secure_session();

// Handle OTP generation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_otp'])) {
    $email = sanitize_input($_POST['email']);
    
    if (!validate_email($email)) {
        $_SESSION['error'] = "Invalid email address.";
        header("Location: forgot_password.php");
        exit();
    }
    
    // Check if user exists
    $stmt = $conn->prepare("SELECT user_id, user_name FROM users WHERE user_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        $_SESSION['error'] = "Email not found.";
        header("Location: forgot_password.php");
        exit();
    }
    
    $user = $result->fetch_assoc();
    
    // Generate 4-digit OTP
    $otp = sprintf("%04d", mt_rand(0, 9999));
    $otp_hash = hash('sha256', $otp);
    $expires = date('Y-m-d H:i:s', time() + 600); // 10 minutes
    
    // Store OTP
    $stmt = $conn->prepare("
        INSERT INTO password_reset_otps (user_id, otp_hash, expires_at)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE otp_hash = ?, expires_at = ?, used = 0
    ");
    $stmt->bind_param("issss", $user['user_id'], $otp_hash, $expires, $otp_hash, $expires);
    $stmt->execute();
    
    // Send OTP email
    if (send_otp_email($email, $otp, $user['user_name'])) {
        $_SESSION['reset_email'] = $email;
        $_SESSION['success'] = "OTP sent to your email.";
        header("Location: verify_otp.php");
        exit();
    } else {
        $_SESSION['error'] = "Failed to send OTP. Try again.";
        header("Location: forgot_password.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Look Back Café</title>

    <link rel="stylesheet" href="../resources/css/login_as.css">
    <link rel="stylesheet" href="../resources/css/forgot_pass.css">
    <link rel="icon" type="image/jpg" href="../resources/img/favicon.jpg">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100..900&family=Montserrat:wght@100..900&family=Red+Hat+Display:wght@300..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="background"></div>
    <div class="background-overlay"></div>
    
    <div class="login-card">
        <div class="logo">
            <img src="../resources/img/LOGIN/logo.jpg" alt="Look Back Café">
        </div>

        <h2 class="welcome-text">Forgot Password?</h2>
        <p class="welcome-subtext">Enter your <span>e-mail</span> to reset your <span>account</span>.</p>

        <!-- Show error message -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <!-- Show success message -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="success-message">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <input type="email" name="email" class="form-input" placeholder="user@gmail.com" required>
            </div>

            <button type="submit" name="send_otp" class="submit-button">Send OTP</button>
        </form>

        <p class="back-link">
            <a href="login_as.php">Back to Login</a>
        </p>
    </div>
</body>
</html>
