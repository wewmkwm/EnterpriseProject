<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="path_to_bootstrap_css/bootstrap.min.css"> <!-- Include Bootstrap CSS -->
    <style>
        .product-card {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .card-img-container {
            flex: 1; /* Allow the image container to grow and fill space */
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            min-height: 200px; /* Set a minimum height for the image container */
        }
        .card-img-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain; /* Ensure the image is contained within the container without being cropped */
        }
        .product-card .card-body {
            flex-grow: 0;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }
        .row {
            row-gap: 15px; /* Adjust the vertical spacing between the rows */
        }
        .col-md-4 {
            padding-left: 5px;
            padding-right: 5px;
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
                    $query = "SELECT * FROM models WHERE brand_id = $brandId";
                }

                $result = mysqli_query($conn, $query);

                // Display products as Bootstrap cards
                while ($row = mysqli_fetch_assoc($result)) {
                    // Fetch image for the current product from the images table
                    $imageQuery = "SELECT * FROM images WHERE model_id = " . $row['id'];
                    $imageResult = mysqli_query($conn, $imageQuery);
                    $imageRow = mysqli_fetch_assoc($imageResult);
                    ?>
                    <div class="col-md-4 d-flex align-items-stretch">
                        <div class="card product-card">
                            <div class="card-img-container d-flex align-items-center justify-content-center">
                                <?php if ($imageRow && $imageRow['image_data']) { ?>
                                    <!-- Display the image directly from the database using base64 encoding -->
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($imageRow['image_data']); ?>" class="card-img-top" alt="Product Image">
                                <?php } else { ?>
                                    <!-- If no image found or image_data is empty, display a placeholder image -->
                                    <img src="path_to_placeholder_image/placeholder.jpg" class="card-img-top" alt="Product Image">
                                <?php } ?>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-end">
                                <h5 class="card-title"><?php echo $row['name']; ?></h5>
                                <p class="card-text">Price: <?php echo $row['price']; ?></p>
                                <p class="card-text">Quantity: <?php echo $row['quantity']; ?></p>
                                <a href="add_to_cart.php?product_id=<?php echo $row['id']; ?>" class="btn btn-primary">Add to Cart</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>

    <!-- Include Bootstrap JS and dependencies -->
    <script src="path_to_jquery/jquery.min.js"></script>
    <script src="path_to_bootstrap_js/bootstrap.bundle.min.js"></script>
</body>
</html>
