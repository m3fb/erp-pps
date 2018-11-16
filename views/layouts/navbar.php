<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;



$this->registerCss(".my-navbar-brand {
							margin: 5px;
							padding-top: 0px;
							width: 200px;
							}
					.my-navbar {
							border-bottom: 2px solid #5f6065;
							background-color: white;
							}
					.my-navbar a {
							color:#5f6065;
							}

					.navbar-right {
							margin-right: 100px;
							}"

					);

// Onclickfunktion für Konstruktins-Todoliste. Öffnet ein Fenster ohne Menü in definierter Größe
$this->registerJs(
		'$(".konstruktion_todo").on("click", function(event){
			window.open("http://m3mssql/m3adminV3/web/index.php?&r=todo%2Faufgaben-konstruktion-quickview&env=konstruktion_qv", "NewWindow","toolbar=no,location=no,directories=yes,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=no,width=780,height=850");

	});'
);

/*
 * Berechtigungen
 */
$berechtigung_admin = ['mrotter','fbogenreuther'];
$berechtigung_gf = ['mrotter','mheim'];
$berechtigung_krank = ['mrotter','mheim','fhess','rwiedemann'];
$berechtigung_planung = ['mrotter','megerer','rwiedemann', 'fbogenreuther','fhess','mheim','cortner','fbraun'];
$berechtigung_logistik = ['mrotter','megerer','rwiedemann', 'fbogenreuther','fhess','mheim','hpitzer','awolf','skhanamiryan','cortner','wheim','nrotter','fbraun'];
$berechtigung_technikum = ['mrotter','megerer','rwiedemann', 'fbogenreuther','fhess','mheim','cortner','fbraun'];
$berechtigung_produktion = ['mrotter','megerer','rwiedemann', 'fbogenreuther','fhess','mheim'];
$berechtigung_verwaltung = ['mrotter','megerer','rwiedemann', 'fbogenreuther','fhess','mheim','skhanamiryan','wheim','nrotter','cortner','pwieser','fbraun'];
$berechtigung_qs = ['mrotter','megerer','rwiedemann', 'fbogenreuther','fhess','mheim','pwieser','vsimonyan','cortner','fbraun'];
$berechtigung_konstruktion = ['mrotter','mheim','cortner','fbraun'];
$berechtigung_special_erp = ['mrotter', 'fbogenreuther', 'skhanamiryan','nrotter','wheim','cortner','fbraun'];
$berechtigung_test_team = ['mrotter', 'fbogenreuther', 'rwiedemann', 'skhanamiryan'];

#-------------------------------------------------------------------------------------------------------------------
#Menüpunkte

#Planung und Auswertung mit Zugangsberechtigung über Username

if (Yii::$app->user->identity and in_array(Yii::$app->user->identity->username, $berechtigung_planung ))  {
						$planung = ['label' => '<span class="glyphicon glyphicon-blackboard"></span> Plan.', 'url' => ['/todo/index','env'=>''],'items' => [
						['label' => 'Aufgabenplanung', 'url' => ['/todo/index','env'=>'']] ,
						['label' => 'Prio-Maschinenplanung', 'url' => ['/planung/mplanung']] ,
						['label' => 'Terminal-Maschinenplanung', 'url' => ['/procontrol/proconplanung','maschine'=>1]],
						['label' => 'Terminal-Kundenmodus', 'url' => ['/procontrol/show-customer-dates']],
						['label' => 'Plantafel', 'url' => ['/planung/plantafel','env'=>'norm']],
						]
					];
                        $auswertung =['label' => '<span class="glyphicon glyphicon-dashboard"></span> Ausw.', 'url' => ['/auswertung/auswertung'],'items' => [
                            ['label' => 'Auswertung','url' => ['/auswertung/auswertung']],
                            ['label' => 'Linienübersicht','url' => ['/auswertung/linien3']],
                            ]
                    ];

                        if (Yii::$app->user->identity and in_array(Yii::$app->user->identity->username, $berechtigung_admin))  {
                         $auswertung =['label' => '<span class="glyphicon glyphicon-dashboard"></span> Ausw.', 'url' => ['/auswertung/auswertung'],'items' => [

                            ['label' => 'Auswertung','url' => ['/auswertung/auswertung']],
                            ['label' => 'Linienübersicht','url' => ['/auswertung/linien3']],
                            ['label' => 'Pilog','url' => ['/auswertung/pilog2']]
                            ]
                    ];


                        }
				} else {
					$planung='';

                    $auswertung = '';
				}

