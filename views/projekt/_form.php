<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\M3ProjektCheckliste */
/* @var $form yii\widgets\ActiveForm */
?>


<?php
$this->registerJsFile("@web/js/projekt.js",
						['depends' => [\yii\web\JqueryAsset::className()]]
						);


?>



<div class="m3-projekt-checkliste-form">
	<?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL, 'formConfig'=>['labelSpan'=>4]]); ?>
	<div class="panel panel-primary">
	  <div class="panel-heading">Allgemeine Informationen</div>
	  <div class="panel-body">

		  <?php
			echo Form::widget([ // fields with labels
				'model'=>$model,
				'form'=>$form,
				'columns'=>2,
				'attributes'=>[
					'WerkzeugNr'=>['label'=>'Werkzeug Nr.:', 'options'=>['placeholder'=>'W....']],
					'Kunde'=>['label'=>'Kunde:', 'options'=>['placeholder'=>'Kunde...']],
					'Artikelnummer'=>['label'=>'Artikel Nr.:', 'options'=>['placeholder'=>'Artikel Nr...']],
					'Profilbezeichnung'=>['label'=>'Profilbez.:', 'options'=>['placeholder'=>'Profilbez...']],
					'Projektkoordinator'=>['label'=>'Projekt-Koord..:', 'options'=>['placeholder'=>'Projektkoordination...']],
				]
			]);
			echo Form::widget([
					'model'=>$model,
					'form'=>$form,
					'columns'=>2,
					'attributes'=>[
						'Vorgangsnummer'=>[
									'type'=>Form::INPUT_DROPDOWN_LIST,
									'items' => ArrayHelper::map($openProjects,'TXTNUMMER','Orderinfo'),
									'label'=>'Vorgangsnr.',
									'options'=>['placeholder'=>'Vorgangsnr...']
								],
						'zeichnungs_detail' => [
							'label'=>'Zeich.nr./Ind.',
							'labelSpan'=>2,
							'columns'=>4,
							'attributes'=>[

								'Zeichnungsnummer'=>[
									'type'=>Form::INPUT_TEXT,
									'options'=>['placeholder'=>'Zeichnungsnr...'],
									'columnOptions'=>['colspan'=>2],
								],
								'Index'=>[
									'type'=>Form::INPUT_TEXT,
									'options'=>['placeholder'=>'Index...']
								],
							]
						]
					]
				]);

		  ?>
	</div>
	</div>
