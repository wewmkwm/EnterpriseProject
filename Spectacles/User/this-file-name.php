<?php
require_once 'vendor/autoload.php'; // Update the path to your autoload.php

use Twilio\Rest\Client;

// Your Twilio credentials
$sid = 'AC33c7d3bad50e789cf2ded42907e3631c';
$token = '5a14045c9ef32bfe9e3deceb4a8a40b7';
$twilioNumber = '+12178582676';

// Function to generate a random OTP
function generateOTP() {
    return mt_rand(1000, 9999); // Change as per your OTP requirements
}

// Check if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the phone number from the form
    $phoneNumber = $_POST['phone'];

    // Generate OTP
    $otp = generateOTP();

    // Initialize Twilio client
    $twilio = new Client($sid, $token);

    try {
        // Send OTP via SMS
        $message = $twilio->messages
                          ->create($phoneNumber, // To
                                   ['from' => $twilioNumber, 'body' => "Your OTP is: $otp"]
                          );
        // Save OTP to the database or session for verification
        // For simplicity, I'm just echoing the OTP here
        echo "OTP sent successfully. Check your phone for the OTP: $otp";
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
    exit; // Terminate further processing
}
?>
