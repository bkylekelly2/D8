var app = angular.module('learningSpaces', []);
app.controller('learningSpacesCtrl', function($scope,$http,$compile,$q ) {
	
	$scope.campus = '433'; //set default
	$scope.amenity = {};
	$scope.building = {};
	$scope.spaceType = {};
	$scope.software = {};
	$scope.furniture = {};
	$scope.noiseExpectation = {};
	$scope.technology = {};

	$scope.limit = 35; //set default
	$scope.total = ''; //set default
	$scope.loadMore = 'load 35 more'; //set default
	$scope.showing = 35; //set default
	$scope.checked_buildings = [];
	var storageRooms = sessionStorage.getItem("resultRooms");
	var formData;
	var map;
	var marker;
	var markers = [];
	var buildings;
	
	$scope.submit = function() {
	formData = getFormData();
	deleteMarkers();	
	loadResults('true','true',formData);
	getBuildingFilter(formData);
	writeBuildingPins(formData);
	};	
	
	$scope.submit_reset = function() {
	formData = getFormData();
	initalizeMap($scope.campus);
	loadResults('false','true',formData);
	getBuildingFilter(formData);
	writeBuildingPins(formData);
	};
	
	
	$scope.loadMoreResults = function() {
	formData = getFormData();
	deleteMarkers();
	loadResults('true','false',formData);
	getBuildingFilter(formData);
	var roomsList = getInfoWindow(formData);
	roomsList.then(function(value) {
	var newvalue = JSON.stringify(value);
	$scope.roomsList = JSON.parse(newvalue);
	});
	writeBuildingPins(formData); //call ajax method);
	};
		
	$scope.closeRoom = function() {
		document.getElementById('room').style.display = 'none';		
		document.getElementById('rooms').style.display = 'block';
	};
	$scope.teaserMouseOver = function(roomID) {
		deleteMarkers();
		getRollOver(roomID);
	};
		
	$scope.teaserMouseLeave = function() {
		formData = getFormData();
		deleteMarkers();
		writeBuildingPins(formData); //call ajax method);
	};
	
 	
 
function loadResults(arg1,arg2,formData){
	//alert(formData);
	var total;
	var totalResults;
	var remainder;
	var limit = $scope.limit;
	var showing = $scope.showing;
	var loadMore = $scope.loadMore;
	total = getTotal(formData);
	
	total.then(function(value) {
		totalResults = JSON.stringify(value);
		totalResults = Number(JSON.parse(totalResults));
		var newlimit = +limit +35; 
		remainder = (totalResults-newlimit);
		if (remainder<0){
			remainder = 0;
		}
		
		
switch(arg1){
			   
			case 'true':
				
				switch(arg2){
					   
					case 'true':
					if (remainder>=35){
						limit = 35;
						loadMore = 'load 35 more';
						showing = limit;
					    //alert('kyle');
//					    alert(totalResults+"-"+newlimit+"="+remainder+', limit = '+limit+', load more: '+loadMore);
						} 
						if (remainder<35){
							if (newlimit>=totalResults){
							limit = totalResults;
							loadMore = 'load '+remainder+' more';
							showing = limit;
							} else {
							limit = newlimit;
							loadMore = 'load '+remainder+' more';
							showing = newlimit;
							}
//						alert('kylekelly');		
						//alert(totalResults+"-"+limit+"="+remainder+', limit = '+limit+', load more: '+remainder);
						}

						if ((totalResults<=showing)||(remainder===0)){
						limit = totalResults;
						loadMore = '';
						showing = totalResults;
						}						
					break;
											   
					case 'false':
					if (remainder>=35){
						limit = newlimit;
						loadMore = 'load 35 more';
						showing = limit;
					   // alert(totalResults+"-"+newlimit+"="+remainder+', limit = '+limit+', load more: '+loadMore);
						} 
						if (remainder<35){
							if (newlimit>=totalResults){
							limit = totalResults;
							loadMore = 'load '+remainder+' more';
							showing = limit;
							} else {
							limit = newlimit;
							loadMore = 'load '+remainder+' more';
							showing = newlimit;
							}
					//	alert(totalResults+"-"+limit+"="+remainder+', limit = '+limit+', load more: '+remainder);
						}

						if ((totalResults<=showing)||(remainder===0)){
						limit = totalResults;
						loadMore = '';
						showing = totalResults;
						}
					break;
					   
				}
			
			break;

			   
			case 'false':
				
				switch(arg2){
					   
					case 'true':
						limit = 35;
						loadMore = 'load 35 more';
						showing = limit;
					break;
  
					case 'false':
						if (remainder>limit){
						limit = +limit +35;
						limit = 35;
						loadMore = 'load 35 more';
						showing = limit;
						} 
						if (remainder<limit){
						loadMore = 'load '+remainder+' more';
						showing = 35;
						limit = 35;
						}
					break;
					   
				}
		break;


			   
		}		
		
		
			$scope.showing = showing;	
			$scope.loadMore = loadMore;
			$scope.total = totalResults;
			$scope.limit = limit;
	$scope.getResults($scope,$http,formData); //call ajax method	
	});
		//////////////////////////////////////////////////////////////////

		//////////////////////////////////////////////
	
}
	
function getFormData (){
	var technology = [];
	var building = [];
	var software = [];
	var furniture = [];
	var noiseExpectation = [];
	var amenity = [];
	var spaceType = [];
	var formData = "";


	if ($scope.campus){
		formData += "input_campus="+$scope.campus;
	}

	if(Object.keys($scope.spaceType).length) {
		angular.forEach($scope.spaceType, function(value, key){

			if (value){
			spaceType.push(key);
			} else {
				var index = spaceType.indexOf(key);
				if (index > -1) {
				   spaceType.splice(index, 1);
				}
			}


		});

	var spaceType_csv = spaceType.join();
	//console.log('space');
	//console.log(spaceType);
	spaceType = [];		
	//console.log('begin');
	//console.log(spaceType_csv);
	//console.log('end');
	formData += "&input_spaceType="+spaceType_csv;
	}



	if(Object.keys($scope.software).length) {
		angular.forEach($scope.software, function(value, key){

			if (value){
			software.push(key);
			} else {
				var index = software.indexOf(key);
				if (index > -1) {
				   software.splice(index, 1);
				}
			}


		});

	var software_csv = software.join();
	//console.log('space');
	//console.log(workType);
	software = [];		
	//console.log('begin');
	//console.log(amenity_csv);
	//console.log('end');
	formData += "&input_software="+software_csv;
	}

	if(Object.keys($scope.furniture).length) {
		angular.forEach($scope.furniture, function(value, key){

			if (value){
			furniture.push(key);
			} else {
				var index = furniture.indexOf(key);
				if (index > -1) {
				   furniture.splice(index, 1);
				}
			}


		});

	var furniture_csv = furniture.join();
	//console.log('space');
	//console.log(furniture);
	furniture = [];		
	//console.log('begin');
	//console.log(furniture_csv);
	//console.log('end');
	formData += "&input_furniture="+furniture_csv;
		console.log(formData);
	}

	if(Object.keys($scope.amenity).length) {
		angular.forEach($scope.amenity, function(value, key){

			if (value){
			amenity.push(key);
			} else {
				var index = amenity.indexOf(key);
				if (index > -1) {
				   amenity.splice(index, 1);
				}
			}


		});

	var amenity_csv = amenity.join();
	//console.log('space');
	//console.log(workType);
	amenity = [];		
	//console.log('begin');
	//console.log(amenity_csv);
	//console.log('end');
	formData += "&input_amenity="+amenity_csv;
	}

	if(Object.keys($scope.noiseExpectation).length) {
		angular.forEach($scope.noiseExpectation, function(value, key){

			if (value){
			noiseExpectation.push(key);
			} else {
				var index = noiseExpectation.indexOf(key);
				if (index > -1) {
				   noiseExpectation.splice(index, 1);
				}
			}


		});

	var noiseExpectation_csv = noiseExpectation.join();
	//console.log('space');
	//console.log(noiseExpectation);
	noiseExpectation = [];		
	//console.log('expectation');
	//console.log(noiseExpectation_csv);
	//console.log('end');
	formData += "&input_noiseExpectation="+noiseExpectation_csv;
	}

	if(Object.keys($scope.technology).length) {
		angular.forEach($scope.technology, function(value, key){

			if (value){
			technology.push(key);
			} else {
				var index = technology.indexOf(key);
				if (index > -1) {
				   technology.splice(index, 1);
				}
			}


		});

	var technology_csv = technology.join();
	//console.log('space');
	//console.log(technology);
	technology = [];		
	//console.log('space');
	//console.log(technology_csv);
	//console.log('end');
	formData += "&input_technology="+technology_csv;
	}
///////////////////////////////////////////////////////////
	if(Object.keys($scope.building).length) {
		angular.forEach($scope.building, function(value, key){

			if (value){
			building.push(key);
			} else {
				var index = building.indexOf(key);
				if (index > -1) {
				   building.splice(index, 1);
				}
			}


		});

	var building_csv = building.join();
	//console.log('space');
	//console.log(technology);
	building = [];		
	//console.log('space');
	//console.log(technology_csv);
	//console.log('end');
	formData += "&input_building="+building_csv;
	}
///////////////////////////////////////////////////////////

	return formData;		
	//alert(formData);
}	
////////////////////////////////////////////////////
function getInitialSpaces() {
	
	var deferred = $q.defer();

	//console.log(formData);
        $http({
			method: 'POST',
			url: '/learningspaces/get_spaces',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},          
			}).then(function successCallback(response) {
			//console.log(response.data);
			deferred.resolve(response.data);
			
		}).catch(function(response){
          deferred.reject(response);
        });
	
		return deferred.promise;
	
    }
////////////////////////////////////////////////////
function getTotal (formData){
	var deferred = $q.defer();

		
	
		//get total without adding a limit
        $http({
			method: 'POST',
			url: '/learningspaces/get_totalTest',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},          
			data:formData,
			}).then(function successCallback(response) {
			
		deferred.resolve(response.data);
	
			
		}).catch(function() {
		// handle error
		});
		
		//totalResults = deferred.promise;
		//totalResults = JSON.parse(totalResults);
		return deferred.promise;
		
		
	}
	
		
