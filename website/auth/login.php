<?php
session_start();
require_once '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";
    $role = $_POST["role"] ?? "user";
    
    if ($role === "admin") {
        // Check admin table
        $stmt = $conn->prepare("SELECT admin_id, user_name, user_email, password, user_avatar FROM admin WHERE user_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            
            // Verify password with bcrypt
            if (password_verify($password, $admin['password'])) {
                // Password correct - create session
                $_SESSION["user_id"] = $admin['admin_id'];
                $_SESSION["user_name"] = $admin['user_name'];
                $_SESSION["user_email"] = $admin['user_email'];
                $_SESSION["is_logged_in"] = true;
                $_SESSION["user_avatar"] = $admin['user_avatar'];
                $_SESSION["role"] = "admin";
                
                header("Location: ../main.php");
                exit();
            }
        }
        
        // Admin login failed
        header("Location: ../as_admin.php?error=1");
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
            if (password_verify($password, $user['password'])) {
                // Password correct - create session
                $_SESSION["user_id"] = $user['user_id'];
                $_SESSION["user_name"] = $user['user_name'];
                $_SESSION["user_email"] = $user['user_email'];
                $_SESSION["is_logged_in"] = true;
                $_SESSION["user_avatar"] = $user['user_avatar'];
                $_SESSION["role"] = "user";
                
                header("Location: ../main.php");
                exit();
            }
        }
        
        // User login failed
        header("Location: ../as_user.php?error=1");
        exit();
    }
}

// If not POST request, redirect back
header("Location: ../login_as.php");
exit();
?>