<div class="panel panel-primary">
  <div class="panel-heading">Informationen für Produktion und Technikum</div>
  <div class="panel-body">
	  <?php
		echo Form::widget([ // fields with labels
			'model'=>$model,
			'form'=>$form,
			'columns'=>2,
			'attributes'=>[
				'geforderterMindestausstoss'=>['label'=>'geford. Mindestausst. [m/min.]:', 'options'=>['placeholder'=>'Mindestausstoss....']],
				'kalkulierterAusschuss'=>['label'=>'kalk. Ausschuss[%]:', 'options'=>['placeholder'=>'Ausschuss...']],
			]
		]);
		echo Form::widget([ // fields with labels
			'model'=>$model,
			'form'=>$form,
			'columns'=>2,
			'attributes'=>[
				'geplanterExtruder'=>['label'=>'geplanter Extruder:', 'options'=>['placeholder'=>'Extruder...']],
				'Einheit'=>['label'=>'Einheit', 'items'=>[0=>'Stück', 1=>'Meter'], 'type'=>Form::INPUT_RADIO_BUTTON_GROUP],
			]
		]);
		?>
			<hr></hr>
			<div class="row">
			  <div class="col-md-2"><label>Gewicht / Bedarfe</label></div>
			  <div class="col-md-4"><label>Art. Nr.</label></div>
			  <div class="col-md-5"><label>Bezeichnung</label></div>
			  <div class="col-md-1"><label>[g/m]</label></div>
			</div>

		<?php
		echo Form::widget([
			'model'=>$model,
			'form'=>$form,
			'columns'=>1,
			'attributes'=>[
				'rohmaterial_detail' => [   // complex nesting of attributes along with labelSpan and colspan
					'label'=>'Kunstst. 1',
					'labelSpan'=>2,
					'columns'=>6,
					'attributes'=>[
						'RM1_Art_Nr'=>[
							'type'=>Form::INPUT_TEXT,
							'columnOptions'=>['colspan'=>3,'class'=>'col-md-4'],
						],
						'RM1_Bezeichnung'=>[
							'type'=>Form::INPUT_TEXT,
							'columnOptions'=>['colspan'=>2,'class'=>'col-md-6'],
						],
						'RM1_Gewicht'=>[
							'type'=>Form::INPUT_TEXT,
							'options' => ['id'=>'RM1_Gewicht'],
							'columnOptions'=>['class'=>'col-md-2'],
						]
					]
				],
				'rohmaterial_detail2' => [   // complex nesting of attributes along with labelSpan and colspan
						'label'=>'Kunstst. 2',
						'labelSpan'=>2,
						'columns'=>6,
						'attributes'=>[
								'RM2_Art_Nr'=>[
								'type'=>Form::INPUT_TEXT,
								'columnOptions'=>['colspan'=>3,'class'=>'col-md-4'],
							],
							'RM2_Bezeichnung'=>[
								'type'=>Form::INPUT_TEXT,
								'columnOptions'=>['colspan'=>2,'class'=>'col-md-6'],
							],
							'RM2_Gewicht'=>[
								'type'=>Form::INPUT_TEXT,
								'options' => ['id'=>'RM2_Gewicht'],
								'columnOptions'=>['class'=>'col-md-2'],
							],
						]
					],
				'rohmaterial_detail3' => [   // complex nesting of attributes along with labelSpan and colspan
						'label'=>'Kupfer 1',
						'labelSpan'=>2,
						'columns'=>6,
						'attributes'=>[
								'CU1_Art_Nr'=>[
								'type'=>Form::INPUT_TEXT,
								'columnOptions'=>['colspan'=>3,'class'=>'col-md-4'],
							],
							'CU1_Bezeichnung'=>[
								'type'=>Form::INPUT_TEXT,
								'columnOptions'=>['colspan'=>2,'class'=>'col-md-6'],
							],
							'CU1_Gewicht'=>[
								'type'=>Form::INPUT_TEXT,
								'options' => ['id'=>'CU1_Gewicht'],
								'columnOptions'=>['class'=>'col-md-2'],
							],
						]
					],
				'rohmaterial_detail4' => [   // complex nesting of attributes along with labelSpan and colspan
						'label'=>'Kupfer 2',
						'labelSpan'=>2,
						'columns'=>6,
						'attributes'=>[
								'CU2_Art_Nr'=>[
								'type'=>Form::INPUT_TEXT,
								'columnOptions'=>['colspan'=>3,'class'=>'col-md-4'],
							],
							'CU2_Bezeichnung'=>[
								'type'=>Form::INPUT_TEXT,
								'columnOptions'=>['colspan'=>2,'class'=>'col-md-6'],
							],
							'CU2_Gewicht'=>[
								'type'=>Form::INPUT_TEXT,
								'options' => ['id'=>'CU2_Gewicht'],
								'columnOptions'=>['class'=>'col-md-2'],
							],
						]
					]
			]
		]);

	  ?>
			<div class="row">
			  <div class="col-md-7"></div>
			  <div class="col-md-2"><label>Gewicht ges.:</label></div>
			  <div class="col-md-3">
						<?php
						echo Form::widget([
							'model'=>$model,
							'form'=>$form,
							'columns'=>1,
							'attributes'=>[
								'Gewicht_gesamt'=>['label'=>'', 'options'=>['id'=>'sum','readonly' => true]]
							]
						]);
					  ?>
				</div>
			</div>
	<?php
		echo Form::widget([
			'model'=>$model,
			'form'=>$form,
			'columns'=>1,
			'attributes'=>[
				'Peripherie'=>['label'=>'Peripherie/ Weiterb.:', 'options'=>['placeholder'=>'Peripherie / Weiterbearb.....']]
			]
		]);
	  ?>
  </div>
