<?php
#use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\grid\EditableColumn;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;


/* @var $this yii\web\View */
$this->title = 'Mehrfachlager';
$this->params['breadcrumbs'][] = $this->title;

 $form = ActiveForm::begin([
			'id'=> 'mahrfachlager',
			#'method' => 'get',
			'type' => ActiveForm::TYPE_HORIZONTAL,
			'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL],
			'options' => ['class' => 'form-horizontal'],
			#'action' => Url::to(['bericht/mehrfachlager']),
		]);	?>

<div class="form-group ">	

	<div class="col-lg-8">
			<?=$form->field($model, 'ARTDESC', [
					'addon' => [
						'append' => [
							'content' => Html::SubmitButton('OK', ['class'=>'btn btn-primary']), 
							'asButton' => true
						]
					]
				]) ->input('number', ['min'=>100000, 'max'=> 999999]);?>
	</div> 
		
			
		<?php ActiveForm::end(); ?>
		
</div>
	
<div style='height:10px;'></div>

<div class="bericht-mehrfachlager">
<?php if ($artdesc): ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'toggleData' => false,
        'summary' =>'{begin} - {end} von {totalCount}',
        'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
		'headerRowOptions'=>['class'=>'kartik-sheet-style'],
		'floatHeader'=>true,
		'pjax'=>true,
        'columns' => [
				[
					'class'=>'kartik\grid\SerialColumn',
					#'hidden'=>true,
				],
			[
				'class' => 'kartik\grid\EditableColumn',
				'attribute'=>'PLACE',
				'label' => 'Lagerort',
				'editableOptions' => function ($model, $key, $index, $widget) {
            return [
					'header' => 'Lagerort',
					'size'=>'lg',
					
					];
			},
				'hAlign'=>'right', 
				'vAlign'=>'middle',
				'width'=>'400px',
				'pageSummary' => true
			],
			[
				'attribute' => 'MENGE',
				'label' => 'Menge',
				'format' => ['decimal',2],
			],
			[
				'attribute' => 'INCDATE',
				'label' => 'Datum Einlagerung',
				'format' => ['date', 'php:d.m.Y H:i:s'],
			],
        ],
        'panel' => [
			'heading'=>
			'<h3 class="panel-title"><i class="glyphicon glyphicon-indent-left"></i>&nbsp;&nbsp;Mehrfachlager Art.Nr.: '.$artdesc->ARTDESC.'&nbsp;'.$artdesc->ARTNAME.'</h3>',
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
	<?php endif; ?>
</div>

