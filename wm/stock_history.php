<?php
// stock_history.php

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productId = $_GET['id'];

    include 'connection.php';

    // Fetch product details
    $productQuery = "SELECT name FROM models WHERE id = '$productId'";
    $productResult = $conn->query($productQuery);

    if ($productResult->num_rows > 0) {
        $product = $productResult->fetch_assoc();
        $productName = $product['name'];

        // Fetch history records
        $historyQuery = "SELECT * FROM stock_history WHERE product_id = '$productId' ORDER BY change_time DESC";
        $historyResult = $conn->query($historyQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1>Stock History for <?php echo $productName; ?></h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Change Type</th>
                    <th>Old Value</th>
                    <th>New Value</th>
                    <th>Change Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($historyResult->num_rows > 0) {
                    while ($row = $historyResult->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . ucfirst($row['change_type']) . "</td>";
                        echo "<td>" . $row['old_value'] . "</td>";
                        echo "<td>" . $row['new_value'] . "</td>";
                        echo "<td>" . $row['change_time'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No history found for this product.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="stock_control.php" class="btn btn-secondary">Back to Stock Control</a>
    </div>
</body>
</html>

<?php
    } else {
        echo "Product not found.";
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
?>
