<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use app\models\Procontrol;
use app\models\Auswertung;
$model = new Auswertung();

$this->registerCss("
.pagination > li > a,
.pagination > li > span {
    color: #3c763d; // use your own color here
}

.pagination > .active > a,
.pagination > .active > a:focus,
.pagination > .active > a:hover,
.pagination > .active > span,
.pagination > .active > span:focus,
.pagination > .active > span:hover {
    background-color: #3c763d;
    border-color: #3c763d;
 }
.my-grouped-tool {
	font-size:14px;
	font-weight:bold;
	background-color: #337ab7;
	color:#fff;
	}
.my-grouped-order {
	font-size:12px;
	font-weight:normal;
	background-color: #fcf8e3;
	color:#000;
	}
.my-warning {
	background-color: #d9534f;
	}

");


/* @var $this yii\web\View */
$this->title = 'Produktionsaufträge';
$this->params['breadcrumbs'][] = $this->title;


$this->registerJsFile(
    '@web/auslies2.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

#var_dump($kundentermin);
?>








<!--
    Unterbrechungsauswahl
-->


<div class="modal fade bde" id="Unterbrechungsmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-linie="<?php echo $model->get_linie($_SERVER['REMOTE_ADDR']) ?>" data-id="">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title" id="myModalLabel"> <div id="fehlermeldung" data-check="0">Unterbrechungsgrund angeben:</div></h4>
        <div id="unt-time"> </div>
        <div id="unt-ident" data-ident="5"> </div>
      </div>
      <div class="modal-body">
        <button type="button" class="btn btn-danger unterbrechungsmodal" data-meld="100">geplante Unterbrechung</button><br>
        <button type="button" class="btn btn-danger unterbrechungsmodal" data-meld="101">Abriss</button><br>
        <button type="button" class="btn btn-danger unterbrechungsmodal" data-meld="102">Sensor defekt</button><br>
        <button type="button" class="btn btn-danger unterbrechungsmodal" data-meld="103">Qualitätsproblem</button><br>
        <button type="button" class="btn btn-danger unterbrechungsmodal" data-meld="104">Bedienpersonal</button><br>
        <button type="button" class="btn btn-danger unterbrechungsmodal" data-meld="105">Wartung / Reinigung</button><br>
      </div>
      <div class="modal-footer unterbrechungsmodal-footer">
        <button type="button" class="btn btn-info ausblenden" data-dismiss="modal">Ausblenden</button>

      </div>
    </div>
  </div>
</div>
<!--
    Ende
-->


<!--
    "Start Stempel Vergessen" - Modal
-->


<div class="modal fade stempel" id="stempelmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">

        <h3 class="modal-title" id="myModalLabel"> Hinweis: </h3>
        <div id="unt-time"> </div>
      </div>
      <div class="modal-body">
        <div id="stempel-fehlertext"> </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info ausblenden" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>
<!--
    Ende
-->






<div class="col-lg-9">


  <?php
      yii\bootstrap\Modal::begin(['id' =>'modal1']);
      yii\bootstrap\Modal::end();
  ?>


	<?php # print_r($dataProvider); ?>
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        #'filterModel' => $searchModel,
        'summary' =>'{begin} - {end} von {totalCount}',
        'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
    		'headerRowOptions'=>['class'=>'kartik-sheet-style','style'=>'font-size:12px;'],
    		'floatHeader'=>true,
        'toolbar' => [
          [
              'content'=> Yii::$app->session->getFlash('msg'),
          ],
          '{toggleData}'
        ],
    		'pjax'=>true,
    		'rowOptions'=>function($model){
    								if($model['AG_Nr'] == 10){
    									return ['style'=>'border-top: 4px solid #d9534f;font-weight:bold;color:#d9534f; font-size:12px;'];
    									#return ['class' => GridView::TYPE_DANGER];
    								}
    								else return ['style'=>'font-size:12px;'];
    						},
            'columns' => [
    			['class' => 'kartik\grid\SerialColumn',
    				'header' => 'Nr.',
    				'headerOptions'=>['style'=>'width: 10px;']
    			],
    			[
    				'attribute' => 'COMMNO',
    				'label' => 'Wkz.',
    				'format' => ['text'],
    				'width'=>'100px',
    				'group'=>true,
    				'groupedRow'=>true,                    // move grouped column to a single grouped row
    				'groupOddCssClass'=>'my-grouped-tool',  // configure odd group cell css class
    				'groupEvenCssClass'=>'my-grouped-tool',
    			],
    			[
    				'attribute' => 'Auftrag',
    				'label' => 'Auftrag',
    				'format' => ['text'],
    				'group'=>true,  // enable grouping
    				'groupedRow'=>true,                    // move grouped column to a single grouped row
    				'groupOddCssClass'=>'my-grouped-order',  // configure odd group cell css class
    				'groupEvenCssClass'=>'my-grouped-order',
    				'subGroupOf'=>1	// Werkzeugnr. ist die Hauptgruppe
    			],
    			[
    				'class'=>'kartik\grid\ExpandRowColumn',
    				'width'=>'50px',
    				'value'=>function ($model, $key, $index, $column) {
              					return GridView::ROW_COLLAPSED;
              				},
    				'detail' =>  function ($model, $key, $index, $column) {
    					$model2 = Procontrol::getArtikel($model['ORNO']);
    					$model3 = Procontrol::getMeldung($model['ORNO']);

              return Yii::$app->controller->renderPartial('_auftrag-details', ['model2' => $model2,
    												'model3'=>$model3,
    												'akt_Stueckzahl'=>$model['akt_Stueckzahl'],
    												'Prod_zeit'=>$model['Prod_zeit']]);
                    },
            'disabled' => function ($model, $key, $index, $column) {
        					($model['AG_Nr']== 20) ? $v= false : $v= true;
        					return $v;
        				},
    				'headerOptions'=>['class'=>'kartik-sheet-style'],
    				'expandOneOnly'=>true,
    			],

    			[
    				'attribute' => 'IDENT',
    				'label' => 'Artikelnr.',
    				'width'=>'100px',
    				'group'=>true,
    				'subGroupOf'=>2,
    			],
    			[
    				'attribute' => 'Bezeichnung',
    				'label' => 'Bezeichnung',
    				'format' => ['text'],
    				'group'=>true,
    				'subGroupOf'=>2,
    			],
    			[
    				'attribute' => 'OPINFO',
    				'label' => 'AG-Info',
    				'format' => ['text'],
    				'contentOptions' => ['style' => 'color: #337ab7;'],
    				'group'=>true,
    				'subGroupOf'=>2,
    			],
    			[
    				'attribute' => 'PPARTS',
    				'label' => 'Sollstück',
    				'format' => ['decimal',2],
    				'group'=>true,
    				'subGroupOf'=> 2,
    			],
    			[
    				'attribute' => 'DELIVERY',
    				'label' => 'Liefertermin',
    				'format' => ['date'],
    				'group'=>true,
    				'subGroupOf'=>2,
    			],
    			[
    				'attribute' => 'AG_Nr',
    				'label' => 'AG-Nr.',
    			],
    			[
    				'attribute' => 'AG_Name',
    				'label' => 'AG-Bezeichnung',
    			],
    			[
    				'attribute' => 'Ruestzeit',
    				'label' => 'Rüstzeit',
    				'width'=>'100px',
    				'value' => function($model) {
    					if ($model['Ruestzeit'] == 0) {
    						 $ausgabe = '';
    						}
    					else {
    						$ausgabe =Yii::$app->formatter->asDecimal($model['Ruestzeit'],2).' Min.';
    					}
    				return $ausgabe;
    				}
    			],
    			[
    				'attribute' => 'Stueckzeit',
    				'label' => 'Stückzeit',
    				'width'=>'100px',
    				'value' => function($model) {
    					if ($model['Stueckzeit'] == 0) {
    						 $ausgabe = '';
    						}
    					else {
    						$ausgabe =Yii::$app->formatter->asDecimal($model['Stueckzeit'],2).' min.';
    					}
    				return $ausgabe;
    				}
    			],
    			[
    				'attribute' => 'Laufzeit ges.',
    				'label' => 'Laufzeit',
    				'width'=>'100px',
    				'value' => function($model) {
    					if ($model['Stueckzeit'] == 0) {
    						 $ausgabe = '';
    						}
    					else {
    						$ausgabe =Yii::$app->formatter->asDecimal($model['Laufzeit'],2).' Std.';
    					}
    				return $ausgabe;
    				}
    			],
    			[
    				'attribute' => 'akt_Stand',
    				'label' => 'fertig',
    				'width'=>'100px',
    				'value' => function($model) {
    					if ($model['Stueckzeit'] == 0) {
    						 $ausgabe = '';
    						}
    					else {
    						$ausgabe =Yii::$app->formatter->asPercent($model['akt_Stand'],0);
    					}
    				return $ausgabe;
            }
    			],
          [
            'attribute' => 'auftragsAktion',
            'value' => function($model) use ($startedTasks,$linie) {
              $taskState = Procontrol::getOperationState($model['ORNO'],$model['SEQNUM']);
              #$startedTasks = Procontrol::getStartedTasks($model['PWPLACE']);
              ($taskState == '400') ? $symbol = 'glyphicon-pause': $symbol = 'glyphicon-play' ;
              $ausgabe='';

              // Klasse für das Ausblenden der Buttons
              // Bei AG 20 "extrudieren, prüfen ...."  werde die Buttons nicht ausgeblendet.
              // Da die Produktionsmitarbeiter auch Anlagen anfahren, wurde AG 15 "anfahren" hinzugefügt.
              ( !in_array($model['AG_Nr'],[15,20]) ) ? $meldeButton  = 'melde-button' : $meldeButton  = '';

                //prüfen ob bereits ein Auftrag gestartet wurde
                if ($startedTasks >0 ){
                  ($startedTasks==1 ) ? $status = false : $status = true;

                  //aktive Aufträge
                  if ($taskState == '300'){ // prüfen ob der aktuelle Auftrag läuft
                    if ($model['AG_Nr']==20){
                      $ausgabe =
                        Html::a('<span class="glyphicon glyphicon-share"></span>', // Rückmeldebutton
                          ['create-rueckmeldung',
                            'id'=>$model['NO'],
                            'linie' => $linie,
                          ],
                          ['class'=> 'btn btn-primary '.$meldeButton,'disabled'=>$status]);
                    }
                    else
                    $ausgabe =
                      Html::a('<span class="glyphicon glyphicon-pause"></span>', // Pausebutton
                          ['status-ag',
                            'id'=>$model['NO'],
                            'status'=>400,
                            'linie' => $linie,
                          ],
                        ['class'=> 'btn btn-warning '.$meldeButton,'disabled'=>$status])
                        .'<div style="margin-top:10px;"></div>'.
                        Html::a('<span class="glyphicon glyphicon-stop"></span>', // Stopbutton
                          ['status-ag',
                            'id'=>$model['NO'],
                            'status'=>500,
                            'linie' => $linie,
                          ],
                          ['class'=> 'btn btn-danger '.$meldeButton,'disabled'=>$status]);

                  }
                  // passive Aufträge
                  else{
                    $ausgabe =
                      Html::button('<span class="glyphicon '.$symbol.'"></span>',['class'=> 'btn btn-default '.$meldeButton,'disabled'=>true]); //Start oder Pausebutton
                  }
                }
                // Wenn an einer Linie kein Auftrag aktiv ist, gibt es nur die Möglichkeit, dass
                // entweder unterbrochene (400) oder noch nicht gestartete Aufträge (ohne LBDC-Eintrag) vorhanden sind.
                else {
                  ($taskState == '400') ? $smbol = 'glyphicon-pause': $smbol = 'glyphicon-play' ;
                  ($taskState == '400') ? $class = 'warning': $class = 'success' ;
                  $ausgabe =
                    Html::a('<span class="glyphicon '.$symbol.'"></span>',
                      ['status-ag',
                        'id'=>$model['NO'],
                        'status' => 300,
                        'linie' => $linie,
                      ],
                      ['class'=> 'btn btn-'.$class .' '.$meldeButton]);
                }

              return $ausgabe;
            },
            'format' => 'raw',
            'label' => false,
          ]
    		],
            'panel' => [
          			'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-list"></i>&nbsp; Offene Aufträge <b>'.$maschine->NAME.'</b></h3>',
          			'type'=>'success',
          			'footerOptions'=>['class'=>'panel-footer'],
          			],
    		'export' => false,
    		'responsive'=>false,
    		'hover'=>false
    		]);
