<?php
// Include database connection
include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');

// Process form submission if category is added
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $categoryName = trim($_POST['categoryName']);
    if (empty($categoryName)) {
        echo json_encode(['status' => 'error', 'message' => 'Category name is required']);
        exit;
    }

    // Placeholder for image handling (if needed)
    $categoryImage = ''; // You may handle file uploads here if required

    // Insert category into database
    $insertQuery = "INSERT INTO categories (category_name, category_image) VALUES (?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ss", $categoryName, $categoryImage);

    if ($stmt->execute()) {
        // Fetch newly added category ID
        $newCategoryId = $stmt->insert_id;
        $stmt->close();

        // Fetch the newly added category details
        $selectQuery = "SELECT cid, category_name, category_image FROM categories WHERE cid = ?";
        $stmt = $conn->prepare($selectQuery);
        $stmt->bind_param("i", $newCategoryId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $category = $result->fetch_assoc();
            // JSON response for AJAX
            echo json_encode(['status' => 'success', 'category' => $category]);
            exit;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to fetch new category']);
            exit;
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to insert category: ' . $stmt->error]);
        exit;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}
?>
