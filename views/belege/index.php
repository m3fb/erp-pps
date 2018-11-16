<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PersonalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ERP-Belege';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns =
	[
				['class' => 'yii\grid\SerialColumn'],
				[
					'attribute' => 'TXTNUMMER',
					'width'=>'100px',
					'label' =>'Belegnr.',
				],
				[
					'attribute' => 'ANLAGEZEIT',
					'format'=>'date',
					'label' =>'Belegdatum',
				],
				[
					'attribute' => 'TXTIDENT',
					'width'=>'250px',
					'label' =>'Belegtyp',
					'filterType'=>GridView::FILTER_SELECT2,
					'filter'=>$belegtypen,
					'filterWidgetOptions'=>[
						'pluginOptions'=>['allowClear'=>true],
					],
					'filterInputOptions'=>['placeholder'=>'Beleg'],
				],
				[
					'attribute' => 'ADDRTEXT',
					'label' =>'Adresse',
				],
				['class' => 'yii\grid\ActionColumn',
									'template'    => '{update}',
				],
];


?>
<div class="belege-index">

    <?= GridView::widget([
        'dataProvider' => $dataProviderOffeneBelege,
        'filterModel' => $paPaperModel,
				'rowOptions'=>function($model){
								 if($model['STATUS'] == 0 ){
										 return ['class' => 'danger'];
								 }
								 elseif($model['STATUS'] == 1 ){
										 return ['class' => 'warning'];
								 }
								 else {
									 return ['class' => 'success'];
								 }
							},
        'columns' => $gridColumns,
				'summary' => 'Seite {page} von {pageCount} &nbsp; Einträge {begin} - {end} von {totalCount}',
				'panel' => [
					'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-list"></i>&nbsp;'. Html::encode($this->title) .'</h3>',
					'type'=>'primary',
					'before' => false,
					'after' => false,
					],

    ]); ?>
</div>
