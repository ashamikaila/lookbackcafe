// Menu data will be loaded from database
let menuData = {};

// Fetch menu data from database
async function loadMenuDataFromDB() {
    try {
        console.log('Fetching menu data from API...');
        const response = await fetch('api/menu-items.php');
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const items = await response.json();
        console.log('API Response:', items);
        console.log('Number of items loaded:', items.length);
        
        // Group items by category
        menuData = {};
        items.forEach(item => {
            if (!menuData[item.category]) {
                menuData[item.category] = [];
            }
            menuData[item.category].push(item);
        });
        
        console.log('Menu data grouped by category:', menuData);
        console.log('Categories loaded:', Object.keys(menuData));
        
        // Load the current category
        loadProducts(currentCategory);
    } catch (error) {
        console.error('Error loading menu data:', error);
        console.log('Falling back to hardcoded data...');
        // Fallback to hardcoded data if database fails
        loadFallbackData();
    }
}

// Fallback data in case database is not available
function loadFallbackData() {
    menuData = {
        espresso: [
            {
                id: 1,
                name: "Affogato",
                image: "../resources/img/MENU/ESPRESSO/affogato.jpg",
                prices: { "16oz": 145 }
            },
        {
            id: 2,
            name: "Spanish Latte",
            image: "../resources/img/MENU/ESPRESSO/spanishlatte.jpg",
            prices: { "hot": 150, "16oz": 130, "upsize": 150, "1liter": 210 }
        },
        {
            id: 3,
            name: "Breve Latte",
            image: "../resources/img/MENU/ESPRESSO/brevelatte.jpg",
            prices: { "hot": 140, "16oz": 160, "upsize": 160, "1liter": 270 }
        },
        {
            id: 4,
            name: "White Chocolate Mocha",
            image: "../resources/img/MENU/ESPRESSO/wcmocha.jpg",
            prices: { "hot": 140, "16oz": 160, "upsize": 160, "1liter": 270 }
        },
        {
            id: 5,
            name: "Signature Blend",
            image: "../resources/img/MENU/ESPRESSO/sigblend.jpg",
            prices: { "16oz": 180, "upsize": 180, "1liter": 300 }
        },
        {
            id: 6,
            name: "Dirty Matcha",
            image: "../resources/img/MENU/ESPRESSO/dirtymatcha.jpg",
            prices: { "hot": 140, "16oz": 160, "upsize": 160, "1liter": 270 }
        },
        {
            id: 7,
            name: "Mocha",
            image: "../resources/img/MENU/ESPRESSO/mocha.jpg",
            prices: { "hot": 130, "16oz": 150, "upsize": 150, "1liter": 250 }
        },
        {
            id: 8,
            name: "Caramel Latte",
            image: "../resources/img/MENU/ESPRESSO/caramellatte.jpg",
            prices: { "hot": 130, "16oz": 150, "upsize": 150, "1liter": 250 }
        },
        {
            id: 9,
            name: "Latte",
            image: "../resources/img/MENU/ESPRESSO/latte.jpg",
            prices: { "hot": 120, "16oz": 140, "upsize": 140, "1liter": 230 }
        },
        {
            id: 10,
            name: "Americano",
            image: "../resources/img/MENU/ESPRESSO/americano.jpg",
            prices: { "hot": 110, "16oz": 130, "upsize": 130, "1liter": 210 }
        }
    ],
    viet: [
        {
            id: 1,
            name: "Caramel Vietnamese",
            image: "../resources/img/MENU/VIET/caramel.jpg",
            prices: { "16oz": 95, "upsize": 115 }
        },
        {
            id: 2,
            name: "Silver Coffee",
            image: "../resources/img/MENU/VIET/silver.jpg",
            prices: { "16oz": 110, "upsize": 130, "1liter": 210 }
        },
        {
            id: 3,
            name: "Egg Coffee",
            image: "../resources/img/MENU/VIET/egg.jpg",
            prices: { "16oz": 130, "upsize": 150, "1liter": 250 }
        },
        {
            id: 4,
            name: "Iced Coffee Milk",
            image: "../resources/img/MENU/VIET/icedcoffee.jpg",
            prices: { "16oz": 95, "upsize": 115, "1liter": 180 }
        },
        {
            id: 5,
            name: "Salt Coffee",
            image: "../resources/img/MENU/VIET/salt.jpg",
            prices: { "16oz": 130, "upsize": 150, "1liter": 250 }
        }
    ],
    noncoffee: [
        {
            id: 1,
            name: "Berry Matcha",
            image: "../resources/img/MENU/NONCOFFEE/berrymatcha.jpg",
            prices: { "hot": 140, "16oz": 150, "1liter": 270 }
        },
        {
            id: 2,
            name: "Brown Sugar Milk",
            image: "../resources/img/MENU/NONCOFFEE/brownsugar.jpg",
            prices: { "hot": 120, "16oz": 130, "upsize": 130, "1liter": 230 }
        },
        {
            id: 3,
            name: "Choco Berry",
            image: "../resources/img/MENU/NONCOFFEE/chocoberry.jpg",
            prices: { "hot": 140, "16oz": 150, "1liter": 270 }
        },
        {
            id: 4,
            name: "Chocolate Milk",
            image: "../resources/img/MENU/NONCOFFEE/chocolate.jpg",
            prices: { "hot": 120, "16oz": 130, "upsize": 130, "1liter": 230 }
        },
        {
            id: 5,
            name: "Matcha",
            image: "../resources/img/MENU/NONCOFFEE/matcha.jpg",
            prices: { "hot": 120, "16oz": 130, "upsize": 130, "1liter": 230 }
        },
        {
            id: 6,
            name: "Strawberry Milk",
            image: "../resources/img/MENU/NONCOFFEE/strawberry.jpg",
            prices: { "hot": 120, "16oz": 130, "1liter": 230 }
        }
    ],
    rice: [
        {
            id: 1,
            name: "BBQ Rice Meal",
            image: "../resources/img/MENU/RICEMEAL/bbq.jpg",
            prices: { "regular": 160 }
        },
        {
            id: 2,
            name: "Chicken Rice Meal",
            image: "../resources/img/MENU/RICEMEAL/chicken.jpg",
            prices: { "regular": 150 }
        },
        {
            id: 3,
            name: "Garlic Rice Meal",
            image: "../resources/img/MENU/RICEMEAL/garlic.jpg",
            prices: { "regular": 160 }
        },
        {
            id: 4,
            name: "Ham Rice Meal",
            image: "../resources/img/MENU/RICEMEAL/ham.jpg",
            prices: { "regular": 130 }
        },
        {
            id: 5,
            name: "Hotdog Rice Meal",
            image: "../resources/img/MENU/RICEMEAL/hotdog.jpg",
            prices: { "regular": 100 }
        },
        {
            id: 6,
            name: "Maple Rice Meal",
            image: "../resources/img/MENU/RICEMEAL/maple.jpg",
            prices: { "regular": 150 }
        },
        {
            id: 7,
            name: "Sausilog Rice Meal",
            image: "../resources/img/MENU/RICEMEAL/sausilog.jpg",
            prices: { "regular": 125 }
        },
        {
            id: 8,
            name: "Sriracha Rice Meal",
            image: "../resources/img/MENU/RICEMEAL/sriracha.jpg",
            prices: { "regular": 130 }
        },
        {
            id: 9,
            name: "Tapa Rice Meal",
            image: "../resources/img/MENU/RICEMEAL/tapa.jpg",
            prices: { "regular": 100 }
        },
        {
            id: 10,
            name: "Tocino Rice Meal",
            image: "../resources/img/MENU/RICEMEAL/tocino.jpg",
            prices: { "regular": 90 }
        }
    ],
    hs: [
        {
            id: 1,
            name: "House Specials",
            image: "../resources/img/MENU/HOUSE SPECIALS/housespecial.png",
            prices: { "regular": 0 }
        }
    ],
    milkshake: [
        {
            id: 1,
            name: "Biscoff Caramel Milkshake",
            image: "../resources/img/MENU/MILKSHAKE/biscoff.jpg",
            prices: { "500ml": 180 }
        },
        {
            id: 2,
            name: "Avocado Milkshake",
            image: "../resources/img/MENU/MILKSHAKE/avo.jpg",
            prices: { "500ml": 180 }
        },
        {
            id: 3,
            name: "Dark Chocolate Milkshake",
            image: "../resources/img/MENU/MILKSHAKE/dc.jpg",
            prices: { "500ml": 180 }
        },
        {
            id: 4,
            name: "Cookies and Cream Milkshake",
            image: "../resources/img/MENU/MILKSHAKE/cnc.jpg",
            prices: { "500ml": 180 }
        }
    ],
    soda: [
        {
            id: 1,
            name: "Blueberry Soda",
            image: "../resources/img/MENU/SODA/blueberry.jpg",
            prices: { "16oz": 130, "upsize": 150, "1liter": 250 }
        },
        {
            id: 2,
            name: "Green Apple Soda",
            image: "../resources/img/MENU/SODA/green.jpg",
            prices: { "16oz": 130, "upsize": 150, "1liter": 250 }
        },
        {
            id: 3,
            name: "Lemon Soda",
            image: "../resources/img/MENU/SODA/lemon.jpg",
            prices: { "16oz": 130, "upsize": 150, "1liter": 250 }
        },
        {
            id: 4,
            name: "Lychee Soda",
            image: "../resources/img/MENU/SODA/lychee.jpg",
            prices: { "16oz": 130, "upsize": 150, "1liter": 250 }
        },
        {
            id: 5,
            name: "Strawberry Soda",
            image: "../resources/img/MENU/SODA/strawberry.jpg",
            prices: { "16oz": 130, "upsize": 150, "1liter": 230 }
        }
    ],
    snacks: [
        {
            id: 1,
            name: "Four Cheese Quesadilla",
            image: "../resources/img/MENU/SNACK/4c.jpg",
            prices: { "regular": 160 }
        },
        {
            id: 2,
            name: "Beef Quesadilla",
            image: "../resources/img/MENU/SNACK/beef.jpg",
            prices: { "regular": 150 }
        },
        {
            id: 3,
            name: "Cheesy Bacon Fries",
            image: "../resources/img/MENU/SNACK/cheesy.jpg",
            prices: { "regular": 160 }
        },
        {
            id: 4,
            name: "Plain Fries",
            image: "../resources/img/MENU/SNACK/fries.png",
            prices: { "regular": 130 }
        }
    ],
    waffles: [
        {
            id: 1,
            name: "Biscoff Caramel Waffle",
            image: "../resources/img/MENU/WAFFLE/biscoff.jpg",
            prices: { "regular": 100 }
        },
        {
            id: 2,
            name: "Chicken & Waffle",
            image: "../resources/img/MENU/WAFFLE/chicken.jpg",
            prices: { "regular": 150 }
        },
        {
            id: 3,
            name: "Ham & Cheese Waffle",
            image: "../resources/img/MENU/WAFFLE/hnc.jpg",
            prices: { "regular": 125 }
        },
        {
            id: 4,
            name: "Ham & Egg Waffle", 
            image: "../resources/img/MENU/WAFFLE/hne.jpg",
            prices: { "regular": 130 }
        },
        {
            id: 5,
            name: "Nutella Almond Waffle",
            image: "../resources/img/MENU/WAFFLE/nutella.jpg",
            prices: { "regular": 100 }
        },
        {
            id: 6,
            name: "Plain Waffle",
            image: "../resources/img/MENU/WAFFLE/plain.jpg",
            prices: { "regular": 45 }
        },
        {
            id: 7,
            name: "Creamy Spinach Waffle",
            image: "../resources/img/MENU/WAFFLE/spinach.jpg",
            prices: { "regular": 100 }
        },
        {
            id: 8,
            name: "Strawberry and Cream Waffle",
            image: "../resources/img/MENU/WAFFLE/strawberrry.jpg",
            prices: { "regular": 90 }
        }
        ],
    };
    loadProducts(currentCategory);
}

