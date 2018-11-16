<?php 
use app\models\Auswertung;
$model = new Auswertung();

?>

<div id="techdiv">
<?php 



echo "<ul class='linien_liste'>";



 
    
    $linien = array();
    $linien[0] = "Linie 04"; 
    $linien[1] = "Linie 06"; 
    $linien[2] = "Linie 07";   
    $linien[3] = "Linie 08";
    $linien[4] = "Linie 10";
    $linien[5] = "Linie 13";
    #$linien[5] = "Linie 04";
     
    foreach($linien as $linie){
        $daten = $model->linien2($linie);
  
        $rand = '';
        if($daten[0]['v_akut'] > 0)
            $rand = 'green';
        else 
            $rand = 'red';
        
        echo "<li><div class='linie'  style='border-color: ".$rand."'>";   
  
    
    $p = 0;
    $filter = 1; ## Ein Filter wird benötigt da die Breite der Messwerte bei hohen Anzahlen falsch berechnet werden (css Problem)
    echo "<b>".$linie.":</b>";
    if($daten[0]['messdaten_check']){
        $x = 180;  // Je höher die Zahl desto höher die Auflösung (u. Rechenlast) 
        while((!is_int($daten[0]['k'] / $x)) && $x < $daten[0]['k']){        
            $x++;
        }
        $zahl = $daten[0]['k'] / $x;
        $breite = 100 / $x;
        echo "<div class='balken'>";
        foreach($daten[1] as $wert){            
            $p++;
            if($p == $zahl){
                $farbe = "";
                $ag = "";
                $unt = "";
                if($wert['arbeitsschritt'] == 0){
                    $farbe = "black";
                    $ag = "nicht definiert";
                }
                else if($wert['arbeitsschritt'] == 5){
                    $farbe = "red";
                    $ag = "Unterbrechung";
                }
                else if($wert['arbeitsschritt'] == 10){
                    $farbe = "yellow";
                    $ag = "Rüsten";
                }
                else if($wert['arbeitsschritt'] == 15){
                    $farbe = "blue";
                    $ag = "Anfahren";
                }
                else if($wert['arbeitsschritt'] == 20){
                    $farbe = "green";
                    $ag = "Produktion";
                }
                else if($wert['arbeitsschritt'] == 40){
                    $farbe = "orange";
                    $ag = "Abrüsten";
                }
                
                
                
                
                
                
                
                
                $zeit = date('d.m H:i',$wert['zeit']);
                $hoehe = $wert['geschwindigkeit'] * 6; 
                
                echo "<div class='werte_backlinien werte-back-tooltip' style='width: ".$breite."%; background-image: linear-gradient(".$farbe.", black);' data-zeit='".$zeit."' data-arbeitsschritt='".$ag."' data-unt='".$wert['unt_grund']."'>";
                echo    "<div class='wertelinien werte-tooltip' style='height: ".$hoehe."px;' data-zeit='".$zeit."' data-geschwindigkeit='".round($wert['geschwindigkeit'],2)."'> </div></div>";
                $p = 0;     
            }
            
        }
        echo "</div>";
        
        echo "aktuelle Geschwindigkeit: <b>" . $daten[0]['v_akut'] . " m/min </b><br>";
        echo "aktuelle Unterbrechungsmeldung: <b>" . ($daten[0]['unt_akut'] ? $daten[0]['unt_akut'] : " -- ") ."</b><br>";
        echo "aktives Werkzeug: <b>" . $daten[0]['werkzeug'] . " </b>";
        
        
    }
    else {
        echo "Keine Messdaten aufgezeichnet <br>"; 
    }
    
    echo "<br><br><br><br><br>";
    
    echo "</div> </li>";
    }
    


echo "</ul>";
?>





</div> 