<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Urlaub */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="urlaub-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'LBNO')->textInput() ?>

    <?= $form->field($model, 'NAME')->textInput() ?>

    <?= $form->field($model, 'OPNO')->textInput() ?>

    <?= $form->field($model, 'OPOPNO')->textInput() ?>

    <?= $form->field($model, 'ORNAME')->textInput() ?>

    <?= $form->field($model, 'ORNO')->textInput() ?>

    <?= $form->field($model, 'OUT')->textInput() ?>

    <?= $form->field($model, 'ADCCOUNT')->textInput() ?>

    <?= $form->field($model, 'ADCMESS')->textInput() ?>

    <?= $form->field($model, 'ADCSTAT')->textInput() ?>

    <?= $form->field($model, 'ADCWORK')->textInput() ?>

    <?= $form->field($model, 'APARTS')->textInput() ?>

    <?= $form->field($model, 'ARCHIVE')->textInput() ?>

    <?= $form->field($model, 'ATE')->textInput() ?>

    <?= $form->field($model, 'ATP')->textInput() ?>

    <?= $form->field($model, 'ATR')->textInput() ?>

    <?= $form->field($model, 'BPARTS')->textInput() ?>

    <?= $form->field($model, 'BPARTS2')->textInput() ?>

    <?= $form->field($model, 'CALTYP')->textInput() ?>

    <?= $form->field($model, 'DESCR')->textInput() ?>

    <?= $form->field($model, 'ERRNUM')->textInput() ?>

    <?= $form->field($model, 'EXSTAT')->textInput() ?>

    <?= $form->field($model, 'FKLBNO')->textInput() ?>

    <?= $form->field($model, 'FNPK')->textInput() ?>

    <?= $form->field($model, 'GPARTS')->textInput() ?>

    <?= $form->field($model, 'INPARTSDBL')->textInput() ?>

    <?= $form->field($model, 'ISINTERNAL')->textInput() ?>

    <?= $form->field($model, 'MSGID')->textInput() ?>

    <?= $form->field($model, 'MSINFO')->textInput() ?>

    <?= $form->field($model, 'MSTIME')->textInput() ?>

    <?= $form->field($model, 'MTIME0')->textInput() ?>

    <?= $form->field($model, 'MTIME1')->textInput() ?>

    <?= $form->field($model, 'MTIME2')->textInput() ?>

    <?= $form->field($model, 'MTIME3')->textInput() ?>

    <?= $form->field($model, 'OPMULTIMESSAGEGROUP')->textInput() ?>

    <?= $form->field($model, 'PERSNAME')->textInput() ?>

    <?= $form->field($model, 'PERSNO')->textInput() ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <?= $form->field($model, 'TERMINAL')->textInput() ?>

    <?= $form->field($model, 'WPLACE')->textInput() ?>

    <?= $form->field($model, 'MATCOST')->textInput() ?>

    <?= $form->field($model, 'CNAME')->textInput() ?>

    <?= $form->field($model, 'CHNAME')->textInput() ?>

    <?= $form->field($model, 'CDATE')->textInput() ?>

    <?= $form->field($model, 'CHDATE')->textInput() ?>

    <?= $form->field($model, 'MANDANTNO')->textInput() ?>

    <?= $form->field($model, 'TSTAMP')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
