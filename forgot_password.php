<?php
include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Check if email exists in the database
    $stmt = $pdo->prepare("SELECT * FROM customers WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Generate a password reset token
        $token = bin2hex(random_bytes(32)); // Use a secure token generator

        // Store the token in the database with an expiry time
        $stmt = $pdo->prepare("INSERT INTO password_resets (email, token, created_at) VALUES (:email, :token, NOW())");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        // Send the user to the password reset page with the token
        header("Location: reset_password.php?token=" . $token);
        exit();
    } else {
        echo '<p>No account found with that email address.</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        /* Form styles */
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }

        form label {
            display: block;
            margin-bottom: 10px;
        }

        form input[type="email"],
        form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        form button:hover {
            background-color: #45a049;
        }

        /* Error message styles */
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <main>
        <h2>Forgot Password</h2>
        <form action="forgot_password.php" method="POST">
            <label for="email">Enter your email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
            <button type="submit">Reset Password</button>
        </form>
    </main>
</body>
</html>
