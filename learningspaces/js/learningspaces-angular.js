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
	$scope.loadMore = 'Load 35 more'; //set default
	$scope.showing = 35; //set default
	$scope.checked_buildings = [];
	var storageRooms = sessionStorage.getItem("resultRooms");
	var formData='';
	var map;
	var marker;
	var markers = [];
	var buildings;
	var newvalues = '';
	sessionStorage.setItem('openModal', 'false');
	
	$scope.getTheFormData = function(){
	return JSON.parse(sessionStorage.getItem("formValues"));
	};
	
	//todo: make each category dynamic
	
	$scope.cancel = function(formValues){
		
	jQuery( ".checkbox" ).removeClass( "ng-valid-parse" );///////////
	jQuery( ".checkbox" ).removeClass( "ng-touched" ).addClass( "ng-untouched" );
	jQuery( ".checkbox" ).removeClass( "ng-not-empty" ).addClass( "ng-empty" );
	jQuery( ".checkbox" ).removeClass( "ng-dirty" ).addClass( "ng-pristine" );
	var allCheckboxes=jQuery('[type=checkbox]');
	jQuery.each(allCheckboxes,function(){///////////////////////
    	jQuery(this).prop('checked', false);
	});

	$scope.spacesForm = {};
	var checked = '';	
	var substring = '';	
		
		substring = 'Open_Seating';		
		$scope.spaceType[substring] = false;
		if (formValues.indexOf(substring) !== -1){
			$scope.spaceType[substring] = true;
			checked = jQuery("."+substring);
			checked.removeClass( "ng-untouched" ).addClass( "ng-touched" );
			checked.removeClass( "ng-pristine" ).addClass( "ng-dirty" );
			checked.removeClass( "ng-empty" ).addClass( "ng-not-empty" );
			checked.addClass( "ng-valid-parse" );///////////
			checked.prop('checked',true);
		}	
		
		substring = 'Single_Group';		
		$scope.spaceType[substring] = false;
		if (formValues.indexOf(substring) !== -1){
			$scope.spaceType[substring] = true;
			checked = jQuery("."+substring);
			checked.removeClass( "ng-untouched" ).addClass( "ng-touched" );
			checked.removeClass( "ng-pristine" ).addClass( "ng-dirty" );
			checked.removeClass( "ng-empty" ).addClass( "ng-not-empty" );
			checked.addClass( "ng-valid-parse" );///////////
			checked.prop('checked',true);
		}	
		
		substring = 'Food_Court';		
		$scope.spaceType[substring] = false;
		if (formValues.indexOf(substring) !== -1){
			$scope.spaceType[substring] = true;
			checked = jQuery("."+substring);
			checked.removeClass( "ng-untouched" ).addClass( "ng-touched" );
			checked.removeClass( "ng-pristine" ).addClass( "ng-dirty" );
			checked.removeClass( "ng-empty" ).addClass( "ng-not-empty" );
			checked.addClass( "ng-valid-parse" );///////////
			checked.prop('checked',true);
		}
		
////////////////////////////////////////////////////////////////////////////////////
				
		substring = 'Quiet_Study';		
		$scope.noiseExpectation[substring] = false;
		if (formValues.indexOf(substring) !== -1){
			$scope.noiseExpectation[substring] = true;
			checked = jQuery("."+substring);
			checked.removeClass( "ng-untouched" ).addClass( "ng-touched" );
			checked.removeClass( "ng-pristine" ).addClass( "ng-dirty" );
			checked.removeClass( "ng-empty" ).addClass( "ng-not-empty" );
			checked.addClass( "ng-valid-parse" );///////////
			checked.prop('checked',true);
		}				
		substring = 'Public';		
		$scope.noiseExpectation[substring] = false;
		if (formValues.indexOf(substring) !== -1){
			$scope.noiseExpectation[substring] = true;
			checked = jQuery("."+substring);
			checked.removeClass( "ng-untouched" ).addClass( "ng-touched" );
			checked.removeClass( "ng-pristine" ).addClass( "ng-dirty" );
			checked.removeClass( "ng-empty" ).addClass( "ng-not-empty" );
			checked.addClass( "ng-valid-parse" );///////////
			checked.prop('checked',true);
		}
//////////////////////////////////////////////////////////////////////////
				
		substring = 'Colonial_Printing_Kiosks';		
		$scope.amenity[substring] = false;
		if (formValues.indexOf(substring) !== -1){
			$scope.amenity[substring] = true;
			checked = jQuery("."+substring);
			checked.removeClass( "ng-untouched" ).addClass( "ng-touched" );
			checked.removeClass( "ng-pristine" ).addClass( "ng-dirty" );
			checked.removeClass( "ng-empty" ).addClass( "ng-not-empty" );
			checked.addClass( "ng-valid-parse" );///////////
			checked.prop('checked',true);
		}				
		substring = 'Vending_Machine';		
		$scope.amenity[substring] = false;
		if (formValues.indexOf(substring) !== -1){
			$scope.amenity[substring] = true;
			checked = jQuery("."+substring);
			checked.removeClass( "ng-untouched" ).addClass( "ng-touched" );
			checked.removeClass( "ng-pristine" ).addClass( "ng-dirty" );
			checked.removeClass( "ng-empty" ).addClass( "ng-not-empty" );
			checked.addClass( "ng-valid-parse" );///////////
			checked.prop('checked',true);
		}				
		substring = 'Natural_Lighting';		
		$scope.amenity[substring] = false;
		if (formValues.indexOf(substring) !== -1){
			$scope.amenity[substring] = true;
			checked = jQuery("."+substring);
			checked.removeClass( "ng-untouched" ).addClass( "ng-touched" );
			checked.removeClass( "ng-pristine" ).addClass( "ng-dirty" );
			checked.removeClass( "ng-empty" ).addClass( "ng-not-empty" );
			checked.addClass( "ng-valid-parse" );///////////
			checked.prop('checked',true);
		}				
		substring = 'Reservable';		
		$scope.amenity[substring] = false;
		if (formValues.indexOf(substring) !== -1){
			$scope.amenity[substring] = true;
			checked = jQuery("."+substring);
			checked.removeClass( "ng-untouched" ).addClass( "ng-touched" );
			checked.removeClass( "ng-pristine" ).addClass( "ng-dirty" );
			checked.removeClass( "ng-empty" ).addClass( "ng-not-empty" );
			checked.addClass( "ng-valid-parse" );///////////
			checked.prop('checked',true);
		}
//////////////////////////////////////////////////////////////////////////
				
		substring = 'Powered_Furniture';		
		$scope.technology[substring] = false;
		if (formValues.indexOf(substring) !== -1){
			$scope.technology[substring] = true;
			checked = jQuery("."+substring);
			checked.removeClass( "ng-untouched" ).addClass( "ng-touched" );
			checked.removeClass( "ng-pristine" ).addClass( "ng-dirty" );
			checked.removeClass( "ng-empty" ).addClass( "ng-not-empty" );
			checked.addClass( "ng-valid-parse" );///////////
			checked.prop('checked',true);
		}				
		substring = 'Whiteboards';		
		$scope.technology[substring] = false;
		if (formValues.indexOf(substring) !== -1){
			$scope.technology[substring] = true;
			checked = jQuery("."+substring);
			checked.removeClass( "ng-untouched" ).addClass( "ng-touched" );
			checked.removeClass( "ng-pristine" ).addClass( "ng-dirty" );
			checked.removeClass( "ng-empty" ).addClass( "ng-not-empty" );
			checked.addClass( "ng-valid-parse" );///////////
			checked.prop('checked',true);
		}				
		substring = 'Display_Screens';		
		$scope.technology[substring] = false;
		if (formValues.indexOf(substring) !== -1){
			$scope.technology[substring] = true;
			checked = jQuery("."+substring);
			checked.removeClass( "ng-untouched" ).addClass( "ng-touched" );
			checked.removeClass( "ng-pristine" ).addClass( "ng-dirty" );
			checked.removeClass( "ng-empty" ).addClass( "ng-not-empty" );
			checked.addClass( "ng-valid-parse" );///////////
			checked.prop('checked',true);
		}				
		substring = 'Wall_Outlets';		
		$scope.technology[substring] = false;
		if (formValues.indexOf(substring) !== -1){
			$scope.technology[substring] = true;
			checked = jQuery("."+substring);
			checked.removeClass( "ng-untouched" ).addClass( "ng-touched" );
			checked.removeClass( "ng-pristine" ).addClass( "ng-dirty" );
			checked.removeClass( "ng-empty" ).addClass( "ng-not-empty" );
			checked.addClass( "ng-valid-parse" );///////////
			checked.prop('checked',true);
		}				
		substring = 'Mac_Computers';		
		$scope.technology[substring] = false;
		if (formValues.indexOf(substring) !== -1){
			$scope.technology[substring] = true;
			checked = jQuery("."+substring);
			checked.removeClass( "ng-untouched" ).addClass( "ng-touched" );
			checked.removeClass( "ng-pristine" ).addClass( "ng-dirty" );
			checked.removeClass( "ng-empty" ).addClass( "ng-not-empty" );
			checked.addClass( "ng-valid-parse" );///////////
			checked.prop('checked',true);
		}				
		substring = 'Windows_Computers';		
		$scope.technology[substring] = false;
		if (formValues.indexOf(substring) !== -1){
			$scope.technology[substring] = true;
			checked = jQuery("."+substring);
			checked.removeClass( "ng-untouched" ).addClass( "ng-touched" );
			checked.removeClass( "ng-pristine" ).addClass( "ng-dirty" );
			checked.removeClass( "ng-empty" ).addClass( "ng-not-empty" );
			checked.addClass( "ng-valid-parse" );///////////
			checked.prop('checked',true);
		}
////////////////////////////////////////////////////////////////////////////
				
		substring = 'Carrels';		
		$scope.furniture[substring] = false;
		if (formValues.indexOf(substring) !== -1){
			$scope.furniture[substring] = true;
			checked = jQuery("."+substring);
			checked.removeClass( "ng-untouched" ).addClass( "ng-touched" );
			checked.removeClass( "ng-pristine" ).addClass( "ng-dirty" );
			checked.removeClass( "ng-empty" ).addClass( "ng-not-empty" );
			checked.addClass( "ng-valid-parse" );///////////
			checked.prop('checked',true);
		}				
		substring = 'Soft_Seating';		
		$scope.furniture[substring] = false;
		if (formValues.indexOf(substring) !== -1){
			$scope.furniture[substring] = true;
			checked = jQuery("."+substring);
			checked.removeClass( "ng-untouched" ).addClass( "ng-touched" );
			checked.removeClass( "ng-pristine" ).addClass( "ng-dirty" );
			checked.removeClass( "ng-empty" ).addClass( "ng-not-empty" );
			checked.addClass( "ng-valid-parse" );///////////
			checked.prop('checked',true);
		}				
		substring = 'High_Tops';		
		$scope.furniture[substring] = false;
		if (formValues.indexOf(substring) !== -1){
			$scope.furniture[substring] = true;
			checked = jQuery("."+substring);
			checked.removeClass( "ng-untouched" ).addClass( "ng-touched" );
			checked.removeClass( "ng-pristine" ).addClass( "ng-dirty" );
			checked.removeClass( "ng-empty" ).addClass( "ng-not-empty" );
			checked.addClass( "ng-valid-parse" );///////////
			checked.prop('checked',true);
		}				
		substring = 'Tables';		
		$scope.furniture[substring] = false;
		if (formValues.indexOf(substring) !== -1){
			$scope.furniture[substring] = true;
			checked = jQuery("."+substring);
			checked.removeClass( "ng-untouched" ).addClass( "ng-touched" );
			checked.removeClass( "ng-pristine" ).addClass( "ng-dirty" );
			checked.removeClass( "ng-empty" ).addClass( "ng-not-empty" );
			checked.addClass( "ng-valid-parse" );///////////
			checked.prop('checked',true);
		}				
		substring = 'Stools';		
		$scope.furniture[substring] = false;
		if (formValues.indexOf(substring) !== -1){
			$scope.furniture[substring] = true;
			checked = jQuery("."+substring);
			checked.removeClass( "ng-untouched" ).addClass( "ng-touched" );
			checked.removeClass( "ng-pristine" ).addClass( "ng-dirty" );
			checked.removeClass( "ng-empty" ).addClass( "ng-not-empty" );
			checked.addClass( "ng-valid-parse" );///////////
			checked.prop('checked',true);
		}
////////////////////////////////////////////////////////////////////////////		

		
	angular.forEach($scope.buildingFilter, function(value, key){
		angular.forEach(value, function(value1, key1){
				$scope.building[value1] = false;
			if (formValues.indexOf(value1) !== -1){
				if (key1==='filter'){
				$scope.building[value1] = true;
				checked = jQuery("."+value1);
				checked.removeClass( "ng-untouched" ).addClass( "ng-touched" );
				checked.removeClass( "ng-pristine" ).addClass( "ng-dirty" );
				checked.removeClass( "ng-empty" ).addClass( "ng-not-empty" );
				checked.addClass( "ng-valid-parse" );///////////
				checked.prop('checked',true);
				}
			}
		});	
	});
		
//////////////////////////////////////////////////////////////////////////////
	
	};
	
	$scope.setTheFormData = function(){
	setDefaultFormData();
	};
	
	$scope.setModalOpenTrue = function(){
	sessionStorage.setItem('openModal', 'true');
	};
	
	$scope.setModalOpenFalse = function(){
	sessionStorage.setItem('openModal', 'false');
	};
	
	$scope.setAppliedFiltersTrue = function(){
	sessionStorage.setItem('formSubmitted', 'true');
	};
	
	$scope.setAppliedFiltersFalse = function(){
	setDefaultFormSubmitted();
	};
	
	$scope.submit = function() {
	if (sessionStorage.getItem("openModal")==='false'){
	document.getElementById("rooms").classList.add("processing-results");
	deleteMarkers();
	formData = getFormData();
	showResults('submit',formData);
	getBuildingFilter(formData);
	//reCalculateCounts();
	setDefaultFormData();
	console.log("submit via submit");
	}
	};
	
	$scope.submitFilters = function() {
	document.getElementById("rooms").classList.add("processing-results");
	deleteMarkers();
	formData = getFormData();
	showResults('submit',formData);
	getBuildingFilter(formData);
	//reCalculateCounts();
	setDefaultFormData();
	console.log("submit via submit Filter");
	};	
	
	$scope.submit_campus = function() {
	$scope.building = {};
	document.getElementById("rooms").classList.add("processing-results");
	deleteMarkers();
	formData = getFormData();
	initalizeMap($scope.campus);
	showResults('campus',formData);
	getBuildingFilter(formData);
	writeBuildingPins(formData);
	};
	
	
	$scope.loadMoreResults = function() {
	deleteMarkers();
	formData = getFormData();
	showResults('loadMore',formData);
	};
		
	$scope.closeRoom = function() {
		document.getElementById('room').style.display = 'none';		
		document.getElementById('rooms').style.display = 'block';
	};
	$scope.teaserMouseEnter = function(e,mouseenter) {
		if (mouseenter === true) {
			focusedElem = document.querySelector(".roomTeaser:focus");
			if (focusedElem) focusedElem.blur();
		}
		deleteMarkers();
		getRollOver(e);
	};
		
	$scope.teaserMouseLeave = function() {
		formData = getFormData();
		deleteMarkers();
		writeBuildingPins($scope.rooms);
	};
	
