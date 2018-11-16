<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\M3ProjektCheckliste */
/* @var $form yii\widgets\ActiveForm */
?>



<?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL, 'formConfig'=>['labelSpan'=>4]]); ?>

<div class="m3-projekt-form">
<div class="panel panel-info">
  <div class="panel-heading">Allgemeine Informationen</div>
  <div class="panel-body">
	  
	  <?php
		echo Form::widget([ // fields with labels
			'model'=>$model,
			'form'=>$form,
			'columns'=>2,
			'attributes'=>[
				'Projekt'=>['label'=>'Projekt:'],
				'Kunde'=>['label'=>'Kunde:', 'options'=>['placeholder'=>'Kunde...']],
			]
		]);

	  ?>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-body">
	<div class="col-md-1"></div>	
    <div class="form-group">
        <?= Html::submitButton('Speichern', ['class' => 'btn btn-success']) ?>
    </div>
  </div>
</div>


    <?php ActiveForm::end(); ?>

</div>