</div>
<div class="panel panel-primary">
  <div class="panel-heading">Auftragsbestätigung an Kunden</div>
  <div class="panel-body">
	  <?php
		echo Form::widget([       // 1 column layout
			'model'=>$model,
			'form'=>$form,
			'columns'=>1,
			'attributes'=>[
				'Versandadresse_Muster'=>['type'=>Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Versandadresse Muster...']]
			]
		]);
		echo Form::widget([
			'model'=>$model,
			'form'=>$form,
			'columns'=>2,
			'attributes'=>[
				'Kontaktperson'=>['label'=>'Kontaktperson:', 'options'=>['placeholder'=>'Kontaktperson.....']],
				'Mindestbestellmenge'=>['label'=>'Mindestbestellmenge:','options'=>['placeholder'=>'Mindestbestellmenge....']],
				'Zahlungsbed_Werkzeug'=>['label'=>'Zahlungsbed. Werkz.:', 'options'=>['placeholder'=>'Zahlungsbed. Werkz......']],
				'Lieferbedingungen'=>['label'=>'Lieferbedingungen:', 'items'=>[0=>'DDP', 1=>'EXW'], 'type'=>Form::INPUT_RADIO_BUTTON_GROUP],
			]
		]);
	  ?>
  </div>
</div>
<div class="panel panel-primary">
  <div class="panel-heading">Information für Bemusterung / QS</div>
  <div class="panel-body">
	  <?php
echo Form::widget([
			'model'=>$model,
			'form'=>$form,
			'columns'=>2,
			'attributes'=>[
				'Muster_Kunde_Anz'=>['label'=>'Anz. Muster f. Kund.:', 'options'=>['placeholder'=>'Anzahl Muster für den Kunden.....'],'columnOptions'=>['class'=>'col-md-7'],],
				'Muster_Kunde_Laenge'=>['label'=>'Länge:','options'=>['placeholder'=>'Länge der Muster für den Kunden....'],'columnOptions'=>['class'=>'col-md-5'],],
				'Muster_Vermess_Anz'=>['label'=>'Anz. Muster zum Verm.:', 'options'=>['placeholder'=>'Anzahl Muster zum Vermessen....'],'columnOptions'=>['class'=>'col-md-7'],],
				'Muster_Vermess_Laenge'=>['label'=>'Länge:','options'=>['placeholder'=>'Länge der Muster zum Vermessen....'],'columnOptions'=>['class'=>'col-md-5'],],
				'Muster_Verbleib_Anz'=>['label'=>'Anz. Muster m3profile.:', 'options'=>['placeholder'=>'Anzahl Muster zum Verbleib bei m3profile....'],'columnOptions'=>['class'=>'col-md-7'],],
				'Muster_Verbleib_Laenge'=>['label'=>'Länge:','options'=>['placeholder'=>'Länge der Muster zum Verbleib bei m3....'],'columnOptions'=>['class'=>'col-md-5'],],
			]
		]);
		echo Form::widget([
			'model'=>$model,
			'form'=>$form,
			'columns'=>1,
			'attributes'=>[
				'sonst_Info_Bemusterung'=>['label'=>'sonstige Infos*:', 'type'=>Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'sonstige Infos Bemusterung...']],
			]
		]); ?>
		<div class="row"><span class="col-md-12"><small><i>*z.B. 100% Prüfung, kritische funtionsr. Merkmale,FMEA, IMDS,
							Kugeldruckprüfung, Geruch RPZ-Vorgabe, Kunden EMP,
							Prüfmittel festlegen, Arbeitsabläufe definieren</i></small></span>
		</div>
		<div class="row"><hr></div>

<?php
		echo Form::widget([
			'model'=>$model,
			'form'=>$form,
			'columns'=>1,
			'attributes'=>[
				'Verpackung_Muster'=>['label'=>'Verpackung Musterteile:', 'options'=>['placeholder'=>'Verpackung der Musterteile....']],
				'Verpackung_Serie'=>['label'=>'Verpackung Serienteile:', 'options'=>['placeholder'=>'Verpackung der Serienteile....']],
				'erste_Serien_Menge'=>['label'=>'1. Serienmenge:','options'=>['placeholder'=>'erste Serienbestellung (Menge)....','format'=>'decimal']],
			]
		]);
		echo Form::widget([
			'model'=>$model,
			'form'=>$form,
			'columns'=>2,
			'attributes'=>[
				'Verp_stellt_Kunde'=>['label'=>'Verpack. stellt Kunde:', 'items'=>[0=>'Nein', 1=>'Ja'], 'type'=>Form::INPUT_RADIO_BUTTON_GROUP],
				'Verp_zahl_Kunde'=>['label'=>'Verpack. zahlt Kunde:', 'items'=>[0=>'Nein', 1=>'Ja'], 'type'=>Form::INPUT_RADIO_BUTTON_GROUP],
			]
		]);
	  ?>
  </div>
