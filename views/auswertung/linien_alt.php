

<?php 
    use app\models\Auswertung;
    $model = new Auswertung();

     
    // $tables = Yii::$app->db->createCommand(" 
    // SELECT TOP 1 * FROM LB_DC WHERE MSINFO LIKE 'Linie 03'  ORDER BY LBNO DESC 
    // ")
    // ->queryAll();
     
    // $orname = "";
    // $linie = "";
    // $orno = 0;
    // foreach($tables as $type){
        // $orname = $type['ORNAME'];
        // $linie = $type['MSINFO'];
        // $orno = $type['ORNO'];
    // }
    
       
    // $auftrag = Yii::$app->db->createCommand(" SELECT * FROM OR_ORDER WHERE NO LIKE '".$orno."' ")
    // ->queryAll();

    // $tables2 = Yii::$app->db->createCommand(" 
    // SELECT * FROM LB_DC WHERE ORNO =".$orno." AND NAME = 20")
    // ->queryAll();    
    
    
    // $op = Yii::$app->db->createCommand(" 
    // SELECT * FROM OR_OP WHERE ORNO = ".$orno."")
    // ->queryAll();
     
    
    
    // $n = 0;
    // $i = 0;
    // $gesamt_zeit = 0;
    // $gesamt_zahl = 0;
    // $stückzahl = 0;
    // $gesamt_dauer = 0;
    // $endtermin = 0;
    
    
    
    
    // foreach($op as $or){
        // $stückzahl = $or['PPARTS'];
        // $pte = $or['PTE'];
        // $ptr = $or['PTR'];
        // $gesamt_dauer = (($stückzahl * $pte) + $ptr) / 3600;  // in Stunden
        
       
    // }
    
    
    // foreach($tables2 as $rechne){$i++;}
    // foreach($tables2 as $rechne){
        // $n++;
        // if($n == 1){
           // $startzeitpunkt = strtotime($rechne['MSTIME']);
        // }
        // if($n == $i){
           // $endzeitpunkt = strtotime($rechne['MSTIME']);
           // $interval = $endzeitpunkt - $startzeitpunkt;  // Vergangene Zeit in Sekunden
           // $gesamt_zeit = round($interval/3600,2);
            
            
        // }
        
        // if($rechne['STATUS'] == 400 || $rechne['STATUS'] == 500){
            // $gesamt_zahl += $rechne['ADCCOUNT'];
        // }
        // if($rechne['STATUS'] == 500){
            // $endtermin = date("d.m.Y  H:i:s",strtotime($rechne['MSTIME']));
        // }
        // else if($rechne['STATUS'] == 400){
            // $endtermin = date("d.m.Y  H:i:s",strtotime($rechne['MSTIME'].'-' . $gesamt_dauer . ' hour'));
        // }
    // }
    
    


  
    
    
    
    
    
    // $auftrags_status = ""; 
    // $liefertermin = "";
    // foreach($auftrag as $auft){
        // if($auft['STATUS'] == 0){
            // $auftrags_status = "<x style='background-color:red;color:white;'>Nocht nicht gestartet</x>";
        // }
        // else if($auft['STATUS'] == 1){
            // $auftrags_status = "<x style='background-color:yellow;color:black;'>In Arbeit</x>";
        // }
        // else if($auft['STATUS'] == 2){
            // $auftrags_status = "<x style='background-color:green;color:white;'>Fertig</x>";
        // } 
            
        // $liefertermin = date("d.m.Y",strtotime($auft['DELIVERY'])); 
    // }
    
    
    
?>

 


<?php 
     
    $l = 0;
    while($l <= 14){
        $l++;
        if(strlen($l) == 1) {
            $l = "0$l";
        }
        echo "<div class='linie'>";
        $eintr = $model->linien($l);
        $i = 0;
        $n = 0;
        foreach($eintr as $erg){$i++;}
        foreach($eintr as $erg){
            $n++;
            if($n == $i){
                echo "<h2>".$erg['linie']."</h2>";
                echo "<h3>".$erg['orname'] . "</h3>";
                echo "<b>Auftragsstand: " . $erg['prozent'] . "%</b><br><br>";
                echo "WerkzeugNr.:" . $erg['werkzeug'] . "<br><br>";
                
                echo "Geplante Laufzeit: " . round($erg['gesamt_dauer'],2) . " Stunden <br>"; 
                echo "Bisherige Laufzeit: " . $erg['gesamt_zeit'] . "<br><br>";
                echo "Zu produzierende Menge: ". $erg['stückzahl'] ."<br>";
                echo "Bereits prodzierte Menge: ". $erg['gesamt_zahl']."<br><br>";
              
                
                echo "Auftrags-Status: " . $erg['auftrags_status'] . "<br>";
                echo "geplante Fertigstellung: ". $erg['liefertermin'] ."<br>";
                echo "Tag der Fertigstellung: ". $erg['endtermin'] . "<br>";
            }
        }
        echo "</div>";
    }

    
   
    ?>







