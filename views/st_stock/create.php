<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\St_stock */

$this->title = 'Create St Stock';
$this->params['breadcrumbs'][] = ['label' => 'St Stocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="st-stock-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
