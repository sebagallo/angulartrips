<?php
require('includes/header.php');
include('includes/nav.php');
?>
<div class="row">
    <div class="col-xs-12 ui-view-container">
        <div ng-hide="isLoading" ui-view class="main-view"></div>
    </div>
</div>
<?php
require('includes/footer.php');
?>