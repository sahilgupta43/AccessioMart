<?php
session_start(); // Start or resume session

include('D:\xampp\htdocs\accessiomart\admin\include\connectdb.php');
include('include/header.php');

// Function to display cart details and summary
function displayCart() {
    echo "<h2 style='text-align: center;'>Your Cart</h2>";

    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        // Display cart items
        echo "<table style='width: 80%; margin: 0 auto; border-collapse: collapse;'>";
        echo "<tr><th>Product ID</th><th>Name</th><th>Image</th><th>Price</th><th>Quantity</th><th>Total Price</th><th>Action</th></tr>";
        
        $subtotal = 0;

        // Fetch product details based on cart items
        foreach ($_SESSION['cart'] as $productId => $product) {
            $totalPrice = $product['price'] * $product['quantity'];
            $subtotal += $totalPrice;

            echo "<tr>";
            echo "<td>{$productId}</td>";
            echo "<td><a href='singleproduct.php?id={$productId}' style='text-decoration: none; color: #333;'>{$product['name']}</a></td>";
            echo "<td><img src='admin/{$product['image']}' alt='{$product['name']}' style='max-width: 100px;'></td>";
            echo "<td>{$product['price']}</td>";
            echo "<td>{$product['quantity']}</td>";
            echo "<td>{$totalPrice}</td>";
            echo "<td><form action='cart.php' method='POST'>";
            echo "<input type='hidden' name='remove_one' value='{$productId}'>";
            echo "<button type='submit' class='button'>Remove</button>";
            echo "</form></td>";
            echo "</tr>";
        }

        echo "</table>";

        // Display shipping and total
        $shippingCharge = 5; // Example shipping charge
        $totalWithShipping = $subtotal + $shippingCharge;

        echo "<h2 style='text-align: center;'>Summary</h2>";
        echo "<table style='width: 50%; margin: 0 auto; border-collapse: collapse;'>";
        echo "<tr><th>Total Price</th><td>{$subtotal}</td></tr>";
        echo "<tr><th>Shipping Charge</th><td>{$shippingCharge}</td></tr>";
        echo "<tr><th>Subtotal</th><td>{$totalWithShipping}</td></tr>";
        echo "</table>";

        // Buttons for continuing shopping and checkout
        echo "<div style='text-align: center; margin-top: 20px;'>";
        echo "<button onclick='window.location=\"index.php\"' class='button'>Continue Shopping</button>";
        echo " ";
        echo "<button onclick='window.location=\"checkout.php\"' class='button'>Proceed to Checkout</button>";
        echo "</div>";
    } else {
        // Display message when cart is empty
        echo "<p style='text-align: center;'>No items in the cart.</p>";
        echo "<div style='text-align: center;'>";
        echo "<button onclick='window.location=\"index.php\"' class='button'>Continue Shopping</button>";
        echo "</div>";
    }
}

// Handle remove one item from cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_one'])) {
    $productId = $_POST['remove_one'];
    if (isset($_SESSION['cart'][$productId])) {
        if ($_SESSION['cart'][$productId]['quantity'] > 1) {
            $_SESSION['cart'][$productId]['quantity']--;
        } else {
            unset($_SESSION['cart'][$productId]);
        }
    }
    header("Location: cart.php"); // Redirect to cart page to refresh the cart display
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<?php displayCart(); ?>
<?php include('include/footer.php') ?>
</body>
</html>
