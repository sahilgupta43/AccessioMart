<?php
session_start();
include ('D:\xampp\htdocs\accessiomart\admin\include\connectdb.php');

// Function to handle successful payment
function handleSuccess() {
    if (isset($_SESSION['userid'])) {
        $userId = $_SESSION['userid'];
        $cartKey = 'cart_' . $userId;
    
        // Unset the cart session data for the logged-in user
        unset($_SESSION[$cartKey]);
    
        // Display thank you message
        header("Location: index.php");
        exit();
    } else {
        // Handle the case where the user is not logged in
        header("Location: signin.php");
        exit();
    }
    }

// Call the handleSuccess function
handleSuccess();
?>
