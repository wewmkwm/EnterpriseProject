<?php
// Start the session
session_start();

// Function to add a product to the cart
function addToCart($productId) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    // Add the product ID to the cart array
    $_SESSION['cart'][] = $productId;
}

// Function to clear the cart
function clearCart() {
    $_SESSION['cart'] = array();
}

// Function to get the cart contents
function getCart() {
    return isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
}
?>
