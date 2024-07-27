<?php
// Include database connection and header
session_start(); // Start or resume the session
include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');
include('include/without.php');

// Get category ID from URL
$cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;

// Pagination settings
$items_per_page = 10; // Number of products per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; // Current page
$offset = ($page - 1) * $items_per_page; // Offset for SQL query

// SQL query to count total number of products for the category
$total_query = "SELECT COUNT(*) AS total FROM products WHERE cid = ?";
$stmt_total = $conn->prepare($total_query);
$stmt_total->bind_param("i", $cid);
$stmt_total->execute();
$total_result = $stmt_total->get_result();
$total_row = $total_result->fetch_assoc();
$total_items = $total_row['total'];
$total_pages = ceil($total_items / $items_per_page);

// SQL query to fetch products for the specific category with pagination
$sql = "SELECT * FROM products WHERE cid = ? LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $cid, $items_per_page, $offset);
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
    echo "<p>No products found for this category.</p>";
}

// Close database connection
$stmt->close();
$stmt_total->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Products</title>
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
            color: #333;
        }
        .button {
            padding: 10px 20px;
            margin-top: 10px;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
        }
        .add-to-cart {
            background-color: #28a745;
        }
        .add-to-wishlist {
            background-color: #dc3545;
        }
        .back-link {
            display: inline-block;
            margin: 20px;
            text-decoration: none;
            color: #007bff;
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

<h1>Products in Category</h1>
<div class="product-container">
    <?php foreach ($products as $product): ?>
    <div class="product-card">
        <a href="productdetails.php?pid=<?php echo htmlspecialchars($product['pid']); ?>">
            <img src="admin/<?php echo htmlspecialchars($product['pimage']); ?>" alt="<?php echo htmlspecialchars($product['pname']); ?>" class="product-image">
            <div class="product-name"><?php echo htmlspecialchars($product['pname']); ?></div>
            <div class="product-price">NPR<?php echo htmlspecialchars($product['price']); ?></div>
        </a>
        <form action="cart.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['pid']); ?>">
            <button type="submit" class="button add-to-cart">Add to Cart</button>
        </form>
        <form action="wishlist.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['pid']); ?>">
            <button type="submit" class="button add-to-wishlist">Add to Wishlist</button>
        </form>
    </div>
    <?php endforeach; ?>
</div>

<!-- Pagination Links -->
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?cid=<?php echo $cid; ?>&page=<?php echo ($page - 1); ?>">Previous</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?cid=<?php echo $cid; ?>&page=<?php echo $i; ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
        <a href="?cid=<?php echo $cid; ?>&page=<?php echo ($page + 1); ?>">Next</a>
    <?php endif; ?>
</div>

<a href="categories.php" class="back-link">Back to Categories</a>

<?php include('include/footer.php') ?>

</body>
</html>
