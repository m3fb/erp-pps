<?php

namespace app\controllers;

use Yii;
use app\models\Urlaub;
use app\models\Event;
use app\models\UrlaubSearch;
use app\models\User;
use app\models\AccessRule;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;

/**
 * UrlaubController implements the CRUD actions for Urlaub model.
 */
class UrlaubController extends Controller
{
	// Layout mit Seitendarstellung zur Navigation
	public $layout = 'urlaub';
    /**
     * @inheritdoc
     */


### Zugriffsrechte für einzelne Usergruppen
// Die individuelle Anzeige für Navbar etc findet sich in den Layouts
public function behaviors()
       {
           return [
               'verbs' => [
                   'class' => VerbFilter::className(),
                   'actions' => [
                       'delete' => ['post'],
                   ],
               ],
               'access' => [
                   'class' => \yii\filters\AccessControl::className(),
                   // We will override the default rule config with the new AccessRule class
                   'ruleConfig' => [
                       'class' => AccessRule::className(),
                   ],
                   'only' => ['abrechnung','antrag', 'manager', 'schicht','verwaltung'],
                   'rules' => [
                       [
                           'actions' => ['antrag'],
                           'allow' => true,

                           'roles' => [
                             User::ROLE_ADMIN,
              							 User::ROLE_USER,
              							 User::ROLE_VERWALTER,
              							 User::ROLE_ABRECHNER
                           ],
                       ],
                       [
                           'actions' => ['manager','schicht','verwaltung'],
                           'allow' => true,

                           'roles' => [
                               User::ROLE_ADMIN,
              							   User::ROLE_ENTSCHEIDER,
              							   User::ROLE_ABRECHNER

                           ],
                       ],
					   [
                           'actions' => ['abrechnung'],
                           'allow' => true,

                           'roles' => [
                               User::ROLE_ADMIN,
							   User::ROLE_ABRECHNER

                           ],
                       ],
                   ],
               ],
           ];
       }


// Funktion zum automatischen Ausloggen nach Inaktivität:
public function actionSession()
{
	$model = new Urlaub();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();
		$call= explode(":", $data['call']);

		// Überprüfung wer eingeloggt ist.
		// 20 / 25: Admin - kein automatisches Ausloggen
		// 10 / 15: normaler User wird nachfolgend ausgeloggt
		if((Yii::$app->user->identity->role==10 || Yii::$app->user->identity->role==15) && !Yii::$app->user->isGuest){
			 $session = Yii::$app->session;
			// echo Yii::$app->session->getId();
			 $session->destroy();

			return 1;
			 // Hier evtl Flash / etc setzen um Grund fürs Ausgeloggt-Werden zu nennen

		}
		else {
			return 0;
		}

  }
}

// Funktion zum automatischen Ausloggen nach Inaktivität:
public function actionSessioncheck()
{
    return 1;
	// $model = new Urlaub();
	// if (Yii::$app->request->isAjax) {
		// // $data = Yii::$app->request->post();
		// // $call= explode(":", $data['call']);
    
		// ### Wenn User eingeloggt: return 1, ansonsten 0
		// if(!Yii::$app->user->isGuest){
			// return 1; 
		// }
		// else {
			// return 0;
		// }

  // }
}


