<?php include('include/header.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help & Support</title>
    <style>
        /* Main content styles */
        main {
            padding: 20px;
            max-width: 800px;
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

        /* Content styles */
        p {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
            margin-bottom: 15px;
        }

        ul {
            margin-bottom: 15px;
        }

        li {
            margin-bottom: 10px;
        }

        .contact-info {
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .contact-info h3 {
            margin-bottom: 10px;
        }

        .contact-info p {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <main>
        <h2>Help & Support</h2>
        <p>
            We are here to assist you with any questions or issues you may have. Below you will find various resources and contact information for support.
        </p>

        <h3>Frequently Asked Questions</h3>
        <p>
            Check our <a href="faq.php">FAQ page</a> for answers to common questions about our products, services, and policies.
        </p>

        <h3>Contact Support</h3>
        <div class="contact-info">
            <h3>Email Support</h3>
            <p>For general inquiries or support requests, please email us at <a href="mailto:support@accessiomart.com">support@accessiomart.com</a>.</p>

            <h3>Phone Support</h3>
            <p>Call us at <strong>+977 9812345678</strong> for immediate assistance. Our support team is available Monday through Friday, 9 AM to 5 PM.</p>

            <h3>Live Chat</h3>
            <p>For real-time assistance, use the <a href="live_chat.php">Live Chat feature</a> on our website during business hours.</p>

            <h3>Support Center</h3>
            <p>Visit our <a href="support_center.php">Support Center</a> for detailed guides, troubleshooting steps, and user manuals.</p>
        </div>

        <h3>Submit a Ticket</h3>
        <p>
            If you need personalized support, you can <a href="submit_ticket.php">submit a support ticket</a> and our team will get back to you as soon as possible.
        </p>
    </main>

    <?php include('include/footer.php'); ?>
</body>
</html>
