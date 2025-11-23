<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config/db.php';

// Handle newsletter subscription
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['newsletter_email'])) {
    $email = filter_var($_POST['newsletter_email'], FILTER_SANITIZE_EMAIL);
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM newsletter_subscribers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            // Insert new subscriber
            $stmt = $conn->prepare("INSERT INTO newsletter_subscribers (email) VALUES (?)");
            $stmt->bind_param("s", $email);
            
            if ($stmt->execute()) {
                $_SESSION['newsletter_success'] = "Thank you for subscribing!";
            }
        } else {
            // Reactivate if inactive
            $stmt = $conn->prepare("UPDATE newsletter_subscribers SET is_active = 1 WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $_SESSION['newsletter_success'] = "You're already subscribed!";
        }
    }
    
    header("Location: main.php#newsletter");
    exit();
}

// Get photo wall caption
$photoCaption = $conn->query("SELECT content_value FROM page_content WHERE page_name = 'photowall' AND section_name = 'caption'")->fetch_assoc();
$photoCaptionText = $photoCaption ? $photoCaption['content_value'] : "A look back at the moments that made Look Back Café special — thank you to every smile, every visit, and every memory. We're so grateful for your support!";

// Get special offers title
$specialTitle = $conn->query("SELECT content_value FROM page_content WHERE page_name = 'special_offers' AND section_name = 'title'")->fetch_assoc();
$specialTitleText = $specialTitle ? $specialTitle['content_value'] : "SPECIAL OFFERS";

// Get active special offers
$specialOffers = $conn->query("SELECT * FROM special_offers WHERE is_active = 1 ORDER BY offer_order ASC LIMIT 2");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Red+Hat+Display:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-…" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Look Back Café</title>
    <link rel="stylesheet" href="../resources/css/style.css">
    <link rel="icon" type="image/jpg" href="../resources/img/favicon.jpg">
</head>

<body>
    <?php include 'includes/nav.php'; ?>
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
                <h1><?php echo htmlspecialchars($photoCaptionText); ?></h1>
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
                <h1><?php echo htmlspecialchars($specialTitleText); ?></h1>
            </div>
            <div class="special">
                <?php 
                if ($specialOffers->num_rows > 0) {
                    while ($offer = $specialOffers->fetch_assoc()) {
                        echo '<img src="' . htmlspecialchars($offer['image_path']) . '" alt="Special Offer">';
                    }
                } else {
                    // Fallback to default images
                    echo '<img src="../resources/img/HOMEPAGE/monthlyspecials/special1.jpg" alt="">';
                    echo '<img src="../resources/img/HOMEPAGE/monthlyspecials/special2.png" alt="">';
                }
                ?>
            </div>
        </div>
    </section>
    <footer>
        <div class="footer-grid">
            <div class="stay">
                <h1>STAY UPDATED</h1>
                <h3>Get the latest drops, news, and insider info—straight to your inbox.</h3>
                <form action="main.php" method="POST" id="newsletter">
                    <?php if (isset($_SESSION['newsletter_success'])): ?>
                        <div class="newsletter-success">
                            <?php 
                            echo $_SESSION['newsletter_success']; 
                            unset($_SESSION['newsletter_success']);
                            ?>
                        </div>
                    <?php endif; ?>
                    <input type="email" name="newsletter_email" placeholder="Enter your email" required>
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
                    <a href="privacy.php">Privacy Policy</a>
                </p>
            </div>
        </div>
    </footer>
    <script src="../resources/js/script.js"></script>
</body>

</html>