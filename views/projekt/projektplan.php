<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use app\assets\AppAsset;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\data\Sort;

/* @var $this yii\web\View */
$this->title = 'Projektplan';
#$this->params['breadcrumbs'][] = ['label' => 'Projektverwaltung', 'url' => ['index']];
#$this->params['breadcrumbs'][] = $this->title;

// css-Script für das GANT-Raster
$this->registerCssFile("@web/css/projekt_kalender.css");

//Rasterwert von 12 bis 52. Künftig über Parameter einstellbar <<TODO##################
$wochenraster = 52;
$cu_year = date( "Y");
//$cu_year = 2018;

$tage_gesamt = $wochenraster * 7;
$wochen_width= 100 / $wochenraster;
$current_week_no = date ( "W" );

//Startwochen; default sollte $current_week_no sein;
// Kann evtl. über Parameter gesteuert werden <<TODO##################
$w=$current_week_no;

#unterschiedliche Hintergrundfarben wenn sich das Jahr in der Kopfzeile ändert
$background=[0=>'#f2dede', 1=>'#d9edf7',2=>'#dff0d8'];
$bi =0;  //background-index


$year =$cu_year;

#Label für Monatsnamen, da diese über die DRECKS Standardformatierung nur in Englisch dargestellt werden
$monatsnamen = [
			   1=>"Januar",
			   2=>"Februar",
			   3=>"März",
			   4=>"April",
			   5=>"Mai",
			   6=>"Juni",
			   7=>"Juli",
			   8=>"August",
			   9=>"September",
			   10=>"Oktober",
			   11=>"November",
			   12=>"Dezember"];

$monatsnummer='';

$gesamt_wochen_width=0;
#$week_index[]=''; //Array für die Zuordnung der Wochennummern und der Prozentwerte


$y=1; //Index zum Jahre zählen. Muss auf 1 stehen.

$w1 = sprintf('%02d', $w);
$erster_montag_ges = strtotime("{$cu_year}-W{$w1}"); //Montag der ersen Woche im Raster als Datum ermitteln für die Resttageberechnung



$weeks='';
$months='';
$jahre='';
$jahres_width = 0;
$tg = $tage_gesamt; //Tage gesamt wird in der unteren Schleife dezimiert. $tg wird für die Gesamtverhältnisrechnungen benötigt
$projekt_rows ='';

/*    function getIsoWeeksInYear($year) {
		$date = new DateTime;
		$date->setISODate($year, 53);
		return ($date->format("W") === "53" ? 53 : 52);
	}*/


//Raster und Header anlegen

for ($i=1; $i<=$wochenraster; $i++) {


	$w1 = sprintf('%02d', $w);
	$erster_montag = strtotime("{$cu_year}-W{$w1}");
	$monatstage = date("t",$erster_montag);

//Monatsnamen Überschrift
	if ($i == 1 && $tage_gesamt > 0) { //erster Monat; ermittelln der restlichen Monatstage und der restlichen Jahrestage für Überschrift

			$monats_kapaz = $monatstage - date("d", $erster_montag)+1;
	}
	elseif ($tage_gesamt > $monatstage && $monatsnummer != date("n", $erster_montag) ) { //volle Monate

			$monats_kapaz = $monatstage;
		}
	elseif  ($tage_gesamt < $monatstage && $monatsnummer != date("n", $erster_montag) ){ //letzer Monat; ermitteln der restlichen Monatstage

			$monats_kapaz = $tage_gesamt;

		}

	if  ($i == 1 || $monatsnummer != date("n", $erster_montag) ){
		$monatsnummer = date("n", $erster_montag);
		$monatsname=$monatsnamen[$monatsnummer];
		$monats_width = 100 /  $tg * $monats_kapaz;
		$tage_gesamt= $tage_gesamt-$monats_kapaz;
		$jahres_width += $monats_width;

		$months .= '<div class="cu_months" style="width:'.$monats_width.'%; background-color:'.$background[$bi].'">'.$monatsname.'</div>';
	}


//Wochennummern Überschrift
	if ($w <= $weeks_of_cur_year) { //Jahreswechsel prüfen ob Wochennummer größer als die gesamte Jahres-Wochenanzahl ist


		$weeks .= '<div class="cu_weeks" style="width:'.$wochen_width.'%">'.sprintf('%02d', $w).'</div>';
		$gesamt_wochen_width += $wochen_width;
		$week_index[$year.sprintf('%02d',$w)]=$gesamt_wochen_width;
		$w++;
	}
	else {  //... Jahreswechsel; Wochennummer zrücksetzen und Jahr + 1

		$w =1;
		$year++;
		$weeks .= '<div class="cu_weeks" style="width:'.$wochen_width.'%">'.sprintf('%02d', $w).'</div>';
		$gesamt_wochen_width += $wochen_width;
		$week_index[$year.sprintf('%02d',$w)]=$gesamt_wochen_width;
		$w++;
		$y++;
		$bi++;

	}
}

