<?php

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

	$gridcolumnsStandard = [
			['class' => 'yii\grid\SerialColumn'],
			[
				'attribute'=>'username',
				'label' => 'Name, Vorname',
				'value'=> function($model){
					$user= User::findByUsername($model->username);
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
				},
				'format' => 'raw',
				'group' => true,
				'enableSorting' => false,
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
				'attribute' => 'Entfernung',
							'label'=>'Entfernung/ Vergütung',
							'format' => 'html',
							'value'=>function ($model) {
								$enfernung = $model->Entfernung;
								$verguetung = Yii::$app->formatter->asCurrency($model->Verguetung);
								$ausgabe = $enfernung.' km / '.$verguetung;
								return $ausgabe;
							},
							'enableSorting' => false,
			],
			[
				'attribute'=>'erstellt_von',
				'hAlign' => 'right',
				'value'=>function ($model, $key, $index, $widget) {
					return $model->user->firstname . ' ' . $model->user->surename ;
				},
				'enableSorting' => false,
			],
			['class' => 'yii\grid\ActionColumn',
								'template'    => '{update} {finish} {delete}',
								'buttons' => [
									'update' => function ($url, $model, $id) {
										return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
											$url, [
												'title' => \Yii::t('yii', 'update'),
												'data-pjax' => '0',
											]);
									},
									'finish' => function ($url, $model, $id) {
										return Html::a('<span class="glyphicon glyphicon-check"></span>',
											$url, [
												'title' => \Yii::t('yii', 'finish'),
												'data-pjax' => '0',
											]);
									},
									'delete' => function ($url, $model, $id) {
										return Html::a('<span class="glyphicon glyphicon-trash"></span>',
												$url, [
												'title' => \Yii::t('yii', 'Delete'),
												'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
												'data-method' => 'post',
												'data-pjax' => '0',
													]);
											},
								]

			],
		];

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
			[
				'class' => 'yii\grid\ActionColumn',
				'template'    => '{update} {delete}',
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
			echo GridView::widget([
				'dataProvider' => $dataProviderStandard,
				#'filterModel' => $searchModelStandard,
				#'floatHeader'=>true,
				'pjax'=>true,
				'summary' =>'',
				'toggleData' => false,
				'columns' => $gridcolumnsStandard,
				'panel' => [
					'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-road"></i> Fahrten mit priv. PKW</h3>',
					'type'=>'primary',
					'before' => false,
					'after' => false,
					'footer'=>false,
					],
			]);


			echo GridView::widget([
				'dataProvider' => $dataProviderUmweg,
				#'filterModel' => $searchModelUmweg,
				#'floatHeader'=>true,
				'pjax'=>true,
				'summary' =>'',
				'toggleData' => false,
				'columns' => $gridcolumnsUmweg,
				#'exportConfig' => $defaultExportConfig,
				'toolbar'=>[

				],

				'panel' => [
					'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-retweet"></i> Umwegfahrten mit priv. PKW &nbsp; '.
										Html::a('<span class="glyphicon glyphicon-export"></span>',
										['umweg-bearbeiten','FahrtdatumMonat'=>date('n'),'FahrtdatumJahr'=>date('Y')],
										[
											'class'=>'btn btn-danger',
											'title' =>'Liste Expotieren',
											]).
										'</h3>',
					'panelHeadingTemplate' => '{items}\n{pager}',
					'type'=>'primary',
					#'before' => false,
					'after' => false,
					'footer'=>false,
					],
			]);

    ?>

</div>
