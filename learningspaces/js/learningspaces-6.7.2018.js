var app = angular.module('learningSpaces', []);
app.controller('learningSpacesCtrl', function($scope,$http,$compile,$q ) {
	
	$scope.campus = '433'; //set default
	$scope.amenity = {};
	$scope.spaceType = {};
	$scope.noiseExpectation = {};
	$scope.technology = {};
	$scope.limit = 35; //set default
	$scope.total = ''; //set default
	$scope.loadMore = 'load 35 more'; //set default
	$scope.showing = 35; //set default
	var formData;

	   
	$scope.submit = function() {
	loadResults('false');
	};
	
	
	$scope.loadMoreResults = function() {
	loadResults('true');
	};
		
	$scope.closeRoom = function() {
		document.getElementById('room').style.display = 'none';		
		document.getElementById('rooms').style.display = 'block';
	};
	
function loadResults(arg){
	var total;
	var totalResults;
	var remainder;
	var limit = $scope.limit;
	var showing = $scope.showing;
	var loadMore = $scope.loadMore;
	total = getTotal();
	
	total.then(function(value) {
		totalResults = JSON.stringify(value);
		totalResults = Number(JSON.parse(totalResults));
		remainder = (totalResults-limit);	
		
	
		//////////////////////////////////////////////////////////////////
		if (arg!=='true'){
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

			
		}
		
		
		if (arg==='true'){
			if (remainder>limit){
				limit = +limit +35;
				loadMore = 'load 35 more';
				showing = limit;
			} 
			if (remainder<limit){
				limit = totalResults;
				loadMore = 'load '+remainder+' more';
				showing = totalResults;
			}

			if (showing===totalResults){
				limit = totalResults;
				loadMore = '';
				showing = totalResults;
			}
		} 
		
		
		//////////////////////////////////////////////
		$scope.showing = showing;	
		$scope.loadMore = loadMore;
		$scope.total = totalResults;
		$scope.limit = limit;
		//////////////////////////////////////////////
	$scope.getResults($scope,$http); //call ajax method	
	});
}
	
function getFormData (){
	var technology = [];
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

	return formData;		
	//alert(formData);
}	
////////////////////////////////////////////////////
	
function getTotal (){
	var deferred = $q.defer();

		var theformData = getFormData();
	
		//get total without adding a limit
        $http({
			method: 'POST',
			url: '/learningspaces/get_total',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},          
			data:theformData,
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
$scope.getResults = function($scope,$http) {
formData = getFormData();

formData += "&input_limit="+$scope.limit;
	
			alert(formData);

	$http({
			method: 'POST',
			url: '/learningspaces/get_rooms',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},          
			data:formData,
			}).then(function successCallback(response) {
	//	console.log(response.data);
			angular.element(document.querySelector('#rooms')).html(response.data);
		}).catch(function() {
		// handle errors
		});
	
		//////////////////////////////////////////
	    $http({
			method: 'POST',
			url: '/learningspaces/get_buildings',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    		data:formData,
			}).then(function successCallback(response1) {
console.log(response1.data);
			$scope.buildings = response1.data;
			
			switch($scope.campus){

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
			var mapOptions = {
				zoom: 16,
				center: myLatlng
			};
			var map = new google.maps.Map(document.getElementById('map'), mapOptions);
			
				angular.forEach($scope.buildings, function(value, key){//foreach building
					var marker = new google.maps.Marker({
						position: new google.maps.LatLng(parseFloat(value.lattitude), parseFloat(value.longitude)),
						map: map,
						title: value.address
					});
					var attachment = '<div class="infoWindowRooms"><h3>'+value.title_building+'</h3>';
	
					attachment += '<div class="infoWindowRoomsList>';
					$http({
					method: 'POST',
					url: '/learningspaces/get_roomslist',
					headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    				data:formData+"&input_buildingID="+value.buildingID,
					}).then(function successCallback(response2) {
						

					angular.forEach(response2.data, function(value1, key1){//foreach rooms

					attachment += '<div class="infoWindowRoom" data-room-id="'+value1.roomID+'" >'+value1.title+'</div>';


					});//foreach rooms
						
					attachment += '</div>';	
					attachment += '</div>';	
					var compiledContent = $compile(attachment)($scope);					
					attachList(marker, compiledContent[0], $scope);
					});





				});//foreach building
			
			
			}).catch(function(event) {
		// handle errors
		angular.forEach(event.data, function(value, key){
			console.log(key+"="+value);
		});//foreach building
	
		});		
		
    };
    ////////////////////////////////////////////////////////////////////////
	
	loadResults();
	
});
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
