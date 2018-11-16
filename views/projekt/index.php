<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjektChecklisteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'm3profile Projektverwaltung';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="m3-projekt-index">

  
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<div class="row">    
    <div class="col-md-6">
	  <h2>Projekte</h2>
	</div>
	<div class="col-md-6">
	  <h2>Projektplan</h2>
	</div>
</div>
<div class="row">    
    <div class="col-md-6">
	  <p>Erstellen und Verwalten der Projekte.</p>
	</div>
	<div class="col-md-6">
	  <p>Terminübersicht für alle offenen Projekte.</p>
	</div>
</div>
<div class="row">    
    <div class="col-md-6">
	  <p><a class="btn btn-primary btn-lg" href="<?=  Url::to(['projekt/checkliste_index']);?>" role="button">Projekt</a></p>
	</div>
	<div class="col-md-6">
	  <p><a class="btn btn-primary btn-lg" href="<?=  Url::to(['projekt/projektplan']);?>" role="button">Projektplan</a></p>
	</div>
</div>

</div>
