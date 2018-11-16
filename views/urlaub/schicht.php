<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\bootstrap\Modal;
use yii\web\JsExpression;



/* @var $this yii\web\View */
$this->title = 'Schichtplaner';
$this->params['breadcrumbs'][] = $this->title;

?>

<h1><?= Html::encode($this->title) ?></h1> 

<div class="site-urlaub">
<br>
<div id="container">
<div id="legende">
<div id='laedt'><img src="laedt.gif"></div>
<!--
<div id='kreis_rot'></div> Fehltage
<div id='kreis_gruen'></div> Steht zur Verfügung
<div id='kreis_sf'></div> Schichtführer
-->
<div id="loesch_gesamt">Aus Plan entfernen <br> / Plan leeren (klick)</div>
<div id="vorlage_1" class="vorlagen" data-ausw="0">Vorlage 1</div>
<div id="vorlage_2" class="vorlagen" data-ausw="0">Vorlage 2</div>
<div id="vorlage_3" class="vorlagen" data-ausw="0">Vorlage 3</div>
<div id="vorlage_uebernehmen" class="vorlagen" data-ausw="0">Vorlage übernehmen</div>



<button id="schicht_eintrag" class="btn btn-primary glyphicon glyphicon-export"> Übernehmen </button><br>
<button href="#" id="vorherige" class="btn btn-primary glyphicon glyphicon-chevron-left">Vorherige</button>
<button href="#" id="naechste" class="btn btn-primary glyphicon glyphicon-chevron-right">Nächste</button>
<br><div id='warnung'>-</div>
</div>




<?php

echo "<div id='mitarbeiter-liste'><ul class='mlist'>";
$tables = $model->mitarbeiter("SM",0,0); 
$i = 0;
$n = -30; // Schichtführer
$z = -10; // Schichtstellvertreterführer..dings
$tagestr = "";

// Schichtführer und Schichtmitarbeiter separat auflisten:
// Das data-sid Attribut wird später verwendet um die Mitarbeiter in den Tabellen zu sortieren (übersichtlicher)
foreach($tables as $type) {
	if($type['TXT01'] == "SF"){	
	echo "<li><div id='".$type['username']."' class='mitarbeiter' data-urlaubstage='' data-sf='1' data-sid='".$n."'>".$type['firstname']." <br>".$type['surename'] . "</div></li>";
	echo "<style> #".$type['username']." { border: 3px dotted #fff; } </style>";
	$n++;
	}
	else if($type['username'] == "vdudin" || $type['username'] == "mvarlan" || $type['username'] == "pwüst" || $type['username'] == "rvála") {
	echo "<li><div id='".$type['username']."' class='mitarbeiter' data-urlaubstage='' data-sf='0' data-sid='".$z."'>".$type['firstname']." <br>".$type['surename'] . "</div></li>";
	echo "<style> #".$type['username']." { border: solid 2px  #fff; border-style: dashed solid dashed solid; } </style>";
	$z++;
	}
	$i++;
};
echo "<br><br><hr noshade>";
foreach($tables as $type) {
	if(($type['TXT01'] == "SM") && !($type['username'] == "vdudin" || $type['username'] == "mvarlan" || $type['username'] == "pwüst" || $type['username'] == "rvála")){
	echo "<li><div id='".$type['username']."' class='mitarbeiter' data-urlaubstage='' data-sf='0' data-sid='".$i."'>".$type['firstname']." <br>".$type['surename'] . "</div></li>";
	}
	$i++;
};
		

// echo "<pre>";
// print_r($tables);
// echo "</pre>";
echo "</ul></div>Verfügbare Mitarbeiter: <a id='vlist'></a>";
?>
</div>

 


