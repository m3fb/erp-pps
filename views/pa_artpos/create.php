<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Pa_artpos */

$this->title = 'Create Pa Artpos';
$this->params['breadcrumbs'][] = ['label' => 'Pa Artpos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pa-artpos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
