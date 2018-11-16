<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\M3UrlaubStundenSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="m3-urlaub-stunden-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'WORKID') ?>

    <?= $form->field($model, 'JAHR') ?>

    <?= $form->field($model, 'S1') ?>

    <?= $form->field($model, 'S2') ?>

    <?php // echo $form->field($model, 'S3') ?>

    <?php // echo $form->field($model, 'S4') ?>

    <?php // echo $form->field($model, 'S5') ?>

    <?php // echo $form->field($model, 'S6') ?>

    <?php // echo $form->field($model, 'S7') ?>

    <?php // echo $form->field($model, 'S8') ?>

    <?php // echo $form->field($model, 'S9') ?>

    <?php // echo $form->field($model, 'S10') ?>

    <?php // echo $form->field($model, 'S11') ?>

    <?php // echo $form->field($model, 'S12') ?>

    <?php // echo $form->field($model, 'U1') ?>

    <?php // echo $form->field($model, 'U2') ?>

    <?php // echo $form->field($model, 'U3') ?>

    <?php // echo $form->field($model, 'U4') ?>

    <?php // echo $form->field($model, 'U5') ?>

    <?php // echo $form->field($model, 'U6') ?>

    <?php // echo $form->field($model, 'U7') ?>

    <?php // echo $form->field($model, 'U8') ?>

    <?php // echo $form->field($model, 'U9') ?>

    <?php // echo $form->field($model, 'U10') ?>

    <?php // echo $form->field($model, 'U11') ?>

    <?php // echo $form->field($model, 'U12') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
