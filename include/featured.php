<?php
// Include database connection
include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');

// Start session to persist cart and wishlist data across pages

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fetch products with category name 'laptop'
$selectQuery = "SELECT p.pid, p.pname, p.price, p.pimage
                FROM products p
                INNER JOIN categories c ON p.cid = c.cid
                WHERE c.category_name = 'laptop' LIMIT 3";
$result = $conn->query($selectQuery);

// Function to get product details by ID
function getProductById($productId) {
    global $conn;
    $sql = "SELECT pid, pname, price, pimage FROM products WHERE pid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
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
        header("Location: signin.php");
        exit();
    }
}

// Function to add product to wishlist
function addToWishlist($productId) {
    $_SESSION['wishlist'][$productId] = true;
}

// Handle add to cart action
if (isset($_GET['add_to_cart'])) {
    $productId = $_GET['add_to_cart'];
    addToCart($productId);
    header("Location: " . $_SERVER['PHP_SELF']); // Redirect to the same page to avoid resubmission
    exit();
}

// Handle add to wishlist action
if (isset($_GET['add_to_wishlist'])) {
    $productId = $_GET['add_to_wishlist'];
    addToWishlist($productId);
    header("Location: " . $_SERVER['PHP_SELF']); // Redirect to the same page to avoid resubmission
    exit();
}

// Close database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Featured Products</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Your custom CSS file -->
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-5Stm0lMkPCjfkVoCO91XAKzjtbrblZxViID9opJKzXu3eFuXDEPSsCmU4CTnuCOG7oOWo6v9lWZ8aMPrzDc/Ow==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 style="margin-top: 25px;" class="section-title">Featured Products</h2>
            </div>
        </div>
        <div id="featured-products" class="row">
            <?php
            // Check if there are any products found
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-lg-4 col-md-6 mb-4">';
                    echo '<div class="card">';
                    echo '<img src="admin/' . $row['pimage'] . '" class="card-img-top" alt="Product Image">'; // Adjusted path here
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row['pname'] . '</h5>';
                    echo '<p class="card-text">NPR ' . $row['price'] . '</p>';
                    echo '<div class="btn-group">';
                    echo '<a href="' . $_SERVER['PHP_SELF'] . '?add_to_cart=' . $row['pid'] . '" class="btn btn-primary">Add to Cart</a>';
                    echo '<a href="' . $_SERVER['PHP_SELF'] . '?add_to_wishlist=' . $row['pid'] . '" class="btn btn-outline-secondary"><i class="far fa-heart"></i></a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="col-12">';
                echo '<p>No laptops found.</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS and FontAwesome JS (for icons) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
