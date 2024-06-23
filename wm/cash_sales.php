<?php
// Include database connection
include 'connection.php';

// Function to sanitize input
function sanitize($input) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($input));
}

// Handle adding to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['model_id']) && isset($_POST['quantity'])) {
    $model_id = sanitize($_POST['model_id']);
    $quantity = (int) sanitize($_POST['quantity']);

    // Insert into customer_cart table
    $sql = "INSERT INTO customer_cart (model_id, quantity) VALUES ('$model_id', $quantity)";
    if ($conn->query($sql) === TRUE) {
        echo '<div class="alert alert-success" role="alert">Item added to cart successfully!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Error adding item to cart: ' . $conn->error . '</div>';
    }
}

// Fetch models from database
$result = $conn->query("SELECT models.id, brands.name AS brand_name, models.name, models.price, models.quantity, models.category FROM models JOIN brands ON models.brand_id = brands.id");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash Sales</title>
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
        <div class="mb-3">
            <a href="stock_control.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Stock Control</a>
        </div>
        <h1>Cash Sales</h1>
        <?php
        // Display message if item added to cart
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['model_id']) && isset($_POST['quantity'])) {
            if ($conn->affected_rows > 0) {
                echo '<div class="alert alert-success" role="alert">Item added to cart successfully!</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Error adding item to cart: ' . $conn->error . '</div>';
            }
        }
        ?>
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
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Brand</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="stock-list">
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['brand_name'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>RM" . $row['price'] . "</td>";
                        echo "<td>" . $row['quantity'] . "</td>";
                        echo "<td>" . $row['category'] . "</td>";
                        echo "<td>
                                <form method='post'>
                                    <input type='hidden' name='model_id' value='" . $row['id'] . "'>
                                    <input type='number' name='quantity' value='1' min='1' max='" . $row['quantity'] . "' style='width: 60px;' required>
                                    <button type='submit' class='btn btn-primary'>Add to Cart</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="mt-3">
            <a href="customer_cart.php" class="btn btn-info">View Customer Cart</a>
        </div>
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
<?php
// Close database connection
$conn->close();
?>
