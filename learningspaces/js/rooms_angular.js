var app = angular.module('learningSpaces', []);
app.controller('spacesFormCtrl', function($scope, $http) {
    

    // submit the form
	
    $scope.submitForm = function() {
		console.log($scope.formData);
    };
	
/*	$http({
        url: '/learningspaces/rooms',
        method: "POST",
        data: { 'message' : message }
    })
    .then(function(response) {
            // success
    }, 
    function(response) { // optional
            // failed
    });
*/	
	
});