</div>
<?php if (Yii::$app->user->identity && in_array(Yii::$app->user->identity->username, ['mrotter','mheim', 'fbogenreuther'])): ?>
<div class="panel panel-primary">
  <div class="panel-heading">Information Termine <small><i>(Wird ein Terminelement nicht benötigt, muss bei Dauer "<b>0</b>" eingetragen werden.)</i></small></div>
  <div class="panel-body">
	  <div class="row" style="margin:5px;">
		  <div class="col-md-3" style="text-align:right;"><label>Endtermin auswählen:</label></div>
		  <div class="col-md-9">

			  <?php

			echo DatePicker::widget([
				'name' => 'dp_6',
				'type' => DatePicker::TYPE_BUTTON,
				'value' => $model->Termin_Pruefber_Ende,
				'pluginOptions' => [
					'format' => 'yyyy-mm-dd',
					'calendarWeeks' => true,
					'autoclose' => true,
				],
				'options'=> ['id'=>'DP_Termin_Pruefber_Ende'],
			]);
			?>
			</div>
	 </div>



		<?php
		//Projekttermine
		$projekt_termine=['ext_Bem','int_Bem','Einfahren','WZBau','Konst'];
		$termin_header = [
			'Konst'=>'Konstruktion',
			'WZBau'=>'Werkzeugbau',
			'RM'=>'Rohmaterial',
			'Einfahren'=>'Einfahren',
			'Vorrichtung'=>'Vorrichtung',
			'Linie'=>'Linie',
			'Verpackung'=>'Verpackung',
			'int_Bem'=>'int. Bemusterung',
			'ext_Bem'=>'Lieferzeit Muster',
			'Pruefber'=>'Prüfbericht beim Kunden',
			] ;

		$pt_row='';
		$zt_row='';
		$sonst_row='';
		$pt_hidden='';
		$zt_hidden='';
		$sonst_hidden='';
		$bez_max_length= 16;
		$lief_max_length=16;

		foreach($projekt_termine as $pt){
			#$pt_ter = rawTermin($model->Termin_Vorrichtung_Ende, 'Vorrichtung','RAW_Vorrichtung_Ende');
			($pt == 'WZBau') ? $lieferant = '<div class="col-md-5">'.$form->field($model, 'Termin_'.$pt.'_Info1')->textInput(['id'=>'Termin_'.$pt.'_Info1','maxlength'=>$lief_max_length])->label(false).'</div>' :
								$lieferant = '<div class="col-md-5">&nbsp;</div>';
			$pt_row .= '<div class="col-md-5" style="border-bottom:1px solid !important;">'. rawTermin($model->{'Termin_'.$pt.'_Ende'},$termin_header[$pt], 'RAW_'.$pt.'_Ende').'</div>
					<div class="col-md-2">'.$form->field($model, 'Termin_'.$pt.'_Dauer')->textInput(['id'=>'Termin_'.$pt.'_Dauer'])->label(false).'</div>'.
					$lieferant.'
					<div class="col-md-12" id="RAW_'.$pt.'_Ende_error"></div>';
			$pt_hidden .= '<div>'.$form->field($model, 'Termin_'.$pt.'_Ende')->hiddenInput(['id'=>'Termin_'.$pt.'_Ende'])->label(false).'</div>';
				}

		$zus_termine=['RM','Vorrichtung','Linie','Verpackung'];
		foreach($zus_termine as $zt){
			#$zt_ter = rawTermin($model->Termin_Vorrichtung_Ende, 'Vorrichtung','RAW_Vorrichtung_Ende');
			$zt_row .= '<div class="col-md-5" style="border-bottom:1px solid !important;">'. rawTermin($model->{'Termin_'.$zt.'_Ende'},$termin_header[$zt], 'RAW_'.$zt.'_Ende').'</div>
					<div class="col-md-2">'.$form->field($model, 'Termin_'.$zt.'_Dauer')->textInput(['id'=>'Termin_'.$zt.'_Dauer'])->label(false).'</div>
					<div class="col-md-5">'.$form->field($model, 'Termin_'.$zt.'_Info1')->textInput(['id'=>'Termin_'.$zt.'_Info1','maxlength'=>$lief_max_length])->label(false).'</div>
					<div class="col-md-12" id="RAW_'.$zt.'_Ende_error"></div>';
			$zt_hidden .= '<div>'.$form->field($model, 'Termin_'.$zt.'_Ende')->hiddenInput(['id'=>'Termin_'.$zt.'_Ende'])->label(false).'</div>';
				}
		for ($i=1; $i<=5; $i++){
			$sonst_row .= '<div class="col-md-3">'.$form->field($model, 'Termin_sonst'.$i.'_Label')->textInput(['id'=>'Termin_sonst'.$i.'_Label','maxlength'=>$bez_max_length])->label('Sonst.'.$i).'</div>
					<div class="col-md-2" style="border-bottom:1px solid !important;">'. rawTermin2($model->{'Termin_sonst'.$i.'_Ende'}, 'RAW_sonst'.$i.'_Ende').'</div>
					<div class="col-md-2">'.$form->field($model, 'Termin_sonst'.$i.'_Dauer')->textInput(['id'=>'Termin_sonst'.$i.'_Dauer'])->label(false).'</div>
					<div class="col-md-5">'.$form->field($model, 'Termin_sonst'.$i.'_Info1')->textInput(['id'=>'Termin_sonst'.$i.'_Info1','maxlength'=>$lief_max_length])->label(false).'</div>
					<div class="col-md-12" id="RAW_sonst'.$i.'_Ende_error"></div>';
					$sonst_hidden .= '<div>'.$form->field($model, 'Termin_sonst'.$i.'_Ende')->hiddenInput(['id'=>'Termin_sonst'.$i.'_Ende'])->label(false).'</div>';
				}

		?>

			<!-- Projekttermine -->
			 <div class="row">
				  <div class="col-md-12 bg-primary"><h3>Projekttermine</h3></div>
			</div>
			 <div class="row">
				  <div class="col-md-1 bg-primary" ><h4>&nbsp;</h4></div>
				  <div class="col-md-2 bg-primary" ><h4>&nbsp;</h4></div>
				  <div class="col-md-2 bg-primary" ><h4>Endtermin</h4></div>
				  <div class="col-md-2 bg-primary"><h4>Dauer in Wochen</h4></div>
				  <div class="col-md-5 bg-primary"><h4>Lieferant / Verantwortlicher</h4></div>
			</div>
			<div class="row">
				  <div class="col-md-6 bg-primary" style="border-bottom:1px solid !important;"></div>
			</div>
			 <div class="row" >
				<div class="col-md-12 bg-primary" style="padding-top:8px;">
					<div class="col-md-5" style="border-bottom:1px solid !important;"><?= rawTermin($model->Termin_Pruefber_Ende,'Endtermin', 'RAW_Pruefber_Ende')?></div>
					<div class="col-md-7" style="height:100%; width:100%; margin:0;"></div>
					<?= $pt_row ?>

				</div>

			</div>
			<!-- zusätzliche Termine -->
			<div class="row">
				  <div class="col-md-12 bg-info"><h3>zus&auml;tzliche Termine</h3></div>
			</div>
			 <div class="row">
				  <div class="col-md-1 bg-info" ><h4>&nbsp;</h4></div>
				  <div class="col-md-2 bg-info" ><h4>&nbsp;</h4></div>
				  <div class="col-md-2 bg-info" ><h4>Endtermin</h4></div>
				  <div class="col-md-2 bg-info"><h4>Dauer in Wochen</h4></div>
				  <div class="col-md-5 bg-info"><h4>Lieferant / Verantwortlicher</h4></div>
			</div>
			<div class="row">
				  <div class="col-md-12 bg-info" style="border-bottom:1px solid !important;"></div>
			</div>
			 <div class="row" >

				<div class="col-md-12 bg-info" style="padding-top:8px;">
				  <?= $zt_row ?>
				 </div>
			</div>
			<!-- sonstige Termine -->
			<div class="row">
				  <div class="col-md-12 bg-warning"><h3>sonstige Termine</h3></div>
			</div>
			<div class="row">
				  <div class="col-md-1 bg-warning" ><h4>&nbsp;</h4></div>
				  <div class="col-md-2 bg-warning" ><h4>Bezeichnung</h4></div>
				  <div class="col-md-2 bg-warning" ><h4>Endtermin</h4></div>
				  <div class="col-md-2 bg-warning"><h4>Dauer in Wochen</h4></div>
				  <div class="col-md-5 bg-warning"><h4>Lieferant / Verantwortlicher</h4></div>
			</div>
			<div class="row">
				  <div class="col-md-12 bg-warning" style="border-bottom:1px solid !important;"></div>
			</div>
			<div class="row" >

				<div class="col-md-12 bg-warning" style="padding-top:8px;">
				  <?= $sonst_row ?>
				</div>
			</div>
		</div>
	</div>
	 <!-- Hidden Fields -->
	 <div class="hide">
			<div><?= $form->field($model, 'Termin_Pruefber_Ende')->hiddenInput(['id'=>'Termin_Pruefber_Ende'])->label(false) ?></div>
			<?= $pt_hidden ?>
			<?= $zt_hidden ?>
			<?= $sonst_hidden ?>
	</div>

