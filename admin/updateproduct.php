<?php
include('D:\xampp\htdocs\accessiomart\admin\include\connectdb.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productId = $_POST['editProductId'];
    $productName = $_POST['editProductName'];
    $productPrice = $_POST['editProductPrice'];
    $productDescription = $_POST['editProductDescription'];
    $categoryId = $_POST['editCategoryId'];

    // Handle image upload if provided
    $productImage = ''; // Initialize empty for now
    if (isset($_FILES['editProductImage']) && $_FILES['editProductImage']['size'] > 0) {
        $targetDir = "uploads/";
        $fileName = basename($_FILES['editProductImage']['name']);
        $targetFilePath = $targetDir . $fileName;
        if (move_uploaded_file($_FILES['editProductImage']['tmp_name'], $targetFilePath)) {
            $productImage = $targetFilePath;
        } else {
            echo json_encode(array("status" => "error", "message" => "Failed to upload image."));
            exit;
        }
    }

    // Update product in database
    $updateQuery = "UPDATE products SET pname=?, pimage=?, price=?, description=?, cid=? WHERE pid=?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssdsii", $productName, $productImage, $productPrice, $productDescription, $categoryId, $productId);
    if ($stmt->execute()) {
        $stmt->close();

        // Fetch updated product details
        $selectUpdatedQuery = "SELECT pid, pname, pimage, price, description, category_name FROM products p JOIN categories c ON p.cid = c.cid WHERE pid=?";
        $stmt = $conn->prepare($selectUpdatedQuery);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();

        echo json_encode(array("status" => "success", "product" => $product));
        exit;
    } else {
        echo json_encode(array("status" => "error", "message" => "Failed to update product."));
        exit;
    }
}

// Close database connection
$conn->close();
?>
