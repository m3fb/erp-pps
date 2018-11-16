<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

$this->title = 'Sql Logs ab '.$dateTime;
#$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact" style="padding:0px 10px;">
    <div class="pull-left" style="margin-right:5px;">
      <?= Html::a('<i class="glyphicon glyphicon-arrow-left"></i>', ['site/sqllog-auswahl'],['type' => 'button', 'class' => 'btn btn-primary']) ?>
    </div>
    <div class="clearfix">
      <h4><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="row">
          <?= $tabellen ?>

    </div>


</div>
