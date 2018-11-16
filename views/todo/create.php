<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Todo */

($env == 'konstruktion')?$this->title = 'Aufgabe für Konstruktion erstellen':$this->title = 'Aufgabe erstellen';
#$this->params['breadcrumbs'][] = ['label' => 'Todos', 'url' => ['index','env'=>$env]];
#$this->params['breadcrumbs'][] = $this->title;
?>
<div class="todo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'env' => $env,
    ]) ?>

</div>