function setDefaultFormData(){
	sessionStorage.setItem("formValues", JSON.stringify(getFormData()));
}
function setDefaultFormSubmitted(){
	sessionStorage.setItem('formSubmitted', 'false');
}
	
function getInitialCounts() {
formData = getFormData();	
getCount(formData += '&input_filter=study_space');
getCount(formData += '&input_filter=noise');
getCount(formData += '&input_filter=amenities');
getCount(formData += '&input_filter=technology');
getCount(formData += '&input_filter=furniture');
getCount(formData += '&input_filter=locations');
}

/////////////////////////////////////////////////////////////////////////////////	
function getCategoryTitles(){
	var deferred = $q.defer();
		$http({
			method: 'POST',
			url: '/learningspaces/getCategoryTitles',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},          
		}).then(function successCallback(response3) {
					deferred.resolve(response3.data);
		}).catch(function(){
			alert("buildingFilter");
		});

		return deferred.promise;

}
/////////////////////////////////////////////////////////////////////////////////////////
function reCalculateCounts(){
formData = getFormData();
	//alert(formData);
        $http({
			method: 'POST',
			url: '/learningspaces/getUpdateCount',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}, 
			data:formData,
			}).then(function successCallback(response) {
			//alert(response.data);
			angular.forEach(response.data, function(value, key){
			document.getElementById(value.filter_title).innerHTML="("+value.filter_count+")";
			//document.getElementById(value.filter_title).innerHTML="()";
			console.log(value.filter_title+','+value.filter_count);
			});
			
		}).catch(function(){
			//alert("firing initial");
			getInitialCounts();
		});
		
}
	
