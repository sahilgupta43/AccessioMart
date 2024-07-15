<?php
session_start(); // Start or resume session

include('D:\xampp\htdocs\accessiomart\admin\include\connectdb.php');
include('include/header.php');

// Function to display checkout form and process payment
function displayCheckout() {
    // Calculate total amount
    $subtotal = 0;
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $productId => $product) {
            $subtotal += $product['price'] * $product['quantity'];
        }
    }
    $shippingCharge = 5; // Example shipping charge
    $totalAmount = $subtotal + $shippingCharge;

    // eSewa payment configuration
    $esewa_merchant_code = 'EPAYTEST';
    $success_url = 'http://localhost/accessiomart/index.php'; // URL where eSewa redirects after successful payment
    $failure_url = 'http://localhost/accessiomart/cart.php'; // URL where eSewa redirects after failed payment

    // Create order entries in the database
    $orderId = uniqid();
    $userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;

    foreach ($_SESSION['cart'] as $productId => $product) {
        $totalPrice = $product['price'] * $product['quantity'];
        $createOrder = $GLOBALS['conn']->prepare("INSERT INTO orders (orderid, userid, name, pid, pname, pimage, price, quantity, totalprice) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $createOrder->bind_param("sisissdii", $orderId, $userId, $_SESSION['name'], $productId, $product['name'], $product['image'], $product['price'], $product['quantity'], $totalPrice);
        $createOrder->execute();
    }

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
    echo '<tr><th>Total Amount</th><td>' . $totalAmount . '</td></tr>';
    echo '<tr><th>Shipping Charge</th><td>' . $shippingCharge . '</td></tr>';
    echo '<tr><th>Subtotal</th><td>' . $subtotal . '</td></tr>';
    echo '</table>';
    echo '<div style="text-align: center; margin-top: 20px;">';
    echo '<button type="submit" class="button">Pay with eSewa</button>';
    echo '</div>';
    echo '</form>';
    echo '</div>';
}

// Handle the checkout process
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the form submission here if needed
    displayCheckout();
} else {
    // Display the checkout form
    displayCheckout();
}

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
    </style>
</head>
<body>

<?php include('include/footer.php') ?>
</body>
</html>
