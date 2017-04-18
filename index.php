<!DOCTYPE html>
<?php setlocale(LC_ALL, 'it_IT.utf8', 'ita'); ?>
<html ng-app="store" lang="it-IT">

<head>
    <title>AngularTrips</title>
    <link rel="stylesheet" href="style.css?v=3">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/github-fork-ribbon-css/0.2.0/gh-fork-ribbon.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <link rel="shortcut icon" href="http://www.sebagallo.eu/favicon.ico" type="image/x-icon">
</head>

<body ng-controller="TravelCtrl">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" ng-click="isCollapsed = !isCollapsed">
                    <span class="sr-only">Abilita Nav</span>
                    <span class="icon-bar">&nbsp;</span>
                    <span class="icon-bar">&nbsp;</span>
                    <span class="icon-bar">&nbsp;</span>
                </button>
                <a class="navbar-brand" ng-click="returnHome()" href="#"><span class="fa fa-plane">&nbsp;</span>AngularTrips</a>
            </div>
            <div class="collapse navbar-collapse" uib-collapse="isCollapsed">
                <form class="navbar-form navbar-left" role="search" ng-submit="onSearchSubmit(selectedDest, 'search')">
                    <div class="form-group">
                        <input type="text" autocomplete="off" placeholder="Seleziona destinazione..." ng-model="selectedDest" uib-typeahead="dest for dest in asyncTA($viewValue) | limitTo:5" class="form-control" typeahead-on-select="onSearchSubmit($item, 'select')" typeahead-focus-first="false" typeahead-loading="loadingDests" typeahead-no-results="noResults">
                        <i ng-show="loadingDests" class="fa fa-refresh fa-spin"></i><i ng-show="noResults"><i class="fa fa-remove"></i> Nessuna destinazione trovata...</i>
                    </div>
                </form>
                <form class="navbar-form navbar-left" ng-show="timeshow">
                    <div class="form-group">
                        <input ng-hide="true" type="text" class="form-control" uib-datepicker-popup ng-model="selectedAvail" is-open="dpPopup.opened" datepicker-options="dpOptions" ng-required="true" placeholder="Seleziona data" ng-change="onSelectDate(selectedAvail)" datepicker-popup-template-url="popup.html">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default" ng-click="dpOpen()">Seleziona Data <i class="fa fa-calendar"></i></button>
                        </span>
                    </div>
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="http://www.sebagallo.eu">SG 2017</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div style="height:50px"></div>
        <div ng-cloak ng-show="isLoading" class="loader text-center">
            <h3>Sto Cercando...</h3>
            <i class="fa fa-spinner fa-spin fa-5x"></i>
            <!-- <img class="img-responsive" src="images/loader.gif" alt="Sto Caricando..."> -->
        </div>
        <div class="home row" ng-show="isHome">
            <?php
            $apiurl = 'http://www.sebagallo.eu/anjs/api.php';
            $apicontent = file_get_contents($apiurl);
            $apijson = json_decode($apicontent, true);
            foreach($apijson as $trip) {
                $datef = strftime("%A %e %B %Y", strtotime($trip[avail]));
                echo
                "<div class='col-xs-12 col-md-4 hometrip'>
                    <div class='innertrip' style='background:url($trip[img_path])'>
                        <div class='tripcontent text-center'>
                            <h2><strong>$trip[dest]</strong></h2>
                            <p class='small'>$trip[resort]</p>
                            <h3>da $datef<h3>
                            <h3>$trip[durata] notti - <strong>$trip[prezzo] €</strong></h3>
                            <p class='pull-right'><button class='btn btn-primary'>Prenota Ora!</button></p>
                        </div>
                    </div>
                </div>";
            }
        ?>
        </div>
        <div ng-cloak ng-hide="isLoading || isHome" class="row trips" ng-repeat="trip in trips">
            <div class="col-xs-12 col-md-3 text-center">
                <img class="img-responsive img-circle" alt="{{ trip.resort }}" ng-src="{{ trip.img_path }}">
                <h3>{{ trip.avail | date:'fullDate' }}</h3>
            </div>
            <div class="col-xs-12 col-md-6 text-justify">
                <h3><strong>{{ trip.dest + " - " + trip.resort }}</strong></h3>
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
        <div style="height:50px"></div>
    </div>
    <a class="github-fork-ribbon right-bottom fixed" href="https://github.com/sebagallo/angulartrips" title="Github Source">Esamina Source su Github</a>
    <!-- LIBRARIES REMOTE -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-i18n/1.6.4/angular-locale_it-it.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-animate.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-touch.min.js"></script> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/2.5.0/ui-bootstrap-tpls.min.js"></script>
    <!-- LIBRARIES LOCAL -->
    <!-- SCRIPTS -->
    <!-- <script src="jq.js"></script> -->
    <script src="angapp.js"></script>
</body>

</html>
