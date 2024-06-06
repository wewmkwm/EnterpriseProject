<?php
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the username and password from the form
    $username = $_POST['username'];
    $password = $_POST['pwd'];

    // Perform database query to check user's credentials
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // User authenticated, retrieve user ID and username from the query result
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];

        // Start the session and store user ID and username
        session_start();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;

        // Redirect to Home.php or perform further actions
        header('Location: Home.php');
        exit;
    } else {
        // Invalid credentials, redirect back to login page with error
        $error = "Invalid username or password";
        header('Location: Login.php?error=' . urlencode($error));
        exit;
    }
}
?>
