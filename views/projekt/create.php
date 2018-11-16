<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\M3ProjektCheckliste */

$this->title = 'm3-Projekt anlegen';

#$this->params['breadcrumbs'][] = ['label' => '<span class="glyphicon glyphicon-arrow-left"></span>', 'url' => ['projekt/projektplan']];
#$this->params['breadcrumbs'][] = $this->title;
?>

<div style="margin-bottom: 5px;"><?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> zurück', ['projekt/projektplan'],['type' => 'button', 'class' => 'btn btn-default']);?></div>

<div class="m3-projekt-checkliste-create">
	<div class="panel panel-primary">
	  <div class="panel-heading"><?= Html::encode($this->title)  ?></div>


		<?= $this->render('_form_create', [
			'model' => $model,
		]) ?>
	</div>
</div>
