<?php
session_start();
include("connect.php"); // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['filter_code'])) {
    // Sanitize user input
    $filter_code = $conn->real_escape_string($_POST['filter_code']);

    // SQL query to delete item
    $sql = "DELETE FROM items WHERE filter_code = '$filter_code'";

    if ($conn->query($sql) === TRUE) {
        $message = "Item with filter code $filter_code was successfully deleted.";
    } else {
        $message = "Error deleting item: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Remove Item</title>
</head>
<body>
    <div class="container">
        <h1 class="form-title">Remove Item</h1>
        
        <!-- Display success/error message -->
        <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
        
        <form method="post" action="">
            <label for="filter_code">Enter Filter Code:</label>
            <input type="text" id="filter_code" name="filter_code" required>
            <button type="submit" class="btn">Delete Item</button>
        </form>

        <!-- Go back to dashboard -->
        <form method="post" action="homepage.php">
            <input type="submit" class="btn" value="Back to Dashboard">
        </form>
    </div>
</body>
</html>
