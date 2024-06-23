<?php
// update_stock.php

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Check if id is set and valid
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];

        // Fetch stock details from database based on $id
        include 'connection.php';

        $query = "SELECT * FROM models WHERE id = '$id'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Stock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Stock</h1>
        <form action="update_stock.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo $row['name']; ?>">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="text" id="price" name="price" class="form-control" value="<?php echo $row['price']; ?>">
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" id="quantity" name="quantity" class="form-control" value="<?php echo $row['quantity']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="stock_control.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
<?php
        } else {
            echo "Stock item not found.";
        }

        $conn->close();
    } else {
        echo "Invalid stock item id.";
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Process form submission to update stock details
    if (isset($_POST['id']) && is_numeric($_POST['id'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];

        // Validate and sanitize inputs if necessary

        // Update the record in the database
        include 'connection.php';

        // Fetch old values before updating
        $fetchQuery = "SELECT name, price, quantity FROM models WHERE id = '$id'";
        $fetchResult = $conn->query($fetchQuery);

        if ($fetchResult->num_rows > 0) {
            $oldValues = $fetchResult->fetch_assoc();

            // Update the record
            $updateQuery = "UPDATE models SET name = '$name', price = '$price', quantity = '$quantity' WHERE id = '$id'";
            if ($conn->query($updateQuery) === TRUE) {
                // Log the changes in history table
                logHistory($conn, $id, 'name', $oldValues['name'], $name);
                logHistory($conn, $id, 'price', $oldValues['price'], $price);
                logHistory($conn, $id, 'quantity', $oldValues['quantity'], $quantity);

                echo "<script>alert('Stock updated successfully');</script>";
                echo "<script>window.location.href = 'stock_control.php';</script>";
            } else {
                echo "Error updating stock: " . $conn->error;
            }
        } else {
            echo "Error fetching old values.";
        }

        $conn->close();
    } else {
        echo "Invalid request.";
    }
}

// Function to log history
function logHistory($conn, $productId, $changeType, $oldValue, $newValue) {
    $productId = mysqli_real_escape_string($conn, $productId);
    $changeType = mysqli_real_escape_string($conn, $changeType);
    $oldValue = mysqli_real_escape_string($conn, $oldValue);
    $newValue = mysqli_real_escape_string($conn, $newValue);

    $insertQuery = "INSERT INTO stock_history (product_id, change_type, old_value, new_value) VALUES ('$productId', '$changeType', '$oldValue', '$newValue')";
    $conn->query($insertQuery);
}
?>
