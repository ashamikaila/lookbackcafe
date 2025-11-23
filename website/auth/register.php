<?php
session_start();
require_once '../config/db.php';
require_once '../config/security.php';

// Configure secure session
configure_secure_session();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = sanitize_input($_POST["name"] ?? "");
    $email = sanitize_input($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirm_password"] ?? "";
    
    // Basic validation
    if (!empty($name) && !empty($email) && !empty($password)) {
        // Validate email format
        if (!validate_email($email)) {
            $_SESSION['error_message'] = "Invalid email format. Please enter a valid email address.";
            header("Location: ../register.php");
            exit();
        }
        
        // Check password match
        if ($password !== $confirmPassword) {
            $_SESSION['error_message'] = "Passwords do not match. Please try again.";
            header("Location: ../register.php");
            exit();
        }
        
        // Validate password strength
        $password_validation = validate_password($password);
        if (!$password_validation['valid']) {
            $_SESSION['error_message'] = implode(". ", $password_validation['errors']);
            header("Location: ../register.php");
            exit();
        }
        
        // Check if email already exists
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE user_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $_SESSION['error_message'] = "Email already registered. Please use a different email or login.";
            header("Location: ../register.php");
            exit();
        }
        
        // Hash the password with bcrypt
        $hashed_password = hash_password($password);
            
            // Insert into users table (user_id auto-increments)
            $stmt = $conn->prepare("INSERT INTO users (user_name, user_email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hashed_password);
            
        if ($stmt->execute()) {
            $user_id = $conn->insert_id; // Get the auto-generated user_id
            
            // Log security event
            log_security_event('user_registration', "New user registered: $email", $user_id);
            
            // Create session
            $_SESSION["user_id"] = $user_id;
            $_SESSION["user_name"] = $name;
            $_SESSION["user_email"] = $email;
            $_SESSION["is_logged_in"] = true;
            $_SESSION["user_avatar"] = null;
            $_SESSION["role"] = "user";
            $_SESSION['last_regeneration'] = time();
            
            // Redirect to main page
            header("Location: ../main.php");
            exit();
        }
    }
}

// If something went wrong, redirect back
$_SESSION['error_message'] = "Registration failed. Please try again.";
header("Location: ../register.php");
exit();
?>