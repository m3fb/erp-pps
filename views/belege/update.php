<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\grid\EditableColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PersonalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $paPaperModel->TXTNUMMER;
$this->params['breadcrumbs'][] = ['label' => 'Belege', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

//Belegstatus:

// Wenn noch keine Position beliefert wurde = offen = 0 Farbe: rot

// Wenn mindestens eine Postion beliefert wurde oder Teillieferung gespeichert wurde,
// Status = in Arbeit = 1 Farbe: gelb

// Wenn alle Postionen beliefert wurden und nirgends Teillieferung gespeichert wurde,
// Status = fertig = 2 Farbe: grün
if ($paPaperModel->STATUS == 0 ){
	$bgClass = 'bg-danger';
	$paPaperStatus = 'offen';
}
elseif ($paPaperModel->STATUS == 1 ){
	$bgClass = 'bg-warning';
	$paPaperStatus = 'in Arbeit';
}
else {
	$bgClass = 'bg-success';
	$paPaperStatus = 'fertig';
}

//Kopfdaten des Belegs:
$belegdaten = '<div class="col-lg-12 '.$bgClass.'"><b>Adresse: </b>'.$paPaperModel->ADDRTEXT .'<br>'.
							'<b>Beleg: </b>'.$paPaperModel->TXTIDENT.' - '.$paPaperModel->TXTNUMMER .'<br>'.
							'<b>Belegdatum: </b>'.Yii::$app->formatter->asDate($paPaperModel->ANLAGEZEIT).'<br>'.
							'<b>Status: </b>'.$paPaperStatus.'</div>';

$beleKomplettErledigen = ($paPaperModel->STATUS != 2) ? Html::a('<span class="btn btn-success">Beleg erledigt</span>',
													['done-all','PANO'=>$paPaperModel->PANO],
													[
							              'title'=>'kompletten Beleg als "erledigt" speichern',
							              'data-confirm' => Yii::t('yii',
																				'Der Beleg wird als erledigt gespeichert!
																				ACHTUNG: Das Feld "bisher geliefert" wird mit den Mengen-Werten überschrieben!'
																			),
							              'data-method' => 'post',
							              'data-pjax' => '0',
							            ]) : '';

$gridColumns =
	[
				[
					'attribute' => 'POSNO',
					'label' =>'Pos.',
				],
				[
					'attribute' => 'POSART',
					'width'=>'100px',
					'label' =>'Artikelnr.',
				],
				[
					'attribute' => 'POSTXTL',
					'label' =>'Bezeichnung',
				],
				[
					'attribute' => 'MENGE',
					'label' =>'Menge',
					'format' => 'decimal'
				],
				[
			    'class' => 'kartik\grid\EditableColumn',
			    'attribute'=>'POSLIEF0',
					'label' =>'bisher gel.',
					'format' => 'decimal',
			    'refreshGrid' => true,
			    'editableOptions' => function ($model, $key, $index, $widget) {
			      return [
			          'header' => 'bisher geliefert',
			          'value' => $model['POSLIEF0'],
			          'formOptions'=>['action' => ['/belege/editbishergeliefert']], // point to the new action
								'inputType'=>\kartik\editable\Editable::INPUT_WIDGET,
								'widgetClass'=> 'kartik\number\NumberControl',
			        ];
			    },
			  ],
				[
					'attribute' => 'POSPRT0',
					'label' =>'Teillieferung',
					'format' => 'raw',
					'value' => function ($model) {
						($model['POSPRT0']==0)? $ausgabe= '<span class="glyphicon glyphicon-unchecked"></span>' : $ausgabe= '<span class="glyphicon glyphicon-check"></span>';
						return $ausgabe;
					},
					'class' => 'kartik\grid\EditableColumn',
					'refreshGrid' => true,
			    'editableOptions' => function ($model, $key, $index, $widget) {
			      return [
			          'header' => 'Teillieferung',
			          'value' => $model['POSPRT0'],
			          'formOptions'=>['action' => ['/belege/editbishergeliefert']], // point to the new action
								'inputType'=>\kartik\editable\Editable::INPUT_RADIO_LIST,
								'data' => [1 => 'ja', 0 => 'nein'],
			        ];
			    },
				],
				[
					'attribute' => 'EINHEIT',
					'label' =>'Einheit',
					'format' => 'decimal',
				],
				[
					'attribute' => 'EPREIS',
					'label' =>'Einzelpreis',
					'format' => 'currency'
				],
				[
					'attribute' => 'GPREIS',
					'label' =>'Gesamtpreis',
					'format' => 'currency'
				],
				['class' => 'yii\grid\ActionColumn',
									'template'    => '{done-position} ',
									'buttons' => [
										'done-position' => function ($url, $model, $id) {
											return Html::a('<span class="glyphicon glyphicon-transfer"></span>',
												$url, [
													'title' =>
													'Position als erledigt speichern: "bisher geliefert" wird mit dem Mengenwert überschrieben!',
													'data-pjax' => '0',
												]);
										},
									]
				],
];


?>
<div class="beleg-position-index">

    <?= GridView::widget([
        'dataProvider' => $dataProviderPaPosit,
        'columns' => $gridColumns,
				'summary' => 'Seite {page} von {pageCount} &nbsp; Einträge {begin} - {end} von {totalCount}',
				'toolbar' => false,
				'panel' => [
					'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-list"></i>&nbsp;'. Html::encode($this->title) .'</h3>',
					'type'=>'primary',
					'before' => $belegdaten,
					'after' => $beleKomplettErledigen,
					],

    ]); ?>
</div>
