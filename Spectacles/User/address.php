<?php
// Include your database connection file
include("connection.php");

// Fetch addresses from the database using the $conn variable
$query = "SELECT id, address FROM address";
$result = mysqli_query($conn, $query); // Use $conn instead of $connection

$addresses = array();
while ($row = mysqli_fetch_assoc($result)) {
    $addresses[] = $row;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Address Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .address-card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <form action="user_card.php" method="post">
            <h2>Select Address</h2>
            <div id="addresses-container">
                <?php foreach ($addresses as $address): ?>
                    <div class="address-card">
                        <label>
                            <input type="radio" name="selected_address" value="<?php echo $address['id']; ?>">
                            <?php echo $address['address']; ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
			
            <button type="submit" class="btn btn-primary">Proceed</button>
			
        </form>
		<a type="submit" class="btn btn-primary" href="address_selection.php">Add Address</a>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
</body>
	<?php
session_start();

// Check if the user_id is set in the session
if(isset($_SESSION['user_id'])) {
    // Display the user ID
    echo "User ID: " . $_SESSION['user_id'] . "<br>";
} else {
    // If user ID is not set, handle it as per your application's logic
    echo "User ID not found.";
}

// Check if cart items are stored in the session
if(isset($_SESSION['cart_items'])) {
    // Unserialize cart items
    $cart_items = unserialize($_SESSION['cart_items']);
    
    // Display cart items
    foreach ($cart_items as $item) {
        // Display each item
        echo "Cart Item ID: " . $item['cart_item_id'] . "<br>";
        echo "Product ID: " . $item['product_id'] . "<br>";
        echo "Product Name: " . $item['product_name'] . "<br>";
        echo "Quantity: " . $item['quantity'] . "<br>";
        echo "Price: RM" . $item['product_price'] . "<br>";
        // Display other item details as needed
    }
} else {
    echo "No items in the cart.";
}
?>

</html>
