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
        <title>Look Back Café | Non-COffee Series</title>
        <link rel="stylesheet" href="../resources/css/noncoffee.css">
        <link rel="icon" type="image/jpg" href="../resources/img/favicon.jpg">
    </head>
    <body>
        <?php include 'includes/nav.php'; ?>

        <div class="header"></div>

        <div class="all-prod">
            <h1>Menu</h1>
            <h3>NON COFFEE SERIES</h3>
        </div>

        <div class="menu">
            <div>
                <div class="best-sell">
                    <div class="table">
                        <div class="menu-img">
                            <img src="../resources/img/MENU/NONCOFFEE/berrymatcha.jpg" alt="">
                        </div>
                        <h2>Berry Matcha</h2>
                        <div class="prices">
                            <div>
                                <p>16 OZ</p>
                                <p>130</p>
                            </div>
                            <div>
                                <p>UPSIZE</p>
                                <p>150</p>
                            </div>
                            <div>
                                <p>1 LITER</p>
                                <p>210</p>
                            </div>
                        </div>
                    </div>
                    <div class="table">
                        <div class="menu-img">
                            <img src="../resources/img/MENU/NONCOFFEE/brownsugar.jpg" alt="">
                        </div>
                        <h2>Brown Sugar</h2>
                        <div class="prices">
                            <div>
                                <p>16 OZ</p>
                                <p>130</p>
                            </div>
                            <div>
                                <p>UPSIZE</p>
                                <p>150</p>
                            </div>
                            <div>
                                <p>1 LITER</p>
                                <p>210</p>
                            </div>
                        </div>
                    </div>
                    <div class="table">
                        <div class="menu-img">
                            <img src="../resources/img/MENU/NONCOFFEE/chocoberry.jpg" alt="">
                        </div>
                        <h2>Choco Berry</h2>
                        <div class="prices">
                            <div>
                                <p>HOT</p>
                                <p>150</p>
                            </div>
                            <div>
                                <p>16 OZ</p>
                                <p>130</p>
                            </div>
                            <div>
                                <p>UPSIZE</p>
                                <p>150</p>
                            </div>
                            <div>
                                <p>1 LITER</p>
                                <p>210</p>
                            </div>
                        </div>
                    </div>
                    <div class="table">
                        <div class="menu-img">
                            <img src="../resources/img/MENU/NONCOFFEE/chocolate.jpg" alt="">
                        </div>
                        <h2>Chocolate</h2>
                        <div class="prices">
                            <div>
                                <p>HOT</p>
                                <p>150</p>
                            </div>
                            <div>
                                <p>16 OZ</p>
                                <p>130</p>
                            </div>
                            <div>
                                <p>UPSIZE</p>
                                <p>150</p>
                            </div>
                            <div>
                                <p>1 LITER</p>
                                <p>210</p>
                            </div>
                        </div>
                    </div>
                    <div class="table">
                        <div class="menu-img">
                            <img src="../resources/img/MENU/NONCOFFEE/matcha.jpg" alt="">
                        </div>
                        <h2>Matcha</h2>
                        <div class="prices">
                            <div>
                                <p>HOT</p>
                                <p>150</p>
                            </div>
                            <div>
                                <p>16 OZ</p>
                                <p>130</p>
                            </div>
                            <div>
                                <p>UPSIZE</p>
                                <p>150</p>
                            </div>
                            <div>
                                <p>1 LITER</p>
                                <p>210</p>
                            </div>
                        </div>
                    </div>
                    <div class="table">
                        <div class="menu-img">
                            <img src="../resources/img/MENU/NONCOFFEE/strawberry.jpg" alt="">
                        </div>
                        <h2>Strawberry</h2>
                        <div class="prices">
                            <div>
                                <p>HOT</p>
                                <p>150</p>
                            </div>
                            <div>
                                <p>16 OZ</p>
                                <p>130</p>
                            </div>
                            <div>
                                <p>UPSIZE</p>
                                <p>150</p>
                            </div>
                            <div>
                                <p>1 LITER</p>
                                <p>210</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       <div class="addons">
            <h3>All drinks are subject to availability.</h3>

            <div class="pagination">
                <a href="viet.php" class="prev">&lt;</a>
                <a href="noncoffee.php" class="active">3</a>
                <a href="soda.php">4</a>
                <a href="milkshake.php">5</a>
                <a href="soda.php" class="next">&gt;</a>
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