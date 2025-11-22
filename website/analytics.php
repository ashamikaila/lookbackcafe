<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Analytics</title>
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
                    <li class="active"><a href="analytics.php">Analytics</a></li>
                    <li><a href="user-accounts.php">User Accounts</a></li>
                    <li><a href="business-info.php">Business Info</a></li>
                    <li><a href="#">Logout</a></li>
                </ul>
            </nav>
        </div>

        <div class="main-content">
            <header class="admin-header">
                <h1>Analytics Dashboard</h1>
                <div class="user-info">
                    <span>Welcome, Admin</span>
                </div>
            </header>

            <!-- Date Filter -->
            <div class="analytics-section">
                <div class="date-filter">
                    <h3>Date Range</h3>
                    <div class="filter-options">
                        <button class="filter-btn active" onclick="setDateRange('7days')">Last 7 Days</button>
                        <button class="filter-btn" onclick="setDateRange('30days')">Last 30 Days</button>
                        <button class="filter-btn" onclick="setDateRange('90days')">Last 90 Days</button>
                        <button class="filter-btn" onclick="setDateRange('1year')">Last Year</button>
                        <div class="custom-date">
                            <span>Custom:</span>
                            <input type="date" id="startDate">
                            <span>to</span>
                            <input type="date" id="endDate">
                            <button class="btn btn-primary btn-sm" onclick="setCustomDate()">Apply</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Key Metrics -->
            <div class="metrics-grid">
                <div class="metric-card">
                    <div class="metric-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="metric-value">0</div>
                    <div class="metric-label">Total Users</div>
                    <div class="metric-change">No data yet</div>
                </div>
                
                <div class="metric-card">
                    <div class="metric-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="metric-value">0</div>
                    <div class="metric-label">Newsletter Subscribers</div>
                    <div class="metric-change">No data yet</div>
                </div>
                
                <div class="metric-card">
                    <div class="metric-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="metric-value">0</div>
                    <div class="metric-label">Monthly Visitors</div>
                    <div class="metric-change">No data yet</div>
                </div>
            </div>

            <!-- Charts Grid -->
            <div class="analytics-section">
                <div class="section-header">
                    <h2>Visitor Analytics</h2>
                    <button class="export-btn" onclick="exportChartData()">
                        <i class="fas fa-download"></i> Export Data
                    </button>
                </div>

                <div class="charts-grid">
                    <!-- Visitors Chart -->
                    <div class="chart-container">
                        <div class="chart-header">
                            <div class="chart-title">Website Visitors</div>
                            <div class="chart-actions">
                                <select id="visitorMetric" onchange="updateVisitorChart()">
                                    <option value="total">Total Visitors</option>
                                </select>
                            </div>
                        </div>
                        <div class="chart-wrapper">
                            <div class="empty-state">
                                <i class="fas fa-chart-line"></i>
                                <h3>No Visitor Data</h3>
                                <p>Website visitor analytics will appear here once you start receiving traffic.</p>
                            </div>
                        </div>
                    </div>

                    <!-- User Growth Chart -->
                    <div class="chart-container">
                        <div class="chart-header">
                            <div class="chart-title">User Growth</div>
                            <div class="chart-actions">
                                <select id="growthMetric" onchange="updateGrowthChart()">
                                    <option value="total">Total Users</option>
                                    <option value="new">New Users</option>
                                </select>
                            </div>
                        </div>
                        <div class="chart-wrapper">
                            <div class="empty-state">
                                <i class="fas fa-user-plus"></i>
                                <h3>No User Data</h3>
                                <p>User growth analytics will appear here once users start registering.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Subscription Trends -->
                    <div class="chart-container">
                        <div class="chart-header">
                            <div class="chart-title">Newsletter Subscriptions</div>
                        </div>
                        <div class="chart-wrapper">
                            <div class="empty-state">
                                <i class="fas fa-envelope"></i>
                                <h3>No Subscription Data</h3>
                                <p>Subscription trends will appear here once users start subscribing to your newsletter.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <script>
        // Chart initialization - keeping the functions but charts won't be initialized
        let visitorsChart, growthChart, subscriptionChart;

        // Sample data - empty for now
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const last6Months = months.slice(-6);

        // Initialize charts - but don't create any since there's no data
        document.addEventListener('DOMContentLoaded', function() {
            // Charts will remain empty until there's data
            console.log('Analytics dashboard loaded - no data available yet');
        });

        // Date Range Functions
        function setDateRange(range) {
            // Update active button
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');

            console.log('Date range changed to:', range);
            // No data to update yet
            alert('No data available for the selected date range.');
        }

        function setCustomDate() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            
            if (startDate && endDate) {
                console.log('Custom date range:', startDate, 'to', endDate);
                alert('No data available for the selected custom date range.');
            } else {
                alert('Please select both start and end dates.');
            }
        }

        // Chart Update Functions - will work when there's data
        function updateVisitorChart() {
            const metric = document.getElementById('visitorMetric').value;
            console.log('Visitor metric changed to:', metric);
            alert('No visitor data available yet.');
        }

        function updateGrowthChart() {
            const metric = document.getElementById('growthMetric').value;
            console.log('Growth metric changed to:', metric);
            alert('No user growth data available yet.');
        }

        function exportChartData() {
            alert('No data available to export yet.');
        }

        // No real-time updates since there's no data
    </script>
</body>
</html>