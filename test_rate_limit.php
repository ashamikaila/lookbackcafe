<?php
require_once 'website/config/db.php';
require_once 'website/config/security.php';

$test_email = 'testuser@gmail.com';

echo "=== TESTING RATE LIMIT FOR: $test_email ===\n\n";

// Check current status
echo "Step 1: Checking current rate limit status...\n";
$is_limited = check_rate_limit($test_email, 5, 60);
echo "Result: " . ($is_limited ? "BLOCKED" : "ALLOWED") . "\n\n";

// Count current failed attempts in last 60 seconds
$time_threshold = time() - 60;
$stmt = $conn->prepare("SELECT COUNT(*) as attempts FROM login_attempts WHERE identifier = ? AND UNIX_TIMESTAMP(attempt_time) >= ? AND success = 0");
$stmt->bind_param("si", $test_email, $time_threshold);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
echo "Failed attempts in last 60 seconds: {$row['attempts']}\n";

// Show all attempts for this email
echo "\nAll attempts for $test_email:\n";
$stmt = $conn->prepare("SELECT id, success, attempt_time, UNIX_TIMESTAMP(attempt_time) as unix_time FROM login_attempts WHERE identifier = ? ORDER BY attempt_time DESC");
$stmt->bind_param("s", $test_email);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $age = time() - $row['unix_time'];
    $success_text = $row['success'] ? 'SUCCESS' : 'FAILED';
    echo "  ID {$row['id']}: $success_text at {$row['attempt_time']} (age: {$age}s)\n";
}

echo "\n=== TEST COMPLETE ===\n";
echo "\nConclusion:\n";
echo "- If failed attempts in last 60 seconds < 5: You should be able to login\n";
echo "- If failed attempts in last 60 seconds >= 5: You are rate limited\n";
echo "- Wait for old attempts to age past 60 seconds, then try again\n";
?>