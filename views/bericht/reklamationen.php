<?php
#use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\grid\EditableColumn;
use yii\helpers\Url;


/* @var $this yii\web\View */

$this->title = 'Reklamationen';
$this->params['breadcrumbs'][] = $this->title;

$type == 'supplier' ? $gridheader = 'Lieferanten-' : $gridheader = 'Kunden-';

?>
<div class="bericht-reklamationen">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' =>'{begin} - {end} von {totalCount}',
        'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
		'headerRowOptions'=>['class'=>'kartik-sheet-style'],
		'floatHeader'=>true,
		'pjax'=>true,
        'columns' => [
			['class' => 'yii\grid\SerialColumn',
				'header' => 'Nr.',
				'headerOptions'=>['style'=>'width: 10px;']
			],
			
			[
            'attribute'=>'CDATE', 
            'label' => 'Rekl.-Dat.',
            'width'=>'100px',
            'value'=>function ($model, $key, $index, $widget) { 
				$datum = Yii::$app->formatter->asDate($model['CDATE'],'medium');
                return $datum;
            },
            'format' => 'html',
			],
			[
            'attribute'=>'TXTNUMMER',
            'label' => 'Reklamation',
            'value'=>function ($model, $key, $index, $widget) { 
				$ausgabe = "<b>".$model['TXTNUMMER'] ."</b>";
                return $ausgabe;
            },
            'format' => 'html',
            'group'=>true,  // enable grouping,
            'groupedRow'=>true,                    // move grouped column to a single grouped row
            'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
            'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
			],
			[
				'attribute' => 'CNAME',
				'label' => 'Lieferant',
				'width'=>'250px',
				'format' => 'html',
			],
			[
				'attribute' => 'POSART',
				'label' => 'Artikelnr.',
				'width'=>'100px',
				
			],
			[
				'attribute' => 'POSTEXT',
				'label' => 'Bezeichnung / Grund der Reklamation',
				'format' => 'html',
				'width'=>'500px',
				'value'=>function ($model, $key, $index, $widget) { 
					$ausgabe = nl2br($model['POSTEXT']);
					return $ausgabe;
				},
				
			],
			[
				'attribute' => 'APOSDAT',
				'label' => 'Lieferdat.',
				'width'=>'100px',
				'value'=>function ($model, $key, $index, $widget) { 
					$datum = Yii::$app->formatter->asDate($model['APOSDAT'],'medium');
					return $datum;
				},
				'format' => 'html',
			],
			[
				'attribute' => 'MENGE',
				'label' => 'reklamierte Menge',
				'format' => ['decimal',2],
				'width' => '120px',

			],
			[
				'attribute' => 'MASSEINH',
				'label' => 'Einh.',
			],
			['class' => 'kartik\grid\ActionColumn',
				'template'    => '{bearbeiten}',
				'buttons' => [
					  'bearbeiten' => function ($url, $model, $id)   {
						   $type= Yii::$app->getRequest()->getQueryParam('type');
							$url =$url =Url::toRoute(['bericht/bearbeiten', 'id' => $id, 'type' => $type ]);
							  return (Yii::$app->user->identity->username == 'mrotter' or Yii::$app->user->identity->username == 'dhörner' ) ? Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, 
											['data'=>'1',
											'title' => Yii::t('app', 'bearbeiten'),
											'target'=> '_self']) :'';					
					  },
					  ],
				'header' => '<span class="glyphicon glyphicon-pencil"></span>',
				'hiddenFromExport' => true,
			],
        ],
        'panel' => [
			'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-alert"></i>&nbsp;'.$gridheader.'Reklamationen</h3>',
			'type'=>'primary',
			'footerOptions'=>['class'=>'panel-footer'],
			],
		'exportConfig' => [

					GridView::PDF => [
						'label' => 'Speichern als PDF',
						'filename' => 'Lieferanten_Reklamationen',
						'config' => [
								'format' => 'A4-P',
								'options' => [
									'title' => 'Reklamationen',
									'subject' => 'm3profile Reklamationsliste',
									'keywords' => 'm3profile, Reklamationen',
									],
								'methods' => [
									'SetHeader' => ['m3profile GmbH|'.$gridheader.'Reklamationen|Stand: ' . Yii::$app->formatter->asDate(date('r'),'medium')],
									'SetFooter' => ['m3profile GmbH||Seite {PAGENO} von {nb}'],
									]
								] 
							],
						
				],
		'export'=>['header'=>'Datei exportieren',
					'showConfirmAlert'=> false,
					],
		'responsive'=>false,
		'hover'=>true
		]); 
		?>

</div>