<table id="schichtplan" class="tg">
  <tr class="head">
    <th class="kopf links" id="ecke"><h2>KW 
	<div id="KW"><?php echo  date("W");?></div><div id="jahr"><?php echo  date("Y");?></div></h2> 

	</th>
    <th class="kopf" id="mo"><h4>Montag</h4><div id="datum_mo"><?php echo date("d.m.Y", time()-((date("N")-1)*86400));?></div></th>
    <th class="kopf" id="di"><h4>Dienstag</h4><div id="datum_di"><?php echo date("d.m.Y", time()-((date("N")-2)*86400));?></div></th>
    <th class="kopf" id="mi"><h4>Mittwoch</h4><div id="datum_mi"><?php echo date("d.m.Y", time()-((date("N")-3)*86400));?></div></th>
    <th class="kopf" id="do"><h4>Donnerstag</h4><div id="datum_do"><?php echo date("d.m.Y", time()-((date("N")-4)*86400));?></div></th>
    <th class="kopf" id="fr"><h4>Freitag</h4><div id="datum_fr"><?php echo date("d.m.Y", time()-((date("N")-5)*86400));?></div></th>
	<th class="kopf" id="sa"><h4>Samstag</h4><div id="datum_sa"><?php echo date("d.m.Y", time()+((6-date("N"))*86400));?></div></th>
	<th class="kopf" id="so"><h4>Sontag</h4><div id="datum_so"><?php echo date("d.m.Y", time()+((7-date("N"))*86400));?></div></th>
  </tr>
   <tr>
    <td class="feld woche fruehschicht links">
	<p align="center">Früh <br><tt>06:00 - 14:00</tt></p>
	Mo: <a id="fr_mo" class="zaehler"> </a><br>
	Di: <a id="fr_di" class="zaehler"> </a><br>
	Mi: <a id="fr_mi" class="zaehler"> </a><br>
	Do: <a id="fr_do" class="zaehler"> </a><br>
	Fr: <a id="fr_fr" class="zaehler"> </a><br>
	Sa: <a id="fr_sa" class="zaehler"> </a><br>
	So: <a id="fr_so" class="zaehler"> </a>
	</td>
    	
	<td class="feld"><div class="kastl frueh mo"></div></td>
    <td class="feld"><div class="kastl frueh di"></div></td>
    <td class="feld"><div class="kastl frueh mi"></div></td>
    <td class="feld"><div class="kastl frueh do"></div></td>
    <td class="feld"><div class="kastl frueh fr"></div></td>
	<td class="feld"><div class="kastl frueh sa"></div></td>
	<td class="feld"><div class="kastl frueh so"></div></td>
  </tr>
  
  <tr>
    <td class="feld woche spaetschicht links">
	<p align="center">Spät <br><tt>14:00 - 22:00</tt></p>
	Mo: <a id="sp_mo" class="zaehler"> </a><br>
	Di: <a id="sp_di" class="zaehler"> </a><br>
	Mi: <a id="sp_mi" class="zaehler"> </a><br>
	Do: <a id="sp_do" class="zaehler"> </a><br>
	Fr: <a id="sp_fr" class="zaehler"> </a><br>
	Sa: <a id="sp_sa" class="zaehler"> </a><br>
	So: <a id="sp_so" class="zaehler"> </a>
	</td>
    
	<td class="feld"><div class="kastl spaet mo"></div></td>
    <td class="feld"><div class="kastl spaet di"></div></td>
    <td class="feld"><div class="kastl spaet mi"></div></td>
    <td class="feld"><div class="kastl spaet do"></div></td>
    <td class="feld"><div class="kastl spaet fr"></div></td>
	<td class="feld"><div class="kastl spaet sa"></div></td>
	<td class="feld"><div class="kastl spaet so"></div></td>
  </tr>
  <tr>
    <td class="feld woche nachtschicht links">
	<p align="center">Nacht <br><tt>22:00 - 06:00</tt></p>
	Mo: <a id="na_mo" class="zaehler"> </a><br>
	Di: <a id="na_di" class="zaehler"> </a><br>
	Mi: <a id="na_mi" class="zaehler"> </a><br>
	Do: <a id="na_do" class="zaehler"> </a><br>
	Fr: <a id="na_fr" class="zaehler"> </a><br>
	Sa: <a id="na_sa" class="zaehler"> </a><br>
	So: <a id="na_so" class="zaehler"> </a>
	</td>
    <td class="feld"><div class="kastl nacht mo"></div></td>
    <td class="feld"><div class="kastl nacht di"></div></td>
    <td class="feld"><div class="kastl nacht mi"></div></td>
    <td class="feld"><div class="kastl nacht do"></div></td>
    <td class="feld"><div class="kastl nacht fr"></div></td>
	<td class="feld"><div class="kastl nacht sa"></div></td>
	<td class="feld"><div class="kastl nacht so"></div></td>
  </tr>
</table>




<br>
<code><?= __FILE__ ?></code>

</div>

</body>
