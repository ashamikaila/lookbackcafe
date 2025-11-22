<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Special Offers - Look Back Café</title>
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
                    <li class="active"><a href="special.php">Special Offers</a></li>
                    <li><a href="newsletter.php">Newsletter</a></li>
                    <li><a href="analytics.php">Analytics</a></li>
                    <li><a href="user-accounts.php">User Accounts</a></li>
                    <li><a href="business-info.php">Business Info</a></li>
                    <li><a href="#">Logout</a></li>
                </ul>
            </nav>
        </div>

        <div class="main-content">
            <header class="admin-header">
                <h1>Special Offers Management</h1>
                <div class="user-info">
                    <span>Welcome, Admin</span>
                </div>
            </header>

            <!-- Title Editor -->
            <div class="title-section">
                <div class="section-header">
                    <h2>Special Offers Title</h2>
                    <button class="btn btn-primary" onclick="saveTitle()">
                        Save Title
                    </button>
                </div>
                
                <div class="title-editor">
                    <input type="text" id="titleText" class="title-input" value="SPECIAL OFFERS" placeholder="Enter special offers title...">
                    <div class="title-preview">
                        <h3>Preview:</h3>
                        <div class="preview-title" id="titlePreview">SPECIAL OFFERS</div>
                    </div>
                </div>
            </div>

            <!-- Current Special Offers -->
            <div class="offers-section">
                <div class="section-header">
                    <h2>Current Special Offers</h2>
                    <button class="btn btn-primary" onclick="openUploadModal()">
                        Upload New Offers
                    </button>
                </div>

                <div class="current-offers">
                    <div class="offers-grid" id="offersGrid">
                        <!-- Offers will be loaded here dynamically -->
                        <div class="offer-item">
                            <div class="offer-container">
                                <img src="../resources/img/HOMEPAGE/monthlyspecials/special1.jpg" alt="Special Offer 1">
                                <div class="offer-overlay">
                                    <button class="btn btn-sm btn-delete" onclick="deleteOffer(1)">Delete</button>
                                    <span class="offer-number">Offer 1</span>
                                </div>
                            </div>
                        </div>
                        <div class="offer-item">
                            <div class="offer-container">
                                <img src="../resources/img/HOMEPAGE/monthlyspecials/special2.png" alt="Special Offer 2">
                                <div class="offer-overlay">
                                    <button class="btn btn-sm btn-delete" onclick="deleteOffer(2)">Delete</button>
                                    <span class="offer-number">Offer 2</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="offers-info">
                    <p><strong>Current Setup:</strong> 2 special offer images displayed side by side</p>
                    <p><strong>File Pattern:</strong> special1.jpg, special2.png</p>
                    <p><strong>Location:</strong> ../resources/img/HOMEPAGE/monthlyspecials/</p>
                    <p><strong>Note:</strong> You can have 1-2 special offers displayed at a time</p>
                </div>
            </div>

            <!-- Preview Section -->
            <div class="preview-section">
                <h2>Live Preview</h2>
                <div class="preview-container">
                    <div class="preview-title-display">
                        <h1 id="previewTitleText">SPECIAL OFFERS</h1>
                    </div>
                    <div class="preview-offers">
                        <div class="special-preview">
                            <img src="../resources/img/HOMEPAGE/monthlyspecials/special1.jpg" alt="Preview Offer 1" id="previewOffer1">
                            <img src="../resources/img/HOMEPAGE/monthlyspecials/special2.png" alt="Preview Offer 2" id="previewOffer2">
                        </div>
                    </div>
                    <p class="preview-note">This shows how the special offers will appear on main.php</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Modal -->
    <div id="uploadModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Upload New Special Offers</h3>
                <button class="btn-close" onclick="closeUploadModal()">×</button>
            </div>
            <form id="uploadForm">
                <div class="form-group">
                    <label>Select Special Offer Images</label>
                    <input type="file" id="offerUpload" name="offers[]" multiple accept="image/*" onchange="previewUploads(this)">
                    <small>You can upload 1-2 images. First image will be Offer 1, second will be Offer 2.</small>
                </div>

                <div class="upload-preview" id="uploadPreview">
                    <p>No images selected</p>
                </div>

                <div class="upload-options">
                    <h4>Upload Options</h4>
                    <div class="option-group">
                        <label>
                            <input type="radio" name="uploadMethod" value="replace" checked> 
                            Replace all existing offers
                        </label>
                        <label>
                            <input type="radio" name="uploadMethod" value="replace1"> 
                            Replace only Offer 1
                        </label>
                        <label>
                            <input type="radio" name="uploadMethod" value="replace2"> 
                            Replace only Offer 2
                        </label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeUploadModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload Offers</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentOffers = 2; // Current number of offers

        // Title functionality
        function updateTitlePreview() {
            const titleText = document.getElementById('titleText').value;
            document.getElementById('titlePreview').textContent = titleText;
            document.getElementById('previewTitleText').textContent = titleText;
        }

        function saveTitle() {
            const titleText = document.getElementById('titleText').value;
            const saveBtn = document.querySelector('.title-section .btn-primary');
            
            if (!titleText.trim()) {
                alert('Please enter a title.');
                return;
            }

            // Show saving state
            saveBtn.innerHTML = 'Saving...';
            saveBtn.disabled = true;

            // Simulate saving to server
            setTimeout(() => {
                alert('Title saved successfully!');
                saveBtn.innerHTML = 'Save Title';
                saveBtn.disabled = false;
                
                // Update preview
                updateTitlePreview();
            }, 1000);
        }

        function openUploadModal() {
            document.getElementById('uploadModal').style.display = 'flex';
            document.getElementById('uploadPreview').innerHTML = '<p>No images selected</p>';
        }

        function closeUploadModal() {
            document.getElementById('uploadModal').style.display = 'none';
            document.getElementById('uploadForm').reset();
        }

        function previewUploads(input) {
            const preview = document.getElementById('uploadPreview');
            preview.innerHTML = '';

            if (input.files.length > 0) {
                const fileList = document.createElement('div');
                fileList.className = 'file-list';
                
                for (let i = 0; i < input.files.length; i++) {
                    const file = input.files[i];
                    const fileItem = document.createElement('div');
                    fileItem.className = 'file-item';
                    fileItem.innerHTML = `
                        <span>Offer ${i + 1}: ${file.name}</span>
                        <span class="file-size">(${Math.round(file.size / 1024)} KB)</span>
                    `;
                    fileList.appendChild(fileItem);
                }
                
                preview.appendChild(fileList);
                preview.innerHTML += `<p>Total files: ${input.files.length} (Max: 2)</p>`;
                
                if (input.files.length > 2) {
                    preview.innerHTML += `<p class="warning">Warning: Only the first 2 images will be used.</p>`;
                }
            } else {
                preview.innerHTML = '<p>No images selected</p>';
            }
        }

        function deleteOffer(offerNumber) {
            if (confirm(`Are you sure you want to delete special offer ${offerNumber}?`)) {
                // Simulate deletion
                const offerItem = document.querySelector(`.offer-item:nth-child(${offerNumber})`);
                offerItem.style.opacity = '0.5';
                offerItem.style.pointerEvents = 'none';
                
                setTimeout(() => {
                    // In real implementation, this would make an API call to delete the file
                    alert(`Special offer ${offerNumber} deleted successfully!`);
                    // Reload or update the offers grid
                    loadOffers();
                }, 1000);
            }
        }

        function loadOffers() {
            // This would load the current offers from the server
            // For now, we'll just reset the opacity
            document.querySelectorAll('.offer-item').forEach(item => {
                item.style.opacity = '1';
                item.style.pointerEvents = 'auto';
            });
        }

        // Handle form submission
        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const files = document.getElementById('offerUpload').files;
            const uploadMethod = document.querySelector('input[name="uploadMethod"]:checked').value;
            
            if (files.length === 0) {
                alert('Please select at least one image to upload.');
                return;
            }

            if (files.length > 2) {
                alert('Maximum 2 special offers allowed. Only the first 2 images will be used.');
            }

            // Show uploading state
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = 'Uploading...';
            submitBtn.disabled = true;

            // Simulate upload process
            setTimeout(() => {
                let message = `${files.length} special offer(s) uploaded successfully! `;
                
                if (uploadMethod === 'replace') {
                    message += 'All existing offers replaced.';
                } else if (uploadMethod === 'replace1') {
                    message += 'Offer 1 replaced.';
                } else if (uploadMethod === 'replace2') {
                    message += 'Offer 2 replaced.';
                }
                
                alert(message);
                closeUploadModal();
                submitBtn.innerHTML = 'Upload Offers';
                submitBtn.disabled = false;
                
                // In real implementation, this would refresh the offers grid
                loadOffers();
            }, 2000);
        });

        // Initialize special offers
        document.addEventListener('DOMContentLoaded', function() {
            loadOffers();
            
            // Set up title real-time preview
            document.getElementById('titleText').addEventListener('input', updateTitlePreview);
        });
    </script>
</body>
</html>