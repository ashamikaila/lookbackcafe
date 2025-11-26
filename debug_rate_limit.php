<?php
require_once 'website/config/db.php';
require_once 'website/config/security.php';

// Get the email to check (you can modify this)
$test_email = 'admintest@email.com'; // Change this to the email you're testing with

echo "=== RATE LIMIT DEBUGGER ===\n\n";
echo "Testing email: $test_email\n";
echo "Current time: " . date('Y-m-d H:i:s') . "\n\n";

// Show current time window
$time_window = 60; // seconds
$time_threshold_date = date('Y-m-d H:i:s', time() - $time_window);
$time_threshold_unix = time() - $time_window;
echo "Time threshold (60 seconds ago):\n";
echo "  - As date string: $time_threshold_date\n";
echo "  - As unix timestamp: $time_threshold_unix\n";
echo "  - Current unix time: " . time() . "\n\n";

// Query ALL attempts for this email
echo "--- ALL ATTEMPTS (including old ones) ---\n";
$stmt = $conn->prepare("SELECT id, identifier, ip_address, success, attempt_time FROM login_attempts WHERE identifier = ? ORDER BY attempt_time DESC LIMIT 20");
$stmt->bind_param("s", $test_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "ID | Email | IP | Success | Time\n";
    echo "------------------------------------------------------------\n";
    while ($row = $result->fetch_assoc()) {
        $success_text = $row['success'] ? 'YES' : 'NO';
        echo "{$row['id']} | {$row['identifier']} | {$row['ip_address']} | $success_text | {$row['attempt_time']}\n";
    }
} else {
    echo "No attempts found for this email.\n";
}

echo "\n--- ATTEMPTS WITHIN TIME WINDOW (last 60 seconds) - OLD METHOD ---\n";
$stmt = $conn->prepare("SELECT id, identifier, ip_address, success, attempt_time, UNIX_TIMESTAMP(attempt_time) as unix_time FROM login_attempts WHERE identifier = ? AND attempt_time > ? ORDER BY attempt_time DESC");
$stmt->bind_param("ss", $test_email, $time_threshold_date);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "ID | Email | IP | Success | Time | Unix Time | Age (sec)\n";
    echo "------------------------------------------------------------\n";
    while ($row = $result->fetch_assoc()) {
        $success_text = $row['success'] ? 'YES' : 'NO';
        $age = time() - $row['unix_time'];
        echo "{$row['id']} | {$row['identifier']} | {$row['ip_address']} | $success_text | {$row['attempt_time']} | {$row['unix_time']} | $age\n";
    }
} else {
    echo "No attempts within the last 60 seconds (OLD METHOD).\n";
}

echo "\n--- ATTEMPTS WITHIN TIME WINDOW (last 60 seconds) - NEW METHOD ---\n";
$stmt = $conn->prepare("SELECT id, identifier, ip_address, success, attempt_time, UNIX_TIMESTAMP(attempt_time) as unix_time FROM login_attempts WHERE identifier = ? AND UNIX_TIMESTAMP(attempt_time) >= ? ORDER BY attempt_time DESC");
$stmt->bind_param("si", $test_email, $time_threshold_unix);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "ID | Email | IP | Success | Time | Unix Time | Age (sec)\n";
    echo "------------------------------------------------------------\n";
    while ($row = $result->fetch_assoc()) {
        $success_text = $row['success'] ? 'YES' : 'NO';
        $age = time() - $row['unix_time'];
        echo "{$row['id']} | {$row['identifier']} | {$row['ip_address']} | $success_text | {$row['attempt_time']} | {$row['unix_time']} | $age\n";
    }
} else {
    echo "No attempts within the last 60 seconds (NEW METHOD).\n";
}

echo "\n--- FAILED ATTEMPTS WITHIN TIME WINDOW (what rate limiter counts) ---\n";
echo "OLD METHOD (using date string comparison):\n";
$stmt = $conn->prepare("SELECT COUNT(*) as attempts FROM login_attempts WHERE identifier = ? AND attempt_time > ? AND success = 0");
$stmt->bind_param("ss", $test_email, $time_threshold_date);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$failed_count_old = $row['attempts'];
echo "  Failed attempts: $failed_count_old\n";

echo "\nNEW METHOD (using UNIX_TIMESTAMP):\n";
$stmt = $conn->prepare("SELECT COUNT(*) as attempts FROM login_attempts WHERE identifier = ? AND UNIX_TIMESTAMP(attempt_time) >= ? AND success = 0");
$stmt->bind_param("si", $test_email, $time_threshold_unix);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$failed_count_new = $row['attempts'];
echo "  Failed attempts: $failed_count_new\n";

echo "\nComparison:\n";
echo "  Old method count: $failed_count_old\n";
echo "  New method count: $failed_count_new\n";
echo "  Difference: " . abs($failed_count_old - $failed_count_new) . "\n";
echo "\nRate limit threshold: 5\n";
echo "Is rate limited (old method)? " . ($failed_count_old >= 5 ? "YES - BLOCKED" : "NO - ALLOWED") . "\n";
echo "Is rate limited (new method)? " . ($failed_count_new >= 5 ? "YES - BLOCKED" : "NO - ALLOWED") . "\n";

echo "\n--- RATE LIMIT CHECK RESULT ---\n";
$is_limited = check_rate_limit($test_email, 5, 60);
echo "check_rate_limit() returned: " . ($is_limited ? "TRUE (BLOCKED)" : "FALSE (ALLOWED)") . "\n";

echo "\n=== END DEBUG ===\n";
?>