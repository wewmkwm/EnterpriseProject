<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combined Navigation Bar and Appointment Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .container, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
            max-width: 100%!important;
        }
        .navbar-expand-lg .navbar-nav .dropdown-menu {
            position: absolute;
            width: 900%;
            padding: 0;
            left: 50%;
            transform: translateX(-50%);
        }
        .navbar-expand-lg .navbar-nav {
            flex-direction: row;
            justify-content: center; /* Center the navbar items */
        }
        .nav-item {
            margin-right: 30px; /* Adjust as needed */
        }
        .dropdown-menu {
            min-width: 300px; /* Adjust as needed */
        }
        .category-column,
        .picture-column {
            padding: 10px; /* Adjust padding as needed */
        }
        .category-item {
            cursor: pointer;
        }
        .picture {
            max-width: 100%; /* Adjust to fill the column width */
            height: auto; /* Maintain aspect ratio */
            display: none;
        }
        .active {
            display: block;
        }
        .row {
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 0;
            display: flex;
            flex-wrap: inherit!important;
            margin-top: calc(var(--bs-gutter-y) * -1);
            margin-right: calc(var(--bs-gutter-x) * -.5);
            margin-left: 0px!important;
        }
        .row>* {
            flex-shrink: 0;
            width: 100%;
            max-width: 100%;
            padding-right: calc(var(--bs-gutter-x) * .5);
            padding-left: calc(var(--bs-gutter-x) * .5);
            margin-top: var(--bs-gutter-y);
            padding: 0;
        }
        .picture-column {
            flex: 1; /* Make the right column flexible */
        }
        .picture-column {
            padding: 0px;
        }
        .col-xxl {
            flex: 1 0 0%;
            padding: 0!important;
        }
        .category-item {
            cursor: pointer;
            text-align-last: center;
            font-size: 26px;
            padding-top: 15%;
        }
        .col-sm {
            flex: 1 0 0%;
            height: 420px;
        }
        .cart-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: auto; /* Push to the right */
            padding: 0 15px;
        }
        .cart-icon i {
            font-size: 30px; /* Adjust as needed */
        }
        .navbar-expand-lg .navbar-nav {
            flex-direction: row;
            margin-left: auto;
            margin-right: auto;
        }
        .logo-column {
            display: flex;
            align-items: center;
        }
        .logo-column img {
            width: 100px; /* Adjust as needed */
            height: auto; /* Maintain aspect ratio */
        }
        .cart-icon i {
            font-size: 25px; /* Default font size */
            color: lightcoral;
            transition: font-size 0.3s; /* Smooth transition effect */
        }
        .cart-icon i:hover {
            font-size: 28px; /* Increased font size on hover */
        }
        /* Additional styles for the appointment calendar */
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
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li class="category-item">Category 1</li>
                            <li class="category-item">Category 2</li>
                            <li class="category-item">Category 3</li>
                        </ul>
                    </li>
                </ul>
                <div class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </div>
    </nav>

    <!-- Appointment Calendar -->
    <div class="container mt-">
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
                                <input type="time" class="form-control" id="appointment-time">
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
</body>
</html>