///////////////////////////////////////
$scope.getResults = function($scope,$http,formData) {

formData += "&input_limit="+$scope.limit;
	
			//alert(formData);

	$http({
			method: 'POST',
			url: '/learningspaces/get_roomsTest',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},          
			data:formData,
			}).then(function successCallback(response) {
	//	console.log(response.data);
			angular.element(document.querySelector('#rooms')).html(response.data);
		}).catch(function() {
		// handle errors
		});
	
		//////////////////////////////////////////
	
	
		
    };
	
function getInfoWindow(formData) {

formData += "&input_limit="+$scope.limit;
	
var deferred = $q.defer();

			//alert(formData);

	$http({
			method: 'POST',
			url: '/learningspaces/get_roomslist',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},          
			data:formData,
			}).then(function successCallback(response) {
		
			deferred.resolve(response.data);

		}).catch(function() {
		  deferred.reject(response);
		}); 
	
	return deferred.promise;
		
    };
////////////////////////////////////////////////////////////////////////
function getBuildings(formData){

formData += "&input_limit="+$scope.limit;

var deferred2 = $q.defer();

		$http({
			method: 'POST',
			url: '/learningspaces/get_buildings',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},          
			data:formData,
		}).then(function successCallback(response) {
			deferred2.resolve(response.data);

		}).catch(function(response){
		  deferred2.reject(response);
		});
	
	

		return deferred2.promise;



}////////////////////////////////////////////////////////////////////////
function getBuildingFilter(){
formData = 'input_campus='+$scope.campus;
		$http({
			method: 'POST',
			url: '/learningspaces/get_buildingFilter',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},          
			data:formData,
		}).then(function successCallback(response3) {
		$scope.buildingFilter = response3.data;
		}).catch(function(){
			alert("buildingFilter");
		});




}
////////////////////////////////////////////////////////////////////////
function writeBuildingPins(formData){
formData += "&input_limit="+$scope.limit;

	$http({
			method: 'POST',
			url: '/learningspaces/get_buildings',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    		data:formData,
			}).then(function successCallback(response1) {

				angular.forEach(response1.data, function(value, key){//foreach building

					var attachment = '<div class="infoWindowRooms"><h3>'+value.title_building+'</h3>';
	
					attachment += '<div class="infoWindowRoomsList">';
					$http({
					method: 'POST',
					url: '/learningspaces/get_roomslist',
					headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    				data:formData+"&input_buildingID="+value.buildingID,
					}).then(function successCallback(response2) {
						

					angular.forEach(response2.data, function(value1, key1){//foreach rooms

					attachment += '<div class="infoWindowRoom" data-room-id="'+value1.roomID+'" >'+value1.title_room+'</div>';


					});//foreach rooms
						
					attachment += '</div>';	
					attachment += '</div>';	
					var compiledContent = $compile(attachment)($scope);					
						addMarkerToMap(value.lattitude, value.longitude, compiledContent[0], value.address);
					});





				});//foreach building
			
			
			}).catch(function() {
		// handle errors
			alert("buildings");
	
		});	

	
	

	

}	
////////////////////////////////////////////////////////////////////////////////	
	function getRollOver(roomID){
		//alert(roomID);
		var newlongitude = "";
		var newlattitude = "";
		var newaddress = "";	
		var title_building = "";	
		var title_room = "";
		
   		storageRooms = sessionStorage.getItem("resultRooms");
		var	roomDataSet = JSON.parse(storageRooms);
		//console.log(roomDataSet);
		
		roomID = parseInt(roomID);
		
				angular.forEach(roomDataSet, function(room, key){//foreach rooms
					var RoomID = parseInt(room.roomID);
					
					if (RoomID===roomID) {
						newlongitude = room.longitude;
						newlattitude = room.lattitude;
						newaddress = room.address;
						title_building = room.title_building;
						title_room = room.title_room;
     			//		console.log(roomID);
					}
				});//foreach rooms

		
						
						var newattachment = '<div class="infoWindowRooms">';
						newattachment += '<h3>'+title_building+'</h3>';
						newattachment += '<div class="infoWindowRoomsList">';
						newattachment += '<div class="infoWindowRoom" data-room-id="'+roomID+'">'+title_room+'</div>';
						newattachment += '</div>';	
						newattachment += '</div>';	
						var compiledContent = $compile(newattachment)($scope);
						
						addMarkerToMap(newlattitude, newlongitude, compiledContent[0], newaddress);
		
	
	}
