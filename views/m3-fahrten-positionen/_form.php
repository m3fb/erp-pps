<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datetime\DateTimePicker;
use kartik\widgets\Select2;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\Cucomp;
use app\models\user;
use app\models\Personal;

$this->registerJsFile("@web/js/fahrten.js",
						['depends' => [\yii\web\JqueryAsset::className()]]
						);

$name = Yii::$app->user->identity->firstname.' ' .Yii::$app->user->identity->surename.' (Privatadresse)';


$cucomp_ar = Cucomp::find()
				->select(['CONO',"[NAME] + ' / '+ [PLACE] as NAME"])
				->orderBy(['NAME'=>SORT_ASC])
				->all();

// Für Verwalter (Role >= 60) werden alle Privatadressen aufgelistet.
// Für standard user wird nur die eigene Adress aufgelistet
if (Yii::$app->user->identity->role >= 60){
	$worker_ar = Personal::find()
				->select(["'9999' + CAST([NO] as varchar(12) ) as CONO", "[FIRSTNAME]+' '+[SURNAME]+' (Privatadresse)' as NAME"])
				->where(['STATUS1'=>0])
				->orderBy(['SURNAME'=>SORT_ASC])
				->all();
			}
			else {
				$worker_ar = Personal::find()
							//Prefix 9999 wird zur Unterscheidung von Kundennummern angehängt
							// im Controller wird dies gefiltert mit
							// if (substr($CONO,0,4) == '9999'){...
							->select(["'9999' + CAST([NO] as varchar(12) ) as CONO", "[FIRSTNAME]+' '+[SURNAME]+' (Privatadresse)' as NAME"])
							->where(['STATUS1'=>0])
							->andWhere(['NO'=>Yii::$app->user->identity->pe_work_id])
							->orderBy(['SURNAME'=>SORT_ASC])
							->all();
			}
$address_ar = ArrayHelper::merge($worker_ar,$cucomp_ar);

$cucomp = ArrayHelper::map($address_ar, 'CONO', 'NAME');
$startdate = date("Y-m-d", strtotime("-1 months"));

$username_ar = user::find()
				->select(['username',"[firstname] + '  '+ [surename] as surename"])
				->orderBy(['surename'=>SORT_ASC])
				->all();
array_unshift($username_ar,['username'=>NULL,'surename'=>'-']);
$username = ArrayHelper::map($username_ar, 'username', 'surename');


/* @var $this yii\web\View */
/* @var $model app\models\M3FahrtenPositionen */
/* @var $form yii\widgets\ActiveForm */

$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);

/*
 * DateTimePicker muss über die Variante $form->field.. gewählt werden.
 * Sonst funktioniert dier Überprüfung über die im Model definierten Prüfroutinen nicht.
 * Folgende Variant wird nicht überprüft:
 *
 * $fahrtdatum = DateTimePicker::widget([
 * 'model'=>$model,
 * 'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
 * 'attribute' => ....
 * */

 $fahrtdatum = $form->field($model, 'Fahrtdatum')->widget(
                    DateTimePicker::className(),
                    [
                        'pluginOptions' => [
							'autoclose'=>true,
							'todayBtn'=>true,
							'format' => 'dd.mm.yyyy HH:ii',
							'language' => 'de',
							'startDate'=> $startdate,
							'endDate'=>date("Y-m-d 23:59:59"),
                        ]
                    ]
                );



$typ = Form::widget([
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[       // 2 column layout
         'Typ'=>[
            'type'=>Form::INPUT_RADIO_LIST,
            'items'=>[0=>'Umweg', 1=>'Standard'],
            'options'=>[
				'inline'=>true,
			]
        ],
    ]
]);




?>

<div class="m3-fahrten-positionen-form">
<?php if (Yii::$app->user->identity->role >= 60): ?>
	<div class="row">
		<div class="col-md-6">
			<?php
			echo '<label class="control-label">Fahrt anlegen für:</label>';
			echo Select2::widget([
				'model' => $model,
				'attribute' => 'username',
				'data' => $username,
				'value' => Yii::$app->user->identity->username,
				'options' => [
					'placeholder' => 'Person auswählen ...',
					'id' => 'selUser'
				],
				'pluginOptions' => [
						'allowClear' => true
					],
			]);
			?>
		</div>
	</div>
