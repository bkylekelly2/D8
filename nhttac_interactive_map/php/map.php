<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
  <meta charset="utf-8">
  <title>NHTTAC Consultant Locations</title>
  <style>

       /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
       #map {
       height: 100%;
       }
    /* Optional: Makes the sample page fill the window. */
    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
    }
  </style>
</head>
<body>

<div id="map"></div>
<script>


  function initMap() {

  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 5,
    center: {lat: 40.342609, lng: -99.801525}
  });

  // Create an array of alphabetical characters used to label the markers.
  var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    var consultants = <?php echo $consultants; ?>


  // Add some markers to the map.
  // Note: The code uses the JavaScript Array.prototype.map() method to
  // create an array of markers based on a given "locations" array.
  // The map() method here has nothing to do with the Google Maps API.

  var markers = consultants.map(function(obj, i) {

    var myLatlng = new google.maps.LatLng(parseFloat(obj.lat),parseFloat(obj.lng));


    var info = obj.title+'\n'+obj.address+'\n'+obj.city+', '+obj.state+' '+obj.zipcode+'\n'+obj.type_of_consultant;

    var newURL = obj.url;

    var icon = '';

    var infowindow='';


    if (obj.type_of_consultant==='Survivor Consultant'){
      icon = 'http://maps.google.com/mapfiles/ms/micons/blue-dot.png';
    }

    if (obj.type_of_consultant==='Expert Consultant'){
      icon = 'http://maps.google.com/mapfiles/ms/micons/red-dot.png';
    }

    if (obj.type_of_consultant==='Survivor Expert Consultant'){
      icon = 'http://maps.google.com/mapfiles/ms/micons/purple-dot.png';
    }

    var contentString = '<div id="content">'+
        '<h2 id="firstHeading" class="firstHeading">'+obj.title+'</h2>'+
        '<div id="bodyContent">'+
        '<div class="bodyType" style="margin-top:-10px;margin-bottom:10px;font-weight:bold;">'+obj.type_of_consultant+'</div>'+
        '<div id="bodyAddress">'+obj.address+'</div>'+
        '<div id="bodyLocation"><span>'+obj.city+',</span> <span>'+obj.state+'</span> <span>'+obj.zipcode+'</span></div>'+
        '<div class="bodyAreas"><h3>Areas of Expertise</h3></div>'+
        '<div class="bodyAreas">'+obj.areas+'</div>'+
        '</div>'+
        '</div>';



    var marker =  new google.maps.Marker({
      position: myLatlng,
      label: labels[i % labels.length],
      title: info,
      icon: icon
    });

    infowindow = new google.maps.InfoWindow({
      content: contentString
    });



    marker.addListener('mouseover', function() {
      infowindow.open(map, marker);
    });




return marker;

  });

  // Add a marker clusterer to manage the markers.
  var markerCluster = new MarkerClusterer(map, markers,
      {imagePath: 'https://cdn.rawgit.com/googlemaps/js-marker-clusterer/gh-pages/images/m'});



  }
</script>
<script src="https://cdn.rawgit.com/googlemaps/js-marker-clusterer/gh-pages/src/markerclusterer.js">
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo $key; ?>&callback=initMap">
</script>
</body>
</html>