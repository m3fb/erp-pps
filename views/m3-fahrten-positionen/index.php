<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\M3FahrtenPositionenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$name = Yii::$app->user->identity->firstname.' '.Yii::$app->user->identity->surename;
$this->title = 'Fahrten mit privaten PKW / '.$name;
#$this->params['breadcrumbs'][] = $this->title;
?>
<div class="m3-fahrten-positionen-index">

	<div class="row" style="margin-top:20px;">    
		<div class="col-md-12">
		  <p class="text-center"><h1><?= Html::encode($this->title )?></h1></p>
		</div>
	</div>
    <div class="row">    
		<div class="col-md-6">
		  <h2><i class="glyphicon glyphicon-retweet"></i>&nbsp;Umwegfahrten</h2>
		</div>
		<div class="col-md-6">
		  <h2><i class="glyphicon glyphicon-road"></i>&nbsp;Standardfahrten</h2>
		</div>
	</div>
	<div class="row" style="margin-top:20px;">    
		<div class="col-md-6">	
				
				<p><?= Html::encode('Die Option "Umweg" darf gewählt werden, wenn auf dem Weg zur Arbeit oder auf dem Heimweg ein Umweg gefahren werden muss um z.B. etwas abzuholen. 
				Beträgt die reine Umwegstrecke mehr als 16km, dann muss die Standard-Abrechung gewählt werden.')?></p>
				<p><?= Html::encode('Wenn man sich bereits auf der Arbeit befindet, mit dem privaten PKW eine Dienstfahrt durchführt und dann wieder zur Arbeit zurückkehrt, 
				muss ebenfalls die "Stanadard-Abrechnung" gewählt werden.')?></p>
			
		</div>
		<div class="col-md-6">
		  <p><?= Html::encode('Diese Option ist für alle Fahrten mit dem privaten PKW, bei denen es sich nicht um eine Umwegfahrt handelt. 
		  Für diese Fahrten gibt es eine Vergütung von 0,30 EUR / km. Es wird ein Auszahlungsbeleg erstellt und die Vergütung wird ausbezahlt oder überwiesen.')?></p>
		</div>
	</div>
	<div class="row" style="margin-top:20px;">    
		<div class="col-md-12">
		  <p class="text-center"><?= Html::a('erstellen', ['create'],['type' => 'button', 'class' => 'btn btn-success btn-lg']) ?></p>
		</div>
	</div>
	<?php 
		$gridcolumns = [
			['class' => 'yii\grid\SerialColumn'],
			['attribute' => 'Fahrtdatum',
							'format' => 'datetime',
			],
			['attribute' => 'von_Adresse1',
							'label'=>'von',
							'format' => 'html',
							'value'=>function ($model) {
								$adresse = $model->von_Adresse1.'<br>'.
											$model->von_Strasse.'<br>'.
											$model->von_PLZ.' '.$model->von_Ort;
								return $adresse;
							},
			
			],
			['attribute' => 'nach_Adresse1',
							'label'=>'nach',
							'format' => 'html',
							'value'=>function ($model) {
								$adresse = $model->nach_Adresse1.'<br>'.
											$model->nach_Strasse.'<br>'.
											$model->nach_PLZ.' '.$model->nach_Ort;
								return $adresse;
							},
			
			],
			['attribute' => 'Entfernung',
							'label'=>'Entf./ Vergütung',
							'format' => 'html',
							'value'=>function ($model) {
								if ($model->Typ == 1) {
									$enfernung = $model->Entfernung;
									$verguetung = Yii::$app->formatter->asCurrency($model->Verguetung);
									$ausgabe = $enfernung.' km / '.$verguetung;
									return $ausgabe;
								}
								else {
									$ausgabe = '- / €7,00';
									return $ausgabe;
								}
							},
			
			],
			['class' => 'yii\grid\ActionColumn'],
		
		];
		
		
	?>
	 
    <?php 
    if ($dataProviderUmweg->totalCount > 0) {
			echo GridView::widget([
			'dataProvider' => $dataProviderUmweg,
			#'filterModel' => $searchModelUmweg,
			'floatHeader'=>true,
			'pjax'=>true,
			'columns' => $gridcolumns,
			'toolbar' => false,
			'panel' => [
				'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-retweet"></i>&nbsp; Umwegfahrten</h3>',
				'type'=>'primary',
				'before' => false,
				'after' => false,
				'footer'=>false,
				],
		]); 
	}
    if ($dataProviderStandard->totalCount > 0) {
		echo GridView::widget([
			'dataProvider' => $dataProviderStandard,
			#'filterModel' => $searchModelStandard,
			'columns' => $gridcolumns,
			'panel' => [
				'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-road"></i>&nbsp; Standardfahrten</h3>',
				'type'=>'primary',
				'before' => false,
				'after' => false,
				'footer'=>false,
				],
		]);
	} 
    ?>
</div>