<?php endif; ?>
	<div class="row">
		<div class="col-md-3">
			<?= $typ ?>
		</div>
		<div class="col-md-3">
			<?= $fahrtdatum ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<?php
			echo '<label class="control-label">Adressen</label>';
			echo Select2::widget([
				'name' => 'vonAdresseAuswahl',
				'data' => $cucomp,
				'options' => [
					'placeholder' => 'Adresse auswählen ...',
					'id' => 'vonFauserStart'
				],
				'pluginOptions' => [
						'allowClear' => true
					],
			]);
			?>
		</div>
		<div class="col-md-6">
			<?php
			echo '<label class="control-label">Adressen</label>';
			echo Select2::widget([
				'name' => 'nachAdresseAuswahl',
				'data' => $cucomp,
				'options' => [
					'placeholder' => 'Adresse auswählen ...',
					'id' => 'nachFauserStart'
				],
				'pluginOptions' => [
						'allowClear' => true
					],
			]);
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?php
			echo Form::widget([ // fields with labels
				'model'=>$model,
				'form'=>$form,
				'columns'=>2,
				'attributes'=>[
					'von_Adresse1'=>['label'=>'Startadresse', 'options'=>['placeholder'=>'Start...']],
					'nach_Adresse1'=>['label'=>'Zieladresse', 'options'=>['placeholder'=>'Ziel...']],
				]
			]);
			echo Form::widget([ // continuation fields to row above without labels
				'model'=>$model,
				'form'=>$form,
				'columns'=>2,
				'attributes'=>[
					'von_Adresse2'=>['label'=>false, 'options'=>['placeholder'=>'Start Adresszusatz...']],
					'nach_Adresse2'=>['label'=>false, 'options'=>['placeholder'=>'Ziel Adresszusatz...']],
				]
			]);
			echo Form::widget([ // continuation fields to row above without labels
				'model'=>$model,
				'form'=>$form,
				'columns'=>2,
				'attributes'=>[
					'von_Strasse'=>['label'=>'Straße', 'options'=>['placeholder'=>'Straße...']],
					'nach_Strasse'=>['label'=>'Straße', 'options'=>['placeholder'=>'Straße...']],
				]
			]);
			echo Form::widget([ // continuation fields to row above without labels
				'model'=>$model,
				'form'=>$form,
				'columns'=>4,
				'attributes'=>[
					'von_PLZ'=>['label'=>'PLZ', 'options'=>['placeholder'=>'PLZ...'],'columnOptions'=>['class'=>'col-md-2']],
					'von_Ort'=>['label'=>'Ort', 'options'=>['placeholder'=>'Ort...'], 'columnOptions'=>['class'=>'col-md-4']],
					'nach_PLZ'=>['label'=>'PLZ', 'options'=>['placeholder'=>'PLZ...'], 'columnOptions'=>['class'=>'col-md-2']],
					'nach_Ort'=>['label'=>'Ort', 'options'=>['placeholder'=>'Ort...'], 'columnOptions'=>['class'=>'col-md-4']],
				]
			]);

			?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3" id="Entfernung" style="display:none">
					<?php
						echo Form::widget([ // continuation fields to row above without labels
						'model'=>$model,
						'form'=>$form,
						'columns'=>1,
						'attributes'=>[
							'Entfernung'=>[
								'visible'=>true,
								'label'=>'Entfernung in km',
								'options'=>[
									'placeholder'=>'Entfernung...',
									'id'=>'Entfernung'
								]
							],
						]
					]);
				?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
			<?= Html::submitButton('Speichern', ['class' => 'btn btn-success']) ?>
			<?= Html::a('Abbrechen', ['/m3-fahrten-positionen/index'], ['class'=>'btn btn-danger']) ?>
			</div>
		</div>

	</div>



    <?php ActiveForm::end(); ?>

</div>
