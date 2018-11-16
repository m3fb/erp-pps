<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\M3UrlaubStunden */

$this->title = 'Create M3 Urlaub Stunden';
$this->params['breadcrumbs'][] = ['label' => 'M3 Urlaub Stundens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="m3-urlaub-stunden-create">

    <h1>Stunden- und Urlaubskonto von <?= Html::encode($name) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'id'=>$id,
    ]) ?>

</div>
