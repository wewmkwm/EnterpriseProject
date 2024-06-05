<?php
session_start();

// Include your database connection file
include("connection.php");

// Check if user is logged in (you may need to adjust this based on your authentication system)
if(isset($_SESSION['user_id'])) {
    // Display the user ID
    echo "User ID: " . $_SESSION['user_id'];

    // Check if productId is provided in the request
    if(isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];
        echo "Product ID: " . $product_id;

        // Check if quantity is provided, default to 1 if not provided
        $quantity = isset($_GET['quantity']) ? $_GET['quantity'] : 1;

        // Check if the item already exists in the cart
        $check_query = "SELECT id, quantity FROM cart_items WHERE user_id = ? AND product_id = ?";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->bind_param("ii", $_SESSION['user_id'], $product_id);
        $check_stmt->execute();
        $check_stmt->store_result();

        if($check_stmt->num_rows > 0) {
            // Item already exists in the cart, update quantity
            $check_stmt->bind_result($cart_item_id, $existing_quantity);
            $check_stmt->fetch();
            $new_quantity = $existing_quantity + $quantity;
            $update_query = "UPDATE cart_items SET quantity = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("ii", $new_quantity, $cart_item_id);
            if($update_stmt->execute()) {
                echo "Quantity updated successfully.";
            } else {
                echo "Error updating quantity: " . $conn->error;
            }
            $update_stmt->close();
        } else {
            // Item does not exist in the cart, insert new record
            $insert_query = "INSERT INTO cart_items (user_id, product_id, quantity, created_at) VALUES (?, ?, ?, CURRENT_TIMESTAMP)";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->bind_param("iii", $_SESSION['user_id'], $product_id, $quantity);
            if($insert_stmt->execute()) {
                echo "Product added to cart successfully.";
            } else {
                echo "Error adding product to cart: " . $conn->error;
            }
            $insert_stmt->close();
        }
        $check_stmt->close();
    } else {
        // Handle the case where no product ID is provided
        echo "Product ID not found.";
    }
} else {
    // Handle the case where user is not logged in
    echo "User is not logged in.";
}

// Close connection
$conn->close();
?>
