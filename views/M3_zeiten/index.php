<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\M3_zeitenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'M3 Zeitens';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="m3-zeiten-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create M3 Zeiten', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            [
				'attribute' =>'MSTIME',
				'format' => ['datetime'],
			],
            'PERSNAME',
            'PERSNO',
            'STATUS',
            // 'WORKID',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
