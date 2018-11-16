<?php


 
$anzahl = Yii::$app->getRequest()->getQueryParam('gebindeanzahl',NULL);
$pono = Yii::$app->getRequest()->getQueryParam('pono',NULL);
$masseinh = Yii::$app->getRequest()->getQueryParam('masseeinheit',NULL);

$postxtl = Yii::$app->getRequest()->getQueryParam('postxtl',NULL);
$vorgno = Yii::$app->getRequest()->getQueryParam('vorgno',NULL);
$posart = Yii::$app->getRequest()->getQueryParam('posart',NULL);
    


while($anzahl > 0){
    $menge = Yii::$app->getRequest()->getQueryParam('gebinde-'.$anzahl.'',NULL);
    $zusatz = Yii::$app->getRequest()->getQueryParam('gebinde-'.$anzahl.'-zusatzinfo',NULL);
    
    
    
    $daten = "VORGNO: ".$vorgno."; POSART: ".$posart."; POSTXTL: ".$postxtl."; Gebinde-".$anzahl.": " . $menge . " ".$masseinh."; Zusatzinfo: ".$zusatz."; INFO-3: ".$pono."-".$anzahl.";"."\r\n";
    
    file_put_contents('data.txt', $daten, FILE_APPEND | LOCK_EX);
        
    $anzahl--;
    
    
}

 header("Location: http://m3mssql/m3adminV3_dev/web/index.php?r=bericht%2Frueckstand&type=order");
 die();






#       file_put_contents('data.txt', $daten, FILE_APPEND | LOCK_EX);
        




?>