//Jahreszahl Überschrift
	($y<3)?$ai=1:$ai=0;
	for ($i=0; $i<$y; $i++) {

		$text_align = [0=>'left', 1=>'center', 2=>'right' ] ;
		$jahres_width=100/$tg * $tg/ $y;
		$jahre .= '<div class="cu_year" style="width:'.$jahres_width.'%; text-align:'.$text_align[$ai].';">'.$cu_year.'</div>';
		$ai++;
		$cu_year++;
	}



/* *
 * Funktion: Pojektliste wird durchgearbeitet;
 * Mindestens der Pojektkopf wird angelegt.
 * 1. 	Prüfen ob Termine und Dauer vorhanden sind und wenn ja, muss geprüft
 * 		werden ob die Endtermine noch in der Startwoche des Rasters erscheinen.
 * 2.	Wenn der Endtermin in das Raster fällt, prüfen ob der Starttermin (=Endtermin - Dauer)
 * 		im Raster erscheint und ob der Starttermin größer als das erste Rasterelement ist.
 * 3. 	Wenn das der Fall ist wird ein Start-, Mittel- und Endelement benötigt.
 * 4. 	Wenn der Starttermin kleiner als das erste Rasterelement ist, wird
 * 		ein Mittelelement mit der Größe: Gesamtzeit - erstes Rasterelement und eine Endelement benötigt
 * 5. 	Wenn der Endtermin größer als das letzte Rasterelement ist, wird eine Start- und ein Mittelelement
 * 		benötigt. Mittelelement ist Gesamtzeit - Zeit außerhalb des Rasters
 * 6. 	Wenn Startzeit kleiner als das erste Element und Endtermin größer als das letzte Rasterelement
 * 		sind, dann wird das Mittelelement 100%.
 * */
