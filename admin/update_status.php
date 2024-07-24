<?php
include('include/connectdb.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $query = "UPDATE orders SET status = ? WHERE orderid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $status, $order_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: orders.php?message=Update%20Successfully");
    } else {
        header("Location: orders.php?message=Failed%20to%20update%20status");
    }
    
    $stmt->close();
}
$conn->close();
?>
