(function () {
    var app = angular.module('store', ['ngAnimate', 'ngTouch', 'ui.router', 'ui.bootstrap']);

    app.config(function($stateProvider) {
        var homeState = {
            name: 'home',
            url: '/',
            templateUrl: 'views/home.html',
            controller: 'HomeCtrl'
        };
        var searchState = {
            name: 'search',
            url: '/search',
            templateUrl: 'views/search.html'
        };
        var tripState = {
            name: 'trip',
            url: '/trip',
            templateUrl: 'views/trip.html'
        };
      $stateProvider.state(homeState);
      $stateProvider.state(searchState);
      $stateProvider.state(tripState);
    });

    app.controller('HomeCtrl', function($scope, tripService) {
        $scope.homeTrips = "";
        tripService.getLastTrips().then(function(data) {
            $scope.homeTrips = data;
        });
        $scope.carActive = 0;
        $scope.carInterval = 6000;
        $scope.carIndex = 0;
        $scope.carSlides = [
            {
                image: 'https://i.ytimg.com/vi/DGIXT7ce3vQ/maxresdefault.jpg',
                text: 'Prenota ora la vacanza dei tuoi sogni!',
                id: $scope.carIndex++,
                link: '#'
            },
            {
                image: 'https://azure.luxresorts.com/media/3040876/Hotel-In-Mauritius-LUX-Le-Morne-Beach-Resort.jpg',
                text: 'Scopri le nuove offerte per l\'estate 2017',
                id: $scope.carIndex++,
                link: '#'
            },
            {
                image: 'https://www.secretcanaries.com/wp-content/uploads/2017/01/Gran-Canaria-1.jpg',
                text: 'Inserisci testo ad alto impatto quì!!',
                id: $scope.carIndex++,
                link: '#'
            },
            {
                image: 'http://8-themes.com/wp-content/uploads/2015/12/cbefd1792723c4adddf557ad89a5122b-1280x720.jpg',
                text: 'Che belle slide, veramente fantastiche.',
                id: $scope.carIndex++,
                link: '#'
            }
        ];
    });

    app.controller('TravelCtrl', function($scope, $state, tripService) {
        $scope.$on('$stateChangeStart', function(event, toState, toParams, fromState, fromParams) {
            $scope.isLoading = true;
            $scope.isCollapsed = true;
        });
        $scope.$on('$stateChangeSuccess', function(event, toState, toParams, fromState, fromParams) {
            $scope.isLoading = false;
        });
        $state.go('home');
        $scope.qMethod = "";
        $scope.dest = "";
        $scope.avails = "";
        $scope.isCollapsed = true;
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
        //datepicker-end
        $scope.returnHome = function () {
            $state.go('home');
        };
        $scope.asyncTA = function(dest) {
            return tripService.getListDestSearch(dest);
        };
        $scope.onSearchSubmit = function($item, method) {
            $scope.dest = $item;
            $scope.qMethod = method;
            $state.go('search', $scope.dest);
            if ($scope.qMethod == 'select') {
                $scope.query1 = '?q=dataDest&dest=';
                $scope.query2 = '?q=listDestAvail&dest=';
            }
            if ($scope.qMethod == 'search') {
                $scope.query1 = '?q=dataDestSearch&dest=';
                $scope.query2 = '?q=listDestAvailSearch&dest=';
            }
            tripService.getCustomQuery($scope.query1, $scope.dest).then(function(data) {
                $scope.trips = data;
            });
            tripService.getCustomQuery($scope.query2, $scope.dest).then(function(data) {
                $scope.avails = data;
                if ($scope.avails.length > 0) {
                    //datepicker calendar dates
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
                    //datepicker calendar dates end
                    $scope.timeshow = true;
                }
                else {
                    $scope.timeshow = false;
                }
            });
        };
        $scope.onSelectDate = function($item) {
            $state.go('search');
            $item.setDate($item.getDate() + 1);
            $scope.date = $item.toISOString().substring(0, 10);
            if ($scope.qMethod == 'select') {
                tripService.getDataDestAvail($scope.dest, $scope.date).then(function(data) {
                    $scope.trips = data;
                });
            }
            if ($scope.qMethod == 'search') {
                tripService.getDataDestAvailSearch($scope.dest, $scope.date).then(function(data) {
                    $scope.trips = data;
                });
            }
        };
        $scope.viewTrip = function(id) {
            $state.go('trip', id);
            $scope.tripid = id;
            tripService.getDataDestID($scope.tripid).then(function(data) {
                $scope.tripdet = data;
            });
        };
    });
})();