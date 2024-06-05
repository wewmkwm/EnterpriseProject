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
    // Get the phone number and country code from the form
    $phoneNumber = $_POST['phone'];
    $countryCode = $_POST['countryCode'];

    // Ensure the phone number has the country code
    // Add the country code if it's missing
    if (!preg_match('/^\+/', $phoneNumber)) {
        $phoneNumber = '+' . $countryCode . $phoneNumber;
    }

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
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Phone Test</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"></script>
</head>

<body>
<form id="otpForm" method="POST">
    <input id="phone" type="tel" name="phone">
    <input id="countryCode" type="hidden" name="countryCode">
    <button class="button" id="btn" type="submit">Send OTP</button>
    <span id="error-msg" class="hide"></span>
</form>

<script>
const input = document.querySelector("#phone");
const countryCodeInput = document.querySelector("#countryCode");
const form = document.querySelector("#otpForm");
const errorMsg = document.querySelector("#error-msg");

const errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

// Initialise plugin
const iti = window.intlTelInput(input, {
  initialCountry: "auto", // Automatically detect user's country
});

const reset = () => {
  input.classList.remove("error");
  errorMsg.innerHTML = "";
  errorMsg.classList.add("hide");
};

const showError = (msg) => {
  input.classList.add("error");
  errorMsg.innerHTML = msg;
  errorMsg.classList.remove("hide");
};

// On form submit: validate phone number and send OTP
form.addEventListener('submit', (e) => {
  e.preventDefault(); // Prevent default form submission

  reset();
  if (!input.value.trim()) {
    showError("Phone number is required");
    return;
  } else if (!iti.isValidNumber()) {
    showError("Invalid phone number");
    return;
  }

  // Get selected country code
  const countryCode = iti.getSelectedCountryData().dialCode;

  // Update the hidden input field with the selected country code
  countryCodeInput.value = countryCode;

  // Submit the form
  form.submit();
});

// On keyup / change flag: reset
input.addEventListener('change', reset);
input.addEventListener('keyup', reset);
</script>
</body>
</html>
