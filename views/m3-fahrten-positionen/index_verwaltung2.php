<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\user;

/* @var $this yii\web\View */
/* @var $searchModel app\models\M3FahrtenPositionenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Verwaltung Fahrten mit privaten PKW';
#$this->params['breadcrumbs'][] = $this->title;
?>

	<?php
		$gridcolumns = [
			['class' => 'yii\grid\SerialColumn'],
			[
				'attribute'=>'Typ',
				#'filter' => false,
				'value'=>function ($model) {
					if ($model->Typ == 0) {
						$ausgabe = '<i class="glyphicon glyphicon-retweet"></i>&nbsp;Umwegfahrten'.' '.
						Html::a('<span class="glyphicon glyphicon-export"></span>',
										['export'],
										[
											'type' => 'button',
											'class' => 'btn btn-primary',
											'title' => \Yii::t('yii', 'Exportieren und als erledigt speichern'),
											'data-confirm' => 'Soll die Liste exportiert und als erledigt gespeichert werden?',
										]
									);
						return $ausgabe;
					}
					else {
						$ausgabe = '<i class="glyphicon glyphicon-road"></i>&nbsp;Standardfahrten';
						return $ausgabe;
					}
				},
				'format' => 'raw',
				'group' => true,
				'groupedRow' => true,
				'groupOddCssClass' => 'bg-primary lead',
				'groupEvenCssClass' => 'bg-primary lead',
			],
			[
				'attribute'=>'username',
				'value'=> function($model){
					$user= User::findByUsername($model->username);
					if ($model->Typ == 1) {
						$ausgabe = $user['surename'].', '.$user['firstname'].'<br>'.
						Html::a('<span class="glyphicon glyphicon-file"></span>',
								['beleg', 'username'=>$model->username],
								[
									'type' => 'button',
									'class' => 'btn btn-default',
									'title' => \Yii::t('yii', 'Beleg erstellen und als erledigt speichern'),
									'data-confirm' => 'Soll der Beleg erstellt und als erledigt gespeichert werden?',
								]
							);
						return $ausgabe;
					}
					else {
						$ausgabe =$user['surename'].', '.$user['firstname'];
						return $ausgabe;
					}
				},
				'format' => 'raw',
				'group' => true,
				'subGroupOf'=>1,

			],
			[
				'attribute' => 'Fahrtdatum',
							'format' => 'datetime',
			],
			[
				'attribute' => 'von_Adresse1',
							'label'=>'von',
							'format' => 'html',
							'value'=>function ($model) {
								$adresse = $model->von_Adresse1.'<br>'.
											$model->von_Strasse.'<br>'.
											$model->von_PLZ.' '.$model->von_Ort;
								return $adresse;
							},

			],
			[
				'attribute' => 'nach_Adresse1',
							'label'=>'nach',
							'format' => 'html',
							'value'=>function ($model) {
								$adresse = $model->nach_Adresse1.'<br>'.
											$model->nach_Strasse.'<br>'.
											$model->nach_PLZ.' '.$model->nach_Ort;
								return $adresse;
							},

			],
			[
				'attribute' => 'Entfernung',
							'label'=>'Entf./ Vergütung',
							'format' => 'html',
							'value'=>function ($model) {
								if ($model->Typ == 1) {
									$enfernung = $model->Entfernung;
									$verguetung = Yii::$app->formatter->asCurrency($model->Verguetung);
									$ausgabe = $enfernung.' km / '.$verguetung;
									return $ausgabe;
								}
								else {
									$ausgabe = '- / €7,00';
									return $ausgabe;
								}
							},

			],
			[
				'attribute'=>'erstellt_von',
				'vAlign'=>'middle',
				'width'=>'180px',
				'value'=>function ($model, $key, $index, $widget) {
					return $model->user->firstname . ' ' . $model->user->surename ;
				},

			],
			['class' => 'yii\grid\ActionColumn'],


		];

		$defaultExportConfig = [
			GridView::EXCEL => [
					'label' => Yii::t('kvgrid', 'Excel'),
					#'icon' => $isFa ? 'file-excel-o' : 'floppy-remove',
					'iconOptions' => ['class' => 'text-success'],
					'showHeader' => true,
					'showPageSummary' => true,
					'showFooter' => true,
					'showCaption' => true,
					'filename' => Yii::t('kvgrid', 'grid-export'),
					'alertMsg' => Yii::t('kvgrid', 'The EXCEL export file will be generated for download.'),
					'options' => ['title' => Yii::t('kvgrid', 'Microsoft Excel 95+')],
					'mime' => 'application/vnd.ms-excel',
					'config' => [
							'worksheet' => Yii::t('kvgrid', 'ExportWorksheet'),
							'cssFile' => ''
					]
			],
			GridView::PDF => [
					'label' => Yii::t('kvgrid', 'PDF'),
					#'icon' => $isFa ? 'file-pdf-o' : 'floppy-disk',
					'iconOptions' => ['class' => 'text-danger'],
					'showConfirmAlert'=> false,
					'showHeader' => true,
					'showPageSummary' => true,
					'showFooter' => true,
					'showCaption' => true,
					'filename' => 'Fahrten_mit priv_PKW',
					'alertMsg' => 'PDF wird zum Herunterladen erstellt.',
					'options' => ['title' => 'Fahrten', 'Portable Document Format'],
					'mime' => 'application/pdf',
					'config' => [
							'mode' => 'c',
							'format' => 'A4-L',
							'destination' => 'D',
							'marginTop' => 20,
							'marginBottom' => 20,
							'cssInline' => '.kv-wrap{padding:20px;}' .
									'.kv-align-center{text-align:center;}' .
									'.kv-align-left{text-align:left;}' .
									'.kv-align-right{text-align:right;}' .
									'.kv-align-top{vertical-align:top!important;}' .
									'.kv-align-bottom{vertical-align:bottom!important;}' .
									'.kv-align-middle{vertical-align:middle!important;}' .
									'.kv-page-summary{border-top:4px double #ddd;font-weight: bold;}' .
									'.kv-table-footer{border-top:4px double #ddd;font-weight: bold;}' .
									'.kv-table-caption{font-size:1.5em;padding:8px;border:1px solid #ddd;border-bottom:none;}',
							/*'methods' => [
									'SetHeader' => [
											['odd' => $pdfHeader, 'even' => $pdfHeader]
									],
									'SetFooter' => [
											['odd' => $pdfFooter, 'even' => $pdfFooter]
									],
							],*/
							'options' => [
									#'title' => $title,
									'subject' => 'm3profile Fahrten mit privaten PKW',
									'keywords' => 'fahrten privat pkw',
							],
							'methods' => [
								'SetHeader' => ['m3profile GmbH|Fahrten mit priv. PKW|Stand: ' . Yii::$app->formatter->asDate(date('r'),'medium')],
								'SetFooter' => ['m3profile GmbH||Seite {PAGENO} von {nb}'],
							],
							'contentBefore'=>'',
							'contentAfter'=>''
					]
			],
		];

	?>
