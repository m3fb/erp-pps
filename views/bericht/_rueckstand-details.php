<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

ini_set('mssql.charset', 'windows-1252');
/* @var $this yii\web\View */
/* @var $model app\models\Ororder */
/* @var $form yii\widgets\ActiveForm */
?>

<!-- Lieferrückstanddetails -->
<?php if ($type == 'delivery'): ?>

	<div class="col-sm-4">
		<p><b>Kundenadresse:</b></p>
		<?= DetailView::widget([
			'model' => $model,
			'attributes' => [   
				[                      
					'label' => 'Name',
					'value' => $model['CNAME'],
				],
				[                      
					'label' => 'Straße',
					'value' => $model['CSTREET'],
				],
				[                      
					'label' => 'PLZ / Ort',
					'value' => $model['CCNTRYSIGN']." ".$model['CPOSTCODE']." ".$model['CPLACE']
				],
			],
		]);
				?>
	</div>

	<div class="col-sm-4">
		<p><b>Lieferadresse:</b></p>
		<?= DetailView::widget([
			'model' => $model,
			'attributes' => [   
				[                      
					'label' => 'Name',
					'value' => $model['VNAME'],
				],
				[                      
					'label' => 'Straße',
					'value' => $model['VSTREET'],
				],
				[                      
					'label' => 'PLZ / Ort',
					'value' => $model['VCSIGN']." ".$model['VPOSTCD']." ".$model['VPLACE']
				],
			],
		]);
				?>
	</div>

	<div class="col-sm-4">
		<p><b>Spedition:</b></p>
		<?= DetailView::widget([
			'model' => $model,
			'attributes' => [   
				[                      
					'label' => 'Sped.-Nr.',
					'value' => $model['CUSTNO'],
				],
				[                      
					'label' => 'Name',
					'value' => $model['SNAME'],
				],
				[                      
					'label' => 'Telefon',
					'value' => $model['SPHONE'],
				],
			],
		]);
				?>
	</div>
<?php endif; ?>

<!-- Bestellrückstanddetails -->

<?php if ($type == 'order'): ?>

	<div class="col-sm-6">
		<p><b>Lieferant:</b></p>
		<?= DetailView::widget([
			'model' => $model,
			'attributes' => [   
				[                      
					'label' => 'Name',
					'value' => $model['CNAME'],
				],
				[                      
					'label' => 'Straße',
					'value' => $model['CSTREET'],
				],
				[                      
					'label' => 'PLZ / Ort',
					'value' => $model['CCNTRYSIGN']." ".$model['CPOSTCODE']." ".$model['CPLACE']
				],
				[                      
					'label' => 'Telefon',
					'value' => $model['PHONE']
				],
			],
		]);
				?>
	</div>
<?php if ($model['ADDRPERS'] > 0): ?>
	<div class="col-sm-6">
		<p><b>Ansprechpartner:</b></p>
		<?= DetailView::widget([
			'model' => $model,
			'attributes' => [
				[                      
					'label' => 'Name',
					'value'=>($model['SEX'] == 1 ?'Frau' : 'Herr') .' '. $model['FIRSTNAME'].' '. $model['SURNAME']
				],
				[                      
					'label' => 'Telefon',
					'value' => $model['PHONE1'],
				],
				[                      
					'label' => 'Email',
					'value' => $model['PHONE5'],
				],
			],
		]);
				?>
	</div>
<?php endif; ?>
	
<?php endif; ?>