?>
</div>
<div class="col-lg-3">

	<div>
			<?= GridView::widget([
				'dataProvider' => $dataBde,
				'summary' => '',
				'headerRowOptions'=>['class'=>'kartik-sheet-style'],
				'rowOptions'=>['style'=>'font-size:9px;'],
				'columns' => [
					[
						'attribute' => 'MSTIME',
						'label' => 'Meldezeit',
						'format' => ['datetime'],
					],
					[
						'attribute' => 'PERSNAME',
						'label' => 'Name',
					],
					[
						'attribute' => 'ADCCOUNT',
						'label' => 'Menge',
						'format' => ['decimal',2],
					],
					[
						'attribute' => 'STATUS',
						'label' => 'Status',
						'format' => ['html'],
						'value' => function($model) {
							if ($model['STATUS'] == 300) {
								 $ausgabe = $model['ORNAME'].'<br>AG-'.$model['AG_Nr'].' Start';
								}
							elseif ($model['STATUS'] == 400) {
								 $ausgabe = $model['ORNAME'].'<br>AG-'.$model['AG_Nr'].' Unterbr.';
								}
							elseif ($model['STATUS'] == 500) {
								 $ausgabe = $model['ORNAME'].'<br>AG-'.$model['AG_Nr'].' Ende';
								}
							else {
								$ausgabe ='';
							}
					return $ausgabe;
					}
				],
				],
				'panel' => [
					'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;aktuelle BDE - Meldungen <b>'.$maschine->NAME.'</b></h3>',
					'type'=>'success',
					'footer'=>false,
					],
				'export' => false,
				'toolbar' => false,
				]);


			?>
	</div>
	<div>
		<div class="panel panel-success">
			<div class="panel-heading"><h3 class="panel-title"><i class="glyphicon glyphicon-wrench"></i> &nbsp;Produktionsdaten&nbsp; &nbsp; <b><?= $maschine->NAME ?></b></h3></div>
			<div class="panel-body" style="font-size:12px;">

				<?php if ($currentSpeed and $currentSpeed->log_GESCHWINDIGKEIT < 0.1): ?>
					<p>Status: keine Produktion</p>
					<p></p>
					<p><?php echo 'Die Maschine steht seit: '.$interval->d.' Tag/e '. $interval->h .' Stunde/n ' .$interval->i. ' Minute/n'; ?></p>
				<?php endif; ?>

				<?php if ($currentSpeed and $currentSpeed->log_GESCHWINDIGKEIT > 0.1): ?>
					<p>Status: Die Anlage läuft</p>
					<p id="geschwindigkeit"><?php echo ($kundentermin!=1) ? 'aktuelle Geschwindigkeit: '. Yii::$app->formatter->asDecimal($currentSpeed->log_GESCHWINDIGKEIT,3).' m/min':'-' ?></p>
					<p></p>
					<p><?php echo 'Die Maschine läuft seit: '.$interval->d.' Tag/e '. $interval->h .' Stunde/n ' .$interval->i. ' Minute/n'; ?></p>
				<?php endif; ?>
				<?php if (!$currentSpeed): ?>
					<p>Keine Daten vorhanden</p>
				<?php endif; ?>


                <!--
                <a href="http://<?php #echo $_SERVER['REMOTE_ADDR'];?>/kalibrier.php"> Sensorkalibrierung (Test) </a>
                -->
			</div>
		</div>

    <div class="panel panel-success">
      <div class="panel-heading"><h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> &nbsp;Benutzerinformationen</h3></div>
      <div class="panel-body" style="font-size:12px;">

        <?php if (empty($userInfo)): ?>
          <div>kein Benutzer angemeldet</div>
        <?php endif; ?>

        <?php if (!empty($userInfo)): ?>
          <div class="pull-left">Angemeldet als: &nbsp;</div>
          <div class="pull-left" id="persno"><b><?php echo $userInfo['persno']?></b></div>
          <div class="pull-left"> &nbsp; / &nbsp; </div><div id="name"><b><?php echo $userInfo['vorname'].' '.$userInfo['nachname']?></b></div>
        <?php endif; ?>

                <a href="http://<?php echo $_SERVER['REMOTE_ADDR'];?>/kalibrier.php"> Sensorkalibrierung (Test) </a>
      </div>
    </div>
	</div>
</div>
