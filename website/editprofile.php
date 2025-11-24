<?php
session_start();
require_once 'config/db.php';
require_once 'config/security.php';

// Configure secure session
configure_secure_session();

// Check if user is logged in
require_auth();

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Determine which table to use
$table = ($role === 'admin') ? 'admin' : 'users';
$id_column = ($role === 'admin') ? 'admin_id' : 'user_id';

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    
    // Check if email is already taken by another user
    $stmt = $conn->prepare("SELECT $id_column FROM $table WHERE user_email = ? AND $id_column != ?");
    $stmt->bind_param("si", $email, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $_SESSION['error_message'] = "Email is already taken by another user.";
    } else {
        // Update profile
        $stmt = $conn->prepare("UPDATE $table SET user_name = ?, user_email = ? WHERE $id_column = ?");
        $stmt->bind_param("ssi", $name, $email, $user_id);
        
        if ($stmt->execute()) {
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
            $_SESSION['success_message'] = "Profile updated successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to update profile. Please try again.";
        }
    }
    
    header("Location: editprofile.php");
    exit();
}

// Handle password change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate passwords match
    if ($new_password !== $confirm_password) {
        $_SESSION['error_message'] = "New passwords do not match!";
        header("Location: editprofile.php");
        exit();
    }
    
    // Validate password strength
    $password_validation = validate_password($new_password);
    if (!$password_validation['valid']) {
        $_SESSION['error_message'] = implode(". ", $password_validation['errors']);
        header("Location: editprofile.php");
        exit();
    }
    
    // Verify old password
    $stmt = $conn->prepare("SELECT password FROM $table WHERE $id_column = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    if (verify_password($old_password, $user['password'])) {
        // Update password
        $hashed_password = hash_password($new_password);
        $stmt = $conn->prepare("UPDATE $table SET password = ? WHERE $id_column = ?");
        $stmt->bind_param("si", $hashed_password, $user_id);
        
        if ($stmt->execute()) {
            log_security_event('password_changed', "Password changed for user ID: $user_id", $user_id);
            $_SESSION['success_message'] = "Password changed successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to change password. Please try again.";
        }
    } else {
        log_security_event('password_change_failed', "Failed password change attempt for user ID: $user_id", $user_id);
        $_SESSION['error_message'] = "Old password is incorrect!";
    }
    
    header("Location: editprofile.php");
    exit();
}

// Handle account deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_account'])) {
    // Only users can delete their accounts, not admins
    if ($role === 'user') {
        $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            // Destroy session and redirect
            session_unset();
            session_destroy();
            // Use absolute path for redirect to avoid issues
            header("Location: main.php?account_deleted=1");
            exit();
        } else {
            $_SESSION['error_message'] = "Failed to delete account. Please try again.";
            header("Location: editprofile.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Admin accounts cannot be deleted from this page.";
        header("Location: editprofile.php");
        exit();
    }
}

// Get current user data
$stmt = $conn->prepare("SELECT user_name, user_email, user_avatar FROM $table WHERE $id_column = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Look Back Café</title>
    <link rel="stylesheet" href="../resources/css/editprofile.css">
    <link rel="icon" type="image/jpg" href="../resources/img/favicon.jpg">
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@400;500;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <img src="../resources/img/LOGIN/loginbg.png" alt="Background" class="background-image">
    <div class="background-overlay"></div>

    <div class="profile-container">
        <div class="profile-header">
            <div class="logo-container">
                <img src="../resources/img/LOGIN/logo.jpg" alt="Look Back Café Logo" class="logo">
            </div>
            <a href="<?php echo $role === 'admin' ? 'admindash.php' : 'admindash.php'; ?>" class="back-link">Back to Dashboard<?php echo $role === 'admin'  ?>
            </a>
        </div>

        <div class="profile-content">
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="success-message">
                    <?php 
                    echo $_SESSION['success_message']; 
                    unset($_SESSION['success_message']);
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="error-message">
                    <?php 
                    echo $_SESSION['error_message']; 
                    unset($_SESSION['error_message']);
                    ?>
                </div>
            <?php endif; ?>

            <div class="profile-section">
                <h2 class="section-title">Edit Profile</h2>
                <form class="profile-form" method="POST" action="editprofile.php">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($userData['user_name']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userData['user_email']); ?>" required>
                    </div>
                    
                    <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
                </form>
            </div>

            <div class="profile-section">
                <h2 class="section-title">Change Password</h2>
                <form class="password-form" method="POST" action="editprofile.php">
                    <div class="form-group password-group">
                        <label for="old_password">Old Password:</label>
                        <input type="password" id="old_password" name="old_password" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('old_password')">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="form-group password-group">
                        <label for="new_password">New Password:</label>
                        <input type="password" id="new_password" name="new_password" required minlength="6">
                        <button type="button" class="toggle-password" onclick="togglePassword('new_password')">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="form-group password-group">
                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" required minlength="6">
                        <button type="button" class="toggle-password" onclick="togglePassword('confirm_password')">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                    
                    <button type="submit" name="change_password" class="btn btn-primary">Change Password</button>
                </form>
            </div>

            <?php if ($role === 'user'): ?>
            <div class="profile-section danger-section">
                <h2 class="section-title">Delete Account</h2>
                <p class="warning-text">Warning: This action cannot be undone. All your data will be permanently deleted.</p>
                <form method="POST" action="editprofile.php" onsubmit="return confirmDelete()">
                    <button type="submit" name="delete_account" class="btn btn-danger">Delete Account</button>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const toggleBtn = passwordInput.parentElement.querySelector('.toggle-password');
            const svg = toggleBtn.querySelector('svg');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                svg.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
            } else {
                passwordInput.type = 'password';
                svg.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        }

        // Confirm delete dialog (ensures form submits if confirmed)
        function confirmDelete() {
            return confirm("Are you sure you want to delete your account? This action cannot be undone.");
        }

        document.addEventListener('DOMContentLoaded', function() {
            const passwordForm = document.querySelector('.password-form');
            if (passwordForm) {
                passwordForm.addEventListener('submit', function(e) {
                    const newPassword = document.getElementById('new_password').value;
                    const confirmPassword = document.getElementById('confirm_password').value;
                    
                    if (newPassword !== confirmPassword) {
                        e.preventDefault();
                        alert('New passwords do not match!');
                        return false;
                        
                    }
                    
                    if (newPassword.length < 6) {
                        e.preventDefault();
                        alert('Password must be at least 6 characters long!');
                        return false;
                    }
                });
            }

            // Auto-hide success/error messages after 5 seconds
            setTimeout(function() {
                var msg = document.querySelector('.success-message');
                if (msg) msg.style.display = 'none';
                msg = document.querySelector('.error-message');
                if (msg) msg.style.display = 'none';
            }, 5000);
        });
    </script>
</body>
</html>