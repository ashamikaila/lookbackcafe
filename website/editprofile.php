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
        </div>

        <div class="profile-content">
            <div id="successMessage" class="success-message" style="display: none;">
                Your profile has been successfully updated!
            </div>

            <div class="profile-section">
                <h2 class="section-title">Edit Profile</h2>
                <form class="profile-form">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="email" id="email" name="email" value="" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" onclick="showSuccessMessage(event)">Update</button>
                </form>
            </div>

            <div class="profile-section">
                <h2 class="section-title">Change Password</h2>
                <form class="password-form">
                    <div class="form-group">
                        <label for="old_password">Old Password:</label>
                        <input type="password" id="old_password" name="old_password" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="new_password">New Password:</label>
                        <input type="password" id="new_password" name="new_password" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" onclick="showSuccessMessage(event)">Update</button>
                </form>
            </div>

            <div class="profile-section danger-section">
                <h2 class="section-title">Delete Account</h2>
                <p class="warning-text">Warning: This action cannot be undone. All your data will be permanently deleted.</p>
                <form onsubmit="return confirmDelete()">
                    <button type="submit" class="btn btn-danger">Delete Account</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showSuccessMessage(event) {
            event.preventDefault();s
            const successMessage = document.getElementById('successMessage');
            successMessage.style.display = 'block';
            
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 3000);
        }

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
                    
                    showSuccessMessage(e);
                });
            }

            const profileForm = document.querySelector('.profile-form');
            if (profileForm) {
                profileForm.addEventListener('submit', function(e) {
                    showSuccessMessage(e);
                });
            }
        });
    </script>
</body>
</html>