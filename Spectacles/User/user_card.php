<?php
// Include your database connection file
include("connection.php");

// Start the session
session_start();

// Save the selected card in the session if it's submitted
if(isset($_POST['selected_card'])) {
    $_SESSION['selected_card'] = $_POST['selected_card'];

    // Decrease product quantity and clear cart items
    if(isset($_SESSION['cart_items'])) {
        $cart_items = unserialize($_SESSION['cart_items']);
        
        foreach ($cart_items as $item) {
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];

            // Decrease product quantity in the database
            $queryUpdateQuantity = "UPDATE models SET quantity = quantity - ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $queryUpdateQuantity);
            mysqli_stmt_bind_param($stmt, "ii", $quantity, $product_id);
            mysqli_stmt_execute($stmt);

            // Clear cart items from the database
            $queryClearCart = "DELETE FROM cart_items WHERE user_id = ?";
            $stmt = mysqli_prepare($conn, $queryClearCart);
            $user_id = $_SESSION['user_id']; // Assuming you have user_id stored in the session
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
        }
    }

    // Redirect to the display.php page after saving the selected card and updating the database
    header("Location: display.php");
    exit(); // Stop further execution of this script after redirection
}

// Fetch user's credit/debit card information
$queryCards = "SELECT card_id, card_number FROM user_cards WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $queryCards);
$user_id = 1; // Replace with the actual user's ID
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$resultCards = mysqli_stmt_get_result($stmt);

$cards = array();
while ($rowCard = mysqli_fetch_assoc($resultCards)) {
    $cards[] = $rowCard;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Card</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #e9f5f5; /* Light teal background */
            color: #333; /* Standard text color */
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
            padding: 30px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .card-selection {
            margin: 10px 0;
        }
        .card {
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 10px;
            transition: box-shadow 0.3s ease;
        }
        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .card label {
            width: 100%;
            margin: 0;
            padding: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card input {
            margin-right: 10px;
        }
        .btn-primary {
            background-color: #ff6347; /* Vibrant coral color */
            border-color: #ff6347;
            color: #fff;
            padding: 12px 25px;
            border-radius: 8px;
            width: 100%;
            margin-top: 20px;
            transition: all 0.2s ease-in-out;
        }
        .btn-primary:hover {
            background-color: #e5533d; /* Darker coral on hover */
            border-color: #e5533d;
            transform: translateY(-2px); /* Slight lift on hover */
        }
        .btn-secondary {
            background-color: #007bff; /* Blue color */
            border-color: #007bff;
            color: #fff;
            padding: 12px 25px;
            border-radius: 8px;
            width: 100%;
            margin-top: 10px;
            transition: all 0.2s ease-in-out;
        }
        .btn-secondary:hover {
            background-color: #0056b3; /* Darker blue on hover */
            border-color: #0056b3;
            transform: translateY(-2px); /* Slight lift on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Select Card</h2>
        <form action="#" method="post">
            <?php if (!empty($cards)): ?>
                <div id="cards-container">
                    <?php foreach ($cards as $card): ?>
                        <div class="card card-selection">
                            <label>
                                <input type="radio" name="selected_card" value="<?php echo $card['card_id']; ?>">
                                <span>**** **** **** <?php echo substr($card['card_number'], -4); ?></span>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="submit" class="btn btn-primary">Proceed</button>
            <?php else: ?>
                <p>No cards available.</p>
            <?php endif; ?>
        </form>
        <a href="add_card.php" class="btn btn-secondary mt-2">Add Card</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
