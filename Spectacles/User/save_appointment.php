<?php
include("connection.php");

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $appointment_date = $_POST['appointment_date'];
  $appointment_time = $_POST['appointment_time'];

  // Check for appointment time clash
  $check_availability_query = "SELECT * FROM appointments WHERE appointment_date = ? AND appointment_time = ?";
  $check_availability_stmt = $conn->prepare($check_availability_query);
  $check_availability_stmt->bind_param("ss", $appointment_date, $appointment_time);
  $check_availability_stmt->execute();
  $check_availability_result = $check_availability_stmt->get_result();

  if ($check_availability_result->num_rows > 0) {
    $_SESSION['error_message'] = "This time slot is already booked. Please choose another time.";
  } else {
    // Save appointment data if no clash found
    $save_appointment_query = "INSERT INTO appointments (user_id, appointment_date, is_confirmed, created_at) VALUES (?, ?, 0, NOW())";
    $save_appointment_stmt = $conn->prepare($save_appointment_query);
    $save_appointment_stmt->bind_param("is", $_SESSION['user_id'], $appointment_date);
    if ($save_appointment_stmt->execute()) {
      $appointment_id = $conn->insert_id;

      // ... (rest of your code to handle saving appointment products)

      // Success message (you can redirect to a confirmation page here)
      echo "<script>alert('Appointment created successfully! You will be contacted for confirmation.');</script>";
    } else {
      echo "Error saving appointment: " . $conn->error;
    }
  }

  $check_availability_stmt->close();
}