<?php

use yii\helpers\Html;
use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $model app\models\Ororder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bericht-kaufteile" style='margin-top:10px; text-align:left;'>

    <?= GridView::widget([
        'dataProvider' => $model,
        'panel' => [
			'heading'=>'<h6 class="panel-title"><i class="glyphicon glyphicon-shopping-cart"></i>&nbsp; offene Bestellungen</h6>',
			'type'=>'success',
			'footer'=>false,
			'before'=>false,
			'after'=>false,
			],
		'toolbar'=>false,
		'summary'=>false,
        'columns' => [
			[
				'attribute' => 'ADDRTEXT',
				'label' => 'Lieferant',
				'value'=>function ($model, $key, $index, $widget) { 
					$adresse_array = explode ("\r\n",$model['ADDRTEXT']);
					$adresse = $adresse_array[0];
					return $adresse;
				},
				'format' => 'text',
			],	
			[
				'attribute' => 'TXTNUMMER',
				'label' => 'Best.-Nr.',
				'format' => 'text',
			],		
			[
				'attribute'=>'POSDAT', 
				'value'=>function ($model, $key, $index, $widget) { 
					$datum = Yii::$app->formatter->asDate($model['POSDAT'],'medium');
					$model['POSDAT'] < date('Y-m-d') ? $color = 'red' : $color = 'black';
					$ausgabe = '<font color="'.$color.'">'.$datum .'</font>';
					return $ausgabe;
				},
				'format' => 'html',
				'label' => 'Liefertermin',
			],
			[
				'attribute' => 'MENGE',
				'label' => 'Sollmenge',
				'format' => ['decimal',2],
			],
			[
				'attribute' => 'POSLIEF0',
				'label' => 'Geliefert',
				'format' => ['decimal',2],
			],
            [
				
				'value' => function ($model){
					$rueckstand = $model['MENGE'] - $model['POSLIEF0'];
					return $rueckstand;
				},
				'label' => 'Rückstand',
				'format' => ['decimal',2],
				'hAlign' => 'right',
				'contentOptions' => ['style'=>'text-align: right; font-weight:bold;'],
			],
			
        ],
        
	]); 
		?>
</div>
