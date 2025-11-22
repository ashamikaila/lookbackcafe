<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | User Accounts</title>
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
                    <li><a href="newsletter.php">Newsletter</a></li>
                    <li><a href="analytics.php">Analytics</a></li>
                    <li class="active"><a href="user-accounts.php">User Accounts</a></li>
                    <li><a href="business-info.php">Business Info</a></li>
                    <li><a href="#">Logout</a></li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header class="admin-header">
                <h1>User Accounts Management</h1>
                <div class="user-info">
                    <span>Welcome, Admin</span>
                </div>
            </header>

            <!-- Search and Filter Section -->
            <div class="users-section">
                <div class="section-header">
                    <h2>Registered Users <span class="user-count">(0 users)</span></h2>
                    <div class="section-actions">
                        <div class="search-box">
                            <input type="text" id="searchUsers" placeholder="Search users..." disabled>
                            <i class="fas fa-search"></i>
                        </div>
                        <button class="btn btn-primary" onclick="exportUsers()" disabled>
                            <i class="fas fa-download"></i> Export CSV
                        </button>
                    </div>
                </div>

                <!-- Empty State -->
                <div class="empty-state">
                    <i class="fas fa-users"></i>
                    <h3>No Users Registered Yet</h3>
                    <p>User accounts will appear here once users start registering on your website.</p>
                    <div class="empty-state-actions">
                        <button class="btn btn-secondary" onclick="checkForUsers()">
                            <i class="fas fa-sync"></i> Check for New Users
                        </button>
                    </div>
                </div>

                <!-- Users Table (Hidden when empty) -->
                <div class="users-table-container" style="display: none;">
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Registered</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Users will be populated here when available -->
                        </tbody>
                    </table>
                </div>
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
        function checkForUsers() {
            alert('No new users found. User accounts will appear here automatically when users register on your website.');
        }

        function exportUsers() {
            alert('No user data available to export yet.');
        }

        function viewUser(userId) {
            // This function will work when users are available
            alert('No users available to view.');
        }

        function closeUserModal() {
            document.getElementById('userModal').style.display = 'none';
        }

        function deleteUser(userId, userName) {
            // This function will work when users are available
            alert('No users available to delete.');
        }

        // Search functionality (disabled for now)
        document.getElementById('searchUsers').addEventListener('input', function(e) {
            // Search will be enabled when users are available
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