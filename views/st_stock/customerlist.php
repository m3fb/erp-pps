<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\St_stock;

($cu_cntrysign!='D')?\Yii::$app->language = 'en-US':'';

/* @var $this yii\web\View */
/* @var $searchModel app\models\St_stockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lagerübersicht';
?>
<?php $form = ActiveForm::begin([
			'id'=> 'sustomerlist_opt',
			'method' => 'get',
			'type' => ActiveForm::TYPE_HORIZONTAL,
			'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL],
			'options' => ['class' => 'form-horizontal'],
			'action' => Url::to(['st_stock/customer-list']),
		]);	?>

	<div class="form-group kv-fieldset-inline">
    <div class="row">
      <div class="col-lg-3">
  		<?= Select2::widget([
  				'name' => 'cu_no',
  				'value' => $cu_no, // initial value
  				'data' => ArrayHelper::map($cu_list,'CONO','CUSTNAME'),
  				'options' => ['placeholder' => 'Kunde auswählen ...','onchange' => 'this.form.submit()'],
  				'pluginOptions' => [
  					'allowClear' => false
  				],
  			 ]);?>
  		</div>
    </div>
</div>
		<?php ActiveForm::end(); ?>
<?php
$gridColumns=[
  ['class'=>'kartik\grid\SerialColumn'],
  [
    'attribute'=>'VAL02',
    'label' => Yii::t('app','Variant'),
    'value'=>function ($model, $key, $index, $widget) {
				($model['VAL02']>0)?$ausgabe= Yii::t('app','Variant').': '.YII::$app->formatter->asInteger($model['VAL02']):$ausgabe='-';
				return $ausgabe;
    },
    'group'=>true,  // enable grouping,
    'groupedRow'=>true,                    // move grouped column to a single grouped row
		'groupOddCssClass' => function ($model, $key, $index, $widget) {
				$model['VAL02']>0 ? $class='danger h3':$class='default';
				return $class;
		},
		'groupEvenCssClass' => function ($model, $key, $index, $widget) {
				$model['VAL02']>0 ? $class='danger h3':$class='default';
				return $class;
		},
		'groupHeader'=>function ($model, $key, $index, $widget) { // Closure method
			return [
						'mergeColumns'=>[[0,13]], // columns to merge in summary
						'content'=>[             // content to show in each summary cell
							0=>'',
						],
						'contentFormats'=>[      // content reformatting for each summary cell

						],
						'contentOptions'=>[      // content html attributes for each summary cell
							0=>['style'=>' text-align:left;'],
						],
						// html attributes for group summary row
						'options'=>['style'=>'background-color:red;']
					];
		}

  ],
  [
    'attribute'=>'ARTDESC',
    'label' => Yii::t('app','Artikel / Bezeichnung'),
    'width'=>'250px',
		'format' =>'html',
    'value'=>function ($model, $key, $index, $widget) {
        return $model['ARTDESC'].' / '.$model['ARTNAME'];
    },
    'group'=>true,  // enable grouping
    'groupedRow'=>true,
    'subGroupOf'=>1, // supplier column index is the parent group,
		'groupOddCssClass' => 'success lead',
		'groupEvenCssClass' => 'success lead',
    'groupFooter'=>function ($model, $key, $index, $widget) { // Closure method
        return [
            'mergeColumns'=>[[3, 5]], // columns to merge in summary
            'content'=>[              // content to show in each summary cell
                3=>Yii::t('app','Sum').' ('.$model['ARTDESC'].' / '.$model['PARTNO'].' ):',
                #4=>GridView::F_AVG,
                6=>GridView::F_SUM,
                7=>GridView::F_SUM,
                9=>GridView::F_SUM,
                10=>Yii::$app->formatter->asDecimal($model['ALAGER2']),
                11=>Yii::$app->formatter->asDecimal($model['length'] / 1000 * $model['ALAGER2']),
								12=>Yii::$app->formatter->asDecimal($model['ALAGER3'] - $model['ALAGER2']),
								13=>Yii::$app->formatter->asDecimal($model['length'] / 1000 * ($model['ALAGER3'] - $model['ALAGER2'])),
            ],
            'contentFormats'=>[      // content reformatting for each summary cell
                6=>['format'=>'number', 'decimals'=>2,'decPoint'=>',', 'thousandSep'=>'.'],
                7=>['format'=>'number', 'decimals'=>0],
								9=>['format'=>'number', 'decimals'=>2,'decPoint'=>',', 'thousandSep'=>'.'],
            ],
            'contentOptions'=>[      // content html attributes for each summary cell
								3=>['class'=>'strong'],
								6=>['style'=>'text-align:right'],
                7=>['style'=>'text-align:right'],
                9=>['class'=>'text-right'],
                10=>['style'=>'text-align:right'],
                11=>['style'=>'text-align:right'],
								12=>['style'=>'text-align:right'],
								13=>['style'=>'text-align:right'],
            ],
            // html attributes for group summary row
            'options'=>['class'=>'success', 'style'=>'font-weight:bold;']
        ];
    },
		'groupHeader'=>function ($model, $key, $index, $widget) { // Closure method
			return [
						'mergeColumns'=>[[0,14]], // columns to merge in summary
						'content'=>[             // content to show in each summary cell
							0=>'',
						],
						'contentFormats'=>[      // content reformatting for each summary cell

						],
						'contentOptions'=>[      // content html attributes for each summary cell
							0=>['style'=>' text-align:left;'],
						],
						// html attributes for group summary row
						'options'=>['style'=>'background-color:green;']
					];
		}

  ],
  [
    'attribute'=>'INFO1',
    'label' => 'Pal. ID',
		'contentOptions' => ['style'=>'text-align:right'],
		'width' => '80px',
  ],
  [
    'attribute' =>'MSTIME',
    'label' => Yii::t('app','Prod. Date'),
    'format' => 'date',
		'contentOptions' => ['style'=>'text-align:right'],
		'width' => '100px',
		'pageSummary'=>Yii::t('app','Stock amount'),
		'pageSummaryOptions'=>['class'=>'text-right text-default'],
  ],
  [
    'attribute' =>'MSTIME',
    'label' => Yii::t('app','S.t. [w]'),
		'width' => '50px',
		'contentOptions' => function($model){
      $i = dateDiffInWeeks(Yii::$app->formatter->asDate($model['MSTIME']), date('Y-m-d'));
			$maxLagerZeit = St_stock::maxLagerzeit($model['ARTDESC']);
      ($maxLagerZeit>0 && $i>$maxLagerZeit) ? $ausgabe = ['style'=>'text-align:right; color:red;'] : $ausgabe = ['style'=>'text-align:right;'];
      return $ausgabe;
		},
		#['style'=>'text-align:right; color:red;'],
    'value' => function($model){
      $i = dateDiffInWeeks(Yii::$app->formatter->asDate($model['MSTIME']), date('Y-m-d'));
      //($i>1) ? $ausgabe = $i : $ausgabe = '';
      return $i;
    },
  ],
  [
    'attribute'=>'MENGE',
		'label' => Yii::t('app','Quantity'),
    'format' => 'decimal',
		'width' => '100px',
		'contentOptions' => ['style'=>'text-align:right'],
  ],
  [
    'attribute' =>'FILLQUANTITY',
    'label' => 'Pal.',
		'width' => '50px',
    'value' => function($model){
      return ($model['FILLQUANTITY']>0) ? round($model['MENGE']/$model['FILLQUANTITY']) : NULL;
    },
    'format' => 'integer',
		'contentOptions' => ['style'=>'text-align:right'],
		'pageSummary'=>true,
		'pageSummaryOptions'=>['class'=>'text-right'],
  ],
  [
    'attribute' =>'division',
    'label' => false,
    'width' => '5px',
    'contentOptions' => ['style' => 'background-color:white; border:0px;'],
  ],
  [
    'attribute'=>'MENGE',
    'label' => ' [m]',
		'format' => 'decimal',
		'width' => '100px',
    'value' => function($model){
			return $model['length'] / 1000 * $model['MENGE'];
		},
		'contentOptions' => ['class'=>'text-right'],
		'pageSummary'=>true,
		'pageSummaryOptions'=>['class'=>'text-right'],
    #'group'=>true,
    #'subGroupOf'=>2,
  ],
  [
    'attribute' =>'ALAGER2',
    'label' => Yii::t('app','res. Qty.'),
    'value' => '',
    'group'=>true,
    'subGroupOf'=>2,
  ],
  [
    'attribute'=>'MENGE1',
    'label' => ' [m]',
    'value' => '',
    'group'=>true,
    'subGroupOf'=>2,
  ],
  [
    #'attribute' =>'freierBestand',
    'label' => Yii::t('app','free Qty.'),
    'value' => '',
		'group'=>true,
    'subGroupOf'=>2,
  ],
  [
    'attribute'=>'MENGE2',
    'label' => ' [m]',
    'value' => '',
		'group'=>true,
    'subGroupOf'=>2,
  ],
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
			'filename' => Yii::t('app', 'Stockoverview_').date('Y_m_d'),
			'alertMsg' => 'PDF wird zum Herunterladen erstellt.',
			'options' => ['title' => Yii::t('app', 'stock overview'), 'Portable Document Format'],
			'mime' => 'application/pdf',
			'config' => [
					'mode' => 'c',
					'format' => 'A4-P',
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
							'subject' => 'm3profile Bestandsuebersicht',
							'keywords' => 'Bestandsuebersicht',
					],
					'methods' => [
						'SetHeader' => ['m3profile GmbH|'.Yii::t('app', 'stock overview').'|'.Yii::t('app', 'State').': ' . Yii::$app->formatter->asDate(date('d.M.Y'))],
						'SetFooter' => ['m3profile GmbH / '.Yii::$app->user->identity->firstname.' '.Yii::$app->user->identity->surename.'||'.Yii::t('app', 'Page').' {PAGENO} / {nb}'],
					],
					'contentBefore'=>'',
					'contentAfter'=>''
			]
	],
];
  ?>

<div class="st-stock-customerlist">
  <div class="row" style="margin-top:15px;">
    <?php
      echo GridView::widget([
            'dataProvider' => $dataProvider,
						'showPageSummary'=>true,
						'summary' =>'',
            'pjax'=>true,
            'striped'=>false,
            'hover'=>true,
						'responsive'=> true,
						'options' => ['style'=>'font-size:12px;'],
						'toolbar'=>[
								'{export}',
						],
						'exportConfig' => $defaultExportConfig,
            //'filterModel' =>$searchModel,
            'panel' => [
                'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i>' .' '. Html::encode($this->title) . ' für '.$cu_name.'</h3>',
                'type'=>'primary',
								#'before' => false,
								'after' => false,
								'footer'=>false,
                #'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Create Country', ['create'], ['class' => 'btn btn-success']),
                #'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset', ['index'], ['class' => 'btn btn-info']),
            ],
            'columns' => $gridColumns,
						'headerRowOptions' => ['class'=>'bg-primary'],
						'floatHeader'=>true,
    				'floatHeaderOptions'=>['top'=>'60'],
        ]);
    ?>
  </div>
</div>
