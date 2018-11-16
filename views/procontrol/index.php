<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Maschine;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\Url;

$maschinenListe = Maschine::find()->select(['WP_MA1.NO','WP_MA1.NAME'])->where(['TERMNO' => 0])->orderBy('NAME')->asArray()->all();




/* @var $this yii\web\View */
$this->title = 'Produktionsaufträge';
$this->params['breadcrumbs'][] = $this->title;


?>



<?php

	$this->registerCss("
	.custom {
		width: 150px !important;
	}
	");

	$buttons='';
	#var_dump($buttons);
	#var_dump($maschinenListe);
	$row=9;
	$i=0;
	$gesamt = count($maschinenListe);
	$counter=0;

	foreach ($maschinenListe as $m) {
		$url = Url::to(['procontrol/auswahl', 'linie'=>$m['NO']]);

		if ($i !=$row and $i !=0 ) {
			$buttons .= '<a class="btn btn-lg btn-default custom" style="margin-bottom:10px;" href='.$url.'>'.$m['NAME'].'</a>'."\n";
			$i++;
			$counter++;
		}
		elseif ($i == $row) {
			$buttons .= '<a class="btn btn-lg btn-default custom" style="margin-bottom:10px;" href='.$url.'>'.$m['NAME'].'</a></div></div>'."\n";
			$i=0;
			$counter++;
		}

		else {
			#$i=0;
			$buttons .= '<div class="col-lg-2"><div class="btn-group-vertical btn-group-lg" role="group" >'."\n".'<a class="btn btn-lg btn-default custom" style="margin-bottom:10px;" href='.$url.'>'.$m['NAME'].'</a>'."\n";
			$i++;
			$counter++;
		}

		if ($counter == $gesamt and $i-1 != $row) { //$i-1, da beim letzten Durchlauf $i nicht mehr erhöht werden darf.
			$buttons .= '</div></div>'."\n";
		}

	}


?>

		<?= $buttons; ?>
