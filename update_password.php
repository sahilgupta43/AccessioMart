<?php
session_start(); // Start or resume the session

// Check if the user is signed in
if (!isset($_SESSION['userid'])) {
    echo 'You are not signed in.';
    exit();
}

include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userID = $_SESSION['userid']; // Get user ID from session

$currentPassword = $_POST['current_password'];
$newPassword = $_POST['new_password'];

// Fetch the current password from the database
$sql = "SELECT password FROM customers WHERE userid = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Verify the current password
if (!password_verify($currentPassword, $user['password'])) {
    echo 'Current password is incorrect.';
    exit();
}

// Hash the new password
$newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

// Update the password in the database
$updateSql = "UPDATE customers SET password = ? WHERE userid = ?";
$updateStmt = $conn->prepare($updateSql);
if (!$updateStmt) {
    die("Prepare failed: " . $conn->error);
}
$updateStmt->bind_param("si", $newPasswordHash, $userID);
if ($updateStmt->execute()) {
    echo 'success';
} else {
    echo 'Failed to update password.';
}
$updateStmt->close();
$conn->close();
?>
