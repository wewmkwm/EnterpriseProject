<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Stock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1>Add Stock</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
                <label for="brand_id" class="form-label">Brand</label>
                <select id="brand_id" name="brand_id" class="form-control">
                    <?php
                    // Fetch brands from the database
                    include 'connection.php';
                    $result = $conn->query("SELECT * FROM brands");

                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <input type="checkbox" id="new_brand_checkbox" name="new_brand_checkbox">
                <label for="new_brand_checkbox">Add New Brand</label>
            </div>
            <div class="mb-3" id="new_brand_fields" style="display: none;">
                <label for="new_brand_name" class="form-label">New Brand Name</label>
                <input type="text" id="new_brand_name" name="new_brand_name" class="form-control">
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" id="price" name="price" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" id="quantity" name="quantity" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <input type="text" id="category" name="category" class="form-control" required>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary" name="submit">Add Stock</button>
                <a href="stock_control.php" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>

    <?php
    include 'connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        // Process form submission
        $brand_id = $_POST['brand_id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $category = $_POST['category'];

        // Check if admin wants to add a new brand
        if (isset($_POST['new_brand_checkbox']) && !empty($_POST['new_brand_name'])) {
            $new_brand_name = $_POST['new_brand_name'];

            // Insert new brand into brands table
            $insert_brand_sql = "INSERT INTO brands (name) VALUES ('$new_brand_name')";
            if ($conn->query($insert_brand_sql) === TRUE) {
                // Get the newly inserted brand's id
                $brand_id = $conn->insert_id;
            } else {
                echo "Error adding new brand: " . $conn->error;
            }
        }

        // Insert stock item into models table
        $insert_stock_sql = "INSERT INTO models (brand_id, name, price, quantity, category) 
                             VALUES ('$brand_id', '$name', '$price', '$quantity', '$category')";

        if ($conn->query($insert_stock_sql) === TRUE) {
            // Redirect back to stock_control.php
            header("Location: stock_control.php");
            exit();
        } else {
            echo "<div class='container mt-3 alert alert-danger' role='alert'>Error adding stock: " . $conn->error . "</div>";
        }
    }

    $conn->close();
    ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const newBrandCheckbox = document.getElementById('new_brand_checkbox');
            const newBrandFields = document.getElementById('new_brand_fields');

            newBrandCheckbox.addEventListener('change', function() {
                if (newBrandCheckbox.checked) {
                    newBrandFields.style.display = 'block';
                } else {
                    newBrandFields.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
