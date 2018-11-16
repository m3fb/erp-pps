<?php

use yii\helpers\Html;
use kartik\grid\GridView;

ini_set('mssql.charset', 'windows-1252');
/* @var $this yii\web\View */
/* @var $model app\models\Ororder */
/* @var $form yii\widgets\ActiveForm */
?>




<div class="col-sm-6">
	<?= GridView::widget([
        'dataProvider' => $model2,
        'summary' => '',
		'headerRowOptions'=>['class'=>'kartik-sheet-style','style'=>'font-size:12px;'],
		'rowOptions'=>['style'=>'font-size:12px;'],
        'columns' => [
			['class' => 'kartik\grid\SerialColumn',
				'header' => 'Nr.',
				'headerOptions'=>['style'=>'width: 10px;']
			],
			[
				'attribute' => 'ARTDESC',
				'label' => 'Art-Nr.',				
			],
			[
				'attribute' => 'ARTNAME',
				'label' => 'Bezeichnung',				
			],
			[
				'attribute' => 'Menge',
				'label' => 'Menge',
				'format' => ['decimal',2],				
			],
			[
				'attribute' => 'Masseinheit',
				'label' => 'Masseinh.',				
			],
		],
        'panel' => [
			'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i>&nbsp; Stückliste</h3>',
			'type'=>'info',
			'footer'=>false,
			],
		'export' => false,
		'toolbar' => false,
		]);
		
		
	?>
</div>

<div class="col-sm-6">
	<?= GridView::widget([
        'dataProvider' => $model3,
        'summary' => '',
		'headerRowOptions'=>['class'=>'kartik-sheet-style','style'=>'font-size:12px;'],
		'rowOptions'=>['style'=>'font-size:12px;'],
        'columns' => [
			['class' => 'kartik\grid\SerialColumn',
				'header' => 'Nr.',
				'headerOptions'=>['style'=>'width: 10px;'],				
			],			
			[
				'attribute' => 'MSTIME',
				'label' => 'Rückmeldezeit',
				'format' => ['datetime'],			
			],
			[
				'attribute' => 'PERSNAME',
				'label' => 'Name',				
			],
			[
				'attribute' => 'ADCCOUNT',
				'label' => 'Menge',
				'format' => ['decimal',2],				
			],
		],
        'panel' => [
			'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i>&nbsp; Meldungen</h3>',
			'type'=>'info',
			'footer'=>' aktuelle Produktionszeit = <b>'.Yii::$app->formatter->asDecimal($Prod_zeit,2).' Std.</b>  // Rückmeldung gesamt: <b>'.Yii::$app->formatter->asDecimal($akt_Stueckzahl,2).'</b>',
			'footerOptions' => ['class'=>'panel-footer','style'=>' text-align: right;font-size:12px;'],
			],
		'export' => false,
		'toolbar' => false,
		]);
		
		
	?>
		
</div>

