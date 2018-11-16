<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\captcha\Captcha;
use yii\bootstrap\Modal;
use yii\web\JsExpression;



/* @var $this yii\web\View */
$this->title = 'Geburtstagsliste';
$this->params['breadcrumbs'][] = $this->title;

?>
<?php 
$tables = Yii::$app->db->createCommand ("
	SELECT PE_WORK.FIRSTNAME as first,PE_WORK.SURNAME as sure,DATEPART(mm,FAG_DETAIL.DAT01) as GEB,FAG_DETAIL.DAT01 as dat
	FROM PE_WORK
	INNER JOIN FAG_DETAIL 
	ON PE_WORK.NO = FAG_DETAIL.FKNO 
	WHERE FAG_DETAIL.TYP = 26
	ORDER BY GEB
	")
	->queryAll();
	
	foreach($tables as $type) {
	echo $type['first'] . " " .$type['sure'] . ": ". date("d.m.Y",strtotime($type['dat'])) ."<br>";
		
		
	}
 