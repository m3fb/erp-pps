<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\bootstrap\Modal;
use yii\web\JsExpression;



/* @var $this yii\web\View */
$this->title = 'Betriebskalender';
$this->params['breadcrumbs'][] = $this->title;

?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="site-urlaub">
<br>
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Neuen Termin hinzufügen</h4>
      </div>
      <div class="modal-body">
	  <table><tr><td>
		Start:
		</td><td>Ende:</td>
		</tr>
		<tr><td>
		<input id="modal-start" class="startneu"></td><td>
        <input id="modal-ende" class="endeneu"><td><br>
		</tr>
		<tr><td>
		Beschreibung:</td></tr> <br>
		<tr><td><textarea id="modal-beschreibung"></textarea>
		</td></tr></table>
		</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Abbrechen</button>
        <button id="btn-speich" type="button" class="btn btn-primary">Termin speichern</button>
      </div>
    </div>
  </div>
</div>
<div class="btn-group">
  <button id="btnAbteilung" type="button" class="btn btn-default dropdown-toggle fc-state-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Abteilung<span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a id="drpProduktion" class="drp" href="#">Produktion</a></li>
    <li><a class="drp" href="#">Technikum</a></li>
    <li><a class="drp" href="#">Verwaltung</a></li>
    <li><a class="drp" href="#">Logistik</a></li>
	<li><a class="drp" href="#">QS</a></li>
	<li><a class="drp" href="#">Auftragsverwaltung</a></li>
	<li><a class="drp" href="#">Planung</a></li>
	<li><a class="drp" href="#">Projektmanagement</a></li>
	<li role="separator" class="divider"></li> 
    <li><a class="drp" href="#">Alle</a></li>
  </ul>
</div>


<div id='laedt'><img src="laedt.gif"></div>
<div id='kalender'></div>



	<br>
    <code><?= __FILE__ ?></code>



</div>
</div>
</body>
