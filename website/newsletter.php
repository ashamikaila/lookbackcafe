<?php
session_start();
require_once 'config/db.php';

// Check if admin is logged in
if (!isset($_SESSION['is_logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: login_as.php");
    exit();
}

// Include email configuration
require_once 'config/email.php';

// Handle newsletter sending
if (isset($_POST['send_newsletter'])) {
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $admin_id = $_SESSION['user_id'];
    
    // Send bulk newsletter using PHPMailer
    $result = send_bulk_newsletter($subject, $message);
    
    if ($result['sent'] > 0) {
        // Log the newsletter in database
        $stmt = $conn->prepare("INSERT INTO newsletters_sent (subject, message, sent_by, recipients_count) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $subject, $message, $admin_id, $result['sent']);
        $stmt->execute();
        
        // Log activity
        $activity_desc = "Sent newsletter: $subject to {$result['sent']} subscribers";
        $ip = $_SERVER['REMOTE_ADDR'];
        $log_stmt = $conn->prepare("INSERT INTO admin_activity_log (admin_id, activity_type, activity_description, ip_address) VALUES (?, 'newsletter', ?, ?)");
        $log_stmt->bind_param("iss", $admin_id, $activity_desc, $ip);
        $log_stmt->execute();
        
        $message_text = "Newsletter sent successfully to {$result['sent']} subscribers!";
        if ($result['failed'] > 0) {
            $message_text .= " ({$result['failed']} failed)";
        }
        $_SESSION['newsletter_message'] = $message_text;
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['newsletter_message'] = "Failed to send newsletter. No subscribers or all emails failed.";
        $_SESSION['message_type'] = 'error';
    }
    
    header("Location: newsletter.php");
    exit();
}

// Handle unsubscribe
if (isset($_POST['unsubscribe'])) {
    $email = $_POST['email'];
    $stmt = $conn->prepare("UPDATE newsletter_subscribers SET is_active = 0 WHERE email = ?");
    $stmt->bind_param("s", $email);
    
    if ($stmt->execute()) {
        $_SESSION['newsletter_message'] = "Email unsubscribed successfully.";
        $_SESSION['message_type'] = 'success';
    }
    
    header("Location: newsletter.php");
    exit();
}

// Handle CSV export
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="newsletter_subscribers_' . date('Y-m-d') . '.csv"');
    
    $output = fopen('php://output', 'w');
    fputcsv($output, array('ID', 'Email', 'Subscribed Date', 'Status'));
    
    $result = $conn->query("SELECT * FROM newsletter_subscribers ORDER BY subscribed_at DESC");
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, array(
            $row['id'],
            $row['email'],
            $row['subscribed_at'],
            $row['is_active'] ? 'Active' : 'Inactive'
        ));
    }
    
    fclose($output);
    exit();
}

// Get subscriber count
$subscriberCount = $conn->query("SELECT COUNT(*) as total FROM newsletter_subscribers WHERE is_active = 1")->fetch_assoc();

// Get this month's subscribers
$currentMonth = date('Y-m');
$thisMonthCount = $conn->query("SELECT COUNT(*) as total FROM newsletter_subscribers WHERE DATE_FORMAT(subscribed_at, '%Y-%m') = '$currentMonth' AND is_active = 1")->fetch_assoc()['total'];

// Get newsletters sent count
$newslettersSent = $conn->query("SELECT COUNT(*) as total FROM newsletters_sent")->fetch_assoc()['total'];

