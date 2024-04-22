<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Product Display</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<style>
    /* Custom CSS to fix image size */
    .product-card {
        height: 100%; /* Set a fixed height for the card */
    }
    .product-card img {
        width: 100%; /* Set width to 100% to fill the container */
        height: auto; /* Automatically adjust height while maintaining aspect ratio */
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
