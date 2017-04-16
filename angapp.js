(function () {
	var app = angular.module('store', ['ngAnimate', 'ngSanitize', 'ui.bootstrap']);

	app.controller('TravelCtrl', function($scope, $http) {
		$http.get('api.php').then(function(data){
			$scope.trips = data.data;
		});
		// var _selectedDest;
		// $scope.selectedDest = undefined;
        // $http.get('api.php?q=listDest').then(function(data) {
        //     $scope.destinations = data.data;
        // });
        $scope.asyncTA = function(val) {
        	return $http.get('api.php?q=listDestSearch&dest=', {
        	      params: {
        	        dest: val,
        	      }
        	    }).then(function(data){
        	      return data.data;
        	      });
        };
        $scope.onSelectTA = function($item,$model,$label) {
            $scope.dest = $item;
            $http.get('api.php?q=dataDest&dest='+$scope.dest).then(function(data){
            	$scope.trips = data.data;
            });
            $scope.timeshow = true;
            $http.get('api.php?q=listDestAvail&dest='+$scope.dest).then(function(data){
            	$scope.avails = data.data;
            });
        };
        $scope.onSearchSubmit = function($item) {
            $scope.dest = $item;
            $http.get('api.php?q=dataDestSearch&dest='+$scope.dest).then(function(data){
            	$scope.trips = data.data;
            });
            $scope.timeshow = true;
            $http.get('api.php?q=listDestAvailSearch&dest='+$scope.dest).then(function(data){
            	$scope.avails = data.data;
            });
        };
        $scope.onSelectDate = function($item) {
        	$scope.date = $item;
        	$http.get('api.php?q=dataDestAvailSearch&dest='+$scope.dest+'&avail='+$scope.date).then(function(data){
        		$scope.trips = data.data;
        	});
        };
     });
})();