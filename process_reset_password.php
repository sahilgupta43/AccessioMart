<?php
include('include/db_connection.php'); // Include your database connection file

if (isset($_POST['reset'])) {
    $token = $_POST['token'];
    $newPassword = $_POST['password'];

    // Validate the token
    $query = "SELECT email, expires FROM password_resets WHERE token = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$token]);

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $email = $row['email'];
        $expires = $row['expires'];

        // Check if the token has expired
        if (date("U") < $expires) {
            // Hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update the user's password
            $query = "UPDATE users SET password = ? WHERE email = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$hashedPassword, $email]);

            // Delete the token from the database
            $query = "DELETE FROM password_resets WHERE token = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$token]);

            echo "Your password has been successfully reset.";
        } else {
            echo "The token has expired. Please request a new password reset.";
        }
    } else {
        echo "Invalid token.";
    }
}
?>
