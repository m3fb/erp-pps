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
use app\models\Maschine;

$js = 'setTimeout("location.reload();",60000);';
$this->registerJs($js, $this::POS_READY);

$this->registerJsFile("@web/js/copy.js",
						['depends' => [\yii\web\JqueryAsset::className()]]
						);


$this->title = 'Bdes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bde-index">

   <!-- <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Bde', ['create'], ['class' => 'btn btn-success']) ?>
    </p>-->

<?php if (yii::$app->controller->action->id == 'archiv'): ?>


		<?php $form = ActiveForm::begin([
			'id'=> 'arch_opt',
			'method' => 'get',
			'type' => ActiveForm::TYPE_HORIZONTAL,
			'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL],
			'options' => ['class' => 'form-horizontal'],
			'action' => Url::to(['bde/archiv']),
		]);	?>
	<div class="form-group kv-fieldset-inline">
		<div class="col-sm-2">
		<?= $form->field($searchModel, 'arch_time', ['showLabels'=>false])->widget(Select2::classname(), [
            'data'=>[2=>'2 Wochen',4=>'4 Wochen',6=>'6 Wochen',8=>'8 Wochen',10=>'10 Wochen',12=>'12 Wochen',50=>50],
            'pluginOptions'=>['allowClear'=>false],
            'options' => ['placeholder'=>'Zeitraum','name'=>'arch_time']
        ]); ?>

		</div>

		<div class="col-sm-1">
		<?= Html::submitButton('OK', ['class' => 'btn btn-primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>

		<div class="col-sm-4">
		<?= " aktueller Archivierungszeitraum: <b>".$arch_time." Wochen</b>"; ?>
		</div>
	</div>

<?php endif;?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' =>'{begin} - {end} von {totalCount}',
        'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
				'headerRowOptions'=>['class'=>'kartik-sheet-style'],
				'rowOptions' => function ($model) {				// wenn auf eine Zeile geklickt wird, lädt die Seite neu. Änderungen werden aufgefrischt
                	return ['id' => $model['ISINTERNAL'], 'onclick' => 'setTimeout("location.reload();",1000);'];
        	},
					'pjax'=>false,
        	'columns' => [
						['class' => 'yii\grid\SerialColumn',
							'header' => 'Nr.',
							'headerOptions'=>['style'=>'width: 10px;']],
						[
							'attribute' => 'MSTIME',
							'label' => 'Rückmeldezeit',
							'format' => ['datetime', 'dd.MM.yyyy HH:mm:ss'],
							'filter'=> false,

						],
						[
							'value' => function ($model) {
								return  substr($model['ORNAME'],0,8);
								},
							'label' => 'Auftrag',
							'format' => ['text']
						],
						[
							'attribute' => 'ARTDESC',
							'label' => 'Art.Nr.',
							'format' => ['text']
						],
						[
							'attribute' => 'DESCR',
							'label' => 'Bezeichnung',
							'format' => ['text'],
						],
						[
							'attribute' => 'MSINFO',
							'label' => 'Linie',
							'format' => ['text'],
						],

			           [
							'value' => function ($model){
								$model['STATUS'] = 400 ? $status='Unterbrechung' : $status='Ende';
								return $status;
							},
							'label' => 'Status',
							'format' => ['text'],
						],
						[
							'attribute' => 'PERSNO',
							'width'=>'210px',
							'label' => 'Name',
							'format' => ['text'],
							'group' => true,
							'value'=>function ($model, $key, $index, $widget) {
			                return $model['PERSNAME'];
			            },
							'filter' => false, //29.05.2018 Filter wegen Perfomance deaktiviert;
							/*'filterType'=>GridView::FILTER_SELECT2,
							'filter'=>ArrayHelper::map($personalListe,'PERSNO','SURNAME'),
							'filterWidgetOptions'=>[
								'pluginOptions'=>['allowClear'=>true],
								],
							'filterInputOptions'=>['placeholder'=>'Mitarbeiter'],*/
						],
						[
							'attribute' => 'ADCCOUNT',
							'label' => 'Menge',
							'hAlign'=>'right',
						],

						[
							'attribute' => 'MASSEINH',
							'label' => 'Einh.',
							'format' => ['text'],
						],
			            ['class' => 'yii\grid\ActionColumn',
							#5.08.2015 etikett1 wird deaktiviert
							'template'    => '{etikett2} {restore}',
							'buttons' => [
								  'etikett2' => function ($url, $model, $id)   {
										  return ($model['ISINTERNAL'] == '' or $model['ISINTERNAL'] == 0 ) ? Html::a('<span class="glyphicon glyphicon-tag"></span>', $url,
														['data'=>'1',
														'title' => Yii::t('app', 'Etikett2'),
														'target'=> '_blank']) :'';
								  },
								  'restore' => function ($url, $model, $id)   {
										  return ($model['ISINTERNAL'] == 2) ? Html::a('<span class="glyphicon glyphicon-floppy-disk"></span>', $url,
														['data'=>'1',
														'title' => Yii::t('app', 'Restore'),
														'target'=> '_self']) :'';
								  },
								  ],
							'header' => 'Kenz.',
							'headerOptions'=>['style'=>'min-width: 16px;']
						],
			     ],
        	'panel' => [
							'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-tags"></i>&nbsp; Rückmeldungen / Ettiketten erstellen</h3>',
							'type'=>'primary',
							#'footer' => false,
							'before' =>false,
							'after' => false,
							],
					'export'=>false,
					'responsive'=>false,
					'hover'=>true
					]);
		?>

</div>
