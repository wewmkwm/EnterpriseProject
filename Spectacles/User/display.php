<?php
session_start();
include("connection.php");

// Check if the user_id is set in the session
if(isset($_SESSION['user_id'])) {
    // Display the user ID
    echo "User ID: " . $_SESSION['user_id'] . "<br>";
    
    // Prepare and execute SQL query to retrieve user details
    $user_id = $_SESSION['user_id'];
    $sql_user = "SELECT firstname, lastname FROM users WHERE user_id = $user_id";
    $result_user = $conn->query($sql_user);

    // Check if query was successful and if user exists
    if ($result_user && $result_user->num_rows > 0) {
        // Fetch user details
        $row_user = $result_user->fetch_assoc();
        $firstname = $row_user['firstname'];
        $lastname = $row_user['lastname'];
        
        // Display firstname and lastname
        echo "Firstname: " . $firstname . "<br>";
        echo "Lastname: " . $lastname . "<br>";
    } else {
        echo "User not found.";
    }

    // Check if cart items are stored in the session
    if(isset($_SESSION['cart_items'])) {
        // Unserialize cart items
        $cart_items = unserialize($_SESSION['cart_items']);
        
        // Display cart items
        $total_price = 0; // Initialize total price
        foreach ($cart_items as $item) {
            // Display each item
            echo "Cart Item ID: " . $item['cart_item_id'] . "<br>";
            echo "Product ID: " . $item['product_id'] . "<br>";
            echo "Product Name: " . $item['product_name'] . "<br>";
            echo "Quantity: " . $item['quantity'] . "<br>";
            echo "Price: RM" . $item['product_price'] . "<br>";
            
            // Add the price of this item to the total price
            $total_price += $item['product_price'] * $item['quantity'];
        }
        
        // Display total price
        echo "Total Price: RM" . $total_price . "<br>";
    } else {
        echo "No items in the cart.";
    }

    // Fetch card number for the user
    $sql_card = "SELECT card_number FROM user_cards WHERE user_id = $user_id";
    $result_card = $conn->query($sql_card);

    if ($result_card && $result_card->num_rows > 0) {
        $row_card = $result_card->fetch_assoc();
        $card_number = $row_card['card_number'];
        
        // Display card number
        echo "Card Number: " . $card_number . "<br>";
    } else {
        echo "Card not found.";
    }

    // Fetch address for the user
    $sql_address = "SELECT address FROM address WHERE user_id = $user_id";
    $result_address = $conn->query($sql_address);

    if ($result_address && $result_address->num_rows > 0) {
        $row_address = $result_address->fetch_assoc();
        $address = $row_address['address'];
        
        // Display address
        echo "Address: " . $address . "<br>";
    } else {
        echo "Address not found.";
    }
    
    // Close database connection
    $conn->close();
} else {
    // If user ID is not set, handle it as per your application's logic
    echo "User ID not found.";
}
?>

<button onclick="printReceipt()">Print Receipt</button>

<script>
function printReceipt() {
    window.print();
}
</script>
