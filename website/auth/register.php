<?php
session_start();
require_once '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"] ?? "";
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirm_password"] ?? "";
    
    // Basic validation
    if (!empty($name) && !empty($email) && !empty($password)) {
        if ($password === $confirmPassword) {
            // Check if email already exists
            $stmt = $conn->prepare("SELECT user_id FROM users WHERE user_email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                header("Location: ../register.php?error=email_exists");
                exit();
            }
            
            // Hash the password with bcrypt
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            
            // Insert into users table (user_id auto-increments)
            $stmt = $conn->prepare("INSERT INTO users (user_name, user_email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hashed_password);
            
            if ($stmt->execute()) {
                $user_id = $conn->insert_id; // Get the auto-generated user_id
                
                // Create session
                $_SESSION["user_id"] = $user_id;
                $_SESSION["user_name"] = $name;
                $_SESSION["user_email"] = $email;
                $_SESSION["is_logged_in"] = true;
                $_SESSION["user_avatar"] = null;
                $_SESSION["role"] = "user";
                
                // Redirect to main page
                header("Location: ../main.php");
                exit();
            }
        }
    }
}

// If something went wrong, redirect back
header("Location: ../register.php?error=1");
exit();
?>