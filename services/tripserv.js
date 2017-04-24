angular.module('store').factory('tripService', function($http) {
    var apiPath = 'api.php';
    var service = {
        getCustomQuery: function(query, data) {
            return $http.get(apiPath+query+data).then(function(resp) {
                return resp.data;
            });
        },
        getLastTrips: function() {
            return $http.get(apiPath).then(function(resp) {
                return resp.data;
            });
        },
        getListDestSearch: function(dest) {
            return $http.get(apiPath+'?q=listDestSearch&dest='+dest).then(function(resp) {
                return resp.data;
            });
        },
        getDataDest: function(dest) {
            return $http.get(apiPath+'?q=dataDest&dest='+dest).then(function(resp) {
                return resp.data;
            });
        },
        getListDestAvail: function(dest) {
            return $http.get(apiPath+'?q=listDestAvail&dest='+dest).then(function(resp) {
                return resp.data;
            });
        },
        getDataDestSearch: function(dest) {
            return $http.get(apiPath+'?q=dataDestSearch&dest='+dest).then(function(resp) {
                return resp.data;
            });
        },
        getListDestAvailSearch: function(dest) {
            return $http.get(apiPath+'?q=listDestAvailSearch&dest='+dest).then(function(resp) {
                return resp.data;
            });
        },
        getDataDestAvail: function(dest, avail) {
            return $http.get(apiPath+'?q=dataDestAvail&dest='+dest+'&avail='+avail).then(function(resp) {
                return resp.data;
            });
        },
        getDataDestAvailSearch: function(dest, avail) {
            return $http.get(apiPath+'?q=dataDestAvailSearch&dest='+dest+'&avail='+avail).then(function(resp) {
                return resp.data;
            });
        },
        getDataDestID: function(dest) {
            return $http.get(apiPath+'?q=dataDestID&id='+dest).then(function(resp) {
                return resp.data;
            });
        }
    };
    return service;
});

angular.module('store').factory('caldateService', function() {
    var timeshow = false;
    var service = {
        getAvailDates: function(data, date) {
            var dpDate = data.date;
            var dpMode = data.mode;
            function areDatesEqual(date1, date2) {
                var comp1 = date1.getFullYear()+"-"+date1.getMonth()+"-"+date1.getDate();
                var comp2 = date2.getFullYear()+"-"+date2.getMonth()+"-"+date2.getDate();
                return (comp1 === comp2);
            }
            var isAvail = true;
            for(var i = 0; i < date.length ; i++) {
                if(areDatesEqual(new Date(date[i]), dpDate)){
                    isAvail = false;
                }
            }
            return ( dpMode === 'day' && isAvail );
        },
        getTimeshow: function(data) {
            return timeshow;
        },
        setTimeshow: function(data) {
            timeshow = data;
        }
    };
    return service;
});