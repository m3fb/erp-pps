<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TodoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="todo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'department') ?>
    
    <?= $form->field($model, 'beauftragter') ?>

    <?= $form->field($model, 'due_date') ?>

    <?php // echo $form->field($model, 'create_name') ?>

    <?php // echo $form->field($model, 'change_name') ?>

    <?php // echo $form->field($model, 'create_date') ?>

    <?php // echo $form->field($model, 'change_date') ?>

    <?php // echo $form->field($model, 'due_date_option') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
