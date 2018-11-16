<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Cucomp */

$this->title = 'Create Cucomp';
$this->params['breadcrumbs'][] = ['label' => 'Cucomps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cucomp-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
