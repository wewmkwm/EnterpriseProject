<?php
session_start();
require 'connection.php'; // Assuming you have a separate file for database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = $_POST['otp'];
    $new_password = $_POST['new_password'];

    // Verify OTP
    if ($entered_otp == $_SESSION['otp']) {
        // Update password in the database
        $username = $_SESSION['username'];
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
        $stmt->bind_param("ss", $new_password, $username);
        if ($stmt->execute()) {
            // Password updated successfully
            unset($_SESSION['otp']);
            unset($_SESSION['username']);
            header("Location: index.php?message=Password updated successfully");
            exit();
        } else {
            // Failed to update password
            header("Location: forgetpassword.php?error=Failed to update password");
            exit();
        }
    } else {
        // Invalid OTP
        header("Location: forgetpassword.php?error=Invalid OTP");
        exit();
    }
}
?>
