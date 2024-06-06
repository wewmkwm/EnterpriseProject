<?php
// view_history.php

include 'connection.php';

if(isset($_GET['id'])) {
    $stock_id = $_GET['id'];

    // Fetch history records for the selected stock item
    $history_query = "SELECT * FROM history WHERE stock_id = $stock_id";
    $history_result = mysqli_query($conn, $history_query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Stock History</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Action</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>

                </tr>
            </thead>
            <tbody>
                <?php
                while($history_row = mysqli_fetch_assoc($history_result)) {
                    echo "<tr>";
                    echo "<td>" . $history_row['date'] . "</td>";
                    echo "<td>" . $history_row['time'] . "</td>";
                    echo "<td>" . $history_row['action'] . "</td>";
                    echo "<td>" . $history_row['product'] . "</td>";
                    echo "<td>" . $history_row['price'] . "</td>";
                    echo "<td>" . $history_row['quantity'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <!-- Back button -->
        <a href="stkctrl.php" class="btn btn-primary">Back</a>
    </div>
</body>
</html>
