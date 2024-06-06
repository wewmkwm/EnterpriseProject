<?php
session_start();

include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    // Retrieve address data from POST request
    $user_id = $_SESSION['user_id'];
    $full_address = $_POST['address'];

    // Perform database insertion
    include("connection.php"); // Include your database connection details

    $stmt = $conn->prepare("INSERT INTO address (user_id, address) VALUES (?, ?)");
    $stmt->bind_param("ss", $user_id, $full_address);

    if ($stmt->execute()) {
        // Address saved successfully
        echo "Address saved successfully.";
    } else {
        // Error occurred while saving address
        echo "Error saving address.";
    }

    $stmt->close();
    $conn->close();
	header("Location: address.php");
} else {
    // Redirect or handle unauthorized access
    header("Location: login.php"); // Redirect to login page or handle unauthorized access
    exit;
}
?>
