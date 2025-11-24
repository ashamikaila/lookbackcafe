<?php
// Security headers - fixes OWASP ZAP alerts
require_once __DIR__ . '/includes/security_init.php';
require_once 'config/db.php';
require_once 'config/security.php';

// Configure secure session
configure_secure_session();

// Check if admin is logged in
require_auth('admin');

// Get statistics
$userCount = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];
$subscriberCount = $conn->query("SELECT COUNT(*) as total FROM newsletter_subscribers WHERE is_active = 1")->fetch_assoc()['total'];

// Get monthly visitors (current month)
$currentMonth = date('Y-m');
$visitorQuery = $conn->query("SELECT SUM(unique_visitors) as total FROM site_analytics WHERE DATE_FORMAT(visit_date, '%Y-%m') = '$currentMonth'");
$monthlyVisitors = $visitorQuery->fetch_assoc()['total'] ?? 0;

// Get recent activities
$recentActivities = $conn->query("SELECT * FROM admin_activity_log ORDER BY created_at DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Look Back Café</title>
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
                    <li class="active"><a href="admindash.php">Dashboard</a></li>
                    <li><a href="menumanagement.php">Menu Management</a></li>
                    <li><a href="photowall.php">Photo Wall</a></li>
                    <li><a href="special.php">Special Offers</a></li>
                    <li><a href="newsletter.php">Newsletter</a></li>
                    <li><a href="analytics.php">Analytics</a></li>
                    <li><a href="user-accounts.php">User Accounts</a></li>
                    <li><a href="business-info.php">Business Info</a></li>
                    <li><a href="main.php">Back to Main</a></li>
                    <li><a href="auth/logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header class="admin-header">
                <h1>Dashboard Overview</h1>
                <div class="user-info">
                    <span>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                </div>
            </header>

            <!-- Stats Cards -->
            <div class="dashboard-stats">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $userCount; ?></h3>
                        <p>Total Users</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $subscriberCount; ?></h3>
                        <p>Newsletter Subscribers</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $monthlyVisitors; ?></h3>
                        <p>Monthly Visitors</p>
                    </div>
                </div>
            </div>

            <div class="quick-actions">
                <h2>Quick Actions</h2>
                <div class="action-grid">
                    <a href="menumanagement.php" class="action-card">
                        <h3>Manage Menu</h3>
                        <p>Add, edit, or delete menu items</p>
                    </a>
                    
                    <a href="photowall.php" class="action-card">
                        <h3>Photo Wall</h3>
                        <p>Update gallery images</p>
                    </a>
                    
                    <a href="special.php" class="action-card">
                        <h3>Special Offers</h3>
                        <p>Create and manage promotions</p>
                    </a>
                    
                    <a href="newsletter.php" class="action-card">
                        <h3>Send Newsletter</h3>
                        <p>Email subscribers</p>
                    </a>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="recent-activities">
                <h2>Recent Activities</h2>
                <div class="activity-list">
                    <?php if ($recentActivities->num_rows > 0): ?>
                        <?php while ($activity = $recentActivities->fetch_assoc()): ?>
                            <div class="activity-item">
                                <i class="fas fa-info-circle"></i>
                                <span><?php echo htmlspecialchars($activity['activity_description']); ?></span>
                                <span class="activity-time"><?php echo date('M j, g:i A', strtotime($activity['created_at'])); ?></span>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="activity-item">
                            <i class="fas fa-info-circle"></i>
                            <span>No recent activities</span>
                            <span class="activity-time">-</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>