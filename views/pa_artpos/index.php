<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use app\models\Pa_artgrp;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Pa_artposSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lager- / Bestandsliste';


$gridColumns = [
  ['class' => 'yii\grid\SerialColumn'],
  [
    'attribute' =>'GRPNO',
    'label' => 'Artikelgruppe',
    'value' => 'grpNo.GRPNAME',
    'filterType' => GridView::FILTER_SELECT2,
    'filter' => ArrayHelper::map(Pa_artgrp::find()->orderBy('GRPNAME')->asArray()->all(), 'GRPNO', 'GRPNAME'),
    'filterWidgetOptions' => [
        'pluginOptions' => ['allowClear' => true],
    ],
    'filterInputOptions' => ['placeholder' => 'Artikelgruppe'],
  ],
  'ARTDESC',
  'ARTNAME',
  [
    'attribute' =>'toolNo',
    'label' => 'WerkzeugNr.',
    'value' => 'toolNo.COMMNO',
  ],
  [
    'attribute' =>'ALAGER3',
    'filter' => false,
    'value' => function($model){
      return Yii::$app->formatter->asDecimal($model->ALAGER3) . ' '. $model->MASSEINH;
    },
  ],
  [
    'attribute' =>'ALAGER2',
    'filter' => false,
    'value' => function($model){
      return Yii::$app->formatter->asDecimal($model->ALAGER2) . ' '. $model->MASSEINH;
    },
  ],
  [
    #'attribute' =>'freierBestand',
    'label' => 'Freier Bestand',
    'value' => function($model){
      $freeStock = $model->ALAGER3 - $model->ALAGER2;
      return Yii::$app->formatter->asDecimal($freeStock) . ' '. $model->MASSEINH;
    },
  ],

   [
    'class' => 'kartik\grid\ActionColumn',
    'template' => ' {st_stock}', // <--  custom action's name
    'header' => false,
    'buttons' => [
      'st_stock' => function($url, $model, $key) {
        return ($model->ALAGER3 > 0 )? Html::a('<i class="glyphicon glyphicon-th"></i>', ['st_stock/index','St_stockSearch[ARTDESC]'=>$model->ARTDESC],['title' => 'Mehrfachlager']) : NULL;
      }
    ]
  ],
];
#$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pa-artpos-index">

    <?php // var_dump($dataProvider); // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
          'dataProvider' => $dataProvider,
          'filterModel' => $searchModel,
          'toolbar' => false,
          'panel' => [
              'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i>' .' '. Html::encode($this->title) . '</h3>',
              'type'=>'primary',
              #'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Create Country', ['create'], ['class' => 'btn btn-success']),
              'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset', ['index'], ['class' => 'btn btn-info']),
          ],
          'columns' => $gridColumns,
      ]); ?>
</div>
