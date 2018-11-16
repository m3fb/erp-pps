<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CucompSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cucomp-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'CONO') ?>

    <?= $form->field($model, 'NAME') ?>

    <?= $form->field($model, 'ADDITION') ?>

    <?= $form->field($model, 'ADDITION2') ?>

    <?= $form->field($model, 'BITMAP') ?>

    <?php // echo $form->field($model, 'BOXCODE') ?>

    <?php // echo $form->field($model, 'BOXNO') ?>

    <?php // echo $form->field($model, 'CLEARANCE') ?>

    <?php // echo $form->field($model, 'CNTRYSIGN') ?>

    <?php // echo $form->field($model, 'COTYPNO') ?>

    <?php // echo $form->field($model, 'CREDITLIMIT') ?>

    <?php // echo $form->field($model, 'CUSTNO') ?>

    <?php // echo $form->field($model, 'CUSTOMERINFO') ?>

    <?php // echo $form->field($model, 'FAX') ?>

    <?php // echo $form->field($model, 'FKPLNO') ?>

    <?php // echo $form->field($model, 'FKPLNO1') ?>

    <?php // echo $form->field($model, 'FKPLNO2') ?>

    <?php // echo $form->field($model, 'FKPLNO3') ?>

    <?php // echo $form->field($model, 'INFO1') ?>

    <?php // echo $form->field($model, 'INFO2') ?>

    <?php // echo $form->field($model, 'LANCNTRY') ?>

    <?php // echo $form->field($model, 'LIEFERB') ?>

    <?php // echo $form->field($model, 'MODEM') ?>

    <?php // echo $form->field($model, 'NUMCOPIESINVOICE') ?>

    <?php // echo $form->field($model, 'PHONE') ?>

    <?php // echo $form->field($model, 'PHONE1') ?>

    <?php // echo $form->field($model, 'PHONE2') ?>

    <?php // echo $form->field($model, 'PHONE3') ?>

    <?php // echo $form->field($model, 'PHONE4') ?>

    <?php // echo $form->field($model, 'PHONE5') ?>

    <?php // echo $form->field($model, 'PHONE6') ?>

    <?php // echo $form->field($model, 'PLACE') ?>

    <?php // echo $form->field($model, 'PLACE2') ?>

    <?php // echo $form->field($model, 'POSTCODE') ?>

    <?php // echo $form->field($model, 'POSTCODE2') ?>

    <?php // echo $form->field($model, 'RABATT') ?>

    <?php // echo $form->field($model, 'SALESMAN') ?>

    <?php // echo $form->field($model, 'SAMMELRECH') ?>

    <?php // echo $form->field($model, 'SECPHONE') ?>

    <?php // echo $form->field($model, 'STATE') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <?php // echo $form->field($model, 'STREET') ?>

    <?php // echo $form->field($model, 'STREET2') ?>

    <?php // echo $form->field($model, 'SUPPLIER') ?>

    <?php // echo $form->field($model, 'TYP0') ?>

    <?php // echo $form->field($model, 'TYP1') ?>

    <?php // echo $form->field($model, 'TYP2') ?>

    <?php // echo $form->field($model, 'UDATUM') ?>

    <?php // echo $form->field($model, 'UMSATZ0') ?>

    <?php // echo $form->field($model, 'UMSATZ1') ?>

    <?php // echo $form->field($model, 'UMSATZ2') ?>

    <?php // echo $form->field($model, 'UMSATZ3') ?>

    <?php // echo $form->field($model, 'UMSATZ4') ?>

    <?php // echo $form->field($model, 'UMSATZ5') ?>

    <?php // echo $form->field($model, 'UMSATZ6') ?>

    <?php // echo $form->field($model, 'UMSATZ7') ?>

    <?php // echo $form->field($model, 'UMSATZ8') ?>

    <?php // echo $form->field($model, 'UMSATZ9') ?>

    <?php // echo $form->field($model, 'UMSATZ10') ?>

    <?php // echo $form->field($model, 'UMSATZ11') ?>

    <?php // echo $form->field($model, 'UMSATZ12') ?>

    <?php // echo $form->field($model, 'VATIDNO') ?>

    <?php // echo $form->field($model, 'VERTID') ?>

    <?php // echo $form->field($model, 'VERTRNAME') ?>

    <?php // echo $form->field($model, 'VPROV') ?>

    <?php // echo $form->field($model, 'VRABATT') ?>

    <?php // echo $form->field($model, 'ZAHLUNGB') ?>

    <?php // echo $form->field($model, 'ZAHLUNGT') ?>

    <?php // echo $form->field($model, 'CNAME') ?>

    <?php // echo $form->field($model, 'CHNAME') ?>

    <?php // echo $form->field($model, 'CDATE') ?>

    <?php // echo $form->field($model, 'CHDATE') ?>

    <?php // echo $form->field($model, 'MANDANTNO') ?>

    <?php // echo $form->field($model, 'EXCHANGELMT') ?>

    <?php // echo $form->field($model, 'EXTWORKRES') ?>

    <?php // echo $form->field($model, 'EXCHANGEPHOTOLMT') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
