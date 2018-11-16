<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\grid\EditableColumn;
use yii\helpers\Url;


/* @var $this yii\web\View */
$type == 'delivery' ? $gridheader = 'Liefer' : $gridheader = 'Bestell';
$type == 'delivery' ? $cust_header = 'Kunde' : $cust_header = 'Lieferant';
$this->title = $gridheader.'rückstand';
$this->params['breadcrumbs'][] = $this->title;
$gridColumns[] = 
		['class' => 'yii\grid\SerialColumn',
						'header' => 'Nr.',
						'headerOptions'=>['style'=>'width: 10px;']
					];
$gridColumns = [					
					[
					'attribute'=>'POSDAT', 
					'width'=>'310px',
					'value'=>function ($model, $key, $index, $widget) {
						$datum = Yii::$app->formatter->asDate($model['POSDAT']);
						$transitTime = Yii::$app->formatter->asInteger($model['VAL02']);
						$datediff =  Yii::$app->formatter->asDate(date('d-m-Y', strtotime("$datum + $transitTime week"))); #Das Datum bei Auslandslieferungen wird im Model mit der Transit substrahiert;
						$woche =  Yii::$app->formatter->asDate($model['POSDAT'],'w');
						$model['POSDAT'] < date('Y-m-d') ? $color = 'red' : $color = 'black';
						$model['VAL02'] > 0 ? $ausgabe = '<font color="'.$color.'">'.$datum .' / KW '.$woche.' / Transitzeit = '.$transitTime.' Wochen / ETA = '.$datediff.'</font>' :
												$ausgabe = '<font color="'.$color.'">'.$datum .' / KW '.$woche.'</font>';
						return $ausgabe;
					},
					'format' => 'html',
					'group'=>true,  // enable grouping,
					'groupedRow'=>true,                    // move grouped column to a single grouped row
					'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
					'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
					],
					[
					'attribute'=>'TXTNUMMER',
					'label' => 'Bestellung', 
					'width'=>'180px',
					'value'=>function ($model, $key, $index, $widget) { 
						$ausgabe = "<b>".$model['TXTNUMMER'] ."</b><br><small> Kund.-Best.nr.:<br>".$model['ORDERNO']."</small>";
						return $ausgabe;
					},
					'format' => 'html',
					'group'=>true,  // enable grouping
					'subGroupOf'=>1 // deliverdate index is the parent group
					],
					/*[
						'class'=>'kartik\grid\ExpandRowColumn',
						'width'=>'50px',
						'value'=>function ($model, $key, $index, $column) {
							return GridView::ROW_COLLAPSED;
						},
						'detail'=>function ($model, $key, $index, $column) {
							return Yii::$app->controller->renderPartial('_expand-row-details', ['model'=>$model]);
						},
						'headerOptions'=>['class'=>'kartik-sheet-style'], 
						'expandOneOnly'=>true
					],*/
					[
						'class'=>'kartik\grid\ExpandRowColumn',
						'width'=>'50px',
						'value'=>function ($model, $key, $index, $column) {
							return GridView::ROW_COLLAPSED;
						},
						'detail'=>function ($model, $key, $index, $widget) { 
						$type= Yii::$app->getRequest()->getQueryParam('type');
						return Yii::$app->controller->renderPartial('_rueckstand-details', ['model'=>$model, 'type' =>$type]);
					},
						'headerOptions'=>['class'=>'kartik-sheet-style'],
						'expandOneOnly'=>true
					],
					[
						'attribute' => 'CNAME',
						'label' => $cust_header,
						'width'=>'120px',
						'value'=>function ($model, $key, $index, $widget) { 
						$ausgabe = "<small>".$model['CNAME']."</small>";
						return $ausgabe;
					},
						'format' => 'html',
					],
					[
						'attribute' => 'ARTDESC',
						'label' => 'Artikelnr.',
						'width'=>'120px',				
					],
					[
						'attribute' => 'POSTEXT',
						'label' => 'Bezeichnung',
						'format' => ['text'],
						
					],
					[
						'attribute' => 'COMMNO',
						'label' => 'Wkz.',
						'format' => ['text'],
						'width'=>'100px',
						
					],
					[
						'attribute' => 'ALAGER3',
						'label' => 'Bestand',
						'format' => ['decimal',2],
					],

					[
						'attribute' => 'MENGE',
						'label' => 'Sollmenge',
						'format' => ['decimal',2],
					],
					
					[
						'attribute' => 'POSLIEF0',
						'label' => 'Geliefert',
						'format' => ['decimal',2],
					],
					[
						'value' => function ($model){
							$rueckstand = $model['MENGE'] - $model['POSLIEF0'];
							return $rueckstand;
						},
						'label' => 'Rückstand',
						'format' => ['decimal',2],
						'contentOptions' => ['style'=>'font-weight:bold;'],
					]
				];
				
if ($type != 'delivery') {
	$gridColumns[] = ['class' => 'yii\grid\ActionColumn',
													'template'    => '{lagereingang}',
													'buttons' => [
														'lagereingang' => function ($url, $model, $id) {
															return Html::a('<span class="glyphicon glyphicon-paste"></span>',
																Url::to(['fauserbuchungen/lagereingang' ,'id' => $id]), [
																	'title' => \Yii::t('yii', 'Lagereingang'),
																	'data-pjax' => '0',
																]);
														},
													]		
															
								];
							}

?>
<div class="bericht-lieferrueckstand">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' =>'{begin} - {end} von {totalCount}',
        'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
		'headerRowOptions'=>['class'=>'kartik-sheet-style'],
		'floatHeader'=>true,
		'pjax'=>true,
        'columns' => $gridColumns,
        'panel' => [
			'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-transfer"></i>&nbsp; '.$gridheader.'rückstandsliste</h3>',
			'type'=>'primary',
			'footerOptions'=>['class'=>'panel-footer'],
			],
		'exportConfig' => [

					GridView::PDF => ['label' => 'Speichern als PDF',],
				],
		'export'=>['header'=>'Datei exportieren',
					'showConfirmAlert'=> false,
					],
		'responsive'=>false,
		'hover'=>true
		]); 
		?>

</div>

