<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Bde */

$this->title = $model->NAME;
$this->params['breadcrumbs'][] = ['label' => 'Bdes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bde-view">

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
            'ORNO',
            'STATUS',
            'WPLACE',
            'PERSNO',
            'PERSNAME',
            'OPNO',
            'NAME',
            'MSTIME',
            'MSINFO',
            'ORNAME',
            'APARTS',
            'GPARTS',
            'BPARTS',
            'ATE',
            'ATR',
            'ATP',
            'ADCSTAT',
            'ADCCOUNT',
            'ADCMESS',
            'ADCWORK',
            'EXSTAT',
            'MTIME0',
            'MTIME1',
            'MTIME2',
            'MTIME3',
            'OPOPNO',
            'OUT',
            'FNPK',
            'MSGID',
            'FKLBNO',
            'TERMINAL',
            'ISINTERNAL',
            'CNAME',
            'CHNAME',
            'CDATE',
            'CHDATE',
            'MANDANTNO',
        ],
    ]) ?>

</div>
