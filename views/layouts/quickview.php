<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;


if ($this->params['reload'] > 500){
	$js = 'setTimeout("location.reload();",'.$this->params['reload'].');';
	$this->registerJs($js, $this::POS_READY);
}


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

<?php $this->beginBody() ?>
    <div class="wrap">
				<div class="container" >
            <?= $content ?>
        </div>
    </div>



<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>
