<?php
session_start(); // Start or resume the session

// Check if the user is signed in
if (!isset($_SESSION['userid'])) {
    header("Location: signin.php");
    exit();
}

include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userID = $_SESSION['userid']; // Get user ID from session

// SQL query to delete user data
$sql = "DELETE FROM customers WHERE userid = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $userID);

if ($stmt->execute()) {
    // Clear session data and redirect to index.php
    session_unset();
    session_destroy();
    header("Location: index.php?message=Account deleted successfully");
    exit();
} else {
    // Redirect back with an error message
    header("Location: user_dashboard.php?error=Failed to delete account");
    exit();
}
$stmt->close();
$conn->close();
?>
