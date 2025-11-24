<?php
// Security headers - fixes OWASP ZAP alerts
require_once __DIR__ . '/includes/security_init.php';
if (session_status() === PHP_SESSION_NONE) {
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Red+Hat+Display:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-…" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Look Back Café | Frequently Asked Questions</title>
        <link rel="stylesheet" href="../resources/css/style.css">
        <link rel="stylesheet" href="../resources/css/faqs.css">
        <link rel="icon" type="image/jpg" href="../resources/img/favicon.jpg">
    </head>
    <body>
        <?php include 'includes/nav.php'; ?>
    <section class="terms-container">
        <h1 class="terms-title">FREQUENTLY ASKED QUESTIONS</h1>

        <h2 class="section-title">1. What are your opening hours?</h2>
        <p class="terms-text">
            Our typical hours are:<br>
            Monday–Saturday: 8:00 AM – 8:00 PM<br>
            Sunday & Holidays: 10:00 AM – 8:00 PM
        </p>

        <h2 class="section-title">2. Where are you located?</h2>
        <p class="terms-text">
            Look Back Café is located in front of CEU Malolos Gate 3, Mac Arthur Highway, Longos, Malolos, Bulacan.
        </p>

        <h2 class="section-title">3. Do you offer Wi-Fi?</h2>
        <p class="terms-text">
            Yes—free, high-speed Wi-Fi is available for all guests. Just ask the staff for the password.
        </p>

        <h2 class="section-title">4. Do you deliver?</h2>
        <p class="terms-text">
            Yes, we deliver! We offer delivery for a minimum purchase of ₱499. Simply message us directly on our page to place your order. Delivery fees start at ₱50, depending on your location.
        </p>

        <h2 class="section-title">5. Do you accept advance orders or bulk orders?</h2>
        <p class="terms-text">
            Yes, we do! You can place an advance order by messaging our Facebook page with your details. For bulk orders, we recommend placing your order ahead of time and including the specific date and time needed so we can prepare everything properly.
        </p>

        <h2 class="section-title">6. How much is your private space?</h2>
        <p class="terms-text">
            Our private space is free to use with a minimum ₱1,000 consumable purchase good for 1 hour. If you wish to extend, you may add ₱500 worth of items for every additional 30 minutes.
        </p>
    </section>

        <footer>
            <div class="footer-grid">
                <div class="stay">
                    <h1>STAY UPDATED</h1>
                    <h3>Get the latest drops, news, and insider info—straight to your inbox.</h3>
                    <form action="">
                        <input type="email" placeholder="Enter your email">
                        <button type="submit">Subscribe</button>
                        <p>By submitting, you agree to our Privacy Policy and Terms & Conditions.</p>
                        <p>You can unsubscribe at any time if you change your mind.</p>
                        <div class="socials">
                            <i class="fa-brands fa-facebook"></i>
                            <i class="fa-brands fa-instagram"></i>
                            <i class="fa-brands fa-tiktok"></i>
                        </div>
                        <div class="logo">
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
                    <p><a href="terms.php">Terms & Conditions</a> | 
                    <a href="privacy.php">Privacy Policy</a></p>
                </div>
            </div>
        </footer>
    <script src="../resources/js/script.js"></script>
    </body>
</html>