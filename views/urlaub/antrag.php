<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\captcha\Captcha;
use app\assets\AppAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use kartik\widgets\DatePicker;
use kartik\widgets\DateControl;
use kartik\daterange\DateRangePicker;
use kartik\field\FieldRange;
use kartik\builder\Form;
use kartik\mpdf\Pdf;


/* @var $this yii\web\View */
$this->title = 'Urlaubsplaner';
$this->params['breadcrumbs'][] = $this->title;

AppAsset::register($this);
?>







<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Urlaubsantrag ändern</h4>
      </div>
      <div class="modal-body">
		Start:<input id="modal-start" class='startneu' value='' >
        Ende:<input id="modal-ende" class='endeneu' value=''><br>
		Tage:<input id="modal-tage" class='tageneu' value=''>
		Stunden:<input id="modal-stunden" class='stundenneu' value=''><br>
		<input id="modal-idstart" type="hidden">
		<input id="modal-idende" type="hidden">
		Neu errechnete Tage:<div id='errTage'></div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Abbrechen</button>
        <button id="btn-eintr" type="button" class="btn btn-primary">Änderungen speichern</button>
      </div>
    </div>
  </div>
</div>
















<h1><?= Html::encode($this->title) ?></h1>


<?php
$verbl_arr = $model->verbl_tage_stunden(0);
$std = $verbl_arr['stunden'];
$tge = $verbl_arr['tage'];
?><br>
<label>Angemeldet als:</label> <?php echo Yii::$app->user->identity->firstname . " " . Yii::$app->user->identity->surename; ?> <br />
<label>Personalnummer:</label> <div id='a_pnr'><?php echo $model->getpnr() ?></div> <br />
<label>Verbleibende Urlaubstage:</label> <?php echo $tge; ?> Tage<br />
<label>Verbleibende Überstunden:</label> <?php echo $std; ?> Stunden<br />
<label>Überstunden in Tagen:</label> <?php echo $std / 8; ?> Tage <br />




<div class="site-urlaub">
	<br>
	<link rel="stylesheet" href="css/test.css">
	<?php $form = ActiveForm::begin(['id' => 'urlaub-form',
			'method' => 'post',
			'action' => ['']
			]);

	echo FieldRange::widget([
    'form' => $form,
    'model' => $model,
    'label' => 'Urlaubszeitraum angeben:',
    'attribute1' => 'start',
    'attribute2' => 'ende',
	'separator' => '<- bis ->',
    'type' => FieldRange::INPUT_DATE,

]);
    ?>
<br>
	<?= Yii::$app->session->getFlash('benTage'); ?>
	Anzahl der benötigten Urlaubstage: <div id="benTage"></div>
	<?= Yii::$app->session->getFlash('urlaubgest'); ?>
	</ br>
	</ br>
	<?php

echo Form::widget([
    'model'=>$model,
    'form'=>$form,
    'columns'=>2,
    'attributes'=>[       // 2 column layout
        'tage'=>['type'=>Form::INPUT_TEXT,'label' => 'Urlaubstage', 'options'=>[ 'placeholder'=>'Aufzuwendende Tage (in Urlaubstagen)...']],
        'stunden'=>['type'=>Form::INPUT_TEXT,'label' => 'Überstunden (in Tagen angeben!)', 'options'=>['placeholder'=>'Aufzuwendende Tage (in Überstunden)...']]
    ]
]);

	?>

	<?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span> Bestätigen', ['class'=> 'btn btn-primary','name'=>'btnAbschicken']) ;?>	

    <?php ActiveForm::end(); ?>

	<br> <br>

