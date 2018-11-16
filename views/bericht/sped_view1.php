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
				'attribute' => 'MENGE',
				'label' => 'Menge',
				'format' => ['decimal',2],
				'contentOptions'=>['style'=>'text-align: right;'],
			],
			
		],
		 'panel' => [
			'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i>&nbsp; Sepditionsauftrag '.$vorgangsnr.'</h3>',
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
            'id' => 'sped-kosten', 
            'type' => ActiveForm::TYPE_INLINE,
            'method' => 'get',
            'action' => Url::to(['bericht/spedauswert']),
        ]); 
    ?>
         <?= $form->field($searchModel, 'id')->hiddenInput(['value'=> $id, 'name'=>'id']) ?>
         <?= $form->field($searchModel, 'Speditionskosten')->textInput([ 'id' => $id, 'name'=>'Speditionskosten']) ?>
        <?= Html::submitButton('Auswerten', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>
    


   

</div>

