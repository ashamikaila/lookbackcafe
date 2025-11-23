<?php
session_start();
require_once 'config/db.php';
require_once 'config/security.php';

// Configure secure session
configure_secure_session();

// Check if admin is logged in
require_auth('admin');

// Handle user deletion
if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        // Log activity using security system
        log_security_event('user_deleted', "Admin deleted user account ID: $user_id", $_SESSION['user_id']);
        
        // Also log in admin activity log
        $admin_id = $_SESSION['user_id'];
        $activity_desc = "Deleted user account ID: $user_id";
        $ip = $_SERVER['REMOTE_ADDR'];
        $log_stmt = $conn->prepare("INSERT INTO admin_activity_log (admin_id, activity_type, activity_description, ip_address) VALUES (?, 'user_management', ?, ?)");
        $log_stmt->bind_param("iss", $admin_id, $activity_desc, $ip);
        $log_stmt->execute();
        
        $_SESSION['success_message'] = "User deleted successfully.";
    }
    
    header("Location: user-accounts.php");
    exit();
}

// Get all users
$users = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
$userCount = $users->num_rows;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | User Accounts</title>
    <link rel="stylesheet" href="../resources/css/admindash.css">
    <link rel="stylesheet" href="../resources/css/user-accounts.css">
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
                    <li><a href="newsletter.php">Newsletter</a></li>
                    <li><a href="analytics.php">Analytics</a></li>
                    <li class="active"><a href="user-accounts.php">User Accounts</a></li>
                    <li><a href="business-info.php">Business Info</a></li>
                    <li><a href="auth/logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header class="admin-header">
                <h1>User Accounts Management</h1>
                <div class="user-info">
                    <span>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                </div>
            </header>

            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="message success">
                    <?php 
                    echo $_SESSION['success_message']; 
                    unset($_SESSION['success_message']);
                    ?>
                </div>
            <?php endif; ?>

            <!-- Search and Filter Section -->
            <div class="users-section">
                <div class="section-header">
                    <h2>Registered Users <span class="user-count">(<?php echo $userCount; ?> users)</span></h2>
                    <div class="section-actions">
                        <div class="search-box">
                            <input type="text" id="searchUsers" placeholder="Search users..." <?php echo $userCount === 0 ? 'disabled' : ''; ?>>
                            <i class="fas fa-search"></i>
                        </div>
                        <button class="btn btn-primary" onclick="exportUsers()" <?php echo $userCount === 0 ? 'disabled' : ''; ?>>
                            <i class="fas fa-download"></i> Export CSV
                        </button>
                    </div>
                </div>

                <?php if ($userCount === 0): ?>
                <!-- Empty State -->
                <div class="empty-state">
                    <i class="fas fa-users"></i>
                    <h3>No Users Registered Yet</h3>
                    <p>User accounts will appear here once users start registering on your website.</p>
                    <div class="empty-state-actions">
                        <button class="btn btn-secondary" onclick="location.reload()">
                            <i class="fas fa-sync"></i> Check for New Users
                        </button>
                    </div>
                </div>
                <?php else: ?>
                <!-- Users Table -->
                <div class="users-table-container">
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Registered</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody">
                            <?php while ($user = $users->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $user['user_id']; ?></td>
                                <td>
                                    <?php if ($user['user_avatar']): ?>
                                        <img src="<?php echo htmlspecialchars($user['user_avatar']); ?>" alt="Avatar" class="user-avatar-img">
                                    <?php else: ?>
                                        <div class="user-avatar-placeholder">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($user['user_name']); ?></td>
                                <td><?php echo htmlspecialchars($user['user_email']); ?></td>
                                <td><?php echo date('M j, Y', strtotime($user['created_at'])); ?></td>
                                <td>
                                    <button class="btn btn-sm btn-secondary" onclick="viewUser(<?php echo $user['user_id']; ?>, '<?php echo htmlspecialchars($user['user_name']); ?>', '<?php echo htmlspecialchars($user['user_email']); ?>', '<?php echo $user['created_at']; ?>')">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    <form method="POST" class="inline-delete-form" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                        <button type="submit" name="delete_user" class="btn btn-sm btn-delete">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- User Details Modal -->
    <div id="userModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>User Details</h3>
                <button type="button" class="btn-close" onclick="closeUserModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="user-details">
                    <div class="empty-state">
                        <i class="fas fa-user"></i>
                        <h3>No User Selected</h3>
                        <p>Select a user to view their details.</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeUserModal()">Close</button>
            </div>
        </div>
    </div>

    <script>
        function exportUsers() {
            window.location.href = 'export-users.php';
        }

        function viewUser(userId, userName, userEmail, createdAt) {
            const modal = document.getElementById('userModal');
            const userDetails = modal.querySelector('.user-details');
            
            userDetails.innerHTML = `
                <div class="user-info-grid">
                    <div class="info-item">
                        <strong>User ID:</strong>
                        <span>${userId}</span>
                    </div>
                    <div class="info-item">
                        <strong>Name:</strong>
                        <span>${userName}</span>
                    </div>
                    <div class="info-item">
                        <strong>Email:</strong>
                        <span>${userEmail}</span>
                    </div>
                    <div class="info-item">
                        <strong>Registered:</strong>
                        <span>${new Date(createdAt).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</span>
                    </div>
                </div>
            `;
            
            modal.style.display = 'flex';
        }

        function closeUserModal() {
            document.getElementById('userModal').style.display = 'none';
        }

        // Search functionality
        document.getElementById('searchUsers').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#usersTableBody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('userModal');
            if (event.target === modal) {
                closeUserModal();
            }
        }
    </script>
</body>
</html>