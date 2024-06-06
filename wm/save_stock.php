<?php
include 'connection.php';


$product = $_POST['product'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];

$sql = "INSERT INTO stock (product, price, quantity) VALUES ('$product', '$price', '$quantity')";
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
header('Location: stkctrl.php');
exit();
?>
