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
        <title>Look Back Café | Rice Meal </title>
        <link rel="stylesheet" href="../resources/css/rice.css">
        <link rel="icon" type="image/jpg" href="../resources/img/favicon.jpg">
    </head>
    <body>
        <?php include 'includes/nav.php'; ?>

        <div class="header"></div>

        <div class="all-prod">
            <h1>Menu</h1>
            <h3>RICE MEAL</h3>
        </div>

        <div class="menu">
            <div class="best-sell">
                <div class="table">
                    <div class="menu-img">
                        <img src="../resources/img/MENU/RICEMEAL/bbq.jpg" alt="BBQ Rice Meal">
                    </div>
                    <h2>BBQ Rice Meal</h2>
                    <div class="prices">
                        <div>
                            <p>₱160</p>
                        </div>
                    </div>
                </div>
                <div class="table">
                    <div class="menu-img">
                        <img src="../resources/img/MENU/RICEMEAL/chicken.jpg" alt="Chicken Rice Meal">
                    </div>
                    <h2>Chicken Rice Meal</h2>
                    <div class="prices">
                        <div>
                            <p>₱150</p>
                        </div>
                    </div>
                </div>
                <div class="table">
                    <div class="menu-img">
                        <img src="../resources/img/MENU/RICEMEAL/garlic.jpg" alt="Garlic Rice Meal">
                    </div>
                    <h2>Garlic Rice Meal</h2>
                    <div class="prices">
                        <div>
                            <p>₱160</p>
                        </div>
                    </div>
                </div>
                <div class="table">
                    <div class="menu-img">
                        <img src="../resources/img/MENU/RICEMEAL/ham.jpg" alt="Ham Rice Meal">
                    </div>
                    <h2>Ham Rice Meal</h2>
                    <div class="prices">
                        <div>
                            <p>₱130</p>
                        </div>
                    </div>
                </div>
                <div class="table">
                    <div class="menu-img">
                        <img src="../resources/img/MENU/RICEMEAL/hotdog.jpg" alt="Hotdog Rice Meal">
                    </div>
                    <h2>Hotdog Rice Meal</h2>
                    <div class="prices">
                        <div>
                            <p>₱100</p>
                        </div>
                    </div>
                </div>
                <div class="table">
                    <div class="menu-img">
                        <img src="../resources/img/MENU/RICEMEAL/maple.jpg" alt="Maple Rice Meal">
                    </div>
                    <h2>Maple Rice Meal</h2>
                    <div class="prices">
                        <div>
                            <p>₱150</p>
                        </div>
                    </div>
                </div>
                <div class="table">
                    <div class="menu-img">
                        <img src="../resources/img/MENU/RICEMEAL/sausilog.jpg" alt="Sausilog Rice Meal">
                    </div>
                    <h2>Sausilog Rice Meal</h2>
                    <div class="prices">
                        <div>
                            <p>₱125</p>
                        </div>
                    </div>
                </div>
                <div class="table">
                    <div class="menu-img">
                        <img src="../resources/img/MENU/RICEMEAL/sriracha.jpg" alt="Sriracha Rice Meal">
                    </div>
                    <h2>Sriracha Rice Meal</h2>
                    <div class="prices">
                        <div>
                            <p>₱130</p>
                        </div>
                    </div>
                </div>
                <div class="table">
                    <div class="menu-img">
                        <img src="../resources/img/MENU/RICEMEAL/tapa.jpg" alt="Tapa Rice Meal">
                    </div>
                    <h2>Tapa Rice Meal</h2>
                    <div class="prices">
                        <div>
                            <p>₱100</p>
                        </div>
                    </div>
                </div>
                <div class="table">
                    <div class="menu-img">
                        <img src="../resources/img/MENU/RICEMEAL/tocino.jpg" alt="Tocino Rice Meal">
                    </div>
                    <h2>Tocino Rice Meal</h2>
                    <div class="prices">
                        <div>
                            <p>₱90</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="addons">
            <h1>ADD ONS</h1>
            <h3>Egg - 20 | Fried Rice - 30 | Atchara - 30</h3>
            <h3>Plain Rice - 20 | Dip - 25 | Spiced Vinegar - 25</h3>

            <h1>ALA CARTE</h1>
            <h3>Sausage - 60 | Bacon - 60 | Ham - 20</h3>
            <h3>Tocino - 60 | Hotdog - 60 | Plain Poppers - 70</h3>

            <h3>All rice meals are subject to availability.</h3>

            <div class="pagination">
                <a href="snacks.php" class="prev">&lt;</a>
                <a href="soda.php"class="active">7</a>
                <a href="snacks.php">8</a>
                <a href="hs.php" class="next">&gt;</a>
            </div>
        </div>

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