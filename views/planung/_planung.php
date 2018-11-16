<?php
$div_wp_style='float:left; width:140px; align:right; margin:1px ';
$div_job_style='float:left; width:160px; align:right; margin:1px;';

$this->registerCss(".my-prodlabel {
							  min-width: 150px !important;
							  display: inline-block !important;
							  font-size:60% !important;
							  padding: 6px 0px;
							}
					.my-wplabel {
							  min-width: 120px !important;
							  display: inline-block !important;
							  padding: 6px 2px;
							  text-align:right;
							}
							");


?>
<div class="planung">
	<?php foreach ($activeMachines as $model) {
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
				$wp_content .= "<div style='".$div_job_style."'><span class='label label-".$tool_label." my-prodlabel'>".$nextOrders[$wno."_".$i]."</span></div>";
				$i++;			
		}
		
		echo "
			<h4><div style='".$div_wp_style."'>
			<span class='label label-".$label." my-wplabel'>".$wp ."</span></div>"
			.$wp_content.
			"<div style='clear: both;'></div></h4>";
		}?>
	 <div style='clear: both; height:20px;'></div>
	 <h4><span class="label label-danger">Prio 1</span>
	 <span class="label label-warning">Prio 2</span>
	 <span class="label label-success">Soll</span>
	 <span class="label label-primary">Kann</span>
	 <span class="label label-default" width=200>Aus</span></h4>
	 
	
</div>
