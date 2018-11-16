<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Cucomp */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cucomp-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'CONO')->textInput() ?>

    <?= $form->field($model, 'NAME')->textInput() ?>

    <?= $form->field($model, 'ADDITION')->textInput() ?>

    <?= $form->field($model, 'ADDITION2')->textInput() ?>

    <?= $form->field($model, 'BITMAP')->textInput() ?>

    <?= $form->field($model, 'BOXCODE')->textInput() ?>

    <?= $form->field($model, 'BOXNO')->textInput() ?>

    <?= $form->field($model, 'CLEARANCE')->textInput() ?>

    <?= $form->field($model, 'CNTRYSIGN')->textInput() ?>

    <?= $form->field($model, 'COTYPNO')->textInput() ?>

    <?= $form->field($model, 'CREDITLIMIT')->textInput() ?>

    <?= $form->field($model, 'CUSTNO')->textInput() ?>

    <?= $form->field($model, 'CUSTOMERINFO')->textInput() ?>

    <?= $form->field($model, 'FAX')->textInput() ?>

    <?= $form->field($model, 'FKPLNO')->textInput() ?>

    <?= $form->field($model, 'FKPLNO1')->textInput() ?>

    <?= $form->field($model, 'FKPLNO2')->textInput() ?>

    <?= $form->field($model, 'FKPLNO3')->textInput() ?>

    <?= $form->field($model, 'INFO1')->textInput() ?>

    <?= $form->field($model, 'INFO2')->textInput() ?>

    <?= $form->field($model, 'LANCNTRY')->textInput() ?>

    <?= $form->field($model, 'LIEFERB')->textInput() ?>

    <?= $form->field($model, 'MODEM')->textInput() ?>

    <?= $form->field($model, 'NUMCOPIESINVOICE')->textInput() ?>

    <?= $form->field($model, 'PHONE')->textInput() ?>

    <?= $form->field($model, 'PHONE1')->textInput() ?>

    <?= $form->field($model, 'PHONE2')->textInput() ?>

    <?= $form->field($model, 'PHONE3')->textInput() ?>

    <?= $form->field($model, 'PHONE4')->textInput() ?>

    <?= $form->field($model, 'PHONE5')->textInput() ?>

    <?= $form->field($model, 'PHONE6')->textInput() ?>

    <?= $form->field($model, 'PLACE')->textInput() ?>

    <?= $form->field($model, 'PLACE2')->textInput() ?>

    <?= $form->field($model, 'POSTCODE')->textInput() ?>

    <?= $form->field($model, 'POSTCODE2')->textInput() ?>

    <?= $form->field($model, 'RABATT')->textInput() ?>

    <?= $form->field($model, 'SALESMAN')->textInput() ?>

    <?= $form->field($model, 'SAMMELRECH')->textInput() ?>

    <?= $form->field($model, 'SECPHONE')->textInput() ?>

    <?= $form->field($model, 'STATE')->textInput() ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <?= $form->field($model, 'STREET')->textInput() ?>

    <?= $form->field($model, 'STREET2')->textInput() ?>

    <?= $form->field($model, 'SUPPLIER')->textInput() ?>

    <?= $form->field($model, 'TYP0')->textInput() ?>

    <?= $form->field($model, 'TYP1')->textInput() ?>

    <?= $form->field($model, 'TYP2')->textInput() ?>

    <?= $form->field($model, 'UDATUM')->textInput() ?>

    <?= $form->field($model, 'UMSATZ0')->textInput() ?>

    <?= $form->field($model, 'UMSATZ1')->textInput() ?>

    <?= $form->field($model, 'UMSATZ2')->textInput() ?>

    <?= $form->field($model, 'UMSATZ3')->textInput() ?>

    <?= $form->field($model, 'UMSATZ4')->textInput() ?>

    <?= $form->field($model, 'UMSATZ5')->textInput() ?>

    <?= $form->field($model, 'UMSATZ6')->textInput() ?>

    <?= $form->field($model, 'UMSATZ7')->textInput() ?>

    <?= $form->field($model, 'UMSATZ8')->textInput() ?>

    <?= $form->field($model, 'UMSATZ9')->textInput() ?>

    <?= $form->field($model, 'UMSATZ10')->textInput() ?>

    <?= $form->field($model, 'UMSATZ11')->textInput() ?>

    <?= $form->field($model, 'UMSATZ12')->textInput() ?>

    <?= $form->field($model, 'VATIDNO')->textInput() ?>

    <?= $form->field($model, 'VERTID')->textInput() ?>

    <?= $form->field($model, 'VERTRNAME')->textInput() ?>

    <?= $form->field($model, 'VPROV')->textInput() ?>

    <?= $form->field($model, 'VRABATT')->textInput() ?>

    <?= $form->field($model, 'ZAHLUNGB')->textInput() ?>

    <?= $form->field($model, 'ZAHLUNGT')->textInput() ?>

    <?= $form->field($model, 'CNAME')->textInput() ?>

    <?= $form->field($model, 'CHNAME')->textInput() ?>

    <?= $form->field($model, 'CDATE')->textInput() ?>

    <?= $form->field($model, 'CHDATE')->textInput() ?>

    <?= $form->field($model, 'MANDANTNO')->textInput() ?>

    <?= $form->field($model, 'EXCHANGELMT')->textInput() ?>

    <?= $form->field($model, 'EXTWORKRES')->textInput() ?>

    <?= $form->field($model, 'EXCHANGEPHOTOLMT')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
