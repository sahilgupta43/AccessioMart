<?php
session_start(); // Start or resume session

// Include header for consistent look and feel
include('include/header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
            padding: 50px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #e74c3c;
        }

        p {
            font-size: 18px;
        }

        .button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 20px;
            text-decoration: none;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Payment Failed!</h1>
        <p>There was an issue with your payment. Please try again or contact support.</p>
        <a href="index.php" class="button">Continue Shopping</a>
        <a href="contact.php" class="button">Contact Support</a>
    </div>

    <?php include('include/footer.php'); ?>
</body>

</html>
