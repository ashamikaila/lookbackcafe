<?php
session_start();
require_once 'config/db.php';
require_once 'config/security.php';
require_once 'config/email.php';

configure_secure_session();

// Check if email is set in session
if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot_password.php");
    exit();
}

// Handle OTP verification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_otp'])) {
    $otp_digits = $_POST['otp'] ?? [];
    if (!is_array($otp_digits) || count($otp_digits) !== 4) {
        $_SESSION['error'] = "Please enter all 4 digits.";
        header("Location: verify_otp.php");
        exit();
    }

    $clean_digits = [];
    foreach ($otp_digits as $d) {
        $d = trim((string)$d);
        if ($d === '' || !ctype_digit($d) || strlen($d) !== 1) {
            $_SESSION['error'] = "Invalid OTP format.";
            header("Location: verify_otp.php");
            exit();
        }
        $clean_digits[] = $d;
    }

    $otp = implode('', $clean_digits);
    if (strlen($otp) !== 4) {
        $_SESSION['error'] = "Please enter all 4 digits.";
        header("Location: verify_otp.php");
        exit();
    }

    $email = $_SESSION['reset_email'];

    // Get user_id first
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE user_email = ? LIMIT 1");
    if (!$stmt) {
        $_SESSION['error'] = "Server error (prepare failed).";
        header("Location: verify_otp.php");
        exit();
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();
    if (!$user) {
        $_SESSION['error'] = "User not found.";
        header("Location: verify_otp.php");
        exit();
    }
    $user_id = (int)$user['user_id'];

    // Fetch the most recent OTP row for the user
    $stmt = $conn->prepare("SELECT * FROM password_reset_otps WHERE user_id = ? ORDER BY expires_at DESC, id DESC LIMIT 1");
    if (!$stmt) {
        $_SESSION['error'] = "Server error (prepare failed).";
        header("Location: verify_otp.php");
        exit();
    }
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    if (!$row) {
        $_SESSION['error'] = "No OTP found. Please request a new code.";
        header("Location: verify_otp.php");
        exit();
    }

    // Check used / expiry
    if ((int)$row['used'] === 1) {
        $_SESSION['error'] = "This OTP has already been used. Request a new one.";
        header("Location: verify_otp.php");
        exit();
    }
    $expires_ts = strtotime($row['expires_at']);
    if ($expires_ts === false || $expires_ts < time()) {
        $_SESSION['error'] = "OTP expired. Please request a new code.";
        header("Location: verify_otp.php");
        exit();
    }

    // Verify with bcrypt using password_verify
    $stored_hash = isset($row['otp_hash']) ? trim($row['otp_hash']) : '';
    if (!password_verify($otp, $stored_hash)) {
        $_SESSION['error'] = "Invalid OTP. Please check the code and try again.";
        header("Location: verify_otp.php");
        exit();
    }

    // Matched: mark this specific OTP row as used by id
    if (isset($row['id'])) {
        $upd = $conn->prepare("UPDATE password_reset_otps SET used = 1 WHERE id = ?");
        if ($upd) {
            $upd->bind_param("i", $row['id']);
            $upd->execute();
        }
    }

    // Set session for password reset and mark verified
    // Keep reset_email in session in case reset_password.php checks it
    $_SESSION['reset_user_id'] = $user_id;
    $_SESSION['otp_verified'] = true;
    $_SESSION['otp_verified_at'] = time();

    // Ensure session data is written before redirecting
    session_write_close();

    // Redirect to reset page (relative path)
    header("Location: reset_password.php");
    exit();
}

