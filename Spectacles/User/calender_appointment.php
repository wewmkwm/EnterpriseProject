<?php
include("connection.php");
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Calendar</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h2>Appointment Calendar</h2>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label for="appointment-date">Select a date:</label>
                                <input type="date" class="form-control" id="appointment-date">
                            </div>
                            <div class="form-group">
                                <label for="appointment-time">Select a time:</label>
                                <select class="form-control" id="appointment-time">
                                    <option value="11:00">11:00 AM</option>
                                    <option value="14:00">2:00 PM</option>
                                    <option value="17:00">5:00 PM</option>
                                </select>
                            </div>
                            <button type="button" class="btn btn-primary btn-block" id="submit-appointment">Book Appointment</button>
                        </form>
                        <div id="confirmation" class="mt-4 d-none">
                            <h4 class="text-success">Appointment Details</h4>
                            <p>Date: <span id="confirm-date"></span></p>
                            <p>Time: <span id="confirm-time"></span></p>
                            <p>Status: <span id="confirm-status">Pending</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set the min attribute for the date input to tomorrow's date
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(today.getDate() + 1);
            const tomorrowDate = tomorrow.toISOString().split('T')[0];
            document.getElementById('appointment-date').setAttribute('min', tomorrowDate);

            // List of public holidays in Malaysia
            const publicHolidays = [
                "2024-01-01", // New Year's Day
                "2024-02-01", // Federal Territory Day
                "2024-02-10", // Chinese New Year
                "2024-02-11", // Chinese New Year (Day 2)
                "2024-05-01", // Labour Day
                "2024-05-17", // Wesak Day
                "2024-06-08", // Agong's Birthday
                "2024-08-31", // National Day
                "2024-09-16", // Malaysia Day
                "2024-10-27", // Deepavali
                "2024-12-25"  // Christmas Day
            ];

            document.getElementById('appointment-date').addEventListener('input', function(event) {
                const selectedDate = event.target.value;
                if (publicHolidays.includes(selectedDate)) {
                    alert("The selected date is a public holiday. Please choose another date.");
                    event.target.value = '';
                }
            });
        });

        document.getElementById('submit-appointment').addEventListener('click', function() {
            const date = document.getElementById('appointment-date').value;
            const time = document.getElementById('appointment-time').value;
            
            if (date && time) {
                document.getElementById('confirm-date').textContent = date;
                document.getElementById('confirm-time').textContent = time;
                document.getElementById('confirm-status').textContent = 'Pending';
                
                document.getElementById('confirmation').classList.remove('d-none');
            } else {
                alert('Please select both a date and a time.');
            }
        });
    </script>
	<?php
              if (isset($_SESSION['error_message'])) {
                echo "<div class='alert alert-danger mt-4'>" . $_SESSION['error_message'] . "</div>";
                unset($_SESSION['error_message']); // Clear error message after displaying
              }
            ?>
</body>
</html>
