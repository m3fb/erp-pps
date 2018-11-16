<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UrlaubSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Urlaubs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="urlaub-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Urlaub', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'LBNO',
            // 'NAME',
            // 'OPNO',
            // 'OPOPNO',
            // 'ORNAME',
            // 'ORNO',
            // 'OUT',
            // 'ADCCOUNT',
            // 'ADCMESS',
            // 'ADCSTAT',
             'ADCWORK',
            // 'APARTS',
            // 'ARCHIVE',
            // 'ATE',
            // 'ATP',
            // 'ATR',
            // 'BPARTS',
            // 'BPARTS2',
            // 'CALTYP',
            // 'DESCR',
            // 'ERRNUM',
            // 'EXSTAT',
            // 'FKLBNO',
            // 'FNPK',
            // 'GPARTS',
            // 'INPARTSDBL',
            // 'ISINTERNAL',
            // 'MSGID',
            // 'MSINFO',
             'MSTIME',
            // 'MTIME0',
            // 'MTIME1',
            // 'MTIME2',
            // 'MTIME3',
            // 'OPMULTIMESSAGEGROUP',
             'PERSNAME',
             'PERSNO',
             'STATUS',
            // 'TERMINAL',
            // 'WPLACE',
            // 'MATCOST',
            // 'CNAME',
            // 'CHNAME',
             'CDATE',
             'CHDATE',
            // 'MANDANTNO',
            // 'TSTAMP',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
