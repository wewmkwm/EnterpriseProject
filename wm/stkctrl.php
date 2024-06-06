<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Control System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/stkctrl.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Frame Stock</h1>
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
            <a href="add_stock.php" class="btn btn-success">Add New Stock</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                    <th>View History</th>
                    <th>Add to Cart</th> <!-- New table header for "Add to Cart" button -->
                </tr>
            </thead>
            <tbody id="stock-list">
                <?php
                include 'connection.php';
                $result = $conn->query("SELECT * FROM stock");
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['product'] . "</td>";
                    echo "<td>RM" . $row['price'] . "</td>";
                    echo "<td>" . $row['quantity'] . "</td>";
                    echo '<td><a href="edit.php?id=' . $row['id'] . '" class="btn btn-primary">Edit</a></td>';
                    echo '<td><a href="history.php?id=' . $row['id'] . '" class="btn btn-info">View History</a></td>';
                    echo '<td><a href="cart.php?action=add&id=' . $row['id'] . '" class="btn btn-success">Add to Cart</a></td>'; // New column for "Add to Cart" button
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function searchProduct() {
            var input = document.getElementById("search-input").value.toLowerCase();
            var table = document.getElementById("stock-list");
            var rows = table.getElementsByTagName("tr");

            for (var i = 0; i < rows.length; i++) {
                var productNameCell = rows[i].getElementsByTagName("td")[0];
                if (productNameCell) {
                    var productName = productNameCell.textContent || productNameCell.innerText;
                    if (productName.toLowerCase().indexOf(input) > -1) {
                        rows[i].style.display = "";
                    } else {
                        rows[i].style.display = "none";
                    }
                }
            }
        }

        function filterProducts() {
            var filterValue = document.getElementById("filter-select").value;
            var table = document.getElementById("stock-list");
            var rows = table.getElementsByTagName("tr");

            for (var i = 0; i < rows.length; i++) {
                var priceCell = rows[i].getElementsByTagName("td")[1];
                var quantityCell = rows[i].getElementsByTagName("td")[2];
                if (priceCell && quantityCell) {
                    var price = parseFloat(priceCell.innerText.replace('RM', ''));
                    var quantity = parseInt(quantityCell.innerText);

                    if (filterValue === "low-quantity" && quantity >= 5) {
                        rows[i].style.display = "none";
                    } else if (filterValue === "high-price" && price <= 50) {
                        rows[i].style.display = "none";
                    } else {
                        rows[i].style.display = "";
                    }
                }
            }
        }

        document.getElementById("search-input").addEventListener("keyup", searchProduct);
        document.getElementById("filter-select").addEventListener("change", filterProducts);
    </script>
</body>
</html>
