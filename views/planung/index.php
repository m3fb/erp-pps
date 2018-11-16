<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;

/* @var $this yii\web\View */
$this->title = 'Planung';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="planung">
    <h1><?= Html::encode($this->title) ?></h1>
	<?foreach ($activeMachines as $model) {
		echo "
			<div style='float:left; width:100px; align:right; margin:2px'>
			<span class='label label-default'>".$model['NAME'] ."</span></div>
			<div style='float:left; width:50px; align:right; margin:2px'><span class='label label-info'>W1010</span></div>
			<div style='float:left; width:50px; align:right; margin:2px'><span class='label label-info'>W1040</span></div>
			<div style='float:left; width:50px; align:right; margin:2px'><span class='label label-info'>W1050</span></div>
			<div style='clear: both;'></div>";
		}?>
	<!--<span class="label label-default" width=200>Standard</span>
	<span class="label label-primary">Primär</span>
	<span class="label label-success">Erfolg</span>
	<span class="label label-info">Info</span>
	<span class="label label-warning">Warnung</span>
	<span class="label label-danger">Gefahr</span> -->
	
</div>