////////////////////////////////////////////////////////////////////////////////////
	
	function parseQueryString(queryString) {
    var obj = {};
    function sliceUp(x) { x.replace('?', '').split('&').forEach(splitUp); }
    function splitUp(x) { var str = x.split('='); obj[str[0]] = decodeURIComponent(str[1]); }
    try { (!queryString ? sliceUp(location.search) : sliceUp(queryString)); } catch(e) {}
   return obj;
}
	
	/* MAP FUNCTIONS */
	
function initalizeMap(campus){
	
	switch(campus){

			case '432': //viginia campus
				centerLattitude = '39.057732';
				centerLongitude = '-77.444629';
				break;

			case '433': //foggy bottom 
				centerLattitude = 38.899648;
				centerLongitude = -77.046973;
				break;

			case '434':  //mount vernon
				centerLattitude = 38.918345;
				centerLongitude = -77.090443;
				break;
			default:
				centerLattitude = 38.899648;
				centerLongitude = -77.046973;
				break;
}

	var myLatlng = new google.maps.LatLng(centerLattitude, centerLongitude);
        var myStyles = [{
            featureType: "poi",
            stylers: [
                { visibility: "off" }
            ]
            }];
	var mapOptions = {
		zoom: 16,
		center: myLatlng,
//		styles: myStyles
	};
	
	map = new google.maps.Map(document.getElementById('map'), mapOptions);
	
	
}

