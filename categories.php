<?php
// Include database connection and header
session_start(); // Start or resume the session
include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');
include('include/without.php');

// Pagination settings
$items_per_page = 4; // Number of categories per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; // Current page
$offset = ($page - 1) * $items_per_page; // Offset for SQL query

// SQL query to count total number of categories
$total_query = "SELECT COUNT(*) AS total FROM categories";
$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_items = $total_row['total'];
$total_pages = ceil($total_items / $items_per_page);

// SQL query to fetch categories with pagination
$sql = "SELECT cid, category_name, category_image FROM categories LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $items_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

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
$stmt->close();
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
        .pagination {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        .pagination a {
            margin: 0 5px;
            padding: 10px 15px;
            border: 1px solid #007bff;
            border-radius: 5px;
            text-decoration: none;
            color: #007bff;
            font-size: 14px;
        }
        .pagination a.active {
            background-color: #007bff;
            color: white;
        }
        .pagination a:hover {
            background-color: #0056b3;
            color: white;
        }
    </style>
</head>
<body>

<div class="category-container">
    <?php foreach ($categories as $category): ?>
    <div class="category-card">
        <a href="cat_p.php?cid=<?php echo htmlspecialchars($category['cid']); ?>" class="category-link">
            <img src="admin/<?php echo htmlspecialchars($category['category_image']); ?>" alt="<?php echo htmlspecialchars($category['category_name']); ?>" class="category-image">
            <div class="category-name"><?php echo htmlspecialchars($category['category_name']); ?></div>
        </a>
    </div>
    <?php endforeach; ?>
</div>

<!-- Pagination Links -->
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=<?php echo ($page - 1); ?>">Previous</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?php echo $i; ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
        <a href="?page=<?php echo ($page + 1); ?>">Next</a>
    <?php endif; ?>
</div>

<?php include('include/footer.php') ?>

</body>
</html>
