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

$this->title = 'Reklamationsauswertung';

$gridColumns = [
  ['class' => 'yii\grid\SerialColumn'],
  #'OID',
  [
    'attribute' => 'Reklamationsnummer',
    'label' => 'Rek.Nr.',
    'format' => 'raw',
    'groupOddCssClass'=>'bg-warning text-warning',  // configure odd group cell css class
    'groupEvenCssClass'=>'bg-warning text-warning',
    'group'=>true,
    'groupedRow'=>true,
    'value' => function($model){
      return 'Rek.Nr.: <b>'.$model['Reklamationsnummer'].'</b>';
    }
  ],
  [
    'attribute' =>'Reklamationsdatum',
    'format' => 'dateTime',
    'group'=>true,
  ],
  [
    'attribute' =>'Reklamationstyp',
    'label' => 'Rekl.typ',
    'group'=>true,
    'subGroupOf'=>1,
    'value' => function($model) {
        if ($model->Reklamationstyp == 1) {
          $ausgabe = 'Kundenrekl.';
        }
        elseif ($model->Reklamationstyp == 2) {
          $ausgabe = 'interne Rekl.';
        }
        else {
          $ausgabe = '-';
        }
        return $ausgabe;
      }
  ],
  [
    'attribute' =>'Kurzbezeichnung',
    'label' => 'Kurzbez.',
    'group'=>true,
    'subGroupOf'=>1,
  ],
  [
    'attribute' =>'ParentElement',
    'label' => 'Fehler Element',
  ],
  [
    'attribute' =>'Fehler',
  ],
  [
    'attribute' =>'Ursachentheorie',
  ],
];

