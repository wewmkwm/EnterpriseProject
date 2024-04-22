<?php
session_start();
include("NavBar.php");

// Include your database connection file
include("connection.php");

$total_price = 0; // Variable to store total price

// Check if user is logged in (you may need to adjust this based on your authentication system)
if(isset($_SESSION['user_id'])) {
    // Display the user ID
    echo "User ID: " . $_SESSION['user_id'];

    // Query to select cart items for the logged-in user
    $query = "SELECT ci.id, ci.product_id, ci.quantity, p.name, p.price, i.image_data FROM cart_items ci INNER JOIN models p ON ci.product_id = p.id LEFT JOIN images i ON p.id = i.model_id WHERE ci.user_id = ?";

    // Prepare and bind parameters
    if($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $_SESSION['user_id']);

        // Execute the query
        $stmt->execute();

        // Bind result variables
        $stmt->bind_result($cart_item_id, $product_id, $quantity, $product_name, $product_price, $image_data);

        // Array to store cart items
        $cart_items = array();

        // Display cart items
        echo "<div class='container'>";
        echo "<h2 class='my-4'>Cart Items</h2>";
        echo "<div class='row'>";
        echo "<div class='col'>";
        echo "<table class='table table-bordered'>";
        echo "<thead class='table-dark'>";
        echo "<tr><th>No</th><th>Product Img</th><th>Product Name</th><th>Quantity</th><th>Price</th><th>Action</th></tr>";
        echo "</thead>";
        echo "<tbody>";
        while ($stmt->fetch()) {
            echo "<tr>";
            echo "<td>{$cart_item_id}</td>";
            // Display image if available
            echo "<td>";
            if ($image_data) {
                echo "<img src='data:image/jpeg;base64," . base64_encode($image_data) . "' alt='Product Image' style='max-width: 100px; max-height: 100px;'>";
            } else {
                echo "No Image Available";
            }
            echo "</td>";
            echo "<td>{$product_name}</td>";
            echo "<td>{$quantity}</td>";
            echo "<td>RM{$product_price}</td>";
            // Calculate total price
            $total_price += $product_price * $quantity;
            // Add delete form with product id
            echo "<td><form method='POST'><input type='hidden' name='product_id' value='{$product_id}'><button type='submit' name='delete_btn' class='btn btn-danger'>Delete</button></form></td>";
            echo "</tr>";

            // Store cart item in array
            $cart_items[] = array(
                'cart_item_id' => $cart_item_id,
                'product_id' => $product_id,
                'quantity' => $quantity,
                'product_name' => $product_name,
                'product_price' => $product_price,
                'image_data' => $image_data
            );
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>"; // Close col
        echo "</div>"; // Close row

        // Display total price row
        echo "<div class='row'>";
        echo "<div class='col'>";
        echo "<h4 class='mt-4'>Total Price: RM{$total_price}</h4>";
        echo "</div>"; // Close col
        echo "</div>"; // Close row

        // Display button to proceed to payment
        echo "<div class='row'>";
        echo "<div class='col'>";
        // Link to the address selection page - Can change between display.php to check details / address to proceed to address
        echo "<a href='address.php' class='btn btn-primary'>Proceed to Payment</a>";
        echo "</div>"; // Close col
        echo "</div>"; // Close row

        echo "</div>"; // Close container

        // Save cart items into session
        $_SESSION['cart_items'] = serialize($cart_items);

        // Close statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    // Handle the case where user is not logged in
    echo "User is not logged in.";
}

// Check if delete button is clicked and process deletion
if(isset($_POST['delete_btn'])) {
    // Get product ID from the form
    $product_id = $_POST['product_id'];
    
    // Decrement quantity by 1
    $update_query = "UPDATE cart_items SET quantity = quantity - 1 WHERE user_id = ? AND product_id = ? AND quantity > 0";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ii", $_SESSION['user_id'], $product_id);
    if($update_stmt->execute()) {
        // Check if the quantity is now 0 and delete the row if so
        $delete_query = "DELETE FROM cart_items WHERE user_id = ? AND product_id = ? AND quantity = 0";
        $delete_stmt = $conn->prepare($delete_query);
        $delete_stmt->bind_param("ii", $_SESSION['user_id'], $product_id);
        if($delete_stmt->execute()) {
            echo "<script>alert('Item deleted successfully.');</script>";
            // Redirect to refresh the page
            echo "<script>window.location.href = 'view_cart.php';</script>";
        } else {
            echo "Error deleting item: " . $conn->error;
        }
        $delete_stmt->close();
    } else {
        echo "Error updating quantity: " . $conn->error;
    }
    
    // Close statement
    $update_stmt->close();
}

// Close connection
$conn->close();
?>
