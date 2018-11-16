<?php

use yii\helpers\Html;
#use yii\widgets\ActiveForm;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\M3UrlaubStunden */
/* @var $form yii\widgets\ActiveForm */
$currentYear = date("Y");
?>

<?php 
$formfield = function($form,$model,$v)  //Formfelder formatieren; 
	{
		echo $form->field($model, $v,['inputOptions' => ['value' => $model->$v]])->textInput();
	}
?>

<div class="m3-urlaub-stunden-form">


    <?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'WORKID')->hiddenInput(['value' => $id])->label(false) ?>
<div class="row">
    <div class="col-md-12">

					<div class="col-md-3">
						<?= $form->field($model, 'JAHR')->textInput(['placeholder'=>'Wert zwischen ' .($currentYear-1) . ' und ' .($currentYear+1)]) ?>
					</div>
					<div class="col-md-3">
						
					</div>

            </div>
    </div>
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-success">
            <div class="panel-heading">Überstunden</div>
                <div class="panel-body">
					<div class="col-md-6">
						
						<?php for ($i=1;$i<7;$i++): ?>						
						
						<?= $formfield($form,$model,'S'.$i) ?>
						
						<?php	endfor ?>
						
					</div>
					<div class="col-md-6">
						<?php for ($i=7;$i<13;$i++): ?>						
						
						<?= $formfield($form,$model,'S'.$i) ?>
						
						<?php	endfor ?>
					</div>
                </div>
            </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading">Urlaub</div>
                <div class="panel-body">
					<div class="col-md-6">
						<?php for ($i=1;$i<7;$i++): ?>						
						
						<?= $formfield($form,$model,'U'.$i) ?>
						
						<?php	endfor ?>
					</div>
					<div class="col-md-6">
						<?php for ($i=7;$i<13;$i++): ?>						
						
						<?= $formfield($form,$model,'U'.$i) ?>
						
						<?php	endfor ?>
					</div>
                </div>
            </div>
    </div>
</div>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Erstellen' : 'Speichern', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
