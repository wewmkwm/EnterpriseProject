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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Pacifico&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f0f8ff;
      color: #333;
    }
    .product-card {
      margin-bottom: 20px;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 10px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      background-color: #fff;
      text-align: center;
    }
    .product-card:hover {
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
      transform: translateY(-5px);
    }
    .product-card img {
      max-width: 100%;
      height: auto;
      border-radius: 10px;
    }
    .brand-button {
      margin: 5px;
      background: linear-gradient(to right, #ff5f6d, #ffc371);
      color: #fff;
      border: none;
      border-radius: 30px;
      padding: 10px 25px;
      transition: background 0.3s ease, transform 0.3s ease;
      font-weight: 500;
      font-family: 'Pacifico', cursive;
    }
    .brand-button:hover {
      background: linear-gradient(to right, #d53369, #daae51);
      transform: scale(1.1);
    }
    .brand-button.active {
      background: linear-gradient(to right, #11998e, #38ef7d);
      transform: scale(1.1);
    }
    .brand-button:focus {
      outline: none;
    }
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }
    .products-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      transition: all 0.3s ease-in-out;
    }
    .products-container .product-card {
      opacity: 0;
      transform: scale(0.9);
      transition: opacity 0.3s ease, transform 0.3s ease;
    }
    .products-container .product-card.loaded {
      opacity: 1;
      transform: scale(1);
    }
  </style>
</head>
<body>

<div class="container">
    <div class="d-flex justify-content-center mb-4">
        <button class="btn brand-button" onclick="filterByBrand(null)">All</button>
        <?php foreach ($brands as $brand): ?>
            <button class="btn brand-button" onclick="filterByBrand(<?php echo $brand['id']; ?>)"><?php echo $brand['name']; ?></button>
        <?php endforeach; ?>
    </div>

    <!-- Container to display products -->
    <div class="products-container mt-4" id="products-container">
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
                var container = document.getElementById("products-container");
                container.innerHTML = this.responseText;
                
                // Add transition effect to the product cards
                var productCards = container.querySelectorAll('.product-card');
                productCards.forEach(function(card) {
                    card.classList.add('loaded');
                });

                // Update active button style
                var buttons = document.querySelectorAll('.brand-button');
                buttons.forEach(button => {
                    button.classList.remove('active');
                    if (button.getAttribute('onclick') === 'filterByBrand(' + brandId + ')') {
                        button.classList.add('active');
                    }
                });
            }
        };
        xhttp.open("GET", "fetch_products.php?brandId=" + brandId, true);
        xhttp.send();
    }
</script>
</body>
</html>
