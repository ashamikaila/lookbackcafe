<?php
// Security headers - fixes OWASP ZAP alerts
require_once __DIR__ . '/../includes/security_init.php';
// Destroy all session data
session_unset();
session_destroy();

// Redirect to login page
header("Location: ../main.php");
exit();
?>