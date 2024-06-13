<?php
// Include your database connection file
include("connection.php");

// Fetch addresses from the database using the $conn variable
$query = "SELECT id, address FROM address";

$result = mysqli_query($conn, $query);

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
  <title>Select Delivery Address</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      background-color: #f2f2f2;
      font-family: 'Poppins', sans-serif;
      font-size: 18px;
      color: #333;
    }
    .container {
      max-width: 800px;
      margin: 50px auto;
      background: #fff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }
    .address-card {
      background-color: #fffbf0;
      border: 1px solid #e0d4b7;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
      transition: box-shadow 0.3s ease;
    }
    .address-card:hover {
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }
    .address-card h3 {
      margin-bottom: 10px;
      font-size: 22px;
      color: #ff6347;
    }
    .address-card label {
      display: flex;
      align-items: center;
      font-size: 18px;
    }
    .address-card input[type="radio"] {
      margin-right: 10px;
      transform: scale(1.5);
    }
    .btn-primary, .btn-outline-primary {
      padding: 12px 25px;
      font-size: 18px;
      border-radius: 5px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }
    .btn-primary {
      background-color: #ff6347;
      border: none;
    }
    .btn-primary:hover {
      background-color: #e5533d;
      transform: translateY(-2px);
    }
    .btn-outline-primary {
      border: 2px solid #ff6347;
      color: #ff6347;
      background: none;
    }
    .btn-outline-primary:hover {
      background-color: #ff6347;
      color: #fff;
      transform: translateY(-2px);
    }
    h2 {
      font-weight: 600;
      color: #333;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2 class="text-center mb-4">Choose Your Delivery Address</h2>
    <form action="user_card.php" method="post">
      <div id="addresses-container">
        <?php
        if (empty($addresses)) {
          echo "<p>You don't have any saved addresses yet. Please add one before proceeding.</p>";
        } else {
          foreach ($addresses as $address): ?>
            <div class="address-card">
              <h3>Delivery Address</h3>
              <label>
                <input type="radio" name="selected_address" value="<?php echo $address['id']; ?>">
                <?php echo $address['address']; ?>
              </label>
            </div>
          <?php endforeach;
        }
        ?>
      </div>
      <div class="d-flex justify-content-between mt-4">
        <button type="submit" class="btn btn-primary">Proceed to Checkout</button>
        <a href="address_selection.php" class="btn btn-outline-primary">Add New Address</a>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>


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
