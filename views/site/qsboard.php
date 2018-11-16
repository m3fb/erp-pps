<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Carousel;

/* @var $this yii\web\View */
$this->title = 'QS-Board';
$this->params['breadcrumbs'][] = $this->title;

$script = 

  "
  .carousel-caption {
    position: relative;
    left: auto;
    right: auto;
    #text-align: left;
    #padding-left: 120px;
}; 
.carousel .container {
  background-color: black;
}

.carousel-inner > .item > img {
    margin: 0 auto;
    width: auto;
	height: 625px;
	max-height: 625px;
}

.carousel .item {
  background-color: black;
}

.carousel-control.left, .carousel-control.right {
    background-image: none
}


";

$script2 = "$('.carousel').carousel({
  interval: 9000
})";

$this->registerCss($script);
$this->registerJs($script2);
ini_set('memory_limit', '-1');
$items='';
#print_r($dataProvider);
foreach ($dataProvider as $model) {
	$rek_id = $model['REK_ID'];
	$rek_datum = Yii::$app->formatter->asDate($model['Reklamationsdatum']);
	$image = $model['Image'];
	$problem = $model['Problembeschreibung'];
	$werkzeug = $model['Form_Nummer'];
	($werkzeug) ? $ausgabe_werkzeug = '<small>  Werkzeug: </small><b>'.$werkzeug.'</b></br>' : $ausgabe_werkzeug ='';
	$artikelnr = $model['Teilenummer'];
	$artikelbezeichnung = $model['Langebezeichnung'];
	$firma = $model['Firma'];
	
	if ($image != NULL){
		$content = "<img src='data:image/jpeg;base64,".base64_encode(hex2bin($image))."' alt='Bildfehler'/>";
	}
	else {
		$content = "<img src='images/KeinBild.jpg' alt='n.a.'/>";
	}

	$items[] =['content' => $content,
			'caption' => 	'</br><small>Reklamation Nr.:</small> <b>'.$rek_id.'</b>
							  <small>   Firma:</small> <b>'.$firma.'</b>
							   <small>   Rek.Datum:</small> <b>'.$rek_datum.'</b></br>'
							 .$ausgabe_werkzeug.
							 '<small>Art. Nr.:</small> <b>'.$artikelnr.'</b><small>   Bezeichnung: </small><b>'.$artikelbezeichnung.'</b></br
							<p><small>Problembeschreibung: </small><b>'.$problem.'</b></p>',
			#'options' => ['class'=>'carousel slide','interval' => '900000']
			];



}

?>


<div class="col-lg-12">
	<div class="page-header"><h3></h3></div> 
	<div class="container" >
    <div class="row clearfix">
        <div class="col-md-12 column">
            <?php echo Carousel::widget(
				[
            'items' => $items
            ]); 
            ?>
       </div>
   </div>

</div>
	
</div>
<div class="col-lg-12">
	<div style=' clear: both;'><hr style=' border:1px solid;'></div>
	<div class="page-header"><h3></h3></div> 
</div>

<? 


#print_r($orders);
#print_r($nextOrders);
#print_r($activeMachines);
?>
