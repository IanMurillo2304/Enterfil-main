<?php
session_start();
include("connect.php"); // Include database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Homepage</title>
</head>
<body>
    <div class="container" id="dashboard">
        <h1 class="form-title">Raw Materials Module Main Dashboard</h1>

        <!-- Add Filter Button -->
        <form method="post" action="addInterface.php">
            <input type="submit" class="btn" value="Add Filter" name="addFilterButton">
        </form>

        <!-- Remove Filter Button -->
        <form method="post" action="removeItem.php">
            <input type="submit" class="btn" value="Remove Filter" name="removeFilterButton">
        </form>

        <!-- Display Items Table -->
        <h2>Items Table</h2>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Filter Code</th>
                    <th>Filter Name</th>
                    <th>Materials</th>
                    <th>Quantity</th>
                    <th>Max Stock</th>
                    <th>Low Stock Signal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch data from filters table
                $sql = "SELECT * FROM filters"; // Updated table name
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        // Determine the stock status
                        $quantityClass = 'quantity-high'; // Default to high
                        if ($row['Quantity'] <= $row['LowStockSignal']) {
                            $quantityClass = 'quantity-low';
                        } elseif ($row['Quantity'] < $row['MaxStock'] / 2) {
                            $quantityClass = 'quantity-medium';
                        }

                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['filter_code'] . "</td>";
                        echo "<td>" . $row['filter_name'] . "</td>";
                        echo "<td>" . $row['materials'] . "</td>";
                        echo "<td>" . $row['quantity'] . "</td>";
                        echo "<td>" . $row['max_stock'] . "</td>";
                        echo "<td>" . $row['low_stock'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No filters found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
