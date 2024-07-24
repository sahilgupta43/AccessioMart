<?php
    // Include database connection and start session
    include('include/connectdb.php');

    // Function to fetch all orders from database
    function fetchOrders($conn) {
    $selectQuery = "SELECT orderid, userid, name, pid, pname, pimage, price, quantity, totalprice, status FROM orders";
    $result = $conn->query($selectQuery);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}


    // Fetch all orders
    $orders = fetchOrders($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        .main-content {
            margin-left: 250px; 
            padding: 20px;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }

        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .order-table th,
        .order-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .order-table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        .order-table td {
            background-color: #f9f9f9;
        }

        .order-table td img {
            max-width: 50px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .order-table td:last-child {
            text-align: center;
        }

        /* Export buttons styling */
        .export-buttons {
            margin-top: 20px;
        }

        .export-buttons button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-right: 10px;
            transition: background-color 0.3s;
        }

        .export-buttons button:hover {
            background-color: #0056b3;
        }
        <style>
    .order-table select {
        padding: 5px;
        border-radius: 4px;
        border: 1px solid #ddd;
        font-size: 14px;
    }

    .order-table button.update-btn {
        background-color: #28a745;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s;
    }

    .order-table button.update-btn:hover {
        background-color: #218838;
    }

    .order-table td:last-child {
        text-align: center;
    }

    /* Popup styling */
    .popup {
        display: none;
        position: fixed;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        padding: 20px;
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        z-index: 1000;
    }

    .popup button {
        background-color: #007bff;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .popup button:hover {
        background-color: #0056b3;
    }
</style>

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
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h2>Orders</h2>

        <!-- Orders Table -->
        <div class="orders-table">
            <table id="orderTable" class="order-table"><thead>
    <tr>
        <th>Order ID</th>
        <th>User ID</th>
        <th>Name</th>
        <th>Product ID</th>
        <th>Product Name</th>
        <th>Product Image</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total Price</th>
        <th>Status</th>
        <th>Action</th> <!-- Update action column -->
    </tr>
</thead>
<tbody>
    <?php foreach ($orders as $order): ?>
        <tr>
            <td><?php echo $order['orderid']; ?></td>
            <td><?php echo $order['userid']; ?></td>
            <td><?php echo $order['name']; ?></td>
            <td><?php echo $order['pid']; ?></td>
            <td><?php echo $order['pname']; ?></td>
            <td><img src="<?php echo $order['pimage']; ?>" alt="Product Image" width="50"></td>
            <td><?php echo $order['price']; ?></td>
            <td><?php echo $order['quantity']; ?></td>
            <td><?php echo $order['totalprice']; ?></td>
            <td>
                <form class="status-form" action="update_status.php" method="POST">
                    <input type="hidden" name="order_id" value="<?php echo $order['orderid']; ?>">
                    <select name="status">
                        <option value="Order Placed" <?php echo $order['status'] === 'Order Placed' ? 'selected' : ''; ?>>Order Placed</option>
                        <option value="Shipping" <?php echo $order['status'] === 'Shipping' ? 'selected' : ''; ?>>Shipping</option>
                        <option value="Delivered" <?php echo $order['status'] === 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                    </select>
                </form>
            </td>
            <td>
                <button class="update-btn" onclick="updateOrder('<?php echo $order['orderid']; ?>')">Update</button>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>



            </table>
        </div>

        <!-- Buttons for Exporting -->
        <div class="export-buttons">
            <button id="exportPdf">Generate PDF</button>
            <button id="exportExcel">Export to Excel</button>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#exportPdf').click(function() {
                window.location.href = 'exportpdf.php';
            });

            $('#exportExcel').click(function() {
                window.location.href = 'exportexcel.php';
            });
        });

        //popup

        function updateOrder(orderId) {
        // Submit the form
        var form = document.querySelector('.status-form');
        form.action = 'update_status.php'; // Ensure the form is pointed to the correct action
        form.submit();

        // Show the popup message
        var popup = document.createElement('div');
        popup.className = 'popup';
        popup.innerHTML = `
            <p>Update Successfully</p>
            <button onclick="closePopup()">OK</button>
        `;
        document.body.appendChild(popup);
        popup.style.display = 'block';

        // Automatically close the popup after 5 seconds
        setTimeout(function() {
            closePopup();
        }, 5000); // 5000 milliseconds = 5 seconds
    }

    function closePopup() {
        var popup = document.querySelector('.popup');
        if (popup) {
            document.body.removeChild(popup);
        }
    }
    </script>
</body>
</html>

<?php
    $conn->close();
?>
