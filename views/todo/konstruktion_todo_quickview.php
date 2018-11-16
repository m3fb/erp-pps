<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
#use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\grid\EditableColumn;
use yii\helpers\Url;
use yii\bootstrap\Progress;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use app\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TodoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

#$this->title = 'Aufgaben Konstruktion';
#$this->params['breadcrumbs'][] = $this->title;

$columns = [
  ['class' => 'yii\grid\SerialColumn'],
  [
    'attribute'=>'due_date',
    'value'=>function ($model, $key, $index, $widget) {
      $datum = Yii::$app->formatter->asDate($model['due_date']);
      $model['due_date'] < date('Y-m-d') ? $color = 'red' : $color = 'black';
      $ausgabe = '<font color="'.$color.'">'.$datum .'</font>';
      return $ausgabe;
    },
    'format' => 'html',
    'filter'=>false,
  ],
  [
    'attribute'=>'beauftragter',
    'vAlign'=>'middle',
    'width'=>'180px',
    'filter'=> ['Fabian Braun'=>'Fabian Braun','Christian Ortner'=>'Christian Ortner'],
    'filterType'=>GridView::FILTER_SELECT2,
    'filterWidgetOptions'=>[
      'pluginOptions'=>['allowClear'=>true],
    ],
    'filterInputOptions'=>['placeholder'=>'Beauftragter'],
    'format'=>'raw'
  ],
  [
    'attribute' => 'name',
    'format' => 'ntext',
  ],
  'prio',
  [
    'class' => 'yii\grid\ActionColumn',
    'template'    => '{update}',
    'buttons' => [
      'update' => function ($url, $model, $id) use ($env) {
        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
          ['update', 'id'=>$id,'env'=>$env], [
            'title' => \Yii::t('yii', 'update'),
            'data-pjax' => '0',
          ]);
      },
    ]
  ],
  [
    'class' => 'yii\grid\ActionColumn',
    'template'    => '{delete}',
    'buttons' => [
      'delete' => function ($url, $model, $id) use ($env) {
        return Html::a('<span class="glyphicon glyphicon-check"></span>',
            ['delete', 'id'=>$id,'env'=>$env], [
            'title' => \Yii::t('yii', 'erledigt'),
            'data-confirm' => Yii::t('yii', 'Aufgabe erledigt? Die Aufgabe wird gelöscht!'),
            'data-method' => 'post',
            'data-pjax' => '0',
              ]);
          },
    ]
  ],
];
?>
<div class="todo-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' =>'Aufgaben {begin} - {end} von {totalCount}',
        'columns' => $columns,
        'panel' => [
          'heading'=>'
              <h3 class="panel-title">'.
              Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create','env'=>'konstruktion_qv'], ['class' => 'btn btn-success btn-xs']) .
              '&nbsp;<i class="glyphicon glyphicon-cog"></i> Aufgaben Konstruktion </h3>',
					'type'=>'primary',
					'before' => false,
					'after' => false,
					'footer'=>false,
					],
    ]); ?>

</div>
