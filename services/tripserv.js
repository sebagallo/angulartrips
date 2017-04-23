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
        },
    };
    return service;
});
