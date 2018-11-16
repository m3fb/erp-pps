<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'Informationen zu den Gebinde-Etiketten';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Ab sofort gibt es nur noch die "Klebe-Etiketten", die wie gewohnt gemäß Verpackungsvorschrift auf die Gebinde geklebt werden. 
        Die DIN-A4- Gebindekennzeichnungen entfallen. 
        Im Folgenden werden Vorgehensweisen für spezielle Sonderfälle beschrieben.
    </p>
     <h3>Gebinde mit Kunden-Etiketten</h3>
    <p>Folgende Kunden stellen uns Ihre eigenen Etiketten zur Verfügung:
    <ul>
    <li>RIDI / Regent (Blindabdeckungen)</li>
    <li>IDL AG</li>
    <li>Jäger Gummi und Kunstoff GmbH (Sigenia)</li>
    </ul>
    Bei diesen Paletten kleben wir unser Etikett nur mit der halben Klebefläche auf, so dass dieses beim Warenausgang ohne Probleme wieder abgezogen werden kann.
    </p>
    
	 <div class="row">
	  
	 <div class="col-xs-6 col-md-3">
		<div class="thumbnail">
		  <img src="<?= Yii::$app->request->baseUrl ?>/images/IMG_0599.JPG" alt="IMG_0599.JPG">
			<div class="caption">
				<p>Klebefolie zur Hälfte abziehen</p>
		  </div>
		</div>
	  </div>
	  
	 <div class="col-xs-6 col-md-3">
		<div class="thumbnail">
		  <img src="<?= Yii::$app->request->baseUrl ?>/images/IMG_0600.JPG" alt="IMG_0600.JPG">
			<div class="caption">
				<p>Anbringung am Gitteraufsatzrahmen </p>
		  </div>
		</div>
	  </div>
	  
	 <div class="col-xs-6 col-md-3">
		<div class="thumbnail">
		  <img src="<?= Yii::$app->request->baseUrl ?>/images/IMG_0601.JPG" alt="IMG_0601.JPG">
			<div class="caption">
				<p>Anbringung bei IDL AG Holzkisten</p>
		  </div>
		</div>
	  </div>
	
	<div class="col-xs-6 col-md-3">
		<div class="thumbnail">
		  <img src="<?= Yii::$app->request->baseUrl ?>/images/IMG_0602.JPG" alt="IMG_0602.JPG">
			<div class="caption">
				<p>Anbringung an einer Langgutpalette</p>
		  </div>
		</div>
	  </div>
	  
	</div>


</div>
