<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProjektChecklisteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="m3-projekt-checkliste-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'WerkzeugNr') ?>

    <?= $form->field($model, 'erstellt_von') ?>

    <?= $form->field($model, 'Erstelldatum') ?>

    <?= $form->field($model, 'geaendert_von') ?>

    <?php // echo $form->field($model, 'Aenderungsdatum') ?>

    <?php // echo $form->field($model, 'Kunde') ?>

    <?php // echo $form->field($model, 'Artikelnummer') ?>

    <?php // echo $form->field($model, 'Profilbezeichnung') ?>

    <?php // echo $form->field($model, 'Vorgangsnummer') ?>

    <?php // echo $form->field($model, 'Zeichnungsnummer') ?>

    <?php // echo $form->field($model, 'Index') ?>

    <?php // echo $form->field($model, 'geforderterMindestausstoss') ?>

    <?php // echo $form->field($model, 'kalkulierterAusschuss') ?>

    <?php // echo $form->field($model, 'geplanterExtruder') ?>

    <?php // echo $form->field($model, 'Einheit') ?>

    <?php // echo $form->field($model, 'RM1_Art_Nr') ?>

    <?php // echo $form->field($model, 'RM2_Art_Nr') ?>

    <?php // echo $form->field($model, 'RM3_Art_Nr') ?>

    <?php // echo $form->field($model, 'CU1_Art_Nr') ?>

    <?php // echo $form->field($model, 'CU2_Art_Nr') ?>

    <?php // echo $form->field($model, 'CU_3_Art_Nr') ?>

    <?php // echo $form->field($model, 'RM1_Bezeichnung') ?>

    <?php // echo $form->field($model, 'RM2_Bezeichnung') ?>

    <?php // echo $form->field($model, 'RM3_Bezeichnung') ?>

    <?php // echo $form->field($model, 'CU1_Bezeichnung') ?>

    <?php // echo $form->field($model, 'CU2_Bezeichnung') ?>

    <?php // echo $form->field($model, 'CU3_Bezeichnung') ?>

    <?php // echo $form->field($model, 'RM1_Gewicht') ?>

    <?php // echo $form->field($model, 'RM2_Gewicht') ?>

    <?php // echo $form->field($model, 'RM3_Gewicht') ?>

    <?php // echo $form->field($model, 'RM_gesamt') ?>

    <?php // echo $form->field($model, 'CU_gesamt') ?>

    <?php // echo $form->field($model, 'Gewicht_gesamt') ?>

    <?php // echo $form->field($model, 'Peripherie') ?>

    <?php // echo $form->field($model, 'Versandadresse_Muster') ?>

    <?php // echo $form->field($model, 'Kontaktperson') ?>

    <?php // echo $form->field($model, 'Mindestbestellmenge') ?>

    <?php // echo $form->field($model, 'Lieferbedingungen') ?>

    <?php // echo $form->field($model, 'Zahlungsbed_Werkzeug') ?>

    <?php // echo $form->field($model, 'Muster_Kunde_Anz') ?>

    <?php // echo $form->field($model, 'Muster_Vermess_Anz') ?>

    <?php // echo $form->field($model, 'Muster_Verbleib_Anz') ?>

    <?php // echo $form->field($model, 'Muster_Kunde_Laenge') ?>

    <?php // echo $form->field($model, 'Muster_Vermess_Laenge') ?>

    <?php // echo $form->field($model, 'Muster_Verbleib_Laenge') ?>

    <?php // echo $form->field($model, 'sonst_Info_Bemusterung') ?>

    <?php // echo $form->field($model, 'Verpackung_Muster') ?>

    <?php // echo $form->field($model, 'Verpackung_Serie') ?>

    <?php // echo $form->field($model, 'Verp_stellt_Kunde') ?>

    <?php // echo $form->field($model, 'Verp_zahl_Kunde') ?>

    <?php // echo $form->field($model, 'erste_Serien_Menge') ?>

    <?php // echo $form->field($model, 'Termin_Konst_Ende') ?>

    <?php // echo $form->field($model, 'Termin_Konst_Dauer') ?>

    <?php // echo $form->field($model, 'Termin_WZBau_Ende') ?>

    <?php // echo $form->field($model, 'Termin_WZBau_Dauer') ?>

    <?php // echo $form->field($model, 'Termin_RM_Ende') ?>

    <?php // echo $form->field($model, 'Termin_RM_Dauer') ?>

    <?php // echo $form->field($model, 'Termin_Vorrichtung_Ende') ?>

    <?php // echo $form->field($model, 'Termin_Vorrichtung_Dauer') ?>

    <?php // echo $form->field($model, 'Termin_int_Bem_Ende') ?>

    <?php // echo $form->field($model, 'Termin_int_Bem_Dauer') ?>

    <?php // echo $form->field($model, 'Termin_ext_Bem_Ende') ?>

    <?php // echo $form->field($model, 'Termin_ext_Bem_Dauer') ?>

    <?php // echo $form->field($model, 'Termin_Pruefber_Ende') ?>

    <?php // echo $form->field($model, 'Termin_Pruefber_Dauer') ?>

    <?php // echo $form->field($model, 'sonst_Info_allg') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