// Category display names
const categoryNames = {
    espresso: "Espresso Drinks",
    viet: "Vietnamese Coffee",
    noncoffee: "Non-Coffee Drinks",
    rice: "Rice Meals",
    hs: "House Specials",
    milkshake: "Milkshakes",
    soda: "Sodas",
    snacks: "Snacks",
    waffles: "Waffles"
};

let currentCategory = 'espresso';

// Function to load products for a category
function loadProducts(category) {
    const productsGrid = document.getElementById('productsGrid');
    const currentCategoryElement = document.getElementById('currentCategory');
    
    // Update current category
    currentCategory = category;
    currentCategoryElement.textContent = categoryNames[category] || category;
    
    // Clear existing products
    productsGrid.innerHTML = '';
    
    // Get products for current category
    const products = menuData[category] || [];
    
    if (products.length === 0) {
        productsGrid.innerHTML = '<div class="no-products">No products found in this category.</div>';
        return;
    }
    
    // Create product cards
    products.forEach(product => {
        const productCard = createProductCard(product, category);
        productsGrid.appendChild(productCard);
    });
}

// Function to create a product card
function createProductCard(product, category) {
    console.log('Creating product card for:', product.name, 'ID:', product.id, 'Type:', typeof product.id);
    
    const card = document.createElement('div');
    card.className = 'product-card';
    card.innerHTML = `
        <div class="product-image">
            <img src="${product.image}" alt="${product.name}" onerror="this.src='../resources/img/placeholder.jpg'">
            <div class="image-overlay">
                <button class="btn-icon" onclick="changeProductImage(${product.id}, '${category}')">
                    <i class="fas fa-camera"></i> Change
                </button>
            </div>
        </div>
        <div class="product-info">
            <h3 class="product-name">${product.name}</h3>
            <div class="product-prices">
                ${Object.entries(product.prices).map(([size, price]) => 
                    `<div class="price-item">
                        <span class="size-label">${size.toUpperCase()}</span>
                        <span class="price">₱${price}</span>
                    </div>`
                ).join('')}
            </div>
        </div>
        <div class="product-actions">
            <button class="btn btn-edit" onclick="editProduct(${product.id}, '${category}')">
                <i class="fas fa-edit"></i> Edit
            </button>
            <button class="btn btn-delete" onclick="deleteProduct(${product.id}, '${category}')">
                <i class="fas fa-trash"></i> Delete
            </button>
        </div>
    `;
    return card;
}

