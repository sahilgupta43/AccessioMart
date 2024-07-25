<?php 
session_start(); // Start or resume the session

// Check if the user is signed in
if (!isset($_SESSION['userid'])) {
    header("Location: signin.php");
    exit();
}

include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

include('include/without.php') ;
$userID = $_SESSION['userid'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AccessioMart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
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
        /* Popup Message Styles */
        #popup-message {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px;
            background-color: #28a745;
            color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            cursor: pointer;
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

    <script>
        document.getElementById('newsletter-form').addEventListener('submit', function(event) {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);

            fetch('subscribe.php', { // Path to the PHP script
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const popupMessage = document.getElementById('popup-message');

                if (data.success) {
                    popupMessage.textContent = 'Successfully subscribed!';
                    popupMessage.style.backgroundColor = '#28a745'; // Green for success
                } else {
                    popupMessage.textContent = data.error;
                    popupMessage.style.backgroundColor = '#dc3545'; // Red for error
                }

                popupMessage.style.display = 'block';
                setTimeout(() => {
                    popupMessage.style.display = 'none';
                }, 2000);
            })
            .catch(error => {
                console.error('Error:', error);
                const popupMessage = document.getElementById('popup-message');
                popupMessage.textContent = 'An error occurred. Please try again.';
                popupMessage.style.backgroundColor = '#dc3545'; // Red for error
                popupMessage.style.display = 'block';

                setTimeout(() => {
                    popupMessage.style.display = 'none';
                }, 2000);
            });
        });

    </script>

    <?php include('include/footer.php'); ?>
</body>
</html>