    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Stock Control System</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" /><link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <style>

        
        /* Custom styles for the table */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            border-right: 1px solid #ddd; /* Add right border to create vertical lines */
        }

        th {
            background-color: #f2f2f2;
        }

        /* Remove right border from the last column */
        th:last-child, td:last-child {
            border-right: none;
        }

        /* Custom styles for buttons */
        .btn {
            margin-right: 5px;
        }
        </style>
    </head>
    <body>
        <div class="container mt-5">
            <h1>Kids Frame Stock </h1>
            <div class="mb-3">
                <input type="text" id="search-input" class="form-control" placeholder="Search product name">
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="stock-list">
                    <!-- Stock items will be displayed here -->
                    <tr>
                        <td>Product A</td>
                        <td>RM10.00</td>
                        <td>10</td>
                        <td>
                            <button class="btn btn-success" onclick="addStock(this)">Add</button>
                            <button class="btn btn-danger" onclick="deductStock(this)">Deduct</button>
                            <button class="btn btn-primary" onclick="editPrice(this)">Edit Price</button>
                            <button class="btn btn-warning" onclick="editName(this)">Edit Name</button>
                            <button class="btn btn-secondary" onclick="editQuantity(this)">Edit Quantity</button>
                            <button class="btn btn-warning" onclick="deleteItem(this)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button class="btn btn-primary" id="add-item-btn">Add Item</button>
        </div>

        <script>
            function addStock(button) {
                var row = button.closest("tr");
                var quantityCell = row.querySelector("td:nth-child(3)");
                var currentQuantity = parseInt(quantityCell.innerText);
                var newQuantity = currentQuantity + 1;
                quantityCell.innerText = newQuantity;
            }

            function deductStock(button) {
                var row = button.closest("tr");
                var quantityCell = row.querySelector("td:nth-child(3)");
                var currentQuantity = parseInt(quantityCell.innerText);
                var newQuantity = Math.max(0, currentQuantity - 1);
                quantityCell.innerText = newQuantity;
            }

            function editPrice(button) {
                var row = button.closest("tr");
                var priceCell = row.querySelector("td:nth-child(2)");
                var newPrice = prompt("Enter new price:");
                if (newPrice !== null) {
                    newPrice = parseFloat(newPrice);
                    if (!isNaN(newPrice)) {
                        priceCell.innerText = "RM" + newPrice.toFixed(2);
                    } else {
                        alert("Invalid price!");
                    }
                }
            }

            function editName(button) {
                var row = button.closest("tr");
                var productNameCell = row.querySelector("td:nth-child(1)");
                var newName = prompt("Enter new name:");
                if (newName !== null && newName !== "") {
                    productNameCell.innerText = newName;
                }
            }

            function editQuantity(button) {
                var row = button.closest("tr");
                var quantityCell = row.querySelector("td:nth-child(3)");
                var newQuantity = prompt("Enter new quantity:");
                if (newQuantity !== null) {
                    newQuantity = parseInt(newQuantity);
                    if (!isNaN(newQuantity) && newQuantity >= 0) {
                        quantityCell.innerText = newQuantity;
                    } else {
                        alert("Invalid quantity!");
                    }
                }
            }

            function deleteItem(button) {
                var row = button.closest("tr");
                row.remove();
            }

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

            document.getElementById("search-input").addEventListener("keyup", searchProduct);

            document.getElementById("add-item-btn").addEventListener("click", function() {
                var tableBody = document.getElementById("stock-list");
                var newRow = document.createElement("tr");
                newRow.innerHTML = `
                    <td>New Product</td>
                    <td>RM0.00</td>
                    <td>0</td>
                    <td>
                        <button class="btn btn-success" onclick="addStock(this)">Add</button>
                        <button class="btn btn-danger" onclick="deductStock(this)">Deduct</button>
                        <button class="btn btn-primary" onclick="editPrice(this)">Edit Price</button>
                        <button class="btn btn-warning" onclick="editName(this)">Edit Name</button>
                        <button class="btn btn-secondary" onclick="editQuantity(this)">Edit Quantity</button>
                        <button class="btn btn-warning" onclick="deleteItem(this)">Delete</button>
                    </td>
                `;
                tableBody.appendChild(newRow);
            });
        </script>
    </body>
    </html>
