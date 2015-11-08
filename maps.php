<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <?php include '_header.php' ?>
  </head>
  <body>
    <div class='container'>
      <div class='row'>
        <div class='col_md_2></div>
        <div class='col_md_8>
          <div class='row'> 
            <div id="map"></div>
          </div>
          <div class='row'>
            <div id="button_holder">
              <a href='#' class="button round" id="button_lidl" onclick="addMarkers('lidl')">Find Lidl's</a>
              <a href='#' class="button round" id="button_ah" onclick="addMarkers('albert heijn')">Find Albert Heijns</a>
              <a href='#' class="button round" id="button_jumbo" onclick="addMarkers('jumbo')">Find Jumbo's</a>
			        <a href='#' class="button round" id="button_dirk" onclick="addMarkers('dirk')">Find Dirk's</a>
			        <a href='#' class="button round" id="button_clear" onclick="clearMarkers()">Clear markers</a>
			        <a href='#' class="button round" id="button_route" onclick="calculateRoute()">Calculate route</a>
            </div>
          </div>
        </div>
        <div class='col_md_2'></div>
      </div>
    </div>
    <script type="text/javascript">
var myLatLng = {lat: 52.342965, lng: 4.829200};
var map;
var markers = [];
var imageYellow = 'images/yellow-dot.png';
var imageRed = 'images/red-dot.png';

function calculateRoute() {
  find_closest_marker();
}

function addMarkers(searchword) {
deleteMarkers();
var service = new google.maps.places.PlacesService(map);
  service.textSearch({
    location: myLatLng,
    radius: 500,
    query: [searchword]
  }, callback);
 }
function initMap() {
  var directionsService = new google.maps.DirectionsService;
  var directionsDisplay = new google.maps.DirectionsRenderer;
  map = new google.maps.Map(document.getElementById('map'), {
    center: myLatLng,
    zoom: 13
  });
  directionsDisplay.setMap(map);
  
  var onChangeHandler = function() {
    calculateAndDisplayRoute(directionsService, directionsDisplay);
  };
  document.getElementById('button_route').addEventListener('click', onChangeHandler);

  var marker = new google.maps.Marker({
      map: map,
      position: myLatLng,
      animation:google.maps.Animation.BOUNCE,
      title: 'Current Location',
	  icon: imageRed
  });
}

function calculateAndDisplayRoute(directionsService, directionsDisplay) {
  directionsService.route({
    origin: myLatLng,
    destination: find_closest_marker(),
    travelMode: google.maps.TravelMode.DRIVING
  }, function(response, status) {
    if (status === google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
    } else {
      window.alert('Directions request failed due to ' + status);
    }
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
    animation:google.maps.Animation.DROP,
	  icon: imageYellow,
  });
  markers.push(marker);
}

// Sets the map on all markers in the array.
function setMapOnAll(map) {
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(map);
  }
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
  setMapOnAll(null);
}

// Shows any markers currently in the array.
function showMarkers() {
  setMapOnAll(map);
}

// Deletes all markers in the array by removing references to them.
function deleteMarkers() {
  clearMarkers();
  markers = [];
}

function rad(x) {return x*Math.PI/180;}
function find_closest_marker() {
    var lat = myLatLng['lat'];
    var lng = myLatLng['lng'];
    var R = 6371; // radius of earth in km
    var distances = [];
    var closest = -1;
    for( i=0;i<markers.length; i++ ) {
        var mlat = markers[i].position.lat();
        var mlng = markers[i].position.lng();
        var dLat  = rad(mlat - lat);
        var dLong = rad(mlng - lng);
        var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(rad(lat)) * Math.cos(rad(lat)) * Math.sin(dLong/2) * Math.sin(dLong/2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        var d = R * c;
        distances[i] = d;
        if ( closest == -1 || d < distances[closest] ) {
            closest = i;
        }
    }
    return(markers[closest].position);
}

    </script>
    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMmnSk7Zonbe_ysxxRnomG0Bm09DsmXSg&libraries=places&callback=initMap">
    </script>
    
    <!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
  </body>
</html>