<?php endif; ?>


<div class="panel panel-primary">
  <div class="panel-heading">sonstige Informationen</div>
  <div class="panel-body">
	  <?php
		echo Form::widget([
			'model'=>$model,
			'form'=>$form,
			'columns'=>1,
			'attributes'=>[
				'sonst_Info_allg'=>['type'=>Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'sonstige Informationen...']]
			]
		]);
	  ?>
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-body">
	<div class="col-md-1"></div>
    <div class="form-group">
        <?= Html::submitButton('Speichern', ['class' => 'btn btn-success']) ?>
				<?= Html::a('<span class="glyphicon glyphicon-repeat"></span>&nbsp;Reset Terminabw. ',
											['urtermin-reset','id'=>$model->ID],
											['type' => 'button',
											'class' => 'btn btn-warning',
											'title' => \Yii::t('yii', 'Reset'),
											'data-confirm' => Yii::t('yii', 'Terminabweichungen zurücksetzen?'),
											'data-method' => 'post',
											'data-pjax' => '0'
											]) ?>
    </div>
  </div>
</div>


    <?php ActiveForm::end(); ?>
</div>

<?php
function rawTermin($date,$label,$id){
	if (DateTime::createFromFormat('Y-m-d', $date) !== FALSE) {
		$timestamp = strtotime($date);
		$formdate = 'KW '. date('W',$timestamp).' - '.Yii::$app->formatter->asDate($date,'Y');
		$anzeige = '<div class="form-group">
						<label class="control-label col-md-7">'.$label.'</label>
						<div class="form-control-static" id="'.$id.'">'.$formdate.'</div>
					</div>';
				}
	else {
		$anzeige = '<div class="form-group">
						<label class="control-label col-md-7">'.$label.'</label>
						<div class="form-control-static" id="'.$id.'"></div>
					</div>';
				}

	return $anzeige;
}
function rawTermin2($date,$id){
	if (DateTime::createFromFormat('Y-m-d', $date) !== FALSE) {
		$timestamp = strtotime($date);
		$formdate = 'KW '. date('W',$timestamp).' - '.Yii::$app->formatter->asDate($date,'Y');
		$anzeige = '<div class="form-group">
						<div class="form-control-static" id="'.$id.'">'.$formdate.'</div>
					</div>';
				}
	else {
		$anzeige = '<div class="form-group">
						<div class="form-control-static" id="'.$id.'"></div>
					</div>';
				}
	return $anzeige;
}

function rawDauer($dauer,$label,$id){
	$anzeige = '<div class="form-group">
					<label class="control-label col-md-4">'.$label.'</label>
					<div class="form-control-static" id="'.$id.'">'.$dauer.'</div>
				</div>';
	return $anzeige;
}
?>
