<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Business Information</title>
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
                    <li><a href="user-accounts.php">User Accounts</a></li>
                    <li class="active"><a href="business-info.php">Business Info</a></li>
                    <li><a href="#">Logout</a></li>
                </ul>
            </nav>
        </div>

         <!-- Main Content -->
        <div class="main-content">
            <header class="admin-header">
                <h1>Business Information</h1>
                <div class="user-info">
                    <span>Welcome, Admin</span>
                </div>
            </header>

            <!-- Business Information Section -->
            <div class="business-section">
                <div class="section-header">
                    <h2>Contact Information</h2>
                    <button class="btn btn-primary" onclick="enableEditing()">
                        <i class="fas fa-edit"></i> Edit Information
                    </button>
                </div>

                <form id="businessInfoForm" class="business-form">
                    <!-- Business Details -->
                    <div class="form-section">
                        <h3>Business Details</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="businessName">Business Name</label>
                                <input type="text" id="businessName" name="businessName" value="Look Back Café" disabled>
                            </div>
                            <div class="form-group">
                                <label for="businessEmail">Email Address</label>
                                <input type="email" id="businessEmail" name="businessEmail" value="lookbackcafe.25@gmail.com" disabled>
                            </div>
                            <div class="form-group">
                                <label for="businessPhone">Phone Number</label>
                                <input type="tel" id="businessPhone" name="businessPhone" value="+63 939 4716 012" disabled>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="form-section">
                        <h3>Address</h3>
                        <div class="form-group full-width">
                            <label for="businessAddress">Full Address</label>
                            <textarea id="businessAddress" name="businessAddress" rows="3" disabled>In front of CEU Malolos Gate 3, MacArthur Highway, Longos, Malolos, Philippines</textarea>
                        </div>
                        <div class="form-group full-width">
                            <label for="googleMapsLink">Google Maps Link</label>
                            <input type="url" id="googleMapsLink" name="googleMapsLink" value="https://maps.app.goo.gl/SVh5K9ZCcPvUCnJm7" disabled>
                        </div>
                    </div>

                    <!-- Store Hours -->
                    <div class="form-section">
                        <h3>Store Hours</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="weekdayHours">Weekday Hours (Mon-Sat)</label>
                                <input type="text" id="weekdayHours" name="weekdayHours" value="8:00 AM – 8:00 PM" disabled>
                            </div>
                            <div class="form-group">
                                <label for="weekendHours">Weekend Hours (Sun & Holidays)</label>
                                <input type="text" id="weekendHours" name="weekendHours" value="10:00 AM – 8:00 PM" disabled>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media Links -->
                    <div class="form-section">
                        <h3>Social Media</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="facebookLink">
                                    <i class="fab fa-facebook" style="color: #1877f2;"></i> Facebook
                                </label>
                                <input type="url" id="facebookLink" name="facebookLink" value="https://www.facebook.com/lookbackcafe/" disabled>
                            </div>
                            <div class="form-group">
                                <label for="instagramLink">
                                    <i class="fab fa-instagram" style="color: #e4405f;"></i> Instagram
                                </label>
                                <input type="url" id="instagramLink" name="instagramLink" value="https://www.instagram.com/lookbackcafe/" disabled>
                            </div>
                            <div class="form-group">
                                <label for="tiktokLink">
                                    <i class="fab fa-tiktok" style="color: #000000;"></i> TikTok
                                </label>
                                <input type="url" id="tiktokLink" name="tiktokLink" value="https://www.tiktok.com/@lookbackcafe" disabled>
                            </div>
                        </div>
                    </div>

                    <!-- Google Maps Embed -->
                    <div class="form-section">
                        <h3>Google Maps Embed</h3>
                        <div class="form-group full-width">
                            <label for="mapsEmbed">Maps Embed Code</label>
                            <textarea id="mapsEmbed" name="mapsEmbed" rows="4" disabled>&lt;iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3856.2099929974647!2d120.79826227574453!3d14.869531670434611!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339651beb9a91c99%3A0x37ab9eef1b7b16c8!2sLook%20Back%20Caf%C3%A9!5e0!3m2!1sen!2sph!4v1763465378566!5m2!1sen!2sph" allowfullscreen="" loading="lazy"&gt;&lt;/iframe&gt;</textarea>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions" id="formActions" style="display: none;">
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
                                <strong>Business Name:</strong> <span id="previewName">Look Back Café</span>
                            </div>
                            <div class="preview-item">
                                <strong>Address:</strong> <span id="previewAddress">In front of CEU Malolos Gate 3, MacArthur Highway, Longos, Malolos, Philippines</span>
                            </div>
                            <div class="preview-item">
                                <strong>Email:</strong> <span id="previewEmail">lookbackcafe.25@gmail.com</span>
                            </div>
                            <div class="preview-item">
                                <strong>Phone:</strong> <span id="previewPhone">+63 939 4716 012</span>
                            </div>
                            <div class="preview-item">
                                <strong>Store Hours:</strong> 
                                <span id="previewWeekday">Mon – Sat, 8AM – 8PM</span><br>
                                <span id="previewWeekend">Sun & Holidays, 10AM – 8PM</span>
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

        document.getElementById('businessInfoForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (isEditing) {
                const formData = new FormData(this);
                const data = Object.fromEntries(formData);
                
                console.log('Saving business info:', data);
                
                setTimeout(() => {
                    alert('Business information updated successfully! Changes will be reflected on the contact page.');
                    saveOriginalData();
                    cancelEditing();
                    updatePreview();
                }, 1000);
            }
        });

        document.getElementById('businessInfoForm').addEventListener('input', function(e) {
            if (isEditing) {
                updatePreview();
            }
        });
    </script>
</body>
</html>