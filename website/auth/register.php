<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"] ?? "";
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirm_password"] ?? "";
    
    // Basic validation
    if (!empty($name) && !empty($email) && !empty($password)) {
        if ($password === $confirmPassword) {
            // For now, simulate successful registration (no database insert)
            // TODO: Add database insert later
            
            // Create session
            $_SESSION["user_id"] = uniqid();
            $_SESSION["user_name"] = $name;
            $_SESSION["user_email"] = $email;
            $_SESSION["is_logged_in"] = true;
            $_SESSION["user_avatar"] = null; // No custom avatar yet
            
            // Redirect to main page
            header("Location: ../main.php");
            exit();
        }
    }
}

// If something went wrong, redirect back
header("Location: ../register.php?error=1");
exit();
?>