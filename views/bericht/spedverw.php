<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
#use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\grid\EditableColumn;
use yii\helpers\Url;
use yii\bootstrap\Progress;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;


$this->title = 'Speditionsauftragsverwaltung';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bde-index">
	
	<?php echo GridView::widget([
		'dataProvider'=> $dataProvider,
		'filterModel' => $searchModel,
		'summary' =>'{begin} - {end} von {totalCount}',
		'columns' => [
			[
				'class'=>'kartik\grid\SerialColumn',
			],
			[
				'attribute' => 'TXTNUMMER',
				'label' => 'Vorgangs-Nr.',
			],
			[
				'attribute' => 'CDATE',
				'label' => 'Datum',
				'format' => ['date', 'dd.MM.yyyy'],
				
			],
			[
				'attribute' => 'ADDRTEXT',
				'label' => 'Kunde',
			],
			[
				'attribute' => 'VNAME',
				'label' => 'Lieferanschrift',
			],
			[
				'attribute' => 'VPLACE',
				'label' => 'Lieferort',
			],
			['class' => 'yii\grid\ActionColumn',
				'template'    => '{select_sped} ',
				'buttons' => [			  
					  'select_sped' => function ($url, $model, $id)   {
							  return Html::a('<span class="glyphicon glyphicon-tasks"></span>', $url, 
											['data'=>'1',
											'title' => Yii::t('app', 'select')]);					
					  },
					  ],
				'header' => '',
				'headerOptions'=>['style'=>'min-width: 16px;']
			],
		],
		 'panel' => [
			'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-road"></i>&nbsp; Sepditionsauftragsverwaltung</h3>',
			'type'=>'primary',
			'footerOptions'=>['class'=>'panel-footer'],
			],
		'responsive'=>true,
		'hover'=>true
	]);

?>

    


   

</div>

