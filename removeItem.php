<?php
session_start();
include("connect.php"); // Include database connection

$message = ""; // Initialize $message to avoid undefined variable error

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['FilterCode'])) {
    // Sanitize user input
    $FilterCode = $conn->real_escape_string($_POST['FilterCode']); // Use 'FilterCode' as per your column name

    // Check if the filter exists in the database
    $checkQuery = "SELECT * FROM filters WHERE FilterCode = '$FilterCode'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        // If the filter exists, attempt to delete it
        $sql = "DELETE FROM filters WHERE FilterCode = '$FilterCode'";
        if ($conn->query($sql) === TRUE) {
            header("Location: homepage.php"); // Redirect to dashboard on success
            exit();
        } else {
            // Error during deletion
            $message = "Error deleting filter: " . $conn->error;
        }
    } else {
        // If no matching filter found, set error message
        $message = "Filter Code not found in the database. Please try again.";
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
    <title>Remove Filter</title>
</head>
<body>
    <div class="container" id="removeItem">
        <h1 class="form-title">Remove Filter</h1>
        
        <!-- Display success/error message -->
        <?php if (!empty($message)) { ?>
            <div class="error-message">
                <p><?php echo $message; ?></p>
                <button onclick="window.location.href='removeitem.php'" class="btn">Go Back to Remove Filter</button>
            </div>
        <?php } ?>

        <form method="post" action="">
            <input type="text" name="FilterCode" id="FilterCode" placeholder="Filter Code" required>
            <label for="FilterCode">Filter Code</label>
            <input type="submit" class="btn" value="Delete Filter">
        </form>

        <!-- Go back to dashboard -->
        <form method="post" action="homepage.php">
            <input type="submit" class="btn" value="Back to Dashboard">
        </form>
    </div>
</body>
</html>
