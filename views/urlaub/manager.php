<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;



/* @var $this yii\web\View */
$this->title = 'Urlaubsmanager';
$this->params['breadcrumbs'][] = $this->title;



?>

<h1><?= Html::encode($this->title) ?></h1> 

<div class="site-urlaub">
	<br>

			<?php $form = ActiveForm::begin(['id' => 'urlaub-form',
										
											 'method' => 'get',
											 'action' => ['']
											 ]); ?>
			<?= $form->field($model, 'pnra')->textInput()->label('PNR:') ?>
			<?= Html::submitButton('Bestätigen', ['class'=> 'btn btn-primary']) ;?>
            <?php ActiveForm::end(); ?>







<?php	



 
    if($array = Yii::$app->getRequest()->getQueryParam('Urlaub',NULL)){ // PERSNO aus Url auslesen (array) 
		$zahl = array_keys($array);
		$pnra = $array[$zahl[0]]; 
		$tables = $model->abfrage($pnra,0);
		$tableslb = $model->abfragelb($pnra,'Alle',date('Y-m-d',strtotime('-3 week')),date('Y-m-d',strtotime('+5 year')));
	}
	else {
		$tables = $model->abfrage(0,0);
		$tableslb = $model->abfragelb(0,'Alle',date('Y-m-d',strtotime('-3 week')),date('Y-m-d',strtotime('+5 year')));
	}
	echo "<h3><a id='trigger_antraege'>Vorliegende Urlaubsanträge</a><a id='trigger_best'>Bestätigte Urlaubsanträge</a></h3> <br />";
	$i = 0;
	echo "<ul class='liste antraege'>";
	$datum = array();
	foreach ($tables as $type) {
		$abteilung = ""; 
		if($type['TXT03'] == "urlaub_technikum@m3profile.com"){
			$abteilung = "tech";
		}
		if($type['TXT03'] == "urlaub_produktion@m3profile.com"){
			$abteilung = "prod";
		}
		if($type['TXT03'] == "urlaub_verwaltung@m3profile.com"){
			$abteilung = "verw";
		}
	$date = new DateTime($type['MSTIME']);
	$datum[$i] = $date->format('d.m.Y');	
	if ($i == 0){
		echo "<div class='manager_eintraege ".$abteilung."'>";
		
		$form = ActiveForm::begin(['id' => 'urlaub-form',
			'method' => 'post',
			'action' => ['']
			]);	
		echo "<li>";
		echo  "<div class='persname'>" .$type['PERSNAME'] . "<br>Personalnummer: " . $type['PERSNO']
		."<br><small>(".$type['TXT02'].": ".$type['TXT03'].")<br>"
		."Antrag gestellt am: ". date("d.m.Y",strtotime($type['CDATE'])) ."<br> Noch verbleibende Urlaubstage des Antragstellers: ". $model->verbl_tage_stunden($type['WORKID'])['tage'] ."</small> </div>";
		echo "</li>";
		$i++;
		echo "<li>";
		echo $form->field($model, 'idstart')->hiddenInput(['value'=> $type['LBNO']])->label(false);
		echo "[" . $type['LBNO'] . "]: " ."Start: " . $datum[0];
		echo "</li>";
	}
	else {
		echo "<li>";
		echo "[" . $type['LBNO'] . "]: " ."Ende: " . $datum[1] . "<br>";
		echo $form->field($model, 'idende')->hiddenInput(['value'=> $type['LBNO']])->label(false);
		echo "</li>";
		$i = 0;
		echo "<li>";
		echo "Aufzuwendende Urlaubstage: " . $type['TAGE'] . "<br>";
		echo "Aufzuwendende Stunden (in Tagen): " .$type['STUNDEN']; 
		echo "</li>";
		
		echo "<li>"; 
		?>
		<?= Html::submitButton('Annehmen', ['class'=> 'btn btn-primary', 'name'=>'btnAnnehmen']) ;?>	
		<?= Html::submitButton('Ablehnen', ['class'=> 'btn btn-secondary btnabl', 'name'=>'btnAblehnen']) ;?>	

		<?= Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> PDF', 
		['urlaub/pdf', 'name' => $type['PERSNAME'], 'pnr' => $type['PERSNO'], 'start' => $datum[0], 'ende' => $datum[1], 
		'bearb' => Yii::$app->user->identity->firstname . " " . Yii::$app->user->identity->surename, 'datum' => date("d.m.Y"),
		'tage'=>$type['TAGE'],'stunden'=>$type['STUNDEN']], 
		['class' => 'btn btn-danger','target'=>'_blank']) ?>
				
		<?php
		echo "</li>";
		ActiveForm::end();
		echo "</div>  <br /> <br />";
	}
	
	}
	
	echo "</ul>";
	
	

	
	
	$i = 0;
	echo "<ul class='liste best_man'>";
	$datum = array();
	foreach ($tableslb as $typelb) {
		$abteilung = ""; 
		if($typelb['TXT03'] == "urlaub_technikum@m3profile.com"){
			$abteilung = "tech";
		}
		if($typelb['TXT03'] == "urlaub_produktion@m3profile.com"){
			$abteilung = "prod";
		}
		if($typelb['TXT03'] == "urlaub_verwaltung@m3profile.com"){
			$abteilung = "verw";
		}
	$date = new DateTime($typelb['MSTIME']);
	$datum[$i] = $date->format('d.m.Y');	
				
			
	if ($i == 0){
		if($typelb['STATUS']==800){
		echo "<div class='manager_eintraege ".$abteilung." best2'>";
		
		$form = ActiveForm::begin(['id' => 'urlaub-form',
			'method' => 'post',
			'action' => ['']
			]);	
		echo "<li>";
		echo  "<div class='persname'>" .$typelb['PERSNAME'] . "<br>Personalnummer: " . $typelb['PERSNO']
		."<br><small>(".$typelb['TXT02'].": ".$typelb['TXT03'].")</small></div> ";	
		echo "</li>";
		$i++;
		echo "<li>";
		echo $form->field($model, 'idstart')->hiddenInput(['value'=> $typelb['LBNO']])->label(false);
		echo "[" . $typelb['LBNO'] . "]: " ."Start: " . $datum[0];
		echo "</li>";
		}
	}
	else {
		echo "<li>";
		echo "[" . $typelb['LBNO'] . "]: " ."Ende: " . $datum[1] . "<br>";
		echo $form->field($model, 'idende')->hiddenInput(['value'=> $typelb['LBNO']])->label(false);
		echo "</li>";
		$i = 0;
		echo "<li>";
		echo "Aufzuwendende Urlaubstage: " . $typelb['TAGE'] . "<br>";
		echo "Aufzuwendende Stunden (in Tagen): " .$typelb['STUNDEN']; 
		echo "</li>";
		
		echo "<li>"; 
		?>
		<?= Html::submitButton('Löschen', ['class'=> 'btn btn-danger', 'name'=>'btnLoeschen']) ;?>
				
		<?php
		echo "</li>";
		ActiveForm::end();
		echo "</div>  <br /> <br />";
	}
	
	}
	
	echo "</ul>";
	
	?>
	
	<br>
    <code><?= __FILE__ ?></code>
</div>
