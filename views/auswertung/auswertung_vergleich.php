<?php 

function vergleich($daten,$daten2){
        
    if($daten[0]['fehler']){
        foreach($daten[0]['fehlermeldungen'] as $fehler){
            echo $fehler;
        }
    }
    else if($daten2[0]['fehler']){
         foreach($daten[0]['fehlermeldungen'] as $fehler){
            echo $fehler;
        }
    }
    else{


    ### Vergleichsfunktionen: Zeitverläufe untereinander? Sinnvoll? (Ressourcen!!!) 
    ### Strahl mit Anteilen von Produktion / Anfahren / Rüsten untereinander zur direkten Vergleichbarkeit
    
    
     


    $p = 0;
    $filter = 1; ## Ein Filter wird benötigt da die Breite der Messwerte bei hohen Anzahlen falsch berechnet werden (css Problem)
    echo "Zeitverlauf:";
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
                
                echo "<div class='werte_back' style='width: ".$breite."%; background-image: linear-gradient(".$farbe.", black);' data-zeit='".$zeit."' data-arbeitsschritt='".$ag."' data-unt='".$wert['unt_grund']."'>";
                echo    "<div class='werte' style='height: ".$hoehe."px;' data-zeit='".$zeit."' data-geschwindigkeit='".round($wert['geschwindigkeit'],2)."'> </div></div>";
                $p = 0;     
            }
            
        }
        echo "</div>";
    }
    else {
        echo "Keine Messdaten aufgezeichnet <br>"; 
    }
    
    
    
    ?>
    
    
<div class="daten">
<table class="vergleich">
<tr>
<th> Arbeitsgänge </th>
<td> <b>Zeitraum 1</b> <br> <i><?php echo date("d.m.Y",$daten[0]['auswertung_startzeit']) . " - " . date("d.m.Y",$daten[0]['auswertung_endzeit']);?></i><br>SOLL/IST</td>
<td> <br><br>IST </td>
<td> <br><br>Differenz </td>
</tr>
<tr>
<th> Rüsten </th>
<td><?php echo $daten[0]['gepl_ruestzeit'] . "/" . $daten[0]['ruestzeit'];?>Std</td>
<td class="bg-<?php echo sollist($daten[0]['gepl_ruestzeit'],$daten[0]['ruestzeit']);?>"><?php echo $daten[0]['ruestzeit_differenz'];?> Std</td>
<td>///// PUFFERZONE /////</td>
<td><?php echo $daten2[0]['gepl_ruestzeit'] . "/" . $daten2[0]['ruestzeit'];?>Std</td>
<td class="bg-<?php echo sollist($daten2[0]['gepl_ruestzeit'],$daten[0]['ruestzeit']);?>"><?php echo $daten[0]['ruestzeit_differenz'];?> Std</td>
</tr>
<tr>
<th> Anfahren </th>
<td> <?php echo $daten[0]['gepl_anfahrzeit'];?>Std</td>
<td> <?php echo $daten[0]['anfahrzeit'];?>Std</td>
<td class="bg-<?php echo sollist($daten[0]['gepl_anfahrzeit'], $daten[0]['anfahrzeit']);?>"><?php echo  $daten[0]['anfahrzeit_differenz'];?>Std</td>
</tr>
<tr>
<th> Produktion </th>
<td> <?php echo $daten[0]['gepl_produktions_dauer'];?>Std</td>
<td> <?php echo $daten[0]['produktion_stunden'];?>Std</td>
<td class="bg-<?php echo sollist($daten[0]['gepl_produktions_dauer'],$daten[0]['produktion_stunden']);?>"><?php echo $daten[0]['produktion_zeit_differenz'];?>Std</td>
</tr>
<tr>
<th> Unterbrechungen </th>
<td> -- </td>
<td> <?php echo $daten[0]['unterbrechungen_stunden'];; ?> Std</td>
<td></td>
</tr>
<tr>
<th> Gepl Zeit / Zeitdifferenz </th>
<td> <?php echo $daten[0]['gepl_gesamt_dauer']; ?>Std</td>
<td> <?php echo $daten[0]['gesamt_dauer']; ?>Std </td>
<td class="bg-<?php echo sollist($daten[0]['gepl_gesamt_dauer'],$daten[0]['gesamt_dauer']);?>"> <?php echo $daten[0]['gesamt_dauer_differenz'];?>Std </td>
</tr>
<tr><td>_</td>
</tr>
<tr>
<th> Produktionsdaten </th>
</tr>
<tr>
<th> Ausschuss </th>
<td> max. 6%</td>
<td> <?php echo $daten[0]['ausschuss_prozent']; ?>%</td>
<td class="bg-<?php echo sollist(6,$daten[0]['ausschuss_prozent']);?>"><?php echo $daten[0]['ausschuss_prozent_differenz'];?>%</td>
</tr>
<tr>
<th> Profilmeter </th>
<td> <?php echo $daten[0]['gesamt_laenge'];?> m </td>
<td> <?php echo $daten[0]['mess_strecke_gesamt'];?> m </td>
<td class="bg-<?php echo sollist($daten[0]['gesamt_laenge'],$daten[0]['mess_strecke_gesamt']);?>"> <?php echo $daten[0]['ausschuss'];?> m  </td>
</tr>
<tr> 
<th> Ø Geschwindigkeit </th>
<td> <?php echo $daten[0]['gepl_vdurchschnitt']; ?> m/min </td>
<td> <?php echo $daten[0]['vdurchschnitt']; ?> m/min</td>
<td class="bg-<?php echo sollist($daten[0]['vdurchschnitt'],$daten[0]['gepl_vdurchschnitt']);?>"> <?php echo $daten[0]['vdurchschnitt_differenz']; ?> m/min </td>
</tr>
<tr>
<th> Linie </th>
<td> </td>

