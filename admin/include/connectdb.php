<?php
    // Check if a session is already started before starting a new session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
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