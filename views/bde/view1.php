<?php
use yii\helpers\Html;
use kartik\editable\Editable;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\TouchSpin;
use kartik\widgets\ColorInput;
use kartik\widgets\RangeInput;
use kartik\widgets\SwitchInput;
use kartik\widgets\Spinner;
use kartik\widgets\FileInput;
use kartik\popover\PopoverX;
 

?>


<?php 
    $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_VERTICAL,
        'formConfig' => ['showErrors' => true]
    ]); 
    $data = [0 => 'Sun', 1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri', 6 => 'Sat'];
    $content = '<p class="text-justify">' .
    'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.' . 
    '</p>';
?>
    <?= $form->field($model, 'ORNO', [
    'addon' => [
        'append' => [
            'content' => 
                \yii\bootstrap\Button::widget([
                    'label'=>'Car', 
                    'options'=>['class'=>'btn btn-default']
                ]) . PHP_EOL .
                \yii\bootstrap\Button::widget([
                    'label'=>'Bus', 
                    'options'=>['class'=>'btn btn-default']
                ]) . PHP_EOL .
                \yii\bootstrap\ButtonDropdown::widget([
                    'label' => 'Air',
                    'dropdown' => [
                        'items' => [
                            ['label' => 'Another action', 'url' => '#'],
                            ['label' => 'Something else', 'url' => '#'],
                            '
',
                            ['label' => 'Separated link', 'url' => '#'],
                        ],
                    ],
                    'options' => ['class'=>'btn-default']
                ]),
            'asButton' => true
        ]
    ]
]); ?>
	
	<?= $form->field($model, 'ORNO')->radio(['options'=>['label'=>'yes']]) ?>
	 <?= $form->field($model, 'ORNO')->widget(TouchSpin::classname(), [
    'options' => ['placeholder' => 'Adjust ...'],
    'pluginOptions' => ['step' => 1,'verticalButtons' => true],
    
]);?>
	<div></div>
    <?= Html::submitButton('Login', ['class' => 'btn btn-primary']) ?>
    <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    <div></div>	
   
<?php ActiveForm::end(); ?>


 <?php
// usage without model
echo '<label>Check Issue Date</label>';
echo DatePicker::widget([
    'name' => 'check_issue_date', 
    'value' => date('d-M-Y', strtotime('+2 days')),
    'options' => ['placeholder' => 'Select issue date ...'],
    'pluginOptions' => [
        'format' => 'dd-M-yyyy',
        'todayHighlight' => true
    ]
]);
echo '<label class="control-label">Contrast</label>';
echo TouchSpin::widget([
    'name' => 'contrast',
    'options' => ['placeholder' => 'Adjust ...'],
]);
echo ColorInput::widget([
    'name' => 'color', 
    'options' => ['placeholder' => 'Select color...']
]);
echo RangeInput::widget([
    'name' => 'brightness',
    'html5Options' => ['min' => 0, 'max' => 100, 'step' => 1],
    'options' => ['placeholder' => 'Control brightness...'], 
    'addon' => ['append' => ['content' => '%']],
]);
echo SwitchInput::widget([
    'name' => 'activation_status',
    'pluginOptions' => ['size' => 'large']
]);
#echo Spinner::widget(['preset' => 'large', 'align' => 'left']);
echo FileInput::widget([
    'name' => 'attachments', 
    'options' => ['multiple' => true], 
    'pluginOptions' => ['previewFileType' => 'any']
]);
echo PopoverX::widget([
    'header' => 'Hello world',
    'placement' => PopoverX::ALIGN_RIGHT,
    'content' => $content,
    'footer' => Html::button('Submit', ['class'=>'btn btn-sm btn-primary']),
    'toggleButton' => ['label'=>'Right', 'class'=>'btn btn-default'],
]);

$form = ActiveForm::begin(['fieldConfig'=>['showLabels'=>false]]);
#$model->password = null;
PopoverX::begin([
    'placement' => PopoverX::ALIGN_TOP,
    'toggleButton' => ['label'=>'Auftrag', 'class'=>'btn btn-default'],
    'header' => '<i class="glyphicon glyphicon-pencil"></i> Enter Auftrag',
    'footer'=>Html::submitButton('Submit', ['class'=>'btn btn-sm btn-primary']) .
             Html::resetButton('Reset', ['class'=>'btn btn-sm btn-default'])
]);
echo $form->field($model, 'ORNO')->textInput(['placeholder'=>'Enter Auftrag...']);
PopoverX::end();
?>
<div></div>	
<?
echo '<label>Province</label><br>';
echo Editable::widget([
    'name'=>'province', 
    
    'header' => 'Province',
    'format' => Editable::FORMAT_BUTTON,
    'inputType' => Editable::INPUT_DROPDOWN_LIST,
    'data'=>$data, // any list of values
    'options' => ['class'=>'form-control', 'prompt'=>'Select province...','asPopover' => false,],
    'editableValueOptions'=>['class'=>'text-danger']
]);
ActiveForm::end();
?>
