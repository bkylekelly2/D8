var app = angular.module('learningSpaces', []);
app.controller('learningSpacesCtrl', function($scope,$http,$window ) {

	
	$scope.formData = {
	   'model_campus' : '',
   	   'model_workType' : '',	
   	   'model_facilities' : '',	
   	   'model_noiseLevel' : '',	
   	   'model_limit' : '',	
		
	}

	$scope.submit = function() {

		angular.forEach($scope.model_facilities, function(value, key){
			
			
			/*
			if (value===true){
				if ($scope.model_facilities_csv === ''){
					$scope.model_facilities_csv = key;
				} else{
					$scope.model_facilities_csv =+ "," + key;
				}
			}
			
			if (value===false){
				$scope.model_facilities_csv = removeValue($scope.model_facilities_csv, key);
			}
			*/
					

						
		});
//		
		//$scope.getResults($scope,$http); //call ajax method

		console.log($scope.model_facilities_csv);
		

    };
	
	$scope.getRoom = function(value) {
		console.log(value);	
    };
	
	
	
 	///////////////////////////////////////
   $scope.getResults = function($scope,$http) {
        $http({
			method: 'POST',
			url: '/learningspaces/get_rooms',
			}).then(function successCallback(response) {
			$scope.rooms = response.data;
			});
		//////////////////////////////////////////
	    $http({
			method: 'POST',
			url: '/learningspaces/get_buildings',
			}).then(function successCallback(response) {

			$scope.buildings = response.data;
			
			switch($scope.model_campus){

					case '432': //viginia campus
						centerLattitude = '';
						centerLongitude = '';
						break;

					case '433': //foggy bottom
						centerLattitude = 38.8991785;
						centerLongitude = -77.0484407;
						break;

					case '434':  //mount vernon
						centerLattitude = 38.9178832;
						centerLongitude = -77.0934827;
						break;
					default:
						centerLattitude = 38.8991785;
						centerLongitude = -77.0484407;
						break;
			}
	
			var myLatlng = new google.maps.LatLng(centerLattitude, centerLongitude);
			var mapOptions = {
				zoom: 16,
				center: myLatlng
			};
			var map = new google.maps.Map(document.getElementById('map'), mapOptions);
			
			
				angular.forEach($scope.buildings, function(value, key){//foreach building
					var marker = new google.maps.Marker({
						position: new google.maps.LatLng(parseFloat(value.lattitude), parseFloat(value.longitude)),
						map: map,
						title: value.title_building
					});
				var attachment = '<div style="width:auto;height:auto;background-color:#ededed;color:#fff; overflow-y: scroll;">';
				var formData = "input_buildingID="+value.buildingID+"&input_campus= "+$scope.model_campus;;
					$http({
					method: 'POST',
					url: '/learningspaces/get_rooms',
					headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    				data:formData,
					}).then(function successCallback(response1) {
					angular.forEach(response1.data, function(value1, key1){//foreach rooms

					attachment = attachment +'<div onClick="getRoom('+value1.roomID+')" style="cursor:pointer;">'+value1.title+'</div>';

					});//foreach rooms
					attachList(marker, attachment);
					});



				attachment = attachment + '</div>';

				});//foreach building
			
			
			});
		
			
		
		
		
		
		
		
    };
    ////////////////////////////////////////////////////////////////////////

    $scope.getResults($scope,$http); //call ajax method	


	
});

function getUniqueArray(array){
  var result = [];
  for(var x = 0; x < array.length; x++){
  if(result.indexOf(array[x]) == -1)
        result.push(array[x]);
  }
  return result;
}
function removeValue(list, value) {
  return list.replace(new RegExp(",?" + value + ",?"), function(match) {
      var first_comma = match.charAt(0) === ',',
          second_comma;

      if (first_comma &&
          (second_comma = match.charAt(match.length - 1) === ',')) {
        return ',';
      }
      return '';
    });
}
function attachList(marker, attachment) {
        var infowindow = new google.maps.InfoWindow({
          content: attachment
        });

        marker.addListener('click', function() {
          infowindow.open(marker.get('map'), marker);
        });
      }