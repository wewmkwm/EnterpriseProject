<?php
session_start();

// Include your database connection file
include("connection.php");

// Check if user is logged in (you may need to adjust this based on your authentication system)
if (isset($_SESSION['user_id'])) {
  // Display the user ID (optional, can be removed)
  // echo "User ID: " . $_SESSION['user_id'];

  // Check if productId is provided in the request
  if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Check if quantity is provided, default to 1 if not provided
    $quantity = isset($_GET['quantity']) ? $_GET['quantity'] : 1;

    // Check if the item already exists in the cart
    $check_query = "SELECT id, quantity FROM cart_items WHERE user_id = ? AND product_id = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("ii", $_SESSION['user_id'], $product_id);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
      // Item already exists in the cart, update quantity
      $check_stmt->bind_result($cart_item_id, $existing_quantity);
      $check_stmt->fetch();
      $new_quantity = $existing_quantity + $quantity;
      $update_query = "UPDATE cart_items SET quantity = ? WHERE id = ?";
      $update_stmt = $conn->prepare($update_query);
      $update_stmt->bind_param("ii", $new_quantity, $cart_item_id);
      if ($update_stmt->execute()) {
        $message = "Quantity updated successfully.";
      } else {
        $message = "Error updating quantity: " . $conn->error;
      }
      $update_stmt->close();
    } else {
      // Item does not exist in the cart, insert new record
      $insert_query = "INSERT INTO cart_items (user_id, product_id, quantity, created_at) VALUES (?, ?, ?, CURRENT_TIMESTAMP)";
      $insert_stmt = $conn->prepare($insert_query);
      $insert_stmt->bind_param("iii", $_SESSION['user_id'], $product_id, $quantity);
      if ($insert_stmt->execute()) {
        $message = "Product added to cart successfully.";
      } else {
        $message = "Error adding product to cart: " . $conn->error;
      }
      $insert_stmt->close();
    }
    $check_stmt->close();
  } else {
    // Handle the case where no product ID is provided
    $message = "Product ID not found.";
  }
} else {
  // Handle the case where user is not logged in
  $message = "User is not logged in.";
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart Notification</title>
  <link rel="stylesheet" href="styles.css">
  <style>
   body {
  font-family: sans-serif;
  margin: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #f5f5f5;
}

.notification-container {
  background-color: #fff;
  border-radius: 10px; /* Rounded corners */
  padding: 30px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); /* Subtle shadow */
  text-align: center;
  position: relative; /* Required for icon positioning */
}

.notification-container::before {
  /* Icon (replace with your desired icon) */
  content: url("path/to/your/icon.svg"); /* Replace with actual icon path */
  position: absolute;
  top: -30px; /* Position icon above the container */
  left: 50%;
  transform: translateX(-50%); /* Center icon horizontally */
  font-size: 40px; /* Adjust icon size as needed */
  color: #3498db; /* Optional icon color */
}

.notification-message {
  margin-bottom: 15px;
  font-size: 18px;
  color: #333; /* Message text color */
}

.btn {
  background-color: #3498db; /* Primary color */
  color: #fff;
  padding: 12px 25px; /* Adjust padding as needed */
  border: none;
  border-radius: 5px;
  cursor: pointer;
  text-decoration: none;
  font-weight: bold; /* Bold button text */
  transition: background-color 0.2s ease-in-out; /* Smooth transition on hover */
}

.btn:hover {
  background-color: #2980b9; /* Darker shade on hover */
}

  </style>  
</head>
<body>
  <div class="notification-container">
    <p class="notification-message"><?php echo $message; ?></p>
    <a href="frame_product.php" class="btn btn-primary">Return</a>
  </div>

  </body>
</html>
