<?php
// Security headers - fixes OWASP ZAP alerts
require_once __DIR__ . '/includes/security_init.php';
require_once 'config/db.php';

// Check if admin is logged in
if (!isset($_SESSION['is_logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: login_as.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $business_name = $_POST['businessName'];
    $business_email = $_POST['businessEmail'];
    $business_phone = $_POST['businessPhone'];
    $business_address = $_POST['businessAddress'];
    $google_maps_link = $_POST['googleMapsLink'];
    $google_maps_embed = $_POST['mapsEmbed'];
    $weekday_hours = $_POST['weekdayHours'];
    $weekend_hours = $_POST['weekendHours'];
    $facebook_link = $_POST['facebookLink'];
    $instagram_link = $_POST['instagramLink'];
    $tiktok_link = $_POST['tiktokLink'];
    
    $stmt = $conn->prepare("UPDATE business_info SET 
        business_name = ?, 
        business_email = ?, 
        business_phone = ?, 
        business_address = ?, 
        google_maps_link = ?, 
        google_maps_embed = ?, 
        weekday_hours = ?, 
        weekend_hours = ?, 
        facebook_link = ?, 
        instagram_link = ?, 
        tiktok_link = ? 
        WHERE info_id = 1");
    
    $stmt->bind_param("sssssssssss", 
        $business_name, $business_email, $business_phone, $business_address,
        $google_maps_link, $google_maps_embed, $weekday_hours, $weekend_hours,
        $facebook_link, $instagram_link, $tiktok_link
    );
    
    if ($stmt->execute()) {
        // Log activity
        $admin_id = $_SESSION['user_id'];
        $activity_desc = "Updated business information";
        $ip = $_SERVER['REMOTE_ADDR'];
        $log_stmt = $conn->prepare("INSERT INTO admin_activity_log (admin_id, activity_type, activity_description, ip_address) VALUES (?, 'business_info', ?, ?)");
        $log_stmt->bind_param("iss", $admin_id, $activity_desc, $ip);
        $log_stmt->execute();
        
        $_SESSION['success_message'] = "Business information updated successfully!";
    }
    
    header("Location: business-info.php");
    exit();
}

// Get business info
$businessInfo = $conn->query("SELECT * FROM business_info WHERE info_id = 1")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Business Information</title>
    <link rel="stylesheet" href="../resources/css/admindash.css">
    <link rel="stylesheet" href="../resources/css/business-info.css">
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
                    <li><a href="user-accounts.php">User Accounts</a></li>
                    <li class="active"><a href="business-info.php">Business Info</a></li>
                    <li><a href="main.php">Back to Main</a></li>
                    <li><a href="auth/logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>

         <!-- Main Content -->
        <div class="main-content">
            <header class="admin-header">
                <h1>Business Information</h1>
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

            <!-- Business Information Section -->
            <div class="business-section">
                <div class="section-header">
                    <h2>Contact Information</h2>
                    <button class="btn btn-primary" onclick="enableEditing()">
                        <i class="fas fa-edit"></i> Edit Information
                    </button>
                </div>

                <form id="businessInfoForm" class="business-form" method="POST" action="business-info.php">
                    <!-- Business Details -->
                    <div class="form-section">
                        <h3>Business Details</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="businessName">Business Name</label>
                                <input type="text" id="businessName" name="businessName" value="<?php echo htmlspecialchars($businessInfo['business_name']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="businessEmail">Email Address</label>
                                <input type="email" id="businessEmail" name="businessEmail" value="<?php echo htmlspecialchars($businessInfo['business_email']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="businessPhone">Phone Number</label>
                                <input type="tel" id="businessPhone" name="businessPhone" value="<?php echo htmlspecialchars($businessInfo['business_phone']); ?>" disabled>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="form-section">
                        <h3>Address</h3>
                        <div class="form-group full-width">
                            <label for="businessAddress">Full Address</label>
                            <textarea id="businessAddress" name="businessAddress" rows="3" disabled><?php echo htmlspecialchars($businessInfo['business_address']); ?></textarea>
                        </div>
                        <div class="form-group full-width">
                            <label for="googleMapsLink">Google Maps Link</label>
                            <input type="url" id="googleMapsLink" name="googleMapsLink" value="<?php echo htmlspecialchars($businessInfo['google_maps_link']); ?>" disabled>
                        </div>
                    </div>

                    <!-- Store Hours -->
                    <div class="form-section">
                        <h3>Store Hours</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="weekdayHours">Weekday Hours (Mon-Sat)</label>
                                <input type="text" id="weekdayHours" name="weekdayHours" value="<?php echo htmlspecialchars($businessInfo['weekday_hours']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="weekendHours">Weekend Hours (Sun & Holidays)</label>
                                <input type="text" id="weekendHours" name="weekendHours" value="<?php echo htmlspecialchars($businessInfo['weekend_hours']); ?>" disabled>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media Links -->
                    <div class="form-section">
                        <h3>Social Media</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="facebookLink">
                                    <i class="fab fa-facebook social-icon-facebook"></i> Facebook
                                </label>
                                <input type="url" id="facebookLink" name="facebookLink" value="<?php echo htmlspecialchars($businessInfo['facebook_link']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="instagramLink">
                                    <i class="fab fa-instagram social-icon-instagram"></i> Instagram
                                </label>
                                <input type="url" id="instagramLink" name="instagramLink" value="<?php echo htmlspecialchars($businessInfo['instagram_link']); ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="tiktokLink">
                                    <i class="fab fa-tiktok social-icon-tiktok"></i> TikTok
                                </label>
                                <input type="url" id="tiktokLink" name="tiktokLink" value="<?php echo htmlspecialchars($businessInfo['tiktok_link']); ?>" disabled>
                            </div>
                        </div>
                    </div>

                    <!-- Google Maps Embed -->
                    <div class="form-section">
                        <h3>Google Maps Embed</h3>
                        <div class="form-group full-width">
                            <label for="mapsEmbed">Maps Embed Code</label>
                            <textarea id="mapsEmbed" name="mapsEmbed" rows="4" disabled><?php echo htmlspecialchars($businessInfo['google_maps_embed']); ?></textarea>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions" id="formActions">
                        <button type="button" class="btn btn-secondary" onclick="cancelEditing()">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </div>
                </form>

                <!-- Preview Section -->
                <div class="preview-section">
                    <h3>Live Preview</h3>
                    <div class="preview-container">
                        <p class="preview-note">Changes will be reflected on the contact page after saving.</p>
                        <div class="preview-content">
                            <div class="preview-item">
                                <strong>Business Name:</strong> <span id="previewName"><?php echo htmlspecialchars($businessInfo['business_name']); ?></span>
                            </div>
                            <div class="preview-item">
                                <strong>Address:</strong> <span id="previewAddress"><?php echo htmlspecialchars($businessInfo['business_address']); ?></span>
                            </div>
                            <div class="preview-item">
                                <strong>Email:</strong> <span id="previewEmail"><?php echo htmlspecialchars($businessInfo['business_email']); ?></span>
                            </div>
                            <div class="preview-item">
                                <strong>Phone:</strong> <span id="previewPhone"><?php echo htmlspecialchars($businessInfo['business_phone']); ?></span>
                            </div>
                            <div class="preview-item">
                                <strong>Store Hours:</strong> 
                                <span id="previewWeekday">Mon – Sat, <?php echo htmlspecialchars($businessInfo['weekday_hours']); ?></span><br>
                                <span id="previewWeekend">Sun & Holidays, <?php echo htmlspecialchars($businessInfo['weekend_hours']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let isEditing = false;
        let originalData = {};

        document.addEventListener('DOMContentLoaded', function() {
            saveOriginalData();
            updatePreview();
        });

        function saveOriginalData() {
            const form = document.getElementById('businessInfoForm');
            const formData = new FormData(form);
            originalData = Object.fromEntries(formData);
        }

        function enableEditing() {
            isEditing = true;
            const inputs = document.querySelectorAll('#businessInfoForm input, #businessInfoForm textarea');
            const editButton = document.querySelector('.section-header .btn');
            const formActions = document.getElementById('formActions');

            inputs.forEach(input => {
                input.disabled = false;
                input.classList.add('editing');
            });

            editButton.style.display = 'none';
            formActions.style.display = 'flex';

            inputs[0].focus();
        }

        function cancelEditing() {
            isEditing = false;
            const inputs = document.querySelectorAll('#businessInfoForm input, #businessInfoForm textarea');
            const editButton = document.querySelector('.section-header .btn');
            const formActions = document.getElementById('formActions');

            inputs.forEach(input => {
                input.value = originalData[input.name];
                input.disabled = true;
                input.classList.remove('editing');
            });

            editButton.style.display = 'inline-block';
            formActions.style.display = 'none';

            updatePreview();
        }

        function updatePreview() {
            document.getElementById('previewName').textContent = document.getElementById('businessName').value;
            document.getElementById('previewAddress').textContent = document.getElementById('businessAddress').value;
            document.getElementById('previewEmail').textContent = document.getElementById('businessEmail').value;
            document.getElementById('previewPhone').textContent = document.getElementById('businessPhone').value;
            document.getElementById('previewWeekday').textContent = `Mon – Sat, ${document.getElementById('weekdayHours').value}`;
            document.getElementById('previewWeekend').textContent = `Sun & Holidays, ${document.getElementById('weekendHours').value}`;
        }

        document.getElementById('businessInfoForm').addEventListener('input', function(e) {
            if (isEditing) {
                updatePreview();
            }
        });
    </script>
</body>
</html>