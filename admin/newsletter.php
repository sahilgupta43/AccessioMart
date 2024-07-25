<?php
    // Include database connection
    include('include/connectdb.php');

    // Function to fetch all newsletter subscriptions from database
    function fetchSubscriptions($conn) {
        $selectQuery = "SELECT id, email FROM newsletter_subscriptions";
        $result = $conn->query($selectQuery);

        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    // Fetch all subscriptions
    $subscriptions = fetchSubscriptions($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter Subscriptions</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        .main-content {
            margin-left: 250px; 
            padding: 20px;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }

        .subscription-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .subscription-table th,
        .subscription-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .subscription-table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        .subscription-table td {
            background-color: #f9f9f9;
        }

        .subscription-table td:last-child {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>Admin Portal</h2>
        </div>
        <ul class="nav-links">
            <li><a href="adminportal.php">Dashboard</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="admins.php">Admins</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="users.php">Users</a></li>
            <li><a href="feedback.php">Feedback</a></li>
            <li><a href="newsletter.php">Newsletter</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h2>Newsletter Subscriptions</h2>

        <!-- Subscriptions Table -->
        <div class="subscriptions-table">
            <table id="subscriptionTable" class="subscription-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subscriptions as $subscription): ?>
                        <tr>
                            <td><?php echo $subscription['id']; ?></td>
                            <td><?php echo $subscription['email']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
    $conn->close();
?>
