<?php
// Security headers - fixes OWASP ZAP alerts
require_once __DIR__ . '/../includes/security_init.php';
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
?>