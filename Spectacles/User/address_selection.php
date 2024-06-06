<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Address Selection</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
    body {
      font-family: 'Poppins', sans-serif; /* Unique font */
      background-color: #e9f5f5; /* Light teal background */
      color: #333; /* Standard text color */
    }
    .container {
      max-width: 900px;
      margin: 50px auto;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
      background-color: #fff; /* White container background */
    }
    .form-label {
      font-weight: 500;
      margin-bottom: 5px;
      color: #555; /* Slightly darker text color for labels */
    }
    #block-unit-input, #building-input, #address-input {
      height: 45px;
      border-radius: 8px;
      border: 1px solid #ccc;
      padding: 10px 15px;
    }
    #map {
        height: 400px;
        width: 100%;
        margin-bottom: 20px;
    }
    #save-address-btn {
      background-color: #ff6347; /* Vibrant coral color */
      border-color: #ff6347;
      color: #fff;
      padding: 12px 25px;
      border-radius: 8px;
      transition: all 0.2s ease-in-out;
    }
    #save-address-btn:hover {
      background-color: #e5533d; /* Darker coral on hover */
      border-color: #e5533d;
      transform: translateY(-2px); /* Slight lift on hover */
    }
    #save-address {
      font-weight: 500;
      margin-bottom: 15px;
      color: #666; /* Lighter text color for saved address */
    }
    .btn-primary, .btn-outline-primary {
      padding: 12px 25px;
      font-size: 18px;
      border-radius: 5px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }
    .btn-primary {
      background-color: #007bff;
      border: none;
    }
    .btn-primary:hover {
      background-color: #0056b3;
      transform: translateY(-2px);
    }
    .btn-outline-primary {
      border: 2px solid #007bff;
      color: #007bff;
      background: none;
    }
    .btn-outline-primary:hover {
      background-color: #007bff;
      color: #fff;
      transform: translateY(-2px);
    }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Select Your Address</h2>
        <div class="mb-3">
            <label for="block-unit-input" class="form-label">Block/Unit Number</label>
            <input id="block-unit-input" type="text" class="form-control" placeholder="Enter block/unit number">
        </div>
        <div class="mb-3">
            <label for="building-input" class="form-label">Building Name</label>
            <input id="building-input" type="text" class="form-control" placeholder="Enter building name">
        </div>
        <div class="input-group mb-3">
            <input id="address-input" type="text" class="form-control" placeholder="Enter your address">
            <button id="search-address-btn" class="btn btn-outline-secondary" type="button">Search</button>
        </div>
        <div id="map"></div>
        <button id="save-address-btn" class="btn btn-primary mt-3">Add Address</button>
        <div id="save-address" class="mt-3"></div> <!-- Added a div to display the save address -->
        <form id="save-address-form" action="save_address.php" method="post">
            <input type="hidden" id="save-address-input" name="address" value="">
            <button type="submit" class="btn btn-success mt-3">Save Address to Database</button>
        </form>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <!-- Google Maps API -->
    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -34.397, lng: 150.644},
                zoom: 15
            });

            var input = document.getElementById('address-input');
            var autocomplete = new google.maps.places.Autocomplete(input);

            autocomplete.bindTo('bounds', map);

            var infowindow = new google.maps.InfoWindow();
            var marker = new google.maps.Marker({
                map: map,
                anchorPoint: new google.maps.Point(0, -29)
            });

            // Event listener to handle when user clicks on the map
            map.addListener('click', function(event) {
                infowindow.close();
                marker.setVisible(false);
                marker.setPosition(event.latLng);
                marker.setVisible(true);

                // Reverse geocode the clicked location to get the address
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({ location: event.latLng }, function(results, status) {
                    if (status === 'OK') {
                        if (results[0]) {
                            var place = results[0];
                            input.value = place.formatted_address;
                        }
                    } else {
                        window.alert('Geocoder failed due to: ' + status);
                    }
                });
            });

            // Event listener for the Search Address button
            document.getElementById('search-address-btn').addEventListener('click', function() {
                var address = input.value;

                if (address) {
                    var geocoder = new google.maps.Geocoder();
                    geocoder.geocode({ address: address }, function(results, status) {
                        if (status === 'OK') {
                            if (results[0]) {
                                var location = results[0].geometry.location;
                                map.setCenter(location);
                                marker.setPosition(location);
                                marker.setVisible(true);
                            }
                        } else {
                            window.alert('Geocoder failed due to: ' + status);
                        }
                    });
                } else {
                    window.alert('Please enter an address.');
                }
            });

            // Add event listener to the Save Address button
            document.getElementById('save-address-btn').addEventListener('click', function() {
                var blockUnit = document.getElementById('block-unit-input').value.trim();
                var building = document.getElementById('building-input').value.trim();
                var address = input.value.trim();
                
                if (blockUnit || building || address) {
                    var combinedAddress = (blockUnit ? blockUnit + ', ' : '') +
                                          (building ? building + ', ' : '') +
                                          address;
                    // Update the value of the hidden input field with the combined address
                    document.getElementById('save-address-input').value = combinedAddress;
                    // Update the content of the save-address div with the combined address
                    document.getElementById('save-address').innerText = combinedAddress;
                } else {
                    console.log("No address entered.");
                }
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDbwOcep_rhK8dH77TJlPR7VuOZyN3OY7A&libraries=places&callback=initMap" async defer></script>
</body>
</html>
