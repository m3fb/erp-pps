<?php
    use yii\bootstrap\ActiveForm;
    use app\models\Auswertung;
    $model = new Auswertung();
    
    
    
    
    ### Vergleichsfunktion, Toleranzen usw.: 
    function vergleich($ist,$soll){        
        $farbe = "";
        
        
        // 10% Toleranz:
        $soll_toleranz = $soll * 1.1;
        
        if($ist > $soll && $ist < $soll_toleranz){
            $farbe = "yellow";            
        }
        else if($ist > $soll_toleranz){
            $farbe = "red";
        }   
        else if($ist <= $soll){
            $farbe = "green";
        }    
        
        return $farbe;
    }
    
    
    
     
?>

<div class='daten'>
  <section class='eingabe'>
   <div class='eingabe_links'>
    <div class='orlg'>
  <?php $form = ActiveForm::begin(['id' => 'auswertung-form',
										
											 'method' => 'get',
											 'action' => ['']
											 ]); ?>
    <span class="input">
        <input name="input_lgnr" class="input__field input__field--yoko" type="text" id="input_lgnr" value=""/>
        <label class="input__label input__label--yoko" for="input_lgnr">
            <span class="input__label-content input__label-content--yoko">LG-Nr.</span>
        </label>
    </span>   
    <span class="input">
        <input name="input_orno" class="input__field input__field--yoko" type="text" id="input_orno" />
        <label class="input__label input__label--yoko" for="input_orno">
            <span class="input__label-content input__label-content--yoko">OrNo.</span>
        </label>
    </span>       
    <div id="rl">
    Erweiterte Optionen:<br>
    Vergleiche: <input type="checkbox"><br>
    Addiere: <input type="checkbox">
    </div>
  <br><button type="submit"  class="button button--winona button--border-thick button--round-l button--text-upper button--size-s button--text-medium" data-text="Bestätige" id="ausw_best"><span>Bestätige</span></button> 
       

<!-- Modal -->
<div class="modal fade" id="Auftragsmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Auftrag auswählen</h4>
      </div>
      <div class="modal-body">
        <div id="auftrag_auswahl"> </div>				
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Schließen</button>
        
      </div>
    </div>
  </div>
</div>

   <?php ActiveForm::end(); ?>
   </div>
   </div>
   
   <div class='eingabe_rechts'>
   <!-- <button data-toggle='modal' data-target='#Auftragsmodal'> here </button> -->
   
   <div class='werkart'>
    <span class="input">
        <input name="input_artnr" class="input__field input__field--yoko" type="text" id="input_artnr"/>
        <label class="input__label input__label--yoko" for="input_artnr">
            <span class="input__label-content input__label-content--yoko">Art.Nr.</span>
        </label>
    </span>
    <span class="input">
        <input name="input_werkzeug" class="input__field input__field--yoko" type="text" id="input_werkzeug" />
        <label class="input__label input__label--yoko" for="input_werkzeug">
            <span class="input__label-content input__label-content--yoko">WerkzeugNr.</span>
        </label>
    </span>
      <br>
    <span class="input">
        <input id="input_start" class='startneu input__field input__field--yoko' value='' >
            <label class="input__label input__label--yoko" for="input_orno">
            <span class="input__label-content input__label-content--yoko">Starttermin</span>
        </label>
    </span>
    <span class="input">
        <input id="input_ende" class='endeneu input__field input__field--yoko' value=''>
         <label class="input__label input__label--yoko" for="input_orno">
            <span class="input__label-content input__label-content--yoko">Endtermin</span>
        </label>
    </span>    
    
   <button class="button button--winona button--border-thick button--round-l button--text-upper button--size-s button--text-medium" data-text="Suchen" id="ausw_such"><span>Suchen</span></button> 
    
    
   </div>
   
   
   
   </div>
  </section>			
 
</div>

<?php
  

if($array = Yii::$app->getRequest()->getQueryParam('input_lgnr',NULL)){ // PERSNO aus Url auslesen (array) 
    $daten = $model->auftrag(0,$array,0);
    // 13520
}
else if($array = Yii::$app->getRequest()->getQueryParam('input_artnr',NULL)){
    $daten = $model->auftrag(0,0,$array);
}
else if($array = Yii::$app->getRequest()->getQueryParam('input_orno',NULL)){
    $array = $array . ".0";  ### 10.11.2017   - weiß der Geier warum der Scheiss nurnoch mit Floatzahlen funktioniert!
    $daten = $model->auftrag($array,0,0);
}
else {
    $daten[0] = 0; 
    $daten[1] = "Bitte Datensatz wählen";
}


