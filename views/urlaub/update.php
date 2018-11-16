<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Urlaub */

$this->title = 'Update Urlaub: ' . $model->NAME;
$this->params['breadcrumbs'][] = ['label' => 'Urlaubs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->NAME, 'url' => ['view', 'id' => $model->LBNO]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="urlaub-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
