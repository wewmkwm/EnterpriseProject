<?php
include 'connection.php';

$admin_name = "Admin Name"; // Replace with actual admin's name
$customer_name = $_POST['customer_name'];
$address = $_POST['address'];
$paid = $_POST['paid'];

// Fetch cart items
$cart_items = $conn->query("SELECT * FROM cart WHERE admin_name = '$admin_name'");

// Calculate total
$total = 0;
while ($item = $cart_items->fetch_assoc()) {
    $product_id = $item['product_id'];
    $quantity = $item['quantity'];
    $product = $conn->query("SELECT * FROM stock WHERE id = $product_id")->fetch_assoc();
    $price = $product['price'];
    $subtotal = $price * $quantity;
    $total += $subtotal;
}

// Generate invoice number
$invoice_no = uniqid("INV");

// Insert invoice
$date = date("Y-m-d");
$time = date("H:i:s");
$change_amount = $paid - $total;
$sql = "INSERT INTO invoice (invoice_no, date, time, admin_name, customer_name, address, total, paid, change_amount)
        VALUES ('$invoice_no', '$date', '$time', '$admin_name', '$customer_name', '$address', '$total', '$paid', '$change_amount')";
if ($conn->query($sql) === TRUE) {
    $invoice_id = $conn->insert_id;
    
    // Insert invoice items
    $cart_items = $conn->query("SELECT * FROM cart WHERE admin_name = '$admin_name'");
    while ($item = $cart_items->fetch_assoc()) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $product = $conn->query("SELECT * FROM stock WHERE id = $product_id")->fetch_assoc();
        $price = $product['price'];
        $subtotal = $price * $quantity;
        $conn->query("INSERT INTO invoice_items (invoice_id, product_id, quantity, price, subtotal) VALUES ('$invoice_id', '$product_id', '$quantity', '$price', '$subtotal')");
    }
    
    // Clear cart
    $conn->query("DELETE FROM cart WHERE admin_name = '$admin_name'");
    
    // Redirect to invoice
    header("Location: invoice.php?id=$invoice_id");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
