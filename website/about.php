<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
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
    <title>Look Back Café | About</title>
    <link rel="stylesheet" href="../resources/css/about.css">
    <link rel="icon" type="image/jpg" href="../resources/img/favicon.jpg">
</head>

<body>
    <?php include 'includes/nav.php'; ?>

    <div class="header"></div>
    <div class="mot-special">
        <div>
            <h1>All About Look Back Café</h1>
        </div>
        <div class="special">
            <img src="../resources/img/ABOUT/about1.png" alt="">
            <img src="../resources/img/ABOUT/about2.png" alt="">
            <img src="../resources/img/ABOUT/about3.png" alt="">
        </div>
    </div>
    <div class="history">
        <img src="../resources/img/ABOUT/about5.png" alt="">
        <div>
            <p>Established in 2023, Look Back Café offers a warm and inviting atmosphere perfect for savoring life's simple
            pleasures. From our carefully brewed coffee and freshly baked pastries to our hearty, comforting meals,
            every detail is crafted to enhance your experience and make each visit memorable.<br /><br />
            We believe that the magic happens in the small things—the friendly smile from our barista, the cozy nook
            where you can curl up with a good book, or the laughter shared over a delicious meal. Our space is designed
            to be a backdrop for your stories, where fleeting moments become cherished memories.<br /><br />Welcome
            to Look Back Café!</p>
        </div>
    </div>
    <img src="../resources/img/ABOUT/about4.png" alt="">
</body>

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
                <a href="privacy.php">Privacy Policy</a>
            </p>
        </div>
    </div>
</footer>
<script src="../resources/js/script.js"></script>
</body>

</html>