<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\User;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
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

<?php $this->beginBody();

// Überprüfen ob angemeldet (ansonsten Fehlermeldung bei identity-Auswertung)
$kalender =	"";	
if(!Yii::$app->user->isGuest){		
	if(Yii::$app->user->identity->pw_check() && Yii::$app->user->identity->role >= 60){
		$kalender1 = Nav::widget([
		'items' => [	
		['label' => 'Urlaubsantrag', 'url' => ['/urlaub/antrag']],
		['label' => 'Kalender', 'url' => ['/urlaub/kalender']],
		['label' => 'Manager','url' => ['/urlaub/manager']],
		['label' => 'Schichtplaner', 'url' => ['/urlaub/schicht']],
		['label' => 'Verwaltung', 'url' => ['/urlaub/verwaltung']],
		['label' => 'Abrechnung', 'url' => ['/urlaub/abrechnung']]
		],
		]);
	}

	
	else if(Yii::$app->user->identity->pw_check() && Yii::$app->user->identity->role >= 50){
		$kalender1 = Nav::widget([
		'items' => [	
		['label' => 'Urlaubsantrag', 'url' => ['/urlaub/antrag']],
		['label' => 'Kalender', 'url' => ['/urlaub/kalender']],
		['label' => 'Manager','url' => ['/urlaub/manager']],
		['label' => 'Schichtplaner', 'url' => ['/urlaub/schicht']],
		['label' => 'Verwaltung', 'url' => ['/urlaub/verwaltung']],
		],
		]);
	}	
	else if(Yii::$app->user->identity->pw_check() && Yii::$app->user->identity->role >= 10){
		$kalender1 = Nav::widget([
		'items' => [	
		['label' => 'Urlaubsantrag', 'url' => ['/urlaub/antrag']],
		['label' => 'Kalender', 'url' => ['/urlaub/kalender']],
		],
		]);
	}	
	
}
else {
	$kalender1 = Nav::widget([
		'items' => [	
		['label' => 'Kalender', 'url' => ['/urlaub/kalender']],
		],
		]);
} 
 ?>
    <div class="wrap">
        <?php
            include_once "navbar.php";
        ?>

        <div class="container" >
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <div class="col-lg-2">
				  <?php 
					echo $kalender1;
			
            ?>

				
            </div>
            <div class="col-lg-10">
            <?= $content ?>
            </div>
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
