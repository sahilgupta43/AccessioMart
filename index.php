<?php include('include/header.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AccessioMart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Custom Styles */
        #featured-products .section-title {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            font-size: 24px;
            font-weight: bold;
        }

        #featured-products .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
            background-color: #fff;
        }

        #featured-products .card:hover {
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
        }

        #featured-products .card-img-top {
            height: 200px; /* Adjust height as needed */
            object-fit: cover;
            transition: all 0.3s ease;
        }

        #featured-products .card:hover .card-img-top {
            transform: scale(1.1);
        }

        #featured-products .card-body {
            padding: 15px;
        }

        #featured-products .card-title {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
            transition: color 0.3s ease;
        }

        #featured-products .card:hover .card-title {
            color: #0056b3;
        }

        #featured-products .card-text {
            color: #666;
            margin-bottom: 10px;
        }

        #featured-products .btn-group {
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
        }

        #featured-products .btn {
            width: 48%;
            background-color: #007bff;
            color: #fff;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        #featured-products .btn:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
        }

        @media (max-width: 768px) {
            #featured-products .btn-group {
                flex-direction: column;
            }

            #featured-products .btn {
                width: 100%;
                margin-top: 5px;
            }
        }

        /* Services Section Styles */
        #services {
            padding: 50px 0;
            background-color: #f9f9f9;
        }

        #services .section-title {
            text-align: center;
            margin-bottom: 50px;
            color: #333;
            font-size: 24px;
            font-weight: bold;
        }

        #services .service-item {
            text-align: center;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
            transition: all 0.3s ease;
        }

        #services .service-item:hover {
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
        }

        #services .service-icon {
            font-size: 40px;
            color: #007bff;
            margin-bottom: 20px;
            transition: color 0.3s ease;
        }

        #services .service-item:hover .service-icon {
            color: #0056b3;
        }

        #services .service-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #007bff;
            transition: color 0.3s ease;
        }

        #services .service-item:hover .service-title {
            color: #0056b3;
        }

        #services .service-description {
            color: #666;
        }

        @media (max-width: 768px) {
            #services .service-item {
                margin-bottom: 30px;
            }
        }

        /* Newsletter Section Styles */
        #newsletter {
            padding: 50px 0;
            background-color: #020508e0;
            color: #fff;
            text-align: center;
        }

        #newsletter .section-title {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
        }

        #newsletter .newsletter-form {
            max-width: 600px;
            margin: 0 auto;
            display: flex;
            justify-content: center;
        }

        #newsletter .newsletter-form input[type="email"] {
            width: 70%;
            padding: 10px;
            border: none;
            border-radius: 5px 0 0 5px;
            outline: none;
        }

        #newsletter .newsletter-form button {
            width: 30%;
            padding: 10px;
            border: none;
            background-color: #0056b3;
            color: #fff;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #newsletter .newsletter-form button:hover {
            background-color: #003f8a;
        }

    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1 class="hero-heading">Welcome to AccessioMart</h1>
            <p class="hero-slogan">Discover the trending products at unbeatable prices!</p>
        </div>
    </section>

    <?php include('include/featured.php') ?>

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
            <form class="newsletter-form">
                <input type="email" placeholder="Enter your email address" required>
                <button type="submit">Subscribe</button>
            </form>
        </div>
    </section>

    <script src="script.js"></script>
</body>
</html>

<?php include('include/footer.php') ?>