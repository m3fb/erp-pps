<?php
// # View für die Monatsdarstellung der Abrechnungstabelle private Fahrten.
use yii\helpers\Html;
use \yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use kartik\export\ExportMenu;
use yii\helpers\Url;
use app\models\user;

/* @var $this yii\web\View */
/* @var $searchModel app\models\M3FahrtenPositionenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Verwaltung Fahrten mit privaten PKW';
#$this->params['breadcrumbs'][] = $this->title;
?>

	<?php


	$gridcolumnsUmweg = [
			['class' => 'yii\grid\SerialColumn'],
			[
				'attribute'=>'username',
				'label' => 'Name, Vorname',
				'enableSorting' => false,
				'value'=> function($model){
					$user= User::findByUsername($model->username);
					$ausgabe =$user['surename'].', '.$user['firstname'];
					return $ausgabe;
				},
				'format' => 'html',
				'group' => true,
				'groupedRow'=>true,
				'groupOddCssClass' => 'bg-default lead',
				'groupEvenCssClass' => 'bg-default lead',
				'groupHeader'=>function ($model, $key, $index, $widget) { // Closure method
								return [
                    #'mergeColumns'=>[[4,5]], // columns to merge in summary
                    'content'=>[             // content to show in each summary cell
                        0=>' ',
                    ],
                    'contentFormats'=>[
                    ],
                    'contentOptions'=>[      // content html attributes for each summary cell
                        0=>['style'=>' text-align:left;'],
                    ],
                    // html attributes for group summary row
                    'options'=>['style'=>'background-color:#c3c3c3;']
                ];
            },
				'groupFooter'=>function ($model, $key, $index, $widget) { // Closure method
						$user= User::findByUsername($model->username);
						return [
								#'mergeColumns'=>[[2,4]], // columns to merge in summary
								'content'=>[             // content to show in each summary cell
										2=>'Summe (' . $user['surename'].', '.$user['firstname'] . ')',
										5=>GridView::F_SUM,
								],
								'contentFormats'=>[      // content reformatting for each summary cell
										5=>['format'=>'number', 'decimals'=>2, 'decPoint'=>',', 'thousandSep'=>'.'],
								],
								'contentOptions'=>[      // content html attributes for each summary cell
										2=>['style'=>'font-variant:small-caps'],
										5=>['style'=>'text-align:right'],
								],
								// html attributes for group summary row
								'options'=>['class'=>'default','style'=>'font-weight:bold;']
						];
				}
			],
			[
				'attribute' => 'Fahrtdatum',
							'format' => 'datetime',
							'enableSorting' => false,
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
							'enableSorting' => false,

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
							'enableSorting' => false,

			],
			[
				'attribute' => 'Verguetung',
							'label'=>'Vergütung [EUR]',
							'format' => 'decimal',
							'hAlign' => 'right',
							'value'=>function (){
								return 7;
							},
							'enableSorting' => false,
			],
			[
				'attribute'=>'erstellt_von',
				'value'=>function ($model, $key, $index, $widget) {
					return $model->user->firstname . ' ' . $model->user->surename ;
				},
				'hAlign' => 'right',
				'contentOptions'=> ['class'=>'skip-export-pdf'],
				'headerOptions'=> ['class'=>'skip-export-pdf'],
				'enableSorting' => false,
			],
		];




	$defaultExportConfig = [

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
									'SetHeader' => ['m3profile GmbH|Umwegfahrten mit priv. PKW: '.$FahrtdatumMonat.'-'.$FahrtdatumJahr. '|Stand: ' . Yii::$app->formatter->asDate(date('d.M.Y'))],
									'SetFooter' => ['m3profile GmbH / '.Yii::$app->user->identity->firstname.' '.Yii::$app->user->identity->surename.'||Seite {PAGENO} von {nb}'],
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
	 </div>


    <?php
		 $form = ActiveForm::begin([
					'id'=> 'umweg_opt',
					'method' => 'get',
					'type' => ActiveForm::TYPE_HORIZONTAL,
					'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL],
					'options' => ['class' => 'form-horizontal'],
					'action' => Url::to(['m3-fahrten-positionen/umweg-bearbeiten']),
				]);	?>

		<div class="form-group kv-fieldset-inline" style="margin-bottom:10px;">

			<div class="col-lg-2">
					<?= Select2::widget([
							'name' => 'FahrtdatumMonat',
							'value' => $FahrtdatumMonat, // initial value
							'data' => getMonthsList(),
							'options' => ['placeholder' => 'Monat wählen ...','onchange' => 'this.form.submit()'],
							'pluginOptions' => [
								'allowClear' => true
							],
						]);?>
			</div>
			<div class="col-lg-2">
					<?= Select2::widget([
							'name' => 'FahrtdatumJahr',
							'value' => $FahrtdatumJahr, // initial value
							'data' => ArrayHelper::map($jahresliste,'jahreswert','jahreswert'),//['2018'=>2018,'2017'=>2017],
							'hideSearch'=> true,
							'options' => ['placeholder' => 'Jahr wählen ...','onchange' => 'this.form.submit()'],
						]);?>
			</div>
		</div>



				<?php ActiveForm::end();
			echo GridView::widget([
				'dataProvider' => $dataProviderUmweg,
				#'filterModel' => $searchModelUmweg,
				'floatHeader'=>true,
				'pjax'=>true,
				'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
				'summary' =>'',
				'toggleData' => false,
				'columns' => $gridcolumnsUmweg,
				'exportConfig' => $defaultExportConfig,
				'toolbar'=>[
						'{export}',
						[
							'content'=>
								Html::a('<span class="glyphicon glyphicon-check"></span>',
											['umweg-erledigt','FahrtdatumMonat'=>$FahrtdatumMonat,'FahrtdatumJahr'=>$FahrtdatumJahr],
											[
												'type' => 'button',
												'class' => 'btn btn-default',
												'title' => \Yii::t('yii', 'Liste als erledigt speichern'),
												'data-confirm' => 'Soll die Liste als erledigt gespeichert werden?',
											]
										),
						]
				],

				'panel' => [
					'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-retweet"></i> Umwegfahrten mit priv. PKW </h3>',
					'panelHeadingTemplate' => '{items}\n{pager}',
					'type'=>'primary',
					#'before' => false,
					'after' => false,
					'footer'=>false,
					],
			]);

    ?>
</div>
