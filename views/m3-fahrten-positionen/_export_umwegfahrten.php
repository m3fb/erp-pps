<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\user;

$gridcolumns = [
	['class' => 'yii\grid\SerialColumn'],
	[
		'attribute'=>'username',
		'label'=>'Name, Vorname',
		'value'=> function($model){
				$user= User::findByUsername($model->username);
				$ausgabe =$user['surename'].', '.$user['firstname'];
				return $ausgabe;
		},
		'format' => 'raw',
		'group' => true,
		'groupFooter'=>function ($model, $key, $index, $widget) { // Closure method
				$user= User::findByUsername($model->username);
				return [
						'mergeColumns'=>[[4,6]], // columns to merge in summary
						'content'=>[             // content to show in each summary cell
								1=>'Summe (' . $user['surename'].', '.$user['firstname'] . ')',
								5=>GridView::F_SUM,
						],
						'contentFormats'=>[      // content reformatting for each summary cell
								5=>['format'=>'number', 'decimals'=>2, 'decPoint'=>',', 'thousandSep'=>'.'],
						],
						'contentOptions'=>[      // content html attributes for each summary cell
								1=>['style'=>'font-variant:small-caps'],
								4=>['style'=>'text-align:right'],
						],
						// html attributes for group summary row
						'options'=>['class'=>'danger','style'=>'font-weight:bold;']
				];
		}
	],
	[
		'attribute' => 'Fahrtdatum',
					'format' => 'datetime',
	],
	[
		'attribute' => 'von_Adresse1',
					'label'=>'von',
					'format' => 'html',
					'value'=>function ($model) {
						$adresse = $model->von_Adresse1.'<br>'.
									$model->von_Strasse.'<br>'.
									$model->von_PLZ.' '.$model->von_Ort;
						return $adresse;
					},

	],
	[
		'attribute' => 'nach_Adresse1',
					'label'=>'nach',
					'format' => 'html',
					'value'=>function ($model) {
						$adresse = $model->nach_Adresse1.'<br>'.
									$model->nach_Strasse.'<br>'.
									$model->nach_PLZ.' '.$model->nach_Ort;
						return $adresse;
					},

	],
	[
		'value' => function ($model){
			return 7;
		},
		'class' => 'skip-export',
		'label' => 'Verguetung',
		'hAlign' => 'right',
		'hidden' => true,
	],
	[
		'attribute' => 'Entfernung',
					'label'=>'Vergütung [EUR]',
					'hAlign' => 'right',
					'format' => 'html',
					'value'=>function ($model) {
							return Yii::$app->formatter->asDecimal(7);
							#return 7;
					},
	]
];

?>

<div>
	<?php
	echo GridView::widget([
		'dataProvider' => $dataProvider,
		'pjax'=>true,
		'summary' => '',
		'columns' => $gridcolumns,
		'toolbar'=> false,
		'panel' => [
			'heading'=>'<h3 class="panel-title">Umwegfahrten mit priv. PKW</h3>',
			'type'=>'default',
			'before' => false,
			'after' => false,
			'footer'=>false,
			],
	]);
	 ?>
</div>
