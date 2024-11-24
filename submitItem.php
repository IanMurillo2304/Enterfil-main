<?php 

include 'connect.php';

// Enable detailed error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (isset($_POST['submitButton'])) {
    // Collect data from the form
    $FilterCode = $_POST['fCode'];
    $FilterName = $_POST['fName'];
    $Materials = $_POST['materials'];
    $Quantity = $_POST['quantity'];
    $MaxStock = $_POST['maxStock'];
    $LowStockSignal = $_POST['lowStock'];

    try {
        // Check if filter_code already exists in the 'items' table
        $checkCode = "SELECT * FROM items WHERE filter_code = ?";
        $stmt = $conn->prepare($checkCode);
        $stmt->bind_param("s", $FilterCode);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Filter Code Already Exists!";
        } else {
            // Insert the new filter into the 'items' table
            $insertQuery = "INSERT INTO items (filter_code, filter_name, materials, quantity, max_stock, low_stock) 
                            VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("sssiii", $FilterCode, $FilterName, $Materials, $Quantity, $MaxStock, $LowStockSignal);

            if ($stmt->execute()) {
                header("Location: index.php"); // Redirect to index.php upon successful insertion
                exit;
            } else {
                echo "Error: " . $stmt->error; // Display an error message if the query fails
            }
        }
    } catch (mysqli_sql_exception $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
}
?>
