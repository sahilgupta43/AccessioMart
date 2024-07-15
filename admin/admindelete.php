<?php
    // Include database connection
    include('include/connectdb.php');

    // Check if adminId is set and it's a numeric value
    if (isset($_POST['adminId']) && is_numeric($_POST['adminId'])) {
        $adminId = $_POST['adminId'];

        // Prepare and execute delete query
        $deleteQuery = "DELETE FROM admintbl WHERE id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $adminId);

        if ($stmt->execute()) {
            // Return success JSON response
            echo json_encode(['status' => 'success']);
        } else {
            // Return error JSON response
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete admin']);
        }

        // Close statement
        $stmt->close();
    } else {
        // Return error JSON response if adminId is not provided or invalid
        echo json_encode(['status' => 'error', 'message' => 'Invalid admin ID']);
    }

    // Close database connection
    $conn->close();
?>
