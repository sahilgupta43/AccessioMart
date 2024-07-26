<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AccessioMart</title>
    <link rel="stylesheet" href="assests/css/styles.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="top-bar">
            <div class="date-time" id="date-time"></div>
            <div class="top-links">
                <a href="pages/about.php">About</a>
                <a href="pages/faq.php">FAQ</a>
                <a href="pages/terms.php">Terms</a>
                <a href="pages/contactus.php">Contact Us</a>
            </div>
        </div>

        <!-- Navbar -->
        <nav class="navbar">
            <div class="brand">
                <a href="accessiomart/index.php">AccessioMart</a>
            </div>
            <ul class="nav-links">
                <li><a href="accessiomart/index.php">Home</a></li>
                <li><a href="pages/categories.php">Categories</a></li>
                <li><a href="pages/products.php">Products</a></li>
                <li><a href="pages/contactus.php">Contact</a></li>
                <?php if (isset($_SESSION['userid'])): ?>
                    <li><a href="pages/user_dashboard.php">Dashboard</a></li>
                    <li><a href="components/logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="pages/signin.php">Sign In</a></li>
                <?php endif; ?>
            </ul>
            <div class="icons">
                <a href="pages/cart.php" class="icon">🛒</a>
                <a href="pages/wishlist.php" class="icon">❤️</a>
                <a href="pages/user_dashboard.php" class="icon">👤</a>
                <a href="#" class="icon" id="search-icon">🔍</a>
            </div>
            <div class="menu-toggle" id="menu-toggle">
                <!-- Menu icon for mobile view -->
            </div>
        </nav>
    </header>

    <!-- Search Popup Box -->
    <div id="search-popup" class="search-popup">
        <form id="search-form" action="components/search.php" method="GET">
            <input type="text" name="query" placeholder="Search for products..." required>
            <button type="submit">Search</button>
        </form>
    </div>

    <script src="assests/js/script.js"></script>
</body>
</html>
