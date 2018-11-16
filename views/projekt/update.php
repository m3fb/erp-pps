<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\M3ProjektCheckliste */

$this->title = 'Checkliste: '. $model->WerkzeugNr;
#$this->params['breadcrumbs'][] = ['label' => 'Projektverwaltung', 'url' => ['index']];
#$this->params['breadcrumbs'][] = ['label' => 'Checklistenverwaltung', 'url' => ['checkliste_index']];
#$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
#$this->params['breadcrumbs'][] = 'Update';
?>
<div style="margin-bottom: 5px;"><?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> zurück', ['projekt/projektplan'],['type' => 'button', 'class' => 'btn btn-default']);?></div>

<div class="m3-projekt-checkliste-update">

		  <div class="panel-heading bg-primary" style="margin-bottom:10px;"><h3><?= Html::encode($this->title)  ?></h3>
									<?= '<small> erstellt von '. $model->user->firstname.' '. $model->user->surename.
								' am '.Yii::$app->formatter->asDateTime($model->Erstelldatum).
								' / geändert von '.$model->changer->firstname.' '. $model->changer->surename.
								' am '.Yii::$app->formatter->asDateTime($model->Aenderungsdatum).'</small>' ?>
		</div>

		<?= $this->render('_form', [
			'model' => $model,
			'openProjects' => $openProjects,
		]) ?>
	
</div>
