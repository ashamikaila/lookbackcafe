<?php
session_start();
require_once 'config/db.php';
require_once 'config/security.php';
require_once 'config/email.php';

configure_secure_session();
require_auth('admin');

// Handle newsletter sending
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_newsletter'])) {
    $subject = sanitize_input($_POST['subject']);
    $content = $_POST['content']; // HTML content
    
    if (empty($subject) || empty($content)) {
        $_SESSION['error'] = "Subject and content are required";
        header("Location: send_newsletter.php");
        exit();
    }
    
    // Send to all subscribers
    $result = send_bulk_newsletter($subject, $content);
    
    // Log the activity
    log_security_event('newsletter_sent', "Newsletter sent to {$result['sent']} subscribers", $_SESSION['user_id']);
    
    // Show detailed result
    if ($result['failed'] > 0) {
        $_SESSION['success'] = "Newsletter sent to {$result['sent']} subscribers. Failed: {$result['failed']}. Check error logs for details.";
    } else {
        $_SESSION['success'] = "Newsletter sent successfully to {$result['sent']} subscribers!";
    }
    header("Location: newsletter.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Newsletter - Look Back Café</title>
    <link rel="stylesheet" href="../resources/css/admindash.css">
    <link rel="stylesheet" href="../resources/css/newsletter.css">
    <link rel="icon" type="image/jpg" href="../resources/img/favicon.jpg">
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@400;500;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="admin-container">
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

        <div class="main-content">
            <header class="admin-header">
                <h1>Send Newsletter</h1>
            </header>

            <div class="newsletter-container">
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="error-message">
                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" class="newsletter-form">
                    <div class="form-group">
                        <label>Subject:</label>
                        <input type="text" name="subject" class="form-input" placeholder="Newsletter Subject" required>
                    </div>

                    <div class="form-group">
                        <label>Content (HTML):</label>
                        <textarea name="content" rows="15" class="form-textarea" required></textarea>
                        <small class="form-help">You can use HTML tags for formatting</small>
                    </div>

                    <div class="template-box">
                        <strong>Quick Templates:</strong>
                        <p style="margin: 10px 0;"><strong>New Special Offer:</strong></p>
                        <code class="template-code">&lt;h2&gt;New Special Offer!&lt;/h2&gt;
&lt;p&gt;Check out our latest promotion...&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Offer:&lt;/strong&gt; [Details]&lt;/p&gt;
&lt;p&gt;&lt;strong&gt;Valid Until:&lt;/strong&gt; [Date]&lt;/p&gt;</code>
                    </div>

                    <button type="submit" name="send_newsletter" class="btn-primary">
                        Send to All Subscribers
                    </button>
                    <a href="newsletter.php" class="btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>