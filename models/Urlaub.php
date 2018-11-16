<?php

namespace app\models;

use Yii;
use kartik\mpdf\Pdf;
use app\models\Personal;

 require 'urlaubrechner.php';
 require 'abrechnungfkt.php';
 require 'zusatzfunktionen/istsf.php';
 require 'zusatzfunktionen/monatsdatenfkt.php';
 //require 'zusatzfunktionen/tage.php';
 //require 'zusatzfunktionen/zeiten.php';

class Urlaub extends \yii\db\ActiveRecord
{
	public $pnr;
	public $test;
	public $start;
	public $ende;
	public $name;
	public $tage;
	public $stunden;
	public $msstart;
	public $msende;
	public $cdate;
	public $lbnostart;
	public $lbnoende;
	public $lbnoneu;
	public $tables;
	public $pnra;
	public $idstart;
	public $idende;
	public $aendern_start;
	public $aendern_ende;
	public $aendern_stunden;
	public $aendern_tage;
	public $abt;
	public $status;
	public $titel;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm3_urlaubsplanung';
    }
	public function istsf($a,$b){
	return istsf($a,$b);

	}


	// Überprüfen ob die eingegebenen Tage / Stunden Kombi mit dem errechneten Tagebedarf übereinstimmt
	public function tagepruef($bentage,$tage,$stunden){
    if(!$stunden)
        $stunden = 0;
    if(!$tage)
        $tage = 0;
		if($bentage==($tage+$stunden))
			return true;
		else
			return false;
	}

	// Funktion ob Feiertag oder Wochenende ja / nein
	public function istfrei($termin) {

	// Aufsplitten des Datums (Format dd.mm.YYYY) am Punkt
	list ($tag, $monat, $jahr) = explode('.', $termin);


    // Parameter in richtiges Format bringen
    if(strlen($tag) == 1) {
       $tag = "0$tag";
    }
    if(strlen($monat) == 1) {
       $monat = "0$monat";
    }

    // Wochentag berechnen
    $datum = getdate(mktime(0, 0, 0, $monat, $tag, $jahr));
    $wochentag = $datum['wday'];

    // Prüfen, ob Wochenende
    if($wochentag == 0 || $wochentag == 6) {
       return true;
    }

    // Feste Feiertage werden nach dem Schema ddmm eingetragen
    $feiertage[] = "0101"; // Neujahrstag
    $feiertage[] = "0601"; // Heilige Drei Könige
    $feiertage[] = "0105"; // Tag der Arbeit
    $feiertage[] = "0310"; // Tag der Deutschen Einheit
    $feiertage[] = "0111"; // Allerheiligen
    $feiertage[] = "2512"; // Erster Weihnachtstag
    $feiertage[] = "2612"; // Zweiter Weihnachtstag

	##### Reformationstag (Ausschließlich 2017! Wieder rausnehmen!)
	#$feiertage[] = "3110";

    // Bewegliche Feiertage berechnen  (Oster-/Pfingstsontag wird schon durch Prüfung Wochenende abgedeckt)
    $tage = 60 * 60 * 24;
    $ostersonntag = easter_date($jahr);
    $feiertage[] = date("dm", $ostersonntag - (2 * $tage));  // Karfreitag
    $feiertage[] = date("dm", $ostersonntag + (1 * $tage));  // Ostermontag
    $feiertage[] = date("dm", $ostersonntag + (39 * $tage)); // Himmelfahrt
    $feiertage[] = date("dm", $ostersonntag + (50 * $tage)); // Pfingstmontag
    $feiertage[] = date("dm", $ostersonntag + (60 * $tage)); // Fronleichnam

    // Prüfen, ob Feiertag
    $code = $tag.$monat;
    return in_array($code, $feiertage);
	}



	public function tagerechner($start,$ende) {

    $betriebsurlaub = tage_betriebsurlaub(5,$start,$ende);
	//  "\" vor DateTime um´s in Yii benutzen zu können    ... (global namespace)
	$start =  new \DateTime($start);
	$ende = new \DateTime($ende);
	$interval = $start->diff($ende);
	$gesamttage = $interval->format('%a') + 1;   // Gesamte Tagesdifferenz ausrechnen, +1 für den ersten Tag ($start)


    $betrieb_array = array();
    $i=0;
    foreach($betriebsurlaub as $tag) {
        $betrieb_array[$i] = date("dmy",strtotime($tag['Datum']));
        $i++;
    }
   // print_r($betriebsurlaub);

	$n = 0;
	while($start <= $ende){
		if($this->istfrei($start->format('d.m.Y'))){
			$n++;
		}
		else if(in_array($start->format('dmy'),$betrieb_array)){
            $n++;
        }
        $start->modify('+1 day');

	}
	$ben_urlaubstage = $gesamttage - $n;


	return $ben_urlaubstage;

	}

	public function antrag_update($start,$idstart,$ende,$idende,$tage,$stunden){

	Yii::$app->db->createCommand("UPDATE m3_urlaubsplanung
								  SET MSTIME =  '".$start."',
									  TAGE = '".$tage."',
									  STUNDEN = '".$stunden."'
								  WHERE LBNO = ".$idstart."
								")
	->execute();
	Yii::$app->db->createCommand("UPDATE m3_urlaubsplanung
								  SET MSTIME =  '".$ende."',
									  TAGE = '".$tage."',
									  STUNDEN = '".$stunden."'
								  WHERE LBNO = ".$idende."
								")
	->execute();





}
	public function m3_betrieb_loesch($idstart,$idende){
        $pnr = Yii::$app->db->CreateCommand("
                    SELECT PERSNO FROM m3_urlaubsplanung WHERE LBNO = ".$idstart." ")
                    ->queryONE();

        $zahl = array_keys($pnr);
		$pnr = $pnr[$zahl[0]];
        if($pnr == 5){
            urlaubrechner($idstart,$idende,2);
        }
		Yii::$app->db->CreateCommand("
				DELETE FROM m3_urlaubsplanung
				WHERE LBNO = ".$idstart."
				OR LBNO = ".$idende."
				")
		->execute();
	return 1;
	}


	public function m3_betrieb_eintr($start,$ende){
		$tage = tagerechner($start,$ende);
		$start = date("Y-d-m 00:00:00.000",strtotime($start));
		$ende = date("Y-d-m 23:59:59.000",strtotime($ende));
		$pnr = 5;
		$name = "Betriebsurlaub";
		$beschr1 = "Betriebsurlaub Start";
		$beschr2 = "Betriebsurlaub Ende";
		$gesamt_tage = $tage;
		$cdate = date("Y-d-m H:i:s");
		$cname = Yii::$app->user->identity->firstname . " ". Yii::$app->user->identity->surename;


		Yii::$app->db->createCommand("INSERT INTO m3_urlaubsplanung
										([MSTIME],
										 [PERSNO],
										 [PERSNAME],
										 [CDATE],
										 [CNAME],
										 [BESCHREIBUNG],
										 [BEST],
										 [GESAMT_TAGE],
										 [STATUS],
										 [TAGE]
										 )
										 VALUES (
										 '".$start."',
										 ".$pnr.",
										 '".$name."',
										 '".$cdate."',
										 '".$cname."',
										 '".$beschr1."',
										 1,
										 ".$gesamt_tage.",
										 800,
										 ".$tage."
										 );
										 ")
		->execute();

		Yii::$app->db->createCommand("INSERT INTO m3_urlaubsplanung
										([MSTIME],
										 [PERSNO],
										 [PERSNAME],
										 [CDATE],
										 [CNAME],
										 [BESCHREIBUNG],
										 [BEST],
										 [GESAMT_TAGE],
										 [STATUS],
										 [TAGE]
										 )
										 VALUES (
										 '".$ende."',
										 ".$pnr.",
										 '".$name."',
										 '".$cdate."',
										 '".$cname."',
										 '".$beschr2."',
										 1,
										 ".$gesamt_tage.",
										 801,
										 ".$tage."
										 );
										 ")
		->execute();



        $eintraege = Yii::$app->db->createCommand("SELECT A.LBNO as idstart, B.LBNO as idende  FROM m3_urlaubsplanung A
                                      INNER JOIN m3_urlaubsplanung B
                                      ON A.LBNO = B.LBNO -1
                                      WHERE A.PERSNAME LIKE 'Betriebsurlaub' AND A.MSTIME = '".$start."' AND B.MSTIME = '".$ende."'
                                      ")
        ->queryAll();

        foreach($eintraege as $eintrag){
            $idstart = $eintrag['idstart'];
            $idende = $eintrag['idende'];
        }
        urlaubrechner($idstart,$idende,3);

		return 1;
	}


	public function m3_termine_eintr($start,$ende,$titel){
		$start = date("Y-d-m",strtotime($start));
		$ende = date("Y-d-m 23:59:59.000",strtotime($ende));
		$titel = $titel;
		Yii::$app->db->createCommand("INSERT INTO m3_termine
										([START],
										 [ENDE],
										 [TITEL],
                                         [pruef]
										 )
										 VALUES (
										 '".$start."',
										 '".$ende."',
										 '".$titel."',
                                         1
										 );
										 ")
		->execute();
		return 1;
	}

	public function m3_termine_loesch($id){
		$id = $id;

		Yii::$app->db->CreateCommand("DELETE FROM m3_termine WHERE ID = ".$id."")
		->execute();
		return 1;
	}


	public function m3_termine($start,$ende){
		$tables = Yii::$app->db->createCommand("SELECT * FROM m3_termine
												WHERE (([START] Between Convert(datetime2,'".$start." 00:00:00')
												AND Convert(datetime2,'".$ende." 23:59:59'))
												OR ([ENDE] Between Convert(datetime2,'".$start." 00:00:00')
												AND Convert(datetime2,'".$ende." 23:59:59')))
                                                AND pruef = 1
												ORDER BY ID")
		->queryAll();
		return $tables;
	}


	// Abfrage auf offene Urlaubsanträge
	public function abfrage($pnra,$abt){
	if($abt=="Abteilung" || $abt=="Alle") {
		$zw = "";
	}
	else{
		$zw = "AND (FAG_DETAIL.TXT02 LIKE '".$abt."')";
	}

	if($pnra == 0){
	$tables = Yii::$app->db->createCommand("SELECT PERSNAME,PERSNO,TXT02,TXT03,MSTIME,m3_urlaubsplanung.CDATE as CDATE, TAGE,STUNDEN,LBNO, WORKID
											FROM m3_urlaubsplanung
											INNER JOIN [FAG_DETAIL] ON m3_urlaubsplanung.WORKID = FAG_DETAIL.FKNO
											WHERE FAG_DETAIL.TYP = 26 AND m3_urlaubsplanung.BEST = 0
											AND (STATUS = 800 OR STATUS = 801)
											" . $zw . "")
    ->queryAll();
	return $tables;
	}
	else
	{
	$tables = Yii::$app->db->createCommand("SELECT PERSNAME,PERSNO,TXT02,TXT03,MSTIME,m3_urlaubsplanung.CDATE as CDATE, TAGE,STUNDEN,LBNO, WORKID
											FROM m3_urlaubsplanung
											INNER JOIN [FAG_DETAIL] ON m3_urlaubsplanung.WORKID = FAG_DETAIL.FKNO
											WHERE PERSNO = " . $pnra . " AND FAG_DETAIL.TYP = 26
											AND m3_urlaubsplanung.best = 0 AND (STATUS = 800 OR STATUS = 801)")
    ->queryAll();

	return $tables;
	}

	}

	// Abfrage für bereits bestätigten Urlaub
	public function abfragelb($pnra,$abt,$start,$ende){
	if($abt=="Abteilung" || $abt=="Alle") {
		$zw = "";
	}
	else{
		$zw = "AND (FAG_DETAIL.TXT02 LIKE '".$abt."')";
	}
	// In der Abfrage werden 2 Monate zum Abfragezeitraum hinzugefügt / abgezogen um eventuelle zusammengehörigen Anträge
	// die nichtmehr im Zeitraum vorhanden sind trotzdem zu erfassen
	if($pnra == 0){
	$tables = Yii::$app->db->createCommand("SELECT * FROM m3_urlaubsplanung
											RIGHT JOIN [FAG_DETAIL] ON m3_urlaubsplanung.WORKID = FAG_DETAIL.FKNO
											WHERE (STATUS = 800 OR STATUS = 801)
											AND ([MSTIME] Between DATEADD(month, -2,Convert(datetime2,'".$start." 00:00:00'))
											AND   DATEADD(month, 2,Convert(datetime2,'".$ende." 23:59:59')))
											AND FAG_DETAIL.TYP = 26
											AND BEST = 1
											" . $zw . "
											ORDER BY LBNO")
    ->queryAll();
	return $tables;
	}
	else
	{
	//$zahl = array_keys($pnra);
	//$pnra = $pnra[$zahl[0]];
	### Funktion wird im Ajaxscript bei Anträge verwendet
	$tables = Yii::$app->db->createCommand("SELECT * FROM m3_urlaubsplanung
											RIGHT JOIN [FAG_DETAIL] ON m3_urlaubsplanung.WORKID = FAG_DETAIL.FKNO
											WHERE PERSNO = " . $pnra . "
											AND (STATUS = 800 OR STATUS = 801)
											AND ([MSTIME] Between DATEADD(week, -1,Convert(datetime2,'".$start." 00:00:00'))
											AND   DATEADD(month, 1,Convert(datetime2,'".$ende." 23:59:59')))
											AND FAG_DETAIL.TYP = 26
											AND BEST = 1
											ORDER BY LBNO")
    ->queryAll();

	return $tables;
	}
	}

	public function betriebsurlaub($start,$ende){
		$tables = Yii::$app->db->CreateCommand ("
			SELECT A.MSTIME as Startzeit, B.MSTIME as Endzeit, A.LBNO as LBNO,A.PERSNAME as PERSNAME, A.GESAMT_TAGE as gesamt_tage FROM m3_urlaubsplanung A
			INNER JOIN m3_urlaubsplanung B
			ON A.LBNO = B.LBNO -1
			WHERE A.PERSNO = 5 AND ((DATEPART(yyyy,A.MSTIME) = DATEPART(yyyy,GETDATE()) AND A.STATUS = 800) OR
			(DATEPART(yyyy,B.MSTIME) = DATEPART(yyyy,GETDATE()) AND B.STATUS = 801)) ")
		->queryAll();

		return $tables;
	}

	public function bestaetigen($idstart,$idende)
	{

	// Schritt 1: Verechnete Urlaubstage / Überstunden vom Konto abziehen
	// externe Datei: urlaubrechner.php
	 $bool = urlaubrechner($idstart,$idende,1);
	 if($bool == 0)
		 return "nicht genügend Urlaubstage vorhanden";



	// LBNO in m3_urlaubsplanung = LBNO in LB_DC
	// Schritt 2: Daten für jeden Eintrag übertragen
	// TODO: CHDATE hinzuf. (Tag der Bestätigung)
	Yii::$app->db->createCommand("UPDATE m3_urlaubsplanung
								  SET
									  CNAME = '". Yii::$app->user->identity->firstname . " ". Yii::$app->user->identity->surename ."',
									  CHDATE = GETDATE(),
									  BEST = 1
								  WHERE m3_urlaubsplanung.LBNO = ".$idstart." OR m3_urlaubsplanung.LBNO = ".$idende."
								")
	->execute();


	// Schritt 3: PDF erstellen und abspeichern
	// Relevante Daten speichern
	$tables = Yii::$app->db->createCommand("
							SELECT * FROM m3_urlaubsplanung
							WHERE LBNO = ".$idstart." OR LBNO = ".$idende." ORDER BY LBNO
							")
		->queryAll();
	// Daten Variablen zuordnen
	$i = 0;
	foreach($tables as $type){
		$name = $type['PERSNAME'];
		$pnr = $type['PERSNO'];
		if($i)
			$ende = date("d.m.Y",strtotime($type['MSTIME']));
		else
			$start = date("d.m.Y",strtotime($type['MSTIME']));
		$tage = $type['TAGE'];
		$stunden = $type['STUNDEN'];
		$datum = date("d.m.Y  G:i:s");
	$i++;
	}


	  $content = "<h3>Bestätigter Urlaub</h3>"."Arbeitnehmer: ".$name." <br> Personalnummer: ". $pnr
				. "<br><br> Urlaubsbeginn: ". $start . "<br> Urlaubsende: ". $ende ." <br> <br> Aufgewendete Urlaubstage: "
				. $tage . "<br> Aufgewendete Stunden (In Tagen): " . $stunden. "<br><br>Bestätigt von: ". Yii::$app->user->identity->firstname . " " . Yii::$app->user->identity->surename
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
        'destination' => Pdf::DEST_FILE,
		'filename' => '../PDFs/bestUrlaub/urlaub_'.$name.'_'.$start.'.pdf',
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
    $pdf->render();





	// Schritt 4: Setzen des BEST Flaggs für bestätigt

	Yii::$app->db->createCommand("UPDATE m3_urlaubsplanung
									SET [BEST] = 1
							      WHERE LBNO = ".$idstart." OR LBNO = ".$idende."
								 ")
	->execute();


	}


	public function ablehnen($idstart,$idende)
	{
	// Relevante Daten speichern
	$tables = Yii::$app->db->createCommand("
							SELECT * FROM m3_urlaubsplanung
							WHERE LBNO = ".$idstart." OR LBNO = ".$idende." ORDER BY LBNO
							")
		->queryAll();
	// Daten Variablen zuordnen
	$i = 0;
	foreach($tables as $type){
		$name = $type['PERSNAME'];
		$pnr = $type['PERSNO'];
		if($i)
			$ende = date("d.m.Y",strtotime($type['MSTIME']));
        else
            $start = date("d.m.Y",strtotime($type['MSTIME']));
		$tage = $type['TAGE'];
		$stunden = $type['STUNDEN'];
		$datum = date("d.m.Y  G:i:s");
	$i++;
	}


	  $content = "<h3>Abgelehnter Urlaub</h3>"."Arbeitnehmer: ".$name." <br> Personalnummer: ". $pnr
				. "<br><br> Urlaubsbeginn: ". $start . "<br> Urlaubsende: ". $ende ." <br> <br> Aufgewendete Urlaubstage: "
				. $tage . "<br> Aufgewendete Stunden (In Tagen): " . $stunden. "<br><br>Abgelehnt von: ". Yii::$app->user->identity->firstname . " " . Yii::$app->user->identity->surename
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
        'destination' => Pdf::DEST_FILE,
		'filename' => '../PDFs/abgUrlaub/urlaub_'.$name.'_'.$start.'.pdf',
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
    $pdf->render();

	// Urlaubseintrag ungültig machen... gegen das komplette Löschen entschieden um Fehler rückgängig machen zu können (Layer 8)
	Yii::$app->db->createCommand("UPDATE m3_urlaubsplanung
						  SET
							  CHNAME = '". Yii::$app->user->identity->firstname . " ". Yii::$app->user->identity->surename ."',
							  CHDATE = GETDATE(),
							  BEST = -1,
							  BESCHREIBUNG = 'abgelehnter Urlaub',
							  PERSNO = '0'
						  WHERE m3_urlaubsplanung.LBNO = ".$idstart." OR m3_urlaubsplanung.LBNO = ".$idende."
						")
	->execute();
	}


	// Bereits bestätigten Urlaubseintrag loeschen und Werte (Tage / Stunden) zurückrechnen
	public function loeschen($idstart,$idende){

		$bool = urlaubrechner($idstart,$idende,0);
		if($bool == 0)
			return "irgendwas lief schief";


	// Urlaubseintrag ungültig machen... gegen das komplette Löschen entschieden um Fehler rückgängig machen zu können (Layer 8)
	Yii::$app->db->createCommand("UPDATE m3_urlaubsplanung
						  SET
							  CHNAME = '". Yii::$app->user->identity->firstname . " ". Yii::$app->user->identity->surename ."',
							  CHDATE = GETDATE(),
							  BEST = -1,
							  BESCHREIBUNG = 'gelöschter Urlaub',
							  PERSNO = '0'
						  WHERE m3_urlaubsplanung.LBNO = ".$idstart." OR m3_urlaubsplanung.LBNO = ".$idende."
						")
	->execute();



		// Yii::$app->db->CreateCommand (" DELETE FROM m3_urlaubsplanung WHERE LBNO = ".$idstart." OR LBNO = ".$idende." ")
		// ->execute();

	}


	public function getpnr() {
		$pnr = Yii::$app->db->createCommand("SELECT PE_WORK.PERSNO FROM [user]
											 INNER JOIN [PE_WORK] ON (PE_WORK.NO = [user].[pe_work_id])
											 WHERE pe_work_id = ".Yii::$app->user->identity->pe_work_id."")
											 ->queryONE();
		$zahl = array_keys($pnr);
		$pnr = $pnr[$zahl[0]];
		return $pnr;
	}

	public function getworkid($pnr) {
		$workid = Yii::$app->db->createCommand("SELECT NO FROM PE_WORK WHERE PERSNO = ".$pnr."")
											 ->queryONE();
		$zahl = array_keys($workid);
		$workid = $workid[$zahl[0]];
		return $workid;
	}



	public function eintragen($pnr,$start,$ende,$name,$tage,$stunden)
	{
		// Es wird jeweils ein Eintrag (Start / Ende) in LB_DC angelegt und einer in m3_urlaubsplanung
		// Der Eintrag in LB_DC hat die Werte PERSNAME=x und dient als Reservierung. Sobald der Urlaubsantrag bestätigt wurde
		// wird der Eintrag mit den jeweiligen Daten aus m3_urlaubsplanung ergänzt (Abgleich über LBNO) (Funktion "bestaetigen")

		// Abfrage der LNBO Nummer des letzten Eintrags aus LB_DC:
		// $lbnoneu = Yii::$app->db->createCommand("SELECT MAX(LBNO) FROM m3_urlaubsplanung")
		// ->queryONE();

		if($tage==NULL){
		    $tage = 0;
		}
		if($stunden==NULL) {
			$stunden = 0;
		}

		// $zahl = array_keys($lbnoneu);
	    // $lbnostart = $lbnoneu[$zahl[0]] +1; 	// LNBO Nr für Urlaub Start
		// $lbnoende = $lbnostart +1;				// LNBO Nr für Urlaub Ende

		//$start = date($start);
		$msstart =  Yii::$app->formatter->asDatetime($start, "php:Y-m-d H:i:01");
		//$start = $start->format('Y-m-d');
		$msende = Yii::$app->formatter->asDatetime($ende, "php:Y-m-d 23:59:02");
		$cdate = date("Y-m-d H:i:s");
		$name = Yii::$app->user->identity->firstname . " " . Yii::$app->user->identity->surename;
		$pnr = $this->getpnr();
		$workid = Yii::$app->user->identity->pe_work_id;
		$gesamt_tage = tagerechner($start,$ende);


		// Einträge in m3_urlaubsplanung
		Yii::$app->db->createCommand("SET DATEFORMAT ymd  INSERT INTO m3_urlaubsplanung (
	  [MSTIME]
	  ,[BESCHREIBUNG]
      ,[GESAMT_TAGE]
      ,[TAGE]
      ,[STUNDEN]
      ,[PERSNAME]
      ,[PERSNO]
	  ,[WORKID]
      ,[STATUS]
      ,[CDATE]
	  ,[BEST])

	VALUES (
      '".$msstart."'
      ,'Urlaub Start'
      ,".$gesamt_tage."
	  ,".$tage."
	  ,".$stunden."
	  ,'".$name."'
      ,'".$pnr."'
	  ,".$workid."
      ,800
      ,'".$cdate."'
	  ,0
	)")
        ->execute();



			Yii::$app->db->createCommand("SET DATEFORMAT ymd  INSERT INTO m3_urlaubsplanung (
	  [MSTIME]
	  ,[BESCHREIBUNG]
      ,[GESAMT_TAGE]
      ,[TAGE]
      ,[STUNDEN]
      ,[PERSNAME]
      ,[PERSNO]
	  ,[WORKID]
      ,[STATUS]
      ,[CDATE]
	  ,[BEST])

	VALUES (
      '".$msende."'
      ,'Urlaub Ende'
      ,".$gesamt_tage."
	  ,".$tage."
	  ,".$stunden."
	  ,'".$name."'
      ,'".$pnr."'
	  ,".$workid."
      ,801
      ,'".$cdate."'
	  ,0
	)")
        ->execute();




	// EMAIL
	$email = $this->email($workid);
	//$email = "f.bogenreuther@m3profile.com";
	Yii::$app->mailer->compose()
		->setFrom($email)
    	->setTo($email)
		->setSubject('Urlaubsantrag')
		->setTextBody('')
		->setHtmlBody('<b>Neuer Urlaubsantrag</b> <br> Eingereicht von: '.$name.' <br>
		               Personalnummer: '.$pnr.' <br> <br> Beantragter Zeitraum: <br> Start: '. $start .' <br>
					   Ende: '. $ende . '<br><br> Aufzuwendende Urlaubstage: '.$tage.' <br>
					   Aufzuwendende Stunden (In Tagen): '.$stunden.'<br> <br>
					   <a href="http://m3mssql/m3adminV3/web/index.php?r=urlaub%2Fmanager">Link zum Urlaubsmanager</a>')
	->send();

	}



	public function schichtplaner($check,$KW,$jahr,$mo_frueh,$mo_spaet,$mo_nacht,$di_frueh,$di_spaet,$di_nacht,
											$mi_frueh,$mi_spaet,$mi_nacht,$do_frueh,$do_spaet,$do_nacht,$fr_frueh,$fr_spaet,$fr_nacht,
											$sa_frueh,$sa_spaet,$sa_nacht,$so_frueh,$so_spaet,$so_nacht)
	{
		if($check == 0){

		// Eintrag in m3_schichtplanung
		// Es wird überprüft ob bereits ein Eintrag für die übergebene KW vorhanden ist. Wenn ja wird ein Update-Befehl ausgeführt
		// wenn nein ein Insert-Befehl

		// TODO Jahr abgleichen
		Yii::$app->db->createCommand("
		MERGE INTO m3_schichtplanung
		USING (VALUES (".$KW.",".$jahr.")) as s(COL1,COL2)
		ON m3_schichtplanung.KW = s.COL1 AND m3_schichtplanung.JAHR = s.COL2

WHEN MATCHED THEN
	UPDATE SET
  m3_schichtplanung.MO_FRUEH = '".$mo_frueh."',
  m3_schichtplanung.MO_SPAET = '".$mo_spaet."',
  m3_schichtplanung.MO_NACHT = '".$mo_nacht."',
  m3_schichtplanung.DI_FRUEH = '".$di_frueh."',
  m3_schichtplanung.DI_SPAET = '".$di_spaet."',
  m3_schichtplanung.DI_NACHT = '".$di_nacht."',
  m3_schichtplanung.MI_FRUEH = '".$mi_frueh."',
  m3_schichtplanung.MI_SPAET = '".$mi_spaet."',
  m3_schichtplanung.MI_NACHT = '".$mi_nacht."',
  m3_schichtplanung.DO_FRUEH = '".$do_frueh."',
  m3_schichtplanung.DO_SPAET = '".$do_spaet."',
  m3_schichtplanung.DO_NACHT = '".$do_nacht."',
  m3_schichtplanung.FR_FRUEH = '".$fr_frueh."',
  m3_schichtplanung.FR_SPAET = '".$fr_spaet."',
  m3_schichtplanung.FR_NACHT = '".$fr_nacht."',
  m3_schichtplanung.SA_FRUEH = '".$sa_frueh."',
  m3_schichtplanung.SA_SPAET = '".$sa_spaet."',
  m3_schichtplanung.SA_NACHT = '".$sa_nacht."',
  m3_schichtplanung.SO_FRUEH = '".$so_frueh."',
  m3_schichtplanung.SO_SPAET = '".$so_spaet."',
  m3_schichtplanung.SO_NACHT = '".$so_nacht."'

WHEN NOT MATCHED THEN
  INSERT  (
	   [KW]
	  ,[JAHR]
      ,[MO_FRUEH]
      ,[MO_SPAET]
      ,[MO_NACHT]
      ,[DI_FRUEH]
      ,[DI_SPAET]
      ,[DI_NACHT]
      ,[MI_FRUEH]
      ,[MI_SPAET]
      ,[MI_NACHT]
      ,[DO_FRUEH]
      ,[DO_SPAET]
      ,[DO_NACHT]
      ,[FR_FRUEH]
      ,[FR_SPAET]
      ,[FR_NACHT]
      ,[SA_FRUEH]
      ,[SA_SPAET]
      ,[SA_NACHT]
      ,[SO_FRUEH]
      ,[SO_SPAET]
      ,[SO_NACHT]
     )
		VALUES (
		'".$KW."'
	  ,'".$jahr."'
      ,'".$mo_frueh."'
      ,'".$mo_spaet."'
      ,'".$mo_nacht."'
      ,'".$di_frueh."'
      ,'".$di_spaet."'
      ,'".$di_nacht."'
      ,'".$mi_frueh."'
      ,'".$mi_spaet."'
      ,'".$mi_nacht."'
      ,'".$do_frueh."'
      ,'".$do_spaet."'
      ,'".$do_nacht."'
      ,'".$fr_frueh."'
      ,'".$fr_spaet."'
      ,'".$fr_nacht."'
      ,'".$sa_frueh."'
      ,'".$sa_spaet."'
      ,'".$sa_nacht."'
      ,'".$so_frueh."'
      ,'".$so_spaet."'
      ,'".$so_nacht."'
				);")
        ->execute();
		return true;
		}
		else {
		$tables = Yii::$app->db->createCommand("SELECT * FROM m3_schichtplanung
												WHERE KW = ".$KW." AND JAHR = ".$jahr.""
												)
		->queryAll();

		return $tables;

		}
	}


	// Schichtplanung => Kalender
	public function schichtzukalender($start,$ende){
	// Umrechnen des Start und Ende Termins auf eine passende KW:
	$kwstart = date("W",strtotime($start));
	$kwende = date("W",strtotime($ende));
	$jahrstart = date("Y",strtotime($start));
	$jahrende = date("Y",strtotime($ende));
	if($kwende<$kwstart){
		$tables = Yii::$app->db->createCommand("SELECT * FROM m3_schichtplanung
											WHERE KW BETWEEN ".$kwstart." AND 56
											OR KW BETWEEN 0 AND ".$kwende."")
		->queryAll();
	return $tables;
	}

	//Abfrage nach beiden KWs bzw dem Zeitraum dazwischen
	$tables = Yii::$app->db->createCommand("SELECT * FROM m3_schichtplanung
											WHERE KW BETWEEN ".$kwstart." AND ".$kwende."")
    ->queryAll();


	//Ändern des Datensatzes auf das passende Kalenderformat  (Start,Ende / Uhrzeit, Titel)





	return $tables;


	}


	public function tabelle($pnr){
		$jahr = date("Y");
		$tables = Yii::$app->db->CreateCommand("
			SELECT *
			FROM m3_urlaub_stunden
			INNER JOIN PE_WORK
			ON m3_urlaub_stunden.WORKID = PE_WORK.NO
			WHERE PE_WORK.PERSNO = ".$pnr." AND JAHR = ".$jahr."
		")
		->queryAll();

	return $tables;
	}


	######
 	public function abrechnung($monat,$jahr){
        ## Manuell das Zeitlimit für die Funktion setzen (Standard 30 war teils zu wenig)
        set_time_limit(60);

		// in m3_urlaub_stunden finden sich Einträge mit der WORKID 1. Diese sind als Merker gedacht um ein doppeltes Abrechnen eines Monats zu verhindern.
		// Bereits abgerechnete Monate sind mit einer 1 markiert, nicht abgerechnete mit einer 0.

		if(!$monat)
			return -5;
		if(!$jahr)
			return -6;

		$tables = monatsdatenfkt($monat,$jahr);

		$check_monat = "U".$monat;

		$check = Yii::$app->db->createCommand("
			SELECT ".$check_monat." from m3_urlaub_stunden
			WHERE WORKID = 1 AND JAHR = ".$jahr."")
		->queryOne();

		if($check){
		$pruef = array_keys($check);
		$check = $check[$pruef[0]];
		}
		else{
			return -3;
		}


		if($monat==date("n") && $jahr==date("Y")){
			// Wenn zu früh gestartet (im gleichen Monat)

			return -1;
		}
		// Überprüfen ob betreffender Monat bereits abgerechnet wurde.
		else if($check == 1)
		{
			return 0;
		}
		else if(($monat>date("n") && $jahr>date("Y")) || $jahr>date("Y")){
			// Abrechnungsmonat würde in der Zukunft liegen
			return -2;
		}

		else {
	//	foreach($tables as $type){
			foreach($tables as $eintrag){
				abrechnungfkt($eintrag['workid'],$monat,$jahr,$eintrag['saldo_stunden']);
			}

		//}
		// Setzen des Markers für den abgerechneten Monat
		Yii::$app->db->CreateCommand("
			UPDATE m3_urlaub_stunden
			SET ".$check_monat." = 1
			WHERE WORKID = 1 AND JAHR = ".$jahr."
			")
		->execute();


		return 1;
		}
	}
	######




	public function abrechnung_such($pnr,$monat,$jahr){

	$letzter_tag= date('t',strtotime($jahr.$monat."01"));

	$tables = Yii::$app->db->createCommand ("

	SELECT * FROM LB_DC
	WHERE PERSNO = ".$pnr."
	AND MSTIME BETWEEN Convert(datetime2,'01.".$monat.".".$jahr."') AND Convert(datetime2,'".$letzter_tag.".".$monat.".".$jahr."')
	AND (STATUS = 200 OR STATUS = 100)
	ORDER BY LBNO
	")
	->queryAll();






	return $tables;
	}









	public function mitarbeiter($abt,$start,$ende){
	if($abt == 'SM') {
		// 03.05  von user Datenbank auf PE_WORK Datenbank geändert zwecks Zeitarbeiter
		if($start == 0 && $ende == 0){
			$tables = Yii::$app->db->createCommand("SELECT LOWER(LEFT(PE_WORK.FIRSTNAME, 1)+PE_WORK.SURNAME) as username ,
													PE_WORK.FIRSTNAME as firstname,PE_WORK.SURNAME as surename, FAG_DETAIL.TXT01 as TXT01, PE_WORK.PERSNO as PERSNO
													FROM PE_WORK
													INNER JOIN FAG_DETAIL
													ON PE_WORK.NO = FAG_DETAIL.FKNO
													WHERE (FAG_DETAIL.TXT01 LIKE 'SM' OR FAG_DETAIL.TXT01 LIKE 'SF' OR PE_WORK.PERSNO = 973)
													AND PE_WORK.STATUS1 != 100
													ORDER BY PE_WORK.NO

			")
			->queryAll();


			/*Alt [user]:

			SELECT username,firstname,surename, FAG_DETAIL.TXT01 as TXT01 FROM [user]
													INNER JOIN FAG_DETAIL
													ON [user].pe_work_id = FAG_DETAIL.FKNO
													WHERE FAG_DETAIL.TXT01 LIKE 'SM' OR FAG_DETAIL.TXT01 LIKE 'SF' */
		return $tables;
		}


	// Zum Start bzw Endtermin werden jeweils 4 Wochen subtrahiert / addiert um einen größeren Zeitrahmen abzudecken in denen Start- und Endtermine fallen können.
	$startneu = date ("Y-d-m",strtotime($start."-5 week"));
	$endeneu = date ("Y-d-m",strtotime($ende."+5 week"));
	// "SF" wird ebenfalls abgefragt
	### In der Query sind zwei Ausdrücke markiert, die beim Umzug auf vom Test- auf das richtige System (Cut der Urlaubsanträge und diesbezügl. richtige
	### Formatierung vorausgesetzt) wegfallen können. (Potenzielle Fehlerquelle)
	$tables = Yii::$app->db->createCommand("WITH CTE AS
  (SELECT DISTINCT PE_WORK.NO as FKNO,A.LBNO, A.STATUS, A.PERSNO, A.MSTIME, A.MSTIME AS Datum,
                   DATEDIFF(dd,A.MSTIME,B.MSTIME) AS diff
   FROM m3_urlaubsplanung A
   INNER JOIN m3_urlaubsplanung B
   ON A.LBNO = B.LBNO -1
   INNER JOIN PE_WORK
   ON A.PERSNO = PE_WORK.PERSNO
   WHERE  (((A.STATUS = 800 AND (A.MSTIME BETWEEN '".$startneu."' AND '".$endeneu."') AND B.STATUS = 801)-- Achtung: letzter Ausdruck nur während Testphase!
   AND	  (B.STATUS = 801 AND (B.MSTIME BETWEEN '".$startneu."' AND '".$endeneu."') AND A.STATUS = 800))-- Achtung: letzter Ausdruck nur während Testphase!
   OR 	  ((A.STATUS = 802 AND (A.MSTIME BETWEEN '".$startneu."' AND '".$endeneu."') AND B.STATUS = 803)-- Achtung: letzter Ausdruck nur während Testphase!
   AND	  (B.STATUS = 803 AND (B.MSTIME BETWEEN '".$startneu."' AND '".$endeneu."') AND A.STATUS = 802))-- Achtung: letzter Ausdruck nur während Testphase!
   OR 	  ((A.STATUS = 804 AND (A.MSTIME BETWEEN '".$startneu."' AND '".$endeneu."') AND B.STATUS = 805)-- Achtung: letzter Ausdruck nur während Testphase!
   AND	  (B.STATUS = 805 AND (B.MSTIME BETWEEN '".$startneu."' AND '".$endeneu."') AND A.STATUS = 804))-- Achtung: letzter Ausdruck nur während Testphase!
   OR     ((A.STATUS = 806 AND (A.MSTIME BETWEEN '".$startneu."' AND '".$endeneu."') AND B.STATUS = 807)-- Achtung: letzter Ausdruck nur während Testphase!
   AND	  (B.STATUS = 807 AND (B.MSTIME BETWEEN '".$startneu."' AND '".$endeneu."') AND A.STATUS = 806)))-- Achtung: letzter Ausdruck nur während Testphase!
   AND 	   (A.BEST = 1 AND B.BEST = 1)




   UNION ALL SELECT FKNO, A.LBNO as LBNO, A.STATUS as STATUS, A.PERSNO as PERSNO, A.MSTIME as MSTIME, Datum,
                    diff - 1 AS diff
   FROM CTE
   INNER JOIN m3_urlaubsplanung A
   ON A.LBNO = CTE.LBNO
   WHERE diff> 0)

SELECT username,firstname,surename,PNR,Datum,STATUS FROM (
SELECT DISTINCT [user].username as username,[user].firstname as firstname,[user].surename as surename, CTE.FKNO, LBNO, CTE.STATUS, PE_WORK.PERSNO as PNR, MSTIME, DateAdd(dd,diff, Datum) AS Datum
FROM CTE
RIGHT JOIN [user]
ON FKNO = [user].pe_work_id
LEFT JOIN FAG_DETAIL
ON [user].pe_work_id = FAG_DETAIL.FKNO
INNER JOIN PE_WORK
ON [user].pe_work_id = PE_WORK.NO
WHERE FAG_DETAIL.TXT01 LIKE 'SM' OR FAG_DETAIL.TXT01 LIKE 'SF')TE
WHERE DATUM  BETWEEN '".$start."' AND dateadd(day, 1, '".$ende."')
GROUP BY username,firstname,surename,PNR,Datum,STATUS

")
		->queryAll();





	// Zuordnung der Urlaubstage (einzeln zu den Mitarbeitern)
	// Es wird ein zweidimensionales Array gebildet. Bei Auslesung kommen die Daten für die einzelnen Urlaubstage in den data-Bereich des
	// div jeweiligen div Bausteins, wo sie von einem Javascript (schicht.js) ausgelesen und verarbeitet werden.

	$tag_arr = array();
	$return_arr = array();
	$pnr = " ";
	$i = 0;
	$n = 0;
	$z = 0;
	foreach($tables as $type) {$i++;}
	foreach($tables as $type) {

	if($pnr == $type['PNR'] || $n == 0)
	{

		$tag_arr['name'] = $type['firstname'] . " " . $type['surename'];
		$tag_arr['id'] = $type['username'];
		if($type['Datum'])
			$tag_arr[$n] =  date("d.m.Y",strtotime($type['Datum']));
		$pnr = $type['PNR'];
		$n++;


	}
	else{
		array_push($return_arr,$tag_arr);

        ### Zwei Codezeilen hinzugefügt am 01.08.2018: Array neu anlegen da sonst höhere Einträge einfach mitkopiert werden.(fiel bis heute angeblich niemandem auf... ... ...anscheinend)
        unset($tag_arr);
        $tag_arr = array();
		$n = 0;
		$tag_arr['name'] = $type['firstname'] . " " . $type['surename'];
		$tag_arr['id'] = $type['username'];
		$pnr = $type['PNR'];
		if($type['Datum'])
			$tag_arr[$n] = date("d.m.Y",strtotime($type['Datum']));
		$n++;
	}
	$z++;
	if($z == $i){array_push($return_arr,$tag_arr);}


	}
	return $return_arr;


	}
	else {
	// Achtung, SQL Injections möglich!
	$tables = Yii::$app->db->createCommand("SELECT * FROM [user]
											RIGHT JOIN FAG_DETAIL ON [user].pe_work_id = FAG_DETAIL.FKNO
											WHERE FAG_DETAIL.TXT02 LIKE '".$abt."'")
    ->queryAll();
	}

	return $tables;


	}


	// Funktion um Benachrichtigungsemail herauszufinden. Falls noch keine angelegt => m.rotter@m3profile.com
	public function email($workid) {

	$email = Yii::$app->db->createCommand ("SELECT TXT03 FROM FAG_DETAIL WHERE FKNO = ".$workid." AND TYP = 26")
				 ->queryONE();

	$zahl = array_keys($email);
	$email = $email[$zahl[0]];
	if($email == "") {
		$email = "m.rotter@m3profile.com";
	}
	return $email;
	}





	public function verbl_tage_stunden($WORKID) {


	if($WORKID == 0){
        $WORKID = Yii::$app->user->identity->pe_work_id;
        }
	$jahr = date('Y');
	$monat = date('n')-1;
	if($monat == 0){
        $monat = 12;
        $jahr = $jahr -1;
        }

    $check_monat = "U".$monat;
    // Überprüfen ob letzter Monat bereits abgerechnet
    $check = Yii::$app->db->createCommand("
    SELECT ".$check_monat." from m3_urlaub_stunden
    WHERE WORKID = 1 AND JAHR = ".$jahr."")
    ->queryOne();

    $pruef = array_keys($check);
    $check = $check[$pruef[0]];
    if($check==0){
        $monat = date('n')-2;
        if($monat == 0){
            $monat = 12;
            $jahr = $jahr -1;
            }
        else if($monat = -1){
            $monat = 11;
        }
    }




	$abfrage_stringU = "";
	$abfrage_stringS = "";
	// Abfrage-String für Urlaub bilden:
	for($i=$monat;$i<=12;$i++){
		if($i==12){
			$abfrage_stringU = $abfrage_stringU."U".$i;
		}
		else{
			$abfrage_stringU = $abfrage_stringU."U".$i."+";
		}
	}

	// Abfrage-String für Stunden bilden
	for($i=$monat;$i<=12;$i++){
		if($i==12){
			$abfrage_stringS = $abfrage_stringS."S".$i;
		}
		else{
			$abfrage_stringS = $abfrage_stringS."S".$i."+";
		}
	}



	$tables = Yii::$app->db->createCommand("
					SELECT
						(".$abfrage_stringU.") as _tage,
						(".$abfrage_stringS.") as _stunden,
						JAHR
					FROM m3_urlaub_stunden
					WHERE WORKID = ".$WORKID."
					AND m3_urlaub_stunden.JAHR = ".$jahr."
					ORDER BY JAHR
					")
    ->queryALL();



	$rueck = array();

	foreach($tables as $type){
		$rueck['stunden'] = $type['_stunden'];
		$rueck['tage'] = $type['_tage'];
	}

	$antraege = Yii::$app->db->createCommand("
					SELECT * FROM m3_urlaubsplanung
						WHERE WORKID = ".$WORKID."
						AND STATUS = 800
						AND DATEPART(yyyy,MSTIME) = DATEPART(yyyy,GETDATE())
						AND BEST = 0
						")
	->queryAll();

  $wochenstunden = Personal::find()
                            ->select(['FAG_DETAIL.VAL02','PE_WORK.NO'])
                            ->from('PE_WORK')
                            ->leftJoin('FAG_DETAIL', 'PE_WORK.NO = FAG_DETAIL.FKNO')
                            ->where(['PE_WORK.NO'=>$WORKID])
                            ->andWhere(['FAG_DETAIL.TYP' => 26])
                            ->one();

	foreach($antraege as $antrag) {
		$rueck['stunden'] -= $antrag['STUNDEN']* ($wochenstunden->VAL02 / 5);
		$rueck['tage'] -= $antrag['TAGE'];
	}



    if($monat == 12){
        $tables2 = Yii::$app->db->createCommand("
                        SELECT
                            (U1+U2+U3+U4+U5+U6+U7+U8+U9+U10+U11+U12) as _tage,
                            (S1+S2+S3+S4+S5+S6+S7+S8+S9+S10+S11+S12) as _stunden,
                            JAHR
                        FROM m3_urlaub_stunden
                        WHERE WORKID = ".$WORKID."
                        AND m3_urlaub_stunden.JAHR = ".($jahr+1)."
                        ORDER BY JAHR
                        ")
        ->queryALL();

        foreach($tables2 as $type2){
            $rueck['stunden'] += $type2['_stunden'];
            $rueck['tage'] += $type2['_tage'];
        }
    }



	return $rueck;
	}


	public function verwaltung($pnr,$start,$ende,$status){
		if($status == 0){
			$status_a = 802;
			$status_e = 803;
			$text_a = "Krank Start";
			$text_e = "Krank Ende";
		}
		if($status == 1){
			$status_a = 804;
			$status_e = 805;
			$text_a = "Elternzeit Start";
			$text_e = "Elternzeit Ende";
		}
		if($status == 2){
			$status_a = 806;
			$status_e = 807;
			$text_a = "unbezahlter Urlaub Start";
			$text_e = "unbezahlter Urlaub Ende";
		}
		if($status == 3){
            $status_a = 808;
            $status_e = 809;
            $text_a = "Berufsschule Start";
            $text_e = "Berufsschule Ende";
        }
		// $lbnoneu = Yii::$app->db->createCommand("SELECT MAX(LBNO) FROM m3_urlaubsplanung")
		// ->queryONE();
		$persname = Yii::$app->db->createCommand("SELECT FIRSTNAME + ' ' + SURNAME AS name, NO as workid FROM PE_WORK WHERE PERSNO = ".$pnr."")
		->queryONE();
		// $zahl = array_keys($lbnoneu);
	    // $lbnostart = $lbnoneu[$zahl[0]] +1; 	// LNBO Nr für Urlaub Start
		// $lbnoende = $lbnostart +1;				// LNBO Nr für Urlaub Ende
		$cdate = date("Y-m-d H:i:s");
		$cname = Yii::$app->user->identity->firstname . " " . Yii::$app->user->identity->surename;

		$msstart =  Yii::$app->formatter->asDatetime($start, "php:Y-m-d H:i:01");
		$msende = Yii::$app->formatter->asDatetime($ende, "php:Y-m-d 23:59:02");

	Yii::$app->db->createCommand("SET DATEFORMAT ymd  INSERT INTO m3_urlaubsplanung (
	  [MSTIME]
	  ,[BESCHREIBUNG]
      ,[PERSNAME]
      ,[PERSNO]
	  ,[WORKID]
      ,[STATUS]
      ,[CDATE]
	  ,[CNAME]
	  ,[BEST])

	VALUES (
      '".$msstart."'
      ,'".$text_a."'
	  ,'".$persname['name']."'
      ,'".$pnr."'
	  ,".$persname['workid']."
      ,".$status_a."
      ,'".$cdate."'
	  ,'".$cname."'
	  ,1
	)")
        ->execute();

	Yii::$app->db->createCommand("SET DATEFORMAT ymd  INSERT INTO m3_urlaubsplanung (
	  [MSTIME]
	  ,[BESCHREIBUNG]
      ,[PERSNAME]
      ,[PERSNO]
	  ,[WORKID]
      ,[STATUS]
      ,[CDATE]
	  ,[CNAME]
	  ,[BEST])

	VALUES (
      '".$msende."'
      ,'".$text_e."'
	  ,'".$persname['name']."'
      ,'".$pnr."'
	  ,".$persname['workid']."
      ,".$status_e."
      ,'".$cdate."'
	  ,'".$cname."'
	  ,1
	)")
        ->execute();



	return 1;

	}


		#####Abrechnung (ausgelagert)
	public function zeiten_tabelle($monat,$jahr){
     ## Manuell das Zeitlimit für die Funktion setzen (Standard 30 war teils zu wenig)
    set_time_limit(150);
	$monat = $monat;
	$jahr = $jahr;

	$tables = Yii::$app->db->createCommand("
	SELECT PERSNO, FIRSTNAME, SURNAME,FAG_DETAIL.TXT01 as TXT01, FAG_DETAIL.VAL02 as VAL02, PE_WORK.NO as WORKID
		FROM PE_WORK
		INNER JOIN FAG_DETAIL
		ON PE_WORK.NO = FAG_DETAIL.FKNO
		WHERE FAG_DETAIL.TYP = 26 AND PE_WORK.STATUS1 = 0
		ORDER BY PERSNO

	")
	->queryAll();


	$erster_tag = "01.".$monat.".".$jahr;   //Datum erster Tag im Monat
	$monat2 = $monat + 1;
	$abr_jahr = $jahr;
	if($monat2 == 13){
		$monat2 = 01;
		$abr_jahr = $jahr + 1;
	}
	$abr_tag = "01.".$monat2 .".".$abr_jahr;

	$rueck = array();
	foreach($tables as $type){
		array_push($rueck,zeitabfrage($type['PERSNO'],$type['TXT01'],$erster_tag,$abr_tag,1));
	}

	$content ="";
	foreach($rueck as $type){
	$i = 0;
	$n = 0;
	foreach($type as $eintrag){$n++;}
    if($n > 0){
    $content = $content . "<table>";
	foreach($type as $eintrag){

		if(!$i){
			$content = $content . "<tr><td>".$eintrag['persname'] ."</td>:<td> ".$eintrag['pnr'] ."</td></tr>".
				 "<tr><td>Datum</td><td>Startzeit</td><td>Schlusszeit</td><td>verrechn. Stunden</td> <td>Nachtzuschlag</td><td>Feiertagszuschlag:</td></tr>";
		};
			$content = $content . "<tr>".
			"<td>".$eintrag['start_tag'].":</td><td> ". date("H:i:s",strtotime($eintrag['startzeit']))."</td><td>".date("H:i:s",strtotime($eintrag['endezeit']))."</td><td>".$eintrag['teilzeit']."</td><td>".$eintrag['teil_nachtzeit']."</td><td>".
			 $eintrag['teil_feierzeit']."</td></tr>".
			"<tr> <td></td> </tr>";
		$i++;
		if($i == $n){
		$content = $content . "<tr><td></td><td></td><td></td><td>".$eintrag['gesamtzeit']."</td><td>".$eintrag['nachtzeit']."</td><td>".$eintrag['feierzeit']."</td>";


        }
	}
    $content = $content . "</table><pagebreak />";
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
		'filename' => '../PDFs/Zeiten-Tabellen/zeiten_'.date("M",strtotime('01.'.$monat.'.'.$jahr)).'-'.$jahr.'.pdf',
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




	return $rueck;

	}


	#####Abrechnung (ausgelagert)
	public function zeiten($monat,$jahr){
	$monat = $monat;
	$jahr = $jahr;
	$rueck = monatsdatenfkt($monat,$jahr);


	//$rueck = zeitabfrage(743,"SF","2017-01-04","2017-01-05");
	return $rueck;

	}

	public function tage_check($pnra,$datum_1,$datum_2){
	$rueck = Yii::$app->db->createCommand("
		SELECT B.PERSNAME as PERSNAME, A.MSTIME as MSSTART, B.MSTIME as MSENDE, A.STATUS as STATUS
		FROM m3_urlaubsplanung A
		INNER JOIN m3_urlaubsplanung B
		ON A.LBNO = B.LBNO -1
		WHERE (((A.STATUS = 802 AND A.MSTIME BETWEEN '".$datum_1."' AND '".$datum_2."' AND B.STATUS = 803)
		OR    (B.STATUS = 803 AND B.MSTIME BETWEEN '".$datum_1."' AND '".$datum_2."' AND A.STATUS = 802))
		OR 	  ((A.STATUS = 804 AND A.MSTIME BETWEEN '".$datum_1."' AND '".$datum_2."' AND B.STATUS = 805)
		OR    (B.STATUS = 805 AND B.MSTIME BETWEEN '".$datum_1."' AND '".$datum_2."' AND A.STATUS = 804))
		OR 	  ((A.STATUS = 806 AND A.MSTIME BETWEEN '".$datum_1."' AND '".$datum_2."' AND B.STATUS = 807)
		OR    (B.STATUS = 807 AND B.MSTIME BETWEEN '".$datum_1."' AND '".$datum_2."' AND A.STATUS = 806))
        OR 	  ((A.STATUS = 808 AND A.MSTIME BETWEEN '".$datum_1."' AND '".$datum_2."' AND B.STATUS = 809)
		OR    (B.STATUS = 809 AND B.MSTIME BETWEEN '".$datum_1."' AND '".$datum_2."' AND A.STATUS = 808)))
		AND A.PERSNO = ".$pnra."
		ORDER BY A.MSTIME
	")
	->queryAll();
	return $rueck;
	}
    /**
     * @inheritdoc
     */
    public function rules()
    {

        return [

			[['start', 'ende'],'required'],
	        [['stunden','tage','pnr','name','benTage','status'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'LBNO' => 'Lbno',
            'NAME' => 'Name',
            'OPNO' => 'Opno',
            'OPOPNO' => 'Opopno',
            'ORNAME' => 'Orname',
            'ORNO' => 'Orno',
            'OUT' => 'Out',
            'ADCCOUNT' => 'Adccount',
            'ADCMESS' => 'Adcmess',
            'ADCSTAT' => 'Adcstat',
            'ADCWORK' => 'Adcwork',
            'APARTS' => 'Aparts',
            'ARCHIVE' => 'Archive',
            'ATE' => 'Ate',
            'ATP' => 'Atp',
            'ATR' => 'Atr',
            'BPARTS' => 'Bparts',
            'BPARTS2' => 'Bparts2',
            'CALTYP' => 'Caltyp',
            'DESCR' => 'Descr',
            'ERRNUM' => 'Errnum',
            'EXSTAT' => 'Exstat',
            'FKLBNO' => 'Fklbno',
            'FNPK' => 'Fnpk',
            'GPARTS' => 'Gparts',
            'INPARTSDBL' => 'Inpartsdbl',
            'ISINTERNAL' => 'Isinternal',
            'MSGID' => 'Msgid',
            'MSINFO' => 'Msinfo',
            'MSTIME' => 'Mstime',
            'MTIME0' => 'Mtime0',
            'MTIME1' => 'Mtime1',
            'MTIME2' => 'Mtime2',
            'MTIME3' => 'Mtime3',
            'OPMULTIMESSAGEGROUP' => 'Opmultimessagegroup',
            'PERSNAME' => 'Persname',
            'PERSNO' => 'Persno',
            'STATUS' => 'Status',
            'TERMINAL' => 'Terminal',
            'WPLACE' => 'Wplace',
            'MATCOST' => 'Matcost',
            'CNAME' => 'Cname',
            'CHNAME' => 'Chname',
            'CDATE' => 'Cdate',
            'CHDATE' => 'Chdate',
            'MANDANTNO' => 'Mandantno',
            'TSTAMP' => 'Tstamp',
        ];
    }
}
