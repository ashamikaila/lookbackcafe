<?php
require_once 'website/config/db.php';
$cleanup_time = date('Y-m-d H:i:s', time() - 3600);
$conn->query("DELETE FROM login_attempts WHERE attempt_time < '$cleanup_time'");
echo "Deleted " . $conn->affected_rows . " old attempts\n";
?>