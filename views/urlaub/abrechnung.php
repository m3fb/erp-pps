<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use kartik\mpdf\Pdf;




/* @var $this yii\web\View */
$this->title = 'Monatsabrechnung';
$this->params['breadcrumbs'][] = $this->title;

?>
 
<h1><?= Html::encode($this->title) ?></h1> 



<?php 
echo "<div id='abr_links'>";
if ($handle = opendir('../PDFs/Abrechnung')){
        while (false !== ($file = readdir($handle))) {
            if($file !== '.' && $file !== '..') {
               echo "<a href='../PDFs/Abrechnung/".$file."' target='_blank'>
                     ".$file."</a><br>\n";
            }
        }
        closedir($handle);
    }
echo "</div>";
echo "<div id='abr_rechts'>";    

if ($handle = opendir('../PDFs/Zeiten-Tabellen')){
        while (false !== ($file = readdir($handle))) {
            if($file !== '.' && $file !== '..') {
               echo "<a href='../PDFs/Zeiten-Tabellen/".$file."' target='_blank'>
                     ".$file."</a><br>\n";
            }
        }
        closedir($handle);
    }
echo "</div>";
// $end = 0;
// $s = 3600;
// $m = 60;

// $end = (8*$s)+(5*$m)+26
// +(8*$s)+(3*$m)+05
// +($s*7)+(5*$m)+17
// +(8*$s)+(15*$m)+6
// +(8*$s)+(3*$m)+29
// +(8*$s)+(3*$m)+18 //
// +(8*$s)+(5*$m)+39
// +29687
// +(8*$s)+(5*$m)+7
// +(8*$s)+(8*$m)+17
// +(8*$s)+(2*$m)+35
// +($s*8)+($m*3)+18
// +(8*$s)+(7*$m)+14
// +(8*$s)+(5*$m)+6
// +(8*$s)+(2*$m)+33;



// echo $end . "<br><pre>";

// print_r ($model->istsf(12,12)); 
// echo "<br>";

// print_r ($model->zeiten()); echo "</pre>";



// $tables = Yii::$app->db->createCommand("
  // SELECT *
  // FROM [LB_DC]
  // WHERE (STATUS = 100 OR STATUS = 200 OR STATUS = 800 OR STATUS = 801 OR STATUS = 802 OR STATUS = 803 OR STATUS = 804 OR STATUS = 805 OR STATUS = 806 OR STATUS = 807)
  // AND PERSNO = 652

  // AND MSTIME BETWEEN '2017-01-02' AND '2017-01-03'
  // ORDER BY MSTIME
  // ")
  // ->queryAll();
 
 
// $gesamtstunden = 0; 
// $stundenarray = array();
// $urlaubsarray = array();
// $nachtarray = array();
// $krankarray = array();
// $monatsarray = array(); 
 
 
 
 
$t = 0; 
$ges = 0;
$datum = 0;
// // foreach($tables as $type){	

// // $datumakt = date('dmY',strtotime($type['MSTIME'])); 
	// // if($datum == $datumakt) {
		// // $monatsarray[$datumakt][$type['STATUS']] = $type['MSTIME'];
		// // $datum = $datumakt; 
		
	// // }
	
	// // else {
		// // $t++;
		// // $monatsarray[$datumakt][$type['STATUS']] = $type['MSTIME'];
		// // $datum = $datumakt;
		
	// // }
	
// // $ges = $ges + $type['MTIME2'];
// // }

// echo "<table class='abrechnung'>";
// foreach($tables as $type){
	// $datumakt = date('dmY',strtotime($type['MSTIME']));
	// if($datum == $datumakt){
		// echo "<tr><td></td>";
		// echo "<td>" . $type['STATUS'] . ":</td><td> " . date(' G:i:s',strtotime($type['MSTIME'])) . "</td></tr>";
		// $datum = $datumakt;
	// }
		
		
	// else {
		// $t++;
		// echo "<tr><td>" . date('d.m.Y',strtotime($type['MSTIME'])) . "</td>";
		// echo "<td>" . $type['STATUS'] . ":</td><td> " . date(' G:i:s',strtotime($type['MSTIME'])) . "</td></tr>";
		// $datum = $datumakt;
	// }
	
	
// }


 // echo "<pre>";
 // print_r ($monatsarray);
 // echo "</pre>";
 // echo "<br> ".$ges." " ;
 // echo "<br>";
 // list($std,$min,$sek) = explode(':',date('G:i:s'));
 // echo $std ." ";
 // echo $min ." ";
 // echo $sek;
?>



