<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";
    
    // For now, simulate successful login (no database check)
    // TODO: Add database verification later
    
    if (!empty($email) && !empty($password)) {
        // Extract name from email (before @) or use username
        $userName = strstr($email, '@', true) ?: $email;
        
        // Create session
        $_SESSION["user_id"] = uniqid();
        $_SESSION["user_name"] = $userName;
        $_SESSION["user_email"] = $email;
        $_SESSION["is_logged_in"] = true;
        $_SESSION["user_avatar"] = null; // No custom avatar yet
        
        // Redirect to main page
        header("Location: ../main.php");
        exit();
    }
}

// If something went wrong, redirect back
header("Location: ../as_user.php?error=1");
exit();
?>