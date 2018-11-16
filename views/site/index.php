<?php
/* @var $this yii\web\View */
$this->title = 'm3profile Intranet';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Zusatzanwendungen</h1>

        <p class="lead">...der m3profile GmbH</p>
		<?php if (Yii::$app->user->isGuest) :  ?>
        <p><a class="btn btn-lg btn-success" href="index.php?r=site/login">Login</a></p>
        <?php endif; ?>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-6">
                <h2>Artikel R&uuml;ckmeldung</h2>

                <p>Hier gelangt man direkt zur Artikelr&uuml;ckmeldung. Es ist keine Anmeldung notwendig.</p>

                <p><a class="btn btn-default" href="index.php?r=bde/index&status=0">Artikel R&uuml;ckmeldung &raquo;</a></p>
            </div>
            <div class="col-lg-6">
                <h2>Berichtswesen</h2>

                <p>Zusatzberichte wie Planungslisten, Kontraktauszüge und sonstige Auswertungen können hier aufgerufen werden.</p>

                <p><a class="btn btn-default" href="index.php?r=bericht">Berichte &raquo;</a></p>
            </div>
           <!--<div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>-->
        </div>

    </div>
</div>