// Category tab functionality
function setupCategoryTabs() {
    const tabs = document.querySelectorAll('.category-tab');
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            tabs.forEach(t => t.classList.remove('active'));
            // Add active class to clicked tab
            this.classList.add('active');
            // Load products for selected category
            const category = this.getAttribute('data-category');
            loadProducts(category);
        });
    });
}

// Modal functions
function openAddProductModal() {
    document.getElementById('addProductModal').style.display = 'flex';
}

function closeAddProductModal() {
    document.getElementById('addProductModal').style.display = 'none';
    document.getElementById('addProductForm').reset();
}

function openEditProductModal() {
    document.getElementById('editProductModal').style.display = 'flex';
}

function closeEditProductModal() {
    document.getElementById('editProductModal').style.display = 'none';
}

// Product management functions
async function addNewProduct() {
    const form = document.getElementById('addProductForm');
    const formData = new FormData(form);
    
    // Get all price values
    const prices = {};
    if (formData.get('price_16oz')) prices['16oz'] = parseFloat(formData.get('price_16oz'));
    if (formData.get('price_upsize')) prices['upsize'] = parseFloat(formData.get('price_upsize'));
    if (formData.get('price_1liter')) prices['1liter'] = parseFloat(formData.get('price_1liter'));
    if (formData.get('price_hot')) prices['hot'] = parseFloat(formData.get('price_hot'));
    if (formData.get('price_500ml')) prices['500ml'] = parseFloat(formData.get('price_500ml'));
    if (formData.get('price_regular')) prices['regular'] = parseFloat(formData.get('price_regular'));
    
    // Create new product object
    const newProduct = {
        name: formData.get('productName'),
        category: formData.get('productCategory'),
        image: formData.get('productImage') || '../resources/img/placeholder.jpg',
        prices: prices
    };
    
    try {
        // Save to database
        const response = await fetch('api/menu-items.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(newProduct)
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Reload menu data from database
            await loadMenuDataFromDB();
            closeAddProductModal();
            alert('Product added successfully!');
        } else {
            alert('Failed to add product. Please try again.');
        }
    } catch (error) {
        console.error('Error adding product:', error);
        alert('Failed to add product. Please try again.');
    }
}

