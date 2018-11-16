<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\grid\EditableColumn;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
#use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model app\models\Personal */

$this->title = 'wlanverwaltung';
#$this->params['breadcrumbs'][] = ['label' => 'Personals', 'url' => ['index']];
#$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
  ['class' => 'yii\grid\SerialColumn'],
  'surename',
  'firstname',
  [
    'class' => 'kartik\grid\EditableColumn',
    'attribute'=>'wlan_username',
    'label' => 'Wlan Benutzername',
    'refreshGrid' => true,
    'editableOptions' => function ($model, $key, $index, $widget) {
      return [
          'header' => 'Wlan Benutzername',
          #'name' => 'user['.$index.'][wlan_username]',
          'value' => $model['wlan_username'],
          'formOptions'=>['action' => ['/personal/editwlanverwaltung']], // point to the new action
        ];
    },
  ],
  [
    'class' => 'kartik\grid\EditableColumn',
    'attribute'=>'wlan_password',
    'label' => 'Wlan Passwort',
    'refreshGrid' => true,
    'editableOptions' => function ($model, $key, $index, $widget) {
      return [
          'header' => 'Wlan Passwort',
          #'name' => 'user['.$index.'][wlan_username]',
          'value' => $model['wlan_password'],
          'formOptions'=>['action' => ['/personal/editwlanverwaltung']], // point to the new action
        ];
    },
  ],
  [
    'class'=>'kartik\grid\EditableColumn',
    'attribute'=>'wlan_expiration',
    'label' => 'Ablaufdatum',
    'refreshGrid' => true,
    'hAlign'=>'center',
    'vAlign'=>'middle',
    'format'=>['datetime','php:d.m.Y / H:i'],
    'refreshGrid' => true,
    'xlFormat'=>"mmm\\-dd\\, \\-yyyy",
    'headerOptions'=>['class'=>'kv-sticky-column'],
    'contentOptions'=>['class'=>'kv-sticky-column'],
    'editableOptions'=>function ($model, $key, $index, $widget) {
      return [
        'header'=>'wlan_expiration',
        #'name' => 'user['.$index.'][wlan_expiration]',
        'size'=>'md',
        'formOptions'=>['action' => ['/personal/editwlanverwaltung']], // point to the new action
        'inputType'=>\kartik\editable\Editable::INPUT_WIDGET,
        'widgetClass'=> 'kartik\datecontrol\DateControl',
        'options'=>[
            'type'=>\kartik\datecontrol\DateControl::FORMAT_DATETIME,
            'displayFormat'=>'dd.MM.yyyy H:i',
            #'saveFormat'=>'dd.mm.yyyy',
            'saveFormat'=>'d.M.Y H:i:s',
            #'saveFormat'=>date('Y-m-d'),
            'options'=>[
              'pluginOptions'=>[
                'autoclose'=>true
              ]
            ]
          ]
        ];
      }
    ],
];

?>
<div class="wlanverwaltung">

  <?= GridView::widget([
      'dataProvider' => $dataProvider,
      //'filterModel' => $searchModel,
      'columns' => $gridColumns,
      'panel' => [
        'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-signal"></i>&nbsp; Hotspot Zugangsdaten für Mitarbeiter</b></h3>',
        'type'=>'primary',
        'footerOptions'=>['class'=>'panel-footer'],
        ],
      'export' => false,
      'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
      'headerRowOptions' => ['class' => 'kartik-sheet-style'],
      'filterRowOptions' => ['class' => 'kartik-sheet-style'],
      'pjax' => true, // pjax is set to always true for this demo
      // set your toolbar
      'toolbar' =>  [
          '{export}',
          '{toggleData}',
        ]
  ]); ?>

</div>
