<?php
/* @var $this yii\web\View */
    use app\models\Technikum;
    use yii\helpers\Html;
  
     $model = new Technikum();
     
$this->registerJsFile(
    '@web/technikum.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

?>



<div id="techdiv"> 

<!--
<div id="pruef">

</div>




<select id='beauftragter' name="top5" size="10">  
<option> Alle </option>
<?php 
    // $tables = $model->tech_mitarbeiter();
    // foreach($tables as $type){
        // echo "<option>".$type['PERSNAME']."</option>";
    // }
?>



 </select><br>

Aufgabentext: 
<textarea id="todo_text"> </textarea><br>
Start:
<input id="input_start" class='startneu' value='' ><br>
Zu erledigen bis:
<input id="input_ende" class='endeneu' value='' ><br>

<fieldset id="todo-zyklus"> 
    <input type="radio" id="mc" name="a" value="7"> <label for="mc"> Wöchentlich</label><br> 
    <input type="radio" id="vi" name="a" value="30"> <label for="vi"> Monatlich</label><br> 
    <input type="radio" id="ae" name="a" value="182"> <label for="ae"> Halbjährlich</label> </fieldset>
    <input type="radio" id="ae" name="a" value="365"> <label for="ae"> Jährlich</label> 
</fieldset>
<br>
<br>
<fieldset id="todo-prio"> 
    <input type="radio" id="mc" name="b" value="1"> <label for="mc"> Wichtig</label><br> 
    <input type="radio" id="vi" name="b" value="2"> <label for="vi"> Naja</label><br> 
    <input type="radio" id="ae" name="b" value="3"> <label for="ae"> Nicht wichtig</label> </fieldset>
</fieldset>
<button id="tech-eingabe">Eintragen</button><br>

                     
<br><br><br>
-->
<?php
$tables = $model->todo_pruef_anzeigen();

if(!$tables)
    echo "Keine abgeschlossenen Aufgaben vorhanden.";

foreach($tables as $type){
    echo "<br>";
    echo date("d.m.Y",strtotime($type['due_date']));
    echo "<br> Erledigte Aufgabe: ".$type['name'];
    echo "<br> Erledigt von: ".$type['beauftragter'];
    echo "<br> <button  class='btn btn-success loesch_tech_todo' data-id='".$type['id']."'>Okay</button>";
    echo "<button  class='btn btn-warning zurueck_tech_todo' data-id='".$type['id']."'>Nicht Okay</button>";
    echo "<br>";
}



?>

<script> 
setTimeout(function(){location.reload();},300000);
</script>



</div>