function editProduct(productId, category) {
    console.log('=== EDIT PRODUCT DEBUG ===');
    console.log('Product ID:', productId, 'Type:', typeof productId);
    console.log('Category:', category);
    console.log('All menu data:', menuData);
    console.log('Category data:', menuData[category]);
    
    if (!menuData[category]) {
        console.error('Category not found:', category);
        console.log('Available categories:', Object.keys(menuData));
        alert('Error: Category "' + category + '" not found. Available categories: ' + Object.keys(menuData).join(', '));
        return;
    }
    
    console.log('Products in category:', menuData[category]);
    console.log('Looking for product with ID:', productId);
    
    // Try to find product - check both as number and string
    let product = menuData[category].find(p => p.id === productId);
    if (!product) {
        // Try with type conversion
        product = menuData[category].find(p => p.id == productId);
    }
    
    console.log('Found product:', product);
    
    if (!product) {
        console.error('Product not found with ID:', productId);
        console.log('All product IDs in category:', menuData[category].map(p => ({ id: p.id, type: typeof p.id, name: p.name })));
        alert('Error: Product not found. Product ID: ' + productId + '\nPlease check console for details.');
        return;
    }
    
    // Populate edit form
    document.getElementById('editProductId').value = productId;
    document.getElementById('editProductName').value = product.name;
    document.getElementById('editProductCategory').value = category;
    document.getElementById('editProductImage').value = product.image;
    document.getElementById('currentImagePath').textContent = product.image;
    
    // Populate prices
    document.getElementById('editPrice16oz').value = product.prices["16oz"] || '';
    document.getElementById('editPriceUpsize').value = product.prices["upsize"] || '';
    document.getElementById('editPrice1liter').value = product.prices["1liter"] || '';
    document.getElementById('editPriceHot').value = product.prices["hot"] || '';
    document.getElementById('editPrice500ml').value = product.prices["500ml"] || '';
    document.getElementById('editPriceRegular').value = product.prices["regular"] || '';
    
    console.log('Opening edit modal');
    openEditProductModal();
}

