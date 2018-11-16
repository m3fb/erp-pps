<?php 
    use app\models\Auswertung;
    $model = new Auswertung();
    use yii\bootstrap\ActiveForm;
    use app\assets\AppAsset;

    AppAsset::register($this);
?>

 

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
     // 0 
    $l = 0;    
    echo "<ul class='linien_liste'>";
    while($l < 14){
        echo "<li>";
        $form = ActiveForm::begin(['id' => 'auswertung-form',
                                   'method' => 'post',
                                   'action' => ['']
								  ]); 
                                             
                                                                                      
        $l++;
        if(strlen($l) == 1) {
            $l = "0$l";
        }
       
        echo "<div class='linie'>";  
        $daten = $model->linien($l);
     
     
        ## 24h 
        $gesamt_dauer = 24 * 3600;
          
        echo "<button type='submit' class='button btn_linie button--winona button--border-thick button--round-l button--text-upper button--size-s button--text-medium' data-text='Linie ".$l."'><span>Linie ".$l."</span></button>";   
       
        echo "<br><br>Werkzeug: " . $daten[0]['werkzeug'] . " || Länge: " . $daten[0]['laenge'] . "mm";
        if(array_key_exists('1',$daten)){
            $letzt = end($daten[1]);
            echo "<input value='".round($letzt['GESCHWINDIGKEIT'],2) . "m/min'>";
        }
        
        echo "<div class='balken_linien'>";
        if($daten[0]['fehler'] == 0){
            foreach($daten[2] as $wert){
                
                // if(!array_key_exists('endzeit',$wert))
                    // $wert['endzeit'] = 0;
                // if(!array_key_exists('startzeit',$wert))
                   // $wert['startzeit'] = 0;
               // if(!array_key_exists('art',$wert))
                    // $wert['art'] = "fehler";
                $laufzeit = $wert['endzeit'] - $wert['startzeit']; 
                $laenge = ($laufzeit / $gesamt_dauer) * 100;
                $data_laufzeit = round($laufzeit / 3600,2);
                
                echo "<div class='".$wert['art']." abschnitt' style='width: ".$laenge."%;' data-art='".$wert['art']."' data-startzeit='".date("H:i:s",$wert['startzeit'])."' data-endzeit='".date("H:i:s",$wert['endzeit'])."' data-laufzeit='".$data_laufzeit."'></div>";
         
         
         
            }
        }
        else {
            echo $daten[0]['fehlermeldung'];
        }
        echo "</div>";
        echo "</div>";
    
        echo "  <input class='input_lgnr' name='input_lgnr' value='". $daten[0]['bezeichnung'] . "'> ";
      
     
    
    ActiveForm::end(); 
    echo "<button  class='button btn_verlauf button--winona button--border-thick button--round-l button--text-upper button--size-s button--text-medium' data-linie='Linie ".$l."' data-text='Verlauf'><span>Verlauf</span></button>";           
   
    echo "</li>";
    }
    echo "</ul>";

    // echo "<pre>";
    // print_r($daten);
    // echo "</pre>";
       
      
  
?>





<?php 
    /*   
        echo "<button type='submit' class='button button--winona button--border-thick button--round-l button--text-upper button--size-s button--text-medium' data-text='Linie ".$l."'><span>Linie ".$l."</span></button>";
        
        // if(!$daten[0] || !array_key_exists('2',$daten))
            // echo $daten[1];
        // else{
            
           
            if(array_key_exists('1',$daten)){
                $letzt = end($daten[1]);
                echo "<input value='".round($letzt['geschwindigkeit'],2) . "m/min'>";
            }
            
            //$gesamt_dauer = $daten[0]['auftrag_gesamt_dauer_mrue'];
            $gesamt_dauer = 3600*24;
            // if($daten[0]['auftrag_status'] != 2)
                // $gesamt_dauer = strtotime("now") - $daten[0]['auftrag_startzeit'];
            $laenge = 0;
            
       
              
              
        if(array_key_exists('2',$daten)){      
        ### Horizontaler Balken
        echo "<div class='balken_linien'>";
    
      $farbe = "";
        $laenge = 0;
        $status = 0;
        $n = 0;
        $pre_endzeit = $daten[0]['startzeitpunkt_ts'];
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
                else 
                    $art = 'fehler';
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
            $laenge_unt = 0;
            if(!array_key_exists('startzeit',$wert)){
                $wert['startzeit'] = $daten[0]['startzeitpunkt_ts'];
            }
            $zwischen = 100 * ($wert['startzeit']-$pre_endzeit) / $gesamt_dauer;
            if($zwischen >= 0){
                $laenge_unt = $zwischen;
            }
            
            $laenge = 100 *  $wert['laufzeit'] / $gesamt_dauer;
            
            if($n == 0){
                $laenge = 100 * ($wert['endzeit'] - $daten[0]['startzeitpunkt_ts']) / $gesamt_dauer;
            }
            
            
            
            
            $unt_start = "";
            $unt_ende = "";
            ### Anzeigen des Datums + Uhrzeit bei längeren Stillständen 
            if($laenge_unt > 5){
                $unt_start = "<div class='unt_top'>".date('d.m H:i',$pre_endzeit)."</div>";
                $unt_ende = "<div class='unt_sub'>".date('d.m H:i', $wert['startzeit'])."</div>";
            }
            
            echo "<div class='unterbrechung abschnitt' style='width: ".$laenge_unt."%;'></div>";
            echo "<div class='".$art." abschnitt' style='width: ".$laenge."%;'></div>";
            
            $pre_endzeit = $wert['endzeit'];
            
            
            ### Falls $n am Ende $daten[0]['n'] entspricht spricht das dafür, dass der letzte Eintrag abgeschlossen und seitdem eine Unterbrechung herrscht. (Unterbrechung oder Stillstand) 
            $n++;            
            if(array_key_exists('status',$wert)){
                $status = $wert['status'];
            }
          
        }
       // if($n==$daten[0]['n'] && $daten[0]['auftrag_status'] != 2){
            $laenge_unt = 100 * (strtotime("now")-$pre_endzeit) / $gesamt_dauer;
            echo "<div class='unterbrechung abschnitt' style='width: ".$laenge_unt."%;'> </div>";
            
       // }
        
        ### Gesamt Dauer: Bei unvolls
        #óòÓÒôÔoOöÖQ
        #úùÚÙûÛuUüÜµ
        // Ist der letzte Eintrag unvollständig (nur startzeit und art) so ist $n !== daten[n] und wird nicht erfasst (status egal)
        // Ist der letzte Eintrag vollständig und der Status wird erfasst, so wird ein div für eine Unterbrechung erstellt soweit der letzte Status eine Unterbrechung war (400) 
        // Die Gesamtlänge des Balkens wird prozentual bei einem 400er Eintrag (letzte) vom aktuellen Zeitpunkt berechnet. 
        
        
        echo "</div>";
        }
        
        // if($l == 1){
            echo "<pre>";
            print_r($daten);
            echo "</pre>";  
        // }
        
        // echo "<pre>";
        // print_r($daten);
        // echo "</pre>";
        echo "  <input class='input_lgnr' name='input_lgnr' value='". $daten[0]['bezeichnung'] . "'> ";
        
        */
        
        
?>




