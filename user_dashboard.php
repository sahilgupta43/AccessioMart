<?php
session_start();
include('D:\xampp\htdocs\accessiomart\admin\include\connectdb.php');
include('include/header.php');
// SQL query to select user data
$sql = "SELECT userid, name, email, phone FROM customers WHERE userid = 1";
$stmt = $conn->prepare($sql);
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
</head>
<body>

<h2>Welcome, <?php echo htmlspecialchars($user['name']); ?></h2>
<table>
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

<a href="logout.php">Logout</a>

</body>
</html>
