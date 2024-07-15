<?php
include('D:\xampp\htdocs\accessiomart\admin\include\connectdb.php');

// Fetch all categories from the database for the dropdown
$categoriesQuery = "SELECT cid, category_name FROM categories";
$categoriesResult = $conn->query($categoriesQuery);

// Process form submission if a product is added
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $productName = $_POST['productName'];
    $productPrice = $_POST['productPrice'];
    $productDescription = $_POST['productDescription'];
    $categoryId = $_POST['categoryId'];

    // Handle image upload if provided
    $productImage = ''; // Initialize empty for now
    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "uploads/"; // Directory where images will be stored
        $fileName = basename($_FILES['productImage']['name']);
        $targetFilePath = $targetDir . $fileName;

        // Check if uploads directory exists, if not create it
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['productImage']['tmp_name'], $targetFilePath)) {
            $productImage = $targetFilePath;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    $insertQuery = "INSERT INTO products (pname, pimage, price, description, cid) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ssdsi", $productName, $productImage, $productPrice, $productDescription, $categoryId);
    if ($stmt->execute()) {
        $stmt->close();
        // Redirect to products.php to prevent form resubmission on refresh
        header("Location: products.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Fetch products for display
$selectQuery = "SELECT pid, pname, pimage, price, description, category_name, p.cid FROM products p JOIN categories c ON p.cid = c.cid";
$result = $conn->query($selectQuery);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .main-content {
            margin-left: 250px; 
            padding: 20px;
        }
        .container form {
            max-width: 600px;
            margin-bottom: 20px;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .container form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        .container form input[type="text"],
        .container form input[type="number"],
        .container form textarea,
        .container form select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }
        .container form button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .container form button[type="submit"]:hover {
            background-color: #45a049;
        }
        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .product-table th,
        .product-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .product-table th {
            background-color: #f2f2f2;
        }
        .product-table img {
            max-width: 100px;
            height: auto;
            display: block;
            margin: 0 auto;
        }
        .product-table td:first-child {
            width: 5%;
        }
        .product-table td:last-child {
            text-align: center;
        }
        .product-table a {
            color: #007bff;
            text-decoration: none;
        }
        .product-table a:hover {
            text-decoration: underline;
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>Admin Portal</h2>
        </div>
        <ul class="nav-links">
            <li><a href="adminportal.php">Dashboard</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="admins.php">Admins</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h2>Add Product</h2>
        <div class="container">
            <form action="products.php" method="POST" enctype="multipart/form-data">
                <label for="productName">Product Name:</label>
                <input type="text" id="productName" name="productName" required>
                
                <label for="productImage">Product Image:</label>
                <input type="file" id="productImage" name="productImage">
                
                <label for="productPrice">Price:</label>
                <input type="number" id="productPrice" name="productPrice" step="0.01" required>
                
                <label for="productDescription">Description:</label>
                <textarea id="productDescription" name="productDescription" rows="5" maxlength="300" required></textarea>
                
                <label for="categoryId">Category:</label>
                <select id="categoryId" name="categoryId" required>
                    <option value="">Select Category</option>
                    <?php
                    // Fetch categories for the form
                    if ($categoriesResult->num_rows > 0) {
                        while ($row = $categoriesResult->fetch_assoc()) {
                            echo "<option value='" . $row['cid'] . "'>" . $row['category_name'] . "</option>";
                        }
                    }
                    ?>
                </select>
                
                <button type="submit" name="submit">Add Product</button>
            </form>

            <h2>Products</h2>
            <table class="product-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr id='product-row-" . $row['pid'] . "'>";
                                echo "<td>" . $row['pid'] . "</td>";
                                echo "<td>" . $row['pname'] . "</td>";
                                echo "<td><img src='" . $row['pimage'] . "' alt='Product Image' style='max-width: 100px;'></td>";
                                echo "<td>" . $row['description'] . "</td>";
                                echo "<td>" . $row['category_name'] . "</td>";
                                echo "<td>$" . number_format($row['price'], 2) . "</td>";
                                echo "<td>";
                                echo "<button onclick='openEditModal('" . $row['pid'] . "', '" . htmlspecialchars($row['pname'], ENT_QUOTES) . "', '" . htmlspecialchars($row['pimage'], ENT_QUOTES) . "', '" . $row['price'] . "', '" . htmlspecialchars($row['description'], ENT_QUOTES) . "', '" . $row['cid'] . "')'>Update</button>";
                                echo "<button onclick='deleteProduct(" . $row['pid'] . ")'>Delete</button>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No products found.</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal for editing product details -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="openEditModal()">&times;</span>
            <h2>Edit Product</h2>
            <form id="editForm" action="products.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="editProductId" name="editProductId">
                
                <label for="editProductName">Product Name:</label>
                <input type="text" id="editProductName" name="editProductName" required>
                
                <label for="editProductImage">Product Image:</label>
                <input type="file" id="editProductImage" name="editProductImage">
                
                <label for="editProductPrice">Price:</label>
                <input type="number" id="editProductPrice" name="editProductPrice" step="0.01" required>
                
                <label for="editProductDescription">Description:</label>
                <textarea id="editProductDescription" name="editProductDescription" rows="5" maxlength="300" required></textarea>
                
                <label for="editCategoryId">Category:</label>
                <select id="editCategoryId" name="editCategoryId" required>
                    <?php
                    // Fetch categories for the edit form
                    $categoriesResult->data_seek(0); // Reset the result pointer
                    if ($categoriesResult->num_rows > 0) {
                        while ($row = $categoriesResult->fetch_assoc()) {
                            echo "<option value='" . $row['cid'] . "'>" . $row['category_name'] . "</option>";
                        }
                    }
                    ?>
                </select>
                
                <button type="submit" name="update">Update Product</button>
            </form>
        </div>
    </div>
    <script>
        // JavaScript functions for modal operations and AJAX delete

        function openEditModal(pid, pname, pimage, price, description, cid) {
    document.getElementById('editProductId').value = pid;
    document.getElementById('editProductName').value = pname;
    document.getElementById('editProductImage').value = pimage;
    document.getElementById('editProductPrice').value = price;
    document.getElementById('editProductDescription').value = description;
    document.getElementById('editCategoryId').value = cid;

    document.getElementById('editModal').style.display = "block";
}

        function closeEditModal() {
            document.getElementById('editModal').style.display = "none";
        }

        function deleteProduct(pid) {
        if (confirm("Are you sure you want to delete this product?")) {
            // Create AJAX request to delete product
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "deleteproduct.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        document.getElementById('product-row-' + pid).remove();
                    } else {
                        alert("Error deleting product: " + response.message);
                    }
                }
            };
            xhr.send("productId=" + pid);
        }
    }
    </script>
</body>
</html>
