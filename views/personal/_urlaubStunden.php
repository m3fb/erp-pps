<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\bootstrap\BootstrapPluginAsset;



/* @var $this yii\web\View */
/* @var $model app\models\Personal



/* @var $form yii\widgets\ActiveForm */

$monats_label = array(
						1 => 'Jan.',
						2 => 'Feb.',
						3 => 'Mrz.',
						4 => 'Apr.',
						5 => 'Mai',
						6 => 'Jun.',
						7 => 'Jul.',
						8 => 'Aug.',
						9 => 'Sep.',
						10 => 'Okt.',
						11 => 'Nov.',
						12 => 'Dez.'
						);
$gridColumns = [
					[
						'attribute' => 'JAHR',
						'format' => ['html'],
						'label' => 'Jahr',
						'value'=>function ($model) {
							return "<b>".$model['JAHR']."</b>";
						}

					],
					[
						'format' => ['html'],
						'label' => '',
						'value'=>function ($model) {
							$output = "Stunden<br>Urlaub";
							return $output;
						}

					],
				];

for ($i = 1; $i <= 12; $i++) {
    $gridColumns[] = [
							'format' => ['html'],
							'label' => $monats_label[$i],
							'value'=>function ($model)use ($i){
								$output = Yii::$app->formatter->asDecimal($model['S'.$i])."<br>".Yii::$app->formatter->asDecimal($model['U'.$i]);
								return $output;
							}
						];
}

if (Yii::$app->user->identity->role >= 20) {
	$gridColumns[] =
						['class' => 'yii\grid\ActionColumn',
											'template'    => '{update} {delete}',
											'buttons' => [
												'update' => function ($url, $model, $id) {
													return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
														['m3-urlaub-stunden/update', 'id'=>$id], [
															'title' => \Yii::t('yii', 'Update'),
															'data-pjax' => '0',
														]);
												},
												'delete' => function ($url, $model, $id) {
													return Html::a('<span class="glyphicon glyphicon-trash"></span>',
														['m3-urlaub-stunden/delete', 'id'=>$id], [
															'title' => \Yii::t('yii', 'Delete'),
															'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
															'data-method' => 'post',
															'data-pjax' => '0',
														]);
												},
											]


						]
					;

	$footer = Html::a('neues Jahr anlegen', ['m3-urlaub-stunden/create', 'id'=>$id], ['class'=>'btn btn-primary']);
}
else {
	$footer = '';
}
?>

<div class="personal-zusInfos">

		<?php if ($urlStdDataProvider->totalCount > 0): ?>
			<?= GridView::widget([
				'dataProvider' => $urlStdDataProvider,
				#'filterModel' => $urlStdSearchModel,
				'toolbar' => false,
				'summary' =>'',
				'panel' => [
					'heading'=>'<h3 class="panel-title">Überstunden- und Urlaubskonto</h3>',
					'type'=>'primary',
					'footer'=> $footer,

					#'footerOptions'=>['class'=>'panel-footer'],
					],
					'rowOptions'=>function($model){
			             if($model['JAHR'] == date('Y')){
			                 return ['class' => 'danger'];
			             }
			 					},
				'columns' => $gridColumns,
			]); ?>
		<?php else: ?>

			<div class="panel panel-primary">
				<div class="panel-heading">
					Kein Eintrag in der Urlaub- und Überstundendatenbank vorhanden
				</div>

			<?php if (Yii::$app->user->identity->role >= 20): ?>
				<div style="padding: 10px;">
					<?= Html::a('Eintrag erstellen', ['m3-urlaub-stunden/create', 'id'=>$id], ['class'=>'btn btn-primary']) ?>
				</div>
			<?php endif ?>

			</div>
	<?php endif ?>
</div>
