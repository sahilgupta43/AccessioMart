<?php
session_start(); // Start or resume the session

// Check if the user is signed in
if (!isset($_SESSION['userid'])) {
    header("Location: signin.php");
    exit();
}

include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');

// Include header without session_start() inside it
include('include/without.php');

$userID = $_SESSION['userid']; // Get user ID from session

// SQL query to select user data
$sql = "SELECT userid, name, email, phone FROM customers WHERE userid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// SQL query to fetch user orders
$sql_orders = "SELECT o.orderid, o.productid, p.pname, p.pimage, o.quantity, p.price, (o.quantity * p.price) AS total_price, o.status 
                FROM orders o 
                JOIN products p ON o.productid = p.pid 
                WHERE o.userid = ?";
$stmt_orders = $conn->prepare($sql_orders);
$stmt_orders->bind_param("i", $userID);
$stmt_orders->execute();
$result_orders = $stmt_orders->get_result();
$orders = $result_orders->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$stmt_orders->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* styles.css */
        /* Unique styling for the user dashboard */
        .dashboard-header {
            text-align: center;
            margin-top: 20px;
            font-size: 24px;
            color: #333;
        }

        .user-info-table, .order-table {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .user-info-table th, .order-table th, .user-info-table td, .order-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .user-info-table th, .order-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .order-table img {
            width: 50px;
            height: auto;
            border-radius: 4px;
        }

        .logout-button {
            display: block;
            width: 120px;
            margin: 20px auto;
            text-align: center;
            padding: 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .logout-button:hover {
            background-color: #0056b3;
        }

        .order-table td {
            vertical-align: middle;
        }

        .order-table tr:hover {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

<h2 class="dashboard-header">Welcome, <?php echo htmlspecialchars($user['name']); ?></h2>

<!-- User Info Table -->
<table class="user-info-table">
    <tr>
        <th>Name</th>
        <td><?php echo htmlspecialchars($user['name']); ?></td>
    </tr>
    <tr>
        <th>Email</th>
        <td><?php echo htmlspecialchars($user['email']); ?></td>
    </tr>
    <tr>
        <th>Phone</th>
        <td><?php echo htmlspecialchars($user['phone']); ?></td>
    </tr>
</table>

<!-- Orders Table -->
<h2 class="dashboard-header">Your Orders</h2>
<table class="order-table">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Product Image</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total Price</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['orderid']); ?></td>
                    <td><?php echo htmlspecialchars($order['productid']); ?></td>
                    <td><?php echo htmlspecialchars($order['pname']); ?></td>
                    <td><img src="admin/<?php echo htmlspecialchars($order['pimage']); ?>" alt="<?php echo htmlspecialchars($order['pname']); ?>"></td>
                    <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                    <td>$<?php echo htmlspecialchars($order['price']); ?></td>
                    <td>$<?php echo htmlspecialchars($order['total_price']); ?></td>
                    <td><?php echo htmlspecialchars($order['status']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8">No orders found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<a href="logout.php" class="logout-button">Logout</a>

</body>
</html>
