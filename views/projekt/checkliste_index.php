<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjektChecklisteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'm3profile Projekt Checklisten';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="m3-projekt-checkliste-index">

  
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'toolbar' =>  [
			['content' => 
				Html::a('<i class="glyphicon glyphicon-arrow-left"></i>', ['index'],['type' => 'button', 'class' => 'btn btn-primary']). ' '.
				Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],['type' => 'button', 'class' => 'btn btn-success'])
			],
		],
		'panel' => [
				'type' => GridView::TYPE_PRIMARY,
				'heading' => $this->title,
			],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'ID',
            'WerkzeugNr',
            'Kunde',
            //'Artikelnummer',
            'Profilbezeichnung',
            [
				'attribute' => 'Termin_Pruefber_Ende',
				'label' => 'Termin Prüfbericht',
				'format' => 'date',
			],
            [
				'attribute' => 'erstellt_von',
				'label' => 'Erstellt',
				'width'=>'120px',
				'value'=>function ($model, $key, $index, $widget) { 
				$ausgabe = $model->user->firstname." ".$model->user->surename;
                return $ausgabe;
            },
				'format' => 'html',
			],
			[
				'attribute' => 'Erstelldatum',
				'label' => 'Erstelldatum',
				'format' => 'datetime',
			],
            //'Vorgangsnummer',
            //'Zeichnungsnummer',
            //'Index',
            //'geforderterMindestausstoss',
            //'kalkulierterAusschuss',
            //'geplanterExtruder',
            //'Einheit',
            //'RM1_Art_Nr',
            //'RM2_Art_Nr',
            //'RM3_Art_Nr',
            //'CU1_Art_Nr',
            //'CU2_Art_Nr',
            //'CU_3_Art_Nr',
            //'RM1_Bezeichnung',
            //'RM2_Bezeichnung',
            //'RM3_Bezeichnung',
            //'CU1_Bezeichnung',
            //'CU2_Bezeichnung',
            //'CU3_Bezeichnung',
            //'RM1_Gewicht',
            //'RM2_Gewicht',
            //'RM3_Gewicht',
            //'RM_gesamt',
            //'CU_gesamt',
            //'Gewicht_gesamt',
            //'Peripherie',
            //'Versandadresse_Muster',
            //'Kontaktperson',
            //'Mindestbestellmenge',
            //'Lieferbedingungen',
            //'Zahlungsbed_Werkzeug',
            //'Muster_Kunde_Anz',
            //'Muster_Vermess_Anz',
            //'Muster_Verbleib_Anz',
            //'Muster_Kunde_Laenge',
            //'Muster_Vermess_Laenge',
            //'Muster_Verbleib_Laenge',
            //'sonst_Info_Bemusterung',
            //'Verpackung_Muster',
            //'Verpackung_Serie',
            //'Verp_stellt_Kunde',
            //'Verp_zahl_Kunde',
            //'erste_Serien_Menge',
            //'Termin_Konst_Ende',
            //'Termin_Konst_Dauer',
            //'Termin_WZBau_Ende',
            //'Termin_WZBau_Dauer',
            //'Termin_RM_Ende',
            //'Termin_RM_Dauer',
            //'Termin_Vorrichtung_Ende',
            //'Termin_Vorrichtung_Dauer',
            //'Termin_int_Bem_Ende',
            //'Termin_int_Bem_Dauer',
            //'Termin_ext_Bem_Ende',
            //'Termin_ext_Bem_Dauer',
            //'Termin_Pruefber_Ende',
            //'Termin_Pruefber_Dauer',
            //'sonst_Info_allg',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
