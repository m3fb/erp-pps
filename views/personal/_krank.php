<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\bootstrap\BootstrapPluginAsset;

/* @var $this yii\web\View */
/* @var $model app\models\Personal */
/* @var $form yii\widgets\ActiveForm */
$monats_label = array(
						1 => 'Jan.',
						2 => 'Feb.',
						3 => 'Mrz.',
						4 => 'Apr.',
						5 => 'Mai',
						6 => 'Jun.',
						7 => 'Jul.',
						8 => 'Aug.',
						9 => 'Sep.',
						10 => 'Okt.',
						11 => 'Nov.',
						12 => 'Dez.'
						);


$gridColumns[] = [
	'attribute'=>'Jahr',
	'contentOptions'=>['style'=>'font-weight:bold'],
];
for ($i=1; $i <= 12 ; $i++) {
	$monatsnummer = sprintf('%02d',$i);
	$gridColumns[] = [
		'attribute' =>$monatsnummer,
		'label' =>	$monats_label[$i],
	];
}
$gridColumns[] = [
	'attribute'=>'Summe',
	'contentOptions'=>['style'=>'font-weight:bold'],
];

?>



<div class="personal-krankdaten">

	<?= GridView::widget([
	 'dataProvider' => $krank,
	 'toolbar' => false,
	 'summary' =>'',
	 'panel' => [
		 'heading'=>'<h3 class="panel-title">Krankheitstage</h3>',
		 'type'=>'primary',
		 'footer'=> false,
	 ],
	 'rowOptions'=>function($model){
            if($model['Jahr'] == date('Y')){
                return ['class' => 'danger'];
            }
					},
	 'columns' => $gridColumns,
]); ?>


	<div style="height:10px;">&nbsp;</div>
</div>
