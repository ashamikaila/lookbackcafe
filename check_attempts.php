<?php
require_once 'website/config/db.php';

echo "=== ALL LOGIN ATTEMPTS IN DATABASE ===\n\n";

$result = $conn->query("SELECT COUNT(*) as total FROM login_attempts");
$row = $result->fetch_assoc();
echo "Total attempts in database: {$row['total']}\n\n";

if ($row['total'] > 0) {
    echo "Recent attempts (last 20):\n";
    echo "ID | Identifier | IP | Success | Time | Unix Time | Age (sec)\n";
    echo "--------------------------------------------------------------------------------\n";
    
    $result = $conn->query("SELECT id, identifier, ip_address, success, attempt_time, UNIX_TIMESTAMP(attempt_time) as unix_time FROM login_attempts ORDER BY attempt_time DESC LIMIT 20");
    while ($row = $result->fetch_assoc()) {
        $success_text = $row['success'] ? 'YES' : 'NO ';
        $age = time() - $row['unix_time'];
        printf("%d | %s | %s | %s | %s | %d | %d\n", 
            $row['id'], 
            $row['identifier'], 
            $row['ip_address'], 
            $success_text, 
            $row['attempt_time'],
            $row['unix_time'],
            $age
        );
    }
    
    echo "\n\nAttempts by identifier:\n";
    $result = $conn->query("SELECT identifier, COUNT(*) as count, SUM(success=0) as failed, SUM(success=1) as succeeded FROM login_attempts GROUP BY identifier");
    while ($row = $result->fetch_assoc()) {
        echo "  {$row['identifier']}: {$row['count']} total ({$row['failed']} failed, {$row['succeeded']} succeeded)\n";
    }
}

echo "\n=== CURRENT TIME INFO ===\n";
echo "PHP time(): " . time() . "\n";
echo "PHP date: " . date('Y-m-d H:i:s') . "\n";

$result = $conn->query("SELECT NOW() as db_now, UNIX_TIMESTAMP(NOW()) as db_unix");
$row = $result->fetch_assoc();
echo "MySQL NOW(): {$row['db_now']}\n";
echo "MySQL UNIX_TIMESTAMP(NOW()): {$row['db_unix']}\n";
echo "Time difference (PHP - MySQL): " . (time() - $row['db_unix']) . " seconds\n";

echo "\n=== END ===\n";
?>