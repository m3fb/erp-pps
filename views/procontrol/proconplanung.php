<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Maschine;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use kartik\grid\GridView;
use kartik\grid\EditableColumn;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;

$maschinenListe = Maschine::find()->select(['WP_MA1.NO','WP_MA1.NAME'])->where(['TERMNO' => 0])->orderBy('NAME')->asArray()->all();

foreach ($maschinenListe as $m) { 
	
	$items[] = [
							'label' => $m['NAME'],
							'url' => ['/procontrol/proconplanung','maschine'=>$m['NO']],
							
						];
}


/* @var $this yii\web\View */
$this->title = 'Produktionsaufträge Planung';
#$this->params['breadcrumbs'][] = $this->title;


?>

<?php
	$this->registerCss("
	.my_container .navbar{
    z-index: 990;
}
	");
?>
<div class="my_container">
<?php
 
NavBar::begin(['options' => ['class' => 'nav navbar'],]);
	            echo Nav::widget([
                'options' => ['class' => 'navbar-nav'],
                'encodeLabels' => false,
                'items' => $items,
                
            ]);
	
            NavBar::end();
?>


</div>

 

				
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' =>'{begin} - {end} von {totalCount}',
        'containerOptions'=>['style'=>'overflow: auto; font-size:11px;'], // only set when $responsive = false
		'headerRowOptions'=>['class'=>'kartik-sheet-style','style'=>'font-size:11px;'],
		'floatHeader'=>true,
		'pjax'=>true,
		
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
			],
			[
				'attribute' => 'Auftrag',
				'label' => 'Auftrag',
				'format' => ['text'],
			],
			[
				'attribute' => 'RELORD',
				'label' => 'Bestellung',
				'format' => ['text'],
			],
			[
				'attribute' => 'IDENT',
				'label' => 'Artikelnr.',				
				'width'=>'100px', 				
			],
			[
				'attribute' => 'Bezeichnung',
				'label' => 'Bezeichnung',
				'format' => ['text'],			
			],
			[
				'attribute' => 'PPARTS',
				'label' => 'Sollstück',	
				'format' => ['decimal',2],		
			],
			[
				'class'=>'kartik\grid\EditableColumn',
				'attribute'=>'DELIVERY',
				'label' => 'Liefertermin', 
				'refreshGrid' => true,   
				'hAlign'=>'center',
				'vAlign'=>'middle',
				'width'=>'9%',
				'format'=>'date',
				'refreshGrid' => true,
				'xlFormat'=>"mmm\\-dd\\, \\-yyyy",
				'headerOptions'=>['class'=>'kv-sticky-column'],
				'contentOptions'=>['class'=>'kv-sticky-column'],
				#'readonly'=>function($model, $key, $index, $widget) {
				#	return (!$model->DELIVERY); // do not allow editing of inactive records
				#},
				'editableOptions'=>function ($model, $key, $index, $widget) {
				return [
					'header'=>'Liefertermin', 
					'name' => 'Order['.$index.'][DELIVERY]',
					'size'=>'md',
					'formOptions'=>['action' => ['/procontrol/editorder']], // point to the new action 
					'inputType'=>\kartik\editable\Editable::INPUT_WIDGET,
					'widgetClass'=> 'kartik\datecontrol\DateControl',
					'options'=>[
						'type'=>\kartik\datecontrol\DateControl::FORMAT_DATE,
						'displayFormat'=>'dd.MM.yyyy',
						#'saveFormat'=>'dd.mm.yyyy',
						'saveFormat'=>'d.M.Y',
						#'saveFormat'=>date('Y-m-d'),
						'options'=>[
							'pluginOptions'=>[
								'autoclose'=>true
							]
						]
					]
				];
			}
			],
			[
				'class' => 'kartik\grid\EditableColumn',
				'attribute'=>'PRIO', 
				'label' => 'Sort.', 
				'refreshGrid' => true,
				'contentOptions'=>['style'=>'width: 60px;'],
				'editableOptions' => function ($model, $key, $index, $widget) {
				return [
					'header' => 'Sortierung',
					'name' => 'Order['.$index.'][PRIO]',
					'value' => $model['PRIO'],
					'formOptions'=>['action' => ['/procontrol/editorder']], // point to the new action 
					'inputType' => \kartik\editable\Editable::INPUT_SPIN,
					'options'=>['pluginOptions'=>['min'=>0, 'max'=>50]]
				];
			},
				'hAlign'=>'right', 
				'vAlign'=>'middle',
				'width'=>'100px',
				'format'=>['decimal', 0],
				'pageSummary' => true
			],
		],
        'panel' => [
			'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-list"></i>&nbsp; Offene Aufträge <b>'.$maschine->NAME.'</b></h3>',
			'type'=>'primary',
			'footerOptions'=>['class'=>'panel-footer'],
			],
		'export' => false,
		'responsive'=>false,
		'hover'=>false
		]);

?>				


		

	
		


