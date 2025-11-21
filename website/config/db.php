<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_lbcsystem";

$conn = new mysqli(hostname: $host, username: $user, password: $pass, database: $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

