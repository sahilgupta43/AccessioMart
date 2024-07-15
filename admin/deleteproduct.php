<?php
// Include database connection
include('D:\xampp\htdocs\accessiomart\admin\include\connectdb.php');

// Check if productId is provided and numeric
if (isset($_POST['productId']) && is_numeric($_POST['productId'])) {
    $productId = $_POST['productId'];

    // Delete product from database
    $deleteQuery = "DELETE FROM products WHERE pid = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $productId);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error deleting product.']);
    }
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid productId.']);
}

// Close database connection
$conn->close();
?>