function getCount(formData) {
	
//	alert(formData);
        $http({
			method: 'POST',
			url: '/learningspaces/getInitialCount',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}, 
			data:formData,
			}).then(function successCallback(response) {
			
			angular.forEach(response.data, function(value, key){
			var a = value.split(",");
			document.getElementById(a[1]).innerHTML="("+a[0]+")";
			//console.log(value);
			});
			
		}).catch(function(response){
			alert('error');

		});
	
	
}
	
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
function getAllResults(formData){
	var Rooms = getResults(formData); //call ajax method
	var VALUEROOMID = '';
	Rooms.then(function(value) {
		
	angular.forEach(value, function(value1, key1){
	VALUEROOMID = value1.roomID;
	});

	if (!angular.isUndefined(VALUEROOMID)){
	document.getElementById("noRoom").classList.remove("show");
	document.getElementById("noRoom").classList.add("hide");
	document.getElementById("rooms").classList.remove("hide");
	document.getElementById("rooms").classList.add("show");
	var	newvalue = JSON.stringify(value);
	$scope.rooms = JSON.parse(newvalue);
	document.getElementById("rooms").classList.remove("processing-results");
	writeBuildingPins($scope.rooms);
	} else {
	document.getElementById("rooms").classList.remove("show");
	document.getElementById("rooms").classList.add("hide");
	document.getElementById("noRoom").classList.remove("hide");
	document.getElementById("noRoom").classList.add("show");
	}	
		

	});
} 	
 
