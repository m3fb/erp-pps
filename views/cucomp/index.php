<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CucompSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cucomps';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cucomp-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Cucomp', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'CONO',
            'NAME',
            'ADDITION',
            'ADDITION2',
            'BITMAP',
            //'BOXCODE',
            //'BOXNO',
            //'CLEARANCE',
            //'CNTRYSIGN',
            //'COTYPNO',
            //'CREDITLIMIT',
            //'CUSTNO',
            //'CUSTOMERINFO',
            //'FAX',
            //'FKPLNO',
            //'FKPLNO1',
            //'FKPLNO2',
            //'FKPLNO3',
            //'INFO1',
            //'INFO2',
            //'LANCNTRY',
            //'LIEFERB',
            //'MODEM',
            //'NUMCOPIESINVOICE',
            //'PHONE',
            //'PHONE1',
            //'PHONE2',
            //'PHONE3',
            //'PHONE4',
            //'PHONE5',
            //'PHONE6',
            //'PLACE',
            //'PLACE2',
            //'POSTCODE',
            //'POSTCODE2',
            //'RABATT',
            //'SALESMAN',
            //'SAMMELRECH',
            //'SECPHONE',
            //'STATE',
            //'STATUS',
            //'STREET',
            //'STREET2',
            //'SUPPLIER',
            //'TYP0',
            //'TYP1',
            //'TYP2',
            //'UDATUM',
            //'UMSATZ0',
            //'UMSATZ1',
            //'UMSATZ2',
            //'UMSATZ3',
            //'UMSATZ4',
            //'UMSATZ5',
            //'UMSATZ6',
            //'UMSATZ7',
            //'UMSATZ8',
            //'UMSATZ9',
            //'UMSATZ10',
            //'UMSATZ11',
            //'UMSATZ12',
            //'VATIDNO',
            //'VERTID',
            //'VERTRNAME',
            //'VPROV',
            //'VRABATT',
            //'ZAHLUNGB',
            //'ZAHLUNGT',
            //'CNAME',
            //'CHNAME',
            //'CDATE',
            //'CHDATE',
            //'MANDANTNO',
            //'EXCHANGELMT',
            //'EXTWORKRES',
            //'EXCHANGEPHOTOLMT',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
