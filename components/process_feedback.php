<?php
include ('C:\xampp\htdocs\accessiomart\admin\include\connectdb.php');

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$feedback = $_POST['feedback'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO feedback (name, email, feedback) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $feedback);

// Execute the query
if ($stmt->execute()) {
    echo "Feedback submitted successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();

// Redirect to a thank you page or back to contact page
header("Location: thank_you.php");
exit();
?>
