<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\bootstrap\Modal;
use yii\bootstrap\BootstrapPluginAsset;


/* @var $this yii\web\View */
/* @var $model app\models\Personal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="personal-stammdaten">

	<?= DetailView::widget([
			'model' => $model,
			'condensed'=>true,
			'striped' => false,
			'mode'=>DetailView::MODE_VIEW,
			'panel'=>[
				'heading'=>'Stammdaten ',
				'type'=>DetailView::TYPE_PRIMARY,
			],
			'buttons1' =>'{update}',
			'attributes' => [
				//'NO',
				[
					'group'=>true,
					'label'=>'<span class="glyphicon glyphicon-user"></span>',
					'rowOptions'=>['class'=>'info']
				],
				[
			'columns' => [
					[
						'attribute'=>'PERSNO',
						'displayOnly' => true,
						'labelColOptions' => ['style'=>'width:15%; text-align:right;'],
						'valueColOptions'=>['style'=>'width:15%'],
					],
					[
						'attribute'=>'FIRSTNAME',
						'displayOnly' => true,
						'labelColOptions' => ['style'=>'width:15%; text-align:right;'],
						'valueColOptions'=>['style'=>'width:15%'],
					],
					[
						'attribute'=>'SURNAME',
						'displayOnly' => true,
						'labelColOptions' => ['style'=>'width:15%; text-align:right;'],
						'valueColOptions'=>['style'=>'width:15%'],
					]
				]
				],
				[
					'group'=>true,
					'label'=>'<span class="glyphicon glyphicon-earphone"></span>',
					'rowOptions'=>['class'=>'info']
				],
				 [
			'columns' => [
				[
						'attribute'=>'PHONE1',
						'labelColOptions' => ['style'=>'width:15%; text-align:right;'],
						'valueColOptions'=>['style'=>'width:15%'],
						'displayOnly' => true,
				],
				[
						'attribute'=>'PHONE2',
						'labelColOptions' => ['style'=>'width:15%; text-align:right;'],
						'valueColOptions'=>['style'=>'width:15%']
				],
				[
						'attribute'=>'PHONE3',
						'labelColOptions' => ['style'=>'width:15%; text-align:right;'],
						'valueColOptions'=>['style'=>'width:15%']
				],
					]
				],
				[
					'group'=>true,
					'label'=>'<span class="glyphicon glyphicon-home"></span>',
					'rowOptions'=>['class'=>'info']
				],
				[
			'columns' => [
				[
						'attribute'=>'STREET',
						'labelColOptions' => ['style'=>'width:15%; text-align:right;'],
						'valueColOptions'=>['style'=>'width:15%']
				],
				[
						'attribute'=>'POSTCODE',
						'labelColOptions' => ['style'=>'width:15%; text-align:right;'],
						'valueColOptions'=>['style'=>'width:15%']
				],
				[
						'attribute'=>'PLACE',
						'labelColOptions' => ['style'=>'width:15%; text-align:right;'],
						'valueColOptions'=>['style'=>'width:15%']
				],
				]
			],
				[
					'group'=>true,
					'label'=>'<span class="glyphicon glyphicon-envelope"></span>',
					'rowOptions'=>['class'=>'info']
				],
				[
			'columns' => [
					[
						'attribute'=>'MODEM',
						'labelColOptions' => ['style'=>'width:100px; text-align:right;'],
					],
				]
			],
				[
					'group'=>true,
					'label'=>'<span class="glyphicon glyphicon-floppy-disk"></span>',
					'rowOptions'=>['class'=>'info']
				],
				[
			'columns' => [
					[
						'attribute'=>'CNAME',
						'displayOnly' => true,
						'labelColOptions' => ['style'=>'width:10%'],
						'valueColOptions'=>['style'=>'width:11%']
					],
					[
						'attribute'=>'CDATE',
						'displayOnly' => true,
						'format' => ['datetime', 'dd.MM.yyyy HH:mm:ss'],
						'labelColOptions' => ['style'=>'width:15%; text-align:right;'],
						'valueColOptions'=>['style'=>'width:15%']
					],
					[
						'attribute'=>'CHNAME',
						'displayOnly' => true,
						'labelColOptions' => ['style'=>'width:10%'],
						'valueColOptions'=>['style'=>'width:11%']
					],
					[
						'attribute'=>'CHDATE',
						'displayOnly' => true,
						'format' => ['datetime', 'dd.MM.yyyy HH:mm:ss'],
						'labelColOptions' => ['style'=>'width:15%; text-align:right;'],
						'valueColOptions'=>['style'=>'width:15%']

					]
				]
				],
				[
					'group'=>true,
					'label'=> '<span class="glyphicon glyphicon-refresh"></span>'.Html::a(' Passwort ändern', ['user/pwchange', 'id'=>$model->NO]),
					'rowOptions'=>['class'=>'info']
				],

			],
		]) ?>

</div>
