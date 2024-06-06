<?php
include("connection.php");

// Get form data
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$username = $_POST['username'];
$phonenumber = $_POST['phonenumber'];
$email = $_POST['email'];
$password = $_POST['password'];

// Check if the email or phone number already exist in the database
$check_query = "SELECT * FROM users WHERE email = '$email' OR phone_number = '$phonenumber'";
$result = $conn->query($check_query);

if ($result->num_rows > 0) {
    // If email or phone number already exist, display error message
    echo "Error: Email or phone number already exists.";
} else {
    // Check if the username already exists
    $check_username_query = "SELECT * FROM users WHERE username = '$username'";
    $username_result = $conn->query($check_username_query);

    if ($username_result->num_rows > 0) {
        // If username already exists, display error message
        echo "Error: Username already exists.";
    } else {
        // Insert data into the database
        $sql = "INSERT INTO users (user_id, firstname, lastname, username, phone_number, email, password)
        VALUES (NULL, '$firstname', '$lastname', '$username', '$phonenumber', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
