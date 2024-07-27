<?php
// Include database connection and header
session_start(); // Start or resume the session

include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');
include('include/without.php');

// Pagination settings
$items_per_page = 8; // Number of products per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; // Current page
$offset = ($page - 1) * $items_per_page; // Offset for SQL query

// SQL query to count total number of products
$total_query = "SELECT COUNT(*) AS total FROM products";
$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_items = $total_row['total'];
$total_pages = ceil($total_items / $items_per_page);

// SQL query to fetch products with pagination
$sql = "SELECT pid, pname, price, pimage FROM products LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $items_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

// Array to store fetched products
$products = array();

// Fetch products and store in $products array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
} else {
    echo "0 results";
}

// Start session to persist cart and wishlist data across pages
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Function to add product to cart
function addToCart($productId) {
    global $products;

    // Ensure the user is logged in
    if (isset($_SESSION['userid'])) {
        $userId = $_SESSION['userid'];
        $cartKey = 'cart_' . $userId; // Create a unique cart key for the user

        // Initialize the user's cart if not already set
        if (!isset($_SESSION[$cartKey])) {
            $_SESSION[$cartKey] = array();
        }

        if (isset($_SESSION[$cartKey][$productId])) {
            $_SESSION[$cartKey][$productId]['quantity']++;
        } else {
            $product = getProductById($productId);
            $_SESSION[$cartKey][$productId] = array(
                'name' => $product['pname'],
                'price' => $product['price'],
                'image' => $product['pimage'],
                'quantity' => 1,
            );
        }
    } else {
        // Handle the case where the user is not logged in
        // You might want to redirect them to the login page or show a message
        echo "<script>window.location.href = 'signin.php';</script>";
        exit();
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
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
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
            cursor: pointer;
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
        .pagination {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        .pagination a {
            margin: 0 5px;
            padding: 10px 15px;
            border: 1px solid #007bff;
            border-radius: 5px;
            text-decoration: none;
            color: #007bff;
            font-size: 14px;
        }
        .pagination a.active {
            background-color: #007bff;
            color: white;
        }
        .pagination a:hover {
            background-color: #0056b3;
            color: white;
        }
    </style>
</head>
<body>

<div class="product-container">
    <?php foreach ($products as $product): ?>
    <div class="product-card">
        <a href="productdetails.php?pid=<?php echo $product['pid']; ?>">
            <img src="admin/<?php echo $product['pimage']; ?>" alt="<?php echo $product['pname']; ?>" class="product-image">
        </a>
        <div class="product-name"><?php echo $product['pname']; ?></div>
        <div class="product-price">NPR<?php echo $product['price']; ?></div>
        <form action="products.php" method="GET">
            <input type="hidden" name="add_to_cart" value="<?php echo $product['pid']; ?>">
            <button type="submit" class="button add-to-cart">Add to Cart</button>
        </form>
        <form action="products.php" method="GET">
            <input type="hidden" name="add_to_wishlist" value="<?php echo $product['pid']; ?>">
            <button type="submit" class="button wishlist">Add to Wishlist</button>
        </form>
    </div>
    <?php endforeach; ?>
</div>

<!-- Pagination Links -->
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=<?php echo ($page - 1); ?>">Previous</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?php echo $i; ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
        <a href="?page=<?php echo ($page + 1); ?>">Next</a>
    <?php endif; ?>
</div>

<?php include('include/footer.php') ?>
<script src="js/search.js"></script>

</body>
</html>
