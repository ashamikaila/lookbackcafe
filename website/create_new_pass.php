<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Red+Hat+Display:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <title>Create New Password - Look Back Café</title>
    <link rel="stylesheet" href="../resources/css/login_as.css">
    <link rel="stylesheet" href="../resources/css/create_new_pass.css">
    <link rel="icon" type="image/jpg" href="../resources/img/favicon.jpg">
</head>
<body>
    <div class="background"></div>
    <div class="background-overlay"></div>
    
    <div class="login-card">
        <div class="logo">
            <img src="../resources/img/LOGIN/logo.jpg" alt="Look Back Café">
        </div>
        
        <h2 class="welcome-text">Create New Password</h2>
        <p class="welcome-subtext">Your new password must be different from previous password.</p>
        
        <form action="pass_change_success.php" method="POST">
            <div class="form-group">
                <input type="password" name="new_password" class="form-input" placeholder="New Password" required>
            </div>
            
            <div class="form-group">
                <input type="password" name="confirm_password" class="form-input" placeholder="Confirm Password" required>
            </div>
            
            <button type="submit" class="submit-button">Create</button>
        </form>
    </div>
</body>
</html>