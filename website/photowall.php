<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Wall Management - Look Back Café</title>
    <link rel="stylesheet" href="../resources/css/admindash.css">
    <link rel="icon" type="image/jpg" href="../resources/img/favicon.jpg">
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@400;500;700;800&display=swap" rel="stylesheet">
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
                    <li class="active"><a href="photowall.php">Photo Wall</a></li>
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
                <h1>Photo Wall Management</h1>
                <div class="user-info">
                    <span>Welcome, Admin</span>
                </div>
            </header>

            <!-- Caption Editor -->
            <div class="caption-section">
                <div class="section-header">
                    <h2>Photo Wall Caption</h2>
                    <button class="btn btn-primary" onclick="saveCaption()">
                        Save Caption
                    </button>
                </div>
                
                <div class="caption-editor">
                    <textarea id="captionText" class="caption-textarea" rows="4" placeholder="Enter your photo wall caption here...">A look back at the moments that made Look Back Café special — thank you to every smile, every visit, and every memory. We're so grateful for your support!</textarea>
                    <div class="caption-preview">
                        <h3>Preview:</h3>
                        <div class="preview-caption" id="captionPreview">
                            A look back at the moments that made Look Back Café special — thank you to every smile, every visit, and every memory. We're so grateful for your support!
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Photo Wall -->
            <div class="photo-wall-section">
                <div class="section-header">
                    <h2>Current Photos</h2>
                    <button class="btn btn-primary" onclick="openUploadModal()">
                        Upload New Photos
                    </button>
                </div>

                <div class="current-photos">
                    <div class="photos-grid" id="photosGrid">
                        <!-- Photos will be loaded here dynamically -->
                        <div class="photo-item">
                            <div class="photo-container">
                                <img src="../resources/img/HOMEPAGE/photowall/photowall1.png" alt="Photo 1">
                                <div class="photo-overlay">
                                    <button class="btn btn-sm btn-delete" onclick="deletePhoto(1)">Delete</button>
                                    <span class="photo-number">1</span>
                                </div>
                            </div>
                        </div>
                        <div class="photo-item">
                            <div class="photo-container">
                                <img src="../resources/img/HOMEPAGE/photowall/photowall2.png" alt="Photo 2">
                                <div class="photo-overlay">
                                    <button class="btn btn-sm btn-delete" onclick="deletePhoto(2)">Delete</button>
                                    <span class="photo-number">2</span>
                                </div>
                            </div>
                        </div>
                        <div class="photo-item">
                            <div class="photo-container">
                                <img src="../resources/img/HOMEPAGE/photowall/photowall3.png" alt="Photo 3">
                                <div class="photo-overlay">
                                    <button class="btn btn-sm btn-delete" onclick="deletePhoto(3)">Delete</button>
                                    <span class="photo-number">3</span>
                                </div>
                            </div>
                        </div>
                        <div class="photo-item">
                            <div class="photo-container">
                                <img src="../resources/img/HOMEPAGE/photowall/photowall4.png" alt="Photo 4">
                                <div class="photo-overlay">
                                    <button class="btn btn-sm btn-delete" onclick="deletePhoto(4)">Delete</button>
                                    <span class="photo-number">4</span>
                                </div>
                            </div>
                        </div>
                        <div class="photo-item">
                            <div class="photo-container">
                                <img src="../resources/img/HOMEPAGE/photowall/photowall5.png" alt="Photo 5">
                                <div class="photo-overlay">
                                    <button class="btn btn-sm btn-delete" onclick="deletePhoto(5)">Delete</button>
                                    <span class="photo-number">5</span>
                                </div>
                            </div>
                        </div>
                        <div class="photo-item">
                            <div class="photo-container">
                                <img src="../resources/img/HOMEPAGE/photowall/photowall6.png" alt="Photo 6">
                                <div class="photo-overlay">
                                    <button class="btn btn-sm btn-delete" onclick="deletePhoto(6)">Delete</button>
                                    <span class="photo-number">6</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="photo-info">
                    <p><strong>File Pattern:</strong> photowall1.png, photowall2.png, ..., photowall6.png</p>
                    <p><strong>Location:</strong> ../resources/img/HOMEPAGE/photowall/</p>
                </div>
            </div>

            <!-- Preview Section -->
            <div class="preview-section">
                <h2>Live Preview</h2>
                <div class="preview-container">
                    <div class="preview-caption-display">
                        <h1 id="previewCaptionText">A look back at the moments that made Look Back Café special — thank you to every smile, every visit, and every memory. We're so grateful for your support!</h1>
                    </div>
                    <div class="preview-scroll">
                        <div class="scrolling-gallery-preview">
                            <!-- Preview images will be duplicated here for scrolling effect -->
                            <div class="preview-image-item">
                                <img src="../resources/img/HOMEPAGE/photowall/photowall1.png" alt="Preview 1">
                            </div>
                            <div class="preview-image-item">
                                <img src="../resources/img/HOMEPAGE/photowall/photowall2.png" alt="Preview 2">
                            </div>
                            <div class="preview-image-item">
                                <img src="../resources/img/HOMEPAGE/photowall/photowall3.png" alt="Preview 3">
                            </div>
                            <div class="preview-image-item">
                                <img src="../resources/img/HOMEPAGE/photowall/photowall4.png" alt="Preview 4">
                            </div>
                            <div class="preview-image-item">
                                <img src="../resources/img/HOMEPAGE/photowall/photowall5.png" alt="Preview 5">
                            </div>
                            <div class="preview-image-item">
                                <img src="../resources/img/HOMEPAGE/photowall/photowall6.png" alt="Preview 6">
                            </div>
                        </div>
                    </div>
                    <p class="preview-note">This photo wall will be updated weekly.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Modal -->
    <div id="uploadModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Upload New Photos</h3>
                <button class="btn-close" onclick="closeUploadModal()">×</button>
            </div>
            <form id="uploadForm">
                <div class="form-group">
                    <label>Select Photos to Upload</label>
                    <input type="file" id="photoUpload" name="photos[]" multiple accept="image/*" onchange="previewUploads(this)">
                </div>

                <div class="upload-preview" id="uploadPreview">
                    <p>No photos selected</p>
                </div>

                <div class="upload-options">
                    <h4>Upload Options</h4>
                    <div class="option-group">
                        <label>
                            <input type="radio" name="uploadMethod" value="replace" checked> 
                            Replace existing photos
                        </label>
                        <label>
                            <input type="radio" name="uploadMethod" value="add"> 
                            Add to existing photos
                        </label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeUploadModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload Photos</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentPhotos = 6; // Current number of photos

        // Caption functionality
        function updateCaptionPreview() {
            const captionText = document.getElementById('captionText').value;
            document.getElementById('captionPreview').textContent = captionText;
            document.getElementById('previewCaptionText').textContent = captionText;
        }

        function saveCaption() {
            const captionText = document.getElementById('captionText').value;
            const saveBtn = document.querySelector('.caption-section .btn-primary');
            
            if (!captionText.trim()) {
                alert('Please enter a caption.');
                return;
            }

            // Show saving state
            saveBtn.innerHTML = 'Saving...';
            saveBtn.disabled = true;

            // Simulate saving to server
            setTimeout(() => {
                alert('Caption saved successfully!');
                saveBtn.innerHTML = 'Save Caption';
                saveBtn.disabled = false;
                
                // Update preview
                updateCaptionPreview();
            }, 1000);
        }

        function openUploadModal() {
            document.getElementById('uploadModal').style.display = 'flex';
            document.getElementById('uploadPreview').innerHTML = '<p>No photos selected</p>';
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
                        <span>${file.name}</span>
                        <span class="file-size">(${Math.round(file.size / 1024)} KB)</span>
                    `;
                    fileList.appendChild(fileItem);
                }
                
                preview.appendChild(fileList);
                preview.innerHTML += `<p>Total files: ${input.files.length}</p>`;
            } else {
                preview.innerHTML = '<p>No photos selected</p>';
            }
        }

        function deletePhoto(photoNumber) {
            if (confirm(`Are you sure you want to delete photo ${photoNumber}? This will remove it from the photo wall.`)) {
                // Simulate deletion
                const photoItem = document.querySelector(`.photo-item:nth-child(${photoNumber})`);
                photoItem.style.opacity = '0.5';
                photoItem.style.pointerEvents = 'none';
                
                setTimeout(() => {
                    // In real implementation, this would make an API call to delete the file
                    alert(`Photo ${photoNumber} deleted successfully!`);
                    // Reload or update the photo grid
                    loadPhotos();
                }, 1000);
            }
        }

        function loadPhotos() {
            // This would load the current photos from the server
            // For now, we'll just reset the opacity
            document.querySelectorAll('.photo-item').forEach(item => {
                item.style.opacity = '1';
                item.style.pointerEvents = 'auto';
            });
        }

        // Handle form submission
        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const files = document.getElementById('photoUpload').files;
            const uploadMethod = document.querySelector('input[name="uploadMethod"]:checked').value;
            
            if (files.length === 0) {
                alert('Please select at least one photo to upload.');
                return;
            }

            // Show uploading state
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = 'Uploading...';
            submitBtn.disabled = true;

            // Simulate upload process
            setTimeout(() => {
                alert(`${files.length} photos uploaded successfully! ${uploadMethod === 'replace' ? 'Existing photos replaced.' : 'Photos added to gallery.'}`);
                closeUploadModal();
                submitBtn.innerHTML = 'Upload Photos';
                submitBtn.disabled = false;
                
                // In real implementation, this would refresh the photo grid
                loadPhotos();
            }, 2000);
        });

        // Initialize photo wall
        document.addEventListener('DOMContentLoaded', function() {
            loadPhotos();
            
            // Set up caption real-time preview
            document.getElementById('captionText').addEventListener('input', updateCaptionPreview);
        });
    </script>
</body>
</html>