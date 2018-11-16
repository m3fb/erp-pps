<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Cucomp */

$this->title = $model->NAME;
$this->params['breadcrumbs'][] = ['label' => 'Cucomps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cucomp-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->CONO], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->CONO], [
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
            'CONO',
            'NAME',
            'ADDITION',
            'ADDITION2',
            'BITMAP',
            'BOXCODE',
            'BOXNO',
            'CLEARANCE',
            'CNTRYSIGN',
            'COTYPNO',
            'CREDITLIMIT',
            'CUSTNO',
            'CUSTOMERINFO',
            'FAX',
            'FKPLNO',
            'FKPLNO1',
            'FKPLNO2',
            'FKPLNO3',
            'INFO1',
            'INFO2',
            'LANCNTRY',
            'LIEFERB',
            'MODEM',
            'NUMCOPIESINVOICE',
            'PHONE',
            'PHONE1',
            'PHONE2',
            'PHONE3',
            'PHONE4',
            'PHONE5',
            'PHONE6',
            'PLACE',
            'PLACE2',
            'POSTCODE',
            'POSTCODE2',
            'RABATT',
            'SALESMAN',
            'SAMMELRECH',
            'SECPHONE',
            'STATE',
            'STATUS',
            'STREET',
            'STREET2',
            'SUPPLIER',
            'TYP0',
            'TYP1',
            'TYP2',
            'UDATUM',
            'UMSATZ0',
            'UMSATZ1',
            'UMSATZ2',
            'UMSATZ3',
            'UMSATZ4',
            'UMSATZ5',
            'UMSATZ6',
            'UMSATZ7',
            'UMSATZ8',
            'UMSATZ9',
            'UMSATZ10',
            'UMSATZ11',
            'UMSATZ12',
            'VATIDNO',
            'VERTID',
            'VERTRNAME',
            'VPROV',
            'VRABATT',
            'ZAHLUNGB',
            'ZAHLUNGT',
            'CNAME',
            'CHNAME',
            'CDATE',
            'CHDATE',
            'MANDANTNO',
            'EXCHANGELMT',
            'EXTWORKRES',
            'EXCHANGEPHOTOLMT',
        ],
    ]) ?>

</div>
