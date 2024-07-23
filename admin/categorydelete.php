<?php
include('include/connectdb.php');

// Process delete request
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['cid'])) {
    $categoryId = intval($_GET['cid']);

    // Delete category from database
    $deleteQuery = "DELETE FROM categories WHERE cid = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $categoryId);

    if ($stmt->execute()) {
        $stmt->close();
        echo json_encode(['status' => 'success', 'message' => 'Category deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete category: ' . $stmt->error]);
    }

    $conn->close();
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
?>