#### PDF Im Browserfenster anzeigen
public function actionPdf() {
	$model = new Urlaub();

	$name = $_GET['name'];
	$pnr = $_GET['pnr'];
	$start = $_GET['start'];
	$ende = $_GET['ende'];
	$bearb = $_GET['bearb'];
	$datum = $_GET['datum'];
	$tage = $_GET['tage'];
	$stunden = $_GET['stunden'];


    // get your HTML raw content without any layouts or scripts
    $content = "<h3>Bestätigter Urlaub</h3>"."Arbeitnehmer: ".$name." <br> Personalnummer: ". $pnr
				. "<br><br> Urlaubsbeginn: ". $start . "<br> Urlaubsende: ". $ende ." <br> <br> Aufgewendete Urlaubstage: "
				. $tage . "<br> Aufgewendete Stunden (In Tagen): " . $stunden. "<br><br>Bestätigt von: ".$bearb
				. "<br> am " . $datum;

    // setup kartik\mpdf\Pdf component
    $pdf = new Pdf([
        // set to use core fonts only
        'mode' => Pdf::MODE_UTF8,
        // A4 paper format
        'format' => Pdf::FORMAT_A4,
        // portrait orientation
        'orientation' => Pdf::ORIENT_PORTRAIT,
        // stream to browser inline
        'destination' => Pdf::DEST_BROWSER,
		'filename' => '../PDFs/urlaubsantrag2.pdf',
        // your html content input
        'content' => $content,
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting
        'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
        // any css to be embedded if required
        'cssInline' => '.kv-heading-1{font-size:18px}',
         // set mPDF properties on the fly
        'options' => ['title' => 'Urlaubsbestätigung'],
         // call mPDF methods on the fly
        'methods' => [
            'SetHeader'=>['Urlaubsantrag m3profile'],
            'SetFooter'=>['{PAGENO}'],
        ]
    ]);

    // return the pdf output as per the destination setting
    return $pdf->render();
}


public function actionAntrag_update()
{
	$model = new Urlaub();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();
		$start= explode(":", $data['start']);
		$ende= explode(":", $data['ende']);
		$tage= explode(":", $data['tage']);
		$stunden= explode(":", $data['stunden']);
		$startdatum= $start[0];
		$endedatum= $ende[0];
		$tage= $tage[0];
		$stunden= $stunden[0];
		$idstart= explode(":", $data['idstart']);
		$idende= explode(":", $data['idende']);
		$idstart = $idstart[0];
		$idende = $idende[0];

		if($model->tagepruef($model->tagerechner($startdatum,$endedatum),$tage,$stunden)){

			$model->antrag_update($startdatum,$idstart,$endedatum,$idende,$tage,$stunden);
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return "1";
		}
		else {
			return "0";
		}
  }
}




public function actionAbrechnung_such()
{
	$model = new Urlaub();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();

		$monat= explode(":", $data['monat']);
		$jahr= explode(":", $data['jahr']);

		$monat= $monat[0];
		$jahr= $jahr[0];
		$tables = $model->abrechnung_such($monat,$jahr);
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

	return [
		'abrechnung' => $tables,
		];
  }
}


// Abrechnung Stunden / Urlaubstage übertragen (auf nächsten Monat)
public function actionSt_ta()
{
	$model = new Urlaub();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();
		$monat= explode(":", $data['monat']);
		$jahr= explode(":", $data['jahr']);
		$monat= $monat[0];
		$jahr= $jahr[0];

		$bool = $model->abrechnung($monat,$jahr);
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
	return [
		'bool' => $bool,
		];
  }
}




