<?php
session_start(); // Start or resume session

include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');
include('include/header.php');

// Function to display checkout form and process payment
function displayCheckout()
{
    global $conn; // Access global connection variable

    // Initialize variables
    $subtotal = 0;
    $shippingCharge = 5; // Example shipping charge
    $totalAmount = 0;

    if (isset($_SESSION['userid'])) {
        $userId = $_SESSION['userid'];
        $cartKey = 'cart_' . $userId;

        // Fetch user information
        $userQuery = $conn->prepare("SELECT name FROM customers WHERE userid = ?");
        $userQuery->bind_param("i", $userId);
        $userQuery->execute();
        $userResult = $userQuery->get_result();
        $user = $userResult->fetch_assoc();
        $userName = $user['name'];
        $userQuery->close();

        // Check if cart is set and not empty
        if (isset($_SESSION[$cartKey]) && !empty($_SESSION[$cartKey])) {
            foreach ($_SESSION[$cartKey] as $productId => $product) {
                $subtotal += $product['price'] * $product['quantity'];
            }
            $totalAmount = $subtotal + $shippingCharge;

            // eSewa payment configuration
            $esewa_merchant_code = 'EPAYTEST';
            $success_url = 'http://localhost/accessiomart/pursuccess.php'; // URL where eSewa redirects after successful payment
            $failure_url = 'http://localhost/accessiomart/failure.php'; // URL where eSewa redirects after failed payment

            // Generate a unique order ID
            do {
                $orderId = 'ORD' . time() . rand(1000, 9999);
                $orderCheckQuery = $conn->prepare("SELECT orderid FROM orders WHERE orderid = ?");
                $orderCheckQuery->bind_param("s", $orderId);
                $orderCheckQuery->execute();
                $orderCheckQuery->store_result();
            } while ($orderCheckQuery->num_rows > 0);
            $orderCheckQuery->close();

            foreach ($_SESSION[$cartKey] as $productId => $product) {
                $totalPrice = $product['price'] * $product['quantity'];
                $createOrder = $conn->prepare("INSERT INTO orders (orderid, userid, name, pname, pimage, price, quantity, totalprice, pid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $createOrder->bind_param("sisssddii", $orderId, $userId, $userName, $product['name'], $product['image'], $product['price'], $product['quantity'], $totalPrice, $productId);
                $createOrder->execute();
            }

            // Display checkout form
            echo '<h2 style="text-align: center;">Checkout</h2>';
            echo '<div style="width: 50%; margin: 0 auto;">';
            echo '<form action="https://uat.esewa.com.np/epay/main" method="POST">'; // Use https://esewa.com.np/epay/main for production
            echo '<input type="hidden" name="tAmt" value="' . $totalAmount . '">';
            echo '<input type="hidden" name="amt" value="' . $subtotal . '">';
            echo '<input type="hidden" name="txAmt" value="0">';
            echo '<input type="hidden" name="psc" value="' . $shippingCharge . '">';
            echo '<input type="hidden" name="pdc" value="0">';
            echo '<input type="hidden" name="scd" value="' . $esewa_merchant_code . '">';
            echo '<input type="hidden" name="pid" value="' . $orderId . '">';
            echo '<input type="hidden" name="su" value="' . $success_url . '">';
            echo '<input type="hidden" name="fu" value="' . $failure_url . '">';
            echo '<table style="width: 100%; border-collapse: collapse; margin: 0 auto;">';
            echo '<tr><th>Subtotal</th><td>' . $subtotal . '</td></tr>';
            echo '<tr><th>Shipping Charge</th><td>' . $shippingCharge . '</td></tr>';
            echo '<tr><th>Total Amount</th><td>' . $totalAmount . '</td></tr>';
            echo '</table>';
            echo '<div style="text-align: center; margin-top: 20px;">';
            echo '<button type="submit" class="button">Pay with eSewa</button>';
            echo '</div>';
            echo '</form>';
            echo '</div>';
        } else {
            // Display message when cart is empty
            echo '<p style="text-align: center;">Your cart is empty. Please add items to the cart before proceeding to checkout.</p>';
            echo '<div style="text-align: center;">';
            echo '<button onclick="window.location=\'index.php\'" class="button">Continue Shopping</button>';
            echo '</div>';
        }
    } else {
        // Handle the case where the user is not logged in
        header("Location: signin.php");
        exit();
    }
}

// Handle the checkout process
displayCheckout();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        .button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }

        .button:hover {
            background-color: #218838;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <?php include('include/footer.php') ?>
</body>

</html>
