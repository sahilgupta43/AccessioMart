<?php include('../include/header.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signin</title>
    <style>
        /* Main content styles */
        main {
            padding: 20px;
        }

        main h2 {
            text-align: center;
        }

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
        form input[type="password"],
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
            text-align: center;
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            form {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <main>
        <!-- Signin form -->
        <h2>Signin Form</h2>

        <!-- Display error message if any -->
        <?php if (isset($_GET['error'])): ?>
            <p class="error-message"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>

        <form action="../components/process_signin.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <button type="submit" name="signin">Sign In</button>

            <div>
                <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
                <p><a href="forgot_password.php">Forgot Password?</a></p>
            </div>
        </form>
    </main>
</body>
</html>

<?php include('../include/footer.php') ?>
