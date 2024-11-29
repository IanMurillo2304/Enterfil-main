<?php
// Include the database connection at the top
include 'connect.php'; // Ensure this file initializes the $conn variable

if (isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);

    // Check if $conn is defined and connected
    if (!$conn) {
        die('Database connection failed: ' . mysqli_connect_error());
    }

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        header("Location: homepage.php");
        exit();
    } else {
        // Show styled error message for incorrect credentials
        echo '
        <div class="error-message" style="display: flex;">
            <p>Incorrect Email or Password!</p>
            <button onclick="window.location.href=\'index.php\'" class="btn">Go Back to Sign In</button>
        </div>';
    }
}
?>
