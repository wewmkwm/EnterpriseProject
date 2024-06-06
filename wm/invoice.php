<?php
session_start();

// Set the time zone to Malaysia
date_default_timezone_set('Asia/Kuala_Lumpur');

$invoice_id = $_GET['invoice_id'];
$date = $_GET['date'];
$time = $_GET['time'];
$admin_name = $_GET['admin_name'];
$address = $_GET['address'];
$total_price = $_GET['total_price'];
$payment = $_GET['payment'];
$change = $_GET['change'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1>Invoice</h1>
        <p>Invoice Number: <?php echo $invoice_id; ?></p>
        <p>Date: <?php echo date("Y-m-d", strtotime($date)); ?></p>
        <p>Time: <?php echo date("H:i:s", strtotime($time)); ?></p>
        <p>Admin: <?php echo $admin_name; ?></p>
        <p>Address: <?php echo $address; ?></p>
        <table class="table">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($_SESSION['cart'] as $item){
                    $subtotal = $item['price'] * $item['quantity'];
                    echo "<tr>";
                    echo "<td>{$item['id']}</td>";
                    echo "<td>{$item['product']}</td>";
                    echo "<td>RM{$item['price']}</td>";
                    echo "<td>{$item['quantity']}</td>";
                    echo "<td>RM{$subtotal}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <h2>Total: RM<?php echo $total_price; ?></h2>
        <p>Payment: RM<?php echo $payment; ?></p>
        <p>Change: RM<?php echo $change; ?></p>
        <button onclick="window.print()" class="btn btn-primary">Print Invoice</button>
        <a href="stkctrl.php" class="btn btn-secondary">Back</a>
    </div>
</body>
</html>

<?php
// Clear the cart after generating the invoice
unset($_SESSION['cart']);
?>