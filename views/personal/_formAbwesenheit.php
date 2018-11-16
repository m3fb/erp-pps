<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use kartik\number\NumberControl;

$this->registerJsFile("@web/js/urlaub_stunden.js",
						['depends' => [\yii\web\JqueryAsset::className()]]
						);


/* @var $this yii\web\View */
/* @var $model app\models\Personal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="abwesenheit-form">

    <?php $form = ActiveForm::begin(); ?>
  <div class="row">
    <div class="col-md-3">
      <?=
          $form->field($model, 'WORKID')->widget(Select2::classname(), [
                  'data' => ArrayHelper::map($aktivesPersonal,'NO','NAME'),
                  'value' => $workid,
                  'options' => ['placeholder' => 'Person auswählen ...'],
                  'pluginOptions' => [
                      'allowClear' => true,
                  ],
                ])
                ->label('Name');
          ?>
    <?=
      $form->field($model, 'MSTIME')
            ->widget(
                         DatePicker::className(),
                         [
                            'options'=> ['id'=>'DP_Startdatum'],
                             'pluginOptions' => [
                     							'autoclose'=>true,
                     							'todayBtn'=>true,
                     							'format' => 'dd.mm.yyyy',
                     							'language' => 'de',
                                             ]
                                         ]
                                     )
            ->label('Startdatum');
      ?>
      <?=
        $form->field($model, 'MSTIME2')
              ->widget(
                           DatePicker::className(),
                           [
                              'options'=> ['id'=>'DP_Enddatum'],
                               'pluginOptions' => [
                     							'autoclose'=>true,
                     							'todayBtn'=>true,
                     							'format' => 'dd.mm.yyyy',
                     							'language' => 'de',
                                             ]
                                         ]
                                     )
              ->label('Enddatum');
        ?>


      </div>
    </div>
    <div class="row">
      <div class="col-md-8">
      <?=
        $form->field($model, 'STATUS')->radioList([
                  800=>'Urlaub', 802=>'Krank',804=>'Elternzeit',806=>'unbezahlter Urlaub', 808=>'Berufsschule'
                ])
            ->label('Status');

    ?>
      </div>
    </div>
    <div class="row col-md-12" id="urlaubstage" style="display:none">
      <div class="col-md-12">
          <div class="col-md-3">
            <?=
              $form->field($model, 'GESAMT_TAGE')
                    ->textInput(['readonly' => true])
                    #->widget(NumberControl::classname())
                    ->label('Benötigte Tage');
              ?>
            </div>
      </div>
      <div class="col-md-12">
          <div class="col-md-3">
            <?=
              $form->field($model, 'TAGE')
                    #->widget(NumberControl::classname())
                    ->textInput(['readonly' => true])
                    ->label('Urlaubstage');
              ?>
            </div>
          <div class="col-md-3">
              <?=
              $form->field($model, 'STUNDEN')
                    ->widget(NumberControl::classname())
                    ->label('Überstunden');
              ?>
          </div>
      </div>
    </div>

  <div class="row">
    <div class="form-group pull-left">
        <?= Html::submitButton($model->isNewRecord ? 'Speichern' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
  </div>
</div>
