<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\captcha\Captcha;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use kartik\field\FieldRange;
use kartik\builder\Form;




/* @var $this yii\web\View */
$this->title = 'Mitarbeiterverwaltung';
$this->params['breadcrumbs'][] = $this->title;

?>
 
<h1><?= Html::encode($this->title) ?></h1> 



<?php $form = ActiveForm::begin(['id' => 'urlaub-form',
			'method' => 'post',
			'action' => ['']
			]); 
			
			
			
echo FieldRange::widget([
    'form' => $form,
    'model' => $model,
    'label' => 'Aktionszeitraum angeben:  (Für alle Optionen)',
    'attribute1' => 'start',
    'attribute2' => 'ende',
	'separator' => '<- bis ->',
    'type' => FieldRange::INPUT_DATE,
	]);	
	
?>		
<?php 
echo "<div id='status'>";  
?>
<?= $form->field($model, 'pnra')->textInput()->label('Personalnummer:') ?>
<?php 
  
$list = [0 => 'Krank', 1 => 'Elternzeit', 2 => 'unbezahlter Urlaub']; 
/* Radiobuttons für Krank/Eltern/unbez.Urlaub - Status */
echo $form->field($model, 'status')->radioList($list, ['inline'=>true]);

 ?>

<?= Html::submitButton('Mitarbeiter-Status Eintragen', ['class'=> 'btn btn-primary glyphicon glyphicon-pencil','name'=>'btnAbschicken']) ;?>	

<?php ActiveForm::end(); 
echo "</div>";
echo "<button id='btn_verw_such' class='btn btn-primary glyphicon glyphicon-question-sign'> Einträge suchen</button>";
?>
<?php
echo "<div id='termine'>";	
?>
<?= $form->field($model, 'titel')->textInput()->label('Termin-Titel:') ?>
<button id="btn_termin_eintr" class='btn btn-primary glyphicon glyphicon-pencil'>Termin Eintragen</button>
<?php
echo "</div>";
echo "<div id='betriebs_urlaub'>"; 
?>
<b>Betriebsurlaub:</b><br>
<button id="btn_betrieb_eintr" class="btn btn-primary glyphicon glyphicon-pencil">Betriebsurlaub Eintragen</button><br><br>
Bereits eingetragen: 
<ul>

<li>
Aktuelles Jahr: <br>
<?php  
$tables = Yii::$app->db->CreateCommand (" 
	SELECT A.MSTIME as Startzeit, B.MSTIME as Endzeit, A.LBNO as LBNO FROM m3_urlaubsplanung A
	INNER JOIN m3_urlaubsplanung B
	ON A.LBNO = B.LBNO -1
	WHERE A.PERSNO = 5 AND ((DATEPART(yyyy,A.MSTIME) = DATEPART(yyyy,GETDATE()) AND A.STATUS = 800) OR
	(DATEPART(yyyy,B.MSTIME) = DATEPART(yyyy,GETDATE()) AND B.STATUS = 801))
	")
->queryAll();

foreach($tables as $type){
	echo "<div id='".$type['LBNO']."'>".date("d.m.Y",strtotime($type['Startzeit'])) . " bis " . date("d.m.Y",strtotime($type['Endzeit'])) . " <a id='".$type['LBNO']."' class='loesch_betrieb'>X</a></div>";
}
?> 
</li>

<li>
Nächstes Jahr:<br>
<?php 
$tables = Yii::$app->db->CreateCommand (" 
	SELECT A.MSTIME as Startzeit, B.MSTIME as Endzeit, A.LBNO as LBNO FROM m3_urlaubsplanung A
	INNER JOIN m3_urlaubsplanung B
	ON A.LBNO = B.LBNO -1
	WHERE A.PERSNO = 5 AND ((DATEPART(yyyy,A.MSTIME) = DATEPART(yyyy,GETDATE())+1 AND A.STATUS = 800) OR
	(DATEPART(yyyy,B.MSTIME) = DATEPART(yyyy,GETDATE())+1 AND B.STATUS = 801))
	")
->queryAll();

foreach($tables as $type){
	echo "<div id='".$type['LBNO']."'>".date("d.m.Y",strtotime($type['Startzeit'])) . " bis " . date("d.m.Y",strtotime($type['Endzeit'])) . " <a id='".$type['LBNO']."' class='loesch_betrieb'>X</a></div>";
}
?>
</li>
</ul>
<br>
<br>

<?php

echo "</div>";
?>
	
<br>
	
	<?= Yii::$app->session->getFlash('status_gest'); ?>
	

    



	<br> <br>
<div id="verw_abfrage"> </div>	
	
<b>Akute Ausfälle:</b> <br>
<?php 
$datum_1 = date('Y.d.m', strtotime('-60 day'));
$datum_2 = date('Y.d.m', strtotime('+5 week'));

$tables = Yii::$app->db->createCommand (" 
	SELECT B.PERSNAME as PERSNAME, A.MSTIME as MSSTART, B.MSTIME as MSENDE, A.STATUS as STATUS,A.LBNO as LBNO 
	FROM m3_urlaubsplanung A 
	INNER JOIN m3_urlaubsplanung B 
	ON A.LBNO = B.LBNO -1 
	WHERE ((A.STATUS = 802 AND A.MSTIME BETWEEN '".$datum_1."' AND '".$datum_2."' AND B.STATUS = 803)
	OR    (B.STATUS = 803 AND B.MSTIME BETWEEN '".$datum_1."' AND '".$datum_2."' AND A.STATUS = 802))
	OR 	  ((A.STATUS = 804 AND A.MSTIME BETWEEN '".$datum_1."' AND '".$datum_2."' AND B.STATUS = 805)
	OR    (B.STATUS = 805 AND B.MSTIME BETWEEN '".$datum_1."' AND '".$datum_2."' AND A.STATUS = 804))
	OR 	  ((A.STATUS = 806 AND A.MSTIME BETWEEN '".$datum_1."' AND '".$datum_2."' AND B.STATUS = 807)
	OR    (B.STATUS = 807 AND B.MSTIME BETWEEN '".$datum_1."' AND '".$datum_2."' AND A.STATUS = 806))
	ORDER BY A.MSTIME
	
	")   
	-> queryAll();
	
$i = 0;
foreach($tables as $type) {
	$typ = "";
	if($type['STATUS'] == 802)
		$typ = "krank";
	if($type['STATUS'] == 804)
		$typ = "Elternzeit";
	if($type['STATUS'] == 806)
		$typ = "unbez. Urlaub";
	
	if(date('Ymd') <= date('Ymd',strtotime($type['MSENDE'])))
		echo "<div id='".$type['LBNO']."'>".$type['PERSNAME'] . ": ". date("d.m.",strtotime($type['MSSTART'])) . " bis " . date("d.m.",strtotime($type['MSENDE'])) . "  <b>(".$typ.")</b> <a id='".$type['LBNO']."' class='loesch_betrieb'>X</a></div>";
}

$termine = Yii::$app->db->createCommand("SELECT * FROM	m3_termine WHERE START > '".$datum_1."'")
			->queryAll();
		
		
echo "<br><b> Termine: </b><br>";
foreach($termine as $termin){
	echo "<div id=".$termin['ID'].">'".$termin['TITEL']."': <u>Start:</u> ".date("d.m.Y",strtotime($termin['START'])). " <u>Ende:</u> ".date("d.m.Y",strtotime($termin['ENDE'])).
	" <a id=".$termin['ID']." class='loesch_termin'>X</a></div>";
}

?>