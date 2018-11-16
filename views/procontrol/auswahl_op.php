<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use app\models\Procontrol;

$this->registerCss("
.pagination > li > a,
.pagination > li > span {
    color: #3c763d; // use your own color here
}

.pagination > .active > a,
.pagination > .active > a:focus,
.pagination > .active > a:hover,
.pagination > .active > span,
.pagination > .active > span:focus,
.pagination > .active > span:hover {
    background-color: #3c763d;
    border-color: #3c763d;
 }   
.my-grouped-tool {
	font-size:16px;
	font-weight:bold;
	background-color: #337ab7;
	color:#fff;
	}
.my-grouped-order {
	font-size:14px;
	font-weight:normal;
	background-color: #fcf8e3;
	color:#000;
	}
.my-warning {
	background-color: #d9534f;
	}

");


/* @var $this yii\web\View */
$this->title = 'Produktionsaufträge';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-lg-9">

	
	<?php # print_r($dataProvider); ?>
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' =>'{begin} - {end} von {totalCount}',
        'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
		'headerRowOptions'=>['class'=>'kartik-sheet-style'],
		'floatHeader'=>true,
		'pjax'=>true,
		'rowOptions'=>function($model){
								if($model['AG_Nr'] == 10){
									return ['style'=>'border-top: 4px solid #d9534f;font-weight:bold;color:#d9534f;'];
									#return ['class' => GridView::TYPE_DANGER];
								}
						},
        'columns' => [
			['class' => 'kartik\grid\SerialColumn',
				'header' => 'Nr.',
				'headerOptions'=>['style'=>'width: 10px;']
			],
			[
				'attribute' => 'COMMNO',
				'label' => 'Wkz.',
				'format' => ['text'],
				'width'=>'100px',
				'group'=>true,
				'groupedRow'=>true,                    // move grouped column to a single grouped row
				'groupOddCssClass'=>'my-grouped-tool',  // configure odd group cell css class
				'groupEvenCssClass'=>'my-grouped-tool',			
			],
			[
				'attribute' => 'Auftrag',
				'label' => 'Auftrag',
				'format' => ['text'],
				'group'=>true,  // enable grouping
				'groupedRow'=>true,                    // move grouped column to a single grouped row
				'groupOddCssClass'=>'my-grouped-order',  // configure odd group cell css class
				'groupEvenCssClass'=>'my-grouped-order',
				'subGroupOf'=>1	// Werkzeugnr. ist die Hauptgruppe			
			],
			[
				'class'=>'kartik\grid\ExpandRowColumn',
				'width'=>'50px',
				'value'=>function ($model, $key, $index, $column) {
					return GridView::ROW_COLLAPSED;
				},
				'detail' =>  function ($model, $key, $index, $column) {
					$model2 = Procontrol::getArtikel($model['ORNO']);
					$model3 = Procontrol::getMeldung($model['ORNO']);
					
                    return Yii::$app->controller->renderPartial('_auftrag-details', ['model2' => $model2,
																					'model3'=>$model3,
																					'akt_Stueckzahl'=>$model['akt_Stueckzahl'],
																					'Prod_zeit'=>$model['Prod_zeit']]);
                },
                'disabled' => function ($model, $key, $index, $column) {
					($model['AG_Nr']== 20) ? $v= false : $v= true;
					return $v;
				},
				'headerOptions'=>['class'=>'kartik-sheet-style'],
				'expandOneOnly'=>true,
			],
			
			[
				'attribute' => 'IDENT',
				'label' => 'Artikelnr.',				
				'width'=>'100px',
				'group'=>true, 
				'subGroupOf'=>2,				
			],
			[
				'attribute' => 'Bezeichnung',
				'label' => 'Bezeichnung',
				'format' => ['text'],
				'group'=>true, 
				'subGroupOf'=>2,				
			],
			[
				'attribute' => 'OPINFO',
				'label' => 'AG-Info',
				'format' => ['text'],
				'contentOptions' => ['style' => 'color: #337ab7;'],
				'group'=>true, 
				'subGroupOf'=>2,				
			],
			[
				'attribute' => 'PPARTS',
				'label' => 'Sollstück',	
				'format' => ['decimal',2],
				'group'=>true, 
				'subGroupOf'=> 2,		
			],
			[
				'attribute' => 'DELIVERY',
				'label' => 'Liefertermin',
				'format' => ['date'],
				'group'=>true, 
				'subGroupOf'=>2,	
			],
			[
				'attribute' => 'AG_Nr',
				'label' => 'AG-Nr.',			
			],
			[
				'attribute' => 'AG_Name',
				'label' => 'AG-Bezeichnung',			
			],
			[
				'attribute' => 'Ruestzeit',
				'label' => 'Rüstzeit',
				'width'=>'100px',
				'value' => function($model) {
					if ($model['Ruestzeit'] == 0) {
						 $ausgabe = ''; 
						}
					else {
						$ausgabe =Yii::$app->formatter->asDecimal($model['Ruestzeit'],2).' Min.';
					}
				return $ausgabe;
				}	
			],
			[
				'attribute' => 'Stueckzeit',
				'label' => 'Stückzeit',
				'width'=>'100px',
				'value' => function($model) {
					if ($model['Stueckzeit'] == 0) {
						 $ausgabe = ''; 
						}
					else {
						$ausgabe =Yii::$app->formatter->asDecimal($model['Stueckzeit'],2).' min.';
					}
				return $ausgabe;
				}	
			],
			[
				'attribute' => 'Laufzeit ges.',
				'label' => 'Laufzeit',
				'width'=>'100px',
				'value' => function($model) {
					if ($model['Stueckzeit'] == 0) {
						 $ausgabe = ''; 
						}
					else {
						$ausgabe =Yii::$app->formatter->asDecimal($model['Laufzeit'],2).' Std.';
					}
				return $ausgabe;
				}	
			],
			[
				'attribute' => 'akt_Stand',
				'label' => 'fertig',
				'width'=>'100px',
				'value' => function($model) {
					if ($model['Stueckzeit'] == 0) {
						 $ausgabe = ''; 
						}
					else {
						$ausgabe =Yii::$app->formatter->asPercent($model['akt_Stand'],0);
					}
				return $ausgabe;
				}		
			],
		],
        'panel' => [
			'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-list"></i>&nbsp; Offene Aufträge <b>'.$maschine->NAME.'</b></h3>',
			'type'=>'success',
			'footerOptions'=>['class'=>'panel-footer'],
			],
		'export' => false,
		'responsive'=>false,
		'hover'=>false
		]);
