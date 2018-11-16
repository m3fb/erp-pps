<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PersonalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = ($status == 800 ) ? 'Urlaubstage': 'Krankheitstage';
$this->params['breadcrumbs'][] = $this->title;

$krankKlasse = ($status == 802) ? 'btn-default' : 'btn-success';
$krankLink = ($status == 802) ? true : false;
$urlaubKlasse = ($status == 800) ? 'btn-default' : 'btn-success';
$urlaubLink = ($status == 800) ? true : false;
$krankButton = HTML::a('Krankheitstage',['abwesend-uebersicht','status'=>802],['class'=>'btn '.$krankKlasse,'disabled'=>$krankLink]);
$urlaubButton = HTML::a('Urlaubstage',['abwesend-uebersicht','status'=>800],['class'=>'btn '.$urlaubKlasse,'disabled'=>$urlaubLink]);

$monats_label = array(
						1 => 'Jan.',
						2 => 'Feb.',
						3 => 'Mrz.',
						4 => 'Apr.',
						5 => 'Mai',
						6 => 'Jun.',
						7 => 'Jul.',
						8 => 'Aug.',
						9 => 'Sep.',
						10 => 'Okt.',
						11 => 'Nov.',
						12 => 'Dez.'
						);

$gridColumns[] =['class' => 'yii\grid\SerialColumn'];
$gridColumns[] = [
  'attribute'=>'Name',
  'contentOptions'=>['style'=>'font-weight:bold'],
  ];

list ($starttag, $startmonat, $startjahr) = explode('.', $startdatum);
list ($endtag, $endmonat, $endjahr) = explode('.', $enddatum);
$startindex=$startjahr.$startmonat;
$endindex=$endjahr.$endmonat;

for ($i=$startindex; $i <=$endindex ; $i++) {
  	$gridColumns[] = [
  		'attribute' =>$i,
  		'label' =>	$monats_label[Yii::$app->formatter->asInteger(substr($i,-2))] .' '.substr($i,2,2),
  	];
    if (substr($i , -2) == 12) $i=$i+88; //Wenn der JahresMonatsIndex = Jahr12 dann wird umm 88 auf das nächste Jahr erhöht.
  }


$gridColumns[] = [
  	'attribute'=>'Summe',
  	'contentOptions'=>['style'=>'font-weight:bold'],
  ];

?>
<div class="personal-abwesenddaten">

	<?= GridView::widget([
	 'dataProvider' => $dataProvider,
	 'toolbar' => false,
	 'summary' => 'Seite {page} von {pageCount} / Einträge {begin} - {end} von {totalCount}',
	 'panel' => [
		 'heading'=>'<h3 class="panel-title">'.(($status==800) ? 'Urlaubs':'Krankheits').'tage der letzten 12 Monate</h3>',
		 'type'=>'primary',
		 'footer'=> false,
		 'before' => $krankButton.'&nbsp;&nbsp;'.$urlaubButton,
	 ],
	 'rowOptions'=>function($model) use($status){
						if($model['Summe'] >= 30 && $status == 802){
								return ['class' => 'danger'];
						}
						elseif($model['Summe'] >= 20 && $status == 802){
								return ['class' => 'warning'];
						}
						else {
							return ['class' => 'default'];
						}
				 },
	 'columns' => $gridColumns,
]); ?>

</div>
