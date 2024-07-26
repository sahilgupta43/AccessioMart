<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <link rel="stylesheet" href="../assests/css/styles.css">
    <style>
        /* Custom Styles for Thank You Page */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        #thank-you {
            text-align: center;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        #thank-you h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }

        #thank-you p {
            color: #666;
            margin-bottom: 20px;
            font-size: 16px;
        }

        #thank-you a {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s, transform 0.3s;
        }

        #thank-you a:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div id="thank-you">
        <h1>Thank You!</h1>
        <p>Your feedback has been submitted successfully. We appreciate your input!</p>
        <a href="../index.php">Back to Homepage</a>
    </div>
</body>
</html>
