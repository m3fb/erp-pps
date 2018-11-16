<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Personal */

$this->title = 'Eintrag Abwesenheitstage';
?>
<div class="personal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formAbwesenheit', [
        'model' => $model,
        'aktivesPersonal' => $aktivesPersonal,
        'workid' => $workid,
    ]) ?>

</div>
