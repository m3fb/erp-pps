<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\qualitainer\Reklamationen;
use app\models\qualitainer\Qualitainer_user;
use app\models\qualitainer\Massnahmen;



/* @var $this yii\web\View */
/* @var $searchModel app\models\St_stockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'interen Reklamationen';

$username_ar = Qualitainer_user::find()
				->select(["OID","LEFT([Vorname],1) + '. '+ [Nachname] as Name"])
				->orderBy(['Nachname'=>SORT_ASC])
				->all();
$username = ArrayHelper::map($username_ar, 'OID', 'Name');

$gridColumns = [

  [
    'attribute' => 'Status',
    'format' => 'raw',
    'width' =>'150px',
    'filterType'=>GridView::FILTER_SELECT2,
    'filter'=>[1=>'Erfasst',2=>'In Bearbeitung',3=>'Wartet',4=>'Abgeschlossen'],
    'filterWidgetOptions'=>[
        'pluginOptions'=>['allowClear'=>true],
    ],
    'filterInputOptions'=>['placeholder'=>'Status'],
    'group'=>true,
    #'groupedRow'=>true,
    'groupOddCssClass'=> function($model){
      ($model->Status ==4)?$class='bg-success text-success':$class='bg-warning text-warning';
      return $class;
    },
    'groupEvenCssClass'=>function($model){
      ($model->Status ==4)?$class='bg-success text-success':$class='bg-warning text-warning';
      return $class;
    },
    'value' => function($model){
      $reklamations_status=[1=>'Erfasst',2=>'In Bearbeitung',3=>'Wartet',4=>'Abgeschlossen'];
      return $reklamations_status[$model->Status];
    }
  ],
  ['class' => 'yii\grid\SerialColumn'],
  [
    'class'=>'kartik\grid\ExpandRowColumn',
    'width'=>'50px',
    'value'=>function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
              },
    'detail' =>  function ($model, $key, $index, $column) {
      $model = Massnahmen::getRekMassnahmen($model->Reklamationsnummer);

      return Yii::$app->controller->renderPartial('_reklamationen-massnahmen', [
                    'model' => $model]);
            },
    'headerOptions'=>['class'=>'kartik-sheet-style'],
    'expandOneOnly'=>true,
  ],
  [
    'attribute' => 'ErfasstAm',
    'format' => 'dateTime',
  ],
  [
    'attribute' => 'Reklamationsnummer',
    'label' => 'Rek.Nr.',
  ],
  [
    'attribute' => 'ErfasstVon',
    'label' => 'Erfasst von',
    'filterType'=>GridView::FILTER_SELECT2,
    'filter'=>$username,
    'filterWidgetOptions'=>[
        'pluginOptions'=>['allowClear'=>true],
    ],
    'filterInputOptions'=>['placeholder'=>'Mitarbeiter'],
    'value' => function($model){
      return $model->Vorname.' '.$model->Nachname;
    }
  ],
  [
    'attribute' => 'Form_Nummer',
    'label' => 'Werkzeug',
  ],
  [
    'attribute' => 'Langebzeichnung',
    'label' => 'Bezeichnung',
  ],
  [
    'attribute' => 'Problembeschreibung',
    'label' => 'Problembeschreibung',
    'format' => 'ntext',
  ],

  #'OID',


];

?>

  <div class="st-sock-index">
    <div class="col-md-12">


<?php

        echo GridView::widget([
              'dataProvider' => $dataProvider,
              'filterModel' => $searchModel,
              'summary' => 'Seite {page} von {pageCount} / Einträge {begin} - {end} von {totalCount}',
              'toolbar' => false,
              'panel' => [
                  'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-hand-up"></i>&nbsp;interne Reklamationen</h3>',
                  'type'=>'danger',
                  'after' => false,
              ],
              'columns' => $gridColumns,
          ]);

    ?>
    </div>
</div>