// Abrechnung PDF erstellen
public function actionZeiten()
{
	$model = new Urlaub();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();
		$monat= explode(":", $data['monat']);
		$jahr= explode(":", $data['jahr']);
		$monat= $monat[0];
		$jahr= $jahr[0];
		// Es wird die komplette Zeiten-Abrechnung (keine Auflistung der jew. Tage) zurückgegeben
		$tables = $model->zeiten($monat,$jahr);
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;


	$stand = date("d.m.Y");
	$i = 0;
	$content = "";
	$content = "<table id='abr_tabelle'> <tr><td>Stand: ".$stand."</td></tr>".
	"<tr><td>Von: ".$tables[0]['erstertag']." </td><td>bis ".$tables[0]['letztertag']."<br></td></tr>".
	"<tr><td><br></td></tr></table>";
	foreach($tables as $type){
		$content = $content . "<table id='abr_tabelle'>".
		"<tr><td>PNR: ".$type['pnr']."</td><td>".$type['persname']."</td></tr>".
		"<tr><td>Arbeitstage: ".$type['arbeitstage']."</td><td>Urlaub-Vorperiode: ".$type['vormonat_urlaub']."</td><td>Sollstunden: ".$type['sollstunden']."</td><td>Schichtzulage: ".$type['schichtzulage']."</td></tr>".
		"<tr><td>Freie Tage: ".$type['feiertage']."</td><td>Urlaub aktuell: ".$type['saldo_urlaub']."</td><td>Iststunden: ".$type['gesamt']."</td><td>Nachtzulage: ".$type['nacht']."</td></tr>".
		"<tr><td>Krankheitstage: ".$type['ktage']."</td><td> </td><td>Stundensaldo: ".$type['saldo_stunden']."</td><td>Feiertagszulage: ".$type['feier']."</td></tr>".
		"<tr><td>Urlaubstage: ".$type['utage']."</td><td> </td><td>Stunden-Vorperiode: ".$type['vormonat_stunden']."</td></tr>".
		"<tr><td>Stundenabbau: ". $type['stundenabbau']."</td> <td> </td><td>Stunden-aktuell: ".$type['stunden_aktuell']."</td></tr>".
        "<tr><td>Elternzeit: ".$type['etage']."</td><td> </td></tr>".
		"<tr><td>unbez. Urlaub: ".$type['ubtage']."</td></tr>".
        "<tr><td>(Berufs-)Schule: ".$type['bstage']."</td></tr>"

		. "<br><br>
		<tr><td><hr noshade></td><td><hr noshade></td><td><hr noshade></td><td><hr noshade></td><td><hr noshade></td></tr><br></table><br><br>";

		$i++;
        if($i == 3){
            $content = $content . "<pagebreak />";
            $i = 0;
        }
	}


	// PDF erstellen:

    // setup kartik\mpdf\Pdf component
    $pdf = new Pdf([
        // set to use core fonts only
        'mode' => Pdf::MODE_UTF8,
        // A4 paper format
        'format' => Pdf::FORMAT_A4,
        // portrait orientation
        'orientation' => Pdf::ORIENT_PORTRAIT,
        // stream to browser inline
        'destination' => Pdf::DEST_FILE,
		'filename' => '../PDFs/Abrechnung/abrechnung_'.date("M",strtotime('01.'.$monat.'.'.$jahr)).'-'.$jahr.'.pdf',
        // your html content input
        'content' => $content,
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting
        'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
        // any css to be embedded if required
        'cssInline' => '.kv-heading-1{font-size:18px}',
         // set mPDF properties on the fly
        'options' => ['title' => 'Urlaubsbestätigung'],
         // call mPDF methods on the fly
        'methods' => [
            'SetHeader'=>['Zeitenabrechnung m3profile'],
            'SetFooter'=>['{PAGENO}'],
        ]
    ]);

    // return the pdf output as per the destination setting
	$pdf->render();
	$tables = $model->zeiten($monat,$jahr);
    return $tables;



  }
}




// Tagerechner in Urlaub/Antrag
public function actionZeiten_tabelle()
{
	$model = new Urlaub();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();
		$monat= explode(":", $data['monat']);
		$jahr= explode(":", $data['jahr']);
		$monat= $monat[0];
		$jahr= $jahr[0];
		$tabelle = $model->zeiten_tabelle($monat,$jahr);
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    return [
        'tabelle' => $tabelle,
    ];
  }
}

public function actionGetBenoetigteTage($startdatum,$enddatum)
{
	$model = new Urlaub();
	Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
	return $model->tagerechner($startdatum,$enddatum);
}




// Tagerechner in Urlaub/Antrag
public function actionSample()
{
	$model = new Urlaub();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();
		$start= explode(":", $data['start']);
		$ende= explode(":", $data['ende']);
		$startdatum= $start[0];
		$endedatum= $ende[0];
		$urlaubstage = $model->tagerechner($startdatum,$endedatum);
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    return [
        'urlaub' => $urlaubstage,
        'code' => 100,
    ];
  }
}

