<?php
// Security headers - fixes OWASP ZAP alerts
require_once __DIR__ . '/../includes/security_init.php';
require_once '../config/db.php';
require_once '../config/security.php';

// Configure secure session
configure_secure_session();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = sanitize_input($_POST["email"] ?? $_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";
    $role = $_POST["role"] ?? "user";
    
    // Check rate limiting
    if (check_rate_limit($email)) {
        log_security_event('rate_limit_exceeded', "Too many login attempts for: $email", null);
        $_SESSION['error_message'] = "Too many login attempts. Please try again later.";
        header("Location: ../" . ($role === "admin" ? "as_admin.php" : "as_user.php"));
        exit();
    }
    
    if ($role === "admin") {
        // Check admin table
        $stmt = $conn->prepare("SELECT admin_id, user_name, user_email, password, user_avatar FROM admin WHERE user_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            
            // Verify password with bcrypt
            if (verify_password($password, $admin['password'])) {
                // Password correct - record successful attempt
                record_login_attempt($email, true);
                log_security_event('admin_login_success', "Admin logged in: $email", $admin['admin_id']);
                
                // Create session
                $_SESSION["user_id"] = $admin['admin_id'];
                $_SESSION["user_name"] = $admin['user_name'];
                $_SESSION["user_email"] = $admin['user_email'];
                $_SESSION["is_logged_in"] = true;
                $_SESSION["user_avatar"] = $admin['user_avatar'];
                $_SESSION["role"] = "admin";
                $_SESSION['last_regeneration'] = time();
                
                header("Location: ../admindash.php");
                exit();
            }
        }
        
        // Admin login failed - record attempt
        record_login_attempt($email, false);
        log_security_event('admin_login_failed', "Failed admin login attempt: $email", null);
        $_SESSION['error_message'] = "Incorrect username or password. Please try again.";
        header("Location: ../as_admin.php");
        exit();
        
    } else {
        // Check users table
        $stmt = $conn->prepare("SELECT user_id, user_name, user_email, password, user_avatar FROM users WHERE user_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify password with bcrypt
            if (verify_password($password, $user['password'])) {
                // Password correct - record successful attempt
                record_login_attempt($email, true);
                log_security_event('user_login_success', "User logged in: $email", $user['user_id']);
                
                // Create session
                $_SESSION["user_id"] = $user['user_id'];
                $_SESSION["user_name"] = $user['user_name'];
                $_SESSION["user_email"] = $user['user_email'];
                $_SESSION["is_logged_in"] = true;
                $_SESSION["user_avatar"] = $user['user_avatar'];
                $_SESSION["role"] = "user";
                $_SESSION['last_regeneration'] = time();
                
                header("Location: ../main.php");
                exit();
            }
        }
        
        // User login failed - record attempt
        record_login_attempt($email, false);
        log_security_event('user_login_failed', "Failed user login attempt: $email", null);
        $_SESSION['error_message'] = "Incorrect email or password. Please try again.";
        header("Location: ../as_user.php");
        exit();
    }
}

// If not POST request, redirect back
header("Location: ../login_as.php");
exit();
?>