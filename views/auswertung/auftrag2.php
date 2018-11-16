


<?php

function auftrag($orno){
$rueck = array();

$ruestzeit = Yii::$app->db->createCommand("SELECT PTR FROM OR_OP WHERE ORNO = ".$orno." AND NAME = 10")
->queryOne();
$ruestzeit = $ruestzeit['PTR'];
$anfahrzeit = 3600; 


$op = Yii::$app->db->createCommand("SELECT OR_OP.PPARTS as PPARTS, OR_OP.PTE as PTE, OR_OP.PTR as PTR, OR_OP.DESCR as DESCR,
                                    LB_DC.MSTIME as MSTIME, LB_DC.STATUS as STATUS, LB_DC.ADCCOUNT as ADCCOUNT, LB_DC.MSINFO as MSINFO, LB_DC.ORNAME as ORNAME, LB_DC.NAME as NAME,
                                    OR_ORDER.STATUS as STATUS2, OR_ORDER.DELIVERY as DELIVERY, OR_ORDER.COMMNO as COMMNO, OR_ORDER.INFO2 as INFO2,
                                    PA_ARTPOS.AEINH2 as AEINH2
                                    FROM LB_DC 
                                    RIGHT JOIN OR_ORDER ON LB_DC.ORNO = OR_ORDER.NO 
                                    RIGHT JOIN OR_OP ON LB_DC.ORNO = OR_OP.ORNO 
                                    RIGHT JOIN PA_ARTPOS ON OR_ORDER.IDENT = PA_ARTPOS.ARTDESC
                                    WHERE LB_DC.ORNO = ".$orno." AND OR_OP.NAME = 20
                                    ")
->queryAll();

$pt = Yii::$app->db->CreateCommand("SELECT PTR FROM OR_OP WHERE NAME = 10 AND ORNO = ".$orno."")
->queryOne();



### geplanter Aufbau des Rückgabearrays: 
### [0]:  Alle Eckdaten wie Auftragsname, werkzeug usw. unabhängig von allen anderen Einträgen. 
###       Außerdem Start und Endzeitpunkt des Auftrages (wird im späteren Verlauf generiert) 
###       Möglk.1: Indikatoren ob Rüstzeit/Anfahrzeit vorhanden oder nicht.  <== this. Da die ges. Rüstzeit ausgewertet wird und sich
###       bei Nichtvorhandensein sonst auf einen Nullwert berufen wird. 
###       Ebenfalls Abrüstzeit beachten!
### [1]:  Rüstzeit falls vorhanden. Evtl mit Indikator zur leichteren Auswertung 
### [2]:  Anfahrzeit falls vorhanden. Evtl mit Indikator zur leichteren Auswertung 

foreach($op as $or){
    ### Abfrage ob Rüsten oder Anfahrzeit dabei ist => Indikator setzen (bei jedem Durchlauf) 
    
    ###  
    
    
}



$i = 0;
$n = 0;
$merk_anfahr = 0; // Gibt nur einmal Anfahren - die ersten 15er Werte werden übernommen
$merk_start = 0;
$teile_zaehler = 0;
$anfahrzeit_start = 0;
foreach($op as $or){$i++;}
foreach($op as $or){
    $n++;
     
    // Rüstzeit (falls vorhanden) definieren:
    if($n == 1 && $or['STATUS'] == 300 && $or['NAME'] == 10){
        $ruestzeit_start = $or['MSTIME'];
    }
    else if($n == 2 && $or['STATUS'] == 500 && $or['NAME'] == 10){
        $ruestzeit_ende = $or['MSTIME'];
        $rueck[0]['ruestdauer'] = round((strtotime($ruestzeit_ende) - strtotime($ruestzeit_start))/3600,3);
        $rueck[0]['intervall'] = round((strtotime($ruestzeit_ende) - strtotime($ruestzeit_start))/3600,3);
        $rueck[0]['ruestzeit_start'] =  $ruestzeit_start;
        $rueck[0]['ruestzeit_ende'] = $ruestzeit_ende;
        $rueck[0]['startzeit'] = $ruestzeit_start;
        $rueck[0]['endzeit'] = $ruestzeit_ende;
        $rueck[0]['descr'] = "Rüsten";
        $rueck[0]['descr_no'] = 10;
        $rueck[0]['adccount'] = $or['ADCCOUNT'];
        $rueck[0]['gepl_ruestzeit'] = $pt['PTR']/3600;

        
        // restlichen Werte hier mitdefinieren (Sonst bei jedem Arrayeintrag mit dabei) 
        $rueck[0]['werkzeug'] = $or['COMMNO'];
        $rueck[0]['liefertermin'] = $or['DELIVERY'];
        $rueck[0]['einzeldauer'] = $or['PTE'];
        $rueck[0]['ruestzeit'] = $ruestzeit/3600;
        $rueck[0]['teile_menge'] = $or['PPARTS'];
        $rueck[0]['gepl_dauer'] = $or['PTE'] * $or['PPARTS'] / 3600;
        $rueck[0]['auftrag_status'] = $or['STATUS2']; 
        $rueck[0]['linie'] = $or['MSINFO'];
        $rueck[0]['auftrag'] = $or['ORNAME'];        
        
        
        // Länge:
        if($or['INFO2']){
            $rueck[0]['laenge'] = $or['INFO2'];
        }
        else{
            $rueck[0]['laenge'] = $or['AEINH2'];
        }
        
    }
    if($or['NAME'] == 15 && $merk_anfahr == 0){
        $anfahrzeit_start = $or['MSTIME'];
        $merk_anfahr = 1;
    }
    else if($or['NAME'] == 15 && $merk_anfahr == 1){
        $rueck[$n]['descr'] = "Anfahren";
        $rueck[$n]['descr_no'] = 15;
        $anfahrzeit_ende = $or['MSTIME'];
        $rueck[$n]['startzeit'] = $anfahrzeit_start;
        $rueck[$n]['endzeit'] = $anfahrzeit_ende;
        $rueck[0]['anfahrdauer'] = round((strtotime($anfahrzeit_ende) - strtotime($anfahrzeit_start))/3600,3);
        $rueck[$n]['intervall'] = round((strtotime($anfahrzeit_ende) - strtotime($anfahrzeit_start))/3600,3);
        $rueck[$n]['adccount'] = $or['ADCCOUNT'];
        $merk_anfahr = 2;
    }
    
    if($or['NAME'] == 20 && $merk_start == 0){
        $startzeit = $or['MSTIME'];
        $merk_start = 1;
    }
    else if($or['NAME'] == 20 && $merk_start == 1){
        $rueck[$n]['descr'] = $or['DESCR'];
        $rueck[$n]['descr_no'] = 20;
        $endzeit = $or['MSTIME'];
        $rueck[$n]['startzeit'] = $startzeit;
        $rueck[$n]['endzeit'] = $endzeit;
        $rueck[$n]['intervall'] = round((strtotime($endzeit) - strtotime($startzeit))/3600,3);
        $rueck[$n]['adccount'] = $or['ADCCOUNT'];
        $teile_zaehler += $or['ADCCOUNT'];
        
        $merk_start = 0;
    }
    
    
    
}
 $rueck[0]['teile_zaehler'] = $teile_zaehler;
 $rueck[0]['gesamt_dauer'] = round((strtotime($rueck[$n]['endzeit']) - strtotime($anfahrzeit_start)) / 3600,2);

 return $rueck;
   
}









$werte = auftrag(13256);
$intervall_ges = 0;
$ruestdauer = $werte[0]['ruestdauer'];
foreach($werte as $wert){
    $intervall_ges += $wert['intervall'];
}
$intervall_ges -= $ruestdauer;
$gepl_dauer = $werte[0]['gepl_dauer'];
$gesamt_dauer = $werte[0]['gesamt_dauer'];

$style = ""; 
if($gepl_dauer > ($intervall_ges)){
    $style = "green";
}
else {
    $style = "red";
}
if(($werte[0]['ruestdauer']-$werte[0]['gepl_ruestzeit']) < 0){
    $style_ruest = "green";
}
else {
    $style_ruest = "red";
}
if($werte[0]['anfahrdauer'] < 0){
    $style_anf = "green";
}
else {
    $style_anf = "red";
}

echo "<h1>Auftragsauswertung ".$werte[0]['auftrag']."</h1>";
echo "<b>".$werte[0]['linie'] . "</b><br><br>";
echo "<b>Abgeschlossen: " . ($werte[0]['teile_zaehler']/$werte[0]['adccount']*100) ."%</b><br>";
echo "Gesamte Dauer des Auftrags: " . $gesamt_dauer . " Std <br>";
echo "Davon effektive Arbeitszeit: " . $intervall_ges . " Std  (<u>Unterbrechungen: " . ($gesamt_dauer - $intervall_ges) . " Std</u>)<br>";
echo "Geplante Dauer des Auftrags: " . $gepl_dauer . " Std  (<a style='background-color: ".$style."; color: white;'>".($intervall_ges - $gepl_dauer)." Std</a>) <br><br>";

echo " Rüstzeit: " . $werte[0]['ruestdauer'] . " Std ( geplant: ".$werte[0]['gepl_ruestzeit']." Std || <a style='background-color: ".$style_ruest."; color: white;'>". ($werte[0]['ruestdauer']-$werte[0]['gepl_ruestzeit']) . "Std </a>)<br>";
echo " Anfahrzeit: " . $werte[0]['anfahrdauer'] . "Std  ( <a style='background-color: ".$style_ruest."; color: white;'>". ($werte[0]['anfahrdauer']-1) ."Std</a>)<br><br>";

if($werte[0]['auftrag_status'] == 0){
        echo "Auftrag-Status:<x style='background-color:red;color:white;'>Nocht nicht gestartet</x><br>";
    }
    else if($werte[0]['auftrag_status'] == 1){
        echo "Auftrag-Status:<x style='background-color:yellow;color:black;'>In Arbeit</x><br>";
    }
    else if($werte[0]['auftrag_status'] == 2){
        echo "Auftrag-Status:<x style='background-color:green;color:white;'>Fertig</x><br>";
    }
    
echo "Zu produzierende Menge: " . $werte[0]['adccount'] . " Stück <br>";
echo "Bereits prodziert: " . $werte[0]['teile_zaehler'] . " Stück <br>"; 





echo "Länge pro Stück: " . $werte[0]['laenge'] . "mm<br>";
echo "Gesamte Länge: 3218m <br>";
echo "Gemessene Länge: 3294m (958 Stück)<br>";
echo "Toleranz: 3% (96,5 Stück)<br>";
echo "<u>=>Im Toleranzbereich</u>"; 






// echo "Rüstdauer: " . $wert['ruestdauer'] . " Std";








$k = 0; 

$pre_endzeit = strtotime($werte[0]['ruestzeit_start']);
$beschr = "";


### Höhe des Graphen: 600px;
echo "<br><br>";
echo "<div class='graph'>";
foreach($werte as $wert){
    $k++;
    // Abspeichern der Endzeit-Werte um die Unterbrechungsblöcke zu berechnen und anzuzeigen
    
        
    $proz_unt = 600 * (((strtotime($wert['startzeit']) -$pre_endzeit) / 3600) / $gesamt_dauer);
    
    $proz = 600 * ($wert['intervall'] / $gesamt_dauer);
    if($wert['descr_no'] == 10){
        $beschr = 'ruest';
    }
    else if($wert['descr_no'] == 15){
        $beschr = 'anfahr';
    }
    else if($wert['descr_no'] == 20){
        $beschr = 'start';
    }  
    
    
    
    echo "<div class='unterbrechung abstand' style='height: ".$proz_unt."px'><z class='subs_l unterb' style='height: ".($proz_unt/2)."px'>Unterbrechung</z></div>";
    
    echo "<div class='".$beschr." abstand' style='height: ".$proz."px'> 
    <z class='subs_l' style='margin-top: ".($proz / 2)."px'><b>".$wert['descr']."</b></z> " . 
    "<z class='subs' style='margin-top: ".$proz."px'>".date("d.m H:i", strtotime($wert['endzeit']))."Uhr <u><b>(".$wert['intervall']." Std</b></u>)    
    // Zurückgemeldete Teile: ".$wert['adccount']."   ( ".$wert['descr']."  )</z></div>";
    
    
    $pre_endzeit = strtotime($wert['endzeit']);
}  




echo "</div><br><br>";



// echo "<pre>";
// print_r($werte);
// echo "</pre>";




?>

    <!-- <div class="abstand ruest"  style="height: 30px">
        <a class="subs">( 1Std 4Min 38Sek ) </a>
    </div>
    <div class="abstand anfahr"  style="height: 20px">
      <a class="subs">12:46:43: Anfahren ( 22 Min 7Sek )</a>
    </div>
    <div class="abstand start"  style="height: 90px">
      <a class="subs">13:08:50: Start ( 36Min 32Sek )</a>
    </div>
    <div class="abstand unterbrechung"  style="height: 35px">
      <a class="subs">13:45:22: Unterbrechung ( 4Min 20Sek ) <br><br><br> Zurückgemeldete Teile: 250 Stck  ||  Gemessene Wegstrecke: 500cm</a>
    </div>
    <div class="abstand start"  style="height: 150px">
      <a class="subs">13:49:42: Start </a>
    </div>
-->



