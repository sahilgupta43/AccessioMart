<?php
session_start(); // Start or resume the session

// Check if the user is signed in
if (!isset($_SESSION['userid'])) {
    header("Location: signin.php");
    exit();
}

include('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userID = $_SESSION['userid']; // Get user ID from session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmNewPassword = $_POST['confirm_new_password'];

    // Validate the new password
    if ($newPassword !== $confirmNewPassword) {
        $error = 'New passwords do not match.';
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $newPassword)) {
        $error = 'Password must be at least 8 characters long and include an uppercase letter, a lowercase letter, a number, and a special character.';
    } else {
        // Fetch current password from database
        $sql = "SELECT password FROM customers WHERE userid = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $stmt->bind_result($storedPassword);
        $stmt->fetch();
        $stmt->close();

        // Verify current password
        if (password_verify($currentPassword, $storedPassword)) {
            // Hash new password and update it in the database
            $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateSql = "UPDATE customers SET password = ? WHERE userid = ?";
            $updateStmt = $conn->prepare($updateSql);
            if (!$updateStmt) {
                die("Prepare failed: " . $conn->error);
            }
            $updateStmt->bind_param("si", $newHashedPassword, $userID);
            if ($updateStmt->execute()) {
                $success = 'Password successfully changed.';
            } else {
                $error = 'An error occurred while updating the password.';
            }
            $updateStmt->close();
        } else {
            $error = 'Current password is incorrect.';
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }

        .form-group {
            margin: 20px auto;
            width: 80%;
            max-width: 400px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .update-button {
            display: block;
            padding: 10px;
            background-color: #007bff;
            color: white;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 20px auto;
        }

        .update-button:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }

        .success-message {
            color: green;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Update Password</h1>

    <?php if (isset($error)): ?>
        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
    <?php elseif (isset($success)): ?>
        <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="current-password">Current Password</label>
            <input type="password" id="current-password" name="current_password" required>
        </div>
        <div class="form-group">
            <label for="new-password">New Password</label>
            <input type="password" id="new-password" name="new_password" required>
        </div>
        <div class="form-group">
            <label for="confirm-new-password">Confirm New Password</label>
            <input type="password" id="confirm-new-password" name="confirm_new_password" required>
        </div>
        <button type="submit" class="update-button">Update Password</button>
    </form>
</body>
</html>
