<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use app\models\user;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;



/* @var $this yii\web\View */
/* @var $model app\models\Todo */
/* @var $form yii\widgets\ActiveForm */

/* user für die die "Beauftragten-Auswahl"*/
$username_ar = user::find()
				->select(["[firstname] + ' '+ [surename] as surename"])
				->orderBy(['surename'=>SORT_ASC])
				->all();
$username_sys = ArrayHelper::map($username_ar, 'surename', 'surename');
$zusatz = [
  'Alle',
  'Schichtführer',
  'Frühschicht',
  'Nachtschicht',
  'Spätschicht',
  'Jede Schicht',
  'Technikum',
  'Technikum und Produktion'
];
foreach($zusatz as $zu){
  $zusatz_username[$zu] = $zu;
}
(in_array($env,['konstruktion','konstruktion_qv']))?$username = ['Fabian Braun'=>'Fabian Braun','Christian Ortner'=>'Christian Ortner']:$username =$zusatz_username + $username_sys;
#print_r($username); die;
?>

<div class="col-lg-6">

<div class="todo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textArea(['rows'=>2,'maxlength' => true]) ?>

    <?php if (in_array($env,['konstruktion','konstruktion_qv'])){
				echo	$form->field($model, 'department')->textInput(['readonly' => true,'value'=>'Konstruktion']);
				}
				else {
					echo	$form->field($model, 'department')->dropDownList(
				        [
				          'Produktion' => 'Produktion',
				          'Technikum' => 'Technikum',
				          'Konstruktion'=>'Konstruktion' ,
				        ],
				        ['style'=>'width:150px']);
				}
				?>

    <?=
        $form->field($model, 'beauftragter')->widget(Select2::classname(), [
          'data' => $username,
          'options' => ['placeholder' => 'Person auswählen ...'],
          'pluginOptions' => [
              'allowClear' => true,
          ],
        ]);

    ?>
    <!--<?= $form->field($model, 'beauftragter')->textInput(['maxlength' => true])->label('Aufgabe für (Beauftragter)') ?>-->

    <?= $form->field($model, 'due_date')
    ->widget(DatePicker::classname(),[
      'options' => ['placeholder' => ''],
      'language' => 'de',
      'type' => DatePicker::TYPE_COMPONENT_APPEND,
      'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'dd.mm.yyyy',
        'todayHighlight' => TRUE,
        'todayBtn' => true,
		]
  ]);

	?>
    <?= $form->field($model, 'zyklus')->radioList([NULL=>'kein Zyklus','woechentlich' => 'Wöchentlich', 'monatlich' => 'Monatlich', 'halbjaehrlich' => 'Halbjährlich', 'jaehrlich' => 'Jährlich'])->label(false) ?>
    <?= $form->field($model, 'prio')->radioList([NULL=>'keine Prio','1' => 'Prio 1', '2' => 'Prio 2', '3' => 'Prio 3'])->label(false) ?>
    <!--<?= $form->field($model, 'src')->fileInput() ?>-->



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Speichern' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>
<div class="col-lg-6"></div>