function showResults(arg1,formData){
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
		remainder = (totalResults-limit);
		if (remainder<0){
			remainder = 0;
		}
		var newlimit = +limit +35; 
		

switch(arg1){
			   
		case 'initial':
				limit = 35;
				loadMore = 'Load 35 more';
				showing = limit;
		break;
			   
		case 'campus':
			if (remainder>limit){
			limit = 35;
			loadMore = 'Load 35 more';
			showing = limit;
			} 
			if ((remainder>0)&&(remainder<limit)){
			loadMore = 'Load '+remainder+' more';
			showing = 35;
			limit = 35;
			}
			if ((totalResults<=showing)||(remainder===0)){
			limit = totalResults;
			loadMore = '';
			showing = totalResults;
			}
		//alert(totalResults+"-"+limit+"="+remainder+', limit = '+limit+', load more: '+loadMore);
		break;
			   
		case 'submit':
			//alert(totalResults+"-"+limit+"="+(totalResults-limit)+', limit = '+limit+', load more: '+remainder);
			if (remainder>=35){
				showing = limit;
				//limit = newlimit;
				loadMore = 'Load 35 more';
			} 
			if (remainder<35){
				if (newlimit>=totalResults){
				loadMore = 'Load '+remainder+' more';
				showing = limit;
				} 
			if (remainder>=35){
				loadMore = 'Load '+remainder+' more';
				showing = newlimit;
				}
			}
			if ((totalResults<=showing)||(remainder==0)){
				loadMore = '';
				showing = totalResults;
			}	
		break;
			   
		case 'loadMore':
//		alert(newlimit);
			if (remainder>=newlimit){
				limit = newlimit;
				showing = limit;
				loadMore = 'Load 35 more';
			//	alert(totalResults+"-"+limit+"="+(totalResults-limit)+', limit = '+limit+', load more: '+loadMore);
			} 
	
			if (remainder<newlimit){
				limit = newlimit;
				showing = limit;
				loadMore = 'Load '+(totalResults-limit)+' more';
			//	alert(totalResults+"-"+limit+"="+(totalResults-limit)+', limit = '+limit+', load more: '+loadMore);
			} 
		

			if ((totalResults<=showing)||(remainder==0)){
				limit = totalResults;
				loadMore = '';
				showing = totalResults;
			}	
		
		break;


			   
		}		
		
		
			$scope.showing = showing;	
			$scope.loadMore = loadMore;
			$scope.total = totalResults;
			$scope.limit = limit;
			getAllResults(formData); //call ajax method
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


	formData = "input_campus="+$scope.campus;

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

		//console.log(key +":" +value);

		});

	var spaceType_csv = spaceType.join();
	//console.log('space start');
	//console.log(spaceType);
	spaceType = [];		
	//console.log(spaceType_csv);
	//console.log('space end');
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
		//console.log(formData);
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
	//return jQuery("#spacesForm").serialize();
}	
////////////////////////////////////////////////////

