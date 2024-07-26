<?php
session_start();

if (!isset($_SESSION['message'])) {
    header('Location: signin.php');
    exit;
}

$message = $_SESSION['message'];
unset($_SESSION['message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Success</title>
    <style>
        /* Main content styles */
        main {
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        /* Header styles */
        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            color: #555;
        }
    </style>
    <script>
        // Redirect to signin.php after 5 seconds
        setTimeout(function() {
            window.location.href = 'signin.php';
        }, 5000);
    </script>
</head>
<body>
    <main>
        <h2>Success</h2>
        <p><?php echo htmlspecialchars($message); ?></p>
    </main>
</body>
</html>
