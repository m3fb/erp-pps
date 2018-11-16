<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\St_stock */

$this->title = 'Update St Stock: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'St Stocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->NO, 'url' => ['view', 'id' => $model->NO]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="st-stock-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
