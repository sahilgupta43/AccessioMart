<?php
// Include your database connection file
include('D:\xampp\htdocs\accessiomart\admin\include\connectdb.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security (to prevent SQL injection)
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $conpassword = mysqli_real_escape_string($conn, $_POST['conpassword']);

    // Insert user data into customers table
    $sql = "INSERT INTO customers (name, email, phone, password, conpassword) VALUES ('$fullname', '$email', '$phone', '$password', '$conpassword')";
    
    if (mysqli_query($conn, $sql)) {
        // Redirect to a success page or do something else upon successful registration
        header("Location: signin.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
