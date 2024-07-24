<?php
// Include database connection and header
include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');
include('include/header.php');

// Fetch product details by product ID
if (isset($_GET['pid'])) {
    $productId = $_GET['pid'];
    $sql = "SELECT * FROM products WHERE pid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
} else {
    echo "Product ID is missing.";
    exit;
}

// Fetch some suggested products (for example, the first 4 products)
$sql_suggestions = "SELECT pid, pname, price, pimage FROM products WHERE pid != ? LIMIT 4";
$stmt_suggestions = $conn->prepare($sql_suggestions);
$stmt_suggestions->bind_param("i", $productId);
$stmt_suggestions->execute();
$result_suggestions = $stmt_suggestions->get_result();
$suggested_products = $result_suggestions->fetch_all(MYSQLI_ASSOC);

// Close database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width==device-width, initial-scale=1.0">
    <title>Product Details</title>
    <style>
        .product-details {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .product-details img {
            width: 300px;
            height: auto;
            border-radius: 10px;
        }
        .product-details .product-name {
            font-size: 24px;
            margin: 16px 0;
        }
        .product-details .product-price {
            font-size: 20px;
            color: green;
            margin: 8px 0;
        }
        .suggestions {
            margin-top: 50px;
            text-align: center;
        }
        .suggestions h2 {
            font-size: 22px;
        }
        .suggestions .product-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }
        .suggestions .product-card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 16px;
            margin: 16px;
            text-align: center;
            width: 200px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .suggestions .product-card img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<div class="product-details">
    <img src="admin/<?php echo $product['pimage']; ?>" alt="<?php echo $product['pname']; ?>">
    <div class="product-name"><?php echo $product['pname']; ?></div>
    <div class="product-price">$<?php echo $product['price']; ?></div>
    <div class="product-description"><?php echo $product['description']; ?></div>
</div>

<div class="suggestions">
    <h2>Suggested Products</h2>
    <div class="product-container">
        <?php foreach ($suggested_products as $suggested_product): ?>
        <div class="product-card">
            <img src="admin/<?php echo $suggested_product['pimage']; ?>" alt="<?php echo $suggested_product['pname']; ?>">
            <div class="product-name"><?php echo $suggested_product['pname']; ?></div>
            <div class="product-price">$<?php echo $suggested_product['price']; ?></div>
            <a href="productdetails.php?pid=<?php echo $suggested_product['pid']; ?>">View Details</a>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include('include/footer.php') ?>
<script src="js/search.js"></script>

</body>
</html>
