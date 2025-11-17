<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stay Updated Footer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .main-content {
            flex: 1;
            padding: 40px 20px;
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }
        
        .main-content h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #2c3e50;
        }
        
        .main-content p {
            font-size: 1.1rem;
            max-width: 700px;
            margin: 0 auto 30px;
            color: #555;
        }
        
        footer {
            background-color: #1a1a1a;
            color: #fff;
            padding: 60px 20px 30px;
        }
        
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }
        
        .newsletter-section h2 {
            font-size: 1.8rem;
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .newsletter-section p {
            color: #ccc;
            margin-bottom: 25px;
            max-width: 400px;
        }
        
        .newsletter-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-width: 400px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .form-group label {
            font-size: 0.9rem;
            color: #aaa;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .form-group input {
            padding: 12px 15px;
            background-color: #2a2a2a;
            border: 1px solid #444;
            border-radius: 4px;
            color: #fff;
            font-size: 1rem;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #666;
        }
        
        .privacy-text {
            font-size: 0.85rem;
            color: #999;
            line-height: 1.5;
            margin-top: 10px;
        }
        
        .privacy-text a {
            color: #ccc;
            text-decoration: underline;
        }
        
        .footer-links {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        
        .links-column h3 {
            font-size: 1.1rem;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #fff;
        }
        
        .links-column ul {
            list-style: none;
        }
        
        .links-column ul li {
            margin-bottom: 12px;
        }
        
        .links-column ul li a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .links-column ul li a:hover {
            color: #fff;
        }
        
        .footer-bottom {
            max-width: 1200px;
            margin: 50px auto 0;
            padding-top: 30px;
            border-top: 1px solid #333;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .legal-links {
            display: flex;
            gap: 20px;
        }
        
        .legal-links a {
            color: #999;
            text-decoration: none;
            font-size: 0.9rem;
        }
        
        .legal-links a:hover {
            color: #fff;
        }
        
        .brand {
            font-size: 1.2rem;
            font-weight: 700;
            letter-spacing: 1px;
        }
        
        .brand-highlight {
            color: #ff6b6b;
        }
        
        @media (max-width: 768px) {
            .footer-container {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            
            .footer-links {
                grid-template-columns: 1fr;
                gap: 25px;
            }
            
            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }
            
            .legal-links {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="main-content">
        <h1>Website Content</h1>
        <p>This is the main content area of the website. Scroll down to see the footer section that replicates the design from your image.</p>
    </div>
    
    <footer>
        <div class="footer-container">
            <div class="newsletter-section">
                <h2>STAY UPDATED</h2>
                <p>Get the latest drops, news, and insider info—straight to your inbox.</p>
                
                <form class="newsletter-form">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" placeholder="Enter your email address">
                    </div>
                    
                    <p class="privacy-text">
                        By advertising you agree to our <a href="#">Privacy Policy</a> and <a href="#">Terms & Conditions</a>.
                        You can unsubscribe at any time if you change your mind.
                    </p>
                </form>
            </div>
            
            <div class="footer-links">
                <div class="links-column">
                    <h3>LEARN MORE</h3>
                    <ul>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Frequently Asked Questions</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>
                
                <div class="links-column">
                    <h3>SUPPORT</h3>
                    <ul>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Shipping Info</a></li>
                        <li><a href="#">Returns</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="legal-links">
                <a href="#">Terms & Conditions</a>
                <a href="#">Privacy Policy</a>
            </div>
            
            <div class="brand">
                <span class="brand-highlight">le-kbox</span>.kcafé
            </div>
            
            <div class="tagline">
                ADD YOURSELF, VITALIZED.
            </div>
        </div>
    </footer>
</body>
</html>