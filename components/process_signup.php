<?php
include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['conpassword'];

    // Validate input
    if (empty($name) || empty($email) || empty($phone) || empty($password) || empty($confirmPassword)) {
        echo '<p class="error-message">All fields are required.</p>';
        exit();
    }

    if ($password !== $confirmPassword) {
        echo '<p class="error-message">Passwords do not match.</p>';
        exit();
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT * FROM customers WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<p class="error-message">Email is already registered.</p>';
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $stmt = $conn->prepare("INSERT INTO customers (name, email, phone, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $name, $email, $phone, $hashedPassword);
    
    if ($stmt->execute()) {
        header("Location: signin.php");
    } else {
        header("Location: signup.php");
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>