<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;

$rdate = Yii::$app->formatter->asDateTime($model['MSTIME'],'medium');
$stueck = Yii::$app->formatter->asDecimal($model['ADCCOUNT'],0)." " .$model['MASSEINH'];
?>



<div class='et_header'>
	<div class='et_box' id='et_head_bezeichnung'>Paletten-Nr.
	</div>
	<div  class='et_box' id='et_head_detail'><?php echo $model['LBNO']; ?><barcode code=<?php echo $model['LBNO']; ?> type="C39E" height="0.66"  />
	</div>
	<div  class='et_box_last' id='et_head_logo'>
	</div>
</div>
				
<div class='et_container'>

	<div class='et_row'></div>
	<div class='et_box' id='et_cont_bezeichnung'>Artikel Nr.
	</div>
	<div class='et_box_last' id='et_cont_detail'><?php echo $model['IDENT']; ?><barcode code=<?php echo $model['IDENT']; ?> type="C39" height="0.66"  />
	</div>		
						
	<div class='et_row'></div>
	<div class='et_box' id='et_cont_bezeichnung'>Bez.
	</div>
	<div class='et_box_last' id='et_cont_detail_bez'><?php echo $model['DESCR']; ?>
	</div>
						
						
	<div class='et_row'></div>
	<div class='et_box' id='et_cont_bezeichnung'>Datum
	</div>
	<div class='et_box_last' id='et_cont_detail'><?php echo $rdate; ?> 
	</div>
						
						
	<div class='et_row'></div>
	<div class='et_box' id='et_cont_bezeichnung'>Name
	</div>
	<div class='et_box_last' id='et_cont_detail'><?php echo $model['PERSNAME']; ?> 
	</div>
						
						
	<div class='et_row'></div>
	<div class='et_box' id='et_cont_bezeichnung'>Menge
	</div>
	<div class='et_box_last' id='et_cont_detail'><?php echo $stueck; ?> <barcode code=<?php echo $model['ADCCOUNT']; ?> type="C39E" height="0.8"  />
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
