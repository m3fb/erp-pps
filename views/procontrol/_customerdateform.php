<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\M3Termine */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="m3-termine-form">

    <?php $form = ActiveForm::begin(); 
    
echo '<label>Start</label>';

echo DateTimePicker::widget([
    'name' => 'M3Termine[START]',
    'type' => DateTimePicker::TYPE_INPUT,
    'value' => date('d.m.Y H:i'),
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'dd.M.yyyy hh:ii',
        'startDate' => date('Y-m-d H:i:s'),
    ]
]);
echo '<label>Ende</label>';
echo DateTimePicker::widget([
    'name' => 'M3Termine[ENDE]',
    'type' => DateTimePicker::TYPE_INPUT,
    'value' => date('d.m.Y H:i'),
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'dd-M-yyyy hh:ii',
        'startDate' => date('Y-m-d H:i:s'),
    ]
]);
?>



    <?= $form->field($model, 'TITEL')->textInput() ?>

    <?= $form->field($model, 'pruef')->hiddenInput([ 'value' => 99])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Speichern' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
