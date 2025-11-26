<?php
require_once 'website/config/db.php';
require_once 'website/config/security.php';

echo "=== ALL LOGIN ATTEMPTS IN DATABASE ===\n\n";
echo "Current time: " . date('Y-m-d H:i:s') . "\n";
echo "Time window: 60 seconds\n";
echo "Time threshold: " . date('Y-m-d H:i:s', time() - 60) . "\n\n";

// Get ALL login attempts
$result = $conn->query("SELECT id, identifier, ip_address, success, attempt_time FROM login_attempts ORDER BY attempt_time DESC LIMIT 50");

if ($result->num_rows > 0) {
    echo "Total attempts in database: " . $result->num_rows . "\n\n";
    echo "ID | Email/Identifier | IP | Success | Time\n";
    echo "--------------------------------------------------------------------------------\n";
    while ($row = $result->fetch_assoc()) {
        $success_text = $row['success'] ? 'YES' : 'NO ';
        $time_diff = time() - strtotime($row['attempt_time']);
        $time_ago = $time_diff < 60 ? "{$time_diff}s ago" : floor($time_diff/60) . "m ago";
        echo "{$row['id']} | {$row['identifier']} | {$row['ip_address']} | $success_text | {$row['attempt_time']} ($time_ago)\n";
    }
    
    echo "\n--- UNIQUE IDENTIFIERS ---\n";
    $result2 = $conn->query("SELECT DISTINCT identifier, COUNT(*) as count FROM login_attempts GROUP BY identifier");
    while ($row = $result2->fetch_assoc()) {
        echo "{$row['identifier']} - {$row['count']} attempts\n";
    }
} else {
    echo "No login attempts found in database.\n";
}

echo "\n=== END ===\n";
?>