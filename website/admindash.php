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
                    <li><a href="#">Logout</a></li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header class="admin-header">
                <h1>Dashboard Overview</h1>
                <div class="user-info">
                    <span>Welcome, Admin</span>
                </div>
            </header>

            <!-- Stats Cards -->
            <div class="dashboard-stats">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3>0</h3>
                        <p>Total Users</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="stat-info">
                        <h3>0</h3>
                        <p>Newsletter Subscribers</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="stat-info">
                        <h3>0</h3>
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
                    <div class="activity-item">
                        <i class="fas fa-info-circle"></i>
                        <span>No recent activities</span>
                        <span class="activity-time">-</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>