<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\bootstrap\Modal;
use yii\bootstrap\BootstrapPluginAsset;


/* @var $this yii\web\View */
/* @var $model app\models\Personal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="personal-zusInfos">

	<?= DetailView::widget([
        'model' => $zusInfo,
        'condensed'=>true,
        'striped' => false,
		'mode'=>DetailView::MODE_VIEW,
		'panel'=>[
			'heading'=>'Zusätzliche Informationen',
			'type'=>DetailView::TYPE_PRIMARY,
		],
        'buttons1' => '', //'{update}',
        'attributes' => [
            //'NO',

			[
        'columns' => [
				[
					'attribute'=>'TXT02',
					'label' => 'Abteilung',
					'valueColOptions'=>['style'=>'width:15%'],
				],
				[
					'attribute'=>'DAT01',
					'label' => 'Geburtstag',
					'displayOnly' => true,
					'format' => ['datetime', 'dd.MM.yyyy'],
					'valueColOptions'=>['style'=>'width:15%'],
				],
				[
					'attribute'=>'TXT03',
					'label' => 'Email Urlaubsantrag',
					'valueColOptions'=>['style'=>'width:15%'],
				]
			]
			],
            
        ],
    ]) ?>

</div>
