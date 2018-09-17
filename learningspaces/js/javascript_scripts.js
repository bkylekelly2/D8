function attachList(marker, attachment) {
        var infowindow = new google.maps.InfoWindow({
          content: attachment
        });

        marker.addListener('click', function() {
          infowindow.open(marker.get('map'), marker);
        });
      }