<?php
session_start();
include("NavBar.php");


?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Home Page</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        /* Custom styles for the slideshow container */
        .slideshow-container {
            max-width: 1920px; /* Set the maximum width of the slideshow container */
            position: relative;
            margin: auto;
            height: auto;
        }
        .slideshow-container img {
            width: 100%;
            height: 500px;
        }
        /* Next & previous buttons */
        .prev, .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            margin-top: -22px;
            padding: 16px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            background-color: transparent; /* Remove background color */
        }
        /* Position the "next button" to the right */
        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }
        /* On hover, add a black background color with a little bit see-through */
        .prev:hover, .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }
        /* Caption text */
        .text {
            color: #f2f2f2;
            font-size: 15px;
            padding: 8px 12px;
            position: absolute;
            bottom: 8px;
            width: 100%;
            text-align: center;
        }
        /* Number text (1/3 etc) */
        .numbertext {
            color: #f2f2f2;
            font-size: 12px;
            padding: 8px 12px;
            position: absolute;
            top: 0;
        }
        /* The dots/bullets/indicators */
        .dot {
            cursor: pointer;
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease;
        }
        .active, .dot:hover {
            background-color: #717171;
        }
        
        body::-webkit-scrollbar {
            display: none;
        }
        .container, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
            max-width: 1320px;
            padding: 0px;
        }
        .navbar-light .navbar-nav .nav-link.active, .navbar-light .navbar-nav .show>.nav-link {
            color: rgba(0,0,0,.9);
            background-color: ghostwhite;
        }
        .row>* {
            flex-shrink: 0;
            width: 30%;
            max-width: 100%;
            margin-top: var(--bs-gutter-y);
            margin-left: auto;
            margin-right: auto;    
            padding: 0px;
        }
        .container, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
            max-width: 1320px;
            padding: 0px;
            text-align-last: center;
        }
        .title-type {
            padding-bottom: 50px;
        }

        /* Custom styles for the cards */
        .card {
            border: none;
            transition: all 500ms cubic-bezier(0.19, 1, 0.22, 1);
            overflow: hidden;
            border-radius: 20px;
            min-height: 450px; /* Default height for larger screens */
            box-shadow: 0 0 12px 0 rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            /* Adjust height for medium screens */
            .card {
                min-height: 350px;
            }
        }

        @media (max-width: 420px) {
            /* Adjust height for small screens */
            .card {
                min-height: 300px;
            }
        }

        .card-has-bg {
            transition: all 500ms cubic-bezier(0.19, 1, 0.22, 1);
            background-size: 120%;
            background-repeat: no-repeat;
            background-position: center center;
        }

        .card-img-overlay {
            opacity: 50%;
        }

        .card:hover {
            transform: scale(0.98);
            box-shadow: 0 0 5px -2px rgba(0, 0, 0, 0.3);
            background-size: 130%;
            transition: all 500ms cubic-bezier(0.19, 1, 0.22, 1);
        }

        .card:hover .card-body {
            margin-top: 30px;
            transition: all 800ms cubic-bezier(0.19, 1, 0.22, 1);
        }

        .card:hover .card-img {
            filter: blur(5px);
        }

        .card-footer {
            background: none;
            border-top: none;
        }

        .card-title {
            font-weight: 800;
        }

        .card-meta {
            color: rgba(0, 0, 0, 0.3);
            text-transform: uppercase;
            font-weight: 500;
            letter-spacing: 2px;
        }

        .card-body {
            transition: all 500ms cubic-bezier(0.19, 1, 0.22, 1);
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Big container -->
        <div class="slideshow-container">
            <!-- Slideshow -->
            <div class="mySlides">
                <img src="Picture/Login_Background.jpg" style="width:100%">
                <div class="text"></div>
            </div>
            <div class="mySlides">
                <img src="Picture/Nav-Sunglasses_2.jpeg" style="width:100%">
                <div class="text"></div>
            </div>
            <div class="mySlides">
                <img src="Picture/Nav-KidsFrame.jpg" style="width:100%">
                <div class="text"></div>
            </div>
            <!-- Next and previous buttons -->
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>
        <!-- The dots/circles -->
        <div style="text-align:center">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
        </div>
    </div>
    <!-- Bootstrap 5 JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+z8L3Z5Tz9KPHot+5Zbs4E3cFbEL+lFZoXYjDQi" crossorigin="anonymous"></script>
    <!-- Slideshow JavaScript -->
    <script>
        var slideIndex = 0;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("dot");
        var timeout;

        // Initially hide all slides
        for (var i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }

        // Show the first slide
        slides[slideIndex].style.display = "block";
        dots[slideIndex].className += " active";

        function showSlides() {
            // Hide the current slide
            slides[slideIndex].style.display = "none";
            dots[slideIndex].className = dots[slideIndex].className.replace(" active", "");

            // Move to the next slide
            slideIndex++;
            if (slideIndex >= slides.length) {
                slideIndex = 0; // Start over from the first slide
            }

            // Show the next slide
            slides[slideIndex].style.display = "block";
            dots[slideIndex].className += " active";

            // Call the function again after a pause (3000 milliseconds = 3 seconds)
            timeout = setTimeout(showSlides, 3000);
        }

        // Start the slideshow
        showSlides();

        // Function to move to the previous slide
        function plusSlides(n) {
            // Hide the current slide
            slides[slideIndex].style.display = "none";
            dots[slideIndex].className = dots[slideIndex].className.replace(" active", "");

            // Move to the previous or next slide
            slideIndex += n;
            if (slideIndex >= slides.length) {
                slideIndex = 0; // Start over from the first slide
            } else if (slideIndex < 0) {
                slideIndex = slides.length - 1; // Go to the last slide
            }

            // Show the new slide
            slides[slideIndex].style.display = "block";
            dots[slideIndex].className += " active";

            // Reset the timer to start counting from the new slide
            clearTimeout(timeout);
            timeout = setTimeout(showSlides, 3000);
        }

        // Function to move to a specific slide
        function currentSlide(n) {
            // Hide the current slide
            slides[slideIndex].style.display = "none";
            dots[slideIndex].className = dots[slideIndex].className.replace(" active", "");

            // Move to the specified slide
            slideIndex = n;
            if (slideIndex >= slides.length) {
                slideIndex = 0; // Start over from the first slide
            } else if (slideIndex < 0) {
                slideIndex = slides.length - 1; // Go to the last slide
            }

            // Show the new slide
            slides[slideIndex].style.display = "block";
            dots[slideIndex].className += " active";

            // Reset the timer to start counting from the new slide
            clearTimeout(timeout);
            timeout = setTimeout(showSlides, 3000);
        }
    </script>
    <!-- New container for cards -->
    <div class="container my-5">
        <div class="row title-type">
            <h2>TYPES OF SPECTACLES</h2>
        </div>
        <div class="row">
            <!-- First Card -->
            <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                <div class="card text-dark card-has-bg click-col" style="background-image:url('Picture/home_card_1.jpg');">
                    <img class="card-img d-none" src="Picture/home_card_1.jpg" alt="Creative Manner Design Lorem Ipsum Sit Amet Consectetur dipisi?">
                    <div class="card-img-overlay d-flex flex-column">
                        <div class="card-body">
                            
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                <div class="card text-dark card-has-bg click-col" style="background-image:url('Picture/home_card_2.jpg');">
                    <img class="card-img d-none" src="Picture/home_card_2.jpg" alt="Creative Manner Design Lorem Ipsum Sit Amet Consectetur dipisi?">
                    <div class="card-img-overlay d-flex flex-column">
                        <div class="card-body">
                            
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                <div class="card text-dark card-has-bg click-col" style="background-image:url('Picture/home_card_3.jpg');">
                    <img class="card-img d-none" src="Picture/home_card_3.jpg" alt="Creative Manner Design Lorem Ipsum Sit Amet Consectetur dipisi?">
                    <div class="card-img-overlay d-flex flex-column">
                        <div class="card-body">
                            
                        </div>
                        
                    </div>
                </div>
            </div>
            <!--Can add next card here-->
        </div>
    </div>

    
    <!--Brands-->
    <div class="container my-5">
        <div class="row title-type">
            <h2>Brands</h2>
        </div>
        <div class="row">
            <div class="col">1 </div>
            <div class="col">1 </div>
            <div class="col">1 </div>
        </div>
        <div class="row">
            <div class="col">1 </div>
            <div class="col">1 </div>
            <div class="col"> 1</div>
        </div>
        <div class="row">
            <div class="col">1 </div>
            <div class="col">1 </div>
            <div class="col">1 </div>
        </div>
        <div class="row">
            <div class="col">1 </div>
            <div class="col"> 1</div>
            <div class="col"> 1</div>
        </div>
        <div class="row">
            <div class="col">1 </div>
            <div class="col">1 </div>

        </div>
    </div>
	<?php
	
if (isset($_SESSION['user_id'])) {
        // Display the user_id session variable
        echo $_SESSION['user_id'];
    } else {
        // Display a message if user_id session variable is not set
        echo "User ID not set";
    }


// After setting session variables
echo "User ID: " . $_SESSION['user_id'];
echo "Username: " . $_SESSION['username'];

	?>
</body>
</html>
