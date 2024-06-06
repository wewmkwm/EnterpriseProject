<?php
// Include your database connection file
include 'connection.php';

// Check if a month and year are provided
if (isset($_GET['month']) && isset($_GET['year'])) {
    $month = $_GET['month'];
    $year = $_GET['year'];

    // Query to fetch sales data for the specified month and year
    $query = "SELECT * FROM sales_transactions WHERE MONTH(date) = $month AND YEAR(date) = $year";
    $result = mysqli_query($conn, $query);

    // Check if there are any sales data for the specified month and year
    if (mysqli_num_rows($result) > 0) {
        // Initialize total sales
        $total_sales = 0;

        // Display table header
        echo "<h2>Sales Report for $month/$year</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Transaction ID</th><th>Product ID</th><th>Quantity</th><th>Price</th><th>Date</th></tr>";

        // Loop through the sales data and calculate total sales
        while ($row = mysqli_fetch_assoc($result)) {
            $transaction_id = $row['transaction_id'];
            $product_id = $row['product_id'];
            $quantity = $row['quantity'];
            $price = $row['price'];
            $date = $row['date'];

            // Calculate total sales
            $total_sales += $quantity * $price;

            // Display sales data in table rows
            echo "<tr>";
            echo "<td>$transaction_id</td>";
            echo "<td>$product_id</td>";
            echo "<td>$quantity</td>";
            echo "<td>$price</td>";
            echo "<td>$date</td>";
            echo "</tr>";
        }

        // Display total sales
        echo "<tr><td colspan='4' align='right'><b>Total Sales:</b></td><td>$total_sales</td></tr>";
        echo "</table>";
    } else {
        echo "<h2>No sales data found for $month/$year</h2>";
    }
} else {
    echo "<h2>Please provide both month and year parameters</h2>";
}
?>
