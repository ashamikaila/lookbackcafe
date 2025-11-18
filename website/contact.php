<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Red+Hat+Display:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Look Back Café | Contact Us</title>
    <link rel="stylesheet" href="../resources/css/style.css">
    <link rel="stylesheet" href="../resources/css/contact.css">
    <link rel="icon" type="image/jpg" href="../resources/img/favicon.jpg">
</head>

<body>

<nav class="nav">
    <ul class="nav-links">
        <li><a href="main.php">Home</a></li>
        <li class="dropdown">
            <a href="#" id="menu-toggle">Menu</a>
            <div class="dropdown-content" id="menu-dropdown">
                <h1>Menu</h1>
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
        <li><a href="about.php">About</a></li>
        <li class="dropdown">
            <a href="#" id="contact-toggle">Contact</a>
            <div class="dropdown-content" id="contact-dropdown">
                <h1>Contact Us</h1>
                <a href="contact.php">CONTACT</a>
                <a href="faqs.php">FAQs</a>
            </div>
        </li>
    </ul>

    <div class="logo">
        <img src="../resources/img/logo.jpg" alt="">
    </div>

    <div class="login-btn">
        <h2><a href="">Login/</a></h2>
        <h2><a href="">Register</a></h2>
    </div>
</nav>

<section class="contact-section">

    <h1 class="contact-title">CONTACT</h1>

    <div class="contact-image-wrapper">
        <img src="../resources/img/CONTACT/header.png" class="contact-image">
    </div>

    <p class="contact-address">
        In front of CEU Malolos Gate 3, MacArthur Highway,<br>
        Longos, Malolos, Philippines
    </p>

    <a class="contact-map-link" href="https://maps.app.goo.gl/SVh5K9ZCcPvUCnJm7" target="_blank">
        <i class="fa-solid fa-location-dot" style="color: #000000;"></i>
        Google Maps to Look Back Cafe
    </a>

    <p class="contact-info">
        email: lookbackcafe.25@gmail.com<br>
        mobile: +63 939 4716 012
    </p>

    <p class="contact-social-label">@lookbackcafe on:</p>

    <div class="contact-socials">
        <a href="https://www.facebook.com/lookbackcafe/"><i class="fa-brands fa-facebook"></i></a>
        <a href="https://www.instagram.com/lookbackcafe/"><i class="fa-brands fa-instagram"></i></a>
        <a href="https://www.tiktok.com/@lookbackcafe"><i class="fa-brands fa-tiktok"></i></a>
    </div>

    <h2 class="store-hours-title">STORE HOURS</h2>

    <p class="store-hours">
        Mon – Sat, 8AM – 8PM<br>
        Sun & Holidays, 10AM – 8PM
    </p>

    <div class="contact-map-embed">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3856.2099929974647!2d120.79826227574453!3d14.869531670434611!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339651beb9a91c99%3A0x37ab9eef1b7b16c8!2sLook%20Back%20Caf%C3%A9!5e0!3m2!1sen!2sph!4v1763465378566!5m2!1sen!2sph"
            allowfullscreen="" loading="lazy">
        </iframe>
    </div>

</section>

<footer>
    <div class="footer-grid">
        <div class="stay">
            <h1>STAY UPDATED</h1>
            <h3>Get the latest drops, news, and insider info—straight to your inbox.</h3>
            <form>
                <input type="email" placeholder="Enter your email">
                <button type="submit">Subscribe</button>
                <p>By submitting, you agree to our Privacy Policy and Terms & Conditions.</p>
                <p>You can unsubscribe at any time if you change your mind.</p>

                <div class="socials">
                    <a href="https://www.facebook.com/lookbackcafe/" target="_blank"><i class="fa-brands fa-facebook"></i></a>
                    <a href="https://www.instagram.com/lookbackcafe/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://www.tiktok.com/@lookbackcafe" target="_blank"><i class="fa-brands fa-tiktok"></i></a>
                </div>

                <div class="logo" style="margin-left: -10px;">
                    <img src="../resources/img/logo.jpg" alt="">
                </div>
            </form>
        </div>

        <div class="learn">
            <h1>LEARN MORE</h1>
            <ul>
                <li><a href="about.php">About</a></li>
                <li><a href="faqs.php">Frequently Asked Questions</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>

            <p>
                <a href="terms.php">Terms & Conditions</a> | 
                <a href="privacy.php">Privacy Policy</a>
            </p>
        </div>
    </div>
</footer>

<script src="../resources/js/script.js"></script>

</body>
</html>
