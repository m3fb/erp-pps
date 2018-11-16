<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\St_stockSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="st-stock-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'NO') ?>

    <?= $form->field($model, 'ARTNO') ?>

    <?= $form->field($model, 'INCDATE') ?>

    <?= $form->field($model, 'MENGE') ?>

    <?= $form->field($model, 'OPNO') ?>

    <?php // echo $form->field($model, 'PLACE') ?>

    <?php // echo $form->field($model, 'WAREHOUSE') ?>

    <?php // echo $form->field($model, 'INFO1') ?>

    <?php // echo $form->field($model, 'INFO2') ?>

    <?php // echo $form->field($model, 'INFO3') ?>

    <?php // echo $form->field($model, 'CNAME') ?>

    <?php // echo $form->field($model, 'CHNAME') ?>

    <?php // echo $form->field($model, 'CDATE') ?>

    <?php // echo $form->field($model, 'CHDATE') ?>

    <?php // echo $form->field($model, 'MANDANTNO') ?>

    <?php // echo $form->field($model, 'REF_TMP_ISQUARANTINESTORE') ?>

    <?php // echo $form->field($model, 'INFO4') ?>

    <?php // echo $form->field($model, 'INFO5') ?>

    <?php // echo $form->field($model, 'INFO6') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
