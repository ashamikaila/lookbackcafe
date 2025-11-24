<?php
// Security headers - fixes OWASP ZAP alerts
require_once __DIR__ . '/includes/security_init.php';
require_once 'config/db.php';

// Check if admin is logged in
if (!isset($_SESSION['is_logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: login_as.php");
    exit();
}

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="users_' . date('Y-m-d') . '.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, array('ID', 'Name', 'Email', 'Registered Date'));

$result = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
while ($row = $result->fetch_assoc()) {
    fputcsv($output, array(
        $row['user_id'],
        $row['user_name'],
        $row['user_email'],
        $row['created_at']
    ));
}

fclose($output);
exit();
?>