<?php
    use yii\bootstrap\ActiveForm;
    use app\models\Auswertung;
    $model = new Auswertung();
    
    require "auswertung_anzeige.php"; 
    require "auswertung_vergleich.php";
        
    ### Vergleichsfunktion, Toleranzen usw.: 
    function sollist($soll,$ist){        
        $farbe = "";    
        // 10% Toleranz:
        $soll_toleranz = $soll * 1.1;
        
        if($ist > $soll && $ist < $soll_toleranz){
            $farbe = "warning";            
        }
        else if($ist > $soll_toleranz){
            $farbe = "danger";
        }   
        else if($ist <= $soll){
            $farbe = "success";
        }    
        
        return $farbe;
    }  
?>
<br><br>
<div class="daten">
<table>
<tr>
<?php $form = ActiveForm::begin(['id' => 'auswertung-form',
										
											 'method' => 'get',
											 'action' => ['']
											 ]); ?>
                                             
<td> Start: </td>
<td> Ende: </td>
</tr>
<tr>
<td> <input name="input_start" class='startneu form-control' value='' > </td>
<td> <input name="input_ende" class='endeneu form-control' value=''> </td>
</tr>
<tr>                                           
<td>   
<select name="input_linie" class="form-control">
  <option value="0">Linie auswählen</option>
  <option value="Linie 06">Linie 06</option>
  <option value="Linie 08">Linie 08</option>
  <option value="Linie 10">Linie 10</option>
  <option value="Linie 13">Linie 13</option>
</select>  
</td>
<td> 
<select name="input_werkzeug" class="form-control">
<?php 
echo "<option value='0'>Werkzeug auswählen</option>";
foreach($model->werkzeuge() as $werkzeug){
    echo "<option value='".$werkzeug['COMMNO']."'>".$werkzeug['COMMNO']."</option>";
}?>
</select>   
</td>
<td>

</td>
<td>
</td>
<td>
<!--<a id="add_datensatz">Datensatz hinzufügen</a> -->
</td>
</tr>
<tr>
<td> </td><td><div id='laedt'><img src="laedt.gif"></div></td>
<td>
<button type="submit" class='btn btn-primary'><span>Bestätige</span></button>
</td>       
</tr>
<!--
<tr id="datensatz2">
<td>
<select id="input_linie2" name="input_linie2">
  <option value="0">Linie auswählen</option>
  <option value="Linie 06">Linie 06</option>
  <option value="Linie 08">Linie 08</option>
  <option value="Linie 10">Linie 10</option>
  <option value="Linie 13">Linie 13</option>
</select>  
</td>
<td> 
<select id="input_linie2" name="input_werkzeug2">
<?php 
#echo "<option value='0'>Werkzeug auswählen</option>";
#foreach($model->werkzeuge() as $werkzeug){
#    echo "<option value='".$werkzeug['COMMNO']."'>".$werkzeug['COMMNO']."</option>";
#}?>
</select>   
</td>
<td>
<input name="input_start2" class='startneu' value='' >
</td>
<td>
<input name="input_ende2" class='endeneu' value=''>
</td>
</tr> 
-->
<?php ActiveForm::end(); ?>
</table>
</div>
<br><br> 
<?php
#1: Übergebene Parameter auslesen: Linie, Start, Ende    (später Werkzeug) 
# Übergeben an 


#### Bei keiner Angabe des Zeitraumes bei Einzelauswertung: die letzten 1-3 Wochen
#### Bei keinen Zeiträumen bei Vergleichsauswertung: Die letzten 1-3 Monate der letzten verfügbaren Aufträge (Werkzeug auf Linie)
    $daten = array();
    $daten2 = array();
  
    if(Yii::$app->getRequest()->getQueryParam('input_linie',NULL)){ // PERSNO aus Url auslesen (array)         
        $start = Yii::$app->getRequest()->getQueryParam('input_start',NULL);
        $ende = Yii::$app->getRequest()->getQueryParam('input_ende',NULL);
        $linie = Yii::$app->getRequest()->getQueryParam('input_linie',NULL);
        $daten= $model->auswertung_zeitraum($start,$ende,$linie,0);       
    }
    else if(Yii::$app->getRequest()->getQueryParam('input_werkzeug',NULL)){ 
       $start = Yii::$app->getRequest()->getQueryParam('input_start',NULL);
       $ende = Yii::$app->getRequest()->getQueryParam('input_ende',NULL);
       $werkzeug = Yii::$app->getRequest()->getQueryParam('input_werkzeug',NULL);
       $daten= $model->auswertung_zeitraum($start,$ende,0,$werkzeug);      
    }
    
    else {
        $daten[0]['fehler'] = 1; 
        $daten[0]['fehlermeldungen'][0] = "Bitte Datensatz wählen";
    }
    
    if(Yii::$app->getRequest()->getQueryParam('input_linie2',NULL)){ // PERSNO aus Url auslesen (array)         
        $start = Yii::$app->getRequest()->getQueryParam('input_start2',NULL);
        $ende = Yii::$app->getRequest()->getQueryParam('input_ende2',NULL);
        $linie = Yii::$app->getRequest()->getQueryParam('input_linie2',NULL);
        $daten2= $model->auswertung_zeitraum($start,$ende,$linie,0);       
    }
    else if(Yii::$app->getRequest()->getQueryParam('input_werkzeug2',NULL)){ 
       $start = Yii::$app->getRequest()->getQueryParam('input_start2',NULL);
       $ende = Yii::$app->getRequest()->getQueryParam('input_ende2',NULL);
       $werkzeug = Yii::$app->getRequest()->getQueryParam('input_werkzeug2',NULL);
       $daten2= $model->auswertung_zeitraum($start,$ende,0,$werkzeug);      
    }
    
    if($daten && !$daten2){
        anzeige($daten);
    }
    else{
        echo "nix da";
    }

?>