// Übernehmen des Schichtplans
public function actionSchichteintrag()
{
	$model = new Urlaub();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();
		// CHECK: 0: Eintrag in DB, 1: Auslesen aus DB
		$check = $data['CHECK'];
		$KW= $data['KW'];
		$jahr = $data['JAHR'];
		$mo_frueh = str_replace('X SF', ',', $data['MO_FRUEH']);
		$mo_spaet = str_replace('X SF', ',', $data['MO_SPAET']);
		$mo_nacht = str_replace('X SF', ',', $data['MO_NACHT']);
		$di_frueh = str_replace('X SF', ',', $data['DI_FRUEH']);
		$di_spaet = str_replace('X SF', ',', $data['DI_SPAET']);
		$di_nacht = str_replace('X SF', ',', $data['DI_NACHT']);
		$mi_frueh = str_replace('X SF', ',', $data['MI_FRUEH']);
		$mi_spaet = str_replace('X SF', ',', $data['MI_SPAET']);
		$mi_nacht = str_replace('X SF', ',', $data['MI_NACHT']);
		$do_frueh = str_replace('X SF', ',', $data['DO_FRUEH']);
		$do_spaet = str_replace('X SF', ',', $data['DO_SPAET']);
		$do_nacht = str_replace('X SF', ',', $data['DO_NACHT']);
		$fr_frueh = str_replace('X SF', ',', $data['FR_FRUEH']);
		$fr_spaet = str_replace('X SF', ',', $data['FR_SPAET']);
		$fr_nacht = str_replace('X SF', ',', $data['FR_NACHT']);
		$sa_frueh = str_replace('X SF', ',', $data['SA_FRUEH']);
		$sa_spaet = str_replace('X SF', ',', $data['SA_SPAET']);
		$sa_nacht = str_replace('X SF', ',', $data['SA_NACHT']);
		$so_frueh = str_replace('X SF', ',', $data['SO_FRUEH']);
		$so_spaet = str_replace('X SF', ',', $data['SO_SPAET']);
		$so_nacht = str_replace('X SF', ',', $data['SO_NACHT']);
		$schichtplan = $model->schichtplaner($check,$KW,$jahr,$mo_frueh,$mo_spaet,$mo_nacht,$di_frueh,$di_spaet,$di_nacht,
											$mi_frueh,$mi_spaet,$mi_nacht,$do_frueh,$do_spaet,$do_nacht,$fr_frueh,$fr_spaet,$fr_nacht,
											$sa_frueh,$sa_spaet,$sa_nacht,$so_frueh,$so_spaet,$so_nacht);
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    return $schichtplan;
  }
}

// Anzeige der Urlaubsanträge im Kalender
public function actionAntraege()
{
	$model = new Urlaub();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();
		$start= explode(":", $data['start']);
		$ende= explode(":", $data['end']);
		$abt = explode(":",$data['abt']);
		$pnr = explode(":",$data['pnra']);
		$startdatum= $start[0];
		$endedatum= $ende[0];
		$pnr = $pnr[0];
		$abt = $abt[0];
		$urlaubstage = $model->abfrage($pnr,$abt);
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		$return_arr = array();
		$row_arr = array();
		$i = 0;
		foreach ($urlaubstage as $type) {

		if($i == 0) {
			$row_array['start'] = $type['MSTIME'];
			#$row_array['allDay'] = 'true';
			$i++;

		}
		else{
			$row_array['end'] = $type['MSTIME'];
			$row_array['title'] = $type['PERSNAME'] . " (Urlaubsantrag)";
			$i = 0;
			array_push($return_arr,$row_array);
		}


		}

		return $return_arr;
}
}
// Anzeige der bestätigten Urlaube im Kalender
public function actionTermine()
{
	$model = new Urlaub();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();
		$start= explode(":", $data['start']);
		$ende= explode(":", $data['end']);
		$abt = explode(":",$data['abt']);
		$pnr = explode(":",$data['pnra']);
		$startdatum= $start[0];
		$endedatum= $ende[0];
		$pnr = $pnr[0];
		$abteilung = $abt[0];
		$urlaubstage = $model->abfragelb($pnr,$abteilung,$startdatum,$endedatum);
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		$return_arr = array();
		$row_arr = array();
		$i = 0;
		foreach ($urlaubstage as $type) {

		if($i == 0) {
			$row_array['start'] = date("Y-m-d",strtotime($type['MSTIME']));
			//$row_array['allDay'] = 'true';
		// Bei datumabhängigen Abfragen kann es sein, dass ein Eintrag "Urlaub Ende" zuerst erscheint
			if($type['STATUS']==800){
			$i++;
			}
			else{
			$row_array['end'] = '';
			$row_array['title'] = $type['PERSNAME'];
			array_push($return_arr,$row_array);
			}
		}
		else{
			if($type['STATUS']==800){
				$row_array['start'] = date("Y-m-d",strtotime($type['MSTIME']));
			}
			else{
			$row_array['end'] =  $type['MSTIME'];
			$row_array['title'] = $type['PERSNAME'] . " (Urlaub)";
			$i = 0;
			array_push($return_arr,$row_array);
			}
		}


		}
		return $return_arr;
}
}


