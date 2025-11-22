<?php
session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // TODO: replace this with DB check
    $dbUser = 'nathan'; // example user from database
    $dbPass = '12345'; // example password from database

    if ($username === $dbUser && $password === $dbPass) {
        $_SESSION['is_logged_in'] = true;
        $_SESSION['user_name'] = $username;
        $_SESSION['user_avatar'] = null; // optional, can use DB value

        header('Location: ../main.php'); // redirect after login
        exit;
    } else {
        $error = 'Invalid username or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Look Back Café</title>
</head>
<body>
    <h1>Login</h1>
    <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <label>Username: <input type="text" name="username" required></label><br>
        <label>Password: <input type="password" name="password" required></label><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