foreach ($dataProvider->models as $model) {

	/*
 * in der Datenbank sind die Terminpaare über Termin_XXX_Ende und Termin_XXX_Dauer
 * definiert. Die Werte XXX werden mit den untentstehenden Werten ersetzt und
 * in die Projektplanung mit aufgenommen.
 * */
	$terminart = ['Konst','WZBau','sonst1','sonst2','sonst3','sonst4','sonst5', 'RM','Vorrichtung','Linie','Verpackung','Einfahren','int_Bem','ext_Bem','Pruefber'] ;
	$termin_header = [
		'Konst'=>'Konstruktion',
		'WZBau'=>'Werkzeugbau',
		'sonst1'=>$model->Termin_sonst1_Label,
		'sonst2'=>$model->Termin_sonst2_Label,
		'sonst3'=>$model->Termin_sonst3_Label,
		'sonst4'=>$model->Termin_sonst4_Label,
		'sonst5'=>$model->Termin_sonst5_Label,
		'RM'=>'Rohmaterial',
		'Vorrichtung'=>'Vorrichtung',
		'Linie'=>'Linie',
		'Verpackung'=>'Verpackung',
		'int_Bem'=>'interne Bemust.',
		'ext_Bem'=>'Lieferzeit Must.',
		'Pruefber'=>'Endtermin',
		'Einfahren' => 'Einfahren',
		];

	$termin_background = [
		'Konst'=>'#f37789',
		'WZBau'=>'#6b82e5',
		'sonst1'=>'#d9d74f',
		'sonst2'=>'#d9d74f',
		'sonst3'=>'#d9d74f',
		'sonst4'=>'#d9d74f',
		'sonst5'=>'#d9d74f',
		'RM'=>'#d9d74f',
		'Vorrichtung'=>'#d9d74f',
		'Linie'=>'#d9d74f',
		'Verpackung'=>'#d9d74f',
		'Einfahren'=>'#b775ef',
		'int_Bem'=>'#6cd94f',
		'ext_Bem'=>'#d9aa4f',
		'Pruefber'=>'#bcbcbc',
		];

	$wznr = ($model->WerkzeugNr) ? Html::a($model->WerkzeugNr.' / ',['projekt/view', 'id'=>$model->ID]) : '';
	$profil_bez = ($model->Profilbezeichnung) ? $model->Profilbezeichnung. ' / ' :'';
	$kunde = ($model->Kunde) ? $model->Kunde. ' / ' :'';
	$koord = ($model->Projektkoordinator) ? 'Projektkoordination: '.$model->Projektkoordinator :'';




	if (Yii::$app->user->identity and Yii::$app->user->identity->role > 50 and $this->params['nav_header'] != 'Techniscreen') {
		$update = Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['projekt/update', 'id'=>$model->ID]);
		if (Yii::$app->user->identity and in_array(Yii::$app->user->identity->username,['mrotter','mheim'])) {
			$delete = Html::a('<span class="glyphicon glyphicon-trash"></span>',
																		['projekt/delete', 'id'=>$model->ID], [
																		'title' => \Yii::t('yii', 'Delete'),
																		'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
																		'data-method' => 'post',
																		'data-pjax' => '0',
																			]);
			$finished = Html::a('<span class="glyphicon glyphicon-check"></span>',
																			['projekt/finish', 'id'=>$model->ID], [
																			'title' => \Yii::t('yii', 'Erledigt'),
																			'data-confirm' => Yii::t('yii', 'Projekt als erledigt speichern?'),
																			'data-method' => 'post',
																			'data-pjax' => '0',
																				]);

			}
		else {
			$delete ='';
			$finished ='';
		}
	}

	else {
		$delete ='';
		$update ='';
		$finished ='';
	}

	$view = Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['projekt/view', 'id'=>$model->ID]);
	$header = $wznr.$profil_bez.$kunde.$koord. " ". $view." ". $update." ". $finished." ". $delete;

	$projekt_rows .='

		<div class="row">
		  <div class="col-md-12 bg-warning label_project_header"><div>'.$header.'</div></div>
		</div>';