<div class="m3-fahrten-positionen-index">

		<div class="row" style="margin-top:20px;">
			<div class="col-md-12">
			  <p class="text-center"><h1><?= Html::encode($this->title )?></h1></p>
			</div>
			<div class="col-md-12">
				<?php
				$form = ActiveForm::begin([
					'method' => 'get',
					'type'=>ActiveForm::TYPE_INLINE,
					'action' => Url::to(['m3-fahrten-positionen/index-verwaltung']),
				]);

				echo Form::widget([
					'model'=>$searchModel,
					'form'=>$form,
					#'columns'=>1,
					'attributes'=>[
						'Typ'=>[
							'type'=>Form::INPUT_WIDGET,
							'widgetClass'=>'\kartik\widgets\Select2',
							'options'=>[
									'data'=>[ NULL=> 'Keine Auswahl',0=>'Umwegfahrten',1=>'Standardfahrten'],
									'hideSearch' => true,
									'options'=>['onchange' => 'this.form.submit()'],
									'pluginOptions'=>[
											'allowClear' => false,
										]
								],
							]
					]
				]);
				ActiveForm::end(); ?>
		 </div>
	 </div>

    <?php
			echo GridView::widget([
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			'floatHeader'=>true,
			'pjax'=>true,
			'columns' => $gridcolumns,
			'toolbar'=>[
					'{export}',
			],
			'exportConfig' => $defaultExportConfig,
			'panel' => [
				'heading'=>'<h3 class="panel-title">Fahrten mit priv. PKW</h3>',
				'type'=>'default',
				#'before' => false,
				'after' => false,
				#'footer'=>false,
				],
		]);

    ?>
</div>
