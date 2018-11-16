<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\M3UrlaubStundenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'M3 Urlaub Stundens';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="m3-urlaub-stunden-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create M3 Urlaub Stunden', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'WORKID',
            'JAHR',
            'S1',
            'S2',
            // 'S3',
            // 'S4',
            // 'S5',
            // 'S6',
            // 'S7',
            // 'S8',
            // 'S9',
            // 'S10',
            // 'S11',
            // 'S12',
            // 'U1',
            // 'U2',
            // 'U3',
            // 'U4',
            // 'U5',
            // 'U6',
            // 'U7',
            // 'U8',
            // 'U9',
            // 'U10',
            // 'U11',
            // 'U12',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
