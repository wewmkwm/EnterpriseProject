<?php
session_start();
include 'connection.php';

// Add to cart
if(isset($_GET['action']) && $_GET['action'] == "add"){
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM stock WHERE id=$id");
    $product = $result->fetch_assoc();
    if($product){
        $item = [
            'id' => $product['id'],
            'product' => $product['product'],
            'price' => $product['price'],
            'quantity' => 1
        ];

        if(isset($_SESSION['cart'][$id])){
            $_SESSION['cart'][$id]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$id] = $item;
        }
    }
}

// Remove from cart
if(isset($_GET['action']) && $_GET['action'] == "remove"){
    $id = intval($_GET['id']);
    if(isset($_SESSION['cart'][$id])){
        unset($_SESSION['cart'][$id]);
    }
}

// Update cart quantity
if(isset($_POST['update_quantity'])){
    $id = intval($_POST['id']);
    $quantity = intval($_POST['quantity']);
    if(isset($_SESSION['cart'][$id])){
        $_SESSION['cart'][$id]['quantity'] = $quantity;
    }
}

// Checkout
if(isset($_POST['checkout'])){
    $total_price = 0;
    foreach($_SESSION['cart'] as $id => $item){
        $total_price += $item['price'] * $item['quantity'];
        $conn->query("UPDATE stock SET quantity = quantity - {$item['quantity']} WHERE id = $id");
    }
    $payment = $_POST['payment'];
    $change = $payment - $total_price;

    // Generate Invoice
    $invoice_id = rand(1000,9999);
    $date = date("Y-m-d");
    $time = date("H:i:s");
    $admin_name = "Admin Name"; // Replace with actual admin name
    $address = "Shop Address"; // Replace with actual shop address

    // Redirect to invoice page
    header("Location: invoice.php?invoice_id=$invoice_id&date=$date&time=$time&admin_name=$admin_name&address=$address&total_price=$total_price&payment=$payment&change=$change");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1>Cart</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_price = 0;
                if(isset($_SESSION['cart'])){
                    foreach($_SESSION['cart'] as $item){
                        $subtotal = $item['price'] * $item['quantity'];
                        $total_price += $subtotal;
                        echo "<tr>";
                        echo "<td>{$item['product']}</td>";
                        echo "<td>RM{$item['price']}</td>";
                        echo "<td>
                                <form method='post' style='display:inline-block;'>
                                    <input type='hidden' name='id' value='{$item['id']}'>
                                    <input type='number' name='quantity' value='{$item['quantity']}' min='1' style='width: 60px;'>
                                    <button type='submit' name='update_quantity' class='btn btn-secondary'>Update</button>
                                </form>
                              </td>";
                        echo "<td>RM{$subtotal}</td>";
                        echo '<td><a href="cart.php?action=remove&id=' . $item['id'] . '" class="btn btn-danger">Remove</a></td>';
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
        <h2>Total: RM<?php echo $total_price; ?></h2>
        <form method="post">
            <div class="mb-3">
                <label for="payment" class="form-label">Payment Amount</label>
                <input type="number" class="form-control" id="payment" name="payment" required>
            </div>
            <button type="submit" name="checkout" class="btn btn-primary">Checkout</button>
        </form>
        <div class="mt-3">
            <form method="get" action="cart.php">
                <div class="mb-3">
                    <label for="product_id" class="form-label">Add Product by ID</label>
                    <input type="number" class="form-control" id="product_id" name="id" required>
                </div>
                <input type="hidden" name="action" value="add">
                <button type="submit" class="btn btn-success">Add Product</button>
            </form>
        </div>
        <div class="mt-3">
            <a href="stkctrl.php" class="btn btn-secondary">Back</a>
        </div>
    </div>
</body>
</html>
