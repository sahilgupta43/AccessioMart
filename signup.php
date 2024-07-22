<?php include('include/header.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
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

        form input[type="text"],
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

        /* Google OAuth button styles */
        .google-btn {
            background-color: #dd4b39;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            display: inline-block;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            margin-bottom: 15px;
        }

        .google-btn:hover {
            background-color: #c23321;
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
        <!-- Signup form -->
        <h2>Signup Form</h2>
        <form action="process_signup.php" method="POST">
            <label for="fullname">Full Name:</label>
            <input type="text" id="fullname" name="fullname" placeholder="Enter your fullname" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" placeholder="Enter your phone number">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <label for="conpassword">Confirm Password:</label>
            <input type="password" id="conpassword" name="conpassword" placeholder="Enter your confirm password" required>

            <button type="submit" name="signup">Signup</button>

            <!-- Google OAuth button -->
            <div class="g-signin2" data-onsuccess="onGoogleSignup"></div>

            <div>
                <p>Are you a user? <a href="signin.php">SignIn</a></p>
            </div>
        </form>
    </main>

    <!-- Include the Google OAuth script -->
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta name="google-signin-client_id" content="210168295618-shoh3nv86g2n7mnroate02hsp7ls6ml5.apps.googleusercontent.com">
    
    <script>
        // Google Sign-Up callback function
        function onGoogleSignup(googleUser) {
            var profile = googleUser.getBasicProfile();
            var id_token = googleUser.getAuthResponse().id_token;
            // Send id_token to server-side PHP for signup verification
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'process_google_signup.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                console.log('Signed up as: ' + xhr.responseText);
                // Redirect or handle response as needed
                window.location.href = 'index.php'; // Example redirect to index.php
            };
            xhr.send('idtoken=' + id_token);
        }
    </script>
</body>
</html>
<?php include('include/footer.php') ?>