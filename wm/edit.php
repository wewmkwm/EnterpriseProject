    <?php
    // edit-stock.php
    include("connection.php");

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM stock WHERE id = $id";
        $result = mysqli_query($conn, $query);
        $stockItem = mysqli_fetch_assoc($result);
    }
    $today = date("Y-m-d");
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $currentTime = date("H:i:s");

    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Stock</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container mt-5">
            <h1>Edit Stock Item</h1>
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $stockItem['id']; ?>">
                <div class="mb-3">
                    <label for="product" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="product" name="product" value="<?php echo $stockItem['product']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="text" class="form-control" id="price" name="price" value="<?php echo $stockItem['price']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo $stockItem['quantity']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary" name="save_changes">Save Changes</button>
                <button type="submit" class="btn btn-danger" name="delete_item" onclick="return confirm('Are you sure you want to delete this item?')">Delete Item</button>
            </form>
        </div>
    </body>
    </html>

    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['save_changes'])) {
            // Update stock item
            $id = $_POST['id'];
            $product = $_POST['product'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
            $oriproduct = $stockItem['product'];
            $oriprice = $stockItem['price'];
            $oriquantity = $stockItem['quantity'];
            $query = "UPDATE `stock` SET `product`='$product',`price`='$price',`quantity`='$quantity' WHERE `id`='$id'";
            mysqli_query($conn, $query);
            //history
            $query1 = "INSERT INTO `history`(`id`, `date`, `time`, `stock_id`, `action`, `product`, `price`, `quantity`) 
            VALUES ('','$today','$currentTime','$id','edit','$oriproduct to $product','$oriprice to $price','$oriquantity to $quantity')";
            mysqli_query($conn, $query1);

        } elseif (isset($_POST['delete_item'])) {
            // Delete stock item
            $id = $_POST['id'];
            $query = "DELETE FROM stock WHERE id = $id";
            mysqli_query($conn, $query);
        }

        header("Location: stkctrl.php");
        exit;
    }
    ?>
