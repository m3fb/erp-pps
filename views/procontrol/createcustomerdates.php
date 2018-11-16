<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\M3Termine */


$this->params['breadcrumbs'][] = ['label' => 'Kundentermine', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="m3-termine-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_customerdateform', [
        'model' => $model,
    ]) ?>

</div>
