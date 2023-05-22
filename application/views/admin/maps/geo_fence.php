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
                const myLatlng = {lat: -1.291020, lng: 36.821390};
                var mapOptions = {
                    zoom: 10,
                    mapTypeId: 'roadmap',
                    streetViewControl: false,
                    mapTypeControl: false,
                    center: myLatlng
                };

                map = new google.maps.Map(document.getElementById("map"), mapOptions);

                // Create the initial InfoWindow.
                let infoWindow = new google.maps.InfoWindow({
                    content: "Click the map to get Lat/Lng!",
                    position: myLatlng,
                });

                infoWindow.open(map);

                // Configure the click listener.
                map.addListener("click", (mapsMouseEvent) => {
                    // Close the current InfoWindow.
                    infoWindow.close();

                    // Create a new InfoWindow.
                    infoWindow = new google.maps.InfoWindow({
                        position: mapsMouseEvent.latLng,
                    });
                    infoWindow.setContent(
                            JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
                            );
                    infoWindow.open(map);
                });


            } // Handles click events on a map, and adds a new point to the Polyline.

        </script>
    </head>
    <body>
        <div id='map'></div>
    </body>
</html>