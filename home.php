<div ng-show="isLoading" class="loader text-center">
    <h1>Sto Cercando...</h1>
    <i class="fa fa-spinner fa-spin fa-5x"></i>
</div>
<div ng-cloak class="home row" ng-show="isHome">
    <div class="home-carousel">
        <div uib-carousel active="carActive" interval="carInterval" no-wrap="false" template-url="tmpl/carousel.html">
            <div uib-slide ng-repeat="slide in carSlides track by slide.id" index="slide.id">
                <a ng-href="{{slide.link}}">
                <img ng-src="{{slide.image}}" style="margin:auto;">
                <div class="carousel-caption">
                    <h1 class="text-uppercase">{{slide.text}}</h1>
                    <p></p>
                </div>
                </a>
            </div>
        </div>
    </div>
    <?php
    $apiurl = 'http://www.sebagallo.eu/anjs/api.php';
    $apicontent = file_get_contents($apiurl);
    $apijson = json_decode($apicontent, true);
    foreach($apijson as $trip) {
        $datef = strftime("%A %e %B %Y", strtotime($trip[avail]));
        echo
        "<div class='col-xs-12 col-sm-6 col-md-4 hometrip'>
            <div class='innertrip' style='background:url($trip[img_path])'>
                <div class='tripcontent text-center'>
                    <h2><strong>$trip[dest]</strong></h2>
                    <p class='small'>$trip[resort]</p>
                    <h3>da $datef</h3>
                    <h3>$trip[durata] notti - <strong>$trip[prezzo] €</strong></h3>
                    <p class='pull-right'><button class='btn btn-primary'>Prenota Ora!</button></p>
                </div>
            </div>
        </div>";
    }
    ?>
</div>
<div ng-cloak ng-hide="isLoading || isHome" class="row trips" ng-repeat="trip in trips">
    <div trip></div>
</div>