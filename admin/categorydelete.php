<?php
    include('include/connectdb.php');

    if (isset($_GET['cid'])) {
        $cid = intval($_GET['cid']);

        // Prepare and execute the delete query
        $deleteQuery = "DELETE FROM categories WHERE cid = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $cid);

        if ($stmt->execute()) {
            // Return success response in JSON format
            echo json_encode(['status' => 'success']);
        } else {
            // Return error response in JSON format
            echo json_encode(['status' => 'error', 'message' => $stmt->error]);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid category ID']);
    }
?>
