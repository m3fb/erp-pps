<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
use kartik\widgets\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\M3_zeiten */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="m3-zeiten-form">

    <?php $form = ActiveForm::begin(); ?>

  

    <?= $form->field($model, 'MSTIME')->widget(DateTimePicker::classname(),[
      	'options' => ['placeholder' => 'Datum & Zeit eingeben ...'],
	'pluginOptions' => [
		'autoclose' => true
	]
    ]);
	?> 
    <?= $form->field($model, 'PERSNAME')->textInput() ?>

    <?= $form->field($model, 'PERSNO')->textInput() ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <?= $form->field($model, 'WORKID')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
