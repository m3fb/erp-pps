<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Pa_artpos */

$this->title = $model->ARTNO;
$this->params['breadcrumbs'][] = ['label' => 'Pa Artpos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pa-artpos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ARTNO], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ARTNO], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ARTNO',
            'GRPNO',
            'ARTDESC',
            'ARTNAME',
            'FIND',
            'FNUM',
            'FTYP',
            'ARCHIVED',
            'DISCONTINUED',
            'ADATUM1',
            'ADATUM2',
            'ADATUM3',
            'ADDRNO0',
            'ADDRNO1',
            'ADDRNO2',
            'ADDRNO3',
            'ADDRNO4',
            'ADDRNO5',
            'AEINH1',
            'AEINH2',
            'AEINH3',
            'ALAGER0',
            'ALAGER1',
            'ALAGER2',
            'ALAGER3',
            'ALAGER4',
            'ALAGER5',
            'ALAGERN',
            'AMENGE1',
            'AMENGE2',
            'AMENGE3',
            'APLACEI',
            'APREIS1',
            'APREIS2',
            'APREIS3',
            'ARTADDR1',
            'ARTADDR2',
            'ARTADDR3',
            'ARTDOC0',
            'ARTDOC1',
            'ARTDOC2',
            'ARTINF1',
            'ARTPRT0',
            'ARTPRT1',
            'ARTPRT2',
            'AUTOLEAVE',
            'AUTORESERV',
            'AVERAGEPRICE',
            'BESTM0',
            'BESTM1',
            'BESTM2',
            'BITMAPA',
            'BITMAPB',
            'CHARGE',
            'DINNO1',
            'DINNO2',
            'DISCALCDATE',
            'DISCOUNT1',
            'DISCOUNT2',
            'DISCOUNT3',
            'DISCOUNT4',
            'DISCOUNT5',
            'DISCOUNT6',
            'DISDEMANDALL',
            'DISDEMANDALLLEFT',
            'DISDEMANDDIFF',
            'DISDEMANDPACTIVE',
            'DISDEMANDPACTIVELEFT',
            'DISDEMANDPPASSIVE',
            'DISDEMANDPPASSIVELEFT',
            'DISFIRSTDATEMINUS',
            'DISPRODUCING',
            'DRAWNO',
            'EINHEIT',
            'EINHIN',
            'EINHOUT',
            'EINHST',
            'EINKAUF0',
            'EINKAUF1',
            'EINKAUF2',
            'EINKAUF3',
            'EINKAUF4',
            'EINKAUF5',
            'EKPERC',
            'EKPREIS',
            'EPREIS0',
            'EPREIS1',
            'EPREIS2',
            'EPREIS3',
            'EPREIS4',
            'EPREIS5',
            'EPROZ0',
            'EPROZ1',
            'EPROZ2',
            'EPROZ3',
            'EPROZ4',
            'EPROZ5',
            'EXCLUDEINDISPO',
            'FAKTOR1',
            'FAKTOR2',
            'FAKTOR3',
            'ISCASTING',
            'MASSEINH',
            'MATTYP',
            'MCPERC',
            'MCREAL',
            'MDIM1',
            'MDIM2',
            'MDIM3',
            'MDIM4',
            'MENGE',
            'MENGE1',
            'MENGE2',
            'MENGE3',
            'MENGE4',
            'MENGE5',
            'MENGE6',
            'MFAKT',
            'MIDENT1',
            'MIDENT2',
            'MIDENT3',
            'MIDENT4',
            'MIDENT5',
            'MIDENT6',
            'MIDENT7',
            'MIDENT8',
            'MINBE3',
            'MINBE4',
            'MINBE5',
            'MINPRICE',
            'MWEIG1',
            'MWEIG2',
            'MWEIG3',
            'NETPRICE1',
            'NETPRICE2',
            'NETPRICE3',
            'NETPRICE4',
            'NETPRICE5',
            'NETPRICE6',
            'ORDERED',
            'PADDITION1',
            'PADDITION2',
            'PADDITION3',
            'PADDITION4',
            'PADDITION5',
            'PADDITION6',
            'PARTNO',
            'PLATE',
            'PPREIS',
            'PREIS',
            'PREIS1',
            'PREIS2',
            'PREIS3',
            'PREIS4',
            'PREIS5',
            'PREIS6',
            'PROVREADY',
            'RABATT',
            'RABATTREADY',
            'SERIALNUMBERKEY',
            'SUPPLIED',
            'SURFACE',
            'VERTID',
            'VERTRNAME',
            'VKPERC',
            'VKPREIS',
            'VPE1',
            'VPE2',
            'VPE3',
            'VPREIS0',
            'VPREIS1',
            'VPREIS2',
            'VPREIS3',
            'VPREIS4',
            'VPREIS5',
            'VPROV',
            'VPROZ0',
            'VPROZ1',
            'VPROZ2',
            'VPROZ3',
            'VPROZ4',
            'VPROZ5',
            'VRABATT',
            'CNAME',
            'CHNAME',
            'CDATE',
            'CHDATE',
            'MANDANTNO',
            'ACCOUNT0',
            'ACCOUNT1',
            'ACCOUNT2',
            'ACCOUNT3',
            'DISCOUNT7',
            'DISCOUNT8',
            'DISCOUNT9',
            'DISCOUNT10',
            'DISCOUNT11',
            'DISCOUNT12',
            'DISCOUNT13',
            'DISCOUNT14',
            'DISCOUNT15',
            'MENGE7',
            'MENGE8',
            'MENGE9',
            'MENGE10',
            'MENGE11',
            'MENGE12',
            'MENGE13',
            'MENGE14',
            'NETPRICE7',
            'NETPRICE8',
            'NETPRICE9',
            'NETPRICE10',
            'NETPRICE11',
            'NETPRICE12',
            'NETPRICE13',
            'NETPRICE14',
            'NETPRICE15',
            'PADDITION7',
            'PADDITION8',
            'PADDITION9',
            'PADDITION10',
            'PADDITION11',
            'PADDITION12',
            'PADDITION13',
            'PADDITION14',
            'PADDITION15',
            'PREIS7',
            'PREIS8',
            'PREIS9',
            'PREIS10',
            'PREIS11',
            'PREIS12',
            'PREIS13',
            'PREIS14',
        ],
    ]) ?>

</div>
