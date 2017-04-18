(function () {
    var app = angular.module('store', ['ngAnimate', 'ngSanitize', 'ui.bootstrap']);

    app.controller('TravelCtrl', function($scope, $http) {
        $scope.isLoading = undefined;
        $scope.isHome = true;
        $scope.qMethod = undefined;
        $scope.dest = undefined;
        $scope.avail = undefined;
        // $http.get('api.php').then(function(data){
        //     $scope.trips = data.data;
        // });
        // NOT-ASYNC METHOD
        // $http.get('api.php?q=listDest').then(function(data) {
        //     $scope.destinations = data.data;
        // });
        // $scope.dpOpen = function() {
        //    $scope.dpPopup.opened = true;
        //  };
        //  $scope.dpPopup = {
        //    opened: false
        //  };
        //  $scope.dpOptions = {
        //      showWeeks: false,
        //  };
        $scope.returnHome = function () {
            $scope.isHome = true;
        };
        $scope.asyncTA = function(val) {
            return $http.get('api.php?q=listDestSearch&dest='+val).then(function(data){
                  return data.data;
            });
        };
        $scope.onSearchSubmit = function($item, method) {
            $scope.isLoading = true;
            $scope.isHome = false;
            $scope.qMethod = method;
            if ($scope.qMethod == 'select') {
                $scope.query1 = 'api.php?q=dataDest&dest=';
                $scope.query2 = 'api.php?q=listDestAvail&dest=';
            }
            if ($scope.qMethod == 'search') {
                $scope.query1 = 'api.php?q=dataDestSearch&dest=';
                $scope.query2 = 'api.php?q=listDestAvailSearch&dest=';
            }
            $scope.dest = $item;
            $http.get($scope.query1+$scope.dest).then(function(data){
                $scope.trips = data.data;
            });
            $http.get($scope.query2+$scope.dest).then(function(data){
                $scope.avails = data.data;
                if ($scope.avails.length > 0) {
                    $scope.timeshow = true;
                }
                else{
                    $scope.timeshow = false;
                }
            }).finally(function() {
                $scope.isLoading = false;
            });
        };
        $scope.onSelectDate = function($item) {
            $scope.isLoading = true;
            $scope.isHome = false;
            $scope.date = $item;
            if ($scope.qMethod == 'select') {
                $scope.query3 = 'api.php?q=dataDestAvail&dest=';
            }
            if ($scope.qMethod == 'search') {
                $scope.query3 = 'api.php?q=dataDestAvailSearch&dest=';
            }
            $http.get($scope.query3+$scope.dest+'&avail='+$scope.date).then(function(data){
                $scope.trips = data.data;
            }).finally(function() {
                $scope.isLoading = false;
            });
        };
     });
})();