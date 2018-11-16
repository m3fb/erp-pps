<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Bde */

$this->title = 'Create Bde';
$this->params['breadcrumbs'][] = ['label' => 'Bdes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bde-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
