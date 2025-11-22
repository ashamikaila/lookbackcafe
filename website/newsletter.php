<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter Management - Look Back Café</title>
    <link rel="stylesheet" href="../resources/css/admindash.css">
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
                    <li><a href="#">Logout</a></li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header class="admin-header">
                <h1>Newsletter Management</h1>
                <div class="user-info">
                    <span>Welcome, Admin</span>
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
                        <h3>0</h3>
                        <p>This Month</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <div class="stat-info">
                        <h3>0</h3>
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
                            <?php if (count($subscribers) > 0): ?>
                                <?php foreach ($subscribers as $subscriber): ?>
                                <tr>
                                    <td><?php echo $subscriber['id']; ?></td>
                                    <td><?php echo htmlspecialchars($subscriber['email']); ?></td>
                                    <td><?php echo date('M j, Y g:i A', strtotime($subscriber['subscribed_at'])); ?></td>
                                    <td>
                                        <form action="newsletter.php" method="POST" style="display: inline;">
                                            <input type="hidden" name="email" value="<?php echo $subscriber['email']; ?>">
                                            <button type="submit" name="unsubscribe" class="btn btn-delete btn-sm" onclick="return confirm('Are you sure you want to unsubscribe this email?')">
                                                <i class="fas fa-user-minus"></i> Unsubscribe
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" style="text-align: center; padding: 20px; color: #666;">
                                        <i class="fas fa-envelope" style="font-size: 48px; margin-bottom: 10px; display: block; opacity: 0.5;"></i>
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

    <script>
        function previewNewsletter() {
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('message').value;
            
            if (!subject || !message) {
                alert('Please fill in both subject and message fields.');
                return;
            }
            
            document.getElementById('previewSubject').textContent = subject;
            document.getElementById('previewMessage').innerHTML = message.replace(/\n/g, '<br>');
            
            document.getElementById('previewModal').style.display = 'flex';
        }
        
        function closePreview() {
            document.getElementById('previewModal').style.display = 'none';
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('previewModal');
            if (event.target === modal) {
                closePreview();
            }
        }
    </script>
</body>
</html>