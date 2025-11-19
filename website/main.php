<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Red+Hat+Display:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-…" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Look Back Café</title>
        <link rel="stylesheet" href="../resources/css/style.css">
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
                        <a href="espresso.php">ESPRESSO SERIES</a>
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
        <section class="home">
            <div class="video">
                <video src="../resources/img/HOMEPAGE/Copy of Look Back Cafe Menu.mp4" autoplay loop muted></video>
            </div>
            <div class="welcome">
                <div>
                    <h1>Welcome to Look Back Café!</h1>
                    <div class="w-p">
                        <p>We serve moments and</p>
                        <p>create memories beyond</p>
                        <p>beans and brews.</p>
                    </div>
                    <a href="menu.php" class="btn">Menu</a>
                </div>
            </div>
            <div class="about">
                <div>
                    <h1>All About Look Back Café!</h1>
                    <a href="about.php" class="btn">OUR STORY</a>
                </div>
            </div>
            <div class="memo">
                <div>
                    <h1>A look back at the moments that made Look Back Café special — thank you to every smile, every visit, and every memory. We’re so grateful for your support!</h1>
                </div>
                <div class="gallery-container">
                    <div class="scrolling-gallery" id="gallery">
                        <?php
                        $totalImages = 6; // number of unique images
                        $duplicates = 6;  // how many times to repeat for seamless scrolling

                        for ($d = 0; $d < $duplicates; $d++) {
                            for ($i = 1; $i <= $totalImages; $i++) {
                                echo '<div class="image-item">';
                                echo '<img src="../resources/img/HOMEPAGE/photowall/photowall' . $i . '.png" alt="">';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                    <p>This photo wall will be updated weekly.</p>
                </div>
            </div>
            <div class="mot-special">
                <div>
                    <h1>SPECIAL OFFERS</h1>
                </div>
                <div class="special">
                    <img src="../resources/img/HOMEPAGE/monthlyspecials/special1.jpg" alt="">
                    <img src="../resources/img/HOMEPAGE/monthlyspecials/special2.png" alt="">
                </div>
            </div>
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
                            <a href="https://www.facebook.com/lookbackcafe/" target="_blank">
                            <i class="fa-brands fa-facebook"></i></a>
                            <a href="https://www.instagram.com/lookbackcafe/" target="_blank">
                            <i class="fa-brands fa-instagram"></i></a>
                            <a href="https://www.tiktok.com/@lookbackcafe" target="_blank">
                            <i class="fa-brands fa-tiktok"></i></a> 
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
                    <p><a href="terms.php">Terms & Conditions</a> | 
                    <a href="privacy.php">Privacy Policy</a></p>
                </div>
            </div>
        </footer>
    <script src="../resources/js/script.js"></script>
    </body>
</html>