<div class="site-urlaub">
Monat:  
<select name="Monat" size="12" id="monat"> 
<option value="1">Januar</option> 
<option value="2">Februar</option> 
<option value="3">März</option> 
<option value="4">April</option> 
<option value="5">Mai</option>
<option value="6">Juni</option>
<option value="7">Juli</option>
<option value="8">August</option>
<option value="9">September</option>
<option value="10">Oktober</option>
<option value="11">November</option>
<option value="12">Dezember</option>
</select>
Jahr: <input id="jahr" class='' value='' ><br>
<div id='laedt'><img src="laedt.gif"></div>
<!-- <button type="button" id="btn_suchen" class="btn btn-primary">Suchen</button> -->










<hr noshade>


<?php 
$mon = date("n") -1;
$mon = "U".$mon;
$jah = date("Y");

if(date("n") -1==0){
	$mon = "U12";
	$jah = $jah -1;
}

$erg = Yii::$app->db->CreateCommand("
		SELECT ".$mon." FROM m3_urlaub_stunden
		WHERE WORKID = 1 AND JAHR = ".$jah." ")
	->queryOne();

if($erg){		
	$pruef = array_keys($erg);
	$erg = $erg[$pruef[0]];
	if($erg == 1)
		echo "letzter Monat bereits abgerechnet";
	else 
		echo "letzter Monat noch nicht abgerechnet";
}
else
	echo "Kein Eintrag zu letzten Monat erstellt";


?>
<div id="meld"></div>
<button id="btn_abrechnung">Abrechnungs-PDF erstellen</button>
<button id="btn_st_ta">Stunden/UTage abrechnen</button>
<button id="btn_zeiten_tabelle">Zeiten-Tabellen-PDF erstellen</button><br>

<div id="ausgabe"></div>




















<?php 
// $tables = $model->zeiten_tabelle(04,2017);

// echo "<table>";
// foreach($tables as $type){
// $i = 0;	
	// foreach($type as $eintrag){
		// if(!$i)
			// echo "<tr><td>".$eintrag['persname'] ."</td>:<td> ".$eintrag['pnr'] ."</td></tr>".
				 // "<tr><td>Datum</td><td>Uhrzeit</td><td>verrechn. Stunden</td> <td>Nachtzuschlag</td><td>Feiertagszuschlag:</td></tr>";		
		// echo "<tr>";
		// echo "<td>".$eintrag['start_tag'].":</td><td> ". $eintrag['startzeit']."</td><td>".$eintrag['teilzeit']."</td><td>".$eintrag['teil_nachtzeit']."</td><td>".
			 // $eintrag['teil_feierzeit']."</td></tr>";	
		// echo "<tr> <td></td> </tr>";
		// $i++;
	// }
//}
?>

 <?php

	// if($array = Yii::$app->getRequest()->getQueryParam('Urlaub',NULL)){ // PERSNO aus Url auslesen (array) 
		// $zahl = array_keys($array);
		// $pnra = $array[$zahl[0]]; 
		// $tables = $model->tabelle($pnra);
		
		// echo "<table id='abrechnungstabelle'><tr>";
		// echo "<td>Januar</td>";
		// echo "<td>Februar</td>";
		// echo "<td>März</td>";
		// echo "<td>April</td>";
		// echo "<td>Mai</td>";
		// echo "<td>Juni</td>";
		// echo "<td>Juli</td>";
		// echo "<td>August</td>";
		// echo "<td>September</td>";
		// echo "<td>Oktober</td>";
		// echo "<td>November</td>";
		// echo "<td>Dezember</td>";		
		// echo "</tr><tr>";
		
		// foreach($tables as $type){
			// echo "<td>".$type['U1']."</td>";
			// echo "<td>".$type['U2']."</td>";
			// echo "<td>".$type['U3']."</td>";
			// echo "<td>".$type['U4']."</td>";
			// echo "<td>".$type['U5']."</td>";
			// echo "<td>".$type['U6']."</td>";
			// echo "<td>".$type['U7']."</td>";
			// echo "<td>".$type['U8']."</td>";
			// echo "<td>".$type['U9']."</td>";
			// echo "<td>".$type['U10']."</td>";
			// echo "<td>".$type['U11']."</td>";
			// echo "<td>".$type['U12']."</td></tr><tr>";
			// echo "<td>".$type['S1']."</td>";
			// echo "<td>".$type['S2']."</td>";
			// echo "<td>".$type['S3']."</td>";
			// echo "<td>".$type['S4']."</td>";
			// echo "<td>".$type['S5']."</td>";
			// echo "<td>".$type['S6']."</td>";
			// echo "<td>".$type['S7']."</td>";
			// echo "<td>".$type['S8']."</td>";
			// echo "<td>".$type['S9']."</td>";
			// echo "<td>".$type['S10']."</td>";
			// echo "<td>".$type['S11']."</td>";
			// echo "<td>".$type['S12']."</td>";
		// }
		// echo "</tr></table>";
		// }
		// echo "<button class='btn btn-primary'>1</button><button class='btn btn-primary'>2</button>";
		// echo "<br>Daten:";
	
		
// ?>




</div>
