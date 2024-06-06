<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Stock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Add New Stock</h1>
        <form action="save_stock.php" method="POST">
            <div class="mb-3">
                <label for="product" class="form-label">Product</label>
                <input type="text" id="product" name="product" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price (RM)</label>
                <input type="number" step="0.01" id="price" name="price" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" id="quantity" name="quantity" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Save Changes</button>
            <a href="stkctrl.php" class="btn btn-secondary">Back</a>
        </form>
    </div>
</body>
</html>
