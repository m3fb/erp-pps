<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

$js = 'setTimeout("location.reload();",3600000);';
$this->registerJs($js, $this::POS_READY);

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
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
		<?php
			NavBar::begin([
					'brandLabel' => 'm3profile GmbH',
					'brandUrl' => Yii::$app->homeUrl,
					'options' => [
						'class' => 'navbar-inverse navbar-fixed-top',
					],
				]);
		?>
			<p class="navbar-brand ">QS-Informationen</p>
			<p class="navbar-text "><?php echo strftime("Datum: %A %d %B %Y / KW: %V / letzte Aktualisierung: %H:%M Uhr");?></p>
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
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
