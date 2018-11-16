<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\M3UrlaubStunden */

$this->title = 'Update M3 Urlaub Stunden: ' . $model->ID;
#$this->params['breadcrumbs'][] = ['label' => 'M3 Urlaub Stundens', 'url' => ['index']];
#$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
#$this->params['breadcrumbs'][] = 'Update';
?>
<div class="m3-urlaub-stunden-update">

    <h1>Stunden- und Urlaubskonto von <?= Html::encode($name) ?></h1>
   
    <?= $this->render('_form', [
        'model' => $model,
        'id'=>$id,
    ]) ?>

</div>
