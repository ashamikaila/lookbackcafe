// ...standalone controller for menumanagement.php...

(function () {
    // Expose functions to global scope for inline handlers
    window.openAddProductModal = openAddProductModal;
    window.closeAddProductModal = closeAddProductModal;
    window.openEditProductModal = openEditProductModal;
    window.closeEditProductModal = closeEditProductModal;
    window.addNewProduct = addNewProduct;
    window.saveProductChanges = saveProductChanges;
    window.deleteProduct = deleteProduct;

    let currentCategory = 'espresso';

    document.addEventListener('DOMContentLoaded', () => {
        setupCategoryTabs();
        setupModalBackdropClose();
        loadProducts(currentCategory);
    });

    function loadProducts(category) {
        currentCategory = category || currentCategory;
        const url = `/api/menu-items.php?category=${encodeURIComponent(currentCategory)}`;
        fetch(url, { cache: 'no-store' })
            .then(r => r.json())
            .then(products => renderProducts(products || []))
            .catch(err => {
                console.error('Failed to load products:', err);
                const grid = document.getElementById('productsGrid');
                if (grid) grid.innerHTML = '<p class="error">Failed to load products.</p>';
            });
    }

    function renderProducts(products) {
        const grid = document.getElementById('productsGrid');
        if (!grid) return;
        grid.innerHTML = '';
        if (!products.length) {
            grid.innerHTML = '<p>No products in this category.</p>';
            return;
        }

        products.forEach(product => {
            const card = document.createElement('div');
            card.className = 'product-card';
            card.innerHTML = `
                <div class="product-image">
                    <img src="${escapeHtml(product.image || '../resources/img/placeholder.jpg')}" alt="${escapeHtml(product.name)}" onerror="this.src='../resources/img/placeholder.jpg'">
                </div>
                <div class="product-info">
                    <h3>${escapeHtml(product.name)}</h3>
                    <div class="product-prices">${generatePricesMarkup(product.prices)}</div>
                </div>
                <div class="product-actions">
                    <button class="btn btn-sm btn-primary edit-btn" data-id="${product.id}"><i class="fas fa-edit"></i> Edit</button>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="${product.id}"><i class="fas fa-trash"></i> Delete</button>
                </div>
            `;
            // Attach listeners
            card.querySelector('.edit-btn').addEventListener('click', () => openEditProductModal(product.id));
            card.querySelector('.delete-btn').addEventListener('click', () => deleteProduct(product.id));
            grid.appendChild(card);
        });
    }

    function generatePricesMarkup(prices = {}) {
        const labels = { hot: 'HOT', '16oz': '16 OZ', upsize: 'UPSIZE', '1liter': '1 LITER', '500ml': '500ML', regular: 'REGULAR' };
        return Object.keys(labels).map(k => {
            if (prices.hasOwnProperty(k) && prices[k] !== null && prices[k] !== undefined) {
                return `<div><p>${labels[k]}</p><p>${escapeHtml(String(prices[k]))}</p></div>`;
            }
            return '';
        }).join('');
    }

    function setupCategoryTabs() {
        const tabs = document.querySelectorAll('.category-tab');
        if (!tabs) return;
        tabs.forEach(t => t.addEventListener('click', function () {
            tabs.forEach(x => x.classList.remove('active'));
            this.classList.add('active');
            const cat = this.getAttribute('data-category') || 'espresso';
            const title = {
                'espresso': 'Espresso Drinks',
                'viet': 'Vietnamese Coffee',
                'noncoffee': 'Non-Coffee',
                'rice': 'Rice Meals',
                'hs': 'House Specials',
                'milkshake': 'Milkshakes',
                'soda': 'Sodas',
                'snacks': 'Snacks',
                'waffles': 'Waffles'
            }[cat] || 'Products';
            const el = document.getElementById('currentCategory');
            if (el) el.textContent = title;
            loadProducts(cat);
        }));
    }

    function openAddProductModal() {
        const form = document.getElementById('addProductForm');
        if (form) form.reset();
        const cat = document.getElementById('productCategory');
        if (cat) cat.value = currentCategory;
        const modal = document.getElementById('addProductModal');
        if (modal) modal.style.display = 'block';
    }
    function closeAddProductModal() { const m = document.getElementById('addProductModal'); if (m) m.style.display = 'none'; }

    function openEditProductModal(productId) {
        const url = `/api/menu-items.php?id=${encodeURIComponent(productId)}`;
        fetch(url, { cache: 'no-store' })
            .then(r => r.json())
            .then(product => {
                if (!product) { alert('Product not found'); return; }
                document.getElementById('editProductId').value = product.id || '';
                document.getElementById('editProductName').value = product.name || '';
                const cat = document.getElementById('editProductCategory');
                if (cat) cat.value = product.category || '';
                document.getElementById('editProductImage').value = product.image || '';
                const cur = document.getElementById('currentImagePath');
                if (cur) cur.textContent = product.image || '';

                document.getElementById('editPrice16oz').value = product.prices['16oz'] ?? '';
                document.getElementById('editPriceUpsize').value = product.prices['upsize'] ?? '';
                document.getElementById('editPrice1liter').value = product.prices['1liter'] ?? '';
                document.getElementById('editPriceHot').value = product.prices['hot'] ?? '';
                document.getElementById('editPrice500ml').value = product.prices['500ml'] ?? '';
                document.getElementById('editPriceRegular').value = product.prices['regular'] ?? '';

                const modal = document.getElementById('editProductModal');
                if (modal) modal.style.display = 'block';
            })
            .catch(err => {
                console.error('Failed to fetch product:', err);
                alert('Failed to load product details');
            });
    }
    function closeEditProductModal() { const m = document.getElementById('editProductModal'); if (m) m.style.display = 'none'; }

    function addNewProduct() {
        const form = document.getElementById('addProductForm');
        if (!form) return;
        const fd = new FormData(form);
        const data = {
            name: fd.get('productName'),
            category: fd.get('productCategory'),
            image: fd.get('productImage'),
            prices: {
                '16oz': parseNumberOrNull(fd.get('price_16oz')),
                'upsize': parseNumberOrNull(fd.get('price_upsize')),
                '1liter': parseNumberOrNull(fd.get('price_1liter')),
                'hot': parseNumberOrNull(fd.get('price_hot')),
                '500ml': parseNumberOrNull(fd.get('price_500ml')),
                'regular': parseNumberOrNull(fd.get('price_regular'))
            }
        };
        fetch('/api/menu-items.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(data) })
            .then(r => r.json())
            .then(res => {
                if (res && res.success) { closeAddProductModal(); loadProducts(currentCategory); }
                else alert('Failed to add product: ' + (res.error || 'unknown'));
            })
            .catch(err => { console.error('Add error', err); alert('Failed to add product'); });
    }

    function saveProductChanges() {
        const id = document.getElementById('editProductId').value;
        const data = {
            id: id,
            name: document.getElementById('editProductName').value,
            image: document.getElementById('editProductImage').value,
            prices: {
                '16oz': parseNumberOrNull(document.getElementById('editPrice16oz').value),
                'upsize': parseNumberOrNull(document.getElementById('editPriceUpsize').value),
                '1liter': parseNumberOrNull(document.getElementById('editPrice1liter').value),
                'hot': parseNumberOrNull(document.getElementById('editPriceHot').value),
                '500ml': parseNumberOrNull(document.getElementById('editPrice500ml').value),
                'regular': parseNumberOrNull(document.getElementById('editPriceRegular').value)
            }
        };
        fetch('/api/menu-items.php', {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(r => r.json())
        .then(res => {
            if (res && res.success) {
                closeEditProductModal();
                loadProducts(currentCategory); // reload products so UI reflects DB
            } else {
                alert('Failed to save changes: ' + (res.error || 'unknown'));
            }
        })
        .catch(err => {
            console.error('Save error', err);
            alert('Failed to save changes');
        });
    }

    function deleteProduct(productId) {
        if (!confirm('Delete this product?')) return;
        fetch(`/api/menu-items.php?id=${encodeURIComponent(productId)}`, { method: 'DELETE' })
            .then(r => r.json())
            .then(res => {
                if (res && res.success) loadProducts(currentCategory);
                else alert('Failed to delete: ' + (res.error || 'unknown'));
            })
            .catch(err => { console.error('Delete error', err); alert('Failed to delete product'); });
    }

    function setupModalBackdropClose() {
        window.addEventListener('click', (e) => {
            const addModal = document.getElementById('addProductModal');
            const editModal = document.getElementById('editProductModal');
            if (e.target === addModal) closeAddProductModal();
            if (e.target === editModal) closeEditProductModal();
        });
    }

    function parseNumberOrNull(v) {
        if (v === null || v === undefined || v === '') return null;
        const n = Number(v);
        return Number.isFinite(n) ? n : null;
    }
    function escapeHtml(s) { if (s === null || s === undefined) return ''; return String(s).replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/'/g,'&#39;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

})();
