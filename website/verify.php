<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Red+Hat+Display:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <title>Verification - Look Back Café</title>
    <link rel="stylesheet" href="../resources/css/login_as.css">
    <link rel="stylesheet" href="../resources/css/verify.css">
    <link rel="icon" type="image/jpg" href="../resources/img/favicon.jpg">
</head>
<body>
    <div class="background"></div>
    <div class="background-overlay"></div>
    
    <div class="login-card">
        <div class="logo">
            <img src="../resources/img/LOGIN/logo.jpg" alt="Look Back Café">
        </div>
        
        <h2 class="welcome-text">Verification</h2>
        <p class="welcome-subtext">We've send the code to your <span>e-mail</span>.</p>
        
        <form action="create_new_pass.php" method="POST">
            <div class="otp-container">
                <input type="text" maxlength="1" class="otp-input" required>
                <input type="text" maxlength="1" class="otp-input" required>
                <input type="text" maxlength="1" class="otp-input" required>
                <input type="text" maxlength="1" class="otp-input" required>
            </div>
            
            <p class="resend-text">Didn't receive the code? <a href="#">Resend OTP.</a></p>
            
            <button type="submit" class="submit-button">Verify</button>
        </form>
    </div>
    
    <script>
        const inputs = document.querySelectorAll('.otp-input');
        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.target.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
            
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });
    </script>
</body>
</html>