<div id="eigene_antraege">

	<div class="btn-group">
		<button id="btnAntrag_Auswahl" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Eingereichte Urlaubsanträge<span class="caret"></span></button>
			<ul class="dropdown-menu antrag_auswahl">
				<li><a class="drp" href="#">Eingereichte Urlaubsanträge</a></li>
				<li><a class="drp" href="#">Bestätigte Urlaubsanträge</a></li>
			</ul>
	</div>
	<br />
	<br>
	<div id="vorl_antraege">
	<?php
	$tables = $model->abfrage($model->getpnr(),0);   // abgabe an Funktion (Urlaub.php)

	$n = 0;
	$i = 0;
 	echo "<ul class='liste'>";
	$datum = array();
	foreach ($tables as $type) {
	$date = new DateTime($type['MSTIME']);
	$datum[$i] = $date->format('d.m.Y');
	if ($i == 0){
		echo "<div class='manager_eintraege'>";

		echo "<li>";
		echo  "<div class='persname'>" .$type['PERSNAME'] . "<br>Personalnummer: " . $type['PERSNO']. "</div> ";
		echo "</li>";
		$i++;
		echo "<li>";
		echo "<input id='t".$n."' class='idstart' type='hidden' value='".$type['LBNO']."'>";
		$n++;
		echo "Urlaubsbeginn: <p id='t".$n."' class='startneu'>".$datum[0]."</p>";
		echo "</li>";
		$n++;
	}
	else {
		echo "<li>";
		echo "Urlaubsende: <p id='t".$n."' class='endeneu'>".$datum[1]."</p>";
		echo "</li>";
		$i = 0;
		$n++;
		echo "<li>";
		echo "<input id='t".$n."' class='idende' type='hidden' value='".$type['LBNO']."'>";
		$n++;
		echo "Verrechnete Tage: <div id='t".$n."' class='tageneu'>".$type['TAGE']."</div>";
		$n++;
		echo " Verechnete Stunden: <div id='t".$n."' class='stundenneu'>".$type['STUNDEN']."</div>";
		echo "</li>";
		echo "<li>";
		echo "<button id='btn-aendern' class='btn btn-primary btn-aendern' value='".$n."' data-toggle='modal' data-target='#myModal'>Ändern</button>";
		$n++;

		echo "</li>";

		echo "</div>  <br /> <br />";
	}

	}

	echo "</ul>"; ?>
	</div>
	<div id="best_antraege">
	<?php
	$tables = $model->abfragelb($model->getpnr(),0,date("d.m.Y"),date("d.m.Y",strtotime("+ 1 year")));   // abgabe an Funktion (Urlaub.php)
	//$tables = Yii::$app->createUrl('index.php?r=urlaub%2Fantraege',$model->getpnr(),0,date("d.m.Y"),date("d.m.Y",strtotime("+ 1 year")));
	//$tables = Yii::$app->runAction('urlaub/termine', ['pnra' => $model->getpnr(), 'abt' => 0, 'start' => date("d.m.Y"), 'end' => date("d.m.Y",strtotime("+ 1 year"))]);
	echo "<ul class='liste'>";
	$i = 0;
	$n = 0;
	foreach($tables as $type){
	$date = new DateTime($type['MSTIME']);
	$datum[$i] = $date->format('d.m.Y');
	if ($i == 0){
		if($type['STATUS']==800){
		echo "<div class='manager_eintraege best'>";

		echo "<li>";
		echo  "<div class='persname'>" .$type['PERSNAME'] . "<br>Personalnummer: " . $type['PERSNO']. "</div> ";
		echo "</li>";
		$i++;
		echo "<li>";
		echo "Urlaubsbeginn: <p id='t".$n."' class='startneu'>".$datum[0]."</p>";
		echo "</li>";
		}
	}
	else {
		echo "<li>";
		echo "Urlaubsende: <p id='t".$n."' class='endeneu'>".$datum[1]."</p>";
		echo "</li>";
		$i = 0;
		echo "</div>  <br /> <br />";
	}
	}


	$betriebsurlaub = Yii::$app->db->createCommand("
			SELECT A.MSTIME as Startzeit, B.MSTIME as Endzeit, A.LBNO as LBNO,A.PERSNAME as PERSNAME, A.GESAMT_TAGE as gesamt_tage FROM m3_urlaubsplanung A
			INNER JOIN m3_urlaubsplanung B
			ON A.LBNO = B.LBNO -1
			WHERE A.PERSNO = 5 AND ((DATEPART(yyyy,A.MSTIME) = DATEPART(yyyy,GETDATE()) AND A.STATUS = 800) OR
			(DATEPART(yyyy,B.MSTIME) = DATEPART(yyyy,GETDATE()) AND B.STATUS = 801))")
	->queryAll();

	foreach($betriebsurlaub as $tag){
		echo "<div class='manager_eintraege best'>";
		echo "<li>";
		echo "<div class='persname'>" . $tag['PERSNAME'] ."</div>";
		echo "</li><li>";
		echo "Beginn: ". date("d.m.Y",strtotime($tag['Startzeit'])) . "</li>";
		echo "<li> Ende: ".date("d.m.Y",strtotime($tag['Endzeit'])) . "</li>";
		echo "<li> Aufgewendete Urlaubstage: " . $tag['gesamt_tage'] . "</li>";
		echo "</div><br><br>";
	}
	echo "</ul>";
	?>
	</div>

	<br>
    <code><?= __FILE__ ?></code>
</div>
