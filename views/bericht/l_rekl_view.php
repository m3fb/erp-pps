<?php
#use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\detail\DetailView;
use yii\helpers\Url;
use yii\bootstrap\ButtonGroup;
use yii\bootstrap\Button;

/* @var $this yii\web\View */
$this->title = 'Reklamationen';
$this->params['breadcrumbs'][] = $this->title;
$type == 'supplier' ? $panelheader = 'Lieferanten-' : $panelheader = 'Kunden-';

echo DetailView::widget([
    'model'=>$model,
    'condensed'=>true,
    'hover'=>true,
    'mode'=>DetailView::MODE_VIEW,
    'panel'=>[
        'heading'=>'<span class="glyphicon glyphicon-alert"></span> '.$panelheader.'Reklamation ' . $model->POSART,
        'type'=>DetailView::TYPE_SUCCESS,
    ],
    'buttons1' => '',
    'updateOptions' => [
		'label' => '<span class="glyphicon glyphicon-check"></span>',
		],
	'resetOptions' => [
		'label' => '<span class="glyphicon glyphicon-arrow-left"></span>',
		],
	'attributes' => [
			[
                'attribute' => 'PONO',
                'label' => 'Zurück zur Liste',
                'format' => 'raw',
                'value' => Html::a('<span class="glyphicon glyphicon-arrow-left btn-lg btn-success"></span>', Yii::$app->request->referrer),
            ],
            [
				'attribute'=>'CDATE',
				'label' => 'Rekl. Dat.',
				'value'=>Yii::$app->formatter->asDate($model->CDATE,'medium'),
				'format' => 'html',
			],
			[
				'attribute'=>'POSART',
				'label' => 'Art. Nr.',
			],
			[
				'attribute'=>'POSTEXT',
				'label' => 'Bezeichnung / Grund der Reklamation',
				'value' => nl2br($model->POSTEXT),
				'format' => 'html',
			],
			[
				'attribute' => 'MENGE',
				'label' => 'Menge',
				'format' => ['decimal',2],
			],
			[
				'attribute' => 'MASSEINH',
				'label' => 'Einheit',
			],

            [
                'attribute' => 'PONO',
                'label' => 'Position als <i>erledigt</i> ausbuchen',
                'format' => 'html',
                'value' => Html::a('<span class="glyphicon glyphicon-check btn-lg btn-success"></span>', ['rekl_update','id'=>$model->PONO, 'type'=>$type]),
            ],
			
	]
	
]);