$gridColumnsStatistik = [
  #['class' => 'yii\grid\SerialColumn'],
  [
    'attribute' => 'wfaktor',
    'label' => 'Wirkungsfaktor',
    'contentOptions'=> ['class'=>'bg-danger text-danger'],
    'headerOptions'=> ['class'=>'bg-danger text-danger'],
    'width' => '200px',
  ],
  [
    'attribute' => 'ges',
    'label' => 'gesamt',
    'headerOptions'=> ['class'=>'bg-default text-default'],
    'contentOptions'=> ['class'=>'bg-default text-default'],
    'format' => 'raw',
    'value' => function($model) use ($wirkungsfaktor,$month,$env){
      ($model['wfaktor'] == $wirkungsfaktor && $month == 0) ? $classOption = 'btn btn-success': $classOption ='';
      $ausgabe =
      Html::a($model['ges'],
            ['auswertung', 'wirkungsfaktor'=>$model['wfaktor'],'month'=>0, 'attribut'=>'','env'=>$env],
            ['class' => $classOption]
          );
      return $ausgabe;
    }
  ],
  [
    'attribute' => 'm12',
    'label' => '12 Mon.',
    'headerOptions'=> ['class'=>'bg-default'],
    'format' => 'raw',
    'value' => function($model) use ($wirkungsfaktor,$month,$env){
      ($model['wfaktor'] == $wirkungsfaktor && $month == 12) ? $classOption = 'btn btn-success': $classOption ='';
      $ausgabe =
      Html::a($model['m12'],
            ['auswertung', 'wirkungsfaktor'=>$model['wfaktor'],'month'=>12, 'attribut'=>'','env'=>$env],
            ['class' => $classOption]
          );
      return $ausgabe;
    }
  ],
  [
    'attribute' => 'm6',
    'label' => '6 Mon.',
    'width' => '50px',
    'headerOptions'=> ['class'=>'bg-info text-info'],
    'contentOptions'=> ['class'=>'bg-info text-info'],
    'format' => 'raw',
    'value' => function($model) use ($wirkungsfaktor,$month,$env){
      ($model['wfaktor'] == $wirkungsfaktor && $month == 6) ? $classOption = 'btn btn-success': $classOption ='';
      $ausgabe =
      Html::a($model['m6'],
            ['auswertung', 'wirkungsfaktor'=>$model['wfaktor'],'month'=>6, 'attribut'=>'','env'=>$env],
            ['class' => $classOption]
          );
      return $ausgabe;
    }
  ],
  [
    'attribute' => 'm6i',
    'label' => false,
    'width' => '50px',
    'headerOptions'=> ['class'=>'bg-info text-info'],
    'contentOptions'=> ['class'=>'bg-info text-info'],
    'value' => function($model) {
      ( !in_array($model['m6i'],[101,-101])) ? $ausgabe=$model['m6i'].'%':$ausgabe='-';
      return $ausgabe;
    }
  ],
  [
    'attribute' => 'm6i',
    'label' => false,
    'width' => '50px',
    'headerOptions'=> ['class'=>'bg-info text-info'],
    'contentOptions'=> ['class'=>'bg-info text-info'],
    'format' => 'raw',
    'value' => function($model){
      if ($model['m6i'] == 0 ) {
        $arrow = '<span class="glyphicon glyphicon-arrow-right text-primary"</span>';
      }
      elseif ($model['m6i'] < 0 ) {
        $arrow = '<span class="glyphicon glyphicon-arrow-down text-success"</span>';
      }
      elseif ($model['m6i'] > 0 ) {
        $arrow = '<span class="glyphicon glyphicon-arrow-up text-danger"</span>';
      }
      $ausgabe = $arrow;

      return $ausgabe;
    }
  ],
  [
    'attribute' => 'm3',
    'label' => '3 Mon.',
    'width' => '50px',
    'headerOptions'=> ['class'=>'bg-warning text-warning'],
    'contentOptions'=> ['class'=>'bg-warning text-warning'],
    'format' => 'raw',
    'value' => function($model) use ($wirkungsfaktor,$month,$env){
      ($model['wfaktor'] == $wirkungsfaktor && $month == 3) ? $classOption = 'btn btn-success': $classOption ='';
      $ausgabe =
      Html::a($model['m3'],
            ['auswertung', 'wirkungsfaktor'=>$model['wfaktor'],'month'=>3, 'attribut'=>'','env'=>$env],
            ['class' => $classOption]
          );
      return $ausgabe;
    }
  ],
  [
    'attribute' => 'm3i',
    'label' => false,
    'width' => '50px',
    'headerOptions'=> ['class'=>'bg-warning text-warning'],
    'contentOptions'=> ['class'=>'bg-warning text-warning'],
    'value' => function($model) {
      ( !in_array($model['m3i'],[101,-101])) ? $ausgabe=$model['m3i'].'%':$ausgabe='-';
      return $ausgabe;
    }
  ],
  [
    'attribute' => 'm3i',
    'label' => false,
    'width' => '50px',
    'headerOptions'=> ['class'=>'bg-warning text-warning'],
    'contentOptions'=> ['class'=>'bg-warning text-warning'],
    'format' => 'raw',
    'value' => function($model){
      if ($model['m3i'] == 0 ) {
        $arrow = '<span class="glyphicon glyphicon-arrow-right text-primary"</span>';
      }
      elseif ($model['m3i'] < 0 ) {
        $arrow = '<span class="glyphicon glyphicon-arrow-down text-success"</span>';
      }
      elseif ($model['m3i'] > 0 ) {
        $arrow = '<span class="glyphicon glyphicon-arrow-up text-danger"</span>';
      }
      $ausgabe = $arrow;

      return $ausgabe;
    }
  ],
];
#$this->params['breadcrumbs'][] = $this->title;
?>


    <?php // var_dump($dataProvider); // echo $this->render('_search', ['model' => $searchModel]); ?>
  <div class="st-sock-index">
    <div class="col-md-8">


    <?php
    echo GridView::widget([
          'dataProvider' => $statistischeWerte,
          'summary' =>'',
          'toolbar' => false,
          'panel' => [
              'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list">
                            </i> Fehlerauswertung aus internen und externen Reklamationen / Statistische Werte</h3>',
              'type'=>'danger',
              #'before' => false,
    					'after' => false,
    					'footer'=>false,
          ],
          'columns' => $gridColumnsStatistik,
      ]);
      ?>
    </div>
    <div class="col-md-4">
    </div>
    <div class="col-md-12">
<?php
      if($groupedData!=''){
        echo $groupedData;
        }

      if($dataProvider !='') {
        echo GridView::widget([
              'dataProvider' => $dataProvider,
              'summary' =>'',
              'toolbar' => false,
              'panel' => [
                  'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i>
                      Fehler und Ursachen von Wirkungsfaktor: '.$wirkungsfaktor.' / <b>'.$attribut.' </b>/ '.$month.' Monate</h3>',
                  'type'=>'danger',
                  #'before' => false,
                  'after' => false,
                  'footer'=>false,
              ],
              'columns' => $gridColumns,
          ]);
      }
    ?>
    </div>
</div>
