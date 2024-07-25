<?php
include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');

if (isset($_POST['reset'])) {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $query = "SELECT id FROM users WHERE email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        $userId = $stmt->fetchColumn();

        // Generate a unique token
        $token = bin2hex(random_bytes(50));
        $expires = date("U") + 3600; // Token expires in 1 hour

        // Store the token in the database
        $query = "INSERT INTO password_resets (email, token, expires) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$email, $token, $expires]);

        // Create the reset link
        $resetLink = "http://yourdomain.com/reset_password.php?token=$token";

        // Send the email (using PHP's mail function for simplicity)
        $to = $email;
        $subject = "Password Reset Request";
        $message = "Please click the following link to reset your password: $resetLink";
        $headers = "From: no-reply@yourdomain.com";

        if (mail($to, $subject, $message, $headers)) {
            echo "A password reset link has been sent to your email.";
        } else {
            echo "Failed to send the email.";
        }
    } else {
        echo "No account found with that email address.";
    }
}
?>
