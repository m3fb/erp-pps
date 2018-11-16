<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Urlaub */

$this->title = $model->NAME;
$this->params['breadcrumbs'][] = ['label' => 'Urlaubs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="urlaub-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->LBNO], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->LBNO], [
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
            'LBNO',
            'NAME',
            'OPNO',
            'OPOPNO',
            'ORNAME',
            'ORNO',
            'OUT',
            'ADCCOUNT',
            'ADCMESS',
            'ADCSTAT',
            'ADCWORK',
            'APARTS',
            'ARCHIVE',
            'ATE',
            'ATP',
            'ATR',
            'BPARTS',
            'BPARTS2',
            'CALTYP',
            'DESCR',
            'ERRNUM',
            'EXSTAT',
            'FKLBNO',
            'FNPK',
            'GPARTS',
            'INPARTSDBL',
            'ISINTERNAL',
            'MSGID',
            'MSINFO',
            'MSTIME',
            'MTIME0',
            'MTIME1',
            'MTIME2',
            'MTIME3',
            'OPMULTIMESSAGEGROUP',
            'PERSNAME',
            'PERSNO',
            'STATUS',
            'TERMINAL',
            'WPLACE',
            'MATCOST',
            'CNAME',
            'CHNAME',
            'CDATE',
            'CHDATE',
            'MANDANTNO',
            'TSTAMP',
        ],
    ]) ?>

</div>