// Get all subscribers
$subscribers = $conn->query("SELECT * FROM newsletter_subscribers ORDER BY subscribed_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter Management - Look Back Café</title>
    <link rel="stylesheet" href="../resources/css/admindash.css">
    <link rel="stylesheet" href="../resources/css/newsletter.css">
    <link rel="icon" type="image/jpg" href="../resources/img/favicon.jpg">
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo-section">
                <img src="../resources/img/LOGIN/logo.jpg" alt="Look Back Café" class="logo">
                <h2>Admin Panel</h2>
            </div>
            
            <nav class="admin-nav">
                <ul>
                    <li><a href="admindash.php">Dashboard</a></li>
                    <li><a href="menumanagement.php">Menu Management</a></li>
                    <li><a href="photowall.php">Photo Wall</a></li>
                    <li><a href="special.php">Special Offers</a></li>
                    <li class="active"><a href="newsletter.php">Newsletter</a></li>
                    <li><a href="analytics.php">Analytics</a></li>
                    <li><a href="user-accounts.php">User Accounts</a></li>
                    <li><a href="business-info.php">Business Info</a></li>
                    <li><a href="auth/logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header class="admin-header">
                <h1>Newsletter Management</h1>
                <div class="user-info">
                    <span>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                </div>
            </header>

            <!-- Stats Cards -->
            <div class="dashboard-stats">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $subscriberCount['total']; ?></h3>
                        <p>Total Subscribers</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $thisMonthCount; ?></h3>
                        <p>This Month</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $newslettersSent; ?></h3>
                        <p>Newsletters Sent</p>
                    </div>
                </div>
            </div>

            <!-- Newsletter Compose Section -->
            <div class="newsletter-section">
                <div class="section-header">
                    <h2>Compose Newsletter</h2>
                </div>
                
                <?php if (isset($_SESSION['newsletter_message'])): ?>
                    <div class="message <?php echo $_SESSION['message_type']; ?>">
                        <?php 
                        echo $_SESSION['newsletter_message']; 
                        unset($_SESSION['newsletter_message']);
                        unset($_SESSION['message_type']);
                        ?>
                    </div>
                <?php endif; ?>
                
                <form action="newsletter.php" method="POST" class="newsletter-form">
                    <div class="form-group">
                        <label for="subject">Subject:</label>
                        <input type="text" id="subject" name="subject" required placeholder="Enter newsletter subject">
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea id="message" name="message" required placeholder="Write your newsletter content here..." rows="10"></textarea>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="previewNewsletter()">
                            <i class="fas fa-eye"></i> Preview
                        </button>
                        <button type="submit" name="send_newsletter" class="btn btn-primary" onclick="return confirm('Are you sure you want to send this newsletter to all subscribers?')">
                            <i class="fas fa-paper-plane"></i> Send Newsletter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Subscribers List -->
            <div class="subscribers-section">
                <div class="section-header">
                    <h2>Subscribers List (<?php echo $subscriberCount['total']; ?>)</h2>
                    <div class="section-actions">
                        <a href="newsletter.php?export=csv" class="btn btn-primary">
                            <i class="fas fa-download"></i> Export CSV
                        </a>
                    </div>
                </div>
                
                <div class="subscribers-table-container">
                    <table class="subscribers-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Subscribed Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($subscribers->num_rows > 0): ?>
                                <?php while ($subscriber = $subscribers->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $subscriber['id']; ?></td>
                                    <td><?php echo htmlspecialchars($subscriber['email']); ?></td>
                                    <td><?php echo date('M j, Y g:i A', strtotime($subscriber['subscribed_at'])); ?></td>
                                    <td>
                                        <form action="newsletter.php" method="POST" class="inline-form">
                                            <input type="hidden" name="email" value="<?php echo $subscriber['email']; ?>">
                                            <button type="submit" name="unsubscribe" class="btn btn-delete btn-sm" onclick="return confirm('Are you sure you want to unsubscribe this email?')">
                                                <i class="fas fa-user-minus"></i> Unsubscribe
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="no-subscribers">
                                        <i class="fas fa-envelope no-subscribers-icon"></i>
                                        No subscribers yet
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Newsletter Preview Modal -->
    <div id="previewModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Newsletter Preview</h3>
                <button type="button" class="btn-close" onclick="closePreview()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="newsletter-preview">
                    <h2 id="previewSubject"></h2>
                    <div id="previewMessage" class="preview-content"></div>
                    <div class="preview-footer">
                        <p><small>This is a preview of how your newsletter will appear to subscribers.</small></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closePreview()">Close</button>
            </div>
        </div>
    </div>

    <script src="../resources/js/newsletter.js"></script>
</body>
</html>