?>		 
</div>
<div class="col-lg-3">
	<div>
			<?= GridView::widget([
				'dataProvider' => $dataBde,
				'summary' => '',
				'headerRowOptions'=>['class'=>'kartik-sheet-style'],
				'rowOptions'=>['style'=>'font-size:10px;'],
				'columns' => [
					[
						'attribute' => 'MSTIME',
						'label' => 'Meldezeit',
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
					[
						'attribute' => 'STATUS',
						'label' => 'Status',
						'format' => ['html'],
						'value' => function($model) {
							if ($model['STATUS'] == 300) {
								 $ausgabe = $model['ORNAME'].'<br>AG-'.$model['AG_Nr'].' Start'; 
								}
							elseif ($model['STATUS'] == 400) {
								 $ausgabe = $model['ORNAME'].'<br>AG-'.$model['AG_Nr'].' Unterbr.'; 
								}
							elseif ($model['STATUS'] == 500) {
								 $ausgabe = $model['ORNAME'].'<br>AG-'.$model['AG_Nr'].' Ende'; 
								}
							else {
								$ausgabe ='';
							}
					return $ausgabe;
					}					
				],
				],
				'panel' => [
					'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;aktuelle BDE - Meldungen <b>'.$maschine->NAME.'</b></h3>',
					'type'=>'success',
					'footer'=>false,
					],
				'export' => false,
				'toolbar' => false,
				]);
				
				
			?>
	</div>
	<div>
		<div class="panel panel-success">
			<div class="panel-heading"><h3 class="panel-title"><i class="glyphicon glyphicon-wrench"></i> &nbsp;Produktionsdaten</h3></div>
			<div class="panel-body">
				<p>Keine Daten vorhanden</p>
			</div>
		</div>
	</div>
</div>	


