<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Personal */
/* @var $form yii\widgets\ActiveForm*/
# Entwicklungsstatus
?>

<div class="personal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'NO')->textInput() ?>

    <?= $form->field($model, 'PERSNO')->textInput() ?>

    <?= $form->field($model, 'FIRSTNAME')->textInput() ?>

    <?= $form->field($model, 'SURNAME')->textInput() ?>

    <?= $form->field($model, 'BITMAP')->textInput() ?>

    <?= $form->field($model, 'CALNO')->textInput() ?>

    <?= $form->field($model, 'CNTRYSIGN')->textInput() ?>

    <?= $form->field($model, 'CONO')->textInput() ?>

    <?= $form->field($model, 'COSTNO')->textInput() ?>

    <?= $form->field($model, 'COSTPH1')->textInput() ?>

    <?= $form->field($model, 'COSTPH2')->textInput() ?>

    <?= $form->field($model, 'COSTPH3')->textInput() ?>

    <?= $form->field($model, 'DEPTNO')->textInput() ?>

    <?= $form->field($model, 'EFC')->textInput() ?>

    <?= $form->field($model, 'FAX')->textInput() ?>

    <?= $form->field($model, 'GROUPNO')->textInput() ?>

    <?= $form->field($model, 'INTMAIL1')->textInput() ?>

    <?= $form->field($model, 'MODEM')->textInput() ?>

    <?= $form->field($model, 'PDAYDAT1')->textInput() ?>

    <?= $form->field($model, 'PDAYDAT2')->textInput() ?>

    <?= $form->field($model, 'PDAYDAT3')->textInput() ?>

    <?= $form->field($model, 'PDAYINF1')->textInput() ?>

    <?= $form->field($model, 'PDAYINF2')->textInput() ?>

    <?= $form->field($model, 'PDAYINF3')->textInput() ?>

    <?= $form->field($model, 'PEINFO')->textInput() ?>

    <?= $form->field($model, 'PHONE1')->textInput() ?>

    <?= $form->field($model, 'PHONE2')->textInput() ?>

    <?= $form->field($model, 'PHONE3')->textInput() ?>

    <?= $form->field($model, 'PLACE')->textInput() ?>

    <?= $form->field($model, 'POSITION')->textInput() ?>

    <?= $form->field($model, 'POSTCODE')->textInput() ?>

    <?= $form->field($model, 'SALUTE')->textInput() ?>

    <?= $form->field($model, 'SBREAK')->textInput() ?>

    <?= $form->field($model, 'SEX')->textInput() ?>

    <?= $form->field($model, 'SHIFTNO')->textInput() ?>

    <?= $form->field($model, 'STATUS1')->textInput() ?>

    <?= $form->field($model, 'STATUS2')->textInput() ?>

    <?= $form->field($model, 'STATUS3')->textInput() ?>

    <?= $form->field($model, 'STREET')->textInput() ?>

    <?= $form->field($model, 'WENDH')->textInput() ?>

    <?= $form->field($model, 'WENDT')->textInput() ?>

    <?= $form->field($model, 'WSTARTH')->textInput() ?>

    <?= $form->field($model, 'WSTARTT')->textInput() ?>

    <?= $form->field($model, 'CNAME')->textInput() ?>

    <?= $form->field($model, 'CHNAME')->textInput() ?>

    <?= $form->field($model, 'CDATE')->textInput() ?>

    <?= $form->field($model, 'CHDATE')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
