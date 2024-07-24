<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AccessioMart</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="top-bar">
            <div class="date-time" id="date-time"></div>
            <div class="top-links">
                <a href="about.php">About</a>
                <a href="faq.php">FAQ</a>
                <a href="terms.php">Terms</a>
                <a href="contactus.php">Contact Us</a>
            </div>
        </div>

        <!-- Navbar -->
        <nav class="navbar">
            <div class="brand">
                <a href="index.php">AccessioMart</a>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="categories.php">Categories</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="contactus.php">Contact</a></li>
                <?php if (isset($_SESSION['userid'])): ?>
                    <li><a href="user_dashboard.php">Dashboard</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="signin.php">Sign In</a></li>
                <?php endif; ?>
            </ul>
            <div class="icons">
                <a href="cart.php" class="icon">🛒</a>
                <a href="wishlist.php" class="icon">❤️</a>
                <a href="user_dashboard.php" class="icon">👤</a>
                <a href="#" class="icon" id="search-icon">🔍</a>
            </div>
            <div class="menu-toggle" id="menu-toggle">
                <!-- Menu icon for mobile view -->
            </div>
        </nav>
    </header>

    <!-- Search Popup Box -->
    <div id="search-popup" class="search-popup">
        <form id="search-form" action="search.php" method="GET">
            <input type="text" name="query" placeholder="Search for products..." required>
            <button type="submit">Search</button>
        </form>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
