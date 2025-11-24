<?php
// Security headers - fixes OWASP ZAP alerts
require_once __DIR__ . '/includes/security_init.php';
/**
 * Simple Newsletter Test
 * Connects to database and sends to all subscribers
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/db.php';
require_once 'config/email.php';

?>
<!DOCTYPE html>
<html>
<head>
    <title>Newsletter Test</title>
    <style>
        body { font-family: Arial; max-width: 900px; margin: 50px auto; padding: 20px; }
        h1 { color: #8B4513; }
        .form-group { margin: 20px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        textarea { min-height: 200px; }
        button { background: #8B4513; color: white; padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        button:hover { background: #654321; }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .info { background: #e3f2fd; color: #014361; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .subscribers { background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .subscriber-list { max-height: 200px; overflow-y: auto; }
    </style>
</head>
<body>
    <h1>📧 Newsletter Test</h1>
    
    <?php
    // Get subscriber count
    $result = $conn->query("SELECT COUNT(*) as total FROM newsletter_subscribers WHERE is_active = 1");
    $subscriber_count = $result->fetch_assoc()['total'];
    
    // Get all subscribers
    $subscribers_result = $conn->query("SELECT email, subscribed_at FROM newsletter_subscribers WHERE is_active = 1 ORDER BY subscribed_at DESC");
    ?>
    
    <div class="subscribers">
        <h3>📊 Active Subscribers: <?php echo $subscriber_count; ?></h3>
        <div class="subscriber-list">
            <?php if ($subscriber_count > 0): ?>
                <ul>
                    <?php while ($sub = $subscribers_result->fetch_assoc()): ?>
                        <li><?php echo htmlspecialchars($sub['email']); ?> (subscribed: <?php echo $sub['subscribed_at']; ?>)</li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No active subscribers yet.</p>
            <?php endif; ?>
        </div>
    </div>
    
    <?php
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_newsletter'])) {
        $subject = trim($_POST['subject']);
        $content = $_POST['content'];
        
        if (empty($subject) || empty($content)) {
            echo "<div class='error'>Subject and content are required!</div>";
        } else {
            echo "<div class='info'>Sending newsletter to $subscriber_count subscribers...</div>";
            
            $result = send_bulk_newsletter($subject, $content);
            
            if ($result['sent'] > 0) {
                echo "<div class='success'>";
                echo "<h3>✅ Newsletter Sent!</h3>";
                echo "<p>Successfully sent to: <strong>{$result['sent']}</strong> subscribers</p>";
                if ($result['failed'] > 0) {
                    echo "<p>Failed: <strong>{$result['failed']}</strong> (check error logs)</p>";
                }
                echo "</div>";
            } else {
                echo "<div class='error'>";
                echo "<h3>❌ Failed to Send</h3>";
                echo "<p>No emails were sent. Check your SMTP configuration and error logs.</p>";
                echo "</div>";
            }
        }
    }
    ?>
    
    <form method="post">
        <div class="form-group">
            <label>Subject:</label>
            <input type="text" name="subject" placeholder="Newsletter subject" required>
        </div>
        
        <div class="form-group">
            <label>Content (HTML allowed):</label>
            <textarea name="content" placeholder="Newsletter content..." required></textarea>
        </div>
        
        <button type="submit" name="send_newsletter" onclick="return confirm('Send newsletter to <?php echo $subscriber_count; ?> subscribers?')">
            📨 Send Newsletter to <?php echo $subscriber_count; ?> Subscribers
        </button>
    </form>
    
    <hr style="margin: 40px 0;">
    
    <h3>💡 Test Tips:</h3>
    <ul>
        <li>Make sure you have subscribers in the database</li>
        <li>Check spam folder if emails don't arrive</li>
        <li>Use simple HTML in content (no CSS needed)</li>
        <li>Example content: <code>&lt;h2&gt;Hello!&lt;/h2&gt;&lt;p&gt;This is our newsletter.&lt;/p&gt;</code></li>
    </ul>
    
</body>
</html>