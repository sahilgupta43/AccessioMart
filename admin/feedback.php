<?php
// Include database connection
include('include/connectdb.php');

// Define the number of feedback entries per page
$feedback_per_page = 10; // Adjust this number as needed

// Determine the current page number
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the starting record for the current page
$start_from = ($page - 1) * $feedback_per_page;

// Function to fetch feedback from the database for the current page
function fetchFeedback($conn, $start_from, $feedback_per_page) {
    $selectQuery = "SELECT id, name, email, feedback FROM feedback LIMIT ?, ?";
    $stmt = $conn->prepare($selectQuery);
    $stmt->bind_param("ii", $start_from, $feedback_per_page);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

// Fetch feedback for the current page
$users = fetchFeedback($conn, $start_from, $feedback_per_page);

// Fetch total number of feedback entries for pagination
$total_query = "SELECT COUNT(id) AS total FROM feedback";
$total_result = $conn->query($total_query);
$total_feedback = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_feedback / $feedback_per_page);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        .main-content {
            margin-left: 250px; 
            padding: 20px;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }

        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .user-table th,
        .user-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .user-table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        .user-table td {
            background-color: #f9f9f9;
        }

        /* Pagination styling */
        .pagination {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .pagination a {
            color: #007bff;
            padding: 10px 15px;
            text-decoration: none;
            border: 1px solid #ddd;
            margin: 0 5px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .pagination a:hover {
            background-color: #f1f1f1;
        }

        .pagination a.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
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
        <h2>User's Feedback</h2>

        <!-- Feedback Table -->
        <div class="users-table">
            <table id="userTable" class="user-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Feedback</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['feedback']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="feedback.php?page=<?php echo $page - 1; ?>">&laquo; Prev</a>
            <?php endif; ?>
            
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="feedback.php?page=<?php echo $i; ?>" class="<?php echo $page == $i ? 'active' : ''; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
            
            <?php if ($page < $total_pages): ?>
                <a href="feedback.php?page=<?php echo $page + 1; ?>">Next &raquo;</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
