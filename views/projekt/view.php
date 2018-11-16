<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\M3ProjektCheckliste */

$this->title = $model->WerkzeugNr;
$this->params['breadcrumbs'][] = ['label' => 'm3-Projekt Checklisten', 'url' => ['checkliste_index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="m3-projekt-checkliste-view">

    <p>
        <?= Html::a('Ändern', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Löschen', ['delete', 'id' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
	<?php 
	$attributes = [
             [
				'group'=>true,
				'label'=>'Allgemeine Informationen',
				'rowOptions'=>['class'=>'info']
			],
			[
				'columns' => [
					[
						'attribute'=>'Kunde', 
						'label'=>'Kunde',
					],
				],
			],
			[
			'columns' => [
					[
						'attribute'=>'Vorgangsnummer', 
						'label'=>'Vorgangsnummer',
					],
					[
						'attribute'=>'Artikelnummer', 
						'label'=>'Art. Nr.',
					],
					[
						'attribute'=>'Profilbezeichnung', 
						'label'=>'Profilbezeichnung',
					],
				],
			],
			[
 			'columns' => [
					[
						'attribute'=>'Zeichnungsnummer', 
						'label'=>'Zeichnungsnr.',
					],
					[
						'attribute'=>'Index', 
						'label'=>'Index',
					],
				],
			],
			[
				'group'=>true,
				'label'=>'Informationen für Produktion und Technikum',
				'rowOptions'=>['class'=>'info']
			],
			[
				'columns' => [
					[
						'attribute'=>'geforderterMindestausstoss', 
						'label'=>'geford. Mindestausst. [m/min]',
					],
					[
						'attribute'=>'kalkulierterAusschuss', 
						'label'=>'kalk. Ausschuss [%]',
					],
					[
						'attribute'=>'Einheit', 
						'label'=>'Einheit',
						'value' => $model->Einheit==0 ? 'Stück' : 'Meter',
						'valueColOptions'=>['style'=>'width:30%']
					],
				],
			],
			[
			'columns' => [
					[
						'attribute'=>'geplanterExtruder', 
						'label'=>'gepl. Extruder',
					]
				],
			],
			[
				'group'=>true,
				'label'=>'<div class="col-md-2"><label>Gewicht / Bedarfe</label></div>
						  <div class="col-md-4"><label>Art. Nr.</label></div>
						  <div class="col-md-5"><label>Bezeichnung</label></div>
						  <div class="col-md-1"><label>[g/m]</label></div>',
				'rowOptions'=>['class'=>'default']
			],
			[
 			'columns' => [
					[ 
						'attribute'=>'RM1_Art_Nr',
						'label'=>'Kunststoff 1',
						'valueColOptions'=>['style'=>'width:50px'],
					],
					[
						'attribute'=>'RM1_Bezeichnung', 
						'label'=>false, 
						'valueColOptions'=>['style'=>'width:150px'],
						'labelColOptions'=>['style'=>'width:50px'],
					],
					[
						'attribute'=>'RM1_Gewicht', 
						'label'=>false,
						'valueColOptions'=>['style'=>'width:50px'],
						'labelColOptions'=>['style'=>'width:50px'],
					],
				],
			],
			[
 			'columns' => [
					[ 
						'attribute'=>'RM2_Art_Nr',
						'label'=>'Kunststoff 2',
						'valueColOptions'=>['style'=>'width:50px'],
					],
					[
						'attribute'=>'RM2_Bezeichnung', 
						'label'=>false,
						'valueColOptions'=>['style'=>'width:150px'],
						'labelColOptions'=>['style'=>'width:50px'],
					],
					[
						'attribute'=>'RM2_Gewicht', 
						'label'=>false,
						'valueColOptions'=>['style'=>'width:50px'],
						'labelColOptions'=>['style'=>'width:50px'], 
					],
				],
			],
			[
 			'columns' => [
					[ 
						'attribute'=>'CU1_Art_Nr',
						'label'=>'Kupfer 1',
						'valueColOptions'=>['style'=>'width:50px'],
					],
					[
						'attribute'=>'CU1_Bezeichnung', 
						'label'=>false,
						'valueColOptions'=>['style'=>'width:150px'],
						'labelColOptions'=>['style'=>'width:50px'],
					],
					[
						'attribute'=>'CU1_Gewicht', 
						'label'=>false,
						'valueColOptions'=>['style'=>'width:50px'],
						'labelColOptions'=>['style'=>'width:50px'], 
					],
				],
			],
			[
 			'columns' => [
					[ 
						'attribute'=>'CU2_Art_Nr',
						'label'=>'Kupfer 2',
						'valueColOptions'=>['style'=>'width:50px'],
					],
					[
						'attribute'=>'CU2_Bezeichnung', 
						'label'=>false,
						'valueColOptions'=>['style'=>'width:150px'],
						'labelColOptions'=>['style'=>'width:50px'],
					],
					[
						'attribute'=>'CU2_Gewicht', 
						'label'=>false,
						'valueColOptions'=>['style'=>'width:50px'],
						'labelColOptions'=>['style'=>'width:50px'], 
					],
				],
			],
			[
 			'columns' => [
					[ 
						'attribute'=>'Gewicht_gesamt',
						'label'=>'Gewich gesamt',
						'labelColOptions'=>['style'=>'width:90%; text-align:right;'],
						'valueColOptions'=>['style'=>'width:50px'],
					],
				],
			],
			[
 			'columns' => [
					[ 
						'attribute'=>'Peripherie',
						'label'=>'Peripherie / Weiterbearb.',
					],
				],
			],
			[
				'group'=>true,
				'label'=>'Auftragsbestätigung an Kunden',
				'rowOptions'=>['class'=>'info']
			],
			[
				'attribute'=>'Versandadresse_Muster', 
				'label'=>'Versandadr. Musterteile',
				'format'=>'ntext', // the value is formatted as an HTML-encoded plain text with newlines converted into line breaks.
			],
			[
				'attribute'=>'Kontaktperson', 
				'label'=>'Kontaktperson',
			],
			[
 			'columns' => [
					[ 
						'attribute'=>'Mindestbestellmenge',
						'label'=>'Mindestbestellmenge',
					],
					[ 
						'attribute'=>'Lieferbedingungen',
						'label'=>'Lieferbedingungen',
						'value' => $model->Lieferbedingungen==0 ? 'DDP' : 'EXW',
					],
					[ 
						'attribute'=>'Zahlungsbed_Werkzeug',
						'label'=>'Zahlungsbed. Werkzeug',
					],
				],
			],
			[
				'group'=>true,
				'label'=>'Informationen für Bemusterung / QS',
				'rowOptions'=>['class'=>'info']
			],
			[
				'columns' => [
					[
						'attribute'=>'Muster_Kunde_Anz', 
						'label'=>'Anzahl Muster Kunde',
					],
					[
						'attribute'=>'Muster_Kunde_Laenge', 
						'label'=>'Länge [mm]',
					],
				],
			],
			[
				'columns' => [
					[
						'attribute'=>'Muster_Vermess_Anz', 
						'label'=>'Anzahl Muster z. Vermessen',
					],
					[
						'attribute'=>'Muster_Vermess_Laenge', 
						'label'=>'Länge [mm]',
					],
				],
			],
			[
				'columns' => [
					[
						'attribute'=>'Muster_Verbleib_Anz', 
						'label'=>'Anzahl Muster Verbleib m3',
					],
					[
						'attribute'=>'Muster_Verbleib_Laenge', 
						'label'=>'Länge [mm]',
					],
				],
			],
			[
				'attribute'=>'sonst_Info_Bemusterung', 
				'label'=>'sonstige Infos*',
				'format'=>'ntext', // the value is formatted as an HTML-encoded plain text with newlines converted into line breaks.
			],
			[
				'group'=>true,
				'label'=>'<div class="col-md-12" style="font-weight:normal;"><small><i>*z.B. 100% Prüfung, kritische funtionsr. Merkmale,FMEA, IMDS, 
							Kugeldruckprüfung, Geruch RPZ-Vorgabe, Kunden EMP, 
							Prüfmittel festlegen, Arbeitsabläufe definieren</i></small></div>',
				'rowOptions'=>['class'=>'default']
			],
			[
				'attribute'=>'Verpackung_Muster', 
				'label'=>'Verpackung Musterteile',
			],
			[
				'attribute'=>'Verpackung_Serie', 
				'label'=>'Verpackung Serienteile',
			],
			[
				'columns' => [
					[
						'attribute'=>'Verp_stellt_Kunde', 
						'label'=>'Verp. stellt Kunde',
						'value' => $model->Verp_stellt_Kunde==0 ? 'Nein' : 'Ja',
					],
					[
						'attribute'=>'Verp_zahl_Kunde', 
						'label'=>'Verp. zahlt Kunde',
						'value' => $model->Verp_zahl_Kunde==0 ? 'Nein' : 'Ja',
					],
					[
						'attribute'=>'erste_Serien_Menge', 
						'label'=>'1. Serienmenge',
					]
				],
			],
			[
				'group'=>true,
				'label'=>'Informationen Termine',
				'rowOptions'=>['class'=>'info']
			],
			[
				'columns' => [
					[
						'attribute'=>'Termin_Konst_Ende', 
						'label'=>'Konstruktion',
						'format'=>'date',
						'valueColOptions'=>['style'=>'width:16%'],
						'labelColOptions'=>['style'=>'width:16%; text-align:right;'],
					],
					[
						'attribute'=>'Termin_WZBau_Ende', 
						'label'=>'Werkzeugbau',
						'format'=>'date',
						'valueColOptions'=>['style'=>'width:16%'],
						'labelColOptions'=>['style'=>'width:16%; text-align:right;'],
					],
					[
						'attribute'=>'Termin_RM_Ende', 
						'label'=>'Rohmaterial',
						'format'=>'date',
						'valueColOptions'=>['style'=>'width:16%'],
						'labelColOptions'=>['style'=>'width:16%; text-align:right;'],
					],
				],
			],
			[
				'columns' => [
					[
						'attribute'=>'Termin_Vorrichtung_Ende', 
						'label'=>'Vorrichtung',
						'format'=>'date',
						'valueColOptions'=>['style'=>'width:16%'],
						'labelColOptions'=>['style'=>'width:16%; text-align:right;'],
					],
					[
						'attribute'=>'Termin_int_Bem_Ende', 
						'label'=>'int. Bemusterung',
						'format'=>'date',
						'valueColOptions'=>['style'=>'width:16%'],
						'labelColOptions'=>['style'=>'width:16%; text-align:right;'],
					],
					[
						'attribute'=>'Termin_ext_Bem_Ende', 
						'label'=>'ext. Bemusterung',
						'format'=>'date',
						'valueColOptions'=>['style'=>'width:16%'],
						'labelColOptions'=>['style'=>'width:16%; text-align:right;'],
					],
				],
			],
			[
				'columns' => [
					[
						'attribute'=>'Termin_Pruefber_Ende', 
						'label'=>'Prüfbericht',
						'format'=>'date',
						'valueColOptions'=>['style'=>'width:83%'],
						'labelColOptions'=>['style'=>'width:17%; text-align:right;'],
					],
				],
			],
			[
				'group'=>true,
				'label'=>'sonstige Informationen',
				'rowOptions'=>['class'=>'info']
			],
			[
				'attribute'=>'sonst_Info_allg', 
				'label'=>'sonstige Infos',
				'format'=>'ntext', // the value is formatted as an HTML-encoded plain text with newlines converted into line breaks.
			],
				
			  
        ];
        

        
	?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
        'panel'=>[
			'heading'=>'<i class="glyphicon glyphicon-align-center"></i>&nbsp' . $model->WerkzeugNr.
						'<small><i> Erstellt von '. $model->user->firstname.' '. $model->user->surename.
						' am '.Yii::$app->formatter->asDateTime($model->Erstelldatum).
						' / geändert von '.$model->changer->firstname.' '. $model->changer->surename.
						' am '.Yii::$app->formatter->asDateTime($model->Aenderungsdatum).'</i></small>',
			'type' => DetailView::TYPE_PRIMARY,
		],
		'enableEditMode'=>false,
        
    ]) ?>

</div>
