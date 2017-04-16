<!DOCTYPE html>
<html ng-app="store" lang="it-IT">

<head>
    <title>AngularTrips</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/loaders.css/0.1.2/loaders.min.css"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <link rel="shortcut icon" href="http://www.sebagallo.eu/favicon.ico" type="image/x-icon">
</head>

<body ng-controller="TravelCtrl">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Abilita Nav</span>
                    <span class="icon-bar">&nbsp;</span>
                    <span class="icon-bar">&nbsp;</span>
                    <span class="icon-bar">&nbsp;</span>
                </button>
                <a class="navbar-brand" href="#"><span class="fa fa-plane">&nbsp;</span>AngularTrips</a>
            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <form class="navbar-form navbar-left" role="search" ng-submit="onSearchSubmit(selectedDest, 'search')">
                    <div class="form-group">
                        <!-- <input type="text" autocomplete="off" placeholder="Seleziona destinazione..." ng-model="selectedDest" uib-typeahead="dest for dest in destinations | filter:$viewValue | limitTo:5" class="form-control" typeahead-on-select="onSelectTA($item, $model, $label)" typeahead-focus-first="false"> -->
                        <input type="text" autocomplete="off" placeholder="Seleziona destinazione..." ng-model="selectedDest" uib-typeahead="dest for dest in asyncTA($viewValue) | limitTo:5" class="form-control" typeahead-on-select="onSearchSubmit($item, 'select')" typeahead-focus-first="false" typeahead-loading="loadingDests" typeahead-no-results="noResults">
                        <i ng-show="loadingDests" class="glyphicon glyphicon-refresh"></i><i ng-show="noResults"><i class="glyphicon glyphicon-remove"></i> Nessuna destinazione trovata...</i>
                    </div>
                </form>
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" ng-show="timeshow" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-calendar">&nbsp;</span>Seleziona Data<b class="caret">&nbsp;</b></a>
                        <ul class="dropdown-menu">
                            <li ng-repeat="avail in avails"><a href="#" ng-click="onSelectDate(avail)">{{ avail | date:'fullDate' }}</a></li>
                        </ul>
                    </li>
<!--                     <li>
                        <div class="input-group navbar-form" ng-show="timeshow">
                            <input ng-hide="true" type="text" class="form-control" uib-datepicker-popup ng-model="selectedAvail" is-open="dpPopup.opened" datepicker-options="dpOptions" ng-required="true" close-text="Chiudi" placeholder="Seleziona data">
                            <span class="input-group-btn">
                            <button type="button" class="btn btn-default" ng-click="dpOpen()">Seleziona Data <i class="fa fa-calendar"></i></button>
                        </span>
                        </div>
                    </li> -->
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="http://www.sebagallo.eu">SG 2017</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row trips" ng-repeat="trip in trips">
            <div class="col-xs-12 col-md-3 text-center">
                <img class="img-responsive img-circle" alt="{{ trip.resort }}" ng-src="{{ trip.img_path }}">
                <h3>{{ trip.avail | date:'fullDate' }}</h3>
            </div>
            <div class="col-xs-12 col-md-6 text-justify">
                <!-- <div class="loading" loader-css="ball-clip-rotate-pulse"></div> -->
                <h3>{{ trip.dest + " - " + trip.resort }}</h3>
                <p>{{ trip.txt }}</p>
            </div>
            <div class="col-xs-12 col-md-3 text-center">
                <h1>{{ trip.prezzo | currency:'€':0 }}</h1>
                <h2>{{ trip.durata + " notti!" }}</h2>
                <p>
                    <button class="btn btn-primary">Prenota Ora!</button>
                </p>
            </div>
        </div>
    </div>
    <!-- LIBRARIES REMOTE -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-i18n/1.6.4/angular-locale_it-it.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-animate.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-touch.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/2.5.0/ui-bootstrap-tpls.min.js"></script>
    <!-- LIBRARIES LOCAL -->
    <!-- <script src="angular-loaders.min.js"></script> -->
    <!-- SCRIPTS -->
    <!-- <script src="jq.js"></script> -->
    <script src="angapp.js"></script>
</body>

</html>
