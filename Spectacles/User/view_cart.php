<?php
session_start();
include("NavBar.php");

// Include your database connection file
include("connection.php");

$total_price = 0; // Variable to store total price

// Check if user is logged in
if(isset($_SESSION['user_id'])) {
    // Query to select cart items for the logged-in user
    $query = "SELECT ci.id, ci.product_id, ci.quantity, p.name, p.price, i.image_data 
              FROM cart_items ci 
              INNER JOIN models p ON ci.product_id = p.id 
              LEFT JOIN images i ON p.id = i.model_id 
              WHERE ci.user_id = ?";

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
        echo "<div class='container my-5'>";
        echo "<h2 class='my-4 text-center'>Cart Items</h2>";
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered'>";
        echo "<thead class='table-dark'>";
        echo "<tr><th>No</th><th>Product Img</th><th>Product Name</th><th>Quantity</th><th>Price</th><th>Action</th></tr>";
        echo "</thead>";
        echo "<tbody>";
        while ($stmt->fetch()) {
            echo "<tr class='align-middle'>";
            echo "<td>{$cart_item_id}</td>";
            // Display image if available
            echo "<td>";
            if ($image_data) {
                echo "<img src='data:image/jpeg;base64," . base64_encode($image_data) . "' alt='Product Image' class='product-img'>";
            } else {
                echo "No Image Available";
            }
            echo "</td>";
            echo "<td>{$product_name}</td>";
            echo "<td>{$quantity}</td>";
            echo "<td>RM" . number_format($product_price, 2) . "</td>";
            // Calculate total price
            $total_price += $product_price * $quantity;
            // Add delete form with product id
            echo "<td><form method='POST'><input type='hidden' name='product_id' value='{$product_id}'><button type='submit' name='delete_btn' class='btn btn-danger btn-sm'>Delete</button></form></td>";
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
        echo "</div>"; // Close table-responsive

        // Display total price row
        echo "<div class='d-flex justify-content-center mt-4'>";
        echo "<h4 class='total-price text-center align-self-center'>Total Price: RM" . number_format($total_price, 2) . "</h4>";
        echo "</div>"; // Close d-flex // Close text-end

        // Display button to proceed to payment
        echo "<div class='text-center mt-4'>";
        echo "<a href='address.php' class='btn btn-primary btn-lg'>Proceed to Payment</a>";
        echo "</div>"; // Close text-center

        echo "</div>"; // Close container

        // Save cart items into session
        $_SESSION['cart_items'] = serialize($cart_items);

        // Close statement
        $stmt->close();
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error preparing statement: " . $conn->error . "</div>";
    }
} else {
    // Handle the case where user is not logged in
    echo "<div class='container my-5'><div class='alert alert-warning' role='alert'>User is not logged in.</div></div>";
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
            echo "<div class='alert alert-danger' role='alert'>Error deleting item: " . $conn->error . "</div>";
        }
        $delete_stmt->close();
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error updating quantity: " . $conn->error . "</div>";
    }
    
    // Close statement
    $update_stmt->close();
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Cart</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjD BrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .product-img {
      max-width: 100px;
      max-height: 100px;
      object-fit: cover;
      margin-right: 10px;
      border-radius: 5px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .product-img:hover {
      transform: scale(1.1);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .total-price {
      font-weight: bold;
      font-size: 18px;
      margin-top: 20px;
    }
    .btn-danger {
      transition: background-color 0.3s ease, transform 0.3s ease;
    }
    .btn-danger:hover {
      background-color: #ff4c4c;
      transform: scale(1.1);
    }
    .btn-primary {
      transition: background-color 0.3s ease, transform 0.3s ease;
    }
    .btn-primary:hover {
      background-color: #0056b3;
      transform: scale(1.1);
    }
    .table {
      margin-top: 20px;
      border-radius: 10px;
      overflow: hidden;
    }
    .table th, .table td {
      text-align: center;
      vertical-align: middle;
    }
    .table thead th {
      background-color: #343a40;
      color: #fff;
    }
    .alert {
      margin-top: 20px;
    }
  </style>
</head>
<body>
</body>
</html>
