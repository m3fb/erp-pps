<?php
/* @var $this yii\web\View */
    use app\models\Auswertung;
    use yii\helpers\Html;
    use kartik\widgets\ActiveForm;
    use kartik\field\FieldRange;
    use kartik\builder\Form;
    $model = new Auswertung();

?>
<br><br><br><br>

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
<?= $form->field($model, 'werkzeugnr')->textInput()->label('Werkzeugnr:') ?>
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
    $werkzeugnr = $array[$zahl[0]]; 



$auftraege = Yii::$app->db->createCommand(" SELECT * FROM OR_ORDER WHERE COMMNO LIKE '%".$werkzeugnr."%' AND EINLAST != -1")
->queryAll();

$auftrags_status = ""; 
foreach($auftraege as $auftrag) {
        if($auftrag['STATUS'] == 0){
            $auftrags_status = "<x style='background-color:red;color:white;'>Nocht nicht gestartet</x>";
        }
        else if($auftrag['STATUS'] == 1){
            $auftrags_status = "<x style='background-color:yellow;color:black;'>In Arbeit</x>";
        }
        else if($auftrag['STATUS'] == 2){
            $auftrags_status = "<x style='background-color:green;color:white;'>Fertig</x>";
        }
        
        echo $auftrag['NAME'] . " " . $auftrags_status . " Laufzeit: " . $model->auftrag($auftrag['NAME'])[0]['gesamt_zeit'] . " Stunden<br>";
}

}
?> 
