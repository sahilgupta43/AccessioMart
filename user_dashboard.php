<?php

include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');
include('include/header.php');

$userID = $_SESSION['userid']; // Get user ID from session

// SQL query to select user data
$sql = "SELECT userid, name, email, phone FROM customers WHERE userid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* styles.css */

/* Unique styling for the user dashboard */
.dashboard-header {
    text-align: center;
    margin-top: 20px;
}

.user-info-table {
    width: 60%;
    margin: 20px auto;
    border-collapse: collapse;
    background: #fff;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.user-info-table th, .user-info-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.user-info-table th {
    background-color: #f2f2f2;
}

.logout-button {
    display: block;
    width: 120px;
    margin: 20px auto;
    text-align: center;
    padding: 10px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

.logout-button:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>

<h2 class="dashboard-header">Welcome, <?php echo htmlspecialchars($user['name']); ?></h2>
<table class="user-info-table">
    <tr>
        <th>UserID</th>
        <td><?php echo htmlspecialchars($user['userid']); ?></td>
    </tr>
    <tr>
        <th>Name</th>
        <td><?php echo htmlspecialchars($user['name']); ?></td>
    </tr>
    <tr>
        <th>Email</th>
        <td><?php echo htmlspecialchars($user['email']); ?></td>
    </tr>
    <tr>
        <th>Phone</th>
        <td><?php echo htmlspecialchars($user['phone']); ?></td>
    </tr>
</table>

<a href="index.php" class="logout-button">Logout</a>

</body>
</html>
