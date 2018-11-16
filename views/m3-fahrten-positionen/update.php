<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\M3FahrtenPositionen */
$name = Yii::$app->user->identity->firstname.' '.Yii::$app->user->identity->surename;
$this->title = 'Fahrt erfassen für '.$name;
$this->title = 'Aktualisierung Fahrten für '.$name;
#$this->params['breadcrumbs'][] = ['label' => 'M3 Fahrten Positionens', 'url' => ['index']];
#$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
#$this->params['breadcrumbs'][] = 'Update';
?>
<div class="m3-fahrten-positionen-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
