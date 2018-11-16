<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;

/* @var $this yii\web\View */
$this->title = 'test';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Testseite
    </p>

    <code><?= __FILE__ ?></code>
</div>
