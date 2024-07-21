<?php
// Include database connection
include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');

// Initialize session (if not already started)
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security (to prevent SQL injection)
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to check user credentials
    $sql = "SELECT * FROM customers WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Check if a row is returned (valid credentials)
        if (mysqli_num_rows($result) == 1) {
            // Valid credentials
            $row = mysqli_fetch_assoc($result);

            if ($row['verified'] == 1) {
                // Account is verified, set session variables and redirect
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $email;
                header("Location: index.php"); // Redirect to the homepage or dashboard
                exit();
            } else {
                // Account is not verified
                header("Location: signin.php?error=not_verified");
                exit();
            }
        } else {
            // Invalid credentials
            header("Location: signin.php?error=invalid_credentials");
            exit();
        }
    } else {
        // Database query error
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    // Redirect to signin.php if accessed without form submission
    header("Location: signin.php");
    exit();
}
?>