#DEGUG
#echo '<div style="height:150px; width:100%">';
#DEBUG
	foreach($terminart as $ta){

		if ($model->{'Termin_'.$ta.'_Ende'} && $model->{'Termin_'.$ta.'_Dauer'} > 0) {

			$endtermin = $model->{'Termin_'.$ta.'_Ende'};
			$dt_endtermin = new DateTime($endtermin);
			$end_week = $dt_endtermin->format("Y").sprintf('%02d',$dt_endtermin->format("W"));
			$end_week_2 = 'KW'.sprintf('%02d',$dt_endtermin->format("W"));

			$ur_endtermin = $model->{'Termin_'.$ta.'_Ende_0'};
			$ur_dt_endtermin = new DateTime($ur_endtermin);
			$ur_end_week = $ur_dt_endtermin->format("Y").sprintf('%02d',$ur_dt_endtermin->format("W"));
			$ur_end_week2 = 'KW'.sprintf('%02d',$ur_dt_endtermin->format("W"));

			$dauer =  $model->{'Termin_'.$ta.'_Dauer'};
			$ur_dauer =  $model->{'Termin_'.$ta.'_Dauer_0'};

			#($end_week_2== $ur_end_week)?$color_week='#666666':$color_week='#000';
			#($dauer== $ur_dauer)?$color_dauer='#666666':$color_dauer='#000';

			/*$soll_ist= 		'<small><span style="color:'.$color_week.'">'.$ur_end_week.'/</span>
							<span style="color:'.$color_dauer.'">'.sprintf('%02d',$ur_dauer).'-</span>
							<span style="color:'.$color_week.'">' .$end_week_2. '/</span>
							<span style="color:'.$color_dauer.'">'. sprintf('%02d',$dauer).'</span></small>';*/

			$starttermin = date('Y-m-d', strtotime('-'.$dauer.' week', strtotime($endtermin)));
			$dt_starttermin = new DateTime($starttermin);
			$start_week = $dt_starttermin->format("Y").sprintf('%02d',$dt_starttermin->format("W"));

			$rasterAnfang = key($week_index);
			$rasterEnde = $cu_year-1 . sprintf('%02d',$w-1);

			$end_week_year = substr($end_week,0,4);
			$start_week_year = substr($start_week,0,4);
			$raster_end_year = substr($rasterEnde,0,4);

			if ($start_week < $rasterEnde && $end_week >= $rasterAnfang){
				if($start_week < $rasterEnde && $start_week >= $rasterAnfang && $end_week >= $rasterAnfang) { // Terminanfang liegt im Raster

					if ($end_week <= $rasterEnde) { //Ende innerhalb des Rasters
						$length = $week_index[$end_week]- $week_index[$start_week];
						$dauer2 = $dauer;
					}
					else { // Ende nicht innerhalb des Rasters
						//Jahreswechsel prüfen um die Restdauer zu berechnen
						if ($raster_end_year > date('Y')) { //Jahreswechsel im Raster
							if ($end_week_year > date('Y') && $start_week_year < date('Y') ) { //Endtermin liegt im Folgejahr; Starttermin nicht
								$dauer_ende = intval(substr($rasterEnde,4,2));
								$cur_year_dauer = $weeks_of_cur_year - intval(substr($start_week,4,2));
								$dauer2 = $dauer_ende + $cur_year_dauer;
							}
							elseif ($end_week_year > date('Y') && $start_week_year > date('Y') ) { //Start- und Endtermin liegen im Folgejahr
								$dauer_ende = intval(substr($rasterEnde,4,2));
								$dauer_start = intval(substr($start_week,4,2));
								$dauer2 = $dauer_ende - $dauer_start;
							}
						}
						else { //kein Jahreswechsel im Raster
							$dauer2 = $weeks_of_cur_year - intval(substr($start_week,4,2));
						}

						$length = $week_index[$rasterEnde]- $week_index[$start_week];


					}
					$projekt_insert ='
									<div class="progress" style="margin-bottom:4px; border-radius: 0px;">
									  <div class="progress-bar progress-bar-success" style="width: '.$week_index[$start_week].'%; background-color:#fff;color:red;"></div>
									  <div class="progress-bar progress-bar-danger" style="width: '.$length.'%; background-color:'.$termin_background[$ta].'">'.$dauer2.'</div>
									</div>';
				}
				elseif($start_week < $rasterEnde && $start_week < $rasterAnfang && $end_week >= $rasterAnfang) {

					if ($end_week <= $rasterEnde) { //Start liegt nicht mehr innerhalb des Rasters; Theoretisches Feld
						$length = $week_index[$end_week];

						//Restliche Dauer berechnen. Jahreswechsel muss berücksichtigt werden
						if ($end_week_year > date('Y')) {
							$next_year_dauer = intval(substr($end_week,4,2));
							$cur_year_dauer = $weeks_of_cur_year - intval(substr($rasterAnfang,4,2))+1;
							$dauer = $next_year_dauer + $cur_year_dauer;
						}

						else {
							$dauer2 = intval(substr($end_week,4,2)) - intval(substr($rasterAnfang,4,2))+1;
						}
					}
					else {
						$length = $rasterEnde;
						$dauer2 = $wochenraster;
					}

					$projekt_insert ='

									<div class="progress" style="margin-bottom:4px; border-radius: 0px;">
									  <div class="progress-bar progress-bar-danger" style="width: '.$length.'%; background-color:'.$termin_background[$ta].'">'.$dauer2.'</div>
									</div>
								';
				}
				// Besprechung am 14.03.2018 mit M.Heim: Ein Termin der abgelaufen ist, muss nicht mehr angezeigt werden.
				/*elseif($end_week < $rasterAnfang) {
					$message = ' KW'.sprintf('%02d',$dt_endtermin->format("W"));
					$projekt_rows .='
						<div class="row">
						  <div class="col-md-1 label_project" style="background-color:'.$termin_background[$ta].';">'.$soll_ist.'</div>
						  <div class="col-md-1 label_project" style="background-color:'.$termin_background[$ta].';">'.$termin_header[$ta].'</div>
						  <div class="col-md-10 " style="padding-left: 0px; padding-right: 0px;">
									<div class="row col-lg-12">
									<div class="progress" style="margin-bottom:4px; border-radius: 0px;">
									  <!--<div class="progress-bar progress-bar-warning progress-bar-striped" style="width: 20%; color:#000;">Termin abgelaufen!!! Endtermin war <b>'.$message.'</b></div>-->
									</div>
								</div>
						  </div>
						</div> ';
				}*/
				/*
				 * Termin-Abweichung beim Endtermin ermitteln; Prüfen ob es bei der Abweichung einen Jahreswechsel gegeben hat. Dieser kann ins künftige als auch in das vorherige Jahr gehen.
				 * Die Abweichung kann beim UR-Wert als auch beim aktuellen Wert vorkommen.
				 *
				 * 1.
				 * Prinzipielle Formel bzw. wenn beide Werte im aktuellen Jahr liegen: UR_KW - aktuelle_KW.
				 * Ergebnis muss zur korrekten Darstellung mit -1 multipliziert werden.
				 *
				 * 2.
				 * Wenn der UR-Wert im vorherigen Jahr liegt, müssen die Restwochen des vorherigen Jahr zum aktuellen Wert addiert werden.
				 * Beispiel: UR_Wert=2017-48 aktueller Wert 2018-03 --> Formel: 53-48+3
				 * Das Ergebnis ist positiv und muss zur Darestellung NICHT mit -1 multipliziert werden.
				 *
				 * 3.
				 * Wenn der UR-Wert im künftigen Jahr gelegen hat muss vom aktuellen Wert die Restwochen ermittelt werden und zum UR-Wert addiert werden.
				 * Beispiel: UR_Wert=2019-04 aktueller Wert 2018-49 --> Formel: 49-53+4
				 * Das Ergebnis ist positiv (soll aber negativ dargestellt werden, da der Termin nach hinten verschoben wird) und muss zur Darestellung mit -1 multipliziert werden.
				 *
				 * 4.
				 * Wenn der aktuelle-Wert im künftigen Jahr liegt und der UR_Wert imn aktuellen Jahr liegt, muss vom aktuellen Wert die Restwochen ermittelt werden und zum UR-Wert addiert werden.
				 * Beispiel: aktueller_Wert=2017-48 UR_Wert 2018-03 --> Formel: 48-53+3
				 * Das Ergebnis ist positiv und muss zur Darestellung NICHT mit -1 multipliziert werden.
				 * */

				$end_week_year = substr($end_week,0,4);
				$ur_end_week_year = substr($ur_end_week,0,4);

				$ur_end_week_only = intval(substr($ur_end_week,4,2));
				$end_week_only = intval(substr($end_week,4,2));
				$abweichung='';

				//Endterminabweichung
				if ($ta == 'Pruefber'){
					//1.
					#$abweichung = ($ur_end_week_only-$end_week_only)*-1;
					($ur_end_week_year == date('Y') && $end_week_year == date('Y'))? $abweichung = ($ur_end_week_only-$end_week_only)*-1 : '';
					// 2.
					($ur_end_week_year < date('Y') && $end_week_year == date('Y'))? $abweichung= $weeks_of_cur_year-$ur_end_week_only+$end_week_only : '';
					//3.
					($ur_end_week_year > date('Y') && $end_week_year == date('Y'))? $abweichung= $weeks_of_cur_year-$end_week_only+$ur_end_week_only : '';
					//4.
					($end_week_year > date('Y') && $ur_end_week_year == date('Y'))? $abweichung= $weeks_of_cur_year-$ur_end_week_only+$end_week_only : '';

					($abweichung == 0 || $abweichung=='')?$abweichung='':$abweichung=sprintf("%+d",$abweichung);
				}
				else {
					$abweichung = ($ur_dauer - $dauer )*-1;
					($abweichung == 0 || $abweichung=='')?$abweichung='':$abweichung=sprintf("%+d",$abweichung);
				}

				( isset($model->{'Termin_'.$ta.'_Info1'}) && $model->{'Termin_'.$ta.'_Info1'}!='' ) ? $lieferant_verantw = $model->{'Termin_'.$ta.'_Info1'} : $lieferant_verantw = '&nbsp;';

				$soll_ist= '<div style="float:left;padding-right:5px;border-right:2px solid #fff;">'.$ur_end_week2.'</div>
						<div style="float:left;padding:0px 5px;border-right:2px solid #fff;">'.sprintf('%02d',$ur_dauer).'</div>
						<div>'.$abweichung.'</div>';

				$projekt_rows .='
						<div class="row">
						  <div class="col-md-1 label_project" style="background-color:'.$termin_background[$ta].';">'.$soll_ist.'</div>
						  <div class="col-md-1 label_project" style="background-color:'.$termin_background[$ta].';">'.$lieferant_verantw.'</div>
						  <div class="col-md-1 label_project" style="background-color:'.$termin_background[$ta].';">'.$termin_header[$ta].'</div>
						  <div class="col-md-9 " style="padding-left: 0px; padding-right: 0px;">
									<div class="row col-lg-12">
									'.$projekt_insert.'
								</div>
						  </div>
						</div> ';
			}
		}
	}

	$projekt_rows .='<div class="row"><hr style="width:100%;border:solid #777 1px; margin:4px;"></div>';
}

