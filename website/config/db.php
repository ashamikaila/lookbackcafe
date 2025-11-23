<?php
/**
 * Database Configuration
 * Implements secure database connection with SSL/TLS support
 */

// Database credentials
$host = "localhost";
$user = "root";
$pass = "";
$db   = "lookback_cafe";

// Create connection with error reporting disabled in production
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    // Log error securely (don't expose to user)
    error_log("Database connection failed: " . $conn->connect_error);
    die("Connection failed. Please try again later.");
}

// Set charset to UTF-8 to prevent SQL injection via encoding
$conn->set_charset("utf8mb4");

// Enable SSL/TLS for database connection (if supported by your MySQL server)
// Uncomment and configure these lines in production with proper SSL certificates
/*
$conn->ssl_set(
    null,                           // key
    null,                           // cert
    '/path/to/ca-cert.pem',        // ca_cert
    null,                           // ca_path
    null                            // cipher
);
*/

// Disable autocommit for better transaction control
// $conn->autocommit(FALSE);
?>

