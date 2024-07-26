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
$orderSql = "SELECT o.orderid, o.pid, p.pname, o.pimage, o.quantity, o.price, o.totalprice, o.status
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
        /* Unique styling for the user dashboard - specific to main content */
        .main-content {
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        .dashboard-header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px;
        }

        .dashboard-header {
            margin: 0;
        }

        .logout-button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            border: none;
        }

        .logout-button:hover {
            background-color: #0056b3;
        }

        .navbar-user {
            display: flex;
            justify-content: center;
            padding: 10px;
        }

        .navbar-user a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            text-align: center;
            border: 2px solid green;
            background-color: #2b2b1f;
            border-radius: 14px;
            margin: 2px;
        }

        .navbar-user a:hover {
            background-color: #0056b3;
        }

        .content-section {
            display: none;
            margin: 20px 0;
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

        .status-display {
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 14px;
            background-color: #e9ecef;
            color: #495057;
            text-align: center;
        }

        .form-group {
            margin: 20px auto;
            width: 80%;
            max-width: 400px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .update-button {
            display: block;
            padding: 10px;
            background-color: #007bff;
            color: white;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 20px auto;
        }

        .update-button:hover {
            background-color: #0056b3;
        }

        .success-message {
            color: green;
            text-align: center;
            margin-top: 20px;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }

        .message {
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
            padding: 10px;
            border-radius: 5px;
        }
        .message.success {
            color: green;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            color: red;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }
    </style>
    <script>
        function showSection(sectionId) {
            var sections = document.getElementsByClassName('content-section');
            for (var i = 0; i < sections.length; i++) {
                sections[i].classList.remove('active');
            }
            document.getElementById(sectionId).classList.add('active');
        }

        document.addEventListener('DOMContentLoaded', function() {
            showSection('user-info');
        });

        function validatePassword(password) {
            var pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            return pattern.test(password);
        }

        function updatePassword() {
            var currentPassword = document.getElementById('current-password').value;
            var newPassword = document.getElementById('new-password').value;
            var confirmNewPassword = document.getElementById('confirm-new-password').value;
            var errorMessage = document.getElementById('error-message');
            var successMessage = document.getElementById('success-message');

            if (newPassword !== confirmNewPassword) {
                errorMessage.textContent = 'New passwords do not match.';
                return false;
            }

            if (!validatePassword(newPassword)) {
                errorMessage.textContent = 'Password must be at least 8 characters long and include an uppercase letter, a lowercase letter, a number, and a special character.';
                return false;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_password.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    if (xhr.responseText === 'success') {
                        successMessage.textContent = 'Password successfully changed.';
                    } else {
                        errorMessage.textContent = xhr.responseText;
                    }
                } else {
                    errorMessage.textContent = 'An error occurred while updating the password.';
                }
            };
            xhr.send('current_password=' + encodeURIComponent(currentPassword) + '&new_password=' + encodeURIComponent(newPassword));
        }

        
    </script>
</head>
<body>
    <div class="dashboard-header-container">
        <h1 class="dashboard-header">Welcome, <?php echo htmlspecialchars($user['name']); ?></h1>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>

    <div class="navbar-user">
        <a href="javascript:void(0);" onclick="showSection('user-info')">User Information</a>
        <a href="javascript:void(0);" onclick="showSection('orders')">Orders</a>
        <a href="javascript:void(0);" onclick="showSection('manage-password')">Manage Password</a>
        <a href="delete_account.php" onclick="return confirm('Are you sure you want to delete your account?');">Delete Account</a>
    </div>

    <?php if (isset($_GET['message'])): ?>
        <div class="message success"><?php echo htmlspecialchars($_GET['message']); ?></div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="message error"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>

    <div id="user-info" class="content-section">
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
        <?php if (count($orders) > 0): ?>
            <table class="orders-table">
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
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['orderid']); ?></td>
                        <td><?php echo htmlspecialchars($order['pid']); ?></td>
                        <td><?php echo htmlspecialchars($order['pname']); ?></td>
                        <td><img src="<?php echo htmlspecialchars($order['pimage']); ?>" alt="<?php echo htmlspecialchars($order['pname']); ?>"></td>
                        <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($order['price']); ?></td>
                        <td><?php echo htmlspecialchars($order['totalprice']); ?></td>
                        <td><span class="status-display"><?php echo htmlspecialchars($order['status']); ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No orders found.</p>
        <?php endif; ?>
    </div>

    <div id="manage-password" class="content-section">
        <div id="error-message" class="error-message"></div>
        <div id="success-message" class="success-message"></div>
        <div class="form-group">
            <label for="current-password">Current Password</label>
            <input type="password" id="current-password" name="current-password" required>
        </div>
        <div class="form-group">
            <label for="new-password">New Password</label>
            <input type="password" id="new-password" name="new-password" required>
        </div>
        <div class="form-group">
            <label for="confirm-new-password">Confirm New Password</label>
            <input type="password" id="confirm-new-password" name="confirm-new-password" required>
        </div>
        <button class="update-button" onclick="updatePassword()">Update Password</button>
    </div>
    <?php include('include/footer.php') ?>
</body>
</html>
