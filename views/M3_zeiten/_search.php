<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\M3_zeitenSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="m3-zeiten-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'MSTIME') ?>

    <?= $form->field($model, 'PERSNAME') ?>

    <?= $form->field($model, 'PERSNO') ?>

    <?= $form->field($model, 'STATUS') ?>

    <?php // echo $form->field($model, 'WORKID') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
