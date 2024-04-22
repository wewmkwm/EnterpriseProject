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
    <!-- Meta tags, title, and CSS -->
</head>
<body>
    <div class="container mt-4">
        <form action="#" method="post">
            <?php if (!empty($cards)): ?> <!-- Check if there are any cards available -->
                <h2>Select Card</h2>
                <div id="cards-container">
                    <?php foreach ($cards as $card): ?>
                        <div class="card">
                            <label>
                                <input type="radio" name="selected_card" value="<?php echo $card['card_id']; ?>">
                                **** **** **** <?php echo substr($card['card_number'], -4); ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="submit" class="btn btn-primary">Proceed</button>
            <?php else: ?>
                <p>No cards available.</p>
            <?php endif; ?>
        </form>
        <a type="submit" class="btn btn-primary" href="add_card.php">Add Card</a>
    </div>

    <!-- Bootstrap JS -->
</body>
</html>
	