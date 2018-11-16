<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */

#$this->title = 'Passwort ändern: ' . $model->username ." / ". $model->firstname ." ". $model->surename;
#$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
#$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
#$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

<div class="row">
  <div class="col-lg-5">
    <div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
		<div class="alert alert-info" role="alert">
				Hinweis: Das Passwort muss mind. sechs Zeichen lang sein, mind. einen Großbuchstaben und mind. eine Zahl beinhalten.
		</div>
    <?= $form->field($model, 'new_password')->passwordInput() ?>
    <?= $form->field($model, 'repeat_pasword')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Update', ['class' =>'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

			</div>
		</div>
	</div>
</div>
