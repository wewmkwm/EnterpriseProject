<?php
// Include database connection
include 'connection.php';

// Function to fetch receipts for the current month
function fetchMonthlyReceipts($conn) {
    // Get current month and year
    $currentMonth = date('m');
    $currentYear = date('Y');

    // Fetch receipts and calculate total amount for each receipt in the current month
    $receipts = [];
    $query = "SELECT r.id, r.invoice_number, SUM(ri.price * ri.quantity) AS total_amount 
              FROM receipt r
              JOIN receipt_items ri ON r.id = ri.receipt_id
              WHERE MONTH(r.created_at) = $currentMonth AND YEAR(r.created_at) = $currentYear
              GROUP BY r.id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $receipts[] = $row;
        }
    }

    return $receipts;
}

// Fetch receipts for the current month
$receipts = fetchMonthlyReceipts($conn);

// Calculate total amount earned in the current month
$totalAmountEarned = 0;
foreach ($receipts as $receipt) {
    $totalAmountEarned += $receipt['total_amount'];
}

// Close database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1>Monthly Report - <?php echo date('F Y'); ?></h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Receipt ID</th>
                    <th>Total Amount (RM)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($receipts as $receipt): ?>
                    <tr>
                        <td><?php echo $receipt['invoice_number']; ?></td>
                        <td>RM <?php echo number_format($receipt['total_amount'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <!-- Display total amount earned in the current month -->
        <div class="mt-3">
            <h5>Total Amount Earned in <?php echo date('F Y'); ?>:</h5>
            <h3>RM <?php echo number_format($totalAmountEarned, 2); ?></h3>
        </div>

        <a href="stock_control.php" class="btn btn-secondary mt-3">Back to Stock Control</a>
    </div>
</body>
</html>
