<?php
// Include database connection
include 'connection.php';

// Fetch all items from customer_cart
$result_cart = $conn->query("SELECT customer_cart.id, models.id AS product_id, models.name, models.price, customer_cart.quantity
                        FROM customer_cart
                        JOIN models ON customer_cart.model_id = models.id");

// Insert into receipt table and get the receipt ID
$totalAmount = 0;
if ($result_cart->num_rows > 0) {
    // Start transaction for data integrity
    $conn->begin_transaction();

    // Insert into receipt table
    $insertReceiptSQL = "INSERT INTO receipt (user_id, invoice_number, total_price, created_at) VALUES (1, 'INV-" . uniqid() . "', $totalAmount, NOW())";
    if ($conn->query($insertReceiptSQL) === TRUE) {
        $receipt_id = $conn->insert_id;
        while ($row = $result_cart->fetch_assoc()) {
            // Insert into receipt_items table
            $insertReceiptItemSQL = "INSERT INTO receipt_items (receipt_id, product_id, quantity, price) VALUES ($receipt_id, {$row['product_id']}, {$row['quantity']}, {$row['price']})";
            if ($conn->query($insertReceiptItemSQL) === TRUE) {
                $totalAmount += $row['price'] * $row['quantity'];

                // Update model quantity (deduct from stock)
                $updateModelSQL = "UPDATE models SET quantity = quantity - {$row['quantity']} WHERE id = {$row['product_id']} AND quantity >= {$row['quantity']}";
                if ($conn->query($updateModelSQL) !== TRUE) {
                    $conn->rollback();
                    echo "Error updating stock for product ID {$row['product_id']}. Transaction rolled back.";
                    exit;
                }
            } else {
                $conn->rollback();
                echo "Error inserting receipt item: " . $conn->error;
                exit;
            }
        }

        // Commit transaction if all queries are successful
        $conn->commit();
    } else {
        echo "Error inserting receipt: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: auto;
        }
        .receipt-header {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .receipt-header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .receipt-header p {
            margin: 0;
        }
        .receipt-header .receipt-id {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .receipt-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .receipt-table th, .receipt-table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .receipt-table th {
            background-color: #f2f2f2;
        }
        .receipt-table tfoot th {
            text-align: right;
            border-top: 1px solid #ddd;
        }
        .btn-back {
            margin-top: 20px;
        }
        .btn-print {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="receipt-header">
            <h1>Receipt</h1>
            <p class="receipt-id">Receipt ID: <?php echo $receipt_id; ?></p>
            <p>Invoice Number: <?php echo 'INV-' . uniqid(); ?></p>
            <p>Date: <?php echo date('Y-m-d H:i:s'); ?></p>
        </div>
        <table class="receipt-table">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result_receipt = $conn->query("SELECT ri.product_id, m.name, ri.price, ri.quantity FROM receipt_items ri JOIN models m ON ri.product_id = m.id WHERE ri.receipt_id = $receipt_id");
                if ($result_receipt->num_rows > 0) {
                    while ($row = $result_receipt->fetch_assoc()) {
                        $total = $row['price'] * $row['quantity'];
                        echo "<tr>";
                        echo "<td>{$row['product_id']}</td>";
                        echo "<td>{$row['name']}</td>";
                        echo "<td>RM " . number_format($row['price'], 2) . "</td>";
                        echo "<td>{$row['quantity']}</td>";
                        echo "<td>RM " . number_format($total, 2) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No items found in receipt</td></tr>";
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4">Total Amount:</th>
                    <th>RM <?php echo number_format($totalAmount, 2); ?></th>
                </tr>
            </tfoot>
        </table>

        <a href="stock_control.php" class="btn btn-secondary btn-back"><i class="fas fa-arrow-left"></i> Back to Stock Control</a>

        <button class="btn btn-primary btn-print" onclick="window.print();"><i class="fas fa-print"></i> Print Receipt</button>
    </div>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