// Anzeige der Betriebsurlaube im Kalender
public function actionBetriebsurlaub()
{
	$model = new Urlaub();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();
		$start= explode(":", $data['start']);
		$ende= explode(":", $data['end']);
		$startdatum= $start[0];
		$endedatum= $ende[0];
		$urlaubstage = $model->betriebsurlaub($startdatum,$endedatum);
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		$return_arr = array();
		$row_arr = array();
		$i = 0;
		foreach ($urlaubstage as $type) {
			$row_arr['start'] = date("Y-m-d",strtotime($type['Startzeit']));
			$row_arr['end'] = $type['Endzeit'];
			$row_arr['title'] = $type['PERSNAME'];
			array_push($return_arr,$row_arr);
		}


		}
		return $return_arr;

}

// Anzeige der Zusatztermine im Kalender
public function actionM3_termine()
{
	$model = new Urlaub();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();
		$start= explode(":", $data['start']);
		$ende= explode(":", $data['end']);
		$startdatum= $start[0];
		$endedatum= $ende[0];
		$tage = $model->m3_termine($startdatum,$endedatum);
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		$return_arr = array();
		$row_arr = array();
		$i = 0;
		foreach ($tage as $type) {
			$row_arr['start'] = $type['START'];
			$row_arr['end'] = $type['ENDE'];
			$row_arr['title'] = $type['TITEL'];
			array_push($return_arr,$row_arr);
		}
		return $return_arr;
}
}
// Eintragen der Zusatztermine im Kalender
public function actionM3_termine_eintr()
{
	$model = new Urlaub();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();
		$titel= explode(":", $data['titel']);
		$start= explode(":", $data['start']);
		$ende= explode(":", $data['ende']);
		$startdatum= $start[0];
		$endedatum= $ende[0];
		$titel = $titel[0];
		$tage = $model->m3_termine_eintr($startdatum,$endedatum,$titel);
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;


		return 1;
}
}
// Löschen der Zusatztermine im Kalender
public function actionM3_termine_loesch()
{
	$model = new Urlaub();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();
		$id= explode(":", $data['id']);
		$id = $id[0];
		$tage = $model->m3_termine_loesch($id);
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;


	 return [
        'id' => $id,
    ];
}
}


// Eintragen der Betriebsurlaube im Kalender
public function actionM3_betrieb_eintr()
{
	$model = new Urlaub();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();
		$start= explode(":", $data['start']);
		$ende= explode(":", $data['ende']);
		$startdatum= $start[0];
		$endedatum= $ende[0];
		$tage = $model->m3_betrieb_eintr($startdatum,$endedatum);
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;


		return 1;
}
}

// Löschen der Betriebsurlaube im Kalender
public function actionM3_betrieb_loesch()
{
	$model = new Urlaub();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();
		$id= explode(":", $data['id']);
		$id = $id[0];
		$idende = $id + 1;
		$tage = $model->m3_betrieb_loesch($id,$idende);
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;


	 return [
        'id' => $id,
    ];
}
}