//This function will add a marker to the map each time it 
//is called.  It takes latitude, longitude, and html markup
//for the content you want to appear in the info window 
//for the marker.
function addMarkerToMap(lat, long, attachment, title){
    var infowindow = new google.maps.InfoWindow();
	var markerCount;
	
    var myLatLng = new google.maps.LatLng(lat, long);
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
      //  animation: google.maps.Animation.DROP,
		title: title
    });
    
    //Gives each marker an Id for the on click
    markerCount++;

    //Creates the event listener for clicking the marker
    //and places the marker on the map 
    google.maps.event.addListener(marker, 'click', (function(marker, markerCount) {
        return function() {
            infowindow.setContent(attachment);
            infowindow.open(map, marker);
        };
    })(marker, markerCount));  
    
    /* Pans map to the new location of the marker */	
	/* uncomment the line below to pan to center (recenter) */
	
    //map.panTo(myLatLng);
	
	markers.push(marker);
}

function deleteMarkers() {
	//Loop through all the markers and remove
	for (var i = 0; i < markers.length; i++) {
		markers[i].setMap(null);
	}
	markers = [];
}
	
/* make it happen */
///////////////////////////////////////////////////////////////
initalizeMap($scope.campus);
loadResults('false','false');
getBuildingFilter();
//$scope.getResults($scope,$http); //call ajax method
writeBuildingPins();
if (storageRooms===null){
		var resultRooms = getInitialSpaces(); //call ajax method
		resultRooms.then(function(value) {
		var	newvalue = JSON.stringify(value);
		sessionStorage.setItem("resultRooms", newvalue);
		var roomDataSet = JSON.parse(newvalue);
		});
}

});
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
app.directive('checkList', function() {
  return {
    scope: {
      list: '=checkList',
      value: '@'
    },
    link: function(scope, elem, attrs) {
      var handler = function(setup) {
        var checked = elem.prop('checked');
        var index = scope.list.indexOf(scope.value);

        if (checked && index == -1) {
          if (setup) elem.prop('checked', false);
          else scope.list.push(scope.value);
        } else if (!checked && index != -1) {
          if (setup) elem.prop('checked', true);
          else scope.list.splice(index, 1);
        }
      };
      
      var setupHandler = handler.bind(null, true);
      var changeHandler = handler.bind(null, false);
            
      elem.on('change', function() {
        scope.$apply(changeHandler);
      });
      scope.$watch('list', setupHandler, true);
    }
  };
});
