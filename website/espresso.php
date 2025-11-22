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
        <title>Look Back Café | Espresso Series </title>
        <link rel="stylesheet" href="../resources/css/espresso.css">
        <link rel="icon" type="image/jpg" href="../resources/img/favicon.jpg">
    </head>
    <body>
        <?php include 'includes/nav.php'; ?>

        <div class="header"></div>
        <div class="menu">
            <h1>Menu</h1>
            <h3>Welcome to Look Back Café</h3>
            <h2>SELECTED BEST SELLERS</h2>
            <div>
                <div class="best-sell">
                    <div class="table">
                        <div class="menu-img">
                            <img src="../resources/img/MENU/ESPRESSO/spanishlatte.jpg" alt="">
                        </div>
                        <h2>Spanish Latte</h2>
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
                            <img src="../resources/img/MENU/ESPRESSO/brevelatte.jpg" alt="">
                        </div>
                        <h2>Breve Latte</h2>
                        <div class="prices">
                            <div>
                                <p>HOT</p>
                                <p>140</p>
                            </div>
                            <div>
                                <p>16 OZ</p>
                                <p>160</p>
                            </div>
                            <div>
                                <p>UPSIZE</p>
                                <p>160</p>
                            </div>
                            <div>
                                <p>1 LITER</p>
                                <p>270</p>
                            </div>
                        </div>
                    </div>
                    <div class="table">
                        <div class="menu-img">
                            <img src="../resources/img/MENU/ESPRESSO/wcmocha.jpg" alt="">
                        </div>
                        <h2>White Chocolate Mocha</h2>
                        <div class="prices">
                            <div>
                                <p>HOT</p>
                                <p>140</p>
                            </div>
                            <div>
                                <p>16 OZ</p>
                                <p>160</p>
                            </div>
                            <div>
                                <p>UPSIZE</p>
                                <p>160</p>
                            </div>
                            <div>
                                <p>1 LITER</p>
                                <p>270</p>
                            </div>
                        </div>
                    </div>
                    <div class="table">
                        <div class="menu-img">
                            <img src="../resources/img/MENU/ESPRESSO/sigblend.jpg" alt="">
                        </div>
                        <h2>Signature Blend</h2>
                        <div class="prices">
                            <div>
                                <p>HOT</p>
                                <p>-</p>
                            </div>
                            <div>
                                <p>16 OZ</p>
                                <p>180</p>
                            </div>
                            <div>
                                <p>UPSIZE</p>
                                <p>180</p>
                            </div>
                            <div>
                                <p>1 LITER</p>
                                <p>300</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="all-prod">
            <h1>ALL PRODUCTS</h1>
            <h3>ESPRESSO SERIES</h3>
            <div>
                <div class="all-prod-img">
                    <img src="../resources/img/MENU/ESPRESSO/affogato.jpg" alt="">
                </div>
                <div class="description">
                    <div class="affogato">
                        <h1>Affogato</h1>
                        <br>
                        <p>A delightful dessert that combines rich, creamy vanilla gelato with a shot of freshly brewed espresso. <br>
                        <br>
                        The warm coffee cascades over the chilled gelato, creating a perfect balance of temperature and flavor. <br>
                        <br>
                        Enjoy this simple yet luxurious treat for an irresistible coffee experience.</p>
                    </div>
                    <div class="aff-price">
                        <h2>145</h2>
                        <h3>16OZ</h3>
                    </div>
                </div>
            </div>
        </div> 
        <div class="menu">
            <div>
                <div class="best-sell">
                    <div class="table">
                        <div class="menu-img">
                            <img src="../resources/img/MENU/ESPRESSO/dirtymatcha.jpg" alt="">
                        </div>
                        <h2>Dirty Matcha</h2>
                        <div class="prices">
                            <div>
                                <p>HOT</p>
                                <p>140</p>
                            </div>
                            <div>
                                <p>16 OZ</p>
                                <p>160</p>
                            </div>
                            <div>
                                <p>UPSIZE</p>
                                <p>160</p>
                            </div>
                            <div>
                                <p>1 LITER</p>
                                <p>270</p>
                            </div>
                        </div>
                    </div>
                    <div class="table">
                        <div class="menu-img">
                            <img src="../resources/img/MENU/ESPRESSO/macchiato.jpg" alt="">
                        </div>
                        <h2>Breve Latte</h2>
                        <div class="prices">
                            <div>
                                <p>HOT</p>
                                <p>130</p>
                            </div>
                            <div>
                                <p>16 OZ</p>
                                <p>150</p>
                            </div>
                            <div>
                                <p>UPSIZE</p>
                                <p>150</p>
                            </div>
                            <div>
                                <p>1 LITER</p>
                                <p>250</p>
                            </div>
                        </div>
                    </div>
                    <div class="table">
                        <div class="menu-img">
                            <img src="../resources/img/MENU/ESPRESSO/mocha.jpg" alt="">
                        </div>
                        <h2>Mocha</h2>
                        <div class="prices">
                            <div>
                                <p>HOT</p>
                                <p>130</p>
                            </div>
                            <div>
                                <p>16 OZ</p>
                                <p>150</p>
                            </div>
                            <div>
                                <p>UPSIZE</p>
                                <p>150</p>
                            </div>
                            <div>
                                <p>1 LITER</p>
                                <p>250</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="menu">
            <div>
                <div class="best-sell">
                    <div class="table">
                        <div class="menu-img">
                            <img src="../resources/img/MENU/ESPRESSO/caramellatte.jpg" alt="">
                        </div>
                        <h2>Caramel Latte</h2>
                        <div class="prices">
                            <div>
                                <p>HOT</p>
                                <p>130</p>
                            </div>
                            <div>
                                <p>16 OZ</p>
                                <p>150</p>
                            </div>
                            <div>
                                <p>UPSIZE</p>
                                <p>150</p>
                            </div>
                            <div>
                                <p>1 LITER</p>
                                <p>250</p>
                            </div>
                        </div>
                    </div>
                    <div class="table">
                        <div class="menu-img">
                            <img src="../resources/img/MENU/ESPRESSO/latte.jpg" alt="">
                        </div>
                        <h2>Latte</h2>
                        <div class="prices">
                            <div>
                                <p>HOT</p>
                                <p>120</p>
                            </div>
                            <div>
                                <p>16 OZ</p>
                                <p>140</p>
                            </div>
                            <div>
                                <p>UPSIZE</p>
                                <p>140</p>
                            </div>
                            <div>
                                <p>1 LITER</p>
                                <p>230</p>
                            </div>
                        </div>
                    </div>
                    <div class="table">
                        <div class="menu-img">
                            <img src="../resources/img/MENU/ESPRESSO/americano.jpg" alt="">
                        </div>
                        <h2>Americano</h2>
                        <div class="prices">
                            <div>
                                <p>HOT</p>
                                <p>110</p>
                            </div>
                            <div>
                                <p>16 OZ</p>
                                <p>130</p>
                            </div>
                            <div>
                                <p>UPSIZE</p>
                                <p>130</p>
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
            <h1>ADD ONS</h1>

            <div class="addon-list">
                <p>Espresso Shot - 30</p>
                <p>Sauce/Syrup - 30</p>
                <p>Ice Cream - 30</p>
            </div>

            <h3>All drinks are subject to availability.</h3>

            <div class="pagination">
                <a href="espresso.php" class="active">1</a>
                <a href="viet.php">2</a>
                <a href="noncoffee.php">3</a>
                <a href="viet.php" class="next">&gt;</a>
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