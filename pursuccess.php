<?php
session_start();

// Clear all data from the cart session for the current user
if (isset($_SESSION['userid'])) {
    unset($_SESSION['cart']);
}

// Redirect to cart page after 5 seconds
header("Refresh: 5; URL=cart.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
            padding: 50px;
        }
        .message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            padding: 20px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="message">
        <h2>Success!</h2>
        <p>Your cart has been cleared. You will be redirected shortly...</p>
    </div>
</body>
</html>
