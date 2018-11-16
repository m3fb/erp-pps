<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pa_artpos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pa-artpos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ARTNO')->textInput() ?>

    <?= $form->field($model, 'GRPNO')->textInput() ?>

    <?= $form->field($model, 'ARTDESC')->textInput() ?>

    <?= $form->field($model, 'ARTNAME')->textInput() ?>

    <?= $form->field($model, 'FIND')->textInput() ?>

    <?= $form->field($model, 'FNUM')->textInput() ?>

    <?= $form->field($model, 'FTYP')->textInput() ?>

    <?= $form->field($model, 'ARCHIVED')->textInput() ?>

    <?= $form->field($model, 'DISCONTINUED')->textInput() ?>

    <?= $form->field($model, 'ADATUM1')->textInput() ?>

    <?= $form->field($model, 'ADATUM2')->textInput() ?>

    <?= $form->field($model, 'ADATUM3')->textInput() ?>

    <?= $form->field($model, 'ADDRNO0')->textInput() ?>

    <?= $form->field($model, 'ADDRNO1')->textInput() ?>

    <?= $form->field($model, 'ADDRNO2')->textInput() ?>

    <?= $form->field($model, 'ADDRNO3')->textInput() ?>

    <?= $form->field($model, 'ADDRNO4')->textInput() ?>

    <?= $form->field($model, 'ADDRNO5')->textInput() ?>

    <?= $form->field($model, 'AEINH1')->textInput() ?>

    <?= $form->field($model, 'AEINH2')->textInput() ?>

    <?= $form->field($model, 'AEINH3')->textInput() ?>

    <?= $form->field($model, 'ALAGER0')->textInput() ?>

    <?= $form->field($model, 'ALAGER1')->textInput() ?>

    <?= $form->field($model, 'ALAGER2')->textInput() ?>

    <?= $form->field($model, 'ALAGER3')->textInput() ?>

    <?= $form->field($model, 'ALAGER4')->textInput() ?>

    <?= $form->field($model, 'ALAGER5')->textInput() ?>

    <?= $form->field($model, 'ALAGERN')->textInput() ?>

    <?= $form->field($model, 'AMENGE1')->textInput() ?>

    <?= $form->field($model, 'AMENGE2')->textInput() ?>

    <?= $form->field($model, 'AMENGE3')->textInput() ?>

    <?= $form->field($model, 'APLACEI')->textInput() ?>

    <?= $form->field($model, 'APREIS1')->textInput() ?>

    <?= $form->field($model, 'APREIS2')->textInput() ?>

    <?= $form->field($model, 'APREIS3')->textInput() ?>

    <?= $form->field($model, 'ARTADDR1')->textInput() ?>

    <?= $form->field($model, 'ARTADDR2')->textInput() ?>

    <?= $form->field($model, 'ARTADDR3')->textInput() ?>

    <?= $form->field($model, 'ARTDOC0')->textInput() ?>

    <?= $form->field($model, 'ARTDOC1')->textInput() ?>

    <?= $form->field($model, 'ARTDOC2')->textInput() ?>

    <?= $form->field($model, 'ARTINF1')->textInput() ?>

    <?= $form->field($model, 'ARTPRT0')->textInput() ?>

    <?= $form->field($model, 'ARTPRT1')->textInput() ?>

    <?= $form->field($model, 'ARTPRT2')->textInput() ?>

    <?= $form->field($model, 'AUTOLEAVE')->textInput() ?>

    <?= $form->field($model, 'AUTORESERV')->textInput() ?>

    <?= $form->field($model, 'AVERAGEPRICE')->textInput() ?>

    <?= $form->field($model, 'BESTM0')->textInput() ?>

    <?= $form->field($model, 'BESTM1')->textInput() ?>

    <?= $form->field($model, 'BESTM2')->textInput() ?>

    <?= $form->field($model, 'BITMAPA')->textInput() ?>

    <?= $form->field($model, 'BITMAPB')->textInput() ?>

    <?= $form->field($model, 'CHARGE')->textInput() ?>

    <?= $form->field($model, 'DINNO1')->textInput() ?>

    <?= $form->field($model, 'DINNO2')->textInput() ?>

    <?= $form->field($model, 'DISCALCDATE')->textInput() ?>

    <?= $form->field($model, 'DISCOUNT1')->textInput() ?>

    <?= $form->field($model, 'DISCOUNT2')->textInput() ?>

    <?= $form->field($model, 'DISCOUNT3')->textInput() ?>

    <?= $form->field($model, 'DISCOUNT4')->textInput() ?>

    <?= $form->field($model, 'DISCOUNT5')->textInput() ?>

    <?= $form->field($model, 'DISCOUNT6')->textInput() ?>

    <?= $form->field($model, 'DISDEMANDALL')->textInput() ?>

    <?= $form->field($model, 'DISDEMANDALLLEFT')->textInput() ?>

    <?= $form->field($model, 'DISDEMANDDIFF')->textInput() ?>

    <?= $form->field($model, 'DISDEMANDPACTIVE')->textInput() ?>

    <?= $form->field($model, 'DISDEMANDPACTIVELEFT')->textInput() ?>

    <?= $form->field($model, 'DISDEMANDPPASSIVE')->textInput() ?>

    <?= $form->field($model, 'DISDEMANDPPASSIVELEFT')->textInput() ?>

    <?= $form->field($model, 'DISFIRSTDATEMINUS')->textInput() ?>

    <?= $form->field($model, 'DISPRODUCING')->textInput() ?>

    <?= $form->field($model, 'DRAWNO')->textInput() ?>

    <?= $form->field($model, 'EINHEIT')->textInput() ?>

    <?= $form->field($model, 'EINHIN')->textInput() ?>

    <?= $form->field($model, 'EINHOUT')->textInput() ?>

    <?= $form->field($model, 'EINHST')->textInput() ?>

    <?= $form->field($model, 'EINKAUF0')->textInput() ?>

    <?= $form->field($model, 'EINKAUF1')->textInput() ?>

    <?= $form->field($model, 'EINKAUF2')->textInput() ?>

    <?= $form->field($model, 'EINKAUF3')->textInput() ?>

    <?= $form->field($model, 'EINKAUF4')->textInput() ?>

    <?= $form->field($model, 'EINKAUF5')->textInput() ?>

    <?= $form->field($model, 'EKPERC')->textInput() ?>

    <?= $form->field($model, 'EKPREIS')->textInput() ?>

    <?= $form->field($model, 'EPREIS0')->textInput() ?>

    <?= $form->field($model, 'EPREIS1')->textInput() ?>

    <?= $form->field($model, 'EPREIS2')->textInput() ?>

    <?= $form->field($model, 'EPREIS3')->textInput() ?>

    <?= $form->field($model, 'EPREIS4')->textInput() ?>

    <?= $form->field($model, 'EPREIS5')->textInput() ?>

    <?= $form->field($model, 'EPROZ0')->textInput() ?>

    <?= $form->field($model, 'EPROZ1')->textInput() ?>

    <?= $form->field($model, 'EPROZ2')->textInput() ?>

    <?= $form->field($model, 'EPROZ3')->textInput() ?>

    <?= $form->field($model, 'EPROZ4')->textInput() ?>

    <?= $form->field($model, 'EPROZ5')->textInput() ?>

    <?= $form->field($model, 'EXCLUDEINDISPO')->textInput() ?>

    <?= $form->field($model, 'FAKTOR1')->textInput() ?>

    <?= $form->field($model, 'FAKTOR2')->textInput() ?>

    <?= $form->field($model, 'FAKTOR3')->textInput() ?>

    <?= $form->field($model, 'ISCASTING')->textInput() ?>

    <?= $form->field($model, 'MASSEINH')->textInput() ?>

    <?= $form->field($model, 'MATTYP')->textInput() ?>

    <?= $form->field($model, 'MCPERC')->textInput() ?>

    <?= $form->field($model, 'MCREAL')->textInput() ?>

    <?= $form->field($model, 'MDIM1')->textInput() ?>

    <?= $form->field($model, 'MDIM2')->textInput() ?>

    <?= $form->field($model, 'MDIM3')->textInput() ?>

    <?= $form->field($model, 'MDIM4')->textInput() ?>

    <?= $form->field($model, 'MENGE')->textInput() ?>

    <?= $form->field($model, 'MENGE1')->textInput() ?>

    <?= $form->field($model, 'MENGE2')->textInput() ?>

    <?= $form->field($model, 'MENGE3')->textInput() ?>

    <?= $form->field($model, 'MENGE4')->textInput() ?>

    <?= $form->field($model, 'MENGE5')->textInput() ?>

    <?= $form->field($model, 'MENGE6')->textInput() ?>

    <?= $form->field($model, 'MFAKT')->textInput() ?>

    <?= $form->field($model, 'MIDENT1')->textInput() ?>

    <?= $form->field($model, 'MIDENT2')->textInput() ?>

    <?= $form->field($model, 'MIDENT3')->textInput() ?>

    <?= $form->field($model, 'MIDENT4')->textInput() ?>

    <?= $form->field($model, 'MIDENT5')->textInput() ?>

    <?= $form->field($model, 'MIDENT6')->textInput() ?>

    <?= $form->field($model, 'MIDENT7')->textInput() ?>

    <?= $form->field($model, 'MIDENT8')->textInput() ?>

    <?= $form->field($model, 'MINBE3')->textInput() ?>

    <?= $form->field($model, 'MINBE4')->textInput() ?>

    <?= $form->field($model, 'MINBE5')->textInput() ?>

    <?= $form->field($model, 'MINPRICE')->textInput() ?>

    <?= $form->field($model, 'MWEIG1')->textInput() ?>

    <?= $form->field($model, 'MWEIG2')->textInput() ?>

    <?= $form->field($model, 'MWEIG3')->textInput() ?>

    <?= $form->field($model, 'NETPRICE1')->textInput() ?>

    <?= $form->field($model, 'NETPRICE2')->textInput() ?>

    <?= $form->field($model, 'NETPRICE3')->textInput() ?>

    <?= $form->field($model, 'NETPRICE4')->textInput() ?>

    <?= $form->field($model, 'NETPRICE5')->textInput() ?>

    <?= $form->field($model, 'NETPRICE6')->textInput() ?>

    <?= $form->field($model, 'ORDERED')->textInput() ?>

    <?= $form->field($model, 'PADDITION1')->textInput() ?>

    <?= $form->field($model, 'PADDITION2')->textInput() ?>

    <?= $form->field($model, 'PADDITION3')->textInput() ?>

    <?= $form->field($model, 'PADDITION4')->textInput() ?>

    <?= $form->field($model, 'PADDITION5')->textInput() ?>

    <?= $form->field($model, 'PADDITION6')->textInput() ?>

    <?= $form->field($model, 'PARTNO')->textInput() ?>

    <?= $form->field($model, 'PLATE')->textInput() ?>

    <?= $form->field($model, 'PPREIS')->textInput() ?>

    <?= $form->field($model, 'PREIS')->textInput() ?>

    <?= $form->field($model, 'PREIS1')->textInput() ?>

    <?= $form->field($model, 'PREIS2')->textInput() ?>

    <?= $form->field($model, 'PREIS3')->textInput() ?>

    <?= $form->field($model, 'PREIS4')->textInput() ?>

    <?= $form->field($model, 'PREIS5')->textInput() ?>

    <?= $form->field($model, 'PREIS6')->textInput() ?>

    <?= $form->field($model, 'PROVREADY')->textInput() ?>

    <?= $form->field($model, 'RABATT')->textInput() ?>

    <?= $form->field($model, 'RABATTREADY')->textInput() ?>

    <?= $form->field($model, 'SERIALNUMBERKEY')->textInput() ?>

    <?= $form->field($model, 'SUPPLIED')->textInput() ?>

    <?= $form->field($model, 'SURFACE')->textInput() ?>

    <?= $form->field($model, 'VERTID')->textInput() ?>

    <?= $form->field($model, 'VERTRNAME')->textInput() ?>

    <?= $form->field($model, 'VKPERC')->textInput() ?>

    <?= $form->field($model, 'VKPREIS')->textInput() ?>

    <?= $form->field($model, 'VPE1')->textInput() ?>

    <?= $form->field($model, 'VPE2')->textInput() ?>

    <?= $form->field($model, 'VPE3')->textInput() ?>

    <?= $form->field($model, 'VPREIS0')->textInput() ?>

    <?= $form->field($model, 'VPREIS1')->textInput() ?>

    <?= $form->field($model, 'VPREIS2')->textInput() ?>

    <?= $form->field($model, 'VPREIS3')->textInput() ?>

    <?= $form->field($model, 'VPREIS4')->textInput() ?>

    <?= $form->field($model, 'VPREIS5')->textInput() ?>

    <?= $form->field($model, 'VPROV')->textInput() ?>

    <?= $form->field($model, 'VPROZ0')->textInput() ?>

    <?= $form->field($model, 'VPROZ1')->textInput() ?>

    <?= $form->field($model, 'VPROZ2')->textInput() ?>

    <?= $form->field($model, 'VPROZ3')->textInput() ?>

    <?= $form->field($model, 'VPROZ4')->textInput() ?>

    <?= $form->field($model, 'VPROZ5')->textInput() ?>

    <?= $form->field($model, 'VRABATT')->textInput() ?>

    <?= $form->field($model, 'CNAME')->textInput() ?>

    <?= $form->field($model, 'CHNAME')->textInput() ?>

    <?= $form->field($model, 'CDATE')->textInput() ?>

    <?= $form->field($model, 'CHDATE')->textInput() ?>

    <?= $form->field($model, 'MANDANTNO')->textInput() ?>

    <?= $form->field($model, 'ACCOUNT0')->textInput() ?>

    <?= $form->field($model, 'ACCOUNT1')->textInput() ?>

    <?= $form->field($model, 'ACCOUNT2')->textInput() ?>

    <?= $form->field($model, 'ACCOUNT3')->textInput() ?>

    <?= $form->field($model, 'DISCOUNT7')->textInput() ?>

    <?= $form->field($model, 'DISCOUNT8')->textInput() ?>

    <?= $form->field($model, 'DISCOUNT9')->textInput() ?>

    <?= $form->field($model, 'DISCOUNT10')->textInput() ?>

    <?= $form->field($model, 'DISCOUNT11')->textInput() ?>

    <?= $form->field($model, 'DISCOUNT12')->textInput() ?>

    <?= $form->field($model, 'DISCOUNT13')->textInput() ?>

    <?= $form->field($model, 'DISCOUNT14')->textInput() ?>

    <?= $form->field($model, 'DISCOUNT15')->textInput() ?>

    <?= $form->field($model, 'MENGE7')->textInput() ?>

    <?= $form->field($model, 'MENGE8')->textInput() ?>

    <?= $form->field($model, 'MENGE9')->textInput() ?>

    <?= $form->field($model, 'MENGE10')->textInput() ?>

    <?= $form->field($model, 'MENGE11')->textInput() ?>

    <?= $form->field($model, 'MENGE12')->textInput() ?>

    <?= $form->field($model, 'MENGE13')->textInput() ?>

    <?= $form->field($model, 'MENGE14')->textInput() ?>

    <?= $form->field($model, 'NETPRICE7')->textInput() ?>

    <?= $form->field($model, 'NETPRICE8')->textInput() ?>

    <?= $form->field($model, 'NETPRICE9')->textInput() ?>

    <?= $form->field($model, 'NETPRICE10')->textInput() ?>

    <?= $form->field($model, 'NETPRICE11')->textInput() ?>

    <?= $form->field($model, 'NETPRICE12')->textInput() ?>

    <?= $form->field($model, 'NETPRICE13')->textInput() ?>

    <?= $form->field($model, 'NETPRICE14')->textInput() ?>

    <?= $form->field($model, 'NETPRICE15')->textInput() ?>

    <?= $form->field($model, 'PADDITION7')->textInput() ?>

    <?= $form->field($model, 'PADDITION8')->textInput() ?>

    <?= $form->field($model, 'PADDITION9')->textInput() ?>

    <?= $form->field($model, 'PADDITION10')->textInput() ?>

    <?= $form->field($model, 'PADDITION11')->textInput() ?>

    <?= $form->field($model, 'PADDITION12')->textInput() ?>

    <?= $form->field($model, 'PADDITION13')->textInput() ?>

    <?= $form->field($model, 'PADDITION14')->textInput() ?>

    <?= $form->field($model, 'PADDITION15')->textInput() ?>

    <?= $form->field($model, 'PREIS7')->textInput() ?>

    <?= $form->field($model, 'PREIS8')->textInput() ?>

    <?= $form->field($model, 'PREIS9')->textInput() ?>

    <?= $form->field($model, 'PREIS10')->textInput() ?>

    <?= $form->field($model, 'PREIS11')->textInput() ?>

    <?= $form->field($model, 'PREIS12')->textInput() ?>

    <?= $form->field($model, 'PREIS13')->textInput() ?>

    <?= $form->field($model, 'PREIS14')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
