<?php
// Include database connection and start session
include('include/connectdb.php');

// Define the number of results per page
$results_per_page = 5;

// Determine the current page number
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the starting record for the current page
$start_from = ($page - 1) * $results_per_page;

// Function to fetch admins for the current page from the database
function fetchAdmins($conn, $start_from, $results_per_page) {
    $selectQuery = "SELECT id, fname, username, password FROM admintbl LIMIT ?, ?";
    $stmt = $conn->prepare($selectQuery);
    $stmt->bind_param("ii", $start_from, $results_per_page);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

// Fetch the total number of admins for pagination
$total_query = "SELECT COUNT(id) AS total FROM admintbl";
$total_result = $conn->query($total_query);
$total_admins = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_admins / $results_per_page);

// Fetch admins for the current page
$admins = fetchAdmins($conn, $start_from, $results_per_page);

// Process AJAX request to delete admin
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    if ($_POST['action'] == 'delete_admin' && isset($_POST['adminId']) && is_numeric($_POST['adminId'])) {
        $adminId = $_POST['adminId'];

        // Delete admin from database
        $deleteQuery = "DELETE FROM admintbl WHERE id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $adminId);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
            exit;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete admin']);
            exit;
        }
    } elseif ($_POST['action'] == 'add_admin') {
        // Validate and sanitize input
        $fname = $_POST['fname'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Add new admin to database
        if (addAdmin($conn, $fname, $username, $password)) {
            echo json_encode(['status' => 'success']);
            exit;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add admin']);
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admins</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        .main-content {
            margin-left: 250px;
            padding: 20px;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }

        .add-admin-form {
            max-width: 600px;
            margin: 20px 0;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .add-admin-form h3 {
            margin-bottom: 20px;
        }

        .add-admin-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .add-admin-form input[type="text"],
        .add-admin-form input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .add-admin-form button[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .add-admin-form button[type="submit"]:hover {
            background-color: #218838;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .admin-table th,
        .admin-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .admin-table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        .admin-table td {
            background-color: #f9f9f9;
        }

        .admin-table td:last-child {
            text-align: center;
        }

        .admin-table button.delete-btn {
            background-color: #dc3545;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .admin-table button.delete-btn:hover {
            background-color: #c82333;
        }

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
        <h2>Admins</h2>
        
        <!-- Add Admin Form -->
        <div class="add-admin-form">
            <h3>Add New Admin</h3>
            <form id="addAdminForm">
                <label for="fname">Full Name:</label>
                <input type="text" id="fname" name="fname" required>
                
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                
                <button type="submit">Add Admin</button>
            </form>
        </div>
        
        <!-- Admins Table -->
        <div class="admins-table">
            <h3>Admins List</h3>
            <table id="adminTable" class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admins as $admin): ?>
                        <tr data-admin-id="<?php echo $admin['id']; ?>">
                            <td><?php echo $admin['id']; ?></td>
                            <td><?php echo $admin['fname']; ?></td>
                            <td><?php echo $admin['username']; ?></td>
                            <td><?php echo $admin['password']; ?></td>
                            <td><button class="delete-btn" data-admin-id="<?php echo $admin['id']; ?>">Delete</button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="admins.php?page=<?php echo $page - 1; ?>">&laquo; Prev</a>
            <?php endif; ?>
            
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="admins.php?page=<?php echo $i; ?>" class="<?php echo $page == $i ? 'active' : ''; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
            
            <?php if ($page < $total_pages): ?>
                <a href="admins.php?page=<?php echo $page + 1; ?>">Next &raquo;</a>
            <?php endif; ?>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Add Admin Form Submission
            $('#addAdminForm').submit(function(event) {
                event.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: 'admins.php',
                    data: formData + '&action=add_admin',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {
                            alert('Admin added successfully.');
                            location.reload(); // Reload the page to fetch updated admin list
                        } else {
                            alert('Failed to add admin.');
                        }
                    },
                    error: function() {
                        alert('Failed to add admin.');
                    }
                });
            });

            // Delete Admin using AJAX
            $('.delete-btn').click(function() {
                var adminId = $(this).data('admin-id');

                if (confirm("Are you sure you want to delete this admin?")) {
                    $.ajax({
                        type: 'POST',
                        url: 'admindelete.php',
                        data: {
                            action: 'delete_admin',
                            adminId: adminId
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == 'success') {
                                $('tr[data-admin-id="' + adminId + '"]').remove();
                                alert('Admin deleted successfully.');
                            } else {
                                alert('Failed to delete admin.');
                            }
                        },
                        error: function() {
                            alert('Failed to delete admin.');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
