<?php


function auftrag($orno) {
$rueck = array();


$op = Yii::$app->db->createCommand("SELECT OR_OP.PPARTS as PPARTS, OR_OP.PTE as PTE, OR_OP.PTR as PTR, OR_OP.DESCR as DESCR,
                                    LB_DC.MSTIME as MSTIME, LB_DC.STATUS as STATUS, LB_DC.ADCCOUNT as ADCCOUNT, LB_DC.MSINFO as MSINFO, LB_DC.ORNAME as ORNAME, LB_DC.NAME as NAME,
                                    OR_ORDER.STATUS as STATUS2, OR_ORDER.DELIVERY as DELIVERY, OR_ORDER.COMMNO as COMMNO, OR_ORDER.INFO2 as INFO2, OR_ORDER.DESCR as ORDER_DESCR, OR_ORDER.IDENT as IDENT,
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
 
    
$i = 0;
$n = 2;  ### Die Arbeitsschritte werden ab $rueck[2] aufgelistet
$c = 0;
$merk_ruest = 0; ## Um im 0er Teil zu informieren ob eine Rüstzeit dabei ist oder nicht
$merk_anfahr = 0; ## Falls Anfahrzeit zählt nur die erste => Merker wird gesetzt (doppelte Funktion gegenüber Rüstmerker)
$merk_strecke = 0; ## Um den Ersten Wert nach der Endzeit eines Eintrages einzufangen (Strecke)
foreach($op as $or){
    $i++;
    ### Es wird hier bereits die Endzeit definiert (letzter Eintrag beschreibt)  um die richtigen Streckendaten rechtzeitig auslesen zu können (nächster Schritt) 
    $rueck[0]['auftrag_endzeit'] = strtotime($or['MSTIME']);    
    }


### Erst auf 0 setzen, wird ggfs noch geändert im weiteren Verlauf
$rueck[0]['merk_ruest'] = 0;
$rueck[0]['merk_anfahr'] = 0;

        
foreach($op as $or){
    ### Die Eckdaten des Auftrags werden im 0er Teil des Arrays gespeichert, danach folgt die chronologische Auflistung der Arbeitsschritte
    if($n==2){
        $rueck[0]['linie'] = $or['MSINFO'];
        $rueck[0]['werkzeug'] = $or['COMMNO'];
        $rueck[0]['liefertermin'] = $or['DELIVERY'];
        $rueck[0]['einzeldauer'] = $or['PTE'];
        $rueck[0]['menge'] = $or['PPARTS'];
        $rueck[0]['gepl_dauer'] = $or['PTE'] * $or['PPARTS'];
        $rueck[0]['auftrag_status'] = $or['STATUS2']; 
        $rueck[0]['auftrag'] = $or['ORNAME'];
        $rueck[0]['auftrag_startzeit'] = strtotime($or['MSTIME']);
        $rueck[0]['teile_zaehler'] = 0;
        $rueck[0]['bezeichnung'] = $or['ORDER_DESCR'];
        $rueck[0]['art_no'] = $or['IDENT'];

        
        
        $rueck[0]['produktions_zeit'] = 0;
        $rueck[0]['mess_strecke_start'] = 0;
        $rueck[0]['mess_strecke_ende'] = 0;
        $rueck[0]['messdaten_check'] = 0;
        // Länge:
        if($or['INFO2']){
            $rueck[0]['laenge'] = $or['INFO2'];
        }
        else{
            $rueck[0]['laenge'] = $or['AEINH2'];
        }
        $rueck[0]['gesamt_laenge'] = ($or['PPARTS'] * $rueck[0]['laenge']) / 1000;
        

        
        
        ###
        ### Holen der Streckendaten!
        $zeitlog = Yii::$app->db->createCommand(" SELECT * FROM m3_streckenlog WHERE MSTIME > '".date("Y.d.m H:i:s",$rueck[0]['auftrag_startzeit'])."' AND MSTIME < '". date("Y.d.m H:i:s",$rueck[0]['auftrag_endzeit']) . "'")
        ->queryAll();
        $k = 0;
        foreach($zeitlog as $log){
            $rueck[1][$k]['zeit'] = strtotime($log['MSTIME']);
            $rueck[1][$k]['strecke'] = $log['STRECKE'];
            $rueck[1][$k]['geschwindigkeit'] = $log['GESCHWINDIGKEIT'];
            $k++;
            
            $rueck[0]['messdaten_check'] = 1;
        }       
    
    }
    
    
    ###### Allgemeine Definitionen; noch keine Auflistung der Arbeitsschritte! 
    ###### Die Merker für Rüst- und Anfahrzeit werden außerdem ins Array übernommen um die Auswertung zu erleichtern
    ## Falls Rüstzeit vorhanden: 
    if($or['NAME'] == 10 && $or['STATUS'] == 300){
        $merk_ruest = 1;
        $rueck[0]['merk_ruest'] = 1;
        $rueck[0]['ruestzeit_start'] = strtotime($or['MSTIME']);
    }
    else if($or['NAME'] == 10 && $or['STATUS'] == 500){
        $rueck[0]['ruestzeit_ende'] = strtotime($or['MSTIME']);
        $rueck[0]['ruestzeit'] = ($rueck[0]['ruestzeit_ende'] - $rueck[0]['ruestzeit_start']);
        $rueck[0]['gepl_ruestzeit'] = $pt['PTR']/3600;
        $rueck[0]['ruest_differenz'] = ($rueck[0]['ruestzeit'] - $rueck[0]['gepl_ruestzeit']);
        
        
    }
    
    ## Falls Anfahrzeit vorhanden: 
    if($or['NAME'] == 15 && $or['STATUS'] == 300 && $merk_anfahr == 0){
        $rueck[0]['anfahrzeit_start'] = strtotime($or['MSTIME']);
    }
    else if($or['NAME'] == 15 && $or['STATUS'] == 500 && $merk_anfahr == 0){
        $rueck[0]['anfahrzeit_ende'] = strtotime($or['MSTIME']);
        $rueck[0]['merk_anfahr'] = 1;
        $merk_anfahr = 1;
        $rueck[0]['anfahrzeit'] = ($rueck[0]['anfahrzeit_ende'] - $rueck[0]['anfahrzeit_start']);
        $rueck[0]['gepl_anfahrzeit'] = 3600;
        $rueck[0]['anfahr_differenz'] = ($rueck[0]['anfahrzeit'] - $rueck[0]['gepl_anfahrzeit']);
    }

    
   

    #### Ab hier Auflistung der Arbeitsschritte: (Ab Array(1)) 
    if($or['STATUS'] == 300){
        $rueck[$n]['startzeit'] = strtotime($or['MSTIME']);
        
        ## art muss hier schon definiert werden bei fehlenden 400//500 Einträgen
        $rueck[$n]['art'] = $or['NAME'];
      
    }
    else if($or['STATUS'] == 400 || $or['STATUS'] == 500){
        $rueck[$n]['endzeit'] = strtotime($or['MSTIME']);
        $rueck[$n]['laufzeit'] = ($rueck[$n]['endzeit'] - $rueck[$n]['startzeit']);
        $rueck[$n]['status'] = $or['STATUS'];
        $rueck[$n]['teile'] = $or['ADCCOUNT'];
        if($or['NAME'] == 20)
            $rueck[0]['teile_zaehler'] += $or['ADCCOUNT'];
            $rueck[0]['produktions_zeit'] += $rueck[$n]['laufzeit'];
        
        ### Streckendaten zuordnen (falls vorhanden)
        if($rueck[0]['messdaten_check']){
            foreach($rueck[1] as $slog){
                if($slog['zeit'] < $rueck[$n]['startzeit']){
                    $rueck[$n]['strecke_start'] = $slog['strecke'];
                }
                if($slog['zeit'] > $rueck[$n]['endzeit'] && $merk_strecke == 0){
                    $rueck[$n]['strecke_ende'] = $slog['strecke'];
                    $merk_strecke = 1;
                }
            }
            $merk_strecke = 0;
        }
        $n++;
    
    }
    
    
    $c++;
    ###########################
    #### Letzter Eintrag:. Die Dauer des Auftrags wird ohne die Rüstzeit berechnet, die Gesamtstrecke wird als Info hinzugefügt
    if($c==$i){
        
       
        
        if($merk_anfahr == 1){
            $rueck[0]['auftrag_gesamt_dauer'] = ($rueck[0]['auftrag_endzeit'] - $rueck[0]['anfahrzeit_start']);
        }
        else{
            $rueck[0]['auftrag_gesamt_dauer'] = ($rueck[0]['auftrag_endzeit'] - $rueck[0]['auftrag_startzeit']);
        }
        
        
        $rueck[0]['zeit_unterbrechnungen'] = ($rueck[0]['auftrag_gesamt_dauer'] - $rueck[0]['produktions_zeit']);
        $rueck[0]['auftrag_dauer_differenz'] = ($rueck[0]['auftrag_gesamt_dauer'] - $rueck[0]['zeit_unterbrechnungen'] - $rueck[0]['gepl_dauer']);
        
        
         ### Gesamt-Streckendaten zuordnen (falls vorhanden)
        if($rueck[0]['messdaten_check']){
            foreach($rueck[1] as $slog){
                if($slog['zeit'] <= $rueck[0]['auftrag_startzeit']){
                    $rueck[0]['mess_strecke_start'] = $slog['strecke'];
                }
                if($slog['zeit'] >= $rueck[0]['auftrag_endzeit'] && $merk_strecke == 0){
                    $rueck[0]['mess_strecke_ende'] = $slog['strecke'];
                    $merk_strecke = 1;
                }
            }
        
        $rueck[0]['mess_strecke_gesamt'] = ($rueck[0]['mess_strecke_ende'] - $rueck[0]['mess_strecke_start']);
        $rueck[0]['mess_ausschuss'] = ($rueck[0]['mess_strecke_gesamt'] - $rueck[0]['gesamt_laenge']);
        $rueck[0]['ausschuss_prozent'] = $rueck[0]['mess_strecke_gesamt'] / $rueck[0]['gesamt_laenge'];
        
        }
        
        ### Prüfen ob Streckendaten valide oder nicht 
        if($rueck[0]['mess_strecke_start'] < $rueck[0]['mess_strecke_ende'])
            $rueck[0]['mess_valide'] = 1;
        else    
            $rueck[0]['mess_valide'] = 0;
    
    
        $rueck[0]['n'] = $n;
        $rueck[0]['k'] = $k;
    
    }
    
}
    

    
    






return $rueck;






}

$daten = auftrag(13256);



echo "<h1>Auftragsauswertung: " . $daten[0]['auftrag'] . "</h1>";
echo "<br>";
echo "<b>Artikeldaten</b><br>";
echo "Werkzeug: " . $daten[0]['werkzeug'] . "<br>";
echo "Art.Nr.: " . $daten[0]['bezeichnung']. "<br>";
echo "Länge : " . $daten[0]['laenge'] . "mm<br>";
echo "<br><br>";
echo "<b>Auftragsdaten:</b> <br>";
echo "Auftragsmenge in Stück: " . $daten[0]['menge'] . "<br>";
echo "<br>";

echo "<table class='auswertung'>";
echo "<tr>";
echo "<td> Arbeitsgänge / Zeiten </td><td>SOLL</td><td>IST</td><td>Differenz:</td>";
echo "</tr>";
echo "<tr>";
echo "<td>Produktionsstart</td><td></td><td>".date("d.m.Y H:i:s", $daten[0]['auftrag_startzeit'])."</td><td></td>";
echo "</tr>";
echo "<tr>";
echo "<td>10 Rüsten</td><td>". (($daten[0]['merk_ruest']) ? $daten[0]['gepl_ruestzeit'] : '0') ."</td><td>". ($daten[0]['merk_ruest'] ? $daten[0]['ruestzeit'] : "0") ."</td><td>".$daten[0]['ruest_differenz']."</td>";
echo "</tr>";
echo "<tr>";
echo "<td>15 Anfahren</td><td>". (($daten[0]['merk_anfahr']) ? $daten[0]['gepl_anfahrzeit'] : '0') ."</td><td>". ($daten[0]['merk_anfahr'] ? $daten[0]['anfahrzeit'] : "0") ."</td><td>".$daten[0]['anfahr_differenz']."</td>";
echo "</tr>";
echo "<tr>";
echo "<td>20 Extrudieren, prüfen und verpacken</td><td>". $daten[0]['gepl_dauer'] ."</td><td>". $daten[0]['produktions_zeit'] ."</td><td></td>";
echo "</tr>";
echo "<tr>";
echo "<td>30 Abrüsten</td><td>". (($daten[0]['merk_ruest']) ? $daten[0]['gepl_ruestzeit'] : '0') ."</td><td>". ($daten[0]['merk_ruest'] ? $daten[0]['ruestzeit'] : "0") ."</td><td></td>";
echo "</tr>";
echo "<tr>";
echo "<td>GEPL: Dauer des Auftrags:</td><td>". $daten[0]['gepl_dauer']."</td><td>". $daten[0]['auftrag_gesamt_dauer'] ."</td><td></td>";
echo "</tr>";
echo "<tr>";
echo "<td>Unterbrechungen</td><td></td><td>".$daten[0]['zeit_unterbrechnungen']."</td><td></td>";
echo "</tr>";
echo "</table>";
echo "<br>";
echo "<b>Produktionsdaten</b><br>";
echo "Maschine: ".$daten[0]['linie']."<br>";
echo "Profilmeter: ". $daten[0]['gesamt_laenge'] . "m <br>";
echo "Ausschuss: 6%";



$j = 2;
$pre_endzeit = $daten[0]['auftrag_startzeit'];
$gesamt_dauer = $daten[0]['auftrag_gesamt_dauer'];
echo "<div class='graph'>";
while($j < $daten[0]['n']){
  
    // Abspeichern der Endzeit-Werte um die Unterbrechungsblöcke zu berechnen und anzuzeigen
    
    $proz_unt = 600 * ((($daten[$j]['startzeit'] -$pre_endzeit) / 3600) / $gesamt_dauer);
    
    $proz = 600 * ($daten[$j]['laufzeit'] / $gesamt_dauer);
    if($daten[$j]['art'] == 10){
        $beschr = 'ruest';
    }
    else if($daten[$j]['art'] == 15){
        $beschr = 'anfahr';
    }
    else if($daten[$j]['art'] == 20){
        $beschr = 'start';
    }  
    
    
    
    echo "<div class='unterbrechung abstand' style='height: ".$proz_unt."px'><z class='subs_l unterb' style='height: ".($proz_unt/2)."px'>Unterbrechung</z></div>";
    
    echo "<div class='".$beschr." abstand' style='height: ".$proz."px'> 
    <z class='subs_l' style='margin-top: ".($proz / 2)."px'><b>".$daten[$j]['art']."</b></z> " . 
    "<z class='subs' style='margin-top: ".$proz."px'>".date("d.m H:i", $daten[$j]['teile'])."Uhr <u><b>(".$daten[$j]['laufzeit']." Std</b></u>)    
    // Zurückgemeldete Teile: ".$daten[$j]['teile']."   ( ".$daten [$j]['art']."  )</z></div>";
    
    
    $pre_endzeit = $daten[$j]['endzeit'];
    $j++;
}  




echo "</div><br><br>";



echo "<pre>";
print_r($daten);
echo "</pre>";





?> 
