<?php
include('include/connectdb.php');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=orders.xls');

// Function to fetch all orders from database
function fetchOrders($conn) {
    $selectQuery = "SELECT orderid, userid, name, pid, pname, pimage, price, quantity, totalprice FROM orders";
    $result = $conn->query($selectQuery);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

$orders = fetchOrders($conn);

echo "Order List: AccessioMart\n";
echo "Order ID\tUser ID\tName\tProduct ID\tProduct Name\tPrice\tQuantity\tTotal Price\n";

$totalSales = 0;
foreach ($orders as $order) {
    echo $order['orderid'] . "\t" . $order['userid'] . "\t" . $order['name'] . "\t" . $order['pid'] . "\t" . $order['pname'] . "\t" . $order['price'] . "\t" . $order['quantity'] . "\t" . $order['totalprice'] . "\n";
    $totalSales += $order['totalprice'];
}

echo "\nTotal Sales\t\t\t\t\t\t\t" . $totalSales . "\n";

$conn->close();
?>
