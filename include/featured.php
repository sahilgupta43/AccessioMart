<?php
// Include database connection
include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');

// Fetch products with category name 'laptop'
$selectQuery = "SELECT pid, pname, price, pimage
                FROM products p
                INNER JOIN categories c ON p.cid = c.cid
                WHERE c.category_name = 'laptop' LIMIT 3";
$result = $conn->query($selectQuery);

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
                <h2 class="section-title">Featured Products</h2>
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
                    echo '<button class="btn btn-primary">Add to Cart</button>';
                    echo '<button class="btn btn-outline-secondary"><i class="far fa-heart"></i></button>';
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
