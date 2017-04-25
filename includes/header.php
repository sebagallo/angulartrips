<!DOCTYPE html>
<html ng-app="store" lang="it-IT">

<head>
    <title>AngularTrips</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/github-fork-ribbon-css/0.2.0/gh-fork-ribbon.min.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700|Acme|Righteous" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <link rel="shortcut icon" href="http://www.sebagallo.eu/favicon.ico" type="image/x-icon">
    <!-- LIBRARIES REMOTE -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-i18n/1.6.4/angular-locale_it-it.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-animate.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-touch.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.4.2/angular-ui-router.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/2.5.0/ui-bootstrap-tpls.min.js"></script>
    <!-- LIBRARIES LOCAL -->
    <!-- APP SCRIPTS /CSS -->
    <?php
    echo '
    <link rel="stylesheet" href="style.css?v='.filemtime('style.css').'">
    <script src="angapp.js?v='.filemtime('angapp.js').'"></script>
    <script src="services/tripserv.js?v='.filemtime('services/tripserv.js').'"></script>'
    ?>
</head>

<body ng-controller="TravelCtrl">
