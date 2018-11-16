<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'Neuer Benutzer';
$this->params['breadcrumbs'][] = $this->title;
$username = mb_strtolower(mb_substr($pers_detail['FIRSTNAME'],0,1).$pers_detail['SURNAME']); //mb_... gewährleistet, dass Umlaute korrekt dargestellt werden
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Benutzer <?php echo $pers_detail['FIRSTNAME'].' '.$pers_detail['SURNAME'].' ' ?>anlegen:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model, 'username')->textInput(['readonly' => true, 'value' => $username] )?>
                <?= $form->field($model, 'firstname')->textInput(['readonly' => true, 'value' => $pers_detail['FIRSTNAME']]) ?>
                <?= $form->field($model, 'surename')->textInput(['readonly' => true, 'value' => $pers_detail['SURNAME']]) ?>
                <?= $form->field($model, 'email')->textInput(['readonly' => true, 'value' => $pers_detail['MODEM']]) ?>
                <?= $form->field($model, 'pe_work_id')->textInput(['type' => 'number','readonly' => true, 'value' => $pers_detail['NO']]) ?>
                <?= $form->field($model, 'role')->dropDownList(['15' => 'User','35' => 'Manager','25' => 'Admin']) ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <div class="form-group">
                    <?= Html::submitButton('Speichern', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
