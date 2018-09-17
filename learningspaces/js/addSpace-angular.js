var addSpace = angular.module('addSpace', []);
addSpace.controller('addSpaceCtrl', function($scope,$http ) {
"use strict";
	
	$scope.campus = ''; //set default
	$scope.room = ''; //set default
	$scope.floor = ''; //set default
	$scope.capacity = ''; //set default
	$scope.reservation = ''; //set default
	$scope.interior = ''; //set default
	$scope.notes = ''; //set default
	$scope.access = ''; //set default
	$scope.amenity = '';
	$scope.space = '';
	$scope.study = '';
	$scope.noise = '';
	$scope.technology = '';
	$scope.furniture = '';
	$scope.building = '';
	$scope.title = '';

	$scope.submit_campus = function() {
		//alert("kyle");
		getBuildingFilterAddSpace();
	};	
	
   $scope.choices = [{id: 'choice1', name: 'choice1'}, {id: 'choice2', name: 'choice2'}, {id: 'choice3', name: 'choice3'}];
   
   $scope.addNewChoice = function() {
     var newItemNo = $scope.choices.length+1;
     $scope.choices.push({'id' : 'choice' + newItemNo, 'name' : 'choice' + newItemNo});
   };
   
   $scope.removeNewChoice = function() {
     var newItemNo = $scope.choices.length-1;
     if ( newItemNo !== 0 ) {
      $scope.choices.pop();
     }
   };
   
   $scope.showAddChoice = function(choice) {
     return choice.id === $scope.choices[$scope.choices.length-1].id;
   };
	
	
function getBuildingFilterAddSpace(){
	//alert("kylekyle");
var formData = 'input_campus='+$scope.campus;
		$http({
			method: 'POST',
			url: '/learningspaces/get_buildingFilter',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},          
			data:formData,
		}).then(function successCallback(response3) {
			//alert(response3.data);
		$scope.buildingFilter = response3.data;
		}).catch(function(){
			alert("buildingFiltererror");
		});




}
	
/////////////////////////////
getBuildingFilterAddSpace();

});
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

  addSpace.directive('ckEditor', function () {
  return {
    require: '?ngModel',
    link: function (scope, elm, attr, ngModel) {
      var ck = CKEDITOR.replace(elm[0]);
      if (!ngModel) return;
      ck.on('instanceReady', function () {
        ck.setData(ngModel.$viewValue);
      });
      function updateModel() {
        scope.$apply(function () {
          ngModel.$setViewValue(ck.getData());
        });
      }
      ck.on('change', updateModel);
      ck.on('key', updateModel);
      ck.on('dataReady', updateModel);

      ngModel.$render = function (value) {
        ck.setData(ngModel.$viewValue);
      };
    }
  };
});

addSpace.directive('numberMask', function() {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            $(element).numeric();
        }
    }
});