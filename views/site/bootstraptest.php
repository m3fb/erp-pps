<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use app\assets\AppAsset;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
$this->title = 'Bootstraptest';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("@web/css/projekt_kalender.css");

//Rasterwert von 12 bis 52
$wochenraster = 52;
$cu_year = date( "Y");
//$cu_year = 2018;

$tage_gesamt = $wochenraster * 7;
$wochen_width= 100 / $wochenraster;
$current_week_no = date ( "W" );

$w=$current_week_no; //Startwochen; default sollte $current_week_no sein; Kann evtl. über Parameter gesteuert werden

$background=[0=>'#f2dede', 1=>'#d9edf7',2=>'#dff0d8'];
$bi =0;  //background-index
$year =$cu_year;
$weeks_of_cur_year = getIsoWeeksInYear($cu_year);
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


$y=1; //Index zum Jahre zählen. Muss auf 1 stehen.

$w1 = sprintf('%02d', $w);
$erster_montag_ges = strtotime("{$cu_year}-W{$w1}"); //Montag der ersen Woche im Raster als Datum ermitteln für die Resttageberechnung



$weeks='';
$months='';
$jahre='';
$jahres_width = 0;
$tg = $tage_gesamt;

//Raster anlegen

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
		$w++;
	}
	else {  //... Jahreswechsel; Wochennummer zrücksetzen und Jahr + 1
		
		$w =1;
		
		$weeks .= '<div class="cu_weeks" style="width:'.$wochen_width.'%">'.sprintf('%02d', $w).'</div>';
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

#$w1 = sprintf('%02d', $w-1);
#$letzter_sonntag = strtotime("{$end_year}-W{$w1}-7");
/*if($end_year > $cu_year) {// prüfen ob Jahreswechsel stattgefunden hat.
	$jahrestage = date("z", mktime(0,0,0,12,31,$cu_year));
	$tageszahl_start = date("z", $erster_montag_ges);
	$jahres_kapaz = $jahrestage - $tageszahl_start;
	$jahres_width = 100 /  $tg * $jahres_kapaz;
	$jahre_name = date("Y", $erster_montag_ges);
	$jahre .= '<div class="cu_year bg-primary" style="width:'.$jahres_width.'%">'.$jahre_name.'</div>';
	
}

else {
	$end_year = $cu_year;
	
}  */


$dateFormat = 'MMMM'; # Long Month Names




function getIsoWeeksInYear($year) {
    $date = new DateTime;
    $date->setISODate($year, 53);
    return ($date->format("W") === "53" ? 53 : 52);
}



?>
<div class="site-about">

<div class="row" style="position:fixed;top:100px; z-index:10;width: 100%;">
  <div class="col-md-1 bg-primary menu_header"><div class="header_content">Projekte</div></div>
  <div class="col-md-11 " style="padding-left: 0px; padding-right: 0px;">
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
<div style="margin-top:80px;">  
<div class="row">
  <div class="col-md-1 bg-warning"><div class="label_content">Punkt 1</div></div>
  <div class="col-md-11 " style="padding-left: 0px; padding-right: 0px;">
		<div class="row col-lg-12">
			<div class="cu_blank" style="width:9.5%;height:100%;"></div>
			<div class="cu_red" style="width:38%;height:100%;"></div>
			<div class="cu_blank" style="width:51.3%;height:100%"></div>
		</div>
  </div>
</div> 
<div class="row">
  <div class="col-md-1 bg-warning"><div class="label_content">Punkt 1</div></div>
  <div class="col-md-11 " style="padding-left: 0px; padding-right: 0px;">
		<div class="row col-lg-12">
			<div class="cu_blank" style="width:9.5%;height:100%;"></div>
			<div class="cu_red" style="width:38%;height:100%;"></div>
			<div class="cu_blank" style="width:51.3%;height:100%"></div>
		</div>
  </div>
</div> 

<?php 
for ($i=1; $i<40; $i++){
echo '	
<div class="row">
  <div class="col-md-1 bg-warning"><div class="label_content">Punkt 2</div></div>
  <div class="col-md-11 " style="padding-left: 0px; padding-right: 0px;">
			<div class="row col-lg-12">
			<div class="progress" style="margin-bottom:4px;">
			  <div class="progress-bar progress-bar-success" style="width: 30%; background-color:#fff;"></div>
			  <div class="progress-bar progress-bar-warning progress-bar-striped" style="width: 20%"></div>
			  <div class="progress-bar progress-bar-danger" style="width: 40%"></div>
			</div>
		</div>
  </div>
</div> ';
}
?>
    

		
</div>		
		
		


</div>
		</div>

    </p>
<?php
Modal::begin([
    'header' => '<h2>Hello world</h2>',
    'toggleButton' => ['label' => 'click me', 'class'=>'btn btn-primary'],
]);

echo 'Say hello...';

Modal::end();
?>

</div>
