<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\St_stock */

$this->title = $model->NO;
$this->params['breadcrumbs'][] = ['label' => 'St Stocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="st-stock-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->NO], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->NO], [
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
            'NO',
            'ARTNO',
            'INCDATE',
            'MENGE',
            'OPNO',
            'PLACE',
            'WAREHOUSE',
            'INFO1',
            'INFO2',
            'INFO3',
            'CNAME',
            'CHNAME',
            'CDATE',
            'CHDATE',
            'MANDANTNO',
            'REF_TMP_ISQUARANTINESTORE',
            'INFO4',
            'INFO5',
            'INFO6',
        ],
    ]) ?>

</div>
