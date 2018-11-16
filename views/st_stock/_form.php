<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\St_stock */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="st-stock-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'NO')->textInput() ?>

    <?= $form->field($model, 'ARTNO')->textInput() ?>

    <?= $form->field($model, 'INCDATE')->textInput() ?>

    <?= $form->field($model, 'MENGE')->textInput() ?>

    <?= $form->field($model, 'OPNO')->textInput() ?>

    <?= $form->field($model, 'PLACE')->textInput() ?>

    <?= $form->field($model, 'WAREHOUSE')->textInput() ?>

    <?= $form->field($model, 'INFO1')->textInput() ?>

    <?= $form->field($model, 'INFO2')->textInput() ?>

    <?= $form->field($model, 'INFO3')->textInput() ?>

    <?= $form->field($model, 'CNAME')->textInput() ?>

    <?= $form->field($model, 'CHNAME')->textInput() ?>

    <?= $form->field($model, 'CDATE')->textInput() ?>

    <?= $form->field($model, 'CHDATE')->textInput() ?>

    <?= $form->field($model, 'MANDANTNO')->textInput() ?>

    <?= $form->field($model, 'REF_TMP_ISQUARANTINESTORE')->textInput() ?>

    <?= $form->field($model, 'INFO4')->textInput() ?>

    <?= $form->field($model, 'INFO5')->textInput() ?>

    <?= $form->field($model, 'INFO6')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
