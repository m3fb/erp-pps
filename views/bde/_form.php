<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Bde */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bde-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'LBNO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ORNO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STATUS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'WPLACE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PERSNO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PERSNAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'OPNO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MSTIME')->textInput() ?>

    <?= $form->field($model, 'MSINFO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ORNAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'APARTS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'GPARTS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BPARTS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ATE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ATR')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ATP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ADCSTAT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ADCCOUNT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ADCMESS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ADCWORK')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'EXSTAT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MTIME0')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MTIME1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MTIME2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MTIME3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'OPOPNO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'OUT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'FNPK')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MSGID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'FKLBNO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TERMINAL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ISINTERNAL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CNAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CHNAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CDATE')->textInput() ?>

    <?= $form->field($model, 'CHDATE')->textInput() ?>

    <?= $form->field($model, 'MANDANTNO')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