public function actionSchichturlaub()
{
	$model = new Urlaub();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();
		$start= explode(":", $data['start']);
		$ende= explode(":", $data['end']);
		$abt = explode(":",$data['abt']);
		$startdatum= $start[0];
		$endedatum= $ende[0];
		$abteilung = $abt[0];
		$urlaubstage = $model->mitarbeiter($abteilung,$startdatum,$endedatum);
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		$return_arr = array();
		$i = 0;
		$n = 0;
		$tagestr = "";

		foreach($urlaubstage as $type=>$tage) {
			$tagestr = " ";
			$n = 0;
			$i = count($tage)-2;

			while($n<$i) {
				$tagestr = $tagestr . " " . $tage[$n];
				$n++;
			}

		array_push($return_arr, $tage['name'] . "§" . $tage['id'] . "§" .$tagestr);
		}
return $return_arr;
}
}


public function actionSchichtzukalender()
{
	$model = new Urlaub();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();
		$start= explode(":", $data['start']);
		$ende= explode(":", $data['end']);
		$startdatum= $start[0];
		$endedatum= $ende[0];
		$kw = $model->schichtzukalender($startdatum,$endedatum);
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		$return_arr = array();
		$row_arr = array();
		foreach ($kw as $type) {
			$datum = new \DateTime();
			$datum->setISODate($type['JAHR'], $type['KW']);
			$row_arr['start'] = $datum->format('Y-m-d 06:00');
			$row_arr['end'] = $datum->format('Y-m-d 14:00');
			$row_arr['title'] = "Frühschicht: ".$type['MO_FRUEH'];
			array_push($return_arr,$row_arr);
			$row_arr['start'] = $datum->format('Y-m-d 14:00');
			$row_arr['end'] = $datum->format('Y-m-d 22:00');
			$row_arr['title'] = "Spätschicht: ".$type['MO_SPAET'];
			array_push($return_arr,$row_arr);
			$row_arr['start'] = $datum->format('Y-m-d 22:00');
			$datum->modify('+1 days');
			$row_arr['end'] = $datum->format('Y-m-d 06:00');
			$row_arr['title'] = "Nachtschicht: ".$type['MO_NACHT'];
			array_push($return_arr,$row_arr);


			$row_arr['start'] = $datum->format('Y-m-d 06:00');
			$row_arr['end'] = $datum->format('Y-m-d 14:00');
			$row_arr['title'] = "Frühschicht: ".$type['DI_FRUEH'];
			array_push($return_arr,$row_arr);
			$row_arr['start'] = $datum->format('Y-m-d 14:00');
			$row_arr['end'] = $datum->format('Y-m-d 22:00');
			$row_arr['title'] = "Spätschicht: ".$type['DI_SPAET'];
			array_push($return_arr,$row_arr);
			$row_arr['start'] = $datum->format('Y-m-d 22:00');
			$datum->modify('+1 days');
			$row_arr['end'] = $datum->format('Y-m-d 06:00');
			$row_arr['title'] = "Nachtschicht: ".$type['DI_NACHT'];
			array_push($return_arr,$row_arr);


			$row_arr['start'] = $datum->format('Y-m-d 06:00');
			$row_arr['end'] = $datum->format('Y-m-d 14:00');
			$row_arr['title'] = "Frühschicht: ".$type['MI_FRUEH'];
			array_push($return_arr,$row_arr);
			$row_arr['start'] = $datum->format('Y-m-d 14:00');
			$row_arr['end'] = $datum->format('Y-m-d 22:00');
			$row_arr['title'] = "Spätschicht: ".$type['MI_SPAET'];
			array_push($return_arr,$row_arr);
			$row_arr['start'] = $datum->format('Y-m-d 22:00');
			$datum->modify('+1 days');
			$row_arr['end'] = $datum->format('Y-m-d 06:00');
			$row_arr['title'] = "Nachtschicht: ".$type['MI_NACHT'];
			array_push($return_arr,$row_arr);


			$row_arr['start'] = $datum->format('Y-m-d 06:00');
			$row_arr['end'] = $datum->format('Y-m-d 14:00');
			$row_arr['title'] = "Frühschicht: ".$type['DO_FRUEH'];
			array_push($return_arr,$row_arr);
			$row_arr['start'] = $datum->format('Y-m-d 14:00');
			$row_arr['end'] = $datum->format('Y-m-d 22:00');
			$row_arr['title'] = "Spätschicht: ".$type['DO_SPAET'];
			array_push($return_arr,$row_arr);
			$row_arr['start'] = $datum->format('Y-m-d 22:00');
			$datum->modify('+1 days');
			$row_arr['end'] = $datum->format('Y-m-d 06:00');
			$row_arr['title'] = "Nachtschicht: ".$type['DO_NACHT'];
			array_push($return_arr,$row_arr);


			$row_arr['start'] = $datum->format('Y-m-d 06:00');
			$row_arr['end'] = $datum->format('Y-m-d 14:00');
			$row_arr['title'] = "Frühschicht: ".$type['FR_FRUEH'];
			array_push($return_arr,$row_arr);
			$row_arr['start'] = $datum->format('Y-m-d 14:00');
			$row_arr['end'] = $datum->format('Y-m-d 22:00');
			$row_arr['title'] = "Spätschicht: ".$type['FR_SPAET'];
			array_push($return_arr,$row_arr);
			$row_arr['start'] = $datum->format('Y-m-d 22:00');
			$datum->modify('+1 days');
			$row_arr['end'] = $datum->format('Y-m-d 06:00');
			$row_arr['title'] = "Nachtschicht: ".$type['FR_NACHT'];
			array_push($return_arr,$row_arr);


			$row_arr['start'] = $datum->format('Y-m-d 06:00');
			$row_arr['end'] = $datum->format('Y-m-d 14:00');
			$row_arr['title'] = "Frühschicht: ".$type['SA_FRUEH'];
			array_push($return_arr,$row_arr);
			$row_arr['start'] = $datum->format('Y-m-d 14:00');
			$row_arr['end'] = $datum->format('Y-m-d 22:00');
			$row_arr['title'] = "Spätschicht: ".$type['SA_SPAET'];
			array_push($return_arr,$row_arr);
			$row_arr['start'] = $datum->format('Y-m-d 22:00');
			$datum->modify('+1 days');
			$row_arr['end'] = $datum->format('Y-m-d 06:00');
			$row_arr['title'] = "Nachtschicht: ".$type['SA_NACHT'];
			array_push($return_arr,$row_arr);


			$row_arr['start'] = $datum->format('Y-m-d 06:00');
			$row_arr['end'] = $datum->format('Y-m-d 14:00');
			$row_arr['title'] = "Frühschicht: ".$type['SO_FRUEH'];
			array_push($return_arr,$row_arr);
			$row_arr['start'] = $datum->format('Y-m-d 14:00');
			$row_arr['end'] = $datum->format('Y-m-d 22:00');
			$row_arr['title'] = "Spätschicht: ".$type['SO_SPAET'];
			array_push($return_arr,$row_arr);
			$row_arr['start'] = $datum->format('Y-m-d 22:00');
			$datum->modify('+1 days');
			$row_arr['end'] = $datum->format('Y-m-d 06:00');
			$row_arr['title'] = "Nachtschicht: ".$type['SO_NACHT'];
			array_push($return_arr,$row_arr);

		}
			return $return_arr;

}

}
















    public function actionAntrag()
    {
        $model = new Urlaub();

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			if($model->tagepruef($model->tagerechner($model->start,$model->ende),$model->tage,$model->stunden)){

			if ( isset( $_POST[ 'btnAbschicken' ] ))
			{
				$model->eintragen($model->pnr,$model->start,$model->ende,$model->name,$model->tage,$model->stunden);
				Yii::$app->getSession()->setFlash('urlaubgest', '<big><u><span class="label label-success">Urlaubsantrag gestellt!</span></u></big><br />');

			}

			}
			else {
				Yii::$app->getSession()->setFlash('benTage', '<span class="label label-warning">Die Anzahl der aufzuwendenden Tage/Stunden stimmt nicht überein. <br> Bitte überprüfen! <br></span>');
            }

				return $this->render('antrag', ['model' => $model]);
            }
		else {


			// either the page is initially displayed or there is some validation error
            return $this->render('antrag', ['model' => $model]);
            }

    }



    public function actionKalender($start=NULL,$end=NULL,$_=NULL)
    {
	   $model = new Urlaub();

        return $this->render('kalender', [
            'model' => $model
        ]);
  }



    public function actionSchicht($start=NULL,$end=NULL,$_=NULL)
    {
	   $model = new Urlaub();

        return $this->render('schicht', [
            'model' => $model
        ]);
  }

    public function actionVerwaltung($start=NULL,$end=NULL,$_=NULL)
    {
	   $model = new Urlaub();
	if ($model->load(Yii::$app->request->post())){
		$model->verwaltung($_POST['Urlaub']['pnra'],$_POST['Urlaub']['start'],$_POST['Urlaub']['ende'],$_POST['Urlaub']['status']);
		Yii::$app->getSession()->setFlash('status_gest', '<u>Eingetragen!</u><br />');
		return $this->render('verwaltung', ['model' => $model]);
	}
    return $this->render('verwaltung', [
        'model' => $model
    ]);
    }


