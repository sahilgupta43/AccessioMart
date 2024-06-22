<?php 
include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');
include('include/header.php');

$sql = "SELECT pid, pname, price, pimage FROM products";
$result = $conn->query($sql);

$products = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
} else {
    echo "0 results";
}

// Function to add product to wishlist
function addToWishlist($productId) {
    $_SESSION['wishlist'][$productId] = true;
}

// Function to remove product from wishlist
function removeFromWishlist($productId) {
    if (isset($_SESSION['wishlist'][$productId])) {
        unset($_SESSION['wishlist'][$productId]);
    }
}

// Check if 'add_to_wishlist' parameter is set (simulating a form submission or button click)
if (isset($_GET['add_to_wishlist'])) {
    $productId = $_GET['add_to_wishlist'];
    addToWishlist($productId);
}

// Check if 'remove_from_wishlist' parameter is set (simulating a form submission or button click)
if (isset($_GET['remove_from_wishlist'])) {
    $productId = $_GET['remove_from_wishlist'];
    removeFromWishlist($productId);
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <style>
        .product-card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 16px;
            margin: 16px;
            text-align: center;
            width: 250px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .product-image {
            width: 100%;
            height: auto;
            border-radius: 10px;
            cursor: pointer; /* Add cursor pointer to indicate clickable */
        }
        .product-name {
            font-size: 18px;
            margin: 16px 0;
        }
        .product-price {
            font-size: 16px;
            color: green;
            margin: 8px 0;
        }
        .button {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .add-to-cart {
            background-color: #28a745;
            color: white;
        }
        .wishlist {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>

<div class="product-container">
    <?php foreach ($products as $product): ?>
    <div class="product-card">
        <a href="singleproduct.php?id=<?php echo $product['pid']; ?>">
            <img src="<?php echo $product['pimage']; ?>" alt="<?php echo $product['pname']; ?>" class="product-image">
        </a>
        <div class="product-name"><?php echo $product['pname']; ?></div>
        <div class="product-price">$<?php echo $product['price']; ?></div>
        <form action="index.php" method="GET">
            <input type="hidden" name="add_to_wishlist" value="<?php echo $product['pid']; ?>">
            <button type="submit" class="button wishlist">Add to Wishlist</button>
        </form>
    </div>
    <?php endforeach; ?>
</div>
<?php include('include/footer.php') ?>
</body>
</html>
