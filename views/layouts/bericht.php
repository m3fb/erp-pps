<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

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

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            include_once "navbar.php";
        ?>

        <div class="container" >
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <div class="col-lg-2">
            <?= Nav::widget([
				'items' => [
					[
						'label' => 'Auftr.bearb.',
						'items' => [
							 ['label' => 'Übersicht Kaufteile', 'url' => ['/bericht/kaufteile','kaufteil_no'=>'']],
							 '<li class="divider"></li>',
							 #'<li class="dropdown-header">offene Bestellungen</li>',
							 ['label' => 'Sped.auftr.verwaltung', 'url' => ['/bericht/spedverw']],
							 ['label' => 'Belege schließen', 'url' => ['/bericht/beleg']],
						],
					],
					[
						'label' => 'Logistik',
						'items' => [
							 ['label' => 'Lieferrückstandsliste', 'url' => ['/bericht/rueckstand','type'=>'delivery']],
							 ['label' => 'Bestellrückstandsliste', 'url' => ['/bericht/rueckstand','type'=>'order']],
							 #['label' => 'Mehrfachlager', 'url' => ['/bericht/mehrfachlager']], //Deaktivierung mit Einführung der 
						],
					],
					[
						'label' => 'Planung',
						'items' => [
							 ['label' => 'Planungsliste', 'url' => ['/bericht/planungsliste' ,'wp_name'=>'','plan_time'=>'']]
							 
						],
					],
					[
						'label' => 'QS',
						'items' => [
							 ['label' => 'Artverwandte Produkte', 'url' => ['/bericht/artverwandt' ]],
						],
					],
				],
			])
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
