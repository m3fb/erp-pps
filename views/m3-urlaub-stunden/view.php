<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\M3UrlaubStunden */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'M3 Urlaub Stundens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="m3-urlaub-stunden-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ID], [
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
            'ID',
            'WORKID',
            'JAHR',
            'S1',
            'S2',
            'S3',
            'S4',
            'S5',
            'S6',
            'S7',
            'S8',
            'S9',
            'S10',
            'S11',
            'S12',
            'U1',
            'U2',
            'U3',
            'U4',
            'U5',
            'U6',
            'U7',
            'U8',
            'U9',
            'U10',
            'U11',
            'U12',
        ],
    ]) ?>

</div>
