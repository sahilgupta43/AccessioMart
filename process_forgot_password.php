<?php
include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');
require 'vendor/autoload.php'; // Make sure Composer's autoload file is included

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

if (isset($_POST['reset'])) {
    if (!isset($_POST['email']) || empty($_POST['email'])) {
        $_SESSION['message'] = "Email is required.";
        header('Location: forgot_password.php');
        exit;
    }

    $email = $_POST['email'];

    // Check if the email exists in the database
    $query = "SELECT userid FROM customers WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Generate a unique token
        $token = bin2hex(random_bytes(50));
        $expires = time() + 3600; // Token expires in 1 hour

        // Store the token in the database
        $query = "INSERT INTO password_resets (email, token, expires) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $email, $token, $expires);
        $stmt->execute();

        // Create the reset link
        $resetLink = "localhost/accessiomart/reset_password.php?token=$token";

        // Send the email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth = true;
            $mail->Username = 'guptasahil2294@gmail.com'; // SMTP username
            $mail->Password = 'hodv rcwo kitg cgig'; // App-specific password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption, `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port = 587; // TCP port to connect to

            // Recipients
            $mail->setFrom('no-reply@accessiomart.com', 'AccessioMart');
            $mail->addAddress($email); // Add a recipient

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = "Please click the following link to reset your password: <a href='$resetLink'>$resetLink</a>";

            $mail->send();
            $_SESSION['message'] = "A password reset link has been sent to your email.";
        } catch (Exception $e) {
            $_SESSION['message'] = "Failed to send the email. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $_SESSION['message'] = "No account found with that email address.";
    }

    header('Location: forgot_password.php');
    exit;
}
?>
