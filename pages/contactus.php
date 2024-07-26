<?php 
session_start(); // Start or resume the session
include('include/header.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - AccessioMart</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Custom Styles */
        #contact-page {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        #contact-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            width: 100%;
            max-width: 1200px;
            margin-bottom: 20px;
        }

        #contact-form {
            flex: 1;
            max-width: 40%;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-right: 2%;
            margin-bottom: 20px;
        }

        #contact-form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        #contact-form label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        #contact-form input, #contact-form textarea {
            width: 95%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 15px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        #contact-form button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #contact-form button:hover {
            background-color: #0056b3;
        }

        #contact-address {
            flex: 1;
            max-width: 48%;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-left: 2%;
            margin-bottom: 20px;
            text-align: center;
        }

        #contact-address h2 {
            margin-bottom: 10px;
            color: #333;
        }

        #contact-address p {
            font-size: 16px;
            line-height: 1.5;
            color: #666;
        }

        #contact-address .contact-info {
            margin-top: 20px;
            text-align: left;
        }

        #contact-address .contact-info h4 {
            margin-bottom: 10px;
            color: #333;
        }

        #contact-address .contact-info p {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        #contact-address .contact-info p i {
            margin-right: 10px;
            color: #007bff;
        }

        #contact-address .social-media {
            margin-top: 20px;
            font-size: 24px;
        }

        #contact-address .social-media a {
            color: #007bff;
            margin: 0 10px;
            text-decoration: none;
        }

        #contact-address .social-media a:hover {
            color: #0056b3;
        }

        #contact-map {
            width: 100%;
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 10px;
        }

        #contact-map iframe {
            width: 100%;
            height: 300px;
            border: none;
            border-radius: 8px;
        }

        @media (max-width: 768px) {
            #contact-content {
                flex-direction: column;
                align-items: center;
            }

            #contact-form, #contact-address {
                max-width: 95%;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <div id="contact-page">
        <div id="contact-content">
            <div id="contact-form">
                <h2>Contact Us</h2>
                <form action="process_feedback.php" method="POST">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="feedback">Feedback:</label>
                    <textarea id="feedback" name="feedback" rows="5" required></textarea>

                    <button type="submit">Submit</button>
                </form>

            </div>

            <div id="contact-address">
                <h2>Visit Us</h2>
                <div class="contact-info">
                    <p><i class="fas fa-map-marker-alt"></i> Wotu, MahaBouddha,<br>Kathmandu, Bagmati,<br>Nepal - 44600</p>
                    <p><i class="fas fa-phone-alt"></i> Phone: +977 1 1234567</p>
                    <p><i class="fas fa-envelope"></i> Email: contact@accessiomart.com</p>
                </div>

                <div class="social-media">
                    <h4>Follow Us:</h4>
                    <a href="https://facebook.com/accessiomart" target="_blank" class="fab fa-facebook-f"></a>
                    <a href="https://twitter.com/accessiomart" target="_blank" class="fab fa-twitter"></a>
                    <a href="https://instagram.com/accessiomart" target="_blank" class="fab fa-instagram"></a>
                    <a href="https://linkedin.com/company/accessiomart" target="_blank" class="fab fa-linkedin-in"></a>
                </div>
            </div>
        </div>

        <div id="contact-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d56516.27776849206!2d85.28493299963512!3d27.709030241827836!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb198a307baabf%3A0xb5137c1bf18db1ea!2sKathmandu%2044600!5e0!3m2!1sen!2snp!4v1719063514391!5m2!1sen!2snp" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>

    <?php include('include/footer.php') ?>
</body>
</html>