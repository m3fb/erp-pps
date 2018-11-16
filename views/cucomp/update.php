<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cucomp */

$this->title = 'Update Cucomp: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Cucomps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->NAME, 'url' => ['view', 'id' => $model->CONO]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cucomp-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
