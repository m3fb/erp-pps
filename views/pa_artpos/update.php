<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pa_artpos */

$this->title = 'Update Pa Artpos: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Pa Artpos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ARTNO, 'url' => ['view', 'id' => $model->ARTNO]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pa-artpos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
