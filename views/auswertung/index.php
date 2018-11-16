<?php
/* @var $this yii\web\View */
    use app\models\Auswertung;
    use yii\helpers\Html;
    use kartik\widgets\ActiveForm;
    use kartik\field\FieldRange;
    use kartik\builder\Form;
    $model = new Auswertung();

?>


<!--
<div class="ausw_input">
Start: 
Ende: <br>
<input id="ausw_start" class='startneu ausw_inputs' value='' >
<input id="ausw_ende" class='endeneu ausw_inputs' value=''><br>
<input id="auftragsnr" value="Auftrag" class='ausw_inputs'>
<input id="werkzeugnr" value="Werkzeug" class='ausw_inputs'>
<input id="liniennr" value="Linie" class='ausw_inputs'><br>

<button id="ausw_best">Bestätige</button>
</div>
-->





<?php $form = ActiveForm::begin(['id' => 'auftrag-form',
                            
                                 'method' => 'get',
                                 'action' => ['']
                                 ]); ?>
<?= $form->field($model, 'auftragsnr')->textInput()->label('Auftragsnr:') ?>
<?= Html::submitButton('Bestätige', ['class'=> 'btn btn-primary']) ;?>
<?php ActiveForm::end(); ?>






<?php 
### Infos zum Auftrag: 
### Wieviel soll produziert werden? 
### In welcher geplanten Zeit? 
### Wann Lieferdatum? 
### Restzeit zum Lieferdatum verbleibend (...-> Kalkulation mit geplanter Produktionszeit -> Dringlichkeit berechnen) 
### Wieviel bereits produziert? (Zwischenstand) 
### Verbleibende zu produzierende Teile + geplante Zeit dafür
### Liefertermin haltbar? 
### Gesamtzahl Meter 
### Zeit vergangen (Zwischenstände zwischen einzelnen Rückmeldungen -> Durchschnittszeit berechnen -> + / - vom Durchschnitt / bzw geplanter Dauer pro Stück) 
// $auftragsnr = "LG-12037-01-001";


if($array = Yii::$app->getRequest()->getQueryParam('Auswertung',NULL)){ // PERSNO aus Url auslesen (array) 
    $zahl = array_keys($array);
    $auftragsnr = $array[$zahl[0]]; 






$auftrag = Yii::$app->db->createCommand(" SELECT * FROM OR_ORDER WHERE NAME LIKE '".$auftragsnr."' ")
->queryAll();

$tables = Yii::$app->db->createCommand(" 
SELECT * FROM LB_DC WHERE ORNAME LIKE '".$auftragsnr."' ")
->queryAll();

$gesamt_zeit = 0;
$gesamt_zahl = 0;
$endtermin = "--";
$n = 0;
$i = 0;
foreach ($tables as $rechne){$i++;}
foreach ($tables as $rechne){
    $n++;
    if($n == 1){
        $startzeitpunkt = strtotime($rechne['MSTIME']);
    }
    if($n == $i){
       $endzeitpunkt = strtotime($rechne['MSTIME']);
       $interval = $endzeitpunkt - $startzeitpunkt;  // Vergangene Zeit in Sekunden
       $gesamt_zeit = round($interval/3600,2);
        
        
    }
    
    if($rechne['STATUS'] == 400 || $rechne['STATUS'] == 500){
        $gesamt_zahl += $rechne['ADCCOUNT'];
    }
    if($rechne['STATUS'] == 500){
        $endtermin = date("d.m.Y  H:i:s",strtotime($rechne['MSTIME']));
    }
    
}
foreach($auftrag as $auft){
    echo "<h1>" . $auft['NAME'] . "</h1>";
    echo $auft['DESCR']. "<br><br>";
    $orno = $auft['NO'];
    if($auft['STATUS'] == 0){
        $auftrags_status = "<x style='background-color:red;color:white;'>Nocht nicht gestartet</x>";
    }                 
    else if($auft['STATUS'] == 1){
        $auftrags_status = "<x style='background-color:yellow;color:black;'>In Arbeit</x>";
    }
    else if($auft['STATUS'] == 2){
        $auftrags_status = "<x style='background-color:green;color:white;'>Fertig</x>";
    }
    
    
    echo "Auftrags-Status: " . $auftrags_status . "<br>";
    echo "geplanter Liefertermin: ". date("d.m.Y",strtotime($auft['DELIVERY'])) . "<br>"; 
    echo "Tag der Fertigstellung: ". $endtermin . "<br>";
   
    
     

}

$op = Yii::$app->db->createCommand(" 
SELECT * FROM OR_OP WHERE ORNO = ".$orno."")
->queryAll();

foreach($op as $or){
    $stückzahl = $or['PPARTS'];
    $pte = $or['PTE'];
    $ptr = $or['PTR'];
    $gesamt_dauer = (($stückzahl * $pte) + $ptr) / 3600;  // in Stunden
    
    echo "Geplante Laufzeit: " . $gesamt_dauer . " Stunden <br>"; 
    echo "Tatsächliche Laufzeit: " . $gesamt_zeit . "<br>";
    echo "Zu produzierende Menge: ". $stückzahl ."<br>";
    echo "Bereits prodzierte Menge: ". $gesamt_zahl."<br>";
}

echo "<br>";
echo "<br>";


$merk_start = 0;

echo "<u>Auftrags-Verlauf</u> <br>"; 
echo "<table class='auswertung'>";
echo "<tr><td>Status</td><td>Zeitpunkt</td><td>Zurückgemeldet</td><td>Linie</td><td>Personal</td><td>Laufzeit</td></tr>";
foreach($tables as $type){
   $laufzeit = 0;
   $gepl = 0;

   if($type['STATUS'] == 300){
       $status = "Start";
   }
   else if ($type['STATUS'] == 400){
       $status = "Unterbrechung";
   }
   else if ($type['STATUS'] == 500){
       $status = "Ende";
   }
     
   if($merk_start==0 && $type['STATUS'] == 300){
       $startzeit = $type['MSTIME'];
       $merk_start = 1;
   }
   if($merk_start==1 && ($type['STATUS'] == 400 || $type['STATUS'] == 500) && $type['ADCCOUNT'] != 0){
       $datetime1 = new DateTime($startzeit);
       $datetime2 = new DateTime($type['MSTIME']);
       $interval = $datetime1->diff($datetime2);
       $laufzeit = $interval->format('%d Tage %h Std %i Min');
       $merk_start = 0; 
       $gepl = $type['ADCCOUNT'] / $pte; 
       $gepl = (int)($gesamt_dauer * 60 / $stückzahl * $type['ADCCOUNT']);
        
        
       $now = date_create('now', new DateTimeZone('GMT'));
       $here = clone $now;
       $here->modify($gepl.' minutes');
       $gepl = $now->diff($here);
       $gepl = $gepl->format('%d Tage %h Std %i Min');  
   }
   
   
   
    echo "<tr>";
    echo "<td>".$status."</td><td>".date("d.m.Y  H:i:s",strtotime($type['MSTIME']))."</td><td>".$type['ADCCOUNT']."</td><td>".$type['MSINFO']."</td><td>".$type['PERSNAME']."</td>".
    "<td>Gepl.: ".$gepl."<br>Laufz.:".$laufzeit."</td>";
    echo "</tr>";
}
}
?> 
