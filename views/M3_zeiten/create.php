<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\M3_zeiten */

$this->title = 'Create M3 Zeiten';
$this->params['breadcrumbs'][] = ['label' => 'M3 Zeiten', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="m3-zeiten-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
