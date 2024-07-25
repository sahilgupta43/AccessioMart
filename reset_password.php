<?php include('include/header.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        /* Add your styles here */
    </style>
</head>
<body>
    <main>
        <h2>Reset Password</h2>
        <form action="process_reset_password.php" method="POST">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your new password" required>
            <button type="submit" name="reset">Reset Password</button>
        </form>
    </main>
</body>
</html>

<?php include('include/footer.php') ?>
