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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        main {
            padding: 20px;
        }

        h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
        }

        .search-results {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .product-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: center;
            padding: 15px;
            text-decoration: none;
            color: inherit;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .product-card img {
            width: 100%;
            height: auto;
            border-bottom: 1px solid #ddd;
        }

        .product-card h2 {
            font-size: 22px;
            color: #333;
            margin: 10px 0;
        }

        .product-card p {
            color: #555;
            margin: 5px 0;
            font-size: 16px;
        }

        .product-card .price {
            font-size: 18px;
            color: green;
            margin: 10px 0;
        }

        .product-card button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            margin-top: 10px;
        }

        .product-card button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .no-results {
            font-size: 18px;
            color: #777;
            text-align: center;
            margin-top: 50px;
        }
    </style>
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
                    <a href="productdetails.php?pid=<?php echo $row['pid']; ?>" class="product-card">
                        <img src="admin/<?php echo htmlspecialchars($row['pimage']); ?>" alt="<?php echo htmlspecialchars($row['pname']); ?>">
                        <h2><?php echo htmlspecialchars($row['pname']); ?></h2>
                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                        <p class="price">Price: $<?php echo htmlspecialchars($row['price']); ?></p>
                        <button>Add to Cart</button>
                    </a>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="no-results">No results found for "<?php echo htmlspecialchars($query); ?>"</p>
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
