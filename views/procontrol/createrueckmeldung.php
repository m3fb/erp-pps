<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\spinner\Spinner;
use kartik\dialog\Dialog;

// widget with default options
echo Dialog::widget(['overrideYiiConfirm' => true]);

/* @var $this yii\web\View */
/* @var $model app\models\Todo */
/* @var $form yii\widgets\ActiveForm */

 $this->registerJsFile(
    '@web/js/numpad.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
 $this->registerJsFile(
    '@web/js/createrueckmeldung.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

?>

<link rel="stylesheet" href="../web/css/numpad.css">


<?php $form = ActiveForm::begin(); ?>
<div class="col-lg-4">
  <div class="col-lg-12">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title">R&uuml;ckmeldung f&uuml;r:</h3>
      </div>
      <div class="panel-body">
        <table class="table table-bordered">
          <tr>
            <td class="success"><strong>Maschine</strong></td>
            <td><?= HTML::encode($maschine->NAME); ?></td>
          </tr>
          <tr>
            <td class="success"><strong>Auftrag</strong></td>
            <td><?= $form->field($model, 'Auftrag')->textInput(['readonly' => true,])->label(false) ?></td>
          </tr>
          <tr>
            <td class="success"><strong>Arbeitsgang</strong></td>
            <td><?= HTML::encode($model->Arbeitsgang); ?></td>
          </tr>
          <tr>
            <td class="success"><strong>Artikelnr.</strong></td>
            <td><?= HTML::encode($PN); ?></td>
          </tr>
          <tr>
            <td class="success"><strong>Bezeichnung</strong></td>
            <td><?= HTML::encode($BZ); ?></td>
          </tr>
        </table>
        <?= $form->field($model, 'Stueckzahl')->textInput(['maxlength' => true,'class'=>'form-control input-lg'])->label('Stückzahl',['class'=>'bg-danger']) ?>
          <div id="buttons_links" style="display:block;">
            <div class="clearfix" style="margin-top:25px;">
              <?= Html::submitButton('<span class="glyphicon glyphicon-play"></span> Rückmeld. und weiterprod.',
                ['title'=>'Speichern und weiter','name' => 'button_continue','class' => 'btn btn-success myButton']); ?>
            </div>
            <div class="clearfix" style="margin-top:25px;">
              <?= Html::submitButton('<span class="glyphicon glyphicon-pause"></span> Rückmeld. und AG unterbrechen',
                ['title'=>'Speichern und AG unterbrechen','name' => 'button_pause','class' => 'btn btn-warning myButton']); ?>
            </div>
            <div class="clearfix" style="margin-top:25px;">
              <?= Html::submitButton('<span class="glyphicon glyphicon-stop"></span> Rückmeld. und AG beenden',
              [
                'title'=>'Speichern und AG beenden',
                'name' => 'button_end',
                'class' => 'btn btn-danger myButton',
                'data-confirm' => Yii::t('yii', 'Der Arbeitsgang wird beendet und erscheint danach nicht mehr in der Auftragsliste!'),
                'data-method' => 'post',
                'data-pjax' => '0',
              ]); ?>
            </div>
          </div>
          <div id="spinner_links" style="margin:50px; display:none;">
            <?= Spinner::widget(['preset' => 'large', 'align' => 'left']); ?>
          	<div class="clearfix"></div>
          </div>
      </div>
    </div>
  </div>
  <div class="col-lg-12" id="rueckmelden_abrechen" style="margin-left:-15px !important; margin-top:25px;">
    <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Abbrechen' , ['procontrol/auswahl', 'linie'=>$maschine->NO], ['class' => 'btn btn-primary']) ?>
  </div>
</div>
<div class="col-lg-4">
  <div class="col-lg-12">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title">Benutzerinformationen</h3>
      </div>
      <div class="panel-body">
        <?= Yii::$app->session->getFlash('msg') ?>
        <table class="table table-bordered">
          <tr>
            <td class="success"><strong>Name</strong></td>
            <td><?= $form->field($model, 'name')->textInput(['readonly' => true,])->label(false) ?></td>
          </tr>
          <tr>
            <td class="success"><strong>Personalnr.</strong></td>
            <td><?= $form->field($model, 'persno')->textInput(['readonly' => true,])->label(false) ?></td>
          </tr>

        </table>
      </div>
    </div>
  </div>
  <div class="col-lg-12">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title">Auftragstatus &auml;ndern</h3>
      </div>
      <div class="panel-body">
        <div class="col-lg-6" style="margin-left:-15px !important; margin-top:0px;">
          <div id="buttons_rechts" style="display:block;">
            <div class="clearfix" style="margin-top:25px;">
                <?= Html::submitButton('<span class="glyphicon glyphicon-pause"></span> AG unterbrechen ohne Rückm.',
                      ['title'=>'AG unterbrechen','name' => 'button_pause_or','class' => 'btn btn-warning myButton']); ?>
            </div>
            <div class="clearfix" style="margin-top:25px;">
                    <?= Html::submitButton('<span class="glyphicon glyphicon-stop"></span> AG beenden ohne Rückm.',
                    [
                      'title'=>'AG beenden',
                      'name' => 'button_end_or',
                      'class' => 'btn btn-danger myButton',
                      'data-confirm' => Yii::t('yii', $message),
                      'data-method' => 'post',
                      'data-pjax' => '0',
                      'title' => Yii::t('yii', 'Confirm?'),
                      'ok' => Yii::t('yii', 'Confirm'),
                      'cancel' => Yii::t('yii', 'Cancel'),
                    ]); ?>
            </div>
          </div>
          <div id="spinner_rechts" style="margin:50px; display:none;">
            <?= Spinner::widget(['preset' => 'large', 'align' => 'left']); ?>
          	<div class="clearfix"></div>
          </div>
        </div>
        <?php ActiveForm::end(); ?>
      </div>
    </div>
  </div>
</div>
