<?php
// Include the database connection file
include('admin/include/connectdb.php');

// Get the search query from the URL
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Check if the query is not empty
if (!empty($query)) {
    // Prepare the SQL query to search for products
    $stmt = $conn->prepare("SELECT * FROM products WHERE pname LIKE ? OR description LIKE ?");
    $searchTerm = '%' . $query . '%';
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - AccessioMart</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- Header (you can include your existing header here) -->
    <?php include('include/header.php'); ?>

    <!-- Main Content -->
    <main>
        <h1>Search Results</h1>
        <?php if ($result && $result->num_rows > 0): ?>
            <div class="search-results">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="product-card">
                        <img src="admin/uploads/<?php echo htmlspecialchars($row['pimage']); ?>" alt="<?php echo htmlspecialchars($row['pname']); ?>">
                        <h2><?php echo htmlspecialchars($row['pname']); ?></h2>
                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                        <p>Price: <?php echo htmlspecialchars($row['price']); ?></p>
                        <button onclick="addToCart(<?php echo $row['pid']; ?>)">Add to Cart</button>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No results found for "<?php echo htmlspecialchars($query); ?>"</p>
        <?php endif; ?>
    </main>

    <!-- Footer (you can include your existing footer here) -->
    <?php include('include/footer.php'); ?>

    <script src="js/script.js"></script>
    <script>
        function addToCart(productId) {
            // Implement the logic to add the product to the cart
            alert('Product ' + productId + ' added to cart!');
        }
    </script>
</body>
</html>
