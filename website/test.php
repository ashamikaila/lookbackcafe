<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>lookbox.kcafé</title>
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Red Hat Display', sans-serif;
        }

        body {
            background-color: #f8f5f2;
            color: #1c1c1c;
            line-height: 1.6;
        }

        .nav {
            background-color: white;
            height: 90px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 40px;
            position: fixed;
            z-index: 100;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        }

        .nav-links {
            display: flex;
            list-style: none;
            align-items: center;
            text-transform: uppercase;
            gap: 30px;
            font-weight: 700;
            font-size: 15px;
        }

        .nav-links li a {
            color: #1c1c1c;
            text-decoration: none;
            transition: color 0.3s;
            position: relative;
            cursor: pointer;
        }

        .nav-links li a:hover {
            color: #8B4513;
        }

        .nav-links li a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: #8B4513;
            transition: width 0.3s;
        }

        .nav-links li a:hover::after {
            width: 100%;
        }

        .logo {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .logo img {
            height: 55px;
            width: auto;
        }

        .login-btn {
            display: flex;
            gap: 5px;
        }

        .login-btn h2 {
            font-size: 18px;
        }

        .login-btn a {
            text-transform: uppercase;
            color: #1c1c1c;
            text-decoration: none;
            font-weight: 700;
            transition: color 0.3s;
        }

        .login-btn a:hover {
            color: #8B4513;
        }

        /* Dropdown Menu Styles */
        .dropdown {
            position: relative;
        }

        .dropdown-content {
            position: absolute;
            background-color: white;
            min-width: 280px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            z-index: 1;
            border-radius: 8px;
            top: 100%;
            left: 0;
            overflow: hidden;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            padding: 10px 0;
        }

        .dropdown-content.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-content a {
            color: #1c1c1c;
            padding: 14px 20px;
            text-decoration: none;
            display: block;
            text-transform: uppercase;
            font-weight: 500;
            font-size: 14px;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            position: relative;
        }

        .dropdown-content a:hover {
            background-color: #f8f5f2;
            padding-left: 30px;
            color: #8B4513;
        }

        .dropdown-content a::before {
            content: '';
            position: absolute;
            width: 4px;
            height: 0;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            background-color: #8B4513;
            transition: height 0.3s;
        }

        .dropdown-content a:hover::before {
            height: 70%;
        }

        /* Main content styles */
        .main-content {
            padding-top: 120px;
            padding-left: 40px;
            padding-right: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
            font-size: 36px;
            text-align: center;
        }

        .subtitle {
            text-align: center;
            margin-bottom: 40px;
            color: #666;
            font-size: 18px;
        }

        .menu-section {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .menu-category {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .menu-category:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        .menu-category h3 {
            color: #8B4513;
            margin-bottom: 15px;
            font-size: 20px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
        }

        .menu-category ul {
            list-style-type: none;
        }

        .menu-category li {
            padding: 8px 0;
            border-bottom: 1px dashed #f0f0f0;
        }

        .menu-category li:last-child {
            border-bottom: none;
        }

        .hero {
            height: 500px;
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
                        url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') no-repeat center center;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            margin-bottom: 60px;
            border-radius: 10px;
        }

        .hero-content h2 {
            font-size: 48px;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .hero-content p {
            font-size: 20px;
            max-width: 600px;
            margin: 0 auto;
        }

        footer {
            background-color: #1c1c1c;
            color: white;
            text-align: center;
            padding: 30px 0;
            margin-top: 60px;
        }

        /* Animation for page load */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }

        .delay-1 { animation-delay: 0.2s; opacity: 0; }
        .delay-2 { animation-delay: 0.4s; opacity: 0; }
        .delay-3 { animation-delay: 0.6s; opacity: 0; }
    </style>
</head>
<body>
    <nav class="nav">
        <ul class="nav-links">
            <li><a href="#">Home</a></li>
            <li class="dropdown">
                <a href="#" id="menu-toggle">Menu</a>
                <div class="dropdown-content" id="menu-dropdown">
                    <a href="#">ESPRESSO SERIES</a>
                    <a href="#">VIETNAMESE SERIES</a>
                    <a href="#">NON-COFFEE SERIES</a>
                    <a href="#">SODA SERIES</a>
                    <a href="#">MILKSHARE SERIES</a>
                    <a href="#">SNACKS & WAFFLES</a>
                    <a href="#">RICE MEAL</a>
                    <a href="#">HOUSE SPECIALS</a>
                </div>
            </li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact Us</a></li>
        </ul>
        <div class="logo">
            <img src="https://via.placeholder.com/180x55/FFFFFF/8B4513?text=lookbox.kcafé" alt="lookbox.kcafé Logo">
        </div>
        <div class="login-btn">
            <h2><a href="">Login/</a></h2>
            <h2><a href="">Register</a></h2>
        </div>
    </nav>

    <div class="main-content">
        <div class="hero fade-in">
            <div class="hero-content">
                <h2>Welcome to lookbox.kcafé</h2>
                <p>Experience the finest coffee and beverages in a cozy atmosphere</p>
            </div>
        </div>

        <h1 class="fade-in delay-1">Our Menu</h1>
        <p class="subtitle fade-in delay-1">Discover our wide selection of beverages and snacks</p>

        <div class="menu-section">
            <div class="menu-category fade-in delay-2">
                <h3>ESPRESSO SERIES</h3>
                <ul>
                    <li>Classic Espresso</li>
                    <li>Americano</li>
                    <li>Cappuccino</li>
                    <li>Latte</li>
                    <li>Mocha</li>
                </ul>
            </div>
            <div class="menu-category fade-in delay-2">
                <h3>VIETNAMESE SERIES</h3>
                <ul>
                    <li>Vietnamese Iced Coffee</li>
                    <li>Egg Coffee</li>
                    <li>Coconut Coffee</li>
                    <li>Saigon Special</li>
                </ul>
            </div>
            <div class="menu-category fade-in delay-3">
                <h3>NON-COFFEE SERIES</h3>
                <ul>
                    <li>Hot Chocolate</li>
                    <li>Chai Latte</li>
                    <li>Matcha Latte</li>
                    <li>Herbal Teas</li>
                </ul>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2023 lookbox.kcafé. All rights reserved.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            const menuDropdown = document.getElementById('menu-dropdown');
            
            // Toggle dropdown on click
            menuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Toggle active class
                menuDropdown.classList.toggle('active');
            });
            
            // Close dropdown when clicking elsewhere
            document.addEventListener('click', function(e) {
                if (!menuDropdown.contains(e.target) && e.target !== menuToggle) {
                    menuDropdown.classList.remove('active');
                }
            });
            
            // Close dropdown when clicking on a menu item
            const dropdownItems = menuDropdown.querySelectorAll('a');
            dropdownItems.forEach(item => {
                item.addEventListener('click', function() {
                    menuDropdown.classList.remove('active');
                });
            });
            
            // Close dropdown when pressing Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    menuDropdown.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>