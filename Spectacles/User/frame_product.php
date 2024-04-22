<?php
// Include your database connection file
include("connection.php");

// Fetch brands from the database using the $conn variable
$query = "SELECT id, name FROM brands";
$result = mysqli_query($conn, $query); // Use $conn instead of $connection

$brands = array();
while ($row = mysqli_fetch_assoc($result)) {
    $brands[] = $row;
}
?>

<?php include("NavBar.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .filter-btn {
            margin-right: 10px;
        }
        .product-card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div id="filter-buttons">
        <button class="filter-btn" onclick="filterByBrand(null)">All</button>
        <?php foreach ($brands as $brand): ?>
            <button class="filter-btn" onclick="filterByBrand(<?php echo $brand['id']; ?>)"><?php echo $brand['name']; ?></button>
        <?php endforeach; ?>
    </div>

    <!-- Container to display products -->
    <div class="container mt-4">
        <div class="row" id="products-container">
            <!-- Products will be displayed here -->
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.onload = function() {
            filterByBrand(null);
        };

        function filterByBrand(brandId) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("products-container").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "fetch_products.php?brandId=" + brandId, true);
            xhttp.send();
        }
    </script>
</body>
</html>
