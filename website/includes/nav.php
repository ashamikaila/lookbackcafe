<?php
$isLoggedIn = isset($_SESSION["is_logged_in"]) && $_SESSION["is_logged_in"];
$userName = $_SESSION["user_name"] ?? "User";
$userAvatar = $_SESSION["user_avatar"] ?? null;

// Get user initials for avatar
function getUserInitials($name): string
{
    $words = explode(' ', trim($name));
    if (count($words) >= 2) {
        return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
    }
    return strtoupper(substr($name, 0, 2));
}
$userInitials = getUserInitials($userName);
?>
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
        <?php if ($isLoggedIn): ?>
            <!-- Logged in: Show user avatar -->
            <div class="user-avatar-container">
                <div class="user-avatar" onclick="toggleUserMenu()">
                    <?php if ($userAvatar): ?>
                        <img src="<?php echo htmlspecialchars($userAvatar); ?>" alt="User Avatar">
                    <?php else: ?>
                        <div class="avatar-initials"><?php echo $userInitials; ?></div>
                    <?php endif; ?>
                </div>
                <div class="user-menu" id="userMenu">
                    <p class="user-menu-name"><?php echo htmlspecialchars($userName); ?></p>
                    <a href="profile.php">Profile</a>
                    <a href="auth/logout.php">Logout</a>
                </div>
            </div>
        <?php else: ?>
            <!-- Not logged in: Show Login/Register -->
            <h2><a href="login_as.php">Login/</a></h2>
            <h2><a href="register.php">Register</a></h2>
        <?php endif; ?>
    </div>
</nav>
<script>
    function toggleUserMenu() {
        const menu = document.getElementById('userMenu');
        menu.classList.toggle('active');
    }

    // Close menu when clicking outside
    document.addEventListener('click', function (event) {
        const container = document.querySelector('.user-avatar-container');
        const menu = document.getElementById('userMenu');

        if (container && !container.contains(event.target)) {
            menu.classList.remove('active');
        }
    });
</script>