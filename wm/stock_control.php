<?php
// Include database connection
include 'connection.php';

// Function to fetch delivery statuses
function fetchDeliveryStatuses($conn) {
    $deliveryStatuses = [];
    $result = $conn->query("SELECT id, receipt_id, status, status_timestamp, notes FROM delivery_status");
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $deliveryStatuses[] = $row;
        }
    }
    return $deliveryStatuses;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Control System</title>
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
        <h1>Stock Control</h1>
        <div class="mb-3">
            <input type="text" id="search-input" class="form-control" placeholder="Search product name">
        </div>
        <div class="mb-3">
            <select id="filter-select" class="form-control">
                <option value="all">All</option>
                <option value="low-quantity">Low Quantity (Less than 5)</option>
                <option value="high-price">High Price (More than RM50)</option>
            </select>
        </div>
        <div class="mb-3">
            <a href="add_stock.php" class="btn btn-success">Add Stock</a>
            <a href="monthly_report.php" class="btn btn-info">Generate Monthly Report</a>
            <a href="cash_sales.php" class="btn btn-warning">Cash Sales</a> <!-- Cash Sales button -->
            <a href="delivery_status.php" class="btn btn-primary">Update Delivery Status</a> <!-- Update Delivery Status button -->
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Brand ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Category</th>
                    <th>Action</th>
                    <th>History</th>
                </tr>
            </thead>
            <tbody id="stock-list">
                <?php
                $result = $conn->query("SELECT * FROM models");

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['brand_id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>RM" . $row['price'] . "</td>";
                        echo "<td>" . $row['quantity'] . "</td>";
                        echo "<td>" . $row['category'] . "</td>";
                        echo "<td><a href='update_stock.php?id=" . $row['id'] . "' class='btn btn-primary'>Edit</a></td>";
                        echo "<td><a href='stock_history.php?id=" . $row['id'] . "' class='btn btn-info'>History</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No records found</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const rows = document.querySelectorAll('#stock-list tr');

            searchInput.addEventListener('input', function() {
                const searchQuery = searchInput.value.trim().toLowerCase();

                rows.forEach(row => {
                    const nameCell = row.querySelector('td:nth-child(3)');
                    if (nameCell) {
                        const nameText = nameCell.textContent.toLowerCase();
                        if (nameText.includes(searchQuery)) {
                            row.classList.remove('hidden');
                        } else {
                            row.classList.add('hidden');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
