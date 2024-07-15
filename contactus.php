<?php include('include/header.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - AccessioMart</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div id="contact-page">
        <div id="contact-form">
            <h2>Contact Us</h2>
            <form action="#" method="POST">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="feedback">Feedback:</label>
                <textarea id="feedback" name="feedback" required></textarea>

                <button type="submit">Submit</button>
            </form>
        </div>

        <div id="contact-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d56516.27776849206!2d85.28493299963512!3d27.709030241827836!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb198a307baabf%3A0xb5137c1bf18db1ea!2sKathmandu%2044600!5e0!3m2!1sen!2snp!4v1719063514391!5m2!1sen!2snp"></iframe>
        </div>
        <div id="contact-address">
            <h3>Visit Us</h3>
            <p>123 Example Street, <br>City Name, State, <br>Country - ZIP Code</p>
        </div>
    </div>

</body>
</html>

<?php include('include/footer.php') ?>