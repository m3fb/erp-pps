<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;



/* @var $this yii\web\View */
/* @var $searchModel app\models\St_stockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mehrfachlager- / Bestandsliste';

$gridColumns = [
  ['class' => 'yii\grid\SerialColumn'],
  'PLACE',
  [
    'attribute' => 'MENGE',
    'format' => 'decimal',
  ],
  [
    'attribute' =>'ARTDESC',
    'label' => 'Art. Nr.',
    'filter' => false,
  ],
  [
    'attribute' =>'ARTNAME',
    'filter' => false,
  ],
  [
    'attribute' =>'COMMNO',
    'filter' => false,
  ],
  [
    'attribute' =>'INFO1',
    'filter' => false,
  ],
  [
    'attribute' =>'MSTIME',
    'label' => 'erste Einbuchung',
    'format' => 'date',
  ],
  [
    'attribute' =>'MSTIME',
    'label' => 'Lagerzeit [Wochen]',
    'value' => function($model){
      $i = dateDiffInWeeks($model['MSTIME'], date('Y-m-d H:i:s'));
      ($i>1) ? $ausgabe = $i : $ausgabe = '';
      return $ausgabe;
    }
  ],
];
#$this->params['breadcrumbs'][] = $this->title;
?>


    <?php // var_dump($dataProvider); // echo $this->render('_search', ['model' => $searchModel]); ?>
  <div class="st-sock-index">
    <?php
    $form = ActiveForm::begin([
      'method' => 'get',
      'type'=>ActiveForm::TYPE_INLINE,
      'action' => Url::to(['st_stock/index']),
    ]);
    echo '<div class="stocknav"><span><b>Suche: </b></span>';
    echo Form::widget([
      'model'=>$searchModel,
      'form'=>$form,
      'attributes'=>[
        'ARTDESC'=>[
          'type'=>Form::INPUT_TEXT,
          ],
        'COMMNO'=>[
          'type'=>Form::INPUT_TEXT,
          ],
        'ARTNAME'=>[
            'type'=>Form::INPUT_TEXT,
            ],
        'INFO1'=>[
            'type'=>Form::INPUT_TEXT,
            ],
        'refresh'=>[
        'type'=>Form::INPUT_RAW,
        'value'=>Html::submitButton('<span class="glyphicon glyphicon-refresh"></span>', ['class'=>'btn btn-primary'])
        ]
      ]
    ]);

    #echo Html::a('<span class="glyphicon glyphicon-plus"></span>', ['create-project'],['type' => 'button', 'class' => 'btn btn-success']);
    ActiveForm::end();

    #Yii::$app->request->get('toolNo');
    #echo 'DEBUG:'.
    #var_dump(Yii::$app->request->queryParams);
    ?>

    <?php


      echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' =>$searchModel,
            'toolbar' => false,
            'panel' => [
                'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i>' .' '. Html::encode($this->title) . '</h3>',
                'type'=>'default',
                #'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Create Country', ['create'], ['class' => 'btn btn-success']),
                'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset', ['index'], ['class' => 'btn btn-info']),
            ],
            'columns' => $gridColumns,
        ]);
    ?>
</div>
