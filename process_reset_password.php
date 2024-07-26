<?php
include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');
session_start();

if (isset($_POST['reset_password'])) {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $_SESSION['message'] = "Passwords do not match.";
        header('Location: reset_password.php?token=' . $token);
        exit;
    }

    $query = "SELECT email FROM password_resets WHERE token = ? AND expires > ?";
    $stmt = $conn->prepare($query);
    $current_time = time();
    $stmt->bind_param("si", $token, $current_time);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['email'];

        // Hash the new password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Update the password in the database
        $query = "UPDATE customers SET password = ? WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $hashed_password, $email);
        $stmt->execute();

        // Delete the token after successful reset
        $query = "DELETE FROM password_resets WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $_SESSION['message'] = "Your password has been reset successfully.";
        header('Location: password_reset_success.php');
        exit;
    } else {
        $_SESSION['message'] = "Invalid token or token has expired.";
        header('Location: reset_password.php?token=' . $token);
        exit;
    }
}
?>
