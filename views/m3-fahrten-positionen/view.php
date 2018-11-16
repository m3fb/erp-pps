<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\M3FahrtenPositionen */
$name = Yii::$app->user->identity->firstname.' '.Yii::$app->user->identity->surename;
$fahrtdatum = Yii::$app->formatter->asDate($model->Fahrtdatum);
$this->title = $name.': Fahrt mit priv. PKW vom '.$fahrtdatum;

$button2 = Html::a('<i class="glyphicon glyphicon-trash"></i>', Url::to(['delete', 'id' => $model->ID]), [
                   'title' => 'Löschen',
                   'class' => 'pull-right detail-button',
                   'data' => [
                       'confirm' => 'Are you sure you want to delete this item?',            
                       'method' => 'post',
                   ]
           ]);
$button1 = Html::a('<i class="glyphicon glyphicon-pencil"></i>', Url::to(['update', 'id' => $model->ID]), [
                   'title' => 'Aktualisieren',
                   'class' => 'pull-right detail-button',
           ]);


#$this->params['breadcrumbs'][] = ['label' => 'M3 Fahrten Positionens', 'url' => ['index']];
#$this->params['breadcrumbs'][] = $this->title;
?>
<div class="m3-fahrten-positionen-view">
	<?php 
	$attributes = [
             [
				'group'=>true,
				'label'=>'Adressen',
				'rowOptions'=>['class'=>'default']
			],
			[
				'columns' => [
						[
							'attribute' => 'von_Adresse1',
							'label' => 'von',
							'displayOnly'=>true,
							'valueColOptions'=>['style'=>'width:30%']
						],
						[
							'attribute' => 'nach_Adresse1',
							'label' => 'nach',
							'displayOnly'=>true,
							'valueColOptions'=>['style'=>'width:30%']
						],
						
					],
			],
			[
				'columns' => [
						[
							'attribute' => 'von_Adresse2',
							'label' => false,
							'displayOnly'=>true,
							'valueColOptions'=>['style'=>'width:30%']
						],
						[
							'attribute' => 'nach_Adresse2',
							'label' => false,
							'displayOnly'=>true,
							'valueColOptions'=>['style'=>'width:30%']
						],
						
					],
			],
			[
				'columns' => [
						[
							'attribute' => 'von_Strasse',
							'label' => 'Straße',
						],
						[
							'attribute' => 'nach_Strasse',
							'label' => 'Straße',
						],
						
					],
			],
		];
	?>
    <?= DetailView::widget([
        'model' => $model,
        
        'panel'=>[
			'heading'=>Html::encode($this->title),
			 'type' => DetailView::TYPE_DEFAULT,
                       'headingOptions' => [
                           'template' => "$button2 $button1 {title}"
                       ],
			
		],
        'attributes' => $attributes,
           /* 'erstellt_von',
            'Erstelldatum',
            'geaendert_von',
            'Aenderungsdatum',
            'von_Adresse1',
            'von_Adresse2',
            'von_Strasse',
            'von_PLZ',
            'von_Ort',
            'nach_Adresse1',
            'nach_Adresse2',
            'nach_Strasse',
            'nach_PLZ',
            'nach_Ort',
            'Entfernung',
            'Verguetung',
            'Typ',
            'username',
        ],*/
    ]) ?>

</div>
