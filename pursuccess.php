<?php
session_start(); // Start or resume session

include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');

// eSewa Payment Success Handling
if (isset($_GET['oid']) && isset($_GET['amt']) && isset($_GET['refId'])) {
    $orderId = $_GET['oid'];
    $amount = $_GET['amt'];
    $refId = $_GET['refId'];

    // Validate the payment
    $paymentQuery = $conn->prepare("SELECT * FROM orders WHERE orderid = ? AND totalprice = ?");
    $paymentQuery->bind_param("sd", $orderId, $amount);
    $paymentQuery->execute();
    $paymentResult = $paymentQuery->get_result();

    if ($paymentResult->num_rows > 0) {
        if (isset($_SESSION['userid'])) {
            $userId = $_SESSION['userid'];
            $cartKey = 'cart_' . $userId;

            // Update the order status to 'Paid' or similar status
            $updateOrderStatus = $conn->prepare("UPDATE orders SET status = 'Paid', refId = ? WHERE orderid = ?");
            $updateOrderStatus->bind_param("ss", $refId, $orderId);
            $updateOrderStatus->execute();

            // Clear the cart session
            if (isset($_SESSION[$cartKey])) {
                unset($_SESSION[$cartKey]);
            }

            // Redirect to a thank you or confirmation page
            header("Location: paymentsuccess.php");
            exit();
        } else {
            // Handle the case where the user is not logged in
            header("Location: signin.php");
            exit();
        }
    } else {
        // Handle invalid payment
        header("Location: failure.php");
        exit();
    }
} else {
    // Handle missing parameters
    header("Location: failure.php");
    exit();
}
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
