<?php
session_start(); // Start or resume the session

// Check if the user is signed in
if (!isset($_SESSION['userid'])) {
    header("Location: signin.php");
    exit();
}

include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Include header without session_start() inside it
include('include/without.php');

$userID = $_SESSION['userid']; // Get user ID from session

// SQL query to select user data
$sql = "SELECT userid, name, email, phone FROM customers WHERE userid = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// SQL query to fetch user orders
$orderSql = "SELECT o.orderid, o.pid, p.pname, p.pimage, o.quantity, o.price, o.totalprice, o.status
             FROM orders o
             JOIN products p ON o.pid = p.pid
             WHERE o.userid = ?";
$orderStmt = $conn->prepare($orderSql);
if (!$orderStmt) {
    die("Prepare failed: " . $conn->error);
}
$orderStmt->bind_param("i", $userID);
$orderStmt->execute();
$orderResult = $orderStmt->get_result();

if ($orderResult->num_rows > 0) {
    $orders = $orderResult->fetch_all(MYSQLI_ASSOC);
} else {
    $orders = [];
}
$orderStmt->close();
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
        /* Unique styling for the user dashboard */
        .dashboard-header {
            text-align: center;
            margin-top: 20px;
        }

        .navbar {
            display: flex;
            justify-content: center;
            background-color: #007bff;
            padding: 10px;
        }

        .navbar a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            text-align: center;
        }

        .navbar a:hover {
            background-color: #0056b3;
        }

        .content-section {
            display: none;
            margin: 20px;
        }

        .content-section.active {
            display: block;
        }

        .user-info-table {
            width: 60%;
            margin: 20px auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .user-info-table th, .user-info-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .user-info-table th {
            background-color: #f2f2f2;
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

        /* Styles for the orders table */
        .orders-table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .orders-table th, .orders-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .orders-table th {
            background-color: #007bff;
            color: white;
        }

        .orders-table td img {
            max-width: 50px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .orders-table td:last-child {
            text-align: center;
        }

        /* CSS for status display */
        .status-display {
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 14px;
            background-color: #e9ecef;
            color: #495057;
            text-align: center;
        }
    </style>
    <script>
        function showSection(sectionId) {
            // Hide all sections
            var sections = document.getElementsByClassName('content-section');
            for (var i = 0; i < sections.length; i++) {
                sections[i].classList.remove('active');
            }

            // Show the selected section
            document.getElementById(sectionId).classList.add('active');
        }

        // Show the "User Information" section by default
        document.addEventListener('DOMContentLoaded', function() {
            showSection('user-info');
        });
    </script>
</head>
<body>



<div class="main-content">
    <h2 class="dashboard-header">Welcome, <?php echo htmlspecialchars($user['name']); ?></h2>

    <div class="navbar">
        <a href="javascript:void(0)" onclick="showSection('user-info')">User Information</a>
        <a href="javascript:void(0)" onclick="showSection('orders')">Orders</a>
        <a href="javascript:void(0)" onclick="showSection('manage-password')">Manage Password</a>
        <a href="javascript:void(0)" onclick="showSection('delete-account')">Delete Account</a>
    </div>

    <div id="user-info" class="content-section active">
        <h3 class="dashboard-header">User Information</h3>
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
    </div>

    <div id="orders" class="content-section">
        <h3 class="dashboard-header">Your Orders</h3>
        <table class="orders-table">
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
                            <td><?php echo htmlspecialchars($order['pid']); ?></td>
                            <td><?php echo htmlspecialchars($order['pname']); ?></td>
                            <td><img src="<?php echo htmlspecialchars($order['pimage']); ?>" alt="Product Image"></td>
                            <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($order['price']); ?></td>
                            <td><?php echo htmlspecialchars($order['totalprice']); ?></td>
                            <td>
                                <span class="status-display">
                                    <?php echo htmlspecialchars($order['status']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align: center;">No orders found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div id="manage-password" class="content-section">
        <h3 class="dashboard-header">Manage Password</h3>
        <!-- Add your form or functionality for managing the password here -->
    </div>

    <div id="delete-account" class="content-section">
        <h3 class="dashboard-header">Delete Account</h3>
        <!-- Add your form or functionality for deleting the account here -->
    </div>

    <a href="logout.php" class="logout-button">Logout</a>
</div>

<?php include('include/footer.php'); ?>

</body>
</html>
