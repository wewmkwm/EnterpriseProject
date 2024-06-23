<?php
// Include database connection
include 'connection.php';

// Function to sanitize input
function sanitize($input) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($input));
}

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = sanitize($_POST['delete_id']);
    
    // Perform delete operation
    $sql = "DELETE FROM customer_cart WHERE id = $delete_id";
    if ($conn->query($sql) === TRUE) {
        echo '<div class="alert alert-success" role="alert">Item deleted successfully!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Error deleting item: ' . $conn->error . '</div>';
    }
}

// Fetch cart items from customer_cart table
$result = $conn->query("SELECT customer_cart.id, models.name, models.price, customer_cart.quantity
                        FROM customer_cart
                        JOIN models ON customer_cart.model_id = models.id");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/stkctrl.css">
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Customer Cart</h1>
        <?php
        // Display message if item deleted
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
            if ($conn->affected_rows > 0) {
                echo '<div class="alert alert-success" role="alert">Item deleted successfully!</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Error deleting item: ' . $conn->error . '</div>';
            }
        }
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalAmount = 0;
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $total = $row['price'] * $row['quantity'];
                        $totalAmount += $total;
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>RM" . $row['price'] . "</td>";
                        echo "<td>" . $row['quantity'] . "</td>";
                        echo "<td>RM" . number_format($total, 2) . "</td>";
                        echo "<td>
                                <form method='post'>
                                    <input type='hidden' name='delete_id' value='" . $row['id'] . "'>
                                    <button type='submit' class='btn btn-danger'>Delete</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No items in cart</td></tr>";
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" style="text-align: right;">Total Amount:</th>
                    <th>RM<?php echo number_format($totalAmount, 2); ?></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>

        <div class="mt-3">
            <a href="cash_sales.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Cash Sales</a>
            <?php if ($totalAmount > 0) : ?>
                <a href="generate_receipt.php" class="btn btn-primary"><i class="fas fa-receipt"></i> Checkout</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php
// Close database connection
$conn->close();
?>
