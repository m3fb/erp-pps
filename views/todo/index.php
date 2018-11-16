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

$this->title = 'Aufgabenverwaltung';
$this->params['breadcrumbs'][] = $this->title;

$username_ar = user::find()
				->select(["[firstname] + ' '+ [surename] as surename"])
				->orderBy(['surename'=>SORT_ASC])
				->all();
$username_sys = ArrayHelper::map($username_ar, 'surename', 'surename');
$zusatz = [
  'Alle',
  'Schichtführer',
  'Frühschicht',
  'Nachtschicht',
  'Spätschicht',
  'Jede Schicht',
  'Technikum',
  'Technikum und Produktion'
];
foreach($zusatz as $zu){
  $zusatz_username[$zu] = $zu;
}

$username =$zusatz_username + $username_sys;

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
      'attribute'=>'department',
      'vAlign'=>'middle',
      'width'=>'180px',
      'filterType'=>GridView::FILTER_SELECT2,
      'filter'=> ['Technikum' => 'Technikum', 'Produktion' => 'Produktion','Konstruktion'=>'Konstruktion' ],
      'filterWidgetOptions'=>[
        'pluginOptions'=>['allowClear'=>true],
      ],
      'filterInputOptions'=>['placeholder'=>'Abteilung'],
      'format'=>'raw'
    ],
    [
      'attribute'=>'beauftragter',
      'vAlign'=>'middle',
      'width'=>'180px',
      'filterType'=>GridView::FILTER_SELECT2,
      'filter' => $username,
      'filterWidgetOptions'=>[
        'pluginOptions'=>['allowClear'=>true],
      ],
      'filterInputOptions'=>['placeholder'=>'Beauftragter'],
      'format'=>'raw'
    ],
    'name',
    [
      'attribute'=>'zyklus',
      'vAlign'=>'middle',
      'width'=>'90px',
      'filterType'=>GridView::FILTER_SELECT2,
      'filterWidgetOptions'=>[
        'pluginOptions'=>['allowClear'=>true],
      ],
      'filterInputOptions'=>['placeholder'=>'Zyklus'],
      'format'=>'raw'
    ],
    [
      'attribute'=>'prio',
      'vAlign'=>'middle',
      'width'=>'60px',
      'filterType'=>GridView::FILTER_SELECT2,
      'filterWidgetOptions'=>[
        'pluginOptions'=>['allowClear'=>true],
      ],
      'filterInputOptions'=>['placeholder'=>'Priorität'],
      'format'=>'raw'
    ],
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

  					  'update' => function ($url, $model, $id) use ($env)  {
  							  return  Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id'=>$id,'env'=>$env],
  											['data'=>'1',
  											'title' => Yii::t('app', 'update'),
  											'target'=> '_self']);
  					  },
  					  'delete' => function ($url, $model, $id) use($env)   {
  							  return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id'=>$id,'env'=>$env],
  											['data'=>'1',
  											'data-method'=>'post',
  											'title' => Yii::t('app', 'delete'),
  											'target'=> '_self']);
  					  },
  					],
    ]
];

?>
<div class="todo-index">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' =>'Aufgaben {begin} - {end} von {totalCount}',
        'panel' => [
					'heading'=>'
              <h3 class="panel-title">'.
              Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create','env'=>''], ['class' => 'btn btn-success btn-xs']) .
              '&nbsp;<i class="glyphicon glyphicon-cog"></i> Aufgaben </h3>',
					'type'=>'primary',
					'before' => false,
					'after' => false,
					'footer'=>false,
        ],
        'columns' => $columns,
    ]); ?>

</div>
