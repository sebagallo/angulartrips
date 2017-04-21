(function () {
    var app = angular.module('store', ['ngAnimate', 'ui.bootstrap']);

    app.controller('TravelCtrl', function($scope, $http) {
        $scope.isLoading = undefined;
        $scope.isHome = true;
        $scope.qMethod = undefined;
        $scope.dest = undefined;
        $scope.avails = undefined;
        $scope.isCollapsed = true;
        //carousel
        $scope.carActive = 0;
        $scope.carInterval = 6000;
        $scope.carIndex = 0;
        $scope.carSlides = [
            {
                image: 'https://i.ytimg.com/vi/DGIXT7ce3vQ/maxresdefault.jpg',
                text: 'Maldive',
                id: $scope.carIndex++
            },
            {
                image: 'https://azure.luxresorts.com/media/3040876/Hotel-In-Mauritius-LUX-Le-Morne-Beach-Resort.jpg',
                text: 'Mauritius',
                id: $scope.carIndex++
            },
            {
                image: 'https://www.secretcanaries.com/wp-content/uploads/2017/01/Gran-Canaria-1.jpg',
                text: 'Canarie',
                id: $scope.carIndex++
            },
            {
                image: 'http://8-themes.com/wp-content/uploads/2015/12/cbefd1792723c4adddf557ad89a5122b-1280x720.jpg',
                text: 'Alpi',
                id: $scope.carIndex++
            }
        ];
        //carousel-end
        //datepicker
        $scope.dpOpen = function() {
            $scope.dpPopup.opened = true;
        };
            $scope.dpPopup = {
                opened: false
        };
            $scope.dpOptions = {
                showWeeks: false
        };
        $scope.returnHome = function () {
            $scope.isHome = true;
            $scope.timeshow = false;
        };
        $scope.asyncTA = function(val) {
            return $http.get('api.php?q=listDestSearch&dest='+val).then(function(data){
                  return data.data;
            });
        };
        //datepicker-end
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
                    //datepicker calendar
                    $scope.dpOptions.initDate = new Date($scope.avails[0]);
                    $scope.dpOptions.dateDisabled = function (data) {
                        var dpDate = data.date;
                        var dpMode = data.mode;
                        function areDatesEqual(date1, date2) {
                            var comp1 = date1.getFullYear()+"-"+date1.getMonth()+"-"+date1.getDate();
                            var comp2 = date2.getFullYear()+"-"+date2.getMonth()+"-"+date2.getDate();
                            return (comp1 === comp2);
                        }
                        var isAvail = true;
                            for(var i = 0; i < $scope.avails.length ; i++) {
                                if(areDatesEqual(new Date($scope.avails[i]), dpDate)){
                                    isAvail = false;
                                }
                            }
                            return ( dpMode === 'day' && isAvail );
                        };
                    //datepicker calendar end
                    $scope.timeshow = true;
                }
                else{
                    $scope.timeshow = false;
                }
            }).finally(function() {
                $scope.isLoading = false;
                $scope.isCollapsed = true;
            });
        };
        $scope.onSelectDate = function($item) {
            $scope.isLoading = true;
            $scope.isHome = false;
            $item.setDate($item.getDate() + 1);
            $scope.date = $item.toISOString().substring(0, 10);
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
                $scope.isCollapsed = true;
            });
        };
    });
    app.directive('trip', function() {
        return {
            restrict: 'AE',
            templateUrl: 'tmpl/trip.html'
        };
    });
})();