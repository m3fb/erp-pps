<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\widgets\Select2;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\grid\EditableColumn;

/* @var $this yii\web\View */
/* @var $model app\models\Personal */

$this->title = 'Verwaltung Abwesenheitstage';
$this->params['breadcrumbs'][] = $this->title;
#var_dump($dataProvider); die;

$gridColumns = [
      [
				'attribute' => 'LBNO',
				'width'=>'100px',
			],
      [
				'attribute' => 'PERSNO',
				'width'=>'100px',
				'filter' => false,
				'label' =>'PersNr.',
			],
      [
				'attribute' => 'PERSNAME',
				'filter' => false,
				'label' =>'Name',

			],
      [
        'class'=>'kartik\grid\EditableColumn',
        'attribute'=>'MSTIME',
        'label' => 'Datum',
        'refreshGrid' => true,
        'hAlign'=>'center',
        'vAlign'=>'middle',
        'format'=>['date','php:d.m.Y'],
        'refreshGrid' => true,
        'xlFormat'=>"mmm\\-dd\\, \\-yyyy",
        'headerOptions'=>['class'=>'kv-sticky-column'],
        'contentOptions'=>['class'=>'kv-sticky-column'],
        'editableOptions'=>function ($model, $key, $index, $widget) {
          return [
            'header'=>'abwesenheit_datum',
            #'name' => 'user['.$index.'][wlan_expiration]',
            'size'=>'md',
            'formOptions'=>['action' => ['/personal/editabwesenheitsdatum']], // point to the new action
            'inputType'=>\kartik\editable\Editable::INPUT_WIDGET,
            'widgetClass'=> 'kartik\datecontrol\DateControl',
            'options'=>[
                'type'=>\kartik\datecontrol\DateControl::FORMAT_DATE,
                'displayFormat'=>'dd.MM.yyyy',
                'saveFormat'=>'d.M.Y H:i:s',
                'options'=>[
                  'pluginOptions'=>[
                    'autoclose'=>true
                  ]
                ]
              ]
            ];
          }
        ],
      [
				'attribute' => 'STATUS',
        'filter' => false,
        'label' =>'Status',
        'width'=>'100px',
			],
      [
				'attribute' => 'BESCHREIBUNG',
        'filter' => false,
        'label' =>'Beschreibung',
			],
      [
        'class' => 'yii\grid\ActionColumn',
        'template'    => '{delete}',
        'buttons' => [
          'delete' => function ($url, $model, $id) use ($workid,$status) {
            return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                ['delete-abwesenheit','id'=>$id, 'workid'=>$workid,'status'=>$status], [
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


  <div class="personal-index">

      <h1><?= Html::encode($this->title) ?></h1>
      <div class="row">
        <div class="col-md-3">
          <?= Html::a('<i class="glyphicon glyphicon-plus"></i>&nbsp;Abwesenheitstage eintragen',
                  ['create-abwesenheit','workid'=>$workid, 'status'=>$status ],
                  ['class' => 'btn btn-success btn-xs']);
                  ?>
          </div>
      </div>
      <div style="height:20px;">&nbsp;</div>
      <?php $form = ActiveForm::begin([
            'method' => 'get',
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL],
            'options' => ['class' => 'form-horizontal'],
            'action' => Url::to(['personal/abwesenheit']),
          ]);	?>
      <div class="row">
        <div class="col-md-3">
            <?= Select2::widget([
                'name' => 'workid',
                'value' => $workid, // initial value
                'data' => ArrayHelper::map($aktivesPersonal,'NO','NAME'),
                'options' => ['placeholder' => 'Mitarbeiter auswählen','onchange' => 'this.form.submit()'],
                'pluginOptions' => [
                  'allowClear' => true,
                  'width' => '200px',
                ],
               ]);?>
        </div>
        <div class="col-md-3">
               <?= Select2::widget([
                   'name' => 'status',
                   'value' => $status, // initial value
                   'data' => [
                      800=>'Urlaub',
                      802=>'Krank',
                      804 =>'Elternzeit',
                      806=>'unbezahlter Urlaub',
                      808=>'Berufsschule'
                    ],
                   'options' => ['placeholder' => 'Status auswählen','onchange' => 'this.form.submit()'],
                   'pluginOptions' => [
                     'allowClear' => true,
                     'width' => '200px',
                   ],
                  ]);?>
          <?php ActiveForm::end(); ?>
        </div>
      </div>
          <div style="height:10px;">&nbsp;</div>
      <?php //var_dump($dataProvider);// echo $this->render('_search', ['model' => $searchModel]);?>

      <?= GridView::widget([
          'dataProvider' => $dataProvider,
          'filterModel' => $searchModel,
          'toolbar' => false,
         	 'summary' => 'Seite {page} von {pageCount} / Einträge {begin} - {end} von {totalCount}',
         	 'panel' => [
         		 'heading'=>'<h3 class="panel-title">Krankheitstage der letzten 12 Monate</h3>',
         		 'type'=>'primary',
         		 'footer'=> false,
         	 ],
          'rowOptions'=>function($model){
                   if($model['STATUS'] % 2 !=0 ){
                       return ['class' => 'danger'];
                   }
                   else {
                     return ['class' => 'success'];
                   }
       					},
  				'options' => ['style'=>'font-size:12px;'],
          'columns' => $gridColumns,

      ]); ?>
  </div>
