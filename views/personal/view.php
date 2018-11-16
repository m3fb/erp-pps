<?php

use yii\helpers\Html;
#use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model app\models\Personal */

$this->title = $model->FIRSTNAME.' '.$model->SURNAME;
#$this->params['breadcrumbs'][] = ['label' => 'Personals', 'url' => ['index']];
#$this->params['breadcrumbs'][] = $this->title;

?>
<div class="personal-view">

    <h1><?= Html::encode($this->title) ?></h1>

	    <?= $this->render('_stammdaten', [
              'model' => $model,
          ]) ?>

    	<?= $this->render('_zusInfos', [
              'zusInfo' => $zusInfo,
          ]) ?>

    <?= $this->render('_wlan', [
              'userModel' => $userModel,
        ]) ?>
    <?= $this->render('_krank', [
              'krank' => $krank,
        ]) ?>
    	<?= $this->render('_urlaubStunden', [
        'urlStdDataProvider' =>$urlStdDataProvider,
        'id' => $model->NO,
    ]) ?>


</div>
