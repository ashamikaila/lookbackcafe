<?php
// connect to db
$conn = new mysqli("localhost", "root", "", "lookback_cafe");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Look Back Café</title>
    <link rel="stylesheet" href="../resources/css/espresso.css">
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
                <a href="viet.php">VIETNAMESE SERIES</a>
                <a href="noncoffee.php">NON-COFFEE SERIES</a>
                <a href="soda.php">SODA SERIES</a>
                <a href="milkshake.php">MILKSHAKE SERIES</a>
                <a href="snacks.php">SNACKS & WAFFLES</a>
                <a href="rice.php">RICE MEAL</a>
                <a href="hs.php">HOUSE SPECIALS</a>
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

<div class="header"></div>

<!-- Selected Best Sellers -->
<div class="menu">
    <h1>Menu</h1>
    <h3>Welcome to Look Back Café</h3>
    <h2>SELECTED BEST SELLERS</h2>
    <div>
        <div class="best-sell">
            <?php
            $best_sellers = $conn->query("SELECT * FROM menu_items WHERE category='espresso' AND is_available=1 LIMIT 4");
            while ($row = $best_sellers->fetch_assoc()) {
            ?>
            <div class="table">
                <div class="menu-img">
                    <img src="<?php echo $row['image_path']; ?>" alt="">
                </div>
                <h2><?php echo $row['item_name']; ?></h2>
                <div class="prices">
                    <div>
                        <p>HOT</p>
                        <p><?php echo $row['price_hot'] ?: '-'; ?></p>
                    </div>
                    <div>
                        <p>16 OZ</p>
                        <p><?php echo $row['price_16oz'] ?: '-'; ?></p>
                    </div>
                    <div>
                        <p>UPSIZE</p>
                        <p><?php echo $row['price_upsize'] ?: '-'; ?></p>
                    </div>
                    <div>
                        <p>1 LITER</p>
                        <p><?php echo $row['price_1liter'] ?: '-'; ?></p>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- All Products -->
<div class="all-prod">
    <h1>ALL PRODUCTS</h1>
    <h3>ESPRESSO SERIES</h3>
    <?php
    $all_espresso = $conn->query("SELECT * FROM menu_items WHERE category='espresso' AND is_available=1");
    while ($row = $all_espresso->fetch_assoc()) {
        if($row['item_name'] == 'Affogato') { 
            // keep static description for Affogato
    ?>
    <div>
        <div class="all-prod-img">
            <img src="<?php echo $row['image_path']; ?>" alt="">
        </div>
        <div class="description">
            <div class="affogato">
                <h1>Affogato</h1>
                <br>
                <p>A delightful dessert that combines rich, creamy vanilla gelato with a shot of freshly brewed espresso. <br><br>
                The warm coffee cascades over the chilled gelato, creating a perfect balance of temperature and flavor. <br><br>
                Enjoy this simple yet luxurious treat for an irresistible coffee experience.</p>
            </div>
            <div class="aff-price">
                <h2><?php echo $row['price_16oz']; ?></h2>
                <h3>16OZ</h3>
            </div>
        </div>
    </div>
    <?php 
        } 
    } 
    ?>
</div>

<!-- Repeat other espresso items dynamically (except Affogato) -->
<div class="menu">
    <div>
        <div class="best-sell">
            <?php
            $other_espresso = $conn->query("SELECT * FROM menu_items WHERE category='espresso' AND item_name!='Affogato' AND is_available=1");
            while ($row = $other_espresso->fetch_assoc()) {
            ?>
            <div class="table">
                <div class="menu-img">
                    <img src="<?php echo $row['image_path']; ?>" alt="">
                </div>
                <h2><?php echo $row['item_name']; ?></h2>
                <div class="prices">
                    <div>
                        <p>HOT</p>
                        <p><?php echo $row['price_hot'] ?: '-'; ?></p>
                    </div>
                    <div>
                        <p>16 OZ</p>
                        <p><?php echo $row['price_16oz'] ?: '-'; ?></p>
                    </div>
                    <div>
                        <p>UPSIZE</p>
                        <p><?php echo $row['price_upsize'] ?: '-'; ?></p>
                    </div>
                    <div>
                        <p>1 LITER</p>
                        <p><?php echo $row['price_1liter'] ?: '-'; ?></p>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Footer -->
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

<?php $conn->close(); ?>
