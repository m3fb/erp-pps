<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use app\models\Fagdetail;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PersonalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
# Entwicklungsstatus

$this->title = 'Personalliste';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
					[
						'attribute' => 'PERSNO',
						'width'=>'200px',
						'filter' => false,
						'label' =>'PersNr.',
					],
						'SURNAME',
						'FIRSTNAME',
            [
						'attribute' => 'ABTEILUNG',
						'width'=>'150px',
						'filterType'=>GridView::FILTER_SELECT2,
						'filter'=>ArrayHelper::map(Fagdetail::find()->select(['TXT02'])->where(['FAG_DETAIL.TYP' => 26])->asArray()->all(), 'TXT02', 'TXT02'),
						'filterWidgetOptions'=>[
							'pluginOptions'=>['allowClear'=>true],
						],
						'filterInputOptions'=>['placeholder'=>'Abteilung'],
					],

             'MODEM',

            [
             	'attribute' => 'PHONE1',
							'width'=>'90px',
						],
            [
             	'attribute' => 'PHONE2',
							'filter' => false,
						],
						[
			        'attribute' => 'PHONE3',
							'filter' => false,
						],
				];

if (Yii::$app->user->identity && in_array(Yii::$app->user->identity->username, ['mrotter','nrotter','mheim'] )) {
		$gridColumns[] =
						[
							'attribute' => 'Geburtstag',
							'format' => 'date',
							'filter' => getMonthsList(),
						];
	}

if (Yii::$app->user->identity && in_array(Yii::$app->user->identity->username, ['mrotter','nrotter'] )) {
			Yii::$app->formatter->thousandSeparator = '';
			$gridColumns[] =
						[
							'attribute' => 'Buchungsnummer',
							'format' => 'integer',
							'label' => 'Buch.nr.'
						];
		}

if (Yii::$app->user->identity && Yii::$app->user->identity->role >= 50) {
		$gridColumns[] =

							[
								'attribute' => 'username',
								'format' => ['html'],
								'label' => 'Username',
								'value'=>function ($model) {
									if ($model['username']) {
										$output = '<span class="glyphicon glyphicon-ok-circle"></span>'.' '.$model['username'];
									}
									else {
										$output = Html::a('<span class="glyphicon glyphicon-ban-circle"></span>'. ' '. $model['SURNAME'].' anlegen',
															[
																'site/signup',
																'id' => $model['NO'],
															]);
														}
										return $output;
									},

							];

		$gridColumns[] =
							['class' => 'yii\grid\ActionColumn',
												'template'    => '{view}{delete}',
												'buttons' => [
													'view' => function ($url, $model, $id) {
														return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
															$url, [
																'title' => \Yii::t('yii', 'View'),
																'data-pjax' => '0',
															]);
													},
													'delete' => function ($url, $model, $id) {
														return Html::a('<span class="glyphicon glyphicon-trash"></span>',
																['personal/delete', 'id'=>$id], [
																'title' => \Yii::t('yii', 'Delete'),
																'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
																'data-method' => 'post',
																'data-pjax' => '0',
																	]);
															},
												]

							];

		}

?>
<div class="personal-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //var_dump($dataProvider);// echo $this->render('_search', ['model' => $searchModel]);?>

    <p>
        <?php if (Yii::$app->user->identity && in_array(Yii::$app->user->identity->username, ['mrotter','rwiedemann', 'fbogenreuther', 'nrotter'])): ?>
			<div class="alert alert-info" role="alert">
				Hinweis: Neues Personal kann nur in <b>Fauser JobDisp</b> unter <b>Einstellung/Personal</b> angelegt werden. Hier können die Personaldaten verwaltet und
				der Zugang für die Zusatzanwendungen erstellt werden. Danach können über die Zusatzanwendungen Adress- und Telefondaten geändert werden.
			</div>
		<?php endif; ?>


    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
				'options' => ['style'=>'font-size:12px;'],
        'columns' => $gridColumns,

    ]); ?>
</div>
