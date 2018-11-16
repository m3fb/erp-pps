<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;

$rdate = Yii::$app->formatter->asDateTime($model['MSTIME'],'dd.MM.yyyy HH:mm:ss');
$stueck = Yii::$app->formatter->asDecimal($model['ADCCOUNT'],0)." " .$model['MASSEINH'];

$lgersetzungen= array("LG-","-01-001");
$lgNummer = str_replace($lgersetzungen,"",$model['ORNAME']); // LG-Nummer muss beim Barcode gekürzt werden, da dieser sonst zu lang wird.

!$model['DRAWIND'] ? $drawno=$model['DRAWNO'] : $drawno=$model['DRAWNO']." Index ". $model['DRAWIND'];

($part_tool_no) ? $tool_no = $part_tool_no : $tool_no= $model['COMMNO'];


strlen($model['DESCR']) > 50 ? $bezeichnung=substr($model['DESCR'],0,47)."..." : $bezeichnung=$model['DESCR'];

?>

<div id ='et_header'>
	<div id='et_head_id'>
		<?php echo $model['LBNO']; ?><barcode code=<?php echo $model['LBNO']; ?> type="C39E" size="1.2" height="0.5"  />
	</div>	
	<div id='et_head_logo'>
	</div>	
</div>

<div id ='et_header' >
	<div id='et_head_art'>
			<div style='width:45mm;height:5mm;float:left;box-sizing: border-box;'></div>
			<div style='width:12mm;float:left;font-size:80%;'>Art. Nr.</div>
			<div class='et_info_float' style='font-weight:bold;width:15mm;'><?php echo $model['IDENT']; ?></div>
			<div class='et_info'><barcode code=<?php echo $model['IDENT']; ?> type="C39E" size="1.2" height="0.5"  /></div>
		</div>
	</div>	
</div>


<div class='et_row'></div>

<div id ='et_container'>
	<div id ='et_content_1'>
		<div id='et_box_1'>
			
			<div class='et_label_nofloat'>Werkzeug</div>
			<div class='et_info'><?php echo $tool_no; ?></div>
		</div>
		<div id='et_box_2'>
			<div class='et_label'>Kunde:</div>
			<div class='et_info'><?php echo $model['CU_NAME']." ".$model['PLACE']; ?></div>
			<div class='et_label'>Art.:</div>
			<div class='et_info'></div>
			<div class='et_info'><?php echo "<b>". $bezeichnung ."</b>"; ?></div>
			<div class='et_label'>Zchng.</div>
			<div class='et_info'><?php echo $drawno; ?></div>
			<div class='et_label'>Mat.</div>
			<div class='et_info'><?php echo $model['INFO1']; ?></div>
		</div>
		<div id ='et_content_2'>
		<div id='et_box_3'>
			<div id='et_box_3_1'>
				<div class='et_label'>Mat-Charge</div>
				<div class='et_info'><?php echo $model['INFO3']; ?></div>
				<div class='et_label'>Datum / Info</div>
				<div class='et_info'><?php echo $rdate ." ".$model['PERSNO']; ?></div>
			</div>
			<div id='et_box_3_2'>
				<div class='et_label'>Prod Charge:</div>
				<div class='et_info'><?php echo $model['ORNAME']; ?></div>
				<div class='et_info'><barcode code=<?php echo $lgNummer; ?> type="C39E" size="1.2" height="0.5"  /></div>
			</div>
		</div>
		<div id='et_box_4'>
			<div class='et_label_nofloat'>Verp. Inhalt</div>
			<div class='et_info' style='font-weight:bold; font-size:1.2em;'><?php echo $stueck; ?></div>
			<div class='et_info'><barcode code=<?php echo $stueck; ?> type="C39E" size="1.2" height="0.5"  /></div>
		</div>
	</div>	
</div>



<!--
LB_DC.LBNO
LB_DC.STATUS
LB_DC.PERSNMAE
LB_DC.NAME
LB_DC.MSTIME
LB_DC.MSINFO
LB_DC.ORNAME
LB_DC.ADCOUNT

OR_OP.ORNO
OR_OP.PPTE
OR_OP.NAME
OR_ORDER.NO
OR_ORDER.IDENT
-->
