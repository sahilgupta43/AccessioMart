<?php 
include('../include/header.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        /* Main content styles */
        main {
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Header styles */
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        /* Form styles */
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        /* Form elements styles */
        form label {
            display: block;
            margin-bottom: 10px;
            font-size: 16px;
            color: #555;
        }

        form input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        form button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        form button:hover {
            background-color: #45a049;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            main {
                width: 90%;
                padding: 15px;
            }

            form {
                padding: 15px;
            }

            form button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <main>
        <h2>Forgot Password</h2>

        <?php
        if (isset($_SESSION['message'])) {
            echo '<p>' . $_SESSION['message'] . '</p>';
            unset($_SESSION['message']);
        }
        ?>

        <form action="process_forgot_password.php" method="post">
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit" name="reset">Reset Password</button>
        </form>
    </main>
</body>
</html>

<?php include('../include/footer.php'); ?>
