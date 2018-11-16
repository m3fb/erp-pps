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
$this->title = 'Kaufteile';
$this->params['breadcrumbs'][] = $this->title;

?>
<?php $form = ActiveForm::begin([
			'id'=> 'kaufteileliste_opt',
			'method' => 'get',
			'type' => ActiveForm::TYPE_HORIZONTAL,
			'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL],
			'options' => ['class' => 'form-horizontal'],
			'action' => Url::to(['bericht/kaufteile']),
		]);	?>

<div class="form-group kv-fieldset-inline">	

	<div class="col-lg-8">
			<?= Select2::widget([
					'name' => 'kaufteil_no',
					'value' => $kaufteil_no, // initial value
					'data' => ArrayHelper::map($kaufteileListe, 'ARTDESC', 'POSTEXT'),
					'options' => ['placeholder' => 'Kaufteil auswählen ...','onchange' => 'this.form.submit()'],
					'pluginOptions' => [
						'allowClear' => true
					],				
				 ]);?>
	</div> 
		
			
		<?php ActiveForm::end(); ?>
		
</div>
	
<div style='height:10px;'></div>

<div class="bericht-kaufteile">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        #'filterModel' => $searchModel,
        'toggleData' => false,
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
					'attribute'=>'ARTDESC', 
					'header' => 'Artikel',
					'value'=>function ($model, $key, $index, $widget) {
					return "<b>".$model['ARTDESC']."&nbsp;".$model['POSTEXT']."</b>";
				},
					'width'=>'310px',
					'format'=>'html',
					'filterType'=>GridView::FILTER_SELECT2,
					'filter'=>ArrayHelper::map($kaufteileListe, 'ARTDESC', 'POSTEXT'), 
					'filterWidgetOptions'=>[
						'pluginOptions'=>['allowClear'=>true],
					],
					'filterInputOptions'=>['placeholder'=>'Kaufteil auswählen...'],
					'group'=>true,  // enable grouping,
					'groupedRow'=>true,                    // move grouped column to a single grouped row
					'groupOddCssClass'=>'info',  // configure odd group cell css class
					'groupEvenCssClass'=>'info', // configure even group cell css class
					'groupFooter'=>function ($model, $key, $index, $widget) { // Closure method
						return [
							'mergeColumns'=>[[0,8]], // columns to merge in summary
							'content'=>[             // content to show in each summary cell
								0=>'<b>----------------------------------------------------------------------</b>',
							],
							'contentFormats'=>[      // content reformatting for each summary cell
								
							],
							'contentOptions'=>[      // content html attributes for each summary cell
								1=>['style'=>' text-align:left;'],
							],
							// html attributes for group summary row
							'options'=>['class'=>'selected','style'=>'font-weight:bold;']
						];
					}
			],
			[
				'attribute'=>'IDENT', 
				'header' => '',
				'width'=>'250px',
				'value'=>function ($model, $key, $index, $widget) {
					$adresse_array = explode ("\r\n",$model['ADDRTEXT']);
					$adresse = $adresse_array[0]; 
					return $model['TXTIDENT']." an ".$adresse;
				},
				'group'=>true,  // enable grouping
				'groupOddCssClass'=>function ($model, $key, $index, $widget) {
					$model['IDENT']==1?$class='warning':$class='success';
					return $class;
				},
				'groupEvenCssClass'=>function ($model, $key, $index, $widget) {
					$model['IDENT']==1?$class='warning':$class='success';
					return $class;
				},
				'subGroupOf'=>1, // supplier column index is the parent group,
				'groupFooter'=>function ($model, $key, $index, $widget) { // Closure method
					$model['IDENT']==1?$class='warning':$class='success';
					return [
						'mergeColumns'=>[[0, 5],[6,8]], // columns to merge in summary
						'content'=>[              // content to show in each summary cell
							2=>'aktueller Bestand: <b>'. Yii::$app->formatter->asDecimal($model['ALAGER3'],2).'&nbsp;&nbsp;&nbsp;&nbsp;</b>Summe '.$model['TXTIDENT'].': ',
							8=>GridView::F_SUM,
						],
						'contentFormats'=>[      // content reformatting for each summary cell
							8=>['format'=>'number', 'decimals'=>2, 'decPoint'=>',', 'thousandSep'=>'.'],
						],
						'contentOptions'=>[      // content html attributes for each summary cell
							6=>['style'=>'text-align:right; font-style:normal; font-weight:bold;'],
						],
						// html attributes for group summary row
						'options'=>['class'=>$class,'style'=>'text-align:right;']
					];
				},
			],
			[
				'attribute' => 'TXTNUMMER',
				'label' => 'Beleg-Nr.',
				'filter' => false,
				'format' => 'text',
				'contentOptions'=>function ($model, $key, $index, $widget) {
					$model['IDENT']==1?$class='warning':$class='success';
					return ['class'=>$class];
				},
			],		
			[
				'attribute'=>'POSDAT', 
				'width'=>'120px',
				'value'=>function ($model, $key, $index, $widget) { 
					$datum = Yii::$app->formatter->asDate($model['POSDAT'],'medium');
					$model['POSDAT'] < date('Y-m-d') ? $color = 'red' : $color = 'black';
					$ausgabe = '<font color="'.$color.'">'.$datum .'</font>';
					return $ausgabe;
				},
				'format' => 'html',
				'label' => 'Liefertermin',
				'contentOptions'=>function ($model, $key, $index, $widget) {
					$model['IDENT']==1?$class='warning':$class='success';
					return ['class'=>$class];
				},
			],
			[
				'attribute' => 'MENGE',
				'label' => 'Sollmenge',
				'format' => ['decimal',2],
				'contentOptions'=>function ($model, $key, $index, $widget) {
					$model['IDENT']==1?$class='warning':$class='success';
					return ['class'=>$class];
				},
			],
			[
				'attribute' => 'POSLIEF0',
				'label' => 'Geliefert',
				'format' => ['decimal',2],
				'contentOptions'=>function ($model, $key, $index, $widget) {
					$model['IDENT']==1?$class='warning':$class='success';
					return ['class'=>$class];
				},
			],
            [
				'value' => function ($model){
					$rueckstand = $model['MENGE'] - $model['POSLIEF0'];
					return $rueckstand;
				},
				'label' => 'Rückstand',
				'hAlign' => 'right',
				'format' => ['decimal',2],
				'contentOptions'=>function ($model, $key, $index, $widget) {
					$model['IDENT']==1?$class='warning':$class='success';
					return ['class'=>$class];
				},
			],
			[
				'value' => function ($model){
					$rueckstand = $model['MENGE'] - $model['POSLIEF0'];
					return $rueckstand;
				},
				'label' => 'Rückstand',
				'hAlign' => 'right',
				'hidden' => true,
			],
			
        ],
        'panel' => [
			'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-shopping-cart"></i>&nbsp; Kaufteile</h3>',
			'type'=>'primary',
			'footer'=>false,
			'after'=>false,
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
