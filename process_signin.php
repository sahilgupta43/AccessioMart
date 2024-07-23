<?php
include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate input
    if (empty($email) || empty($password)) {
        header('Location: signin.php?error=Both fields are required.');
        exit();
    }

    // Prepare SQL statement to check if email exists
    $stmt = $conn->prepare("SELECT userid, email, password FROM customers WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows === 0) {
        header('Location: signin.php?error=Invalid email or password.');
        exit();
    }

    // Fetch user data
    $user = $result->fetch_assoc();

    // Verify password
    if (!password_verify($password, $user['password'])) {
        header('Location: signin.php?error=Invalid email or password.');
        exit();
    }

    // Store user ID in session
    $_SESSION['userid'] = $user['id'];

    // Redirect to the index page
    header('Location: index.php');
    exit();
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
