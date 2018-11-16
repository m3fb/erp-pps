<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\M3FahrtenPositionenSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="m3-fahrten-positionen-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'Status') ?>

    <?= $form->field($model, 'BelegID') ?>

    <?= $form->field($model, 'erstellt_von') ?>

    <?= $form->field($model, 'Erstelldatum') ?>

    <?php // echo $form->field($model, 'geaendert_von') ?>

    <?php // echo $form->field($model, 'Aenderungsdatum') ?>

    <?php // echo $form->field($model, 'von_Adresse1') ?>

    <?php // echo $form->field($model, 'von_Adresse2') ?>

    <?php // echo $form->field($model, 'von_Strasse') ?>

    <?php // echo $form->field($model, 'von_PLZ') ?>

    <?php // echo $form->field($model, 'von_Ort') ?>

    <?php // echo $form->field($model, 'nach_Adresse1') ?>

    <?php // echo $form->field($model, 'nach_Adresse2') ?>

    <?php // echo $form->field($model, 'nach_Strasse') ?>

    <?php // echo $form->field($model, 'nach_PLZ') ?>

    <?php // echo $form->field($model, 'nach_Ort') ?>

    <?php // echo $form->field($model, 'Entfernung') ?>

    <?php // echo $form->field($model, 'Verguetung') ?>

    <?php // echo $form->field($model, 'Typ') ?>

    <?php // echo $form->field($model, 'username') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
