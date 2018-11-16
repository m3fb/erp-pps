<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\grid\EditableColumn;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
$this->title = 'Planungsliste';
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $form = ActiveForm::begin([
			'id'=> 'planungsliste_opt',
			'method' => 'get',
			'type' => ActiveForm::TYPE_HORIZONTAL,
			'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL],
			'options' => ['class' => 'form-horizontal'],
			'action' => Url::to(['bericht/planungsliste']),
		]);	?>

	<div class="form-group kv-fieldset-inline">		
		<div class="col-lg-3">
		<?= Select2::widget([
				'name' => 'wp_name',
				'value' => $wp_name, // initial value
				'data' => ArrayHelper::map($maschinenListe,'NO','NAME'),
				'options' => ['placeholder' => 'Maschine auswählen ...','onchange' => 'this.form.submit()'],
				'pluginOptions' => [
					'allowClear' => true
				],				
			 ]);?>
		</div> 
		<div class="col-lg-3">
		<!--<label class="control-label">Birth Date</label>-->
			<?= DatePicker::widget([
				'name' => 'plan_time',
				'type' => DatePicker::TYPE_COMPONENT_PREPEND,
				'options' => ['onchange' => 'this.form.submit()'],
				'value' => $plan_time,
				'pluginOptions' => [
					'autoclose'=>true,
					#'format' => 'yyyy-m-dd'
					'format' => 'dd-mm-yyyy'
				]
			]); ?>
		</div> 
		
			
		<?php ActiveForm::end(); ?>
		
	</div>

<div style='height:10px;'></div>

<div class="bericht-planungsliste">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' =>'{begin} - {end} von {totalCount}',
        'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
		'headerRowOptions'=>['class'=>'kartik-sheet-style'],
		'floatHeader'=>true,
		'pjax'=>true,
        'columns' => [
			[
				'class'=>'kartik\grid\SerialColumn',
				'hidden'=>true,
			],
			[
				'attribute'=>'WP_MA1_NO', 
				'width'=>'310px',
				'value'=>'WP_MA1_NAME',
				'format' => 'html',
				'group'=>true,  // enable grouping,
				'groupedRow'=>true,                    // move grouped column to a single grouped row
				'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
				'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
			],
			[
				'attribute'=>'POSDAT', 
				'width'=>'120px',
				'value'=>function ($model, $key, $index, $widget) { 
					$datum = Yii::$app->formatter->asDate($model['POSDAT'],'dd.MM.Y');
					$model['POSDAT'] < date('Y-m-d') ? $color = 'red' : $color = 'black';
					$ausgabe = '<font color="'.$color.'">'.$datum .'</font>';
					return $ausgabe;
				},
				'format' => 'html',
				'group'=>true,  // enable grouping,
				'subGroupOf'=>1, // Machine Name index is the parent group
				'label' => 'Liefertermin',
			],
			[
				'attribute' => 'CustName',
				'label' => 'Kunde',
				'width'=>'120px',
			],
			[
				'attribute'=>'TXTNUMMER',
				'label' => 'Bestellung',
				'value'=>function ($model, $key, $index, $widget) { 
					$ausgabe = "<small><b>".$model['TXTNUMMER'] ."</b></small>";
					return $ausgabe;
				},
				'format' => 'html',
				'group'=>true,  // enable grouping
				'subGroupOf'=>2 // deliverdate index is the parent group
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
				'width'=>'90px',
				
			],
			[
				'attribute' => 'ALAGER3',
				'label' => 'Bestand',
				'format' => ['decimal',2],
			],

			[
				'attribute' => 'MENGE',
				'header' => '<small>Sollmenge</small><br><small>Geliefert</small><br>Rückstand',
				'value' => function ($model){
					$sollmenge = Yii::$app->formatter->asDecimal($model['MENGE'],2);
					$geliefert = Yii::$app->formatter->asDecimal($model['POSLIEF0'],2);
					$rueckstand = $model['MENGE'] - $model['POSLIEF0'];
					$rueckstand_form = Yii::$app->formatter->asDecimal($rueckstand,2);
					$ausgabe = $sollmenge."<br>".$geliefert."<br><b>".$rueckstand_form."</b>";
					return $ausgabe;
				},
				'format' => 'html',
				'headerOptions'=>['style'=>'text-align: right;'],
				'contentOptions'=>['style'=>'text-align: right;'],
			],
			[
				'value' => function ($model){
					$laufzeit = ($model['PTE'] / 3600) * ($model['MENGE'] - $model['POSLIEF0']);
					return $laufzeit;
				},
				'label' => 'Laufz.(h)',
				'format' => ['decimal',2],
				'contentOptions'=>['style'=>'text-align: right;'],
			],
        ],
        'panel' => [
			'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-calendar"></i>&nbsp; Planungsliste</h3>',
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
</div>