#Kalender

$kalender = "";
if(!Yii::$app->user->isGuest){
	if(Yii::$app->user->identity->pw_check() && Yii::$app->user->identity->role >= 60){
		$kalender = ['label' => '<span class="glyphicon glyphicon-calendar"></span> Kal.', 'url' => ['/urlaub/kalender'],'items' => [

		['label' => 'Kalender', 'url' => ['/urlaub/kalender']],
		['label' => 'Manager','url' => ['/urlaub/manager']],
		['label' => 'Schichtplaner', 'url' => ['/urlaub/schicht']],
		['label' => 'Verwaltung', 'url' => ['/urlaub/verwaltung']],
		['label' => 'Abwesenheitstage', 'url' => ['/personal/abwesenheit','workid'=>0,'status'=>'']],
		['label' => 'Abrechnung', 'url' => ['/urlaub/abrechnung']],
        ['label' => 'Zeiten', 'url' => ['/m3_zeiten/index']]

		]];
	}
	else if(Yii::$app->user->identity->pw_check() && Yii::$app->user->identity->role >= 50){
		$kalender = ['label' => '<span class="glyphicon glyphicon-calendar"></span> Kal.', 'url' => ['/urlaub/kalender'],'items' => [

		['label' => 'Kalender', 'url' => ['/urlaub/kalender']],
		['label' => 'Manager','url' => ['/urlaub/manager']],
		['label' => 'Schichtplaner', 'url' => ['/urlaub/schicht']],
		['label' => 'Verwaltung', 'url' => ['/urlaub/verwaltung']],
		['label' => 'Abwesenheitstage', 'url' => ['/personal/abwesenheit','workid'=>0,'status'=>'']],
		]];
	}
	else if(Yii::$app->user->identity->pw_check() && Yii::$app->user->identity->role >= 10){
		$kalender = ['label' => '<span class="glyphicon glyphicon-calendar"></span> Kal.', 'url' => ['/urlaub/kalender']];
	}

}
else {
	$kalender =	['label' => '<span class="glyphicon glyphicon-calendar"></span> Kal.', 'url' => ['/urlaub/kalender']];
}

#m3profile
$m3profile = ['label' => '<span class="glyphicon glyphicon-info-sign"></span> Inf.', 'url' => ['/urlaub/kalender'],'items' => [

		['label' => 'Informationen', 'url' => ['/site/informationen']],
		['label' => 'Vorlagen','url' => ['/site/vorlagen']],
		['label' => 'Personalliste', 'url' => ['/personal']],
		['label' => 'wichtige Telefonnummer', 'url' => ['/site/wichtigetelefon']],
		['label' => 'Verantwortungsbereiche', 'url' => ['/site/organigramm']],
		['label' => 'Webmail', 'url' => 'https://webmail.your-server.de/', 'linkOptions' => ['target' => '_blank']],
		['label' => 'sam Secova', 'url' => 'https://m3profile.secova.de/', 'linkOptions' => ['target' => '_blank']]
		]];

$produktion = ['label' => '<span class="glyphicon glyphicon-cog"></span> Prod.', 'url' => ['/bde/index'],'items' => [

		['label' => 'Rückmeldung', 'url' => ['/bde/index']],
		['label' => 'Informationen', 'url' => ['/bde/manual']],
		(Yii::$app->user->identity and in_array(Yii::$app->user->identity->username, $berechtigung_produktion )) ?
		['label' => 'archiviert', 'url' => ['/bde/archiv','arch_time'=>4]]:'',
		]];

