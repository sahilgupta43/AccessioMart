<?php
include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$response = array();

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $sql = "INSERT INTO subscribers (email) VALUES ('$email')";
    if ($conn->query($sql) === TRUE) {
        $response['success'] = true;
    } else {
        $response['error'] = "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    $response['error'] = "Invalid email address.";
}

echo json_encode($response);

$conn->close();
?>
