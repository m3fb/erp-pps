<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\M3ProjektCheckliste */

$this->title = 'm3-Projekt Checkliste';
#$this->params['breadcrumbs'][] = ['label' => 'm3-Projekt Checklistes', 'url' => ['index']];
#$this->params['breadcrumbs'][] = $this->title;
?>
<div class="m3-projekt-checkliste-create">
<div class="panel panel-primary">
  <div class="panel-heading"><?= Html::encode($this->title)  ?></div>

</div>
    <?= $this->render('_form_project', [
        'model' => $model,
    ]) ?>

</div>
