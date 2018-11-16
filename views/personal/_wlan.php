<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\bootstrap\Modal;
use yii\bootstrap\BootstrapPluginAsset;

(Yii::$app->user->identity && in_array(Yii::$app->user->identity->username, ['mrotter', 'fbogenreuther'])) ? $buttons = '{update}' : $buttons=' ';
/* @var $this yii\web\View */
/* @var $model app\models\Personal */
/* @var $form yii\widgets\ActiveForm */

?>



<div class="personal-wlandaten">

<!-- Wenn ein Wlanzugang beantrag wird, wird eine Standardeintrag generiert
Es wird geprüft ob bereits ein Eintrag im Feld wlan_username existiert
und das Ablaufdatum noch nicht überschritten ist.
Admins (role = 90) können
$currentDate = date('d.m.Y H:i:s');
-->
<?php if ($userModel->wlan_username && Yii::$app->formatter->asTimestamp($userModel->wlan_expiration) > Yii::$app->formatter->asTimestamp(date('d.m.Y H:i:s')) ): ?>
	<?= DetailView::widget([
			'model' => $userModel,
			'condensed'=>true,
			'striped' => false,
			#'mode'=>DetailView::MODE_VIEW,
			'panel'=>[
				'heading'=>'Zugangsdaten für m3-Hotspot / SSID: <b>m3PSMA</b>',
				'type'=>DetailView::TYPE_PRIMARY,
			],
			'buttons1' =>$buttons,
			'attributes' => [
				//'NO',
				[
					'group'=>true,
					'label'=>'<span class="glyphicon glyphicon-user"></span>',
					'rowOptions'=>['class'=>'info']
				],
				[
			'columns' => [
					[
						'attribute'=>'wlan_username',
						'labelColOptions' => ['style'=>'width:15%; text-align:right;'],
						'valueColOptions'=>['style'=>'width:15%'],
					],
					[
						'attribute'=>'wlan_password',
						'labelColOptions' => ['style'=>'width:15%; text-align:right;'],
						'valueColOptions'=>['style'=>'width:15%'],
					],
					[
						'attribute'=>'wlan_expiration',
						'label' => 'Ablaufdatum',
						#'displayOnly' => true,
						'labelColOptions' => ['style'=>'width:15%; text-align:right;'],
						'valueColOptions'=>['style'=>'width:15%'],
						'format' => 'datetime',
					]
				]
				],


			],
		]) ?>

<?php elseif ($userModel->wlan_username=='-'): ?>
	<div class="label label-default">Wlanzugang wurde am <?= Yii::$app->formatter->asDate($userModel->wlan_expiration) ?> beantragt.</div>
	<div style="height:10px;">&nbsp;</div>

<?php else:  ?>
<?=	Html::a('<span class="glyphicon glyphicon-signal"></span> Wlanzugang beantragen',
				['wlanantrag', 'id'=>$userModel->id],
				[
					'type' => 'button',
					'class' => 'btn btn-primary',
					'title' => \Yii::t('yii', 'Wlan-Zugang beantragen'),
					'data-confirm' => 'Soll der Antrag für '.$userModel->firstname.' '.$userModel->surename.' gesendet werden?',
				]
			);
	?>
	<div style="height:10px;">&nbsp;</div>
<?php endif;  ?>
</div>
