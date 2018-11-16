<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Urlaub */

$this->title = 'Create Urlaub';
$this->params['breadcrumbs'][] = ['label' => 'Urlaubs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="urlaub-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
