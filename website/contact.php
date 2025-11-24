<?php
// Security headers - fixes OWASP ZAP alerts
require_once __DIR__ . '/includes/security_init.php';
if (session_status() === PHP_SESSION_NONE) {
}
require_once 'config/db.php';

// Get business info from database
$businessInfo = $conn->query("SELECT * FROM business_info WHERE info_id = 1")->fetch_assoc();
?>
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

<?php include 'includes/nav.php'; ?>

<section class="contact-section">

    <h1 class="contact-title">CONTACT</h1>

    <div class="contact-image-wrapper">
        <img src="../resources/img/CONTACT/header.png" class="contact-image">
    </div>

    <p class="contact-address">
        <?php echo nl2br(htmlspecialchars($businessInfo['business_address'])); ?>
    </p>

    <a class="contact-map-link" href="<?php echo htmlspecialchars($businessInfo['google_maps_link']); ?>" target="_blank">
        <i class="fa-solid fa-location-dot"></i>
        Google Maps to Look Back Cafe
    </a>

    <p class="contact-info">
        email: <?php echo htmlspecialchars($businessInfo['business_email']); ?><br>
        mobile: <?php echo htmlspecialchars($businessInfo['business_phone']); ?>
    </p>

    <p class="contact-social-label">@lookbackcafe on:</p>

    <div class="contact-socials">
        <a href="<?php echo htmlspecialchars($businessInfo['facebook_link']); ?>" target="_blank"><i class="fa-brands fa-facebook"></i></a>
        <a href="<?php echo htmlspecialchars($businessInfo['instagram_link']); ?>" target="_blank"><i class="fa-brands fa-instagram"></i></a>
        <a href="<?php echo htmlspecialchars($businessInfo['tiktok_link']); ?>" target="_blank"><i class="fa-brands fa-tiktok"></i></a>
    </div>

    <h2 class="store-hours-title">STORE HOURS</h2>

    <p class="store-hours">
        Mon – Sat, <?php echo htmlspecialchars($businessInfo['weekday_hours']); ?><br>
        Sun & Holidays, <?php echo htmlspecialchars($businessInfo['weekend_hours']); ?>
    </p>

    <div class="contact-map-embed">
        <?php echo $businessInfo['google_maps_embed']; ?>
    </div>

</section>

<footer>
    <div class="footer-grid">
        <div class="stay">
            <h1>STAY UPDATED</h1>
            <h3>Get the latest drops, news, and insider info—straight to your inbox.</h3>
            <form action="main.php" method="POST">
                <input type="email" name="newsletter_email" placeholder="Enter your email" required>
                <button type="submit">Subscribe</button>
                <p>By submitting, you agree to our Privacy Policy and Terms & Conditions.</p>
                <p>You can unsubscribe at any time if you change your mind.</p>

                <div class="socials">
                    <a href="<?php echo htmlspecialchars($businessInfo['facebook_link']); ?>" target="_blank"><i class="fa-brands fa-facebook"></i></a>
                    <a href="<?php echo htmlspecialchars($businessInfo['instagram_link']); ?>" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                    <a href="<?php echo htmlspecialchars($businessInfo['tiktok_link']); ?>" target="_blank"><i class="fa-brands fa-tiktok"></i></a>
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
