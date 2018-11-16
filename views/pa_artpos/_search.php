<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pa_artposSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pa-artpos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ARTNO') ?>

    <?= $form->field($model, 'GRPNO') ?>

    <?= $form->field($model, 'ARTDESC') ?>

    <?= $form->field($model, 'ARTNAME') ?>

    <?= $form->field($model, 'FIND') ?>

    <?php // echo $form->field($model, 'FNUM') ?>

    <?php // echo $form->field($model, 'FTYP') ?>

    <?php // echo $form->field($model, 'ARCHIVED') ?>

    <?php // echo $form->field($model, 'DISCONTINUED') ?>

    <?php // echo $form->field($model, 'ADATUM1') ?>

    <?php // echo $form->field($model, 'ADATUM2') ?>

    <?php // echo $form->field($model, 'ADATUM3') ?>

    <?php // echo $form->field($model, 'ADDRNO0') ?>

    <?php // echo $form->field($model, 'ADDRNO1') ?>

    <?php // echo $form->field($model, 'ADDRNO2') ?>

    <?php // echo $form->field($model, 'ADDRNO3') ?>

    <?php // echo $form->field($model, 'ADDRNO4') ?>

    <?php // echo $form->field($model, 'ADDRNO5') ?>

    <?php // echo $form->field($model, 'AEINH1') ?>

    <?php // echo $form->field($model, 'AEINH2') ?>

    <?php // echo $form->field($model, 'AEINH3') ?>

    <?php // echo $form->field($model, 'ALAGER0') ?>

    <?php // echo $form->field($model, 'ALAGER1') ?>

    <?php // echo $form->field($model, 'ALAGER2') ?>

    <?php // echo $form->field($model, 'ALAGER3') ?>

    <?php // echo $form->field($model, 'ALAGER4') ?>

    <?php // echo $form->field($model, 'ALAGER5') ?>

    <?php // echo $form->field($model, 'ALAGERN') ?>

    <?php // echo $form->field($model, 'AMENGE1') ?>

    <?php // echo $form->field($model, 'AMENGE2') ?>

    <?php // echo $form->field($model, 'AMENGE3') ?>

    <?php // echo $form->field($model, 'APLACEI') ?>

    <?php // echo $form->field($model, 'APREIS1') ?>

    <?php // echo $form->field($model, 'APREIS2') ?>

    <?php // echo $form->field($model, 'APREIS3') ?>

    <?php // echo $form->field($model, 'ARTADDR1') ?>

    <?php // echo $form->field($model, 'ARTADDR2') ?>

    <?php // echo $form->field($model, 'ARTADDR3') ?>

    <?php // echo $form->field($model, 'ARTDOC0') ?>

    <?php // echo $form->field($model, 'ARTDOC1') ?>

    <?php // echo $form->field($model, 'ARTDOC2') ?>

    <?php // echo $form->field($model, 'ARTINF1') ?>

    <?php // echo $form->field($model, 'ARTPRT0') ?>

    <?php // echo $form->field($model, 'ARTPRT1') ?>

    <?php // echo $form->field($model, 'ARTPRT2') ?>

    <?php // echo $form->field($model, 'AUTOLEAVE') ?>

    <?php // echo $form->field($model, 'AUTORESERV') ?>

    <?php // echo $form->field($model, 'AVERAGEPRICE') ?>

    <?php // echo $form->field($model, 'BESTM0') ?>

    <?php // echo $form->field($model, 'BESTM1') ?>

    <?php // echo $form->field($model, 'BESTM2') ?>

    <?php // echo $form->field($model, 'BITMAPA') ?>

    <?php // echo $form->field($model, 'BITMAPB') ?>

    <?php // echo $form->field($model, 'CHARGE') ?>

    <?php // echo $form->field($model, 'DINNO1') ?>

    <?php // echo $form->field($model, 'DINNO2') ?>

    <?php // echo $form->field($model, 'DISCALCDATE') ?>

    <?php // echo $form->field($model, 'DISCOUNT1') ?>

    <?php // echo $form->field($model, 'DISCOUNT2') ?>

    <?php // echo $form->field($model, 'DISCOUNT3') ?>

    <?php // echo $form->field($model, 'DISCOUNT4') ?>

    <?php // echo $form->field($model, 'DISCOUNT5') ?>

    <?php // echo $form->field($model, 'DISCOUNT6') ?>

    <?php // echo $form->field($model, 'DISDEMANDALL') ?>

    <?php // echo $form->field($model, 'DISDEMANDALLLEFT') ?>

    <?php // echo $form->field($model, 'DISDEMANDDIFF') ?>

    <?php // echo $form->field($model, 'DISDEMANDPACTIVE') ?>

    <?php // echo $form->field($model, 'DISDEMANDPACTIVELEFT') ?>

    <?php // echo $form->field($model, 'DISDEMANDPPASSIVE') ?>

    <?php // echo $form->field($model, 'DISDEMANDPPASSIVELEFT') ?>

    <?php // echo $form->field($model, 'DISFIRSTDATEMINUS') ?>

    <?php // echo $form->field($model, 'DISPRODUCING') ?>

    <?php // echo $form->field($model, 'DRAWNO') ?>

    <?php // echo $form->field($model, 'EINHEIT') ?>

    <?php // echo $form->field($model, 'EINHIN') ?>

    <?php // echo $form->field($model, 'EINHOUT') ?>

    <?php // echo $form->field($model, 'EINHST') ?>

    <?php // echo $form->field($model, 'EINKAUF0') ?>

    <?php // echo $form->field($model, 'EINKAUF1') ?>

    <?php // echo $form->field($model, 'EINKAUF2') ?>

    <?php // echo $form->field($model, 'EINKAUF3') ?>

    <?php // echo $form->field($model, 'EINKAUF4') ?>

    <?php // echo $form->field($model, 'EINKAUF5') ?>

    <?php // echo $form->field($model, 'EKPERC') ?>

    <?php // echo $form->field($model, 'EKPREIS') ?>

    <?php // echo $form->field($model, 'EPREIS0') ?>

    <?php // echo $form->field($model, 'EPREIS1') ?>

    <?php // echo $form->field($model, 'EPREIS2') ?>

    <?php // echo $form->field($model, 'EPREIS3') ?>

    <?php // echo $form->field($model, 'EPREIS4') ?>

    <?php // echo $form->field($model, 'EPREIS5') ?>

    <?php // echo $form->field($model, 'EPROZ0') ?>

    <?php // echo $form->field($model, 'EPROZ1') ?>

    <?php // echo $form->field($model, 'EPROZ2') ?>

    <?php // echo $form->field($model, 'EPROZ3') ?>

    <?php // echo $form->field($model, 'EPROZ4') ?>

    <?php // echo $form->field($model, 'EPROZ5') ?>

    <?php // echo $form->field($model, 'EXCLUDEINDISPO') ?>

    <?php // echo $form->field($model, 'FAKTOR1') ?>

    <?php // echo $form->field($model, 'FAKTOR2') ?>

    <?php // echo $form->field($model, 'FAKTOR3') ?>

    <?php // echo $form->field($model, 'ISCASTING') ?>

    <?php // echo $form->field($model, 'MASSEINH') ?>

    <?php // echo $form->field($model, 'MATTYP') ?>

    <?php // echo $form->field($model, 'MCPERC') ?>

    <?php // echo $form->field($model, 'MCREAL') ?>

    <?php // echo $form->field($model, 'MDIM1') ?>

    <?php // echo $form->field($model, 'MDIM2') ?>

    <?php // echo $form->field($model, 'MDIM3') ?>

    <?php // echo $form->field($model, 'MDIM4') ?>

    <?php // echo $form->field($model, 'MENGE') ?>

    <?php // echo $form->field($model, 'MENGE1') ?>

    <?php // echo $form->field($model, 'MENGE2') ?>

    <?php // echo $form->field($model, 'MENGE3') ?>

    <?php // echo $form->field($model, 'MENGE4') ?>

    <?php // echo $form->field($model, 'MENGE5') ?>

    <?php // echo $form->field($model, 'MENGE6') ?>

    <?php // echo $form->field($model, 'MFAKT') ?>

    <?php // echo $form->field($model, 'MIDENT1') ?>

    <?php // echo $form->field($model, 'MIDENT2') ?>

    <?php // echo $form->field($model, 'MIDENT3') ?>

    <?php // echo $form->field($model, 'MIDENT4') ?>

    <?php // echo $form->field($model, 'MIDENT5') ?>

    <?php // echo $form->field($model, 'MIDENT6') ?>

    <?php // echo $form->field($model, 'MIDENT7') ?>

    <?php // echo $form->field($model, 'MIDENT8') ?>

    <?php // echo $form->field($model, 'MINBE3') ?>

    <?php // echo $form->field($model, 'MINBE4') ?>

    <?php // echo $form->field($model, 'MINBE5') ?>

    <?php // echo $form->field($model, 'MINPRICE') ?>

    <?php // echo $form->field($model, 'MWEIG1') ?>

    <?php // echo $form->field($model, 'MWEIG2') ?>

    <?php // echo $form->field($model, 'MWEIG3') ?>

    <?php // echo $form->field($model, 'NETPRICE1') ?>

    <?php // echo $form->field($model, 'NETPRICE2') ?>

    <?php // echo $form->field($model, 'NETPRICE3') ?>

    <?php // echo $form->field($model, 'NETPRICE4') ?>

    <?php // echo $form->field($model, 'NETPRICE5') ?>

    <?php // echo $form->field($model, 'NETPRICE6') ?>

    <?php // echo $form->field($model, 'ORDERED') ?>

    <?php // echo $form->field($model, 'PADDITION1') ?>

    <?php // echo $form->field($model, 'PADDITION2') ?>

    <?php // echo $form->field($model, 'PADDITION3') ?>

    <?php // echo $form->field($model, 'PADDITION4') ?>

    <?php // echo $form->field($model, 'PADDITION5') ?>

    <?php // echo $form->field($model, 'PADDITION6') ?>

    <?php // echo $form->field($model, 'PARTNO') ?>

    <?php // echo $form->field($model, 'PLATE') ?>

    <?php // echo $form->field($model, 'PPREIS') ?>

    <?php // echo $form->field($model, 'PREIS') ?>

    <?php // echo $form->field($model, 'PREIS1') ?>

    <?php // echo $form->field($model, 'PREIS2') ?>

    <?php // echo $form->field($model, 'PREIS3') ?>

    <?php // echo $form->field($model, 'PREIS4') ?>

    <?php // echo $form->field($model, 'PREIS5') ?>

    <?php // echo $form->field($model, 'PREIS6') ?>

    <?php // echo $form->field($model, 'PROVREADY') ?>

    <?php // echo $form->field($model, 'RABATT') ?>

    <?php // echo $form->field($model, 'RABATTREADY') ?>

    <?php // echo $form->field($model, 'SERIALNUMBERKEY') ?>

    <?php // echo $form->field($model, 'SUPPLIED') ?>

    <?php // echo $form->field($model, 'SURFACE') ?>

    <?php // echo $form->field($model, 'VERTID') ?>

    <?php // echo $form->field($model, 'VERTRNAME') ?>

    <?php // echo $form->field($model, 'VKPERC') ?>

    <?php // echo $form->field($model, 'VKPREIS') ?>

    <?php // echo $form->field($model, 'VPE1') ?>

    <?php // echo $form->field($model, 'VPE2') ?>

    <?php // echo $form->field($model, 'VPE3') ?>

    <?php // echo $form->field($model, 'VPREIS0') ?>

    <?php // echo $form->field($model, 'VPREIS1') ?>

    <?php // echo $form->field($model, 'VPREIS2') ?>

    <?php // echo $form->field($model, 'VPREIS3') ?>

    <?php // echo $form->field($model, 'VPREIS4') ?>

    <?php // echo $form->field($model, 'VPREIS5') ?>

    <?php // echo $form->field($model, 'VPROV') ?>

    <?php // echo $form->field($model, 'VPROZ0') ?>

    <?php // echo $form->field($model, 'VPROZ1') ?>

    <?php // echo $form->field($model, 'VPROZ2') ?>

    <?php // echo $form->field($model, 'VPROZ3') ?>

    <?php // echo $form->field($model, 'VPROZ4') ?>

    <?php // echo $form->field($model, 'VPROZ5') ?>

    <?php // echo $form->field($model, 'VRABATT') ?>

    <?php // echo $form->field($model, 'CNAME') ?>

    <?php // echo $form->field($model, 'CHNAME') ?>

    <?php // echo $form->field($model, 'CDATE') ?>

    <?php // echo $form->field($model, 'CHDATE') ?>

    <?php // echo $form->field($model, 'MANDANTNO') ?>

    <?php // echo $form->field($model, 'ACCOUNT0') ?>

    <?php // echo $form->field($model, 'ACCOUNT1') ?>

    <?php // echo $form->field($model, 'ACCOUNT2') ?>

    <?php // echo $form->field($model, 'ACCOUNT3') ?>

    <?php // echo $form->field($model, 'DISCOUNT7') ?>

    <?php // echo $form->field($model, 'DISCOUNT8') ?>

    <?php // echo $form->field($model, 'DISCOUNT9') ?>

    <?php // echo $form->field($model, 'DISCOUNT10') ?>

    <?php // echo $form->field($model, 'DISCOUNT11') ?>

    <?php // echo $form->field($model, 'DISCOUNT12') ?>

    <?php // echo $form->field($model, 'DISCOUNT13') ?>

    <?php // echo $form->field($model, 'DISCOUNT14') ?>

    <?php // echo $form->field($model, 'DISCOUNT15') ?>

    <?php // echo $form->field($model, 'MENGE7') ?>

    <?php // echo $form->field($model, 'MENGE8') ?>

    <?php // echo $form->field($model, 'MENGE9') ?>

    <?php // echo $form->field($model, 'MENGE10') ?>

    <?php // echo $form->field($model, 'MENGE11') ?>

    <?php // echo $form->field($model, 'MENGE12') ?>

    <?php // echo $form->field($model, 'MENGE13') ?>

    <?php // echo $form->field($model, 'MENGE14') ?>

    <?php // echo $form->field($model, 'NETPRICE7') ?>

    <?php // echo $form->field($model, 'NETPRICE8') ?>

    <?php // echo $form->field($model, 'NETPRICE9') ?>

    <?php // echo $form->field($model, 'NETPRICE10') ?>

    <?php // echo $form->field($model, 'NETPRICE11') ?>

    <?php // echo $form->field($model, 'NETPRICE12') ?>

    <?php // echo $form->field($model, 'NETPRICE13') ?>

    <?php // echo $form->field($model, 'NETPRICE14') ?>

    <?php // echo $form->field($model, 'NETPRICE15') ?>

    <?php // echo $form->field($model, 'PADDITION7') ?>

    <?php // echo $form->field($model, 'PADDITION8') ?>

    <?php // echo $form->field($model, 'PADDITION9') ?>

    <?php // echo $form->field($model, 'PADDITION10') ?>

    <?php // echo $form->field($model, 'PADDITION11') ?>

    <?php // echo $form->field($model, 'PADDITION12') ?>

    <?php // echo $form->field($model, 'PADDITION13') ?>

    <?php // echo $form->field($model, 'PADDITION14') ?>

    <?php // echo $form->field($model, 'PADDITION15') ?>

    <?php // echo $form->field($model, 'PREIS7') ?>

    <?php // echo $form->field($model, 'PREIS8') ?>

    <?php // echo $form->field($model, 'PREIS9') ?>

    <?php // echo $form->field($model, 'PREIS10') ?>

    <?php // echo $form->field($model, 'PREIS11') ?>

    <?php // echo $form->field($model, 'PREIS12') ?>

    <?php // echo $form->field($model, 'PREIS13') ?>

    <?php // echo $form->field($model, 'PREIS14') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
