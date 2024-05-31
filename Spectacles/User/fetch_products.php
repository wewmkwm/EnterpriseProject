<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Product Display</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<style>
      /* Custom CSS */
      .container {
        padding-top: 30px; /* Add some top padding for spacing */
      }
      .product-card {
        border-radius: 5px; /* Add rounded corners to cards */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
        transition: transform 0.3s ease-in-out; /* Smooth hover effect */
      }
      .product-card:hover {
        transform: translateY(-3px); /* Slight card lift on hover */
      }
      .product-card-img {
        /* Maintain existing styles from previous code */
      }
      .card-body {
        padding: 20px; /* Adjust card body padding for better spacing */
      }
      .card-title {
        margin-bottom: 10px; /* Add some space below the product name */
        font-weight: bold; /* Make product name stand out */
      }
      .card-text {
        color: #333; /* Adjust text color for better readability */
      }
      .btn-primary {
        background-color: #007bff; /* Adjust button color (optional) */
        border-color: #007bff; /* Adjust button border color (optional) */
      }
      .btn-primary:hover {
        background-color: #0062cc; /* Adjust button hover color (optional) */
        border-color: #0062cc; /* Adjust button hover border color (optional) */
      }
</style>
</head>

<body>
<div class="container">
    <div class="row">
        <?php
        // Include your database connection file
        include("connection.php");
		

        // Fetch products related to the selected brand
        if (isset($_GET['brandId'])) {
            $brandId = $_GET['brandId'];
            if ($brandId === 'null') {
                // If All button is clicked, fetch all products
                $query = "SELECT * FROM models";
            } else {
                // Otherwise, fetch products of the selected brand
                $query = "SELECT * FROM models WHERE id = $brandId";
            }

            $result = mysqli_query($conn, $query);

            // Display products as Bootstrap cards
            while ($row = mysqli_fetch_assoc($result)) {
                // Fetch image for the current product from the images table
                $imageQuery = "SELECT * FROM images WHERE model_id = " . $row['id'];
                $imageResult = mysqli_query($conn, $imageQuery);
                $imageRow = mysqli_fetch_assoc($imageResult);

                echo '<div class="col-md-4">';
                echo '<div class="card product-card">';
                // Check if an image is found for the product
				echo '<div class="card product-card-img">';
                if ($imageRow && $imageRow['image_data']) {
                    // Display the image directly from the database using base64 encoding
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($imageRow['image_data']) . '" class="card-img-top" alt="Product Image">';
                } else {
                    // If no image found or image_data is empty, display a placeholder image or handle accordingly
                    echo '<img src="path_to_placeholder_image/placeholder.jpg" class="card-img-top" alt="Product Image">';
                }
				echo '</div>';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $row['name'] . '</h5>';
                echo '<p class="card-text">Price: ' . $row['price'] . '</p>';
                echo '<p class="card-text">Quantity: ' . $row['quantity'] . '</p>';
                echo '<a href="add_to_cart.php?product_id=' . $row['id'] . '" class="btn btn-primary">Add to Cart</a>';
                // You can display more details here if needed
                echo '</div>'; // Close card-body
                echo '</div>'; // Close card
                echo '</div>'; // Close col-md-4
            }
        }
        ?>
    </div>
</div>
</body>
</html>
