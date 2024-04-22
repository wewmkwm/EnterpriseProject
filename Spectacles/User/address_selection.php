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
    <style>
        #map {
            height: 400px;
            width: 100%;
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