//Funktionsleiste für die Filterung und die Sortierung des Projektplans
if ($this->params['nav_header']!='Techniscreen'){
	$form = ActiveForm::begin([
		'method' => 'get',
		'type'=>ActiveForm::TYPE_INLINE,
		'action' => Url::to(['projekt/projektplan']),
	]);
	echo '<div class="projektnav"><span><b>Filter: </b></span>';
	echo Form::widget([
		'model'=>$searchModel,
		'form'=>$form,
		'attributes'=>[
			'Kunde'=>[
				'type'=>Form::INPUT_TEXT,
				],
			'WerkzeugNr'=>[
				'type'=>Form::INPUT_TEXT,
				],
			'refresh'=>[
			'type'=>Form::INPUT_RAW,
			'value'=>Html::submitButton('<span class="glyphicon glyphicon-refresh"></span>', ['class'=>'btn btn-primary'])
			],
			'create'=>[
			'type'=>Form::INPUT_RAW,
			'value'=>Html::a('<span class="glyphicon glyphicon-plus"></span>', ['create'],['type' => 'button', 'class' => 'btn btn-success'])
			]
		]
	]);
	echo '<span style="margin-left:40px;"><b>Sortierung: </b><span class="btn btn-default">'.
					$sort->link('WerkzeugNr') .
				'</span> <span class="btn btn-default">' .
					$sort->link('Termin_Pruefber_Ende').
				'</span></span></div>';
	#echo Html::a('<span class="glyphicon glyphicon-plus"></span>', ['create-project'],['type' => 'button', 'class' => 'btn btn-success']);
	ActiveForm::end();

}
else {
	echo '<div class="row" style="height:40px; width="100%"></div>';
}
?>

