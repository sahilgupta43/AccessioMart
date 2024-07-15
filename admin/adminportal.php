<?php

    include('include/connectdb.php');

    if (!isset($_SESSION['admin_id'])) {
        header("Location: login.php");
        exit();
    }

    // Fetch total customers
    $totalCustomersQuery = "SELECT COUNT(*) AS total_customers FROM customers";
    $totalCustomersResult = $conn->query($totalCustomersQuery);
    $totalCustomers = $totalCustomersResult->fetch_assoc()['total_customers'];

    // Fetch total sales
    $totalSalesQuery = "SELECT SUM(totalprice) AS total_sales FROM orders";
    $totalSalesResult = $conn->query($totalSalesQuery);
    $totalSales = $totalSalesResult->fetch_assoc()['total_sales'];

    // Fetch total products
    $totalProductsQuery = "SELECT COUNT(*) AS total_products FROM products";
    $totalProductsResult = $conn->query($totalProductsQuery);
    $totalProducts = $totalProductsResult->fetch_assoc()['total_products'];

    // Fetch total orders
    $totalOrdersQuery = "SELECT COUNT(*) AS total_orders FROM orders";
    $totalOrdersResult = $conn->query($totalOrdersQuery);
    $totalOrders = $totalOrdersResult->fetch_assoc()['total_orders'];

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
        <h2>Dashboard</h2>
        <div class="cards">
            <div class="card">
                <div class="card-icon">👤</div>
                <div class="card-info">
                    <h3>Total Customers</h3>
                    <p><?php echo $totalCustomers; ?></p>
                </div>
            </div>
            <div class="card">
                <div class="card-icon">💰</div>
                <div class="card-info">
                    <h3>Total Sales</h3>
                    <p>$<?php echo number_format($totalSales, 2); ?></p>
                </div>
            </div>
            <div class="card">
                <div class="card-icon">📦</div>
                <div class="card-info">
                    <h3>Total Products</h3>
                    <p><?php echo $totalProducts; ?></p>
                </div>
            </div>
            <div class="card">
                <div class="card-icon">🛒</div>
                <div class="card-info">
                    <h3>Total Orders</h3>
                    <p><?php echo $totalOrders; ?></p>
                </div>
            </div>
        </div>
        <canvas id="salesChart"></canvas>
    </div>
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                    label: 'Total Sales',
                    data: [1200, 1900, 3000, 5000, 2300, 3800, 4200, 3500, 2900, 4100, 4600, 5400], // Example data
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
