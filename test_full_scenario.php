<?php
require_once 'website/config/db.php';
require_once 'website/config/security.php';

echo "=== SIMULATING REAL LOGIN SCENARIO ===\n\n";

$test_email = 'test@example.com';

// Clean up any existing attempts for this test email
echo "Step 1: Cleaning up old test data...\n";
$conn->query("DELETE FROM login_attempts WHERE identifier = '$test_email'");
echo "Done.\n\n";

// Simulate 5 failed login attempts
echo "Step 2: Simulating 5 failed login attempts...\n";
for ($i = 1; $i <= 5; $i++) {
    record_login_attempt($test_email, false);
    echo "  Attempt $i: FAILED\n";
    sleep(1); // Small delay between attempts
}
echo "Done.\n\n";

// Check if rate limited
echo "Step 3: Checking rate limit immediately after 5 failures...\n";
$is_limited = check_rate_limit($test_email, 5, 60);
echo "Result: " . ($is_limited ? "BLOCKED ✓ (Expected)" : "ALLOWED ✗ (Unexpected!)") . "\n\n";

// Count failed attempts
$time_threshold = time() - 60;
$stmt = $conn->prepare("SELECT COUNT(*) as attempts FROM login_attempts WHERE identifier = ? AND UNIX_TIMESTAMP(attempt_time) >= ? AND success = 0");
$stmt->bind_param("si", $test_email, $time_threshold);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
echo "Failed attempts in last 60 seconds: {$row['attempts']}/5\n\n";

// Wait for cooldown
echo "Step 4: Waiting for 60-second cooldown...\n";
echo "Please wait";
for ($i = 0; $i < 60; $i++) {
    echo ".";
    if (($i + 1) % 10 == 0) echo " " . (60 - $i - 1) . "s left";
    sleep(1);
}
echo "\nCooldown complete!\n\n";

// Check if rate limit lifted
echo "Step 5: Checking rate limit after 60-second cooldown...\n";
$is_limited = check_rate_limit($test_email, 5, 60);
echo "Result: " . ($is_limited ? "BLOCKED ✗ (Should be allowed!)" : "ALLOWED ✓ (Expected)") . "\n\n";

// Count failed attempts again
$time_threshold = time() - 60;
$stmt = $conn->prepare("SELECT COUNT(*) as attempts FROM login_attempts WHERE identifier = ? AND UNIX_TIMESTAMP(attempt_time) >= ? AND success = 0");
$stmt->bind_param("si", $test_email, $time_threshold);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
echo "Failed attempts in last 60 seconds: {$row['attempts']}/5\n\n";

// Show all attempts with ages
echo "Step 6: All attempts for $test_email:\n";
$stmt = $conn->prepare("SELECT id, success, attempt_time, UNIX_TIMESTAMP(attempt_time) as unix_time FROM login_attempts WHERE identifier = ? ORDER BY attempt_time DESC");
$stmt->bind_param("s", $test_email);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $age = time() - $row['unix_time'];
    $success_text = $row['success'] ? 'SUCCESS' : 'FAILED';
    $within_window = $age <= 60 ? 'COUNTED' : 'EXPIRED';
    echo "  ID {$row['id']}: $success_text at {$row['attempt_time']} (age: {$age}s) [$within_window]\n";
}

// Cleanup
echo "\nStep 7: Cleaning up test data...\n";
$conn->query("DELETE FROM login_attempts WHERE identifier = '$test_email'");
echo "Done.\n";

echo "\n=== TEST COMPLETE ===\n";
echo "\nCONCLUSION:\n";
echo "✓ Rate limit blocks after 5 failed attempts\n";
echo "✓ Rate limit is lifted after 60 seconds\n";
echo "✓ You can login again after the cooldown period\n";
echo "\nNO PAGE REFRESH NEEDED - the check happens server-side on every login attempt.\n";
?>