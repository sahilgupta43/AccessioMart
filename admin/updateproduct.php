<?php
include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['editProductId'];
    $productName = $_POST['editProductName'];
    $productPrice = $_POST['editProductPrice'];
    $productDescription = $_POST['editProductDescription'];
    $categoryId = $_POST['editCategoryId'];

    // Handle image upload if provided
    $productImage = $_POST['existingImage'];
    if (isset($_FILES['editProductImage']) && $_FILES['editProductImage']['error'] == 0) {
        $targetDir = "uploads/"; // Directory where images will be stored
        $fileName = basename($_FILES['editProductImage']['name']);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['editProductImage']['tmp_name'], $targetFilePath)) {
            $productImage = $targetFilePath;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error uploading image']);
            exit();
        }
    }

    $updateQuery = "UPDATE products SET pname = ?, pimage = ?, price = ?, description = ?, cid = ? WHERE pid = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssdsii", $productName, $productImage, $productPrice, $productDescription, $categoryId, $productId);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'product' => [
            'pid' => $productId,
            'pname' => $productName,
            'pimage' => $productImage,
            'price' => $productPrice,
            'description' => $productDescription,
            'cid' => $categoryId
        ]]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating product']);
    }
    $stmt->close();
    $conn->close();
}
?>
