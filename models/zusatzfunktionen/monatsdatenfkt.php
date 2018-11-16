<?php
require 'zeiten.php';
require 'tage.php';
require 'tage_betriebsurlaub.php';

//require '../abrechnungsfkt.php'

function resttage($WORKID,$art,$monat) {
    
    $jahr = date('Y');
    $monat = $monat; 
    if($monat == 0){ $monat = 1;}
    
    
    // Art 0 = Aktueller Stand für abzurechnenden Monat  (Es werden nicht zukünftige Urlaubstage / Stunden mit abgezogen
    if($art == 0){
        $check_monat = "U".$monat;    
        // Überprüfen ob letzter Monat bereits abgerechnet
        $check = Yii::$app->db->createCommand("
        SELECT ".$check_monat." from m3_urlaub_stunden
        WHERE WORKID = 1 AND JAHR = ".$jahr."")
        ->queryOne();
         
        $pruef = array_keys($check);
        
      
        $check = $check[$pruef[0]]; 
        if($check==0){
            $vormonat = $monat-1;
            $abfrage_stringU = "U".$vormonat."+U".$monat;
            $abfrage_stringS = "S".$vormonat ."+S".$monat;    
        }
        else {
             $abfrage_stringU = "U".$monat;
             $abfrage_stringS = "S".$monat;
        }
        
        

        
            
            $tables = Yii::$app->db->createCommand("
                            SELECT 
                                (".$abfrage_stringU.") as _tage,
                                (".$abfrage_stringS.") as _stunden,
                                JAHR				    
                            FROM m3_urlaub_stunden 
                            WHERE WORKID = ".$WORKID." 
                            AND m3_urlaub_stunden.JAHR = DATEPART(yyyy,GETDATE())
                            ORDER BY JAHR
                            ")
            ->queryALL();		
            
            $rueck = array();
            
            foreach($tables as $type){
                $rueck['stunden'] = $type['_stunden'];
                $rueck['tage'] = $type['_tage'];
            }
            return $rueck; 
            
    }
    
    // Art == 1   Alle Tage / Stunden die diesen Monat verbraucht werden
    else {
        $abfrage_monatU = "U".$monat;    
        $abfrage_monatS = "S".$monat; 
        $tables = Yii::$app->db->createCommand("
                        SELECT 
                            (".$abfrage_monatU.") as _tage,
                            (".$abfrage_monatS.") as _stunden,
                            JAHR				    
                        FROM m3_urlaub_stunden 
                        WHERE WORKID = ".$WORKID." 
                        AND m3_urlaub_stunden.JAHR = DATEPART(yyyy,GETDATE())
                        ORDER BY JAHR
                        ")
        ->queryALL();
  
        $rueck = array();
        
        foreach($tables as $type){
            $rueck['stunden'] = $type['_stunden'];
            $rueck['tage'] = $type['_tage'];
            // if($monat !== date("n")-1){
                // $rueck['stunden'] = 0;
                // $rueck['tage'] = 0;
            // }
        }
        return $rueck; 
    }		
        
}	




























function monatsdatenfkt($monat,$jahr) {
		
// Alle Mitarbeiter erfassen:
$tables = Yii::$app->db->createCommand("
	SELECT PERSNO, FIRSTNAME, SURNAME,FAG_DETAIL.TXT01 as TXT01, FAG_DETAIL.VAL02 as VAL02, PE_WORK.NO as WORKID 
		FROM PE_WORK
		INNER JOIN FAG_DETAIL 
		ON PE_WORK.NO = FAG_DETAIL.FKNO 
		WHERE FAG_DETAIL.TYP = 26 AND PE_WORK.STATUS1 = 0 AND (PE_WORK.SURNAME NOT LIKE 'Rotter' AND SURNAME+FIRSTNAME NOT LIKE 'HeimMichael') AND PERSNO NOT LIKE '[3]%'
		ORDER BY PERSNO

	")
	->queryAll();


#### Ausrechnen wieviele Arbeitstage in dem Monat anfallen: 
// Gesamte Arbeitstage im Monat: 
$erster_tag = "01.".$monat.".".$jahr;   //Datum erster Tag im Monat
$monat2 = $monat + 1;
$letzter_tag = date('t.m.Y',strtotime($erster_tag)); //Datum letzer Tag im Monat
$abr_jahr = $jahr;
if($monat2 == 13){
	$monat2 = 01;
	$abr_jahr = $jahr + 1;
}

$abr_tag = "01.".$monat2 .".".$abr_jahr;


$arbeitstage = tagerechner($erster_tag,$letzter_tag);	 // Anzahl an Arbeitstagen in diesem Monat
$feiertage = date('t',strtotime($erster_tag)) - $arbeitstage; // Anzahl an Feiertagen in diesem Monat +(Samstag /Sontag)

$varU = "U".($monat-1); //  -2 ergänzen
$varS = "S".($monat-1);

$monatsdaten_arr = array();
$zeitdaten = array();
#### Große Schleife um Gesamtarrayeintrag des Mitarbeiters zu erstellen: 	
foreach($tables as $type){
	
$zeitdaten = zeitabfrage($type['PERSNO'],$type['TXT01'],$erster_tag,$abr_tag,0); 

### Übertragen der Stunden / Urlaubstagewerte aus dem Vormonat in den neuen Monat:
// abrechnungsfkt($type['WORKID']);

### TODO: Stundensaldo und verbrauchte Urlaubstage (evtl direkt aus Datenbank oder ausgerechneter Wert) in m3_urlaub_stunden übertragen
### Problem: Überstundenabbau wird zukünftig als Urlaub erfasst => Stundensaldo und Urlaubsaldo aus m3_urlaub_stunden auslesen!
### Kein Problem mehr mit neuem System: Tage / Stunden in Urlaubsantrag direkt gespeichert
### Sollstunden-Satz mit Krankheitstagen / Urlaubstagen etc vergleichen.. (eine Variable in foreach-Schleife mitzählen und abziehen)

$vormonat = Yii::$app->db->createCommand("
	SELECT ".$varU.",".$varS." FROM m3_urlaub_stunden 
	WHERE JAHR = ".$jahr."
	AND WORKID = ".$type['WORKID']." 
	")
->queryAll();
$vormonat_stunden = 0;
$vormonat_urlaub = 0;
	foreach($vormonat as $data){
		$vormonat_urlaub = $data[$varU];
		$vormonat_stunden = $data[$varS];
	}



$utage = 0; // Urlaubstage
$etage = 0; // Elterntage 
$ktage = 0; // Krankheitstage
$ubtage = 0; //unbezahlter Urlaub - Tage
$tage_array = tage($type['PERSNO'],$erster_tag,$letzter_tag); 
$tag_merker = "0"; // Um doppelte Tage auszusortieren

### Überprüfung ob Tag am Wochenende, wenn nein zählt er
foreach($tage_array as $tage){
if(!istfrei(date("d.m.Y",strtotime($tage['Datum'])))){
	
if($tag_merker !== date("d.m.Y",strtotime($tage['Datum']))){  // Überprüfen ob der Tag bereits gezählt wurde
	switch($tage['STATUS']) {
      case 800:
		$utage++;
	  break;
	 	   
	  case 802:
		$ktage++;
	  break;
	   
	  case 804:
	    $etage++;
	  break;
	  
	  case 806:
		$ubtage++;
	  break;
	  
      default:
         //Anweisung;
      break;
   }
   $tag_merker = date("d.m.Y",strtotime($tage['Datum']));  // Tag-Merker setzen
}

}
	
	
}
$zeitdaten['workid'] = $type['WORKID'];
$zeitdaten['persname'] = $type['FIRSTNAME'] . " " . $type['SURNAME'];
$zeitdaten['pnr'] = $type['PERSNO'];
$zeitdaten['erstertag'] = $erster_tag;
$zeitdaten['letztertag'] = $letzter_tag;

$schichtzulage = 0;
if($type['TXT01'] == "SM" || $type['TXT01'] == "SF")
{
	$schichtzulage = $zeitdaten['gesamt'];
}	
$sollstunden = ($type['VAL02']/5) * ($arbeitstage - $ktage - $utage - $etage - $ubtage);
//abrechnungsfkt($workid);




// die Urlaubstage werden von der Funktion verbl_tage_stunden() geholt, da ein Urlaubstag auch mit Überstunden abgegolten werden kann
$verbl_arr = resttage($type['WORKID'],0,$monat);
$verbr_arr = resttage($type['WORKID'],1,$monat);
$saldo_urlaub = $verbl_arr['tage'];


$saldo_stunden = $zeitdaten['gesamt'] - $sollstunden;  
// "verbr_arr['stunden'] sind die Stunden die als Urlaubstage in diesem Monat verrechnet wurden.
$stunden_aktuell = $zeitdaten['gesamt'] - $sollstunden + $vormonat_stunden + $verbr_arr['stunden'];

### Alternativ: $verbr_arr['tage']  (wird aus urlaub_stunden gezogen - unpraktisch bei nicht aktueller Abrechnung - und bei doppelter Krankheits / Urlaubstagsbelegung)
$zeitdaten['utage'] = $utage;
$zeitdaten['stundenabbau'] = $verbr_arr['stunden'];


// Da die verbrauchten Werte nur in m3_urlaub_stunden gespeichert sind (wird bei Abrechnung überschrieben) sind diese nichtmehr rekonstruierbar. 
### Mögliche Lösung in Zukunft: Über Abrechnungsfunktion urlaubtage() die Anteile an Stunden / Tagen für monatsübergreifende Urlaube ausrechnen
// if($monat !== date("n")-1){
    // $zeitdaten['utage'] = $utage;
    // $zeitdaten['stundenabbau'] = 0;
    // $stunden_aktuell = $zeitdaten['gesamt'] - $sollstunden + $vormonat_stunden;
    // $saldo_urlaub = $vormonat_urlaub - $utage;

// }

$zeitdaten['schichtzulage'] = $schichtzulage;
$zeitdaten['arbeitstage'] = $arbeitstage; 
$zeitdaten['feiertage'] = $feiertage;
$zeitdaten['sollstunden'] = $sollstunden;
$zeitdaten['vormonat_urlaub'] = $vormonat_urlaub;
$zeitdaten['vormonat_stunden'] = $vormonat_stunden;
$zeitdaten['ktage'] = $ktage;
$zeitdaten['etage'] = $etage;
$zeitdaten['ubtage'] = $ubtage;
$zeitdaten['saldo_urlaub'] = $saldo_urlaub;
$zeitdaten['saldo_stunden'] = round($saldo_stunden,3);
$zeitdaten['stunden_aktuell'] = round($stunden_aktuell,3);


array_push($monatsdaten_arr,$zeitdaten);
} 
return $monatsdaten_arr;
}
?>