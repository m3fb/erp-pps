<?php

use yii\helpers\Html;
use kartik\grid\GridView;

 ini_set('mssql.charset', 'windows-1252');
/* @var $this yii\web\View */
/* @var $model app\models\Ororder */
/* @var $form yii\widgets\ActiveForm */
?>




<div class="col-sm-12">
	<?= GridView::widget([
        'dataProvider' => $model,
        'summary' => '',
		'headerRowOptions'=>['class'=>'kartik-sheet-style','style'=>'font-size:12px;'],
		'rowOptions'=>['style'=>'font-size:12px;'],
        'columns' => [
			['class' => 'kartik\grid\SerialColumn',
				'header' => 'Nr.',
				'headerOptions'=>['style'=>'width: 10px;']
			],
			[
				'attribute' => 'Titel',
			],
			[
				'attribute' => 'Planbeginn',
				'format' =>'date',
			],
			[
				'attribute' => 'PlanEnde',
				'format' =>'date',
			],
			[
				'attribute' => 'Status',
				'value' => function($model){
					$status = [
						1=>'offen',
						2=>'in Bearbeitung',
						3=>'wartet',
						4=>'Abgeschlossen'
					];
					return $status[$model->Status];
				}
			],
			[
				'attribute' => 'Auftragnehmer',
			],
			[
				'attribute' => 'Auftraggeber',
			],
		],
      'panel' => [
			'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i>&nbsp; Maßnahmen</h3>',
			'type'=>'info',
			'footer'=>false,
			],
		'export' => false,
		'toolbar' => false,
		]);


	?>
</div>
