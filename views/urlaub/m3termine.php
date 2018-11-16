<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\M3Termine;
use app\models\User;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\grid\EditableColumn;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;




/* @var $this yii\web\View */
$this->title = 'Termine m3profile';
$this->params['breadcrumbs'][] = $this->title;



?>


<div class="m3-termine-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            #'ID',
            [
				'class'=>'kartik\grid\EditableColumn',
				'attribute'=>'START',
				'label' => 'Start',
				'refreshGrid' => true,
				'hAlign'=>'center',
				'vAlign'=>'middle',
				'width'=>'9%',
				'format'=>'date',
				'refreshGrid' => true,
				'xlFormat'=>"mmm\\-dd\\, \\-yyyy",
				#'headerOptions'=>['class'=>'kv-sticky-column'],
				#'contentOptions'=>['class'=>'kv-sticky-column'],
				#'readonly'=>function($model, $key, $index, $widget) {
				#	return (!$model->DELIVERY); // do not allow editing of inactive records
				#},
				'editableOptions'=>function ($model, $key, $index, $widget) {
				return [
					'header'=>'Startdatum',
					'name' => 'M3Termine['.$index.'][START]',
					'size'=>'md',
					'formOptions'=>['action' => ['/procontrol/editcustomerdate']], // point to the new action
					'inputType'=>\kartik\editable\Editable::INPUT_WIDGET,
					'widgetClass'=> 'kartik\datecontrol\DateControl',
					'options'=>[
						'type'=>\kartik\datecontrol\DateControl::FORMAT_DATE,
						'displayFormat'=>'dd.MM.yyyy',
						#'saveFormat'=>'dd.mm.yyyy',
						'saveFormat'=>'d.M.Y',
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
			[
				'class'=>'kartik\grid\EditableColumn',
				'attribute'=>'ENDE',
				'label' => 'Ende',
				'refreshGrid' => true,
				'hAlign'=>'center',
				'vAlign'=>'middle',
				'width'=>'9%',
				'format'=>'date',
				'refreshGrid' => true,
				'xlFormat'=>"mmm\\-dd\\, \\-yyyy",
				#'headerOptions'=>['class'=>'kv-sticky-column'],
				#'contentOptions'=>['class'=>'kv-sticky-column'],
				#'readonly'=>function($model, $key, $index, $widget) {
				#	return (!$model->DELIVERY); // do not allow editing of inactive records
				#},
				'editableOptions'=>function ($model, $key, $index, $widget) {
				return [
					'header'=>'Startdatum',
					'name' => 'M3Termine['.$index.'][ENDE]',
					'size'=>'md',
					'formOptions'=>['action' => ['/procontrol/editcustomerdate']], // point to the new action
					'inputType'=>\kartik\editable\Editable::INPUT_WIDGET,
					'widgetClass'=> 'kartik\datecontrol\DateControl',
					'options'=>[
						'type'=>\kartik\datecontrol\DateControl::FORMAT_DATE,
						'displayFormat'=>'dd.MM.yyyy',
						#'saveFormat'=>'dd.mm.yyyy',
						'saveFormat'=>'d.M.Y',
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
            'TITEL',
            //'BESCHREIBUNG',
            // 'ZUSATZ',
            [
				'attribute' => 'CNAME',
				'label' => 'erstellt von',
				'value' => function($model) {
					$user = User::findOne($model['CNAME']);
				return ($user) ? $user->firstname ." " .$user->surename : '';

				}
			],
			[
				'attribute' => 'CDATE',
				'label' => 'erstellt am:',
				'format' => ['datetime'],
			],
			[
				'attribute' => 'CHNAME',
				'label' => 'geändert von',
				'value' => function($model) {
					$user = User::findOne($model['CHNAME']);
				return ($user) ? $user->firstname ." " .$user->surename : '';

				}
			],
			[
				'attribute' => 'CHDATE',
				'label' => 'geändert am:',
				'format' => ['datetime'],
			],
            // 'pruef',
            ['class' => 'yii\grid\ActionColumn',
								'template'    => '{delete}',
								'buttons' => [
									'delete' => function ($url, $model, $id) {
									return Html::a('<span class="glyphicon glyphicon-trash"></span>',
												['procontrol/delete-customer-dates', 'id'=>$id], [
												'title' => \Yii::t('yii', 'Delete'),
												'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
												'data-method' => 'post',
												'data-pjax' => '0',
													]);
											},
								]
			]
        ],
        'panel' => [
			'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-calendar"></i>&nbsp;m3profile Termine</b></h3>',
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
			['content' =>
				Html::a('<i class="glyphicon glyphicon-plus"></i>',['create-customer-dates'], ['data-pjax' => 0, 'class' => 'btn btn-success', 'title' => 'New Date'])# . ' '.
				#Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type' => 'button', 'title' => 'Add Book', 'class' => 'btn btn-success', 'onclick' => 'alert("This will launch the book creation form.\n\nDisabled for this demo!");']) . ' '.
				#Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['show-customer-dates'], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => 'Reset Grid'])
			],
			'{export}',
			'{toggleData}',
		]
    ]); ?>



</div>
