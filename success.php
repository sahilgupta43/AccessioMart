<?php
session_start();
include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');

if (isset($_GET['oid']) && isset($_GET['amt']) && isset($_GET['refId'])) {
    $orderId = $_GET['oid'];
    $amount = $_GET['amt'];
    $referenceId = $_GET['refId'];

    // Validate the payment with eSewa
    $url = "https://uat.esewa.com.np/epay/transrec";
    $data = [
        'amt' => $amount,
        'rid' => $referenceId,
        'pid' => $orderId,
        'scd' => 'EPAYTEST'
    ];

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);

    if (strpos($response, "Success") !== false) {
        // Payment is successful, update order status in your database
        $updateOrderStatus = $conn->prepare("UPDATE orders SET status = 'Completed', transaction_id = ? WHERE orderid = ?");
        $updateOrderStatus->bind_param("si", $referenceId, $orderId);
        $updateOrderStatus->execute();

        // Clear the cart session
        if ($updateOrderStatus->affected_rows > 0) {
            unset($_SESSION['cart']);
            echo "<h1>Payment Successful!</h1>";
            echo "<p>Thank you for your purchase. Your payment has been successfully processed.</p>";
        } else {
            echo "<h1>Error updating order status!</h1>";
            echo "<p>Please contact support.</p>";
        }
    } else {
        // Payment validation failed
        echo "<h1>Payment Validation Failed!</h1>";
        echo "<p>There was an issue validating your payment. Please contact support.</p>";
    }
} else {
    echo "<h1>Invalid Response!</h1>";
    echo "<p>No payment data received. Please contact support.</p>";
}

include('include/footer.php');
?>
