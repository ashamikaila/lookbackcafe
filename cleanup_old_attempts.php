<?php
require_once 'website/config/db.php';

echo "=== CLEANING UP OLD LOGIN ATTEMPTS ===\n\n";

// Show current attempts
$result = $conn->query("SELECT COUNT(*) as total FROM login_attempts");
$row = $result->fetch_assoc();
echo "Total attempts before cleanup: {$row['total']}\n";

// Delete attempts older than 1 hour
$cleanup_time = date('Y-m-d H:i:s', time() - 3600); // 1 hour
echo "Deleting attempts older than: $cleanup_time\n";

$result = $conn->query("DELETE FROM login_attempts WHERE attempt_time < '$cleanup_time'");
$deleted = $conn->affected_rows;

echo "Deleted: $deleted old attempts\n\n";

// Show remaining attempts
$result = $conn->query("SELECT COUNT(*) as total FROM login_attempts");
$row = $result->fetch_assoc();
echo "Total attempts after cleanup: {$row['total']}\n";

if ($row['total'] > 0) {
    echo "\nRemaining attempts:\n";
    $result = $conn->query("SELECT identifier, COUNT(*) as count FROM login_attempts GROUP BY identifier");
    while ($row = $result->fetch_assoc()) {
        echo "  - {$row['identifier']}: {$row['count']} attempts\n";
    }
}

echo "\n=== CLEANUP COMPLETE ===\n";
echo "You should now be able to login again!\n";
?>