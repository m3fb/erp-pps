<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;

/* @var $this yii\web\View */
$this->title = 'Planung';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-6">
	<div class="panel panel-success">
	  <div class="panel-heading">Produktionsplanung</div>
	  <div class="panel-body">

		<?= $this->render('_planung',['activeMachines'=>$activeMachines,'nextOrders'=>$nextOrders]); ?>
		
	  </div>
	</div>
</div>


<div class="col-lg-6">
	<div class="panel panel-success">
	  <div class="panel-heading">Aufgaben Produktion</div>
	  <div class="panel-body">
		  
	<?= $this->render('_todo',['openTasks'=>$openTasks,'department'=>'Produktion']) ?>
	
	  </div>
	</div>	
</div>



<div class="col-lg-12">
	<div style=' clear: both;'><hr style=' border:1px solid;'></div>
	<div class="page-header"><h3></h3></div> 
</div>

<? 


#print_r($orders);
#print_r($nextOrders);
#print_r($activeMachines);
?>
