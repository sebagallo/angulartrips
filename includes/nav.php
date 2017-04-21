<nav class="navbar navbar-default navbar-fixed-top navbar-sandtheme" role="navigation">
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
        <div ng-cloak class="collapse navbar-collapse" uib-collapse="isCollapsed">
            <form class="navbar-form navbar-left" role="search" ng-submit="onSearchSubmit(selectedDest, 'search')">
                <div class="form-group">
                    <input type="text" autocomplete="off" placeholder="Seleziona destinazione..." ng-model="selectedDest" uib-typeahead="dest for dest in asyncTA($viewValue) | limitTo:5" class="form-control" typeahead-on-select="onSearchSubmit($item, 'select')" typeahead-focus-first="false" typeahead-loading="loadingDests" typeahead-no-results="noResults">
                    <i ng-show="loadingDests" class="fa fa-refresh"></i><i ng-show="noResults"><i class="fa fa-remove"></i> Nessuna destinazione trovata...</i>
                </div>
            </form>
            <form class="navbar-form navbar-left" ng-show="timeshow">
                <div class="form-group">
                    <input ng-hide="true" type="text" class="form-control" uib-datepicker-popup ng-model="selectedAvail" is-open="dpPopup.opened" datepicker-options="dpOptions" ng-required="true" placeholder="Seleziona data" ng-change="onSelectDate(selectedAvail)" datepicker-popup-template-url="tmpl/dpPopup.html">
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