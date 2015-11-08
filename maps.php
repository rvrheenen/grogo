<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <style type="text/css">
      html, body { height: 100%; margin: 0; padding: 0; }
      #map { height: 50%; width: 50%; margin: 50px; border: #000 1px solid; }
      #button_holder { height: 50%; width: 50%; margin: auto; }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <div id="button_holder">
      <button id="button_lidl" onclick="addMarkers('lidl')">Vind Lidl's</button>
      <button id="button_ah" onclick="addMarkers('albert heijn')">Vind Albert Heijns</button>
      <button id="button_aldi" onclick="addMarkers('aldi')">Vind Aldi's</button>
    </div>
    <script type="text/javascript">
var myLatLng = {lat: 52.342965, lng: 4.829200};

function addMarkers(searchword) {
var service = new google.maps.places.PlacesService(map);
  service.textSearch({
    location: myLatLng,
    radius: 500,
    query: [searchword]
  }, callback);
 }
var map;
function initMap() {
  map = new google.maps.Map(document.getElementById('map'), {
    center: myLatLng,
    zoom: 13
  });

var marker = new google.maps.Marker({
    map: map,
    position: myLatLng,
    animation:google.maps.Animation.BOUNCE,
    title: 'Current Location'
  });
}

function callback(results, status) {
  if (status === google.maps.places.PlacesServiceStatus.OK) {
    for (var i = 0; i < results.length; i++) {
      createMarker(results[i]);
    }
  }
}

function createMarker(place) {
  var placeLoc = place.geometry.location;
  var marker = new google.maps.Marker({
    map: map,
    position: place.geometry.location,
    animation:google.maps.Animation.DROP
  });
  
}

    </script>
    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMmnSk7Zonbe_ysxxRnomG0Bm09DsmXSg&libraries=places&callback=initMap">
    </script>
  </body>
</html>