async function saveProductChanges() {
    const productId = parseInt(document.getElementById('editProductId').value);
    const category = document.getElementById('editProductCategory').value;
    
    const prices = {};
    const price16oz = document.getElementById('editPrice16oz').value;
    const priceUpsize = document.getElementById('editPriceUpsize').value;
    const price1liter = document.getElementById('editPrice1liter').value;
    const priceHot = document.getElementById('editPriceHot').value;
    const price500ml = document.getElementById('editPrice500ml').value;
    const priceRegular = document.getElementById('editPriceRegular').value;
    
    if (price16oz) prices['16oz'] = parseFloat(price16oz);
    if (priceUpsize) prices['upsize'] = parseFloat(priceUpsize);
    if (price1liter) prices['1liter'] = parseFloat(price1liter);
    if (priceHot) prices['hot'] = parseFloat(priceHot);
    if (price500ml) prices['500ml'] = parseFloat(price500ml);
    if (priceRegular) prices['regular'] = parseFloat(priceRegular);
    
    const updatedProduct = {
        id: productId,
        name: document.getElementById('editProductName').value,
        image: document.getElementById('editProductImage').value,
        category: category,
        prices: prices
    };
    
    console.log('Saving product changes:', updatedProduct);
    
    try {
        const response = await fetch('api/menu-items.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(updatedProduct)
        });
        
        console.log('Response status:', response.status);
        const result = await response.json();
        console.log('Response data:', result);
        
        if (result.success) {
            await loadMenuDataFromDB();
            closeEditProductModal();
            alert('Product updated successfully!');
        } else {
            alert('Failed to update product: ' + (result.error || 'Unknown error'));
            console.error('Server error:', result);
        }
    } catch (error) {
        console.error('Error updating product:', error);
        alert('Failed to update product. Error: ' + error.message);
    }
}

async function deleteProduct(productId, category) {
    if (confirm('Are you sure you want to delete this product?')) {
        try {
            const response = await fetch(`api/menu-items.php?id=${productId}`, {
                method: 'DELETE'
            });
            
            const result = await response.json();
            
            if (result.success) {
                await loadMenuDataFromDB();
                alert('Product deleted successfully!');
            } else {
                alert('Failed to delete product. Please try again.');
            }
        } catch (error) {
            console.error('Error deleting product:', error);
            alert('Failed to delete product. Please try again.');
        }
    }
}

function changeProductImage(productId, category) {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*';
    input.onchange = function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const product = menuData[category].find(p => p.id === productId);
                if (product) {
                    product.image = e.target.result;
                    loadProducts(currentCategory);
                    alert('Image updated successfully!');
                }
            };
            reader.readAsDataURL(file);
        }
    };
    input.click();
}

// Make functions globally accessible
window.editProduct = editProduct;
window.deleteProduct = deleteProduct;
window.changeProductImage = changeProductImage;
window.openAddProductModal = openAddProductModal;
window.closeAddProductModal = closeAddProductModal;
window.openEditProductModal = openEditProductModal;
window.closeEditProductModal = closeEditProductModal;
window.addNewProduct = addNewProduct;
window.saveProductChanges = saveProductChanges;

document.addEventListener('DOMContentLoaded', function() {
    setupCategoryTabs();
    
    // Load menu data from database
    loadMenuDataFromDB();
    
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.style.display = 'none';
            }
        });
    });
});