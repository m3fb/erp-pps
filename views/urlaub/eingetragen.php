<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\assets\AppAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use kartik\widgets\DatePicker;
use kartik\widgets\DateControl;
use kartik\daterange\DateRangePicker;


/* @var $this yii\web\View */
$this->title = 'Urlaubsplaner';
$this->params['breadcrumbs'][] = $this->title;


AppAsset::register($this);


?>
<label>Name</label>: <?= Html::encode($model->name) ?>
<label>PNR</label>: <?= Html::encode($model->pnr) ?> 
<label>Start</label>: <?= Html::encode($model->start) ?>

		
<div class="site-urlaub">
	<br>
	<link rel="stylesheet" href="css/test.css">
	<?php $form = ActiveForm::begin(['id' => 'urlaub-form',
			'layout' => 'horizontal',
			'method' => 'get',
			'action' => ['']
			]); ?>
	<?= $form->field($model, 'pnr')->textInput()->label('PNR:') ?>
	<?= $form->field($model, 'test')->textInput()->label('Test:') ?>		
	<?php   
    // echo '<div class="well well-sm" style="background-color: #fff; width:245px">';
    // echo DatePicker::widget([
        // 'name' => 'dp_5',
        // 'type' => DatePicker::TYPE_INLINE,
        // 'value' => 'Tue, 23-Feb-1982',
        // 'pluginOptions' => [
            // 'format' => 'D, dd-M-yyyy'
        // ],
        // 'options' => [
            // // you can hide the input by setting the following
            // // 'class' => 'hide'
        // ]
    // ]); 
	
	Yii::$app->getRequest()->getQueryParam('Urlaub',NULL);


	
    echo '</div>';	
	echo '<label class="control-label">Valid Dates</label>';
    echo DatePicker::widget([
        'name' => 'start',
        'value' => '23-Mar-2017',
        'type' => DatePicker::TYPE_RANGE,
        'name2' => 'ende',
        'value2' => '01-May-2017',
        'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'dd-M-yyyy'
        ]
		]);
	?>
	
	<?= Html::submitButton('Bestätigen', ['class'=> 'btn btn-primary']) ;?>
    <?php ActiveForm::end(); ?>
			


	<!-- echo Yii::$app->user->identity->username; 
	<h1><?= Html::encode($this->title) ?></h1> -->
	
	
	<br>
    <code><?= __FILE__ ?></code>
</div>
