<?php
require_once 'includes/security_init.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Red+Hat+Display:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <title>Admin Login - Look Back Café</title>
    <link rel="stylesheet" href="../resources/css/login_as.css">
    <link rel="stylesheet" href="../resources/css/as_admin.css">
    <link rel="icon" type="image/jpg" href="../resources/img/favicon.jpg">
</head>
<body>
    <div class="background"></div>
    <div class="background-overlay"></div>
    
    <div class="login-card">
        <a href="main.php" class="back-to-home">
            ← Back to Home
        </a>
        <div class="logo">
            <img src="../resources/img/LOGIN/logo.jpg" alt="Look Back Café">
        </div>
        
        <h2 class="welcome-text">Welcome Back!</h2>
        <p class="welcome-subtext">Please enter your details to login.</p>
        
        <form action="auth/login.php" method="POST">
            <input type="hidden" name="role" value="admin">
            
            <div class="form-group">
                <input type="text" name="username" class="form-input" placeholder="Enter your username" required>
            </div>
            
            <div class="form-group password-group">
                <input type="password" name="password" id="password" class="form-input" placeholder="Enter your password" required>
                <button type="button" class="toggle-password" onclick="togglePassword()">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </button>
            </div>
            
            <button type="submit" class="submit-button">Login</button>
        </form>
    </div>
    
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleBtn = document.querySelector('.toggle-password');
            const svg = toggleBtn.querySelector('svg');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                svg.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
            } else {
                passwordInput.type = 'password';
                svg.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        }

        <?php if (isset($_SESSION['error_message'])): ?>
            alert('<?php echo addslashes($_SESSION['error_message']); ?>');
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
    </script>
    </div>
</body>
</html>