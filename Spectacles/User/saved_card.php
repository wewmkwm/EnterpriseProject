<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include("connection.php");

    // Retrieve user ID from session
    $user_id = $_SESSION['user_id'];

    // Retrieve card details from the form submission
    $cardholder_name = $_POST['cardholder_name'];
    $card_number = $_POST['card_number'];
    $expiry = $_POST['expiry'];
    $cvv = $_POST['cvv'];

    // Insert card details into the database
    $query = "INSERT INTO user_cards (user_id, card_number, cardholder_name, expiration_date, cvv) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "issss", $user_id, $card_number, $cardholder_name, $expiry, $cvv);
    mysqli_stmt_execute($stmt);

    // Check if the card was saved successfully
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "Card saved successfully.";
    } else {
        echo "Error saving card.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo "Invalid request method.";
}
?>



