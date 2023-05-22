<!DOCTYPE html>
<html> 
    <head>
        <title><?= PROJECT_NAME; ?> | Maps</title>
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
        <script src="<?= base_url() ?>web_assets/js/jquery.min.js"></script>
        <script
            src="https://maps.googleapis.com/maps/api/js?key=<?= $google_map_api_key ?>&callback=initMap&libraries=places,drawing&v=weekly"
            defer
        ></script>
        <style type="text/css">
            /* Always set the map height explicitly to define the size of the div
             * element that contains the map. */
            #map {
                height: 90%;
            }

            /* Optional: Makes the sample page fill the window. */
            html,
            body {
                height: 100%;
                margin: 0;
                padding: 0;
            }
        </style> 
        <script>
            "use strict";
            let map;
            function initMap() {
                const myLatlng = {lat: <?= $latitude ?>, lng: <?= $longitude ?>};
                var mapOptions = {
                    zoom: 10,
                    mapTypeId: 'roadmap',
                    streetViewControl: false,
                    mapTypeControl: false,
                    center: myLatlng
                };

                map = new google.maps.Map(document.getElementById("map"), mapOptions);

                const contentString =
                        '<div id="content">' +
                        '<h2 id="firstHeading" class="firstHeading"> <?= $location_name ?> </h2>' +
                        '<div id="bodyContent">' +
                        "<p><b>Address: </b> <?= $address ?> </p>" +
                        "</div>";

                const infowindow = new google.maps.InfoWindow({
                    content: contentString,
                });

                const marker = new google.maps.Marker({
                    position: myLatlng,
                    map,
                    title: "Lat/Lng",
                });

                marker.addListener("click", () => {
                    infowindow.open({
                        anchor: marker,
                        map,
                        shouldFocus: false,
                    });
                });

            } // Handles click events on a map, and adds a new point to the Polyline.

        </script>
    </head>
    <body>
        <div id='map'></div>
    </body>
</html>