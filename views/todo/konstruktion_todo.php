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
    'attribute'=>'create_name',
    'vAlign'=>'middle',
    'width'=>'180px',
    'value'=>function ($model, $key, $index, $widget) {
      return $model->user->firstname . ' ' . $model->user->surename ;
    },
    'filterType'=>GridView::FILTER_SELECT2,
    'filter'=>ArrayHelper::map(User::find()->where(['status' => 10])->orderBy('surename')->asArray()->all(), 'id', function($model, $defaultValue) {
          return $model['surename'].' '.$model['firstname'];
        }),
    'filterWidgetOptions'=>[
      'pluginOptions'=>['allowClear'=>true],
    ],
    'filterInputOptions'=>['placeholder'=>'Benutzer'],
    'format'=>'raw'
  ],
  [
    'class' => 'yii\grid\ActionColumn',
    'template'    => '{update} {delete}',
    'buttons' => [
      'update' => function ($url, $model, $id) use ($env) {
        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
          ['update', 'id'=>$id,'env'=>$env], [
            'title' => \Yii::t('yii', 'update'),
            'data-pjax' => '0',
          ]);
      },
      'delete' => function ($url, $model, $id) use ($env) {
        return Html::a('<span class="glyphicon glyphicon-trash"></span>',
            ['delete', 'id'=>$id,'env'=>$env], [
            'title' => \Yii::t('yii', 'delete'),
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
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
              Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create','env'=>'konstruktion'], ['class' => 'btn btn-success btn-xs']) .
              '&nbsp;<i class="glyphicon glyphicon-cog"></i> Aufgaben Konstruktion </h3>',
					'type'=>'primary',
					'before' => false,
					'after' => false,
					'footer'=>false,
					],
    ]); ?>

</div>
