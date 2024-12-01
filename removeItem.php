<?php
session_start();
include("connect.php"); // Include database connection

$message = ""; // Initialize the message variable

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['FilterCode'])) {
    // Sanitize user input
    $FilterCode = $conn->real_escape_string($_POST['FilterCode']); // Use 'FilterCode' as per your column name

    // Check if the filter exists in the database
    $check_sql = "SELECT * FROM filters WHERE FilterCode = '$FilterCode'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        // If filter exists, delete it
        $sql = "DELETE FROM filters WHERE FilterCode = '$FilterCode'";
        if ($conn->query($sql) === TRUE) {
            header("Location: homepage.php"); // Redirect to homepage
            exit; // Ensure no further code is executed
        } else {
            $message = "Error deleting filter: " . $conn->error;
        }
    } else {
        // If filter does not exist, show error message
        $message = "Filter not found";
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
            <p class="error-message"><?php echo $message; ?></p>
        <?php } ?>
        
        <!-- Only show the form if there's no error -->
        <?php if ($message !== "Filter not found") { ?>
            <form method="post" action="">
                <input type="text" name="FilterCode" id="FilterCode" placeholder="Filter Code" required>
                <label for="FilterCode">Filter Code</label>
                <input type="submit" class="btn" value="Delete Filter">
            </form>
        <?php } ?>

        <!-- Return to homepage button -->
        <?php if ($message === "Filter not found") { ?>
            <form method="get" action="homepage.php">
                <button type="submit" class="btn">Return to Homepage</button>
            </form>
        <?php } ?>
    </div>
</body>
</html>
