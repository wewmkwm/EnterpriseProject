<?php
require __DIR__ . '/vendor/autoload.php'; // Include Twilio PHP SDK

use Twilio\Rest\Client;

// Twilio credentials
$account_sid = 'AC33c7d3bad50e789cf2ded42907e3631c';
$auth_token = '5a14045c9ef32bfe9e3deceb4a8a40b7';

// Initialize Twilio client
$client = new Client($account_sid, $auth_token);

// Get phone number and country code from POST request
$phone_number = $_POST['phone_number'];
$country_code = $_POST['country_code'];

// Generate OTP
$otp = rand(1000, 9999); // Generate a 4-digit OTP

// Send OTP via SMS
try {
    $message = $client->messages->create(
        $country_code . $phone_number,
        [
            'from' => '+12178582676',
            'body' => 'Your OTP is: ' . $otp
        ]
    );
    echo json_encode(['success' => true, 'message' => 'OTP sent successfully']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error sending OTP: ' . $e->getMessage()]);
}
?>
