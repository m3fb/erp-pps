<?php 
use app\models\Auswertung;
$model = new Auswertung();


$this->registerJsFile(
    '@web/linien.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);



?>
 <div class="col-md-14">
<?php 



echo "<ul class='linien_liste'>";



 
    
    $linien = array();
    $linien[0] = "Linie 02";
    $linien[1] = "Linie 04"; 
    $linien[2] = "Linie 06"; 
    $linien[3] = "Linie 07";   
    $linien[4] = "Linie 08";
    $linien[5] = "Linie 10";
    $linien[6] = "Linie 13";
 
     
    foreach($linien as $linie){
        $daten = $model->linien2($linie);
  
        $rand = '';
        if($daten[0]['v_akut'] > 0)
            $rand = 'green';
        else 
            $rand = 'red';
        
        echo "<li><div id='".$daten[0]['linie']."' class='linie'  style='border-color: ".$rand."'>";   
  
    
    $p = 0;
    $filter = 1; ## Ein Filter wird benötigt da die Breite der Messwerte bei hohen Anzahlen falsch berechnet werden (css Problem)
    echo "<b>".$linie.":</b> <i>(<span class='".$daten[0]['linie']."-auftrag'> </span>)</i>";
    if($daten[0]['messdaten_check']){
        $x = 180;  // Je höher die Zahl desto höher die Auflösung (u. Rechenlast) 
        while((!is_int($daten[0]['k'] / $x)) && $x < $daten[0]['k']){        
            $x++;
        }
        $zahl = $daten[0]['k'] / $x;
        $breite = 100 / $x;
        echo "<div class='balken ".$daten[0]['linie']."'>";
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
                $hoehe = $wert['geschwindigkeit'] * 3; 
                
                echo "<div class='werte_backlinien werte-back-tooltip' style='width: ".$breite."%; background-image: linear-gradient(".$farbe.", black);' data-zeit='".$zeit."' data-arbeitsschritt='".$ag."' data-unt='".$wert['unt_grund']."'>";
                echo    "<div class='wertelinien werte-tooltip' style='height: ".$hoehe."px;' data-zeit='".$zeit."' data-geschwindigkeit='".round($wert['geschwindigkeit'],2)."'> </div></div>";
                $p = 0;      
            }
            
        }
        echo "</div>";
        
        echo "aktuelle Geschwindigkeit: <b><span class='".$daten[0]['linie']."-v'> </span></b><br>";
        echo "aktuelle Unterbrechungsmeldung: <b><span class='".$daten[0]['linie']."-unt'> </span></b><br>";
        echo "aktives Werkzeug: <b>" . $daten[0]['werkzeug'] . " </b><br>";
        echo "Zeitplan: <b><span class='".$daten[0]['linie']."-t'> </span></b> /  Menge: <b><span class='".$daten[0]['linie']."-m'> </span></b>";
    
        echo "<div class='progress'>";
        echo "<div class='progress-bar progress-bar-success ".$daten[0]['linie']."-progress' role='progressbar' aria-valuenow='15' aria-valuemin='0' aria-valuemax='100' style='width: 0%'>";
          echo "<div class='".$daten[0]['linie']."-strecke'> </div>";
        echo "</div>";
        echo "</div>";
        echo "<div class='".$daten[0]['linie']."-fehler'> </div>";
    }
    else {
        echo "Keine Messdaten aufgezeichnet <br>"; 
    }
    
    echo "";
    
    echo "</div> </li>";
    }
    


echo "</ul>"; 
?>





</div> 
<br>