<?php 
session_start(); 

// Comment out or remove the session check
// if (!isset($_SESSION['userid'])) {
//     header("Location: signin.php");
//     exit();
// }

include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

include('include/without.php');
$userID = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AccessioMart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="assests/css/styles.css">
</head>
<body>
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1 class="hero-heading">Welcome to AccessioMart</h1>
            <p class="hero-slogan">Discover the trending products at unbeatable prices!</p>
        </div>
    </section>

    <!-- Featured Products -->
    <?php include('include/featured.php'); ?>

    <!-- Services Section -->
    <section id="services">
        <div class="container">
            <h2 class="section-title">Our Services</h2>
            <div class="row">
                <div class="col-md-4 service-item">
                    <div class="service-icon"><i class="fas fa-shipping-fast"></i></div>
                    <h3 class="service-title">Fast Delivery</h3>
                    <p class="service-description">Get your products delivered quickly with our fast delivery service.</p>
                </div>
                <div class="col-md-4 service-item">
                    <div class="service-icon"><i class="fas fa-sync-alt"></i></div>
                    <h3 class="service-title">Easy Returns</h3>
                    <p class="service-description">Hassle-free returns for your convenience.</p>
                </div>
                <div class="col-md-4 service-item">
                    <div class="service-icon"><i class="fas fa-headset"></i></div>
                    <h3 class="service-title">24/7 Support</h3>
                    <p class="service-description">Our support team is available 24/7 to assist you.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section id="newsletter">
        <div class="container">
            <h2 class="section-title">Subscribe to our Newsletter</h2>
            <p>Stay updated with the latest products and offers!</p>
            <form id="newsletter-form" class="newsletter-form">
                <input type="email" name="email" placeholder="Enter your email address" required>
                <button type="submit">Subscribe</button>
            </form>
        </div>
    </section>

    <!-- Popup Message -->
    <div id="popup-message"></div>

    <script src="assests/js/script.js"></script>

    <?php include('include/footer.php'); ?>
</body>
</html>