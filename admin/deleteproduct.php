<?php
include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['productId'];

    $deleteQuery = "DELETE FROM products WHERE pid = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $productId);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error deleting product']);
    }
    $stmt->close();
    $conn->close();
}
?>
