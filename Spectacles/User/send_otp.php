<?php
session_start();
require_once 'vendor/autoload.php'; // Update the path to your autoload.php
require 'connection.php'; // Ensure you have a database connection setup here

use Twilio\Rest\Client;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];

    // Fetch user's mobile number from the database
    $stmt = $conn->prepare("SELECT phone_number FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $mobile = $row['phone_number'];

        // Generate OTP
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['username'] = $username;

        // Twilio credentials
        $sid = "AC33c7d3bad50e789cf2ded42907e3631c";
        $token = "5a14045c9ef32bfe9e3deceb4a8a40b7";
        $twilio = new Client($sid, $token);

        // Your Twilio phone number
        $from = "+12178582676"; 

        try {
            // Send OTP to user's mobile phone
            $message = $twilio->messages->create(
                $mobile,
                [
                    "from" => $from,
                    "body" => "Your OTP code is $otp"
                ]
            );
            
            // Redirect to OTP form
            header("Location: forgetpassword.php?step=otp");
            exit();
        } catch (Exception $e) {
            // Handle error
            header("Location: forgetpassword.php?error=Failed to send OTP");
            exit();
        }
    } else {
        // Username does not exist
        header("Location: forgetpassword.php?error=Username does not exist");
        exit();
    }
}
?>

<?php/*
require_once 'vendor/autoload.php'; // Update the path to your autoload.php

use Twilio\Rest\Client;

$sid = "AC33c7d3bad50e789cf2ded42907e3631c";
$token = "5a14045c9ef32bfe9e3deceb4a8a40b7"; // Replace "your_auth_token" with your actual Twilio Auth Token
$twilio = new Client($sid, $token);

$to = "+60164941225"; // Recipient's phone number
$from = "+12178582676"; // Your Twilio phone number

try {
    $message = $twilio->messages->create(
        $to,
        [
            "from" => $from,
            "body" => "DAMN CIBAI SUCCESS LIAO"
        ]
    );
    
    echo "Message sent successfully. SID: " . $message->sid;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}*/
?>

<?php/*
session_start();
require __DIR__ . '/vendor/autoload.php'; // Correct path to autoload
require 'connection.php'; // Ensure you have a database connection setup here

use Twilio\Rest\Client;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];

    // Fetch user's mobile number from the database
    $stmt = $conn->prepare("SELECT phone_number FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $mobile = $row['phone_number'];

        // Generate OTP
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['username'] = $username;

        // Twilio credentials
        $sid = 'AC33c7d3bad50e789cf2ded42907e3631c';
        $token = '5a14045c9ef32bfe9e3deceb4a8a40b7';
        $twilio_number = '+12178582676';

        // Initialize Twilio client
        $client = new Client($sid, $token);

        // Send OTP to user's mobile phone
        try {
            $message = $client->messages->create(
                $mobile, // Text this number
                [
                    'from' => $twilio_number, // From a valid Twilio number
                    'body' => "Your OTP code is $otp"
                ]
            );
            
            // Redirect to OTP form
            header("Location: forgetpassword.php?step=otp");
            exit();
        } catch (Exception $e) {
            // Handle error
            header("Location: forgetpassword.php?error=Failed to send OTP");
            exit();
        }
    } else {
        // Username does not exist
        header("Location: forgetpassword.php?error=Username does not exist");
        exit();
    }
}*/
?>
