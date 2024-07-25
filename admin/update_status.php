<?php
include('include/connectdb.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $order_id = filter_var($_POST['order_id'], FILTER_SANITIZE_NUMBER_INT);
    $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);

    // Debugging output
    echo "Order ID: " . htmlspecialchars($order_id) . "<br>";
    echo "Status: " . htmlspecialchars($status) . "<br>";

    // Prepare and execute query
    $query = "UPDATE orders SET status = ? WHERE orderid = ?";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param('si', $status, $order_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("Location: orders.php?message=Update%20Successfully");
        } else {
            header("Location: orders.php?message=Failed%20to%20update%20status");
        }
        
        $stmt->close();
    } else {
        echo "Failed to prepare statement.";
    }
}

$conn->close();
?>
