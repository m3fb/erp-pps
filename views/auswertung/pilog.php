<?php 
use app\models\Auswertung;
$model = new Auswertung();

$this->registerJsFile(
    '@web/pilog.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>




<div id="techdiv">
<?php 

$tables = $model->pilog();


echo "<ul class='linien_liste'>";
foreach($tables as $type){
    $pfad = 'http://'.preg_replace('/\s+/','',$type['IP']).'/mess/log.txt';
    $farbe = 'red';
    $text = "log.txt ist <u>nicht</u> aktuell";
    if($type['AKTUELL'] == "green"){
        $fh = fopen($pfad,'r');
        $line = fgets($fh);
        $arr = explode("!",$line);
        if(strtotime($arr[0] . $arr[1]) > (strtotime('now') -30)){
            $farbe = "green";
            $text = "log.txt ist aktuell";
        }
    }
    
    echo "<li><div class='linie'>".$type['LINIE']." <br> Online seit: ".$type['UPTIME']."<br>";
    echo "<div style='background-color: ".$type['AKTUELL'].";color: white;'>Letzte Meldung: ".$type['MSLETZT']."</div>";
    echo "<div style='background-color: ".$farbe.";color: white;'>".$text." </div><br>";
    
    echo "<table width='100%'><tr>";
    
    echo "<td width='50%'>IP: " . $type['IP'] . "</td>";
    echo "<td width='50%'>RAM: " . round($type['RAM']) . " MB </td>";
    echo "</tr><tr>";
    echo "<td width='50%'>V-Aktuell : " . $type['GESCHWINDIGKEIT'] . " m/min</td>";
    echo "<td width='50%'>Temp: ".$type['TEMP']."°C </td>";
    echo "</tr>";
    
    if($type['AKTUELL'] == "green"){
        echo "<tr>";
        echo "<td width='50%'>gesamt.py Vers.:". $arr[10] . "</td>";
        echo "<td width='50%'>pilog.py Vers.:". $arr[11] . "</td>";
        echo "</tr><tr>";
        echo "<td width='50%'>exec.py Vers.:". $arr[12] . "</td>";
        echo "<td width='50%'> </td>";
        echo "</tr>";
        
        fclose($fh);
        echo "</table>";
        echo "<br><i>Fehlermeldungen: </i> <br>";
        
        ###
        if($arr[3] != 0 && $type['GESCHWINDIGKEIT'] == 0 && $farbe == "green")
            echo " <i> - Loggingfehler Geschwidigkeit in db </i><br>";
        if($arr[2] < ($type['STRECKE'] - 600)  || $arr[2] > ($type['STRECKE'] + 600))
            echo " <i> - Hohe Streckendifferenz db/txt </i><br>";
    }    
    else {
        echo "</table>";
        echo "<br><i>Fehlermeldungen: </i> <br>";
        echo " <i> - log.txt nicht erreichbar </i><br>";      
    }
    
    echo "<br>";
    echo "<button class='pireset' data-ip='".$type['IP']."'> Reset Software </button> <button class='piupdate' data-ip='".$type['IP']."'> Update Software </button>";
    echo "<button class='piboot' data-ip='".$type['IP']."'> Reboot Pi </button>";
    
    echo "</div> </li>";
    
    
}

echo "</ul>";
?>





</div> 