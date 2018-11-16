<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BdeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bde-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'LBNO') ?>

    <?= $form->field($model, 'ORNO') ?>

    <?= $form->field($model, 'STATUS') ?>

    <?= $form->field($model, 'WPLACE') ?>

    <?= $form->field($model, 'PERSNO') ?>

    <?php // echo $form->field($model, 'PERSNAME') ?>

    <?php // echo $form->field($model, 'OPNO') ?>

    <?php // echo $form->field($model, 'NAME') ?>

    <?php // echo $form->field($model, 'MSTIME') ?>

    <?php // echo $form->field($model, 'MSINFO') ?>

    <?php // echo $form->field($model, 'ORNAME') ?>

    <?php // echo $form->field($model, 'APARTS') ?>

    <?php // echo $form->field($model, 'GPARTS') ?>

    <?php // echo $form->field($model, 'BPARTS') ?>

    <?php // echo $form->field($model, 'ATE') ?>

    <?php // echo $form->field($model, 'ATR') ?>

    <?php // echo $form->field($model, 'ATP') ?>

    <?php // echo $form->field($model, 'ADCSTAT') ?>

    <?php // echo $form->field($model, 'ADCCOUNT') ?>

    <?php // echo $form->field($model, 'ADCMESS') ?>

    <?php // echo $form->field($model, 'ADCWORK') ?>

    <?php // echo $form->field($model, 'EXSTAT') ?>

    <?php // echo $form->field($model, 'MTIME0') ?>

    <?php // echo $form->field($model, 'MTIME1') ?>

    <?php // echo $form->field($model, 'MTIME2') ?>

    <?php // echo $form->field($model, 'MTIME3') ?>

    <?php // echo $form->field($model, 'OPOPNO') ?>

    <?php // echo $form->field($model, 'OUT') ?>

    <?php // echo $form->field($model, 'FNPK') ?>

    <?php // echo $form->field($model, 'MSGID') ?>

    <?php // echo $form->field($model, 'FKLBNO') ?>

    <?php // echo $form->field($model, 'TERMINAL') ?>

    <?php // echo $form->field($model, 'ISINTERNAL') ?>

    <?php // echo $form->field($model, 'CNAME') ?>

    <?php // echo $form->field($model, 'CHNAME') ?>

    <?php // echo $form->field($model, 'CDATE') ?>

    <?php // echo $form->field($model, 'CHDATE') ?>

    <?php // echo $form->field($model, 'MANDANTNO') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