</tr><!--
<tr> 
<th> Ausschusskosten </th>
<td> -- € </td>

</tr>-->
<tr><td>_</td>
</tr>
<tr>
<th> Unterbrechungsgründe: </th>
</tr>
<tr>
<th> Geplante Unterbrechung </th>
<td> </td>
<td>  <?php echo $daten[0]['zeit_unt100']; ?>Std</td>
<td> <?php echo $daten[0]['prozent_unt100']; ?>%</td>%</td>
</tr>
<tr>
<th> Abriss </th>
<td> </td>
<td> <?php echo $daten[0]['zeit_unt101']; ?>Std</td>
<td> <?php echo $daten[0]['prozent_unt101']; ?>%</td>%</td>
</tr>
<tr>
<th> Sensor defekt </th>
<td> </td>
<td> <?php echo $daten[0]['zeit_unt102']; ?>Std</td>
<td> <?php echo $daten[0]['prozent_unt102']; ?>%</td>%</td>
</tr>
<tr>
<th> Qualitätsproblem </th>
<td> </td>
<td> <?php echo $daten[0]['zeit_unt103']; ?>Std</td>
<td> <?php echo $daten[0]['prozent_unt103']; ?>%</td>%</td>
</tr>
<tr>
<th> Bedienpersonal </th>
<td> </td>
<td> <?php echo $daten[0]['zeit_unt104']; ?>Std</td>
<td> <?php echo $daten[0]['prozent_unt104']; ?>%</td>%</td>
</tr>
<tr>
<th> Wartung / Reinigung </th>
<td> </td>
<td> <?php echo $daten[0]['zeit_unt105']; ?>Std</td>
<td> <?php echo $daten[0]['prozent_unt105']; ?>%</td>
</tr>


</table> <br> <br> 



<?php 
echo "<i><b>Ausgewertete (Teil-)Aufträge:</b> <br>";
foreach($daten[0]['auftraege'] as $auftrag){
    echo $auftrag['auftrag'] . " (".date("d.m.Y",$auftrag['auftrag_startzeit'])." - ".date("d.m.Y",$auftrag['auftrag_endzeit']).") (".$auftrag['orno'].")<br>";
    echo $auftrag['bezeichnung'] ."<br><br>";
}
echo "</i><br><br>";

echo "Fehlermeldungen: <br>";
foreach($daten[0]['fehlermeldungen'] as $fehler){
        echo $fehler . "<br>";
}
?>
</div>
<?php


   







    echo "<pre>";
    print_r($daten);
    echo "</pre>";
    
    
    ## If Fehlerbedingung wird hier geschlossen (Anfang)
    }
}
?>