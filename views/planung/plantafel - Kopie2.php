<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;

/* @var $this yii\web\View */
$this->title = 'Planung';
$this->params['breadcrumbs'][] = $this->title;

$div_wp_style='float:left; width:140px; align:right; margin:2px ';
$div_job_style='float:left; width:110px; align:right; margin:2px ';
#$fontsize='100%';



?>
<div class="planung">
	<?foreach ($activeMachines as $model) {
		$wp_content = '';
		$wp = $model['NAME'];
		$wno = $model['WP_MA1_NO'];
		$i=0;
		$prio = $model['CONTROL'];
	
		if ($prio == 4) {
			$label = 'primary';
		} elseif ($prio == 3) {
			$label = 'success';
		} elseif ($prio == 2) {
			$label = 'warning';
		} elseif ($prio == 1) {
			$label = 'danger';
		} else {
			$label = 'default';
		}
			
		#while ($nextOrders[$wno."_".$i]) {
		while (array_key_exists($wno."_".$i ,$nextOrders)) {
				($i == 0) ? $tool_label = $label : $tool_label = 'default';
				$wp_content .= "<div style='".$div_job_style."'><span class='label label-".$tool_label."'>".$nextOrders[$wno."_".$i]."</span></div>";
				$i++;			
		}
		
		echo "
			<h4><div style='".$div_wp_style."'>
			<span class='label label-".$label."'>".$wp ."</span></div>"
			.$wp_content.
			"<div style='clear: both;'></div></h4>";
		}?>
	 <h3><span class="label label-danger">Prio 1</span>
	 <span class="label label-warning">Prio 2</span>
	 <span class="label label-success">Soll</span>
	 <span class="label label-primary">Kann</span>
	 <span class="label label-default" width=200>Aus</span></h3>
	 
	
</div>
 <?= $this->render('_todo') ?>; 


<? 


#print_r($orders);
#print_r($nextOrders);
#print_r($activeMachines);
?>
