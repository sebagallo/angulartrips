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
            url: '/search/:dest/:avail',
            controller: 'SearchCtrl',
            templateUrl: 'views/search.html',
            resolve: {
                srcData: function(tripService, $stateParams) {
                    if (tripService.getQMethod == 'select') return tripService.getDataDest($stateParams.dest);
                    else return tripService.getDataDestSearch($stateParams.dest);
                },
                srcAvail: function(tripService, $stateParams) {
                    if (tripService.getQMethod == 'select') return tripService.getListDestAvail($stateParams.dest);
                    else return tripService.getListDestAvailSearch($stateParams.dest);
                },
                srcDate: function(tripService, $stateParams) {
                    if ($stateParams.avail) {
                        if (tripService.getQMethod == 'select') return tripService.getDataDestAvail($stateParams.dest, $stateParams.avail);
                        else return tripService.getDataDestAvailSearch($stateParams.dest, $stateParams.avail);
                    }
                }
            }
        };
        var tripState = {
            name: 'trip',
            url: '/trip/:id',
            controller: 'TripCtrl',
            templateUrl: 'views/trip.html',
            resolve: {
                tripdet: function(tripService, $stateParams) {
                    return tripService.getDataDestID($stateParams.id);
                }
            }
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

    app.controller('TripCtrl', function(tripdet, $scope) {
        $scope.tripdet = tripdet;
    });

    app.controller('SearchCtrl', function(srcData, srcAvail, srcDate, caldateService, $scope) {
        if (srcDate) {
            $scope.trips = srcDate;
        }
        else {
            $scope.trips = srcData;
        }
        $scope.avails = srcAvail;
        if ($scope.avails.length > 0) {
            $scope.dpOptions.initDate = new Date($scope.avails[0]);
            $scope.dpOptions.dateDisabled = function(data, date) {
                return caldateService.getAvailDates(data, $scope.avails);
            };
            caldateService.setTimeshow(true);
        }
        else {
            caldateService.setTimeshow(false);
        }
    });

    app.controller('TravelCtrl', function($scope, $state, tripService, caldateService) {
        $scope.$on('$stateChangeStart', function(event, toState, toParams, fromState, fromParams) {
            $scope.isLoading = true;
            $scope.isCollapsed = true;
        });
        $scope.$on('$stateChangeSuccess', function(event, toState, toParams, fromState, fromParams) {
            $scope.isLoading = false;
        });
        $scope.qMethod ="";
        $scope.dest = "";
        $scope.avails = "";
        $state.go('home');
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
            $scope.timeshow = false;
        };
        $scope.asyncTA = function(dest) {
            return tripService.getListDestSearch(dest);
        };
        $scope.onSearchSubmit = function($item, method) {
            $scope.isCollapsed = true;
            $scope.dest = $item;
            $scope.qMethod = method;
            tripService.setQMethod($scope.qMethod);
            $scope.timeshow = caldateService.getTimeshow;
            $state.go('search', {'dest': $scope.dest, 'avail': ''});
        };
        $scope.onSelectDate = function($item) {
            $scope.isCollapsed = true;
            $item.setDate($item.getDate() + 1);
            $scope.date = $item.toISOString().substring(0, 10);
            $state.go('search', {'dest': $scope.dest, 'avail': $scope.date});
        };
    });
})();