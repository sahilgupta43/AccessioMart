<?php
// Include database connection
include('include/connectdb.php');

// Define the number of orders per page
$orders_per_page = 10; // Adjust this number as needed

// Determine the current page number
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the starting record for the current page
$start_from = ($page - 1) * $orders_per_page;

// Function to fetch orders from the database for the current page
function fetchOrders($conn, $start_from, $orders_per_page) {
    $selectQuery = "SELECT orderid, userid, name, pid, pname, pimage, price, quantity, totalprice, status FROM orders LIMIT ?, ?";
    $stmt = $conn->prepare($selectQuery);
    $stmt->bind_param("ii", $start_from, $orders_per_page);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

// Fetch orders for the current page
$orders = fetchOrders($conn, $start_from, $orders_per_page);

// Fetch total number of orders for pagination
$total_query = "SELECT COUNT(orderid) AS total FROM orders";
$total_result = $conn->query($total_query);
$total_orders = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_orders / $orders_per_page);

$conn->close();
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

        /* Pagination styling */
        .pagination {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .pagination a {
            color: #007bff;
            padding: 10px 15px;
            text-decoration: none;
            border: 1px solid #ddd;
            margin: 0 5px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .pagination a:hover {
            background-color: #f1f1f1;
        }

        .pagination a.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
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
        <h2>Orders</h2>

        <!-- Orders Table -->
        <div class="orders-table">
            <table id="orderTable" class="order-table">
                <thead>
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
                            <td><?php echo htmlspecialchars($order['orderid']); ?></td>
                            <td><?php echo htmlspecialchars($order['userid']); ?></td>
                            <td><?php echo htmlspecialchars($order['name']); ?></td>
                            <td><?php echo htmlspecialchars($order['pid']); ?></td>
                            <td><?php echo htmlspecialchars($order['pname']); ?></td>
                            <td><img src="<?php echo htmlspecialchars($order['pimage']); ?>" alt="Product Image" width="50"></td>
                            <td><?php echo htmlspecialchars($order['price']); ?></td>
                            <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($order['totalprice']); ?></td>
                            <td>
                                <form id="status-form-<?php echo $order['orderid']; ?>" class="status-form" action="update_status.php" method="POST">
                                    <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['orderid']); ?>">
                                    <select name="status" onchange="this.form.submit()">
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

        <!-- Pagination -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="orders.php?page=<?php echo $page - 1; ?>">&laquo; Prev</a>
            <?php endif; ?>
            
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="orders.php?page=<?php echo $i; ?>" class="<?php echo $page == $i ? 'active' : ''; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
            
            <?php if ($page < $total_pages): ?>
                <a href="orders.php?page=<?php echo $page + 1; ?>">Next &raquo;</a>
            <?php endif; ?>
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

        // Update Order function
        function updateOrder(orderId) {
            // Find the form for the specific order
            var form = document.getElementById('status-form-' + orderId);
            if (form) {
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
