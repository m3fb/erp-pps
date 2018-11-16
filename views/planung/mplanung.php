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

/* @var $this yii\web\View */
/* @var $searchModel app\models\TodoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Maschinenplanung';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mplanung-index">
	<div class="col-sm-6">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $activeMachines,
        'filterModel' => $searchModel,
        'rowOptions'=>function($model){
            if($model['CONTROL'] ==  1){
                return ['class' => 'danger'];
            }
            else if ($model['CONTROL'] ==  2){
                return ['class' => 'warning'];
            }
             else if ($model['CONTROL'] ==  3){
                return ['class' => 'success'];
            }
            else if ($model['CONTROL'] ==  4){
                return ['class' => 'info'];
            } 
            else {
                return ['class' => 'active'];
            }          
		},
        'summary' =>'{totalCount} Maschinen',
        'columns' => [
            [
				'class' => 'yii\grid\SerialColumn',
				'contentOptions'=>['style'=>'width: 50px;']
			],
            [
				'class' => 'kartik\grid\EditableColumn',
				'attribute'=>'CONTROL', 
				'label' => 'Prio',
				'refreshGrid' => true,
				'contentOptions'=>['style'=>'width: 60px;'],
				/*'readonly'=>function($model, $key, $index, $widget) {
					return (!$model['STATUS']); // do not allow editing of inactive records
				},*/
				'editableOptions' => function ($model, $key, $index, $widget) {
            return [
					'header' => 'Prio',
					'name' => 'Maschine['.$index.'][CONTROL]',
					'value' => $model['CONTROL'],
					'inputType' => \kartik\editable\Editable::INPUT_SPIN,
					'id'=> 'maschine-'.$index.'-control',
					'options' => [
						'pluginOptions' => ['min'=>0, 'max'=>4]
					]
				];
			},
				'hAlign'=>'right', 
				'vAlign'=>'middle',
				'width'=>'100px',
				'format'=>['decimal', 0],
				'pageSummary' => true
			],
			[
				'attribute'=>'NAME'
            ],
            

            //'id',
            //'NAME',
            //'department',
           
        ],
    ]);  ?>
    </div>
</div>
<div class="col-sm-6"></div>
</div>
