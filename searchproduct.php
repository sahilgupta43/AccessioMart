<?php
// Include database connection and header
include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');
include('include/header.php');

// Start session to persist cart and wishlist data across pages
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize search query
$searchQuery = isset($_GET['search_query']) ? $_GET['search_query'] : '';

// SQL query to fetch products from database based on search query
$sql = "SELECT pid, pname, price, pimage FROM products";
if ($searchQuery) {
    $sql .= " WHERE pname LIKE '%" . $conn->real_escape_string($searchQuery) . "%'";
}
$result = $conn->query($sql);

// Array to store fetched products
$products = array();

// Fetch products and store in $products array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
} else {
    echo "No results found";
}

// Function to add product to cart
function addToCart($productId) {
    global $products;
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity']++;
    } else {
        $product = getProductById($productId);
        $_SESSION['cart'][$productId] = array(
            'name' => $product['pname'],
            'price' => $product['price'],
            'image' => $product['pimage'],
            'quantity' => 1,
        );
    }
}

// Function to get product details by ID
function getProductById($productId) {
    global $products;
    foreach ($products as $product) {
        if ($product['pid'] == $productId) {
            return $product;
        }
    }
    return null;
}

// Check if 'add_to_cart' parameter is set (simulating a form submission or button click)
if (isset($_GET['add_to_cart'])) {
    $productId = $_GET['add_to_cart'];
    addToCart($productId);
}

// Function to add product to wishlist
function addToWishlist($productId) {
    $_SESSION['wishlist'][$productId] = true;
}

// Check if 'add_to_wishlist' parameter is set (simulating a form submission or button click)
if (isset($_GET['add_to_wishlist'])) {
    $productId = $_GET['add_to_wishlist'];
    addToWishlist($productId);
}

// Close database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <style>
        .product-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
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
        <img src="admin/<?php echo $product['pimage']; ?>" alt="<?php echo $product['pname']; ?>" class="product-image">
        <div class="product-name"><?php echo $product['pname']; ?></div>
        <div class="product-price">$<?php echo $product['price']; ?></div>
        <form action="searchproduct.php" method="GET">
            <input type="hidden" name="add_to_cart" value="<?php echo $product['pid']; ?>">
            <button type="submit" class="button add-to-cart">Add to Cart</button>
        </form>
        <form action="searchproduct.php" method="GET">
            <input type="hidden" name="add_to_wishlist" value="<?php echo $product['pid']; ?>">
            <button type="submit" class="button wishlist">Add to Wishlist</button>
        </form>
    </div>
    <?php endforeach; ?>
</div>

<?php include('include/footer.php') ?>

</body>
</html>
