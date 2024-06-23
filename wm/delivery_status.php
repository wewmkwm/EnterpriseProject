<?php
// Include database connection
include 'connection.php';

// Function to fetch delivery statuses with optional filter
function fetchDeliveryStatuses($conn, $filter = null) {
    $deliveryStatuses = [];
    $filterCondition = "";
    
    // Construct filter condition
    if ($filter) {
        $filterCondition = " WHERE status = '$filter'";
    }
    
    $query = "SELECT id, receipt_id, status, status_timestamp, notes FROM delivery_status" . $filterCondition;
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $deliveryStatuses[] = $row;
        }
    }

    return $deliveryStatuses;
}

// Update delivery status if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['status']) && isset($_POST['notes']) && isset($_POST['status_id'])) {
        $status = $_POST['status'];
        $notes = $_POST['notes'];
        $status_id = $_POST['status_id'];

        // Update delivery status
        $updateQuery = "UPDATE delivery_status SET status = '$status', notes = '$notes' WHERE id = $status_id";
        if ($conn->query($updateQuery) === TRUE) {
            echo "<script>alert('Delivery status updated successfully');</script>";
        } else {
            echo "<script>alert('Error updating delivery status: " . $conn->error . "');</script>";
        }
    }
}

// Fetch delivery statuses with optional filter
$filter = isset($_GET['filter']) ? $_GET['filter'] : null;
$deliveryStatuses = fetchDeliveryStatuses($conn, $filter);

// Close database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1>Delivery Status</h1>

        <!-- Filter Form -->
        <form action="" method="GET" class="mb-3">
            <div class="form-group">
                <label for="status-filter">Filter by Status:</label>
                <select id="status-filter" class="form-control" name="filter">
                    <option value="">All</option>
                    <option value="Pending" <?php if ($filter === 'Pending') echo 'selected'; ?>>Pending</option>
                    <option value="In Progress" <?php if ($filter === 'In Progress') echo 'selected'; ?>>In Progress</option>
                    <option value="Delivered" <?php if ($filter === 'Delivered') echo 'selected'; ?>>Delivered</option>
                </select>
            </div>
        </form>

        <!-- Delivery Status Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Receipt ID</th>
                    <th>Status</th>
                    <th>Status Timestamp</th>
                    <th>Notes</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($deliveryStatuses as $status): ?>
                    <tr>
                        <form method="POST">
                            <input type="hidden" name="status_id" value="<?php echo $status['id']; ?>">
                            <td><?php echo $status['id']; ?></td>
                            <td><?php echo $status['receipt_id']; ?></td>
                            <td>
                                <select class="form-control" name="status">
                                    <option value="Pending" <?php if ($status['status'] === 'Pending') echo 'selected'; ?>>Pending</option>
                                    <option value="In Progress" <?php if ($status['status'] === 'In Progress') echo 'selected'; ?>>In Progress</option>
                                    <option value="Delivered" <?php if ($status['status'] === 'Delivered') echo 'selected'; ?>>Delivered</option>
                                </select>
                            </td>
                            <td><?php echo $status['status_timestamp']; ?></td>
                            <td><textarea class="form-control" name="notes"><?php echo $status['notes']; ?></textarea></td>
                            <td><button type="submit" class="btn btn-primary">Update</button></td>
                        </form>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Back Button -->
        <a href="stock_control.php" class="btn btn-secondary">Back to Stock Control</a>
    </div>

    <script>
        // JavaScript to handle form submission and apply filter
        document.addEventListener('DOMContentLoaded', function() {
            const statusFilter = document.getElementById('status-filter');
            statusFilter.addEventListener('change', function() {
                this.form.submit(); // Submit the form when filter value changes
            });
        });
    </script>
</body>
</html>
