<?php
/* @var $this yii\web\View */
    use app\models\Technikum;
    use yii\helpers\Html;
  
     $model = new Technikum();

$this->registerJsFile(
    '@web/technikum.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->title = 'Technisreen';
?>



<div id="techdiv"> 

  <!-- <div class='tech-todo'>
                 <div class='tech-todo-datum'>23.09.2017</div>
                 <div class='tech-todo-prio'>2</div>
                 <div class='tech-todo-text'>Textexttextetetetextxtxtetextexeextetxeetxrey<br>testestestestestestestestestestet <br>dritte Zeile</div>
                 <div class='tech-todo-beauftragter'>Jeder</div>              
                 <button class='todo_erledigt'>Erledigt</button>
  </div>

<br>
<br>
<br>
<br> -->

 
<div class="col-md-6"> 
	<div class="panel panel-primary">
	  <div class="panel-heading">Aktuelle Aufgaben:</div>
	  <div class="panel-body">
		
		<div id="techlinks"></div>  
	
	  </div>
	</div>
</div>



<!--
<div id="techrechts">
Aufgabenzyklus: <br>
</div>
-->

<div class="col-md-6">
	<div class="panel panel-primary">
	  <div class="panel-heading">Reklamationen:</div>
	  <div class="panel-body">
		
		<div id="reklamationen"></div>  
	
	  </div>
	</div>	
</div>







</div>
