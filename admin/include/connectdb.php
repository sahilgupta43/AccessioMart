<?php
// Check if a session is already started before starting a new session

// Database credentials
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "accessiomart";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Set character set to UTF-8
$conn->set_charset("utf8");

// Optional: Print a message to confirm the connection was successful (useful for debugging)
// echo 'Database connection successful.';
?>
