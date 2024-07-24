<?php
include('include/connectdb.php');

// Check if category name exists
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryName = trim($_POST['categoryName']);
    
    // Validate category name (only alphabets and numbers)
    if (!preg_match('/^[a-zA-Z0-9]+$/', $categoryName)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid category name']);
        exit;
    }

    $checkQuery = "SELECT cid FROM categories WHERE category_name = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $categoryName);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['status' => 'exists']);
    } else {
        echo json_encode(['status' => 'not_exists']);
    }
    
    $stmt->close();
    $conn->close();
}
?>