// Handle resend OTP
if (isset($_GET['resend'])) {
    $email = $_SESSION['reset_email'];

    // Get user
    $stmt = $conn->prepare("SELECT user_id, user_name FROM users WHERE user_email = ? LIMIT 1");
    if (!$stmt) {
        $_SESSION['error'] = "Server error: cannot resend OTP.";
        header("Location: verify_otp.php");
        exit();
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        $_SESSION['error'] = "User not found.";
        header("Location: verify_otp.php");
        exit();
    }

    // Generate new OTP
    $otp = sprintf("%04d", mt_rand(0, 9999));
    // Use bcrypt for storage
    $otp_hash = password_hash($otp, PASSWORD_DEFAULT);
    $expires = date('Y-m-d H:i:s', time() + 600); // 10 minutes

    // Upsert OTP for the user_id (assumes unique key on user_id)
    $stmt = $conn->prepare("
        INSERT INTO password_reset_otps (user_id, otp_hash, expires_at, used)
        VALUES (?, ?, ?, 0)
        ON DUPLICATE KEY UPDATE otp_hash = VALUES(otp_hash), expires_at = VALUES(expires_at), used = 0
    ");
    if ($stmt) {
        $stmt->bind_param("iss", $user['user_id'], $otp_hash, $expires);
        $stmt->execute();
    } else {
        $_SESSION['error'] = "Failed to generate OTP. Try again.";
        header("Location: verify_otp.php");
        exit();
    }

    // Send OTP email (plain 4-digit code sent to user)
    if (send_otp_email($email, $otp, $user['user_name'])) {
        $_SESSION['success'] = "New OTP sent to your email.";
    } else {
        $_SESSION['error'] = "Failed to send OTP. Try again.";
    }

    header("Location: verify_otp.php");
    exit();
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
    <title>Verification - Look Back Café</title>
    <link rel="stylesheet" href="../resources/css/login_as.css">
    <link rel="stylesheet" href="../resources/css/verify.css">
    <link rel="icon" type="image/jpg" href="../resources/img/favicon.jpg">
</head>
<body>
    <div class="background"></div>
    <div class="background-overlay"></div>
    
    <div class="login-card">
        <div class="logo">
            <img src="../resources/img/LOGIN/logo.jpg" alt="Look Back Café">
        </div>
        
        <h2 class="welcome-text">Verification</h2>
        <p class="welcome-subtext">We've sent the code to your <span>e-mail</span>.</p>
        
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
        
        <form method="POST" id="otpForm">
            <div class="otp-container">
                <input type="text" maxlength="1" class="otp-input" name="otp[]" required pattern="[0-9]" inputmode="numeric">
                <input type="text" maxlength="1" class="otp-input" name="otp[]" required pattern="[0-9]" inputmode="numeric">
                <input type="text" maxlength="1" class="otp-input" name="otp[]" required pattern="[0-9]" inputmode="numeric">
                <input type="text" maxlength="1" class="otp-input" name="otp[]" required pattern="[0-9]" inputmode="numeric">
            </div>
            
            <p class="resend-text">Didn't receive the code? <a href="verify_otp.php?resend=1">Resend OTP.</a></p>
            
            <button type="submit" name="verify_otp" class="submit-button">Verify</button>
        </form>
    </div>
    
    <script>
        const inputs = document.querySelectorAll('.otp-input');
        
        // Auto-focus first input on page load
        window.addEventListener('load', () => {
            inputs[0].focus();
        });
        
        inputs.forEach((input, index) => {
            // Handle input - move to next field
            input.addEventListener('input', (e) => {
                // Only allow numbers
                e.target.value = e.target.value.replace(/[^0-9]/g, '');
                
                if (e.target.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
                
                // Auto-submit when all fields are filled
                const allFilled = Array.from(inputs).every(inp => inp.value.length === 1);
                if (allFilled) {
                    // Optional: Auto-submit after a short delay
                    // setTimeout(() => document.getElementById('otpForm').submit(), 500);
                }
            });
            
            // Handle backspace - move to previous field
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    inputs[index - 1].focus();
                    inputs[index - 1].value = '';
                }
                
                // Handle left/right arrow keys
                if (e.key === 'ArrowLeft' && index > 0) {
                    e.preventDefault();
                    inputs[index - 1].focus();
                }
                if (e.key === 'ArrowRight' && index < inputs.length - 1) {
                    e.preventDefault();
                    inputs[index + 1].focus();
                }
            });
            
            // Handle paste - distribute across all fields
            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pastedData = e.clipboardData.getData('text').replace(/[^0-9]/g, '');
                
                for (let i = 0; i < Math.min(pastedData.length, inputs.length); i++) {
                    inputs[i].value = pastedData[i];
                }
                
                // Focus the next empty field or the last field
                const nextEmpty = Array.from(inputs).findIndex(inp => !inp.value);
                if (nextEmpty !== -1) {
                    inputs[nextEmpty].focus();
                } else {
                    inputs[inputs.length - 1].focus();
                }
            });
            
            // Prevent non-numeric input
            input.addEventListener('keypress', (e) => {
                if (!/[0-9]/.test(e.key)) {
                    e.preventDefault();
                }
            });
        });
        
        // Form validation before submit
        document.getElementById('otpForm').addEventListener('submit', (e) => {
            const allFilled = Array.from(inputs).every(inp => inp.value.length === 1);
            if (!allFilled) {
                e.preventDefault();
                alert('Please enter all 4 digits');
                inputs[0].focus();
            }
        });
    </script>
</body>
</html>