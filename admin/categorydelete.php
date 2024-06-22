<?php
    // Include database connection
    include('include/connectdb.php');

    // Check if category ID is provided and numeric
    if (isset($_GET['cid']) && is_numeric($_GET['cid'])) {
        $categoryId = $_GET['cid'];

        // Prepare delete statement
        $deleteQuery = "DELETE FROM categories WHERE cid = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $categoryId);

        // Execute delete query
        if ($stmt->execute()) {
            // Return JSON response for success
            echo json_encode(['status' => 'success']);
        } else {
            // Return JSON response for failure
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete category']);
        }

        // Close statement
        $stmt->close();
    } else {
        // Return JSON response for invalid request
        echo json_encode(['status' => 'error', 'message' => 'Invalid category ID']);
    }

    // Close database connection
    $conn->close();
?>
