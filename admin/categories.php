<?php
include('include/connectdb.php');

// Process form submission if category is added
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $categoryName = trim($_POST['categoryName']);
    $categoryImage = ''; // Placeholder for image handling

    // Validate category name (only alphabets and numbers)
    if (!preg_match('/^[a-zA-Z0-9]+$/', $categoryName)) {
        echo json_encode(['status' => 'error', 'message' => 'Category name should contain only alphabets and numbers']);
        exit;
    }

    // Check for duplicate category name
    $checkQuery = "SELECT cid FROM categories WHERE category_name = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $categoryName);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Category name already exists']);
        exit;
    }
    $stmt->close();

    // Handle image upload
    if (isset($_FILES['categoryImage']) && $_FILES['categoryImage']['error'] == 0) {
        $targetDir = "uploads/categories/"; // Set your desired upload directory
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true); // Create the directory if it doesn't exist
        }
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
        $newCategoryId = $stmt->insert_id;
        $stmt->close();

        $selectQuery = "SELECT cid, category_name, category_image FROM categories WHERE cid = ?";
        $stmt = $conn->prepare($selectQuery);
        $stmt->bind_param("i", $newCategoryId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $category = $result->fetch_assoc();
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
}

// Fetch all categories from database
$selectQuery = "SELECT cid, category_name, category_image FROM categories";
$result = $conn->query($selectQuery);

// Close database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        .main-content {
            display: flex;
            flex-direction: column;
            align-items: center; /* Center aligns content horizontally */
            justify-content: center; /* Center aligns content vertically */
            flex-grow: 1;
            padding: 20px;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px; /* Adjust maximum width as needed */
            margin-bottom: 20px; /* Space between form and table */
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"], input[type="file"], button {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%; /* Ensure inputs and button fill the container */
            box-sizing: border-box; /* Ensure padding and border are included in width */
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover {
            background-color: #45a049;
        }

        .category-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .category-table th, .category-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .category-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .category-table td {
            vertical-align: middle;
        }

        .category-table td a {
            color: #007bff;
            text-decoration: none;
            margin-right: 10px;
        }

        .category-table td a:hover {
            text-decoration: underline;
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>Admin Portal</h2>
        </div>
        <ul class="nav-links">
            <li><a href="adminportal.php">Dashboard</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="admins.php">Admins</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="users.php">Users</a></li>
            <li><a href="feedback.php">Feedback</a></li>
            <li><a href="newsletter.php">Newsletter</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h2>Add Category</h2>
        <div class="container">
            <form id="addCategoryForm" enctype="multipart/form-data">
                <label for="categoryName">Category Name:</label>
                <input type="text" id="categoryName" name="categoryName" required>
                
                <label for="categoryImage">Category Image:</label>
                <input type="file" id="categoryImage" name="categoryImage">
                
                <button type="submit" name="submit">Add Category</button>
            </form>

            <h2>Categories</h2>
            <table class="category-table">
                <thead>
                    <tr>
                        <th>Category ID</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="categoryTableBody">
                    <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['cid'] . "</td>";
                                echo "<td>" . $row['category_name'] . "</td>";
                                echo "<td><a href='categorydelete.php?cid=" . $row['cid'] . "' class='delete-category'>Delete</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>No categories found.</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#addCategoryForm').submit(function(event) {
                event.preventDefault();
                
                var categoryName = $('#categoryName').val();
                var formData = new FormData(this);

                // Validate category name
                if (!/^[a-zA-Z0-9]+$/.test(categoryName)) {
                    alert('Category name should contain only alphabets and numbers');
                    return;
                }

                // Check for duplicate category name
                $.ajax({
                    type: 'POST',
                    url: 'check_category.php', // New script to check for duplicate category
                    data: { categoryName: categoryName },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'exists') {
                            alert('Category name already exists');
                            return;
                        }

                        // Submit the form if no duplicates
                        $.ajax({
                            type: 'POST',
                            url: 'categoriesinsert.php', // Ensure this URL is correct
                            data: formData,
                            processData: false,
                            contentType: false,
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    var category = response.category;
                                    var newRow = "<tr>" +
                                        "<td>" + category.cid + "</td>" +
                                        "<td>" + category.category_name + "</td>" +
                                        "<td><a href='categorydelete.php?cid=" + category.cid + "' class='delete-category'>Delete</a></td>" +
                                        "</tr>";
                                    $('#categoryTableBody').append(newRow);
                                    alert('Category added successfully.');
                                } else {
                                    alert('Failed to add category: ' + response.message);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log('Server response:', xhr.responseText);
                                alert('Failed to add category: ' + error);
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log('Server response:', xhr.responseText);
                        alert('Failed to check category: ' + error);
                    }
                });
            });

            $(document).on('click', '.delete-category', function(event) {
                event.preventDefault();
                var deleteUrl = $(this).attr('href');

                if (confirm("Are you sure you want to delete this category?")) {
                    $.ajax({
                        type: 'GET',
                        url: deleteUrl,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                $(event.target).closest('tr').remove();
                                alert('Category deleted successfully.');
                            } else {
                                alert('Failed to delete category: ' + response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log('Server response:', xhr.responseText);
                            alert('Failed to delete category: ' + error);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