<?php ($this->params['nav_header'] != 'Techniscreen') ? $top_space= 110: $top_space= 60;?>

<div class="projektkalender">

<!-- Header START -->
<div class="row" style="position:fixed;top:<?=$top_space?>px; background:#fff; z-index:10;width: 100%;">
  <div class="col-md-1 bg-primary menu_header"><div class="header_content"><span style="font-size:10px;">Ur-Term. | Dauer | Abw.</span></div></div>
  <div class="col-md-1 bg-primary menu_header"><div class="header_content"><span style="font-size:10px;">Lieferant / Verantw.</span></div></div>
  <div class="col-md-1 bg-primary menu_header"><div class="header_content"><span style="font-size:10px;">Termine</span></div></div>
  <div class="col-md-9 " style="padding-left: 0px; padding-right: 0px;">
		<div class="row col-lg-12">
			<?= $jahre ?>
		</div>
		<div class="row col-lg-12">
			<?= $months ?>
		</div>
       <div class="row col-lg-12">
			<?= $weeks ?>
		</div>
  </div>
</div>
<!-- Header Ende -->

<!-- Pojektliste START -->
<div style="margin-top:<?=$top_space+42?>px;">
	<?= $projekt_rows; ?>



</div>
<div class="row" style="height:900px; width=100%"></div>
<!-- Pojektliste Ende -->

</div>
