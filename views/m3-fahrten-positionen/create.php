<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\M3FahrtenPositionen */
$name = Yii::$app->user->identity->firstname.' '.Yii::$app->user->identity->surename;
(Yii::$app->user->identity->role >= 60) ? $this->title = 'Fahrt erfassen für Verwalter' : $this->title = 'Fahrt erfassen für '.$name;
#$this->params['breadcrumbs'][] = ['label' => 'M3 Fahrten Positionens', 'url' => ['index']];
#$this->params['breadcrumbs'][] = $this->title;
?>
<div class="m3-fahrten-positionen-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
