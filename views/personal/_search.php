<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PersonalSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="personal-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'NO') ?>

    <?= $form->field($model, 'PERSNO') ?>

    <?= $form->field($model, 'FIRSTNAME') ?>

    <?= $form->field($model, 'SURNAME') ?>

    <?= $form->field($model, 'BITMAP') ?>

    <?php // echo $form->field($model, 'CALNO') ?>

    <?php // echo $form->field($model, 'CNTRYSIGN') ?>

    <?php // echo $form->field($model, 'CONO') ?>

    <?php // echo $form->field($model, 'COSTNO') ?>

    <?php // echo $form->field($model, 'COSTPH1') ?>

    <?php // echo $form->field($model, 'COSTPH2') ?>

    <?php // echo $form->field($model, 'COSTPH3') ?>

    <?php // echo $form->field($model, 'DEPTNO') ?>

    <?php // echo $form->field($model, 'EFC') ?>

    <?php // echo $form->field($model, 'FAX') ?>

    <?php // echo $form->field($model, 'GROUPNO') ?>

    <?php // echo $form->field($model, 'INTMAIL1') ?>

    <?php // echo $form->field($model, 'MODEM') ?>

    <?php // echo $form->field($model, 'PDAYDAT1') ?>

    <?php // echo $form->field($model, 'PDAYDAT2') ?>

    <?php // echo $form->field($model, 'PDAYDAT3') ?>

    <?php // echo $form->field($model, 'PDAYINF1') ?>

    <?php // echo $form->field($model, 'PDAYINF2') ?>

    <?php // echo $form->field($model, 'PDAYINF3') ?>

    <?php // echo $form->field($model, 'PEINFO') ?>

    <?php // echo $form->field($model, 'PHONE1') ?>

    <?php // echo $form->field($model, 'PHONE2') ?>

    <?php // echo $form->field($model, 'PHONE3') ?>

    <?php // echo $form->field($model, 'PLACE') ?>

    <?php // echo $form->field($model, 'POSITION') ?>

    <?php // echo $form->field($model, 'POSTCODE') ?>

    <?php // echo $form->field($model, 'SALUTE') ?>

    <?php // echo $form->field($model, 'SBREAK') ?>

    <?php // echo $form->field($model, 'SEX') ?>

    <?php // echo $form->field($model, 'SHIFTNO') ?>

    <?php // echo $form->field($model, 'STATUS1') ?>

    <?php // echo $form->field($model, 'STATUS2') ?>

    <?php // echo $form->field($model, 'STATUS3') ?>

    <?php // echo $form->field($model, 'STREET') ?>

    <?php // echo $form->field($model, 'WENDH') ?>

    <?php // echo $form->field($model, 'WENDT') ?>

    <?php // echo $form->field($model, 'WSTARTH') ?>

    <?php // echo $form->field($model, 'WSTARTT') ?>

    <?php // echo $form->field($model, 'CNAME') ?>

    <?php // echo $form->field($model, 'CHNAME') ?>

    <?php // echo $form->field($model, 'CDATE') ?>

    <?php // echo $form->field($model, 'CHDATE') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
