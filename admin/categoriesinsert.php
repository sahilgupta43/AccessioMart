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

    // Handle image upload
    $categoryImage = '';
    if (isset($_FILES['categoryImage']) && $_FILES['categoryImage']['error'] == 0) {
        $targetDir = "uploads/categories/"; // Set your desired upload directory
        $targetFile = $targetDir . basename($_FILES["categoryImage"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["categoryImage"]["tmp_name"]);
        if ($check === false) {
            echo json_encode(['status' => 'error', 'message' => 'File is not an image']);
            exit;
        }

        // Check file size (e.g., limit to 2MB)
        if ($_FILES["categoryImage"]["size"] > 2000000) {
            echo json_encode(['status' => 'error', 'message' => 'Sorry, your file is too large']);
            exit;
        }

        // Allow certain file formats
        $allowedFormats = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedFormats)) {
            echo json_encode(['status' => 'error', 'message' => 'Sorry, only JPG, JPEG, PNG & GIF files are allowed']);
            exit;
        }

        // Check if file already exists
        if (file_exists($targetFile)) {
            echo json_encode(['status' => 'error', 'message' => 'Sorry, file already exists']);
            exit;
        }

        // Try to upload file
        if (move_uploaded_file($_FILES["categoryImage"]["tmp_name"], $targetFile)) {
            $categoryImage = $targetFile; // Set the file path to save in the database
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Sorry, there was an error uploading your file']);
            exit;
        }
    }

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
