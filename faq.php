<?php include('include/header.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - AccessioMart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f9f9f9;
            padding: 20px;
        }
        .faq {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .faq h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .faq-item {
            margin-bottom: 20px;
        }
        .question {
            font-weight: bold;
        }
        .answer {
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <!-- FAQ section -->
    <div class="faq">
        <h2>FAQ's</h2>
        
        <div class="faq-item">
            <div class="question">What payment methods do you accept?</div>
            <div class="answer">We accept Visa, MasterCard, PayPal, eSewa, and bank transfers.</div>
        </div>
        
        <div class="faq-item">
            <div class="question">How can I track my order?</div>
            <div class="answer">You can track your order through our website. Simply log in to your account and go to the order tracking section.</div>
        </div>
        
        <div class="faq-item">
            <div class="question">What is your return policy?</div>
            <div class="answer">We offer a 30-day return policy. Items must be unused and in their original packaging.</div>
        </div>
        
        <div class="faq-item">
            <div class="question">Do you ship internationally?</div>
            <div class="answer">Yes, we ship internationally to most countries.</div>
        </div>
        
        <div class="faq-item">
            <div class="question">How can I contact customer support?</div>
            <div class="answer">You can contact our customer support team via email at support@accessiomart.com or by phone at +123456789.</div>
        </div>
    </div>
</body>
</html>

<?php include('include/footer.php') ?>
