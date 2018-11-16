<?php 
    use app\models\Auswertung;
    $model = new Auswertung();     
?>


<br>
<br>
<br>
<br>
<br>
<br>
Prototyp Zeitachse für Gesamtdauer des Auftrags. Unterscheidung in einzelne Zeitabschnitte zur genauen Zuordnung von Datenpunkten:
<br>

<br><br><br><br><br><br>
<?php


echo "<div class='balken'>";   
         
    echo "<div class='werte_back' style='width: 4%;' data-zeit='' data-geschwindigkeit=''> <div class='werte' style='height: 6px; width: 100%;'> </div></div>";
    echo "<div class='werte_back' style='width: 4%;' data-zeit='' data-geschwindigkeit=''> <div class='werte' style='height: 3px; width: 100%;'> </div></div>";
       
echo "</div>";
        
?>

<?php

   // ### Horizontaler Balken
   
   // // Zu jeder Zeiteinheit gibt es einen Abschnitt im LB_DC- und im Geschwindigkeitsverlauf. Sollte einer von beiden Abschnitten nicht existieren, so ist dieser mit einem roten Fehlabstand markiert. 
   
   
   // // Zeiteinheiten pro Zeitstrahl: 
   // $aufloesung = 3600;
   // ### Evtl Einteilung ändern je nach Dauer des eigentlichen Auftrags
   
   
   // $zeiteinheit = $daten[0]['auftrag_gesamt_dauer_mrue'] / $aufloesung;
   
   // // Abfrage auf LB_DC Daten: 
   
   
   
   
   // // Zeitachse Gesamtdauer Auftrag
        // echo "<div class='balken_linien'>";
        // $farbe = "";
        // $laenge = 0;
        // $status = 0;
        // $n = 0;
        // $pre_endzeit = $daten[0]['startzeitpunkt_ts'];
        // foreach($daten[2] as $wert){
            // if(array_key_exists('art',$wert)){
                // if($wert['art'] == 10)
                    // $art = 'ruest';
                // else if($wert['art'] == 15)
                    // $art = 'anfahr';
                // else if($wert['art'] == 20)
                    // $art = 'produktion';
                // else if($wert['art'] == 30)
                    // $art = 'abruest';
            // }
            // else
                // $art = 'fehler';

            // // if(!array_key_exists('startzeit',$wert)){
                // // $wert['startzeit'] = $wert['endzeit'] - 3600;
            // // }
            
            // if(!array_key_exists('laufzeit',$wert)){
                // $wert['endzeit'] = strtotime("now");
                // $wert['laufzeit'] = $wert['endzeit'] - $wert['startzeit'];
            // }
            
            // ### Länge des Eintrags für die Unterbrechung:
            // $laenge_unt = 0;
            // if(!array_key_exists('startzeit',$wert)){
                // $wert['startzeit'] = $daten[0]['startzeitpunkt_ts'];
            // }
            // $zwischen = 100 * ($wert['startzeit']-$pre_endzeit) / $gesamt_dauer;
            // if($zwischen >= 0){
                // $laenge_unt = $zwischen;
            // }
            
            // $laenge = 100 *  $wert['laufzeit'] / $gesamt_dauer;
            
            // if($n == 0){
                // $laenge = 100 * ($wert['endzeit'] - $daten[0]['startzeitpunkt_ts']) / $gesamt_dauer;
            // }
            
            
            
            // $unt_start = "";
            // $unt_ende = "";
            // ### Anzeigen des Datums + Uhrzeit bei längeren Stillständen 
            // if($laenge_unt > 5){
                // $unt_start = "<div class='unt_top'>".date('d.m H:i',$pre_endzeit)."</div>";
                // $unt_ende = "<div class='unt_sub'>".date('d.m H:i', $wert['startzeit'])."</div>";
            // }
            
            // echo "<div class='unterbrechung abschnitt' style='width: ".$laenge_unt."%;'></div>";
            // echo "<div class='".$art." abschnitt' style='width: ".$laenge."%;'></div>";
            
            // $pre_endzeit = $wert['endzeit'];
            
            
            // ### Falls $n am Ende $daten[0]['n'] entspricht spricht das dafür, dass der letzte Eintrag abgeschlossen und seitdem eine Unterbrechung herrscht. (Unterbrechung oder Stillstand) 
            // $n++;            
            // if(array_key_exists('status',$wert)){
                // $status = $wert['status'];
            // }
          
        // }
       // // if($n==$daten[0]['n'] && $daten[0]['auftrag_status'] != 2){
        // $laenge_unt = 100 * (strtotime("now")-$pre_endzeit) / $gesamt_dauer;
        // echo "<div class='unterbrechung abschnitt' style='width: ".$laenge_unt."%;'> </div>";
            
       // // }
        
        // ### Gesamt Dauer: Bei unvolls
     
        // // Ist der letzte Eintrag unvollständig (nur startzeit und art) so ist $n !== daten[n] und wird nicht erfasst (status egal)
        // // Ist der letzte Eintrag vollständig und der Status wird erfasst, so wird ein div für eine Unterbrechung erstellt soweit der letzte Status eine Unterbrechung war (400) 
        // // Die Gesamtlänge des Balkens wird prozentual bei einem 400er Eintrag (letzte) vom aktuellen Zeitpunkt berechnet. 
        
        
        // echo "</div>";
        
        
        // // if($l == 1){
            // echo "<pre>";
            // print_r($daten);
            // echo "</pre>";
        // // }
        
        // // echo "<pre>";
        // // print_r($daten);
        // // echo "</pre>";
        // echo "  <input class='input_lgnr' name='input_lgnr' value='". $daten[0]['bezeichnung'] . "'> ";
    // echo "</div>";
    
     
     
    // ActiveForm::end(); 
    
   
    // echo "</li>";
    
    // echo "</ul>";
 
?>



<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<script src="jquery.js"></script>
<script src="auslies.js"></script> 
<button id='start_stop'>Start</button> <br>


Gemessene Strecke: 
<div id='test'> </div>



<?php 

// $trenn = array();
// $file = file_get_contents('http://192.168.1.180/entfernung.txt', FILE_USE_INCLUDE_PATH);
// $trenn = explode(' ! ',$file);
// $i = 0;
// $n = 0;
// // $k = 0;
// // $neu = array(); 
// // foreach($trenn as $tr){
    // // if($n !== 0){
    // // if($i == 1){
        // // $zw = explode(' ',$tr); 
        // // $u = 0;
        // // foreach($zw as $z){
            // // if($u == 0){
            // // $neu[$k][2] = $z;
            // // $u++;
            // // }
            // // else{
                // // $neu[$k][0] = $z;
                // // $neu[$k][1] = $merk;
            // // }
        // // }
        // // $i = 0;
        // // $k++;
    // // }
    // // else{
        // // $merk = $tr;
        // // $i = 1;   
    // // }
    // // }
    // // $n++;
// // }

// //print_r($trenn);
// $merk_zeit = 0;
// $merk_geschw = 0;
// foreach($trenn as $tr){
    // $i++;
    // echo " " . $tr . " ";
    
    // if($i == 4){
        // echo "<br>";
        // $i=0;
    // }
// }
?> 

 

