<?php
    // Start session only if the user is logged in
    if (!isset($_SESSION)) {
        session_start();
    }

    // Check if user is signed in
    if (!isset($_SESSION['user_id'])) {
        // If not signed in, redirect to sign in page
        header("Location: sign_in.php");
        exit();
    }

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
?>