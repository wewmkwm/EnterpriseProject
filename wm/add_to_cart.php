<?php
session_start(); // Start the session
include 'connection.php';

$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];
$admin_name = $_SESSION['admin_name']; // Use admin_name from session

// Check if the item is already in the cart
$check_cart = $conn->query("SELECT * FROM cart WHERE product_id = '$product_id' AND admin_name = '$admin_name'");
if ($check_cart->num_rows > 0) {
    // Update quantity if the item already exists in the cart
    $conn->query("UPDATE cart SET quantity = quantity + $quantity WHERE product_id = '$product_id' AND admin_name = '$admin_name'");
} else {
    // Add new item to the cart
    $conn->query("INSERT INTO cart (product_id, quantity, admin_name) VALUES ('$product_id', '$quantity', '$admin_name')");
}

$conn->close();
header('Location: cart.php');
exit();
?>
