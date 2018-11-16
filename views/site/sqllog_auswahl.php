<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\datetime\DateTimePicker;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

$this->title = 'Sql Logs Datumsauswahl';
#$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact" style="padding:0px 10px;">
    <h3><?= Html::encode($this->title) ?></h3>



    <?php $form = ActiveForm::begin([
    			'id'=> 'sqllog_opt',
    			'method' => 'get',
    			'type' => ActiveForm::TYPE_HORIZONTAL,
    			'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL],
    			'options' => ['class' => 'form-horizontal'],
    			'action' => Url::to(['site/sqllog']),
    		]);	?>

    	<div class="form-group kv-fieldset-inline">
    		<div class="col-lg-3">
    		<!--<label class="control-label">Birth Date</label>-->
    			<?= DateTimePicker::widget([
              'name' => 'dateTime',
              'options' => ['placeholder' => 'Select operating time ...'],
              'convertFormat' => true,
              'options' => ['onchange' => 'this.form.submit()'],
              'pluginOptions' => [
                  'format' => 'dd.MM.yyyy H:i:s',
                  'startDate' => '01.07.2018 12:00:00',
                  'todayHighlight' => true
              ]
          ]);?>
    		</div>


    		<?php ActiveForm::end(); ?>

    	</div>


</div>