function getTotal (formData){
	var deferred = $q.defer();

		
	
		//get total without adding a limit
        $http({
			method: 'POST',
			url: '/learningspaces/get_total',
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
////////////////////////////////////////////////////////////

		
///////////////////////////////////////
function getResults(formData) {
	formData += "&input_limit="+$scope.limit;
	//alert(formData);
	var deferredResults = $q.defer();

	$http({
			method: 'POST',
			url: '/learningspaces/get_rooms',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},          
			data:formData,
			}).then(function successCallback(response) {			
			deferredResults.resolve(response.data);
			//angular.element(document.querySelector('#rooms')).html(response.data);
		}).catch(function() {
		// handle errors
		});
		
		//////////////////////////////////////////
		return deferredResults.promise;///////////
		//////////////////////////////////////////
		
}
///////////////////////////////////////

	
////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
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
function writeBuildingPins(buildings){
var buildingArray = [];


				angular.forEach(buildings, function(building, key){//foreach building
					
					if(buildingArray.indexOf(building.buildingID) === -1) {
						buildingArray.push(building.buildingID);

						var attachment = '<div class="infoWindowRooms"><h3>'+building.title_building+'</h3><div class="infoWindowRoomsList">';

						angular.forEach($scope.rooms, function(room, key1){//foreach rooms
							if(building.buildingID === room.buildingID){
							attachment += '<div class="infoWindowRoom" data-room-id="'+room.roomID+'" id="'+room.roomID+'">'+room.title_room+'</div>';
							}//if
						});//foreach rooms

						attachment += '</div>';	
						attachment += '</div>';	
						var compiledContent = $compile(attachment)($scope);					
						addMarkerToMap(building.lattitude, building.longitude, compiledContent[0], building.address);
					}

				});//foreach buildingArray

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
				centerLattitude = '';
				centerLongitude = '';
				break;

			case '433': //foggy bottom 
				centerLattitude = 38.898094;
				centerLongitude = -77.0464613;
				break;

			case '434':  //mount vernon
				centerLattitude = 38.9178832;
				centerLongitude = -77.0934827;
				break;
			default:
				centerLattitude = 38.898094;
				centerLongitude = -77.0464613;
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

    // The following is an adjustment made so that controls such as mapType ("Map | Satellite") and the full screen control
    // don't get in the way of the infoWindow's title and its "x" for closing.  Done in response to Drupal-Modules issue #69.
    // Basically, it gets the offset in pixels of the infoWindow's associated lat/lang relative to the top of the map, 
    // subtracts the height of the infoWindow (plus some adjustments for things like marker height, arrow height, etc.) and
    // if the value is negative, it moves it down after the map has been autopanned to adjust for otherwise offscreen infoWindows.
    // Perhaps more complicated that it should be, but there seems to be few built-in controls for such a feature.
    // The first few lines are things I got from StackOverflow answers to apparently be able to start making such calculations.
    var overlay = new google.maps.OverlayView();
    overlay.draw = function() {};
    overlay.setMap(map);
    var proj;
    // Make the adjustment, if necessary on the position_changed event
    google.maps.event.addListener(infowindow, 'position_changed', function() {
	// Define proj here, since it errors if trying to set outside the event
	proj = overlay.getProjection();
	var ll = infowindow.getPosition();
	var pxOffsetY = proj.fromLatLngToContainerPixel(ll).y;
	var iwHeight = infowindow.getContent().getBoundingClientRect().height;
        var iwHeightPlus = iwHeight + 130 // apparently roughly 130 pixels accounts for marker height, arrow height, infoWindow padding, and control height
	var difference = pxOffsetY - iwHeightPlus;
	if (difference < 0) {
	    // Delay this action, since apparently position_changed actually seems to fire at the beginning of the autopan,
            // and any adjustment we make gets overridden by the autopanner otherwise. 500 is just a guess for the time.
	    setTimeout(function() {
		// Move it only by the higher of -30 or whatever the difference is (so that if the infoWindow is only ~10 pixels under the controls, it only gets moved 10px
		map.panBy(0,Math.max(-30,difference));
	    }, 500);
	}
    });

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
showResults('initial',getFormData());
getBuildingFilter();
if (storageRooms===null){
		var resultRooms = getInitialSpaces(); //call ajax method
		resultRooms.then(function(value) {
		var	newvalue = JSON.stringify(value);
		sessionStorage.setItem("resultRooms", newvalue);
		var roomDataSet = JSON.parse(newvalue);
		});
}
		angular.element(document.getElementById('page')).scope().setTheFormData();

//getInitialCounts();
setDefaultFormData();
setDefaultFormSubmitted();

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