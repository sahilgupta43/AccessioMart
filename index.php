<?php include('include/header.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AccessioMart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Custom Styles */
#featured-products .section-title {
    text-align: center;
    margin-bottom: 30px;
    color: #333;
}

#featured-products .card {
    border: 1px solid #ddd;
    border-radius: 8px;
    transition: all 0.3s ease;
}

#featured-products .card:hover {
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

#featured-products .card-img-top {
    height: 200px; /* Adjust height as needed */
    object-fit: cover;
}

#featured-products .card-title {
    font-size: 18px;
    font-weight: bold;
}

#featured-products .card-text {
    color: #666;
    margin-bottom: 10px;
}

#featured-products .btn-group {
    margin-top: 10px;
    display: flex;
    justify-content: space-between;
}

#featured-products .btn {
    width: 48%;
}

@media (max-width: 768px) {
    #featured-products .btn-group {
        flex-direction: column;
    }

    #featured-products .btn {
        width: 100%;
        margin-top: 5px;
    }
}

    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1 class="hero-heading">Welcome to AccessioMart</h1>
            <p class="hero-slogan">Discover the trending products at unbeatable prices!</p>
        </div>
    </section>

    <?php include('include/featured.php') ?>

    <script src="script.js"></script>
</body>
</html>


<?php include('include/footer.php') ?>