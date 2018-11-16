<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;


/* @var $this yii\web\View */
/* @var $model app\models\M3ProjektCheckliste */

$this->title = 'm3-Projekt';
$this->params['breadcrumbs'][] = ['label' => 'm3-Projekt', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="m3-projekt-create">
<div class="panel panel-primary">
  <div class="panel-heading"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i>', ['index'],['type' => 'button', 'class' => 'btn btn-primary']).' '.Html::encode($this->title) ?></div>
	
</div>

<?php if ($openChecklists): ?>	
   <?php $form = ActiveForm::begin([
			'id'=> 'project_id',
			'method' => 'get',
			'type' => ActiveForm::TYPE_HORIZONTAL,
			'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL],
			'options' => ['class' => 'form-horizontal'],
			'action' => Url::to(['projekt/create-project2']),
		]);	?>

	<div class="form-group kv-fieldset-inline">		
		<div class="col-lg-3">
		<?= Select2::widget([
				'name' => 'checklist_id',
				#'value' => $wp_name, // initial value
				'data' => ArrayHelper::map($openChecklists,'ID','Checklist_info'),
				'options' => ['placeholder' => 'Checkliste auswählen ...','onchange' => 'this.form.submit()'],
				'pluginOptions' => [
					'allowClear' => true
				],				
			 ]);?>
		</div> 
	
		<?php ActiveForm::end(); ?>
		
	</div>
<?php else: ?>
	<div class="alert alert-warning" role="alert"><?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i>', ['index'],['type' => 'button', 'class' => 'btn btn-warning']) ?> Keine offene Checkliste vorhanden! </div>
<?php endif; ?>

</div>
