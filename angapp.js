(function () {
	var app = angular.module('store', ['ngAnimate', 'ngSanitize', 'ui.bootstrap']);

	// app.controller('TravelCtrl', function($scope, $http){
	// 	// $http.get('api.php'+'?q='+'d'+'&dest='+'Maldive').then(function(data){
	// 	$http.get('api.php').then(function(data){
	// 		$scope.trips = data.data;
	// 	});
	// });

	app.controller('TravelCtrl', function($scope, $http) {
		$http.get('api.php').then(function(data){
			$scope.trips = data.data;
		});
		var _selectedDest;
		$scope.selectedDest = undefined;
        $http.get('api.php?q=dl').then(function(data) {
            $scope.destinations = data.data;
        });
        $scope.onSelectTA = function($item,$model,$label) {
            $scope.dest = $item;
            $http.get('api.php?q=d&dest='+$scope.dest).then(function(data){
            	$scope.trips = data.data;
            });
            $scope.timeshow = true;
            $http.get('api.php?q=dal&dest='+$scope.dest).then(function(data){
            	$scope.avails = data.data;
            });
        };
        $scope.onSelectDate = function($item) {
        	$scope.date = $item;
        	$http.get('api.php?q=da&dest='+$scope.dest+'&avail='+$scope.date).then(function(data){
        		$scope.trips = data.data;
        	});
        };
     });
	/*
	 * Still need to do:
	 * -typeahead (api.php?q=dls&dest=$STRING$ -- only returns matching destinations)
	 * 	-controller/directive?
	 * 	DONE!
	 *
	 * -select from searchbox-->change mainview to display only chosen destinations
	 * (api.php?q=d&dest=$STRING$)
	 *  DONE!
	 *
	 * -further refine search results by choosing a date (only doable after dest)
	 * (api.php?q=da&dest=$STRING$&avail=$STRING$)
	 *  DONE!!!!!
	 *
	 *
	 *
	 */

	// app.controller('TypeaheadCtrl', function($http){
	// 	var store = this;
	// 	store.dests = [];

	// 	var qdest='';
	// 	$http.get('api.php'+'?q='+'dls'+'&dest='+qdest).then(function(data){
	// 		store.dests = data.data;
	// 	});
	// 	$scope.search = function(){

	// 	};
	// });

})();