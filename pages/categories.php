<?php
// Include database connection and header
session_start(); // Start or resume the session
include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');
include('include/without.php');

// SQL query to fetch categories
$sql = "SELECT cid, category_name, category_image FROM categories";
$result = $conn->query($sql);

// Array to store fetched categories
$categories = array();

// Fetch categories and store in $categories array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
} else {
    echo "0 results";
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Page</title>
    <style>
        .category-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .category-card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 16px;
            margin: 16px;
            text-align: center;
            width: 250px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .category-image {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .category-name {
            font-size: 18px;
            margin: 16px 0;
        }
        .category-link {
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>
<body>

<div class="category-container">
    <?php foreach ($categories as $category): ?>
    <div class="category-card">
        <a href="cat_p.php?cid=<?php echo $category['cid']; ?>" class="category-link">
            <img src="admin/<?php echo $category['category_image']; ?>" alt="<?php echo $category['category_name']; ?>" class="category-image">
            <div class="category-name"><?php echo $category['category_name']; ?></div>
        </a>
    </div>
    <?php endforeach; ?>
</div>

<?php include('include/footer.php') ?>

</body>
</html>