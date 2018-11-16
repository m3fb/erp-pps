<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/*
 * Layout für Dashboards
 * Im Controller können folgende Parameter definiert werden:
 * 
 * Hintergrundfarbe Navigation.
 * $this->view->params['nav_background'] = '#ffffff';
 * 
 * Schriftfarbe im Navigationsbereich.
 * $this->view->params['nav_color'] = '#000000';
 * 
 * Überschrift / Titel
 * $this->view->params['nav_header'] = 'Meine Überschrift';
 * 
 * Hyperlink für Überschrift / Titel
 * $this->view->params['nav_URL'] = '/procontrol/index';
 * 
 * #Seite Neuladen nach Timeout z.B. 30.000 = 5Min.
 * reload deaktivieren = 0 oder NULL
 * $this->view->params['reload'] = '30000' 
*/

if ($this->params['nav_background']){
	$this->registerCss(".my-navbar { background-color: ".$this->params['nav_background'].";
	}");
}
if ($this->params['nav_color']){
	$this->registerCss(".my-navbar { color: ".$this->params['nav_color'].";
	}");
}

if ($this->params['reload'] > 500){
	$js = 'setTimeout("location.reload();",'.$this->params['reload'].');';
	$this->registerJs($js, $this::POS_READY);
}

$this->registerJsFile(
    '@web/live_clock.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);


AppAsset::register($this);

setlocale(LC_ALL, 'de_DE@euro', 'de_DE', 'deu_deu');
?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body onload="clock_update('myclock');">

<?php $this->beginBody() ?>
    <div class="wrap">
		<?php
			NavBar::begin([
					'brandLabel' => 'm3profile GmbH',
					'brandUrl' => [$this->params['nav_URL']],
					'brandOptions'=>['style' => 'color: '.$this->params['nav_color'].';'],
					'options' => [
						'class' => 'my-navbar navbar-fixed-top',
					],
				]);
		?>
			<p class="navbar-brand "><?php echo $this->params['nav_header'] ?></p>
			<p class="navbar-text "><span id="myclock"></span></p>
		<?php
			
			NavBar::end();
		?>

        <div class="container-fluid" style="margin-top:80px;">
			
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; m3profile Gmbh <?= date('Y') ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
