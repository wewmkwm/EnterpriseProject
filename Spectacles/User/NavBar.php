<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dropdown with Images</title>
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

    </style>
</head>
<body>
	
	<!--Container for slide show-->
    <div class="container-xxl">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <div class="logo-column">
                    <img src="Picture/Retail_Logo.png" alt="Logo">
                </div>
                <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="Home.php">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Products
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <div class="row">
                                    <div class="col-sm category-column">
                                        <li class="category-item"><a class="dropdown-item" href="frame_product.php">Kids Frame</a></li>
                                        <li class="category-item"><a class="dropdown-item" href="frame_product.php">Men / Women Frame</a></li>
                                        <li class="category-item"><a class="dropdown-item" href="frame_product.php">Sunglasses</a></li>
                                    </div>
                                    <div class="col-xxl picture-column">
                                        <img class="picture" src="Picture/Nav-KidsFrame.jpg" alt="Kids Frame">
                                        <img class="picture" src="Picture/Nav-Frame.jpg" alt="Men / Women Frame">
                                        <img class="picture" src="Picture/Nav-Sunglasses_2.jpeg" alt="Sunglasses">
                                    </div>
                                </div>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="history.php">History</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about_us.php">Our Story</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="logout()">Log Out</a>
                        </li>
                    </ul>
                </div>
                <div class="cart-icon">
                    <a class="nav-link" href="view_cart.php">
                        <i class="fas fa-cart-shopping"></i>
                    </a>
                </div>
            </div>
        </nav>
    </div>
	
		<!--Script for slideshow-->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categoryItems = document.querySelectorAll('.category-item');
            const pictures = document.querySelectorAll('.picture');

            categoryItems.forEach((item, index) => {
                item.addEventListener('mouseover', () => {
                    pictures.forEach((picture) => picture.classList.remove('active'));
                    pictures[index].classList.add('active');
                });
            });
        });

        function logout() {
  // Assuming you're using sessions
  fetch('logout.php') // Replace with your logout script URL if different
    .then(response => response.text()) // Process the response (optional)
    .then(() => {
      window.location.href = "index.php"; // Redirect to index.php on logout
    })
    .catch(error => console.error(error)); // Handle errors (optional)
}
    </script>
    
	
</body>
</html>

