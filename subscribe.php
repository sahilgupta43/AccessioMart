<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate email
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Database connection
        include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute SQL statement
        $stmt = $conn->prepare("INSERT INTO newsletter_subscriptions (email) VALUES (?) ON DUPLICATE KEY UPDATE email=email");
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => $stmt->error]);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(["success" => false, "error" => "Invalid email address."]);
    }
    exit();
}
?>