public function actionVerw_abfrage()
{
	$model = new Urlaub();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();
		$pnra= explode(":", $data['pnra']);
		$pnra= $pnra[0];
		$start= explode(":", $data['start']);
		$start= $start[0];
		$ende= explode(":", $data['ende']);
		$ende= $ende[0];

		if($start==0){
		$start = date("Y-m-d", strtotime('-50 day'));
		$ende = date("Y-m-d", strtotime('+50 day'));
		}

		$start = date("Y-d-m",strtotime($start. '-10 day'));
		$ende = date("Y-d-m",strtotime($ende . '+10 day'));

		$tage = $model->tage_check($pnra,$start,$ende);
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		return $tage;
		}
  }





    public function actionManager()
    {
        $model = new Urlaub();
		if ($model->load(Yii::$app->request->post())) {

			if ( isset( $_POST[ 'btnAnnehmen' ] ) )
			{
				//Yii::$app->request->post('name')

				$model->bestaetigen($_POST['Urlaub']['idstart'],$_POST['Urlaub']['idende']);
				//$this->refresh();
			}

			elseif ( isset( $_POST[ 'btnAblehnen' ] ) )
			{
				$model->ablehnen($_POST['Urlaub']['idstart'],$_POST['Urlaub']['idende']);
				$this->refresh();
			}

			elseif ( isset( $_POST[ 'btnLoeschen' ] ) )
			{
				$model->loeschen($_POST['Urlaub']['idstart'],$_POST['Urlaub']['idende']);
				$this->refresh();
			}




			$model->abfrage($model->pnra,0);
			return $this->render('manager', ['model' => $model]);
		}
		else{


            return $this->render('manager', [
                'model' => $model,
            ]);
		}

    }



    public function actionAbrechnung()
    {
        $model = new Urlaub();
		// if ($model->load(Yii::$app->request->post())) {

			// if ( isset( $_POST[ 'btnAbrechnen' ] ) )
			// {
				// //Yii::$app->request->post('name')

				// $model->abrechnung(355802);
				// return $this->render('abrechnung', ['model' => $model]);
			// }

			// if ( isset( $_POST[ 'btnAbfragen' ] ) )
			// {

				// $model->abfrage($model->pnra,0);

			// return $this->render('abrechnung', ['model' => $model]);
			// }






		// }
		// else{


            return $this->render('abrechnung', [
                'model' => $model,
            ]);
		// }

    }


	public function actionGeburtstage()
    {
        $model = new Urlaub();
        return $this->render('geburtstage', [
            'model' => $model,
        ]);
    }


    /**
     * Lists all Urlaub models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UrlaubSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Urlaub model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Urlaub model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Urlaub();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->LBNO]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Urlaub model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->LBNO]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Urlaub model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Urlaub model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Urlaub the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Urlaub::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