//$daten = auftrag(13520);

if($daten[0] == 0)
    echo $daten[1];
else  {


echo "<h1>Auftragsauswertung: " . $daten[0]['auftrag'] . "</h1>";
?>
<div id="legende_auswertung"> 
<table>
<tr>
<td> ( Rüsten </td><td> <div class="punkte ruest"> </div></td>
<td> )( Anfahren </td><td> <div class="punkte anfahr"> </div></td>
<td> )( Produktion </td><td> <div class="punkte produktion"></div></td>
<td> )( Abrüsten </td><td> <div class="punkte abruest"></div></td>
<td> )( Unterbrechung </td><td> <div class="punkte unterbrechung"></div></td>
<td> )( Sonstige </td><td> <div class="punkte sonstige"></div></td>
<td> )( Fehler </td><td> <div class="punkte fehler"></div> </td>
<td> ) </td>

</tr>
</table>
</div>
<?php

$gesamt_dauer = $daten[0]['auftrag_gesamt_dauer_mrue'];
$laenge = 0;




### Horizontale Ansicht Auftragsverlauf
 if(!$daten[0] || !array_key_exists('2',$daten))
            echo $daten[1];
        else{
                       
            $gesamt_dauer = $daten[0]['auftrag_gesamt_dauer_mrue'];
            if($daten[0]['auftrag_status'] != 2)
                $gesamt_dauer = strtotime("now") - $daten[0]['auftrag_startzeit'];
            $laenge = 0;
            
       
              
              
        if(array_key_exists('2',$daten)){      
        ### Horzontaler Balken
        echo "<div class='balken'>";
        $farbe = "";
        $laenge = 0;
        $status = 0;
        $n = 0;
        $pre_endzeit = $daten[0]['auftrag_startzeit'];
        foreach($daten[2] as $wert){
            if(array_key_exists('art',$wert)){
                if($wert['art'] == 10)
                    $art = 'ruest';
                else if($wert['art'] == 15)
                    $art = 'anfahr';
                else if($wert['art'] == 20)
                    $art = 'produktion';
                else if($wert['art'] == 30)
                    $art = 'abruest';
            }
            else
                $art = 'fehler';
            
            // if(!array_key_exists('startzeit',$wert)){
                // $wert['startzeit'] = $wert['endzeit'] - 3600;
            // }
            if(!array_key_exists('laufzeit',$wert)){
                $wert['endzeit'] = strtotime("now");
                $wert['laufzeit'] = $wert['endzeit'] - $wert['startzeit'];
            }
            
            ### Länge des Eintrags für die Unterbrechung:
            $unt_laufzeit = round(($wert['startzeit'] - $pre_endzeit) / 3600,2);
            $laufzeit = round($wert['laufzeit'] / 3600,2);
            $laenge_unt = 100 * ($wert['startzeit']-$pre_endzeit) / $gesamt_dauer;
            $laenge = 100 *  $wert['laufzeit'] / $gesamt_dauer;
            
            
            
            $unt_start = "";
            $unt_ende = "";
            ### Anzeigen des Datums + Uhrzeit bei längeren Stillständen 
            if($laenge_unt > 5){
                $unt_start = "<div class='unt_top' >".date('d.m H:i',$pre_endzeit)."</div>";
                $unt_ende = "<div class='unt_sub' >".date('d.m H:i', $wert['startzeit'])."</div>";
            }
           
            echo "<div class='unterbrechung abschnitt' style='width: ".$laenge_unt."%;' data-startzeit='".date("d.m. H:i:s",$pre_endzeit)."' data-endzeit='".date("d.m H:i:s",$wert['startzeit'])."' data-laufzeit='".$unt_laufzeit."'>".$unt_start."</div>";
            echo "<div class='".$art." abschnitt' style='width: ".$laenge."%;' data-startzeit='".date("d.m. H:i:s",$wert['startzeit'])."' data-endzeit='".date("d.m H:i:s",$wert['endzeit'])."' data-laufzeit='".$laufzeit."'>".$unt_ende."</div>";

            $pre_endzeit = $wert['endzeit'];
            
            
            ### Falls $n am Ende $daten[0]['n'] entspricht spricht das dafür, dass der letzte Eintrag abgeschlossen und seitdem eine Unterbrechung herrscht. (Unterbrechung oder Stillstand) 
            $n++;            
            if(array_key_exists('status',$wert)){
                $status = $wert['status'];
            }
          
        }
        if($n==$daten[0]['n'] && $daten[0]['auftrag_status'] != 2){
            $laenge_unt = 100 * (strtotime("now")-$pre_endzeit) / $gesamt_dauer;
            echo "<div class='unterbrechung abschnitt' style='width: ".$laenge_unt."%;'  data-startzeit='".date("d.m. H:i:s",$pre_endzeit)."' data-endzeit='".date("d.m H:i:s",$wert['startzeit'])."' data-laufzeit='".$unt_laufzeit."'> </div>";
            
        }
        
        ### Gesamt Dauer: Bei unvolls
        
        // Ist der letzte Eintrag unvollständig (nur startzeit und art) so ist $n !== daten[n] und wird nicht erfasst (status egal)
        // Ist der letzte Eintrag vollständig und der Status wird erfasst, so wird ein div für eine Unterbrechung erstellt soweit der letzte Status eine Unterbrechung war (400) 
        // Die Gesamtlänge des Balkens wird prozentual bei einem 400er Eintrag (letzte) vom aktuellen Zeitpunkt berechnet. 
        
        
    echo "</div>";
        }
    } 





### Geschwindigkeitsverlauf Messdaten


$p = 0;
$filter = 1; ## Ein Filter wird benötigt da die Breite der Messwerte bei hohen Anzahlen falsch berechnet werden (css Problem)
echo "Geschwindigkeitsverlauf:";
if($daten[0]['messdaten_check']){
    $x = 333;  // Je höher die Zahl desto höher die Auflösung (u. Rechenlast) 
    while((!is_int($daten[0]['k'] / $x)) && $x < $daten[0]['k']){        
        $x++;
    }
    $zahl = $daten[0]['k'] / $x;
    $breite = 100 / $x;
    echo "<div class='balken'>";
    foreach($daten[1] as $wert){
        $p++;
        if($p == $zahl){
            $hoehe = $wert['geschwindigkeit'] * 4.5;
            
            echo "<div class='werte' style='height: ".$hoehe."px; width: ".$breite."%;' data-zeit='".(date('d.m H:i',$wert['zeit']))."' data-geschwindigkeit='".round($wert['geschwindigkeit'],2)."'> </div>";
            $p = 0;     
        }
        
    }
    echo "</div>";
}
else {
    echo "Keine Messdaten aufgezeichnet <br>"; 
}


if($daten[0]['mess_valide'] == 0){
    echo "<u>Die Messdaten sind nicht valide!</u>";
}


#### Auftragsdaten: 

$farbe_anfahr = '';
$farbe_ruest = '';
if($daten[0]['merk_anfahr']){
    $farbe_anfahr = vergleich($daten[0]['anfahrzeit'],$daten[0]['gepl_anfahrzeit']);
}
if($daten[0]['merk_ruest']){
    $farbe_ruest = vergleich($daten[0]['ruestzeit'],$daten[0]['gepl_ruestzeit']);
}
$farbe_produktion = vergleich($daten[0]['produktions_zeit'],$daten[0]['gepl_produktions_dauer']);
$farbe_ges = vergleich($daten[0]['auftrag_gesamt_dauer'],$daten[0]['gepl_gesamt_dauer']);




echo "<br><div class='daten'>";
echo "<b><u>Artikeldaten</u></b><br><br>";
echo "<table class='auflistung'>";
echo "<tr>";
echo "<th>Werkzeug: </th><td>" . $daten[0]['werkzeug'] . "</td>";
echo "</tr><tr>";
echo "<th>Art.Nr.: </th><td>" .$daten[0]['art_no']."</td>";
echo "</tr><tr>";
echo "<th>Bezeichnung: </th><td>" . $daten[0]['bezeichnung']. "</td>";
echo "</tr><tr>";
echo "<th>Länge: </th><td>" . $daten[0]['laenge'] . "mm</td>";
echo "</tr></table>";
echo "</div>";


echo "<div class='daten'>";
echo "<b><u>Auftragsdaten:</u></b> <br><br>";
echo "<table class='auflistung'>";
echo "<tr>";
echo "<th>Auftragsmenge in Stück: </th><td> " . $daten[0]['menge'] . "</td>";
echo "</tr>";
echo "<tr>";
echo "<th>Produktionsstand: </th><td>".$daten[0]['teile_zaehler'] . "</td>";
echo "<tr>";
echo "<th>Produktionsstart: </th><td>".date("d.m.Y H:i", $daten[0]['auftrag_startzeit'])."</td>";
echo "</tr>";
echo "<tr>";
echo "<th>Letzter Eintrag: </th><td>".date("d.m.Y H:i",$daten[0]['auftrag_endzeit'])."</td>";
echo "</tr>";
echo "</table>";



echo "<br>";

echo "<table class='auswertung'>";
echo "<tr>";
echo "<th> Arbeitsgänge / Zeiten </th><td>SOLL</td><td>IST</td><td>Differenz:</th>";
echo "</tr>";
echo "<tr>";
echo "<th>10 Rüsten</th><td>". (($daten[0]['merk_ruest']) ? round($daten[0]['gepl_ruestzeit']/3600,2) : '--') ." Std</td><td>". ($daten[0]['merk_ruest'] ? round($daten[0]['ruestzeit']/3600,2) : "--") ." Std</td><td bgcolor=".$farbe_ruest.">".($daten[0]['merk_ruest'] ? round($daten[0]['ruest_differenz']/3600,2) : '--') ." Std</td>";
echo "</tr>";
echo "<tr>";
echo "<th>15 Anfahren</th><td>". (($daten[0]['merk_anfahr']) ? round($daten[0]['gepl_anfahrzeit']/3600,2) : '--') ." Std</td><td>". ($daten[0]['merk_anfahr'] ? round($daten[0]['anfahrzeit']/3600,2) : "--") ." Std</td><td bgcolor=".$farbe_anfahr.">".($daten[0]['merk_anfahr'] ? round($daten[0]['anfahr_differenz']/3600,2) : '--') ." Std</td>";
echo "</tr>";
echo "<tr>";
echo "<th>20 Extrudieren, prüfen und verpacken</th><td>". round($daten[0]['gepl_produktions_dauer']/3600,2) ." Std</td><td>". round($daten[0]['produktions_zeit']/3600,2) ." Std</td><td bgcolor=".$farbe_produktion.">".round($daten[0]['produktions_zeit_differenz']/3600,2)." Std</td>";
echo "</tr>";
echo "<tr>";
echo "<th>30 Abrüsten</th><td>--</td><td>". ($daten[0]['merk_abruest'] ? round($daten[0]['abruestzeit']/3600,2) : "--") ." Std</td><td>--</td>";
echo "</tr>";
echo "<tr>";
echo "<th>Gepl. Dauer des Auftrags:</th><td>". round($daten[0]['gepl_gesamt_dauer']/3600,2)." Std</td><td>". round($daten[0]['auftrag_gesamt_dauer']/3600,2) ." Std</td><td bgcolor=".$farbe_ges.">".round($daten[0]['auftrag_dauer_differenz']/3600,2)." Std</td>";
echo "</tr>";
echo "<tr>";
echo "<th>Unterbrechungen</th><td>--</td><td>".round($daten[0]['zeit_unterbrechnungen']/3600,2)." Std</td><td>--</td>";
echo "</tr>";
echo "</table><br></div>";





echo "<div class='daten'>";
echo "<b><u>Produktionsdaten</u></b><br><br>";

echo "<table class='auswertung'>";
echo "<tr>";
echo "<th> Bezeichnung </th><td>SOLL</td><td>IST</td><td>Differenz:</th>";
echo "</tr>";
echo "<tr>";
echo "<th> Maschine </th><td> </td><td>".$daten[0]['linie']."</td><td>--</td>";
echo "</tr>";
echo "<tr>";
echo "<th> Profilmeter </th><td>".$daten[0]['gesamt_laenge']."m</td><td>".($daten[0]['messdaten_check'] ? round($daten[0]['mess_strecke_gesamt'],0) : '--') ."m</td><td>".($daten[0]['messdaten_check'] ? round($daten[0]['mess_ausschuss'],0) : '--') ."m</td>";
echo "</tr>";
echo "<tr>";
echo "<th> Ausschuss </th><td> 6% </td><td>".($daten[0]['messdaten_check'] ? round($daten[0]['ausschuss_prozent'],2) : '--') ."%</td><td>".($daten[0]['messdaten_check'] ? round(6-$daten[0]['ausschuss_prozent'],2) : '--') ."%</td>";
echo "</tr>";
echo "<tr>";
echo "<th>Ausschusskosten</th><td>0€</td><td> </td> <td> </td>";
echo "</tr>";
echo "<tr>";
echo "<th>Geschwindigkeit</th><td>".round($daten[0]['gepl_geschwindigkeit'],2)." m/min</td><td>".($daten[0]['messdaten_check'] ? round($daten[0]['vdurchschnitt'],2) : '--' )." m/min</td><td>".($daten[0]['messdaten_check'] ? round($daten[0]['vdifferenz'],2) : '--')." m/min</td>";
echo "</tr>";


echo "</table>";
echo "<br></div>";


echo "<br><br><br>";





### Detailierter Auftragsverlauf: 



###### Vorerst: Nur detailierte Ansicht wenn Auftrag als abgeschlossen markiert
if(!$daten[0] || !array_key_exists('2',$daten))
            echo $daten[1];
        else if($daten[0]['auftrag_status'] != 2){
            echo "Auftrag noch nicht abgeschlossen. Vorerst keine detailierte Ansicht möglich";
        }
        else {
$pre_endzeit = $daten[0]['auftrag_startzeit'];

$c = 0;

### TODO Höhe des Graphen evtl prozentual zur Auftragslänge o.Ä. generieren damit die Einträge im detailierten Verlauf noch lesbar bleiben
if($daten[0]['auftrag_gesamt_dauer_mrue'] > 300000){
    $hoehe_graph = 1200;
}
else{
    $hoehe_graph = 750;
}
$teile_mess = 0;
$gepl_zeit = 0;
$tat_zeit = 0;
$m = 0;   ### Überprüfung ob Messwerte in Aufzeichnung vorhanden
$n = 0;   ### Zeitaddierung bei 0Teile Rückmeldung 
$merk_zeit = 0;
$r = 0;
echo "Detailierter Auftragsverlauf: <br><br>";
echo "Auftrag Start: " . date("d.m.Y H:i",$daten[0]['auftrag_startzeit']) . "<br>";
echo "<div class='graph'>";

foreach($daten[2] as $wert){
    if($r)
        $r = 0;
    else
        $r = 1;
    ### Links Startzeit 
    ### Recht Endzeit 
        
        
    $proz_unt = $hoehe_graph * ((($wert['startzeit'] - $pre_endzeit)) / $gesamt_dauer);
    $proz = $hoehe_graph * ($wert['laufzeit'] / $gesamt_dauer);
      
    if($wert['art'] == 10)
        $art = 'ruest';
    else if($wert['art'] == 15)
        $art = 'anfahr';
    else if($wert['art'] == 20)
        $art = 'produktion';
    else if($wert['art'] == 30)
        $art = 'abruest';
    
    
    
    if (array_key_exists('strecke_start', $wert) && array_key_exists('strecke_ende',$wert)) {    
        $teile_mess = round(($wert['strecke_ende'] - $wert['strecke_start']) / ($daten[0]['laenge'] / 10),0);
        $m = 1; ### für die Ausgabe
    }

    
    $gepl_zeit = round(($wert['teile'] * $daten[0]['pte'] / 3600),2);
    $tat_zeit = round(($wert['endzeit'] - $wert['startzeit']) / 3600,2);
    
    if($n==1)
        $tat_zeit = ($tat_zeit + $merk_zeit);

    ### Merker für Zeitaddierung bei 0 Teile-Rückmeldung
    if($wert['teile'] <= 0){
        $merk_zeit = $tat_zeit;
        $n = 1;
    }
    else if($wert['teile'] > 0){
        $n = 0;
    }
        
    #### Div für Unterbrechungen
    echo "<div class='unterbrechung abstand' style='height: ".$proz_unt."px'>";
    echo ($proz_unt > 15 ? "<z class='subs_l unterb'>".(date("d.m: H:i",$pre_endzeit))." <div class='roter_punkt'> </div></z>" : '' )."</div>";
    
    ### Div für den Rest
    echo "<div class='".$art." abstand' style='height: ".$proz."px'>";
        echo "<z class='".($r ? 'subs_r' : 'subs_l')." unterb'>".(date("d.m: H:i",$wert['startzeit']))."<div class='gruener_punkt ".($r ? 'punkt_r' : '')."'> </div></z>";
        echo "<y class='".($r ? 'kasten_l' : 'kasten_r')."'style='height:".($proz-1)."px'> Zurückgemeldete Teile: ".$wert['teile']. ($m ? '<br>Gemessene Teile: '. $teile_mess .'<br>' : '<br>');
        echo "Gepl.Zeit: ".$gepl_zeit." Std <br> Tats.Zeit: ".$tat_zeit." Std</y>";
    echo"</div>";
    
    
    
  
    
    $pre_endzeit = $wert['endzeit'];
    $m = 0;
}

echo "</div>";
echo "Auftrag Ende: " . date("d.m.Y H:i",$daten[0]['auftrag_endzeit']);




echo "</div><br><br>";

        }

echo "<pre>";
print_r($daten);
echo "</pre>";




}
?> 
