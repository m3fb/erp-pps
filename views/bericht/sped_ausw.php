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


$this->title = 'Speditionsauftragsverwaltung';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="bde-index">
	
	<?php echo GridView::widget([
		'dataProvider'=> $dataProvider,
		#'filterModel' => $searchModel,
		'summary' =>'{begin} - {end} von {totalCount}',
		'toolbar' => false,
		'columns' => [
			[
				'attribute' => 'POSNO',
				'label' => 'Pos.',
			],
			[
				'attribute' => 'POSART',
				'label' => 'Art.Nr.',
				
			],
			[
				'attribute' => 'POSTXTL',
				'label' => 'Bezeichnung',
			],
			[
				'attribute' => 'COMMNO',
				'label' => 'Werkzeug',
				'group'=>true,
				'groupedRow'=>true,                    // move grouped column to a single grouped row
				'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
				'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
				'groupFooter'=>function ($model, $key, $index, $widget) { // Closure method
					return [
						'mergeColumns'=>[[0,5]], // columns to merge in summary
						'content'=>[             // content to show in each summary cell
							0=>'Anteil '.$model['COMMNO'].' in %',
							#4=>GridView::F_AVG,
							#5=>GridView::F_SUM,
							6=>GridView::F_SUM,
                    ],
						'contentFormats'=>[      // content reformatting for each summary cell
							#4=>['format'=>'number', 'decimals'=>2],
							#5=>['format'=>'number', 'decimals'=>0],
							6=>['format'=>'number', 'decimals'=>2 ,'decPoint'=>',', 'thousandSep'=>' '],
                    ],
						'contentOptions'=>[      // content html attributes for each summary cell
							0=>['style'=>'text-align:right; font-style:normal; font-weight:bold;'],
							6=>['style'=>'text-align:right; font-style:normal; font-weight:bold;'],
						],
                   ];
                 }  
			],
			[
				'attribute' => 'MENGE',
				'label' => 'Menge',
				'format' => ['decimal',2],
				'contentOptions'=>['style'=>'text-align: right;'],
			],
			[
				'attribute' => 'GPREIS',
				'label' => 'Gesamtpreis €',
				'format' => ['decimal',2],
				'contentOptions'=>['style'=>'text-align: right;'],
			],
			[
				'attribute' => 'GPREIS',
				'label' => 'Anteil in %',
				'value' => function($model) use ($sumgpreis){
					($sumgpreis >0 and $model['GPREIS'] > 0)?
					$anteil = 100 / $sumgpreis * $model['GPREIS']:
					$anteil=0;
					return $anteil;
				},
				'format' => ['decimal',2],
				'contentOptions'=>['style'=>'text-align: right;'],
			],
						
		],
		 'panel' => [
			'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-road"></i>&nbsp; Sepditionsauftrag '.$vorgangsnr.'</h3>',
			/*'heading'=>function ($url, $model, $id)   {
							  return $vorgangsnr;					
					  },*/
			'type'=>'primary',
			'footer'=> false,
			#'footerOptions'=>['class'=>'panel-footer'],
			],
		'responsive'=>true,
		'hover'=>true,
	]);
?>
</div>

<div>
    <?php 
        $form = ActiveForm::begin([
            'id' => 'sped-quit', 
            'type' => ActiveForm::TYPE_INLINE,
            'method' => 'get',
            'action' => Url::to(['bericht/belegquit' ,'id'=>$id]),
        ]); 
    ?>

         
        <?= Html::submitButton('Ausbuchen', ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end(); ?>
    


   

</div>

