<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjektChecklisteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'm3profile Projekte Übersicht';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="m3-projekt-checkliste-index">

  
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'toolbar' =>  [
			['content' => 
				Html::a('<i class="glyphicon glyphicon-arrow-left"></i>', ['index'],['type' => 'button', 'class' => 'btn btn-primary']). ' '.
				Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create-project'],['type' => 'button', 'class' => 'btn btn-success'])
			],
		],
		'panel' => [
				'type' => GridView::TYPE_PRIMARY,
				'heading' => $this->title,
			],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'ID',
            'Projekt',
            'Kunde',
            [
				'attribute' => 'erstellt_von',
				'label' => 'Erstellt',
				'width'=>'120px',
				'value'=>function ($model, $key, $index, $widget) { 
				$ausgabe = $model->user->firstname." ".$model->user->surename;
                return $ausgabe;
            },
				'format' => 'html',
			],
			[
				'attribute' => 'Erstelldatum',
				'label' => 'Erstelldatum',
				'format' => 'datetime',
			],
           

            [
				'class' => '\kartik\grid\ActionColumn',
				'buttons' => [
					'delete' =>	function($url, $model) {
							//Action für Project
							return Html::a('<span class="glyphicon glyphicon-trash"></span>',
																		['projekt/delete-project', 'id'=>$model->ID], [
																		'title' => \Yii::t('yii', 'Delete'),
																		'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
																		'data-method' => 'post',
																		'data-pjax' => '0',
																			]);
				}
				],
            
            ],
        ],
    ]); ?>
</div>
