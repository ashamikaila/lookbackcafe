<?php
session_start();
require_once 'config/db.php';
require_once 'config/security.php';

// Configure secure session
configure_secure_session();

// Check if admin is logged in
require_auth('admin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Menu Management</title>
    <link rel="stylesheet" href="../resources/css/admindash.css">
    <link rel="stylesheet" href="../resources/css/menu-management.css">
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
                    <li class="active"><a href="menumanagement.php">Menu Management</a></li>
                    <li><a href="photowall.php">Photo Wall</a></li>
                    <li><a href="special.php">Special Offers</a></li>
                    <li><a href="newsletter.php">Newsletter</a></li>
                    <li><a href="analytics.php">Analytics</a></li>
                    <li><a href="user-accounts.php">User Accounts</a></li>
                    <li><a href="business-info.php">Business Info</a></li>
                    <li><a href="auth/logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header class="admin-header">
                <h1>Menu Management</h1>
                <div class="user-info">
                    <span>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                </div>
            </header>

            <!-- Category Navigation -->
            <div class="category-nav">
                <div class="category-tabs">
                    <button class="category-tab active" data-category="espresso">Espresso</button>
                    <button class="category-tab" data-category="viet">Vietnamese</button>
                    <button class="category-tab" data-category="noncoffee">Non-Coffee</button>
                    <button class="category-tab" data-category="rice">Rice Meals</button>
                    <button class="category-tab" data-category="hs">House Specials</button>
                    <button class="category-tab" data-category="milkshake">Milkshakes</button>
                    <button class="category-tab" data-category="soda">Sodas</button>
                    <button class="category-tab" data-category="snacks">Snacks</button>
                    <button class="category-tab" data-category="waffles">Waffles</button>
                </div>
            </div>

            <!-- Add New Product Button -->
            <div class="section-header">
                <h2 id="currentCategory">Espresso Drinks</h2>
                <button class="btn btn-primary" onclick="openAddProductModal()">
                    <i class="fas fa-plus"></i> Add New Product
                </button>
            </div>

            <!-- Products Grid -->
            <div class="products-grid" id="productsGrid">
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div id="addProductModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add New Product</h3>
                <button type="button" class="btn-close" onclick="closeAddProductModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="addProductForm" class="product-form">
                    <div class="form-group">
                        <label for="productName">Product Name</label>
                        <input type="text" id="productName" name="productName" required>
                    </div>
                    <div class="form-group">
                        <label for="productCategory">Category</label>
                        <select id="productCategory" name="productCategory" required>
                            <option value="espresso">Espresso</option>
                            <option value="viet">Vietnamese</option>
                            <option value="noncoffee">Non-Coffee</option>
                            <option value="rice">Rice Meals</option>
                            <option value="hs">House Specials</option>
                            <option value="milkshake">Milkshakes</option>
                            <option value="soda">Sodas</option>
                            <option value="snacks">Snacks</option>
                            <option value="waffles">Waffles</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="productImage">Product Image URL</label>
                        <input type="text" id="productImage" name="productImage" placeholder="../resources/img/MENU/CATEGORY/image.jpg">
                        <small>Enter the image path relative to your project</small>
                    </div>
                    <div class="price-sections">
                        <h4>Pricing</h4>
                        <div class="price-inputs">
                            <div class="price-input-group">
                                <label>16 OZ</label>
                                <input type="number" name="price_16oz" placeholder="Price">
                            </div>
                            <div class="price-input-group">
                                <label>UPSIZE</label>
                                <input type="number" name="price_upsize" placeholder="Price">
                            </div>
                            <div class="price-input-group">
                                <label>1 LITER</label>
                                <input type="number" name="price_1liter" placeholder="Price">
                            </div>
                            <div class="price-input-group">
                                <label>HOT</label>
                                <input type="number" name="price_hot" placeholder="Price">
                            </div>
                            <div class="price-input-group">
                                <label>500ml</label>
                                <input type="number" name="price_500ml" placeholder="Price">
                            </div>
                            <div class="price-input-group">
                                <label>Regular</label>
                                <input type="number" name="price_regular" placeholder="Price">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeAddProductModal()">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="addNewProduct()">Add Product</button>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
<div id="editProductModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit Product</h3>
                <button type="button" class="btn-close" onclick="closeEditProductModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editProductForm" class="product-form">
                    <input type="hidden" id="editProductId" name="productId">
                    <div class="form-group">
                        <label for="editProductName">Product Name</label>
                        <input type="text" id="editProductName" name="productName" required>
                    </div>
                    <div class="form-group">
                        <label for="editProductCategory">Category</label>
                        <select id="editProductCategory" name="productCategory" required disabled>
                            <option value="espresso">Espresso</option>
                            <option value="viet">Vietnamese</option>
                            <option value="noncoffee">Non-Coffee</option>
                            <option value="rice">Rice Meals</option>
                            <option value="hs">House Specials</option>
                            <option value="milkshake">Milkshakes</option>
                            <option value="soda">Sodas</option>
                            <option value="snacks">Snacks</option>
                            <option value="waffles">Waffles</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editProductImage">Product Image URL</label>
                        <input type="text" id="editProductImage" name="productImage">
                        <small>Current image: <span id="currentImagePath"></span></small>
                    </div>
                    <div class="price-sections">
                        <h4>Pricing</h4>
                        <div class="price-inputs">
                            <div class="price-input-group">
                                <label>16 OZ</label>
                                <input type="number" id="editPrice16oz" name="price_16oz" placeholder="Price">
                            </div>
                            <div class="price-input-group">
                                <label>UPSIZE</label>
                                <input type="number" id="editPriceUpsize" name="price_upsize" placeholder="Price">
                            </div>
                            <div class="price-input-group">
                                <label>1 LITER</label>
                                <input type="number" id="editPrice1liter" name="price_1liter" placeholder="Price">
                            </div>
                            <div class="price-input-group">
                                <label>HOT</label>
                                <input type="number" id="editPriceHot" name="price_hot" placeholder="Price">
                            </div>
                            <div class="price-input-group">
                                <label>500ml</label>
                                <input type="number" id="editPrice500ml" name="price_500ml" placeholder="Price">
                            </div>
                            <div class="price-input-group">
                                <label>Regular</label>
                                <input type="number" id="editPriceRegular" name="price_regular" placeholder="Price">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeEditProductModal()">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveProductChanges()">Save Changes</button>
            </div>
        </div>
    </div>

    <script src="../resources/js/menu-management.js"></script>
</body>
</html>