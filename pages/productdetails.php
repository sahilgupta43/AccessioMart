<?php
// Include database connection and header
session_start(); // Start or resume the session
$userID = $_SESSION['userid'];
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .go-back {
            display: flex;
            align-items: center;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .go-back a {
            text-decoration: none;
            color: #007bff;
            font-size: 18px;
            display: flex;
            align-items: center;
        }

        .go-back i {
            margin-right: 8px;
            font-size: 20px;
        }

        .product-details {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            max-width: 450px;
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }

        .product-details:hover {
            transform: scale(1.02);
        }

        .product-details img {
            width: 100%;
            max-width: 500px;
            height: auto;
            border-radius: 10px;
            transition: transform 0.3s ease-in-out;
        }

        .product-details img:hover {
            transform: scale(1.05);
        }

        .product-details .product-name {
            font-size: 28px;
            margin: 16px 0;
            color: #333;
        }

        .product-details .product-price {
            font-size: 24px;
            color: green;
            margin: 8px 0;
        }

        .product-details .product-description {
            font-size: 18px;
            color: #666;
            margin-top: 20px;
        }

        .product-details .buttons {
            margin-top: 20px;
        }

        .product-details .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            margin: 5px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .product-details .btn:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .product-details .btn.wishlist {
            background-color: #dc3545;
        }

        .product-details .btn.wishlist:hover {
            background-color: #c82333;
        }

        .suggestions {
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 100%;
            margin: 50px auto;
        }

        .suggestions h2 {
            text-align: center;
            font-size: 22px;
            color: #333;
            margin-bottom: 20px;
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
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            background-color: #fff;
        }

        .suggestions .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .suggestions .product-card img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            transition: transform 0.3s ease-in-out;
        }

        .suggestions .product-card img:hover {
            transform: scale(1.05);
        }

        .suggestions .product-name {
            font-size: 18px;
            color: #007bff;
            margin: 16px 0;
            transition: color 0.3s ease-in-out;
        }

        .suggestions .product-card:hover .product-name {
            color: #0056b3;
        }

        .suggestions .product-price {
            font-size: 16px;
            color: green;
            margin-bottom: 10px;
        }

        .suggestions .product-card a {
            text-decoration: none;
            color: #007bff;
            transition: color 0.3s ease-in-out;
        }

        .suggestions .product-card a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>

<div class="go-back">
    <a href="products.php"><i class="fas fa-arrow-left"></i> Back </a>
</div>

<div class="product-details">
    <img src="admin/<?php echo $product['pimage']; ?>" alt="<?php echo $product['pname']; ?>">
    <div class="product-name"><?php echo $product['pname']; ?></div>
    <div class="product-price">NPR<?php echo $product['price']; ?></div>
    <div class="product-description"><?php echo $product['description']; ?></div>
    <div class="buttons">
        <a href="cart.php?pid=<?php echo $product['pid']; ?>" class="btn">Add to Cart</a>
        <a href="wishlist.php?pid=<?php echo $product['pid']; ?>" class="btn wishlist">Add to Wishlist</a>
    </div>
</div>

<div class="suggestions">
    <h2>Suggested Products</h2>
    <div class="product-container">
        <?php foreach ($suggested_products as $suggested_product): ?>
        <div class="product-card">
            <a href="productdetails.php?pid=<?php echo $suggested_product['pid']; ?>">
                <img src="admin/<?php echo $suggested_product['pimage']; ?>" alt="<?php echo $suggested_product['pname']; ?>">
                <div class="product-name"><?php echo $suggested_product['pname']; ?></div>
                <div class="product-price">NPR<?php echo $suggested_product['price']; ?></div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include('include/footer.php') ?>
<script src="js/search.js"></script>

</body>
</html>