if (Yii::$app->user->identity and in_array(Yii::$app->user->identity->username, $berechtigung_konstruktion ))  {
			$konstruktion_todo = ['label' => 'Aufgaben Konstruktion', 'url' => ['/todo/aufgaben-konstruktion','env'=>'konstruktion']];
				}
else $konstruktion_todo = '';
if (Yii::$app->user->identity and in_array(Yii::$app->user->identity->username, $berechtigung_technikum ))  {
	$technikum = ['label' => '<span class="glyphicon glyphicon-wrench"></span> Techn.', 'url' => ['/urlaub/kalender'],'items' => [

			['label' => 'Techniscreen', 'url' => ['/technikum/index'], 'linkOptions' => ['target' => '_blank']],
			['label' => 'Technikum-Aufgabenprüfung', 'url' => ['/technikum/eingabe'], 'linkOptions' => ['target' => '_blank']],
			['label' => 'Projektverwaltung', 'url' => ['/projekt/projektplan']],
			$konstruktion_todo,
			]];

		}

		else {
			$technikum ='';
		}
if (Yii::$app->user->identity and in_array(Yii::$app->user->identity->username, $berechtigung_verwaltung ))  {
	$verwaltung = ['label' => '<span class="glyphicon glyphicon-paperclip"></span> Verw.', 'url' => ['/urlaub/kalender'],'items' => [

			['label' => 'Übersicht Kaufteile', 'url' => ['/bericht/kaufteile','kaufteil_no'=>'']],
			'<li class="divider"></li>',
			['label' => 'Sped.auftr.verwaltung', 'url' => ['/bericht/spedverw']],
			'<li class="divider"></li>',
			['label' => 'Projektverwaltung', 'url' => ['/projekt/projektplan']],
		#	['label' => 'Projektaufgaben', 'url' => ['/projekt/projektaufgaben']],
			'<li class="divider"></li>',
			['label' => 'priv. Fahrten Verwaltung', 'url' => ['/m3-fahrten-positionen/index-verwaltung']],
			'<li class="divider"></li>',
			['label' => 'Lager', 'url' => ['/pa_artpos']],
			['label' => 'Mehrfachlager', 'url' => ['/st_stock']],
			['label' => 'Kunden-Lagerlisten', 'url' => ['/st_stock/customer-list','cu_no'=>0]],
			]];
		}
		else {
			$verwaltung ='';
		}

if (Yii::$app->user->identity and in_array(Yii::$app->user->identity->username, $berechtigung_krank))  {
	$verwaltung['items'][] =
				['label' => 'Übersicht Krank/Urlaub', 'url' => ['/personal/abwesend-uebersicht','status'=>802]];
		}
if (Yii::$app->user->identity and in_array(Yii::$app->user->identity->username, $berechtigung_special_erp))  {
	$verwaltung['items'][] =
				'<li class="divider"></li>';
	$verwaltung['items'][] =
				['label' => 'Belegverwaltung', 'url' => ['/belege']];
		}

if (Yii::$app->user->identity and in_array(Yii::$app->user->identity->username, $berechtigung_logistik ))  {
	$logistik = ['label' => '<span class="glyphicon glyphicon-road"></span> Log.', 'url' => ['/urlaub/kalender'],'items' => [

			['label' => 'Lieferrückstand',  'url' => ['/bericht/rueckstand','type'=>'delivery']],
			['label' => 'Bestellrückstand', 'url' => ['/bericht/rueckstand','type'=>'order']],
			]];
		}
		else {
			$logistik ='';
		}


	$qs = ['label' => '<span class="glyphicon glyphicon-check"></span> QS', 'url' => ['/urlaub/kalender'],'items' => [

			['label' => 'QM-Handbuch',  'url' => ['/site/qmhanbuch']],
			['label' => 'Zertifikate',  'url' => ['/site/zertifikate']],
			['label' => 'Arbeitsanweisungen',  'url' => ['/site/arbeitsanweisungen']],
			['label' => 'Verfahrensanweisungen',  'url' => ['/site/verfahrensanweisungen']],
			['label' => 'Reklamationsauswertungen',  'url' => ['/reklamationen/auswertung','wirkungsfaktor'=>'','month'=>'', 'attribut'=>'','env'=>'']],
			['label' => 'interne Reklamationen',  'url' => ['/reklamationen/interne-reklamationen','env'=>'']],

			]];

//persönliche Aufgaben für Konstruktion
(Yii::$app->user->identity and in_array(Yii::$app->user->identity->username, ['cortner','fbraun'] ))?
	$pers_Aufgaben =  ['label' => 'persönliche Aufgaben',	'url' => '#',	'options' =>['class'=>'konstruktion_todo']]:
	$pers_Aufgaben = '';

if (Yii::$app->user->identity and in_array(Yii::$app->user->identity->username, $berechtigung_admin ))  {
						$joomla = ['label' => 'JoomlaAdmin', 'url' => 'http://192.168.1.22/m3intraV2/administrator', 'linkOptions' => ['target' => '_blank']];
						$bootstrap = ['label' => 'Bootstraptest', 'url' => ['/site/bootstraptest']];
						$wlan = ['label' => 'Wlan-Anträge', 'url' => ['/personal/wlan-verwaltung']];
						$sqllog = ['label' => 'Sql-Log', 'url' => ['/site/sqllog-auswahl']];
						$aufgaben = ['label' => 'persönliche Aufgaben',	'url' => '#',	'options' =>['class'=>'konstruktion_todo']];
					}

					else {
						$joomla ='';
						$bootstrap = '';
						$wlan = '';
						$sqllog ='';
						$aufgaben = '';
					}


$user = Yii::$app->user->isGuest ?
                        ['label' => 'Login', 'url' => ['/site/login']] :

                    #Dropdown Benutzerverwaltung
                        [
							'label' => '<span class="glyphicon glyphicon-user"></span>', // (' . substr(Yii::$app->user->identity->firstname,0,1) .'.' . Yii::$app->user->identity->surename . ')',
							'items' => [
								 ['label' => 'Persönliche Daten', 'url' => ['personal/view','id'=>Yii::$app->user->identity->pe_work_id]],
								 ['label' => 'Urlaubsantrag', 'url' => ['/urlaub/antrag']],
								 ['label' => 'Fahrten mit priv. PKW', 'url' => ['/m3-fahrten-positionen']],
								 $pers_Aufgaben,
								 ['label' => 'Logout',
									'url' => ['/site/logout'],
									'linkOptions' => ['data-method' => 'post']],
								$wlan,
								$joomla,
								$bootstrap,
								$sqllog,
								$aufgaben,
						]];

						if (Yii::$app->user->identity and in_array(Yii::$app->user->identity->username, $berechtigung_test_team))  {
												$user['items'][] =
															['label' => 'Terminal', 'url' => ['/procontrol'],'linkOptions' => ['target' => '_blank']];
													}



#------------------------------------------------------------------------------------------------------------------------
#Hier beginnt die Navigationsleiste

            NavBar::begin([
                'brandLabel' => '<img src="'.Yii::$app->getUrlManager()->getBaseUrl().'/images/m3profile.jpg" style="float:left; margin-right:10px; padding-left:15px;"/><div><h3 style="margin-top:10px;"></h3></div>',#Html::img('@web/images/m3profile.jpg', ['alt'=>Yii::$app->name]),
                'brandUrl' => Yii::$app->homeUrl,
                'brandOptions' =>['class' => 'my-navbar-brand'] ,
                'innerContainerOptions' => ['class' => 'container-fluid'],
                'options' => [
                    'class' => 'my-navbar navbar-default navbar-fixed-top',
                ],
            ]);


	            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'encodeLabels' => false,
                'items' => [
                    ['label' => '<span class="glyphicon glyphicon-home"></span>', 'url' => ['/site/index']],
                    $m3profile,
										$kalender,
										$produktion,
										$technikum,
										$qs,
										$planung,
										$logistik,
										$verwaltung,
										$auswertung,
                    $user,


                ],
            ]);


#--------------
            NavBar::end();
?>
