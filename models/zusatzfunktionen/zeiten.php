<?php 
require 'feiertag.php';

function zeitabfrage($pnr,$typ,$start,$ende,$art) {
	$tables = Yii::$app->db->CreateCommand(" 
		SELECT * FROM LB_DC 	
		WHERE 
		(STATUS = 100 OR STATUS = 200) 
		AND PERSNO = ".$pnr." 
		AND MSTIME BETWEEN '".$start."' AND '".$ende."' 
		ORDER BY MSTIME
		")
	->queryAll();
	
	
	$i = 0; 
	$n = 0;
	$t = 0;

	
	$sm = 0; // Schichtmitarbeiter
	$sf = 0; // Schichtführer
	$ks = 0;
	
	
	
	
	if($typ=="KS"){
		$ks = 1;
	}
	else {
		$ks = 0;
	}
	
	// Überprüfung ob Schichtführer 
	// Überprüfung wieviele Tage Schichtführer 
	// Multiplikation mit Nachzuschlag 

	// TODO SF UND SM zusammenfassen (SF bei startzeit unten mit feiertag abfragen (gleiche wirkung)) 
	// TODO KS Mitarbeiter die ab und zu in der Schicht mithelfen => Stempelverhalten? 
	// TODO Stunden ausbezahlen => Feld
	
	
	
	
########
		// Überprüfung ob erster Datensatz = erster Tag im Monat. 
		// Überprüfung ob erster Datensatz = 200 
		
	
	
	
	####  Nur 100 und 200 Einträge hier verwerten lassen! Nicht mit anderen Einträgen mischen! 
	$timestamp_frueh = (6*3600);
	$timestamp_nacht = (23*3600) + (59*60) + 59;
	$timestamp_spaet = (20*3600);
	
    $timestamp_fruehschicht = (3600*6);
	$timestamp_spaetschicht = (3600*14);
	$timestamp_nachtschicht = (3600*22);
    
	$merk_frueh = 0;
	$merk_spaet = 0;
	$merk_nacht = 0;
	$merk_feier = 0;
    $merk_krank = 0; // Notwendig für Krankschreibungen bei Nachtschicht
    $merk_letzter_tag = 0; // Für die richtige Darstellung des letzten Tages (Spätschicht) im Monat bei der Listenansicht
	$s = 0;
	$startzeit = 0;	
	$gesamtzeit = 0; //Gesamtstundenanzahl im Monat
	$nachtzeit = 0; // Nachtzulange 
	$feierzeit = 0; // Feiertagszulage
	$feiertag = 0; // Indikator ob Feiertag ja/nein
	$tag = 0;

	$nachtzeit_merk = 0;
	$feierzeit_merk = 0;
	
	$diff = 0; // (für SM) Zeit die nicht mitberechnet wird (Zeit vor Schichtbeginn)
	$nacht_array = array(); // Debug
	$return_arr = array();
	
	$datum = 0;
	$teilzeit = 0;
	$start_tag = 0;
	$persname = "";
	
	$naw_arr = array();
	$krank_arr = array();
	$zw_arr = array(); 
	
	// Holen der Urlaubs/Krankheitstage
	$naw_arr=tage($pnr,$start,$ende); 
	// Aussortieren der Krankheitstage
	foreach ($naw_arr as $naw){
		if($naw['STATUS']==802){
			array_push($krank_arr,date('d',strtotime($naw['Datum'])));
		}
	}
	

	// Wenn Mitarbeiter krank => Stempelzeiten werden an diesem Tag nicht gewertet.
	
	
	foreach ($tables as $type){$i++;}
	foreach ($tables as $type){
	$n++;
	$akt_tag = date('d',strtotime($type['MSTIME']));
    list($std, $min, $sek) = explode(':', date('G:i:s',strtotime($type['MSTIME'])));
	$zeit_sek = ($std * 3600) + ($min * 60) + $sek;
    
    // Wenn Einstempelzeitpunkt nach 06Uhr morgens, dann wird der Nachtmerker zurückgesetzt
    // Dies dient als Backup falls der Nachtmerker nicht zuverlässig zurückgesetzt wurde (Mitarbeiter stempelt vor 06 Uhr aus z.B.) 
    // und ist für die Kennung der Krankheitstage bzw der Wertung der Nachtschichten an diesen notwendig
    
    
    // Wenn kein Krankheitstag und einstempeln zur Nachtschicht (bzw nach 06 Uhr) dann zurücksetzen des Krankheitsmerkers. 
    // => Die Nachtschicht wird nicht gewertet. Alles darauffolgende an diesem Tag (kein Krankheitstag!) schon ... theoretisch ...
    if($zeit_sek > $timestamp_frueh && $type['STATUS'] == 100){
        $merk_nacht = 0;
       if (!in_array($akt_tag, $krank_arr)){
           $merk_krank = 0; 
       }
    }
    
     
    
    
		if ((!in_array($akt_tag, $krank_arr) || $merk_nacht) && !$merk_krank) {
	

    ### Evtl Krankmelder setzen der markiert ob Person am Vortag bereits krank gewesen ist. 
    ### Dann Abgleich ob Nachtmerker gesetzt ist. 
    ### 
    ### Bzw am Krankheitstag abfragen ob Nachtmerker gesetzt ist. 
    ### if(!in_array($akt_tag, $krank_arr) || $merk_nacht) 
    ###         geht durch
    ### zusätzlich innerhalb: $merk_krank = 1 ... das dann noch in die Anfangbedingung. 
    ### Sonst wird evtl der darauffolgende 200 Eintrag als 0 Uhr bis zeit_sek gewertet
    ###    - gibt es dann überhaupt einen 200 Eintrag? 
    ###    - wird $merk_nacht zuverlässig zurückgesetzt bei Schichtwechsel?
    ###    - Probleme bei anderen Schichtmodellen?
    ### Erweitert: Problem bei bereits absolvierter Nachtschicht am Krankheitstag ! 
    
    if(in_array($akt_tag,$krank_arr)){
        $merk_krank = 1; 
    }
    
    
    
    
	##### Hier Abfrage ob Schichtführer
	##### Hier Abfrage ob Schichtführer
	if($ks==0){
		if(istsf($pnr,date("d.m.Y",strtotime($type['MSTIME'])))){
			$sf = 1;
			$sm = 0;
		}
		else{
			$sf = 0;
			$sm = 1;
		}
	}
	
	##### Überprüfung ob Tag Feiertag ist 
	##### TODO feiertag.php modifizieren - Samstage und Sontage rauslassen (check)
	$date = date("d.m.Y",strtotime($type['MSTIME']));
	$feiertag = istfrei2($date);
	
	
	##### Fälle für ersten und letzten Eintag!
		// Situation: Monatswechsel u. Nachtschicht: 
###### - Abfrage nach ersten 200er Eintrag evtl überfällig 
		if($n == 1 && $type['STATUS']== 200){
			// Zeit ab 0 Uhr 
			### TODO NACHTZULAGE
			// Nachtzulage => wird in einzelnen Segmenten behandelt
			list($std, $min, $sek) = explode(':', date('G:i:s',strtotime($type['MSTIME'])));
			// MSTIME ist in dem Fall genau genommen die Zeit "ab 0 Uhr"
			$zeit_sek = ($std * 3600) + ($min * 60) + $sek;
			$diff = $type['MTIME2'] - $zeit_sek;
            
            $zw_arr['start_tag'] = date('d.m.Y',strtotime($type['MSTIME']));
			// startzeit noch auf 0 => passt (Nachtzeitrechnung)
			// Nachtzeit: 
			// if($zeit_sek > $timestamp_frueh) {
				// // Falls nach 06 Uhr ausgestempelt wurde werden nur die 06 Stunden (ab 0 Uhr) zu der Nachtzeit verrechnet
				// $nachtzeit = $nachtzeit + $timestamp_frueh;
			// }
			// else{
				// $nachtzeit = $nachtzeit + $zeit_sek; 
			// }
		}
		// Wenn letzter Eintrag = 100  => Für Alle gültig (SM,SF,!SM)
		#### TODO: 
		#### Schichtführer-Status beachten!! 
		else if($n == $i && $type['STATUS']==100){
			// Zeit bis 0 Uhr
			list($std,$min,$sek) = explode(':',date('G:i:s',strtotime($type['MSTIME'])));
			$zeit_sek = ($std * 3600) + ($min * 60) + $sek;
            // SM Berechnung
            if($sm)
                $zeit_sek = $timestamp_nachtschicht;
			$gesamtzeit = $gesamtzeit + ($timestamp_nacht - $zeit_sek);

			// Nachtzeit: 
			// Wenn Einstempelzeit vor 20 Uhr werden nur die 4 Stunden bis zur Nachtzeit verrechnet
			// Dadurch, dass dies der letzte Eintrag des Monats ist der verwertet wird, können wir sicher sein
			// dass kein 200-Eintrag mehr folgt
			### TODO Unterscheidung SF / SM
			if($zeit_sek < $timestamp_spaet) {
				$nachtzeit = $nachtzeit + $timestamp_spaet;
			}
			else{
				$nachtzeit = $nachtzeit + ($timestamp_nacht - $zeit_sek); 
			}
			// Feiertagszuschlag (Feierzeit) falls heutiger Tag == 1. (Gesamte Arbeitszeit wird aufgerechnet)
			if($feiertag){
                // SM Neuberechnung 
                $zeit_sek = ($std * 3600) + ($min * 60) + $sek;
				$feierzeit += $timestamp_nacht - $zeit_sek;
			}
				
		}  
		
	#######
	// Normale Einträge 
	// Keine Schichtarbeit: 
	else if ($ks == 1){
		$tag_akt = date('d',strtotime($type['MSTIME']));
	
		// Abfrage ob 100 und passender 200er Block am selben Tag => keine Nachtschicht
		// $tag als Prüfvariable
		
		// Fall: 100 ist erster Eintrag: 
		if($type['STATUS'] == 100 && $tag !== $tag_akt){
			
			list($std,$min,$sek) = explode(':',date('G:i:s',strtotime($type['MSTIME'])));
			$zeit_sek = ($std * 3600) + ($min * 60) + $sek;
			
			// Wenn Schichtführer oder kein Schichtmitarbeiter => Nachtzeit vor 06 Uhr
			// if(($zeit_sek < $timestamp_frueh) && (($sf == 1) || ($sm == 0))) {
				// $nachtzeit += $timestamp_frueh - $zeit_sek;
			// }
			// // Wenn Schichtführer oder kein Schichtmitarbeiter => Nachtzeit vor 22 Uhr
			// #### ??? Bei Eintrag 100 ???
			// else if(($zeit_sek > $timestamp_spaet)&& (($sf == 1) || ($sm == 0))) {
				// $nachtzeit += $timestamp_nacht - $zeit_sek;
			// }
			// Wenn Schichtmitarbeiter und Anfangszeit nach 22 Uhr und 200er Eintrag am nächsten Tag
			
			if($feiertag){
				$merk_feier = 1;
			}
			
			$startzeit = $zeit_sek;
			$tag = $tag_akt;
		}
		
		// Fall: 100 ist zweiter Eintrag:
		if($type['STATUS'] == 100 && $tag == $tag_akt){
			list($std,$min,$sek) = explode(':',date('G:i:s',strtotime($type['MSTIME'])));
			$zeit_sek = ($std * 3600) + ($min * 60) + $sek;
			
			// Wenn Schichtführer oder kein Schichtmitarbeiter => Nachtzeit vor 22 Uhr
			if(($zeit_sek > $timestamp_spaet)&& (($sf == 1) || ($sm == 0))) {
				$nachtzeit += $timestamp_nacht - $zeit_sek;
			}		
			if($feiertag){
				$merk_feier = 1;
			}
			$startzeit = $zeit_sek;
			$tag = $tag_akt;
		}
		
		// Fall: 200 ist erster Eintrag:
		if($type['STATUS'] == 200 && $tag !== $tag_akt){
			list($std,$min,$sek) = explode(':',date('G:i:s',strtotime($type['MSTIME'])));
			$zeit_sek = ($std * 3600) + ($min * 60) + $sek;
			
			if(($zeit_sek >= $timestamp_frueh)){
				$nachtzeit += $timestamp_frueh;
			}
			else{
				$nachtzeit += $zeit_sek;
			}
			
			$tag = $tag_akt;
			
			// Gesamtzeit:
			
			if($zeit_sek <= $startzeit){
				$gesamtzeit = $gesamtzeit + ($zeit_sek + (24*3600) - $startzeit);
			}
			else{
				$gesamtzeit = $gesamtzeit + ($zeit_sek - $startzeit);
			}	
			// Feiertag  
			// Fall 1: 100er und 200er Eintrag am selben Tag
			// Fall 2: 200er Eintrag am Feiertag ohne zugehörigen 100er Eintrag am selben Tag
			if($feiertag){
				if($akt_tag == $tag && $merk_feier == 1){
					$feierzeit += $type['MTIME2'] - $diff;
				}
				else{
					$feierzeit += $zeit_sek;
				}
				$merk_feier = 0;
			}
			// Fall 3: 100 Eintrag am Feiertag ohne darauffolgenden 200 Eintrag am selben Tag
			if($akt_tag !== $tag && $merk_feier == 1){
					$feierzeit += $timestamp_nacht - $startzeit;
					$merk_feier = 0;
			}
		}
		// Fall: 200 ist zweiter Eintrag
		if($type['STATUS'] == 200 && $tag == $tag_akt){
			list($std,$min,$sek) = explode(':',date('G:i:s',strtotime($type['MSTIME'])));
			$zeit_sek = ($std * 3600) + ($min * 60) + $sek;
			
			// Startzeit vor 20 nach 6 und  Endzeit nach 20 Uhr für Nachtzeit Spätschicht: 
			if(($startzeit <= $timestamp_spaet && $startzeit > $timestamp_frueh) && ($zeit_sek >= $timestamp_spaet)){
				$nachtzeit = $nachtzeit + ($zeit_sek - $timestamp_spaet);
			}
			// Startzeit nach 20 Uhr Und Endzeit zwischen 20 und 23:59:59
			else if(($startzeit >= $timestamp_spaet) && ($zeit_sek <= $timestamp_nacht && $zeit_sek >= $timestamp_spaet)){
				$nachtzeit = $nachtzeit + ($zeit_sek - $startzeit);
				//echo "<script>alert('".$nachtzeit."');</script>";
			}
			// Startzeit vor 20 Uhr (und nach 06 Uhr [26.06. Nachtrag]) und Endzeit zw 0 und 6 Uhr
			else if(($startzeit <= $timestamp_spaet && $startzeit > $timestamp_frueh) && ($zeit_sek <= $timestamp_frueh)){
				$nachtzeit = $nachtzeit + ($timestamp_nacht - $timestamp_spaet) + $zeit_sek;
			}
			// Startzeit vor 20 nach 6 Uhr und Endzeit zw 6 u. 20 Uhr
			else if(($startzeit <= $timestamp_spaet && $startzeit > $timestamp_frueh) && ($zeit_sek > $timestamp_frueh && $zeit_sek < $timestamp_spaet)){
				//$nachtzeit = $nachtzeit + ($timestamp_nacht - $timestamp_spaet) + $timestamp_frueh;
			}
			// Startzeit nach 20 Uhr und Endzeit vor 6 Uhr
			else if(($startzeit >= $timestamp_spaet) && ($zeit_sek <= $timestamp_frueh)){
				$nachtzeit = $nachtzeit + ($timestamp_nacht - $startzeit) +  $zeit_sek;
				//echo "<script>alert('".$startzeit."');</script>";
				
			}
			//  Startzeit nach 20 Uhr und Endzeit zwischen 6 Uhr und 20 Uhr 
			else if(($startzeit >= $timestamp_spaet) && ($zeit_sek > $timestamp_frueh && $zeit_sek < $timestamp_spaet)){
				$nachtzeit = $nachtzeit + ($timestamp_nacht - $startzeit) + $timestamp_frueh;
			}
			// Startzeit vor 6 Uhr und Endzeit vor 6 Uhr
			else if(($startzeit <= $timestamp_frueh) && ($zeit_sek <= $timestamp_frueh)){
				$nachtzeit = $nachtzeit + ($zeit_sek - $startzeit);
			}
			// Startzeit vor 6 Uhr und Endzeit zw 6 und 20 Uhr
			else if(($startzeit <=$timestamp_frueh) && ($zeit_sek > $timestamp_frueh && $zeit_sek < $timestamp_spaet)){
				$nachtzeit = $nachtzeit + ($timestamp_frueh - $startzeit);
			}
			// Startzeit vor 6 Uhr und Endzeit nach 20 Uhr 
			else if(($startzeit <= $timestamp_frueh) && ($zeit_sek > $timestamp_spaet)){
				$nachtzeit = $nachtzeit + ($timestamp_frueh - $startzeit) + ($zeit_sek - $timestamp_spaet);
			}
			
			$tag = $tag_akt;
			
				// Gesamtzeit:
			if($zeit_sek <= $startzeit){
				$gesamtzeit = $gesamtzeit + ($zeit_sek + (24*3600) - $startzeit);
			}
			else{
				$gesamtzeit = $gesamtzeit + ($zeit_sek - $startzeit);
			}	
	// Feiertag  
			// Fall 1: 100er und 200er Eintrag am selben Tag
			// Fall 2: 200er Eintrag am Feiertag ohne zugehörigen 100er Eintrag am selben Tag
			if($feiertag){
				if($akt_tag == $tag && $merk_feier == 1){
					$feierzeit += ($zeit_sek - $startzeit);
				}
				else{
					$feierzeit += $zeit_sek;
				}
				$merk_feier = 0;
			}
			// Fall 3: 100 Eintrag am Feiertag ohne darauffolgenden 200 Eintrag am selben Tag
			if($akt_tag !== $tag && $merk_feier == 1){
					$feierzeit += $timestamp_nacht - $startzeit;
					$merk_feier = 0;
			}
		}
	
	
	 // 26.04.17
	 // $gesamtzeit = $gesamtzeit + $type['MTIME2'];
	 

	
	 // if($feiertag == 1) {
		 // $feierzeit += $type['MTIME2'];
	 // }
	 
	
	
		
	
	
	//array_push($nacht_array,"NACHT:".($nachtzeit)/3600 . " startzeit: " . $startzeit . " zeit_sek: ".$zeit_sek . " GESAMT: " . $gesamtzeit/3600 . "   TEIL: ". ($zeit_sek - $startzeit)/3600);
	
	}
	
		// falls erst 200 dann 100 kommt => Nachtschicht (wschl) 
	
	
	
	
		// Nachtzeit vor 06 Uhr / nach 20 Uhr addieren:
		// if($type['STATUS'] == 100) {
			// list($std,$min,$sek) = explode(':',date('G:i:s',strtotime($type['MSTIME'])));
			// $zeit_sek = ($std * 3600) + ($min * 60) + $sek;
			// if($zeit_sek < $timestamp_frueh) {
				// $nachtzeit = $timestamp_frueh - $zeit_sek;
			// }
			// else if($zeit_sek > $timestamp_spaet ) {
				// $nachtzeit = $timestamp_nacht - $zeit_sek;
			// }
		
		// }
		// else {
			// list($std,$min,$sek) = explode(':',date('G:i:s',strtotime($type['MSTIME'])));
			// $zeit_sek = ($std * 3600) + ($min * 60) + $sek;
			// if($zeit_sek > $timestamp_spaet) {
				// $nachtzeit = $zeit_sek - $timestamp_spaet; 
			// }
		// }
	
	
	
	
	
	
	
	
	
	############## Schichtmitarbeiter: 
	$timestamp_fruehschicht = (3600*6);
	$timestamp_spaetschicht = (3600*14);
	$timestamp_nachtschicht = (3600*22);
	##### TODO auch hier wieder Den ersten und letzten Wert abfragen - dazwischen müsste dann eine problemlose Aufeinanderreihung von 
	##### 100 und 200 Einträgen erfolgen    
	##### Pausezeiten beachten
    if($sm == 1){
		list($std,$min,$sek) = explode(':',date('G:i:s',strtotime($type['MSTIME'])));
		$zeit_sek = ($std * 3600) + ($min * 60) + $sek;
		
		// Fall: Mitarbeiter stempelt Freitag um 20:00 Uhr aus (Spätschicht) und am Montag um 21:00 Uhr zur Nachtschicht ein 
		// => Merker "Spät" wurde nicht zurückgesetzt am Freitag und es wird die Zeit ab 21:00 Uhr verwertet trotz "SM" 
		// ==> Lösung: Tagesabgleich. Wenn aktueller Tag != Merker_Tag => Zurücksetzen aller Merker. 
		// Ausnahmefall: Nachtschicht -> Einstempeln vor 24:00 Uhr und erste Raucherpause nach 05 Uhr. Würde als Frühschicht gewertet. 
		// Aufbauend: Erste Pause nach 05 Uhr und Ausstempeln (nach hause) vor 06 Uhr. Merker bliebe wieder bestehen. 
        
        //  01.09 Ergänzug: Fall Hess: Stempelt Samstag vor dem Timestamp früh aus -> nachtmerker wird nicht zurückgesetzt - startzeit = zeit_sek -> 
        // -> Prüfung ob Wochenende mit akt_tag!=tag+1  (Prüfung für Krankheitsfall noch nicht gemacht)
		if(($akt_tag != $tag && !$merk_nacht) || ($akt_tag==$tag+1)){
			$merk_frueh = 0;
			$merk_spaet = 0;
			$merk_nacht = 0;
		}
		// Um die verschiedenen Schichtmodelle zu unterscheiden wird eine Toleranzzeitraum von 1 Stunde vor Schichtbeginn angegeben. 
		// Stempelt der Mitarbeiter während dieser Zeit ein, dann werden die Zeiten für diese Schicht gewertet, ansonsten für die 
		// vorherige Schicht. (Unterschiedliche Verwertung bei Schichtführer und Schichtmitarbeiter wird beachtet)
		
		
		// Um Raucherpausen während des Toleranzzeitraums zu erkennen, werden bei Schichtbeginn Merker gesetzt die signalisieren, dass
		// die jeweilige Schicht begonnen wurde. Diese werden innerhalb des Toleranzzeitraums der nächsten Schicht abgefragt.
		// Stempelt ein Mitarbeiter nach Schichtbeginn der nächsten Schicht aus, wird der Merker wieder auf 0 gesetzt. 
		
		
		
		// Die Variablen $startzeit und $endzeit dienen als Merker
		
		// Schichtunterscheidungen und Setzen der Startzeit: 
		if($type['STATUS'] == 100){
			###FRÜH:
			// Zeit nach 06 Uhr aber vor 13 Uhr
			if($zeit_sek > $timestamp_fruehschicht && $zeit_sek < ($timestamp_spaetschicht - 3600)){
				$startzeit = $zeit_sek;
				$diff = 0;
				$merk_frueh = 1;
			}
			// Zeit vor 06 Uhr aber nach 05 Uhr
			else if($zeit_sek >= ($timestamp_fruehschicht - 3600) && $zeit_sek <= $timestamp_fruehschicht){
				$startzeit = $timestamp_fruehschicht;
				$diff = $timestamp_fruehschicht - $zeit_sek;
				$merk_frueh = 1;
				###### Raucherpause für Toleranzzeitraum "FRÜH" (während Nachtschicht):
				if($merk_nacht == 1){
					$startzeit = $zeit_sek;
					$diff = 0;
				}

			}
			###SPAET: 
			// Zeit nach 14 Uhr aber vor 21 Uhr
			else if($zeit_sek > $timestamp_spaetschicht && $zeit_sek < ($timestamp_nachtschicht - 3600)){
				$startzeit = $zeit_sek;
				$diff = 0;
				$merk_spaet = 1;
			}
			// Zeit vor 14 Uhr aber nach 13 Uhr
			else if($zeit_sek >= ($timestamp_spaetschicht - 3600) && $zeit_sek <= $timestamp_spaetschicht){
				$startzeit = $timestamp_spaetschicht; 
				$diff = $timestamp_spaetschicht - $zeit_sek;
				$merk_spaet = 1;
				###### Raucherpause für Toleranzzeitraum "SPAET"(während Frühschicht):
				if($merk_frueh == 1){
					$startzeit = $zeit_sek;
					$diff = 0;
				}
			}
			###NACHT:
			// Zeit nach 22 Uhr aber vor 5 Uhr 
			else if(($zeit_sek >= $timestamp_nachtschicht && $zeit_sek <= (3600 * 24)) || ($zeit_sek <= $timestamp_fruehschicht -3600 && $zeit_sek > 0)){
				$startzeit = $zeit_sek; 
				$diff = 0;
				$merk_nacht = 1;
			}
			// Zeit nach 21 Uhr aber vor 22 Uhr
			else if(($zeit_sek >= ($timestamp_nachtschicht - 3600)) && $zeit_sek <= $timestamp_nachtschicht){
				$startzeit = $timestamp_nachtschicht;
				//echo "<script>alert('".$type['LBNO']."');</script>";
				$diff = $timestamp_nachtschicht - $zeit_sek;
				$merk_nacht = 1;
				###### Raucherpause für Toleranzzeitraum "NACHT"(während Spätschicht):
				if($merk_spaet == 1){
					$startzeit = $zeit_sek;
					$diff = 0;
				}
			}
			
			// wichtig für Feiertagsrechnung. 
			// Feiertagrechnung: Wenn der 100 Eintrag am gleichen Tag wie der 200er ist => komplette MTIME2-diff als Feiertagszuschlag
			// wenn nicht nur $zeit_sek als Feiertagszuschlag
			// Der Feiermerker wird gesetzt für den Fall, dass der nächste 200 Eintrag erst am darauffolgenden Tag kommt
			$tag = $akt_tag;
			if($feiertag){
				$merk_feier = 1;
				$startzeit = $zeit_sek;
				$diff = 0;
			}
		}
		
		// Berechnen der Gesamtzeit und der Nachtzeit anhand des zuvor gesetzten Startwertes
		if($type['STATUS'] == 200){
			// Gesamtzeit:
			### Zweite Bedingung: Falls SM und vor Schichtbeginn einmal aus und wieder eingestempelt -> Rechnet sonst 24h auf.
			### Wichtig: Muss als erste Bedingung vor die else if Bedingungen da Sonderfall Nachtschicht!!
			if($zeit_sek <= $startzeit && $zeit_sek < $timestamp_spaetschicht){
				$gesamtzeit = $gesamtzeit + ($zeit_sek + (24*3600) - $startzeit);
			}
			### Weitere Fallbacks falls sich im Toleranzzeitraum ein- und wieder ausgestempelt wird!
			else if($merk_spaet && ($zeit_sek < $timestamp_spaetschicht && $zeit_sek > $timestamp_fruehschicht)){
				$gesamtzeit = $gesamtzeit + 0;
			}
			else if($merk_nacht && ($zeit_sek < $timestamp_nachtschicht && $zeit_sek > $timestamp_spaetschicht)){
				$gesamtzeit = $gesamtzeit + 0;
			}
			else if($merk_frueh && $zeit_sek < $timestamp_fruehschicht){
				$gesamtzeit = $gesamtzeit + 0;
			}
			### Ansonsten normales Aufaddieren zur Gesamtzeit
			else{
				$gesamtzeit = $gesamtzeit + ($zeit_sek - $startzeit);
			}	
			// Eig sicherere Variante, allerdings Fall: PNR 757  06.02.2017 -> Fauser berechnet MTIME2-Zeit falsch!
			// Evtl Problem mit Nachkorrektur bei Stempelzeiten
			//$gesamtzeit = $gesamtzeit + ($type['MTIME2'] - $diff);
			
			// Feiertag  
			// Fall 1: 100er und 200er Eintrag am selben Tag
			// Fall 2: 200er Eintrag am Feiertag ohne zugehörigen 100er Eintrag am selben Tag
			if($feiertag){
				if($akt_tag == $tag && $merk_feier == 1){
					$feierzeit += ($zeit_sek - $startzeit);
				}
				else{
					$feierzeit += $zeit_sek;
				}
				$merk_feier = 0;
			}
			// Fall 3: 100 Eintrag am Feiertag ohne darauffolgenden 200 Eintrag am selben Tag
			if($akt_tag !== $tag && $merk_feier == 1){
					$feierzeit += $timestamp_nacht - $startzeit;
					$merk_feier = 0;
			}
			// Nachtzeit:

			// Abfrage ob Endzeit nach 20 Uhr für Nachtzeit Spätschicht: 
			if(($startzeit <= $timestamp_spaet && $startzeit > $timestamp_frueh) && ($zeit_sek >= $timestamp_spaet)){
				$nachtzeit = $nachtzeit + ($zeit_sek - $timestamp_spaet);
			}
			// Startzeit nach 20 Uhr Und Endzeit zwischen 20 und 23:59:59
			else if(($startzeit >= $timestamp_spaet) && ($zeit_sek <= $timestamp_nacht && $zeit_sek >= $timestamp_spaet)){
				$nachtzeit = $nachtzeit + ($zeit_sek - $startzeit);
				//echo "<script>alert('".$nachtzeit."');</script>";
			}
            #####
            
			// Startzeit vor 20 Uhr (und nach 06 Uhr [26.06. Nachtrag]) und Endzeit zw 0 und 6 Uhr
			else if(($startzeit <= $timestamp_spaet && $startzeit > $timestamp_frueh) && ($zeit_sek <= $timestamp_frueh)){
				$nachtzeit = $nachtzeit + ($timestamp_nacht - $timestamp_spaet) + $zeit_sek;
			}
			// Startzeit vor 20 nach 6 Uhr und Endzeit zw 6 u. 20 Uhr
			else if(($startzeit <= $timestamp_spaet && $startzeit > $timestamp_frueh) && ($zeit_sek > $timestamp_frueh && $zeit_sek < $timestamp_spaet)){
				//$nachtzeit = $nachtzeit + ($timestamp_nacht - $timestamp_spaet) + $timestamp_frueh;
				### keine Nachtzeit ..
				// Hier Ausnahmen setzten: $startzeit > $zeit_sek ...
			}
			// Startzeit nach 20 Uhr und Endzeit vor 6 Uhr
			else if(($startzeit >= $timestamp_spaet) && ($zeit_sek <= $timestamp_frueh)){
				$nachtzeit = $nachtzeit + ($timestamp_nacht - $startzeit) +  $zeit_sek;
				//echo "<script>alert('".$startzeit."');</script>";
				
			}
			//  Startzeit nach 20 Uhr und Endzeit zwischen 6 Uhr und 20 Uhr 
			else if(($startzeit >= $timestamp_spaet) && ($zeit_sek > $timestamp_frueh && $zeit_sek < $timestamp_spaet)){
				$nachtzeit = $nachtzeit + ($timestamp_nacht - $startzeit) + $timestamp_frueh;
			}
			// Startzeit vor 6 Uhr und Endzeit vor 6 Uhr
			else if(($startzeit <= $timestamp_frueh) && ($zeit_sek <= $timestamp_frueh)){
				$nachtzeit = $nachtzeit + ($zeit_sek - $startzeit);
			}
			// Startzeit vor 6 Uhr und Endzeit zw 6 und 20 Uhr
			else if(($startzeit <=$timestamp_frueh) && ($zeit_sek > $timestamp_frueh && $zeit_sek < $timestamp_spaet)){
				$nachtzeit = $nachtzeit + ($timestamp_frueh - $startzeit);
			}
			// Startzeit vor 6 Uhr und Endzeit nach 20 Uhr 
			else if(($startzeit <= $timestamp_frueh) && ($zeit_sek > $timestamp_spaet)){
				$nachtzeit = $nachtzeit + ($timestamp_frueh - $startzeit) + ($zeit_sek - $timestamp_spaet);
			}
			
			### Zurücksetzen der Merker: 
			### Es ist egal ob zwei Merker gleichzeitig gesetzt werden solange die Schichten gleich bleiben
			#### Änderung 02.05 timestamp_schicht jeweils um eine Schicht nach hinten verschoben
			#### UND jeweils den darauffolgenden Merker ebenfalls zurückgesetzt.
			#### Problem sind "SM" Springer die mal Schicht mal normal arbeiten
			if ($merk_frueh == 1 && $zeit_sek > $timestamp_spaetschicht) {
				$merk_frueh = 0;
				$merk_spaet = 0;
			}
			if ($merk_spaet == 1 && $zeit_sek > $timestamp_nachtschicht) {
				$merk_spaet = 0;
				$merk_nacht = 0;
			}
			if ($merk_nacht == 1 && $zeit_sek > $timestamp_fruehschicht) {
				$merk_nacht = 0;
				$merk_frueh = 0;
			}
			
			// Setzen der $tag Variable zur Merkerkontrolle bei Beginn der 100er Abfrage
			$tag = $akt_tag; 
			
				
				
				
				
			// Für Tabellenform
			// $start_stunde = ($startzeit % 3600);
			// $start_stunden_rest = fmod($startzeit,3600);
			// $start_minute = ($start_stunden_rest % 60);
			// $start_sekunde = fmod($start_stunden_rest,60); 
			
		
			//array_push($nacht_array,"NACHT:".($nachtzeit)/3600 . " startzeit: " . $startzeit . " zeit_sek: ".$zeit_sek . " GESAMT: " . $gesamtzeit/3600 . "   TEIL: ". ($zeit_sek - $startzeit)/3600);
		
		
		
		
		}
	
	
	
	}
	
	
	
	### Falls Mitarbeiter an diesem Tag Schichtführer war: 
	if($sf == 1) {
		list($std,$min,$sek) = explode(':',date('G:i:s',strtotime($type['MSTIME'])));
		$zeit_sek = ($std * 3600) + ($min * 60) + $sek;

		
		// Um die verschiedenen Schichtmodelle zu unterscheiden wird eine Toleranzzeitraum von 1 Stunde vor Schichtbeginn angegeben. 
		// Stempelt der Mitarbeiter während dieser Zeit ein, dann werden die Zeiten für diese Schicht gewertet, ansonsten für die 
		// vorherige Schicht. (Unterschiedliche Verwertung bei Schichtführer und Schichtmitarbeiter wird beachtet)
		// Bei Schichtführern beträgt der Toleranzzeitraum 2 Stunden 
		
		// Die Variablen $startzeit und $endzeit dienen als Merker
		
		// Schichtunterscheidungen und Setzen der Startzeit: 
		if($type['STATUS'] == 100){
			$startzeit = $zeit_sek; 
			// wichtig für Feiertagsrechnung. 
			// Feiertagrechnung: Wenn der 100 Eintrag am gleichen Tag wie der 200er ist => komplette MTIME2-diff als Feiertagszuschlag
			// wenn nicht nur $zeit_sek als Feiertagszuschlag
			// Der Feiermerker wird gesetzt für den Fall, dass der nächste 200 Eintrag erst am darauffolgenden Tag kommt
			$tag = $akt_tag;
			if($feiertag){
				$merk_feier = 1;
			}
            
            
            #### Problem 01.09.: Bei den Schichtführern muss ebenfalls der Nachtmerker gesetzt werden, da sonst Krankheitstage nicht korrekt gesetzt werden. (Rücksetzprüfung im 200er Eintrag ebenfalls hinzugefügt (nicht geprüft)
            else if(($zeit_sek >= $timestamp_nachtschicht && $zeit_sek <= (3600 * 24)) || ($zeit_sek <= $timestamp_fruehschicht -3600 && $zeit_sek > 0)){			
				$merk_nacht = 1;
			}
			// Zeit nach 21 Uhr aber vor 22 Uhr
			else if(($zeit_sek >= ($timestamp_nachtschicht - 3600)) && $zeit_sek <= $timestamp_nachtschicht){
				$merk_nacht = 1;		
			}
		}
		
		// Berechnen der Gesamtzeit und der Nachtzeit anhand des zuvor gesetzten Startwertes
		if($type['STATUS'] == 200){	
			// Gesamtzeit:
			if($zeit_sek <= $startzeit){
				$gesamtzeit = $gesamtzeit + ($zeit_sek + (24*3600) - $startzeit);
			}
			else{
				$gesamtzeit = $gesamtzeit + ($zeit_sek - $startzeit);
			}	
			// Eig sicherere Variante, allerdings Fall: PNR 757  06.02.2017 -> Fauser berechnet MTIME2-Zeit falsch!
			// Evtl Problem mit Nachkorrektur bei Stempelzeiten
			//$gesamtzeit = $gesamtzeit + ($type['MTIME2'] - $diff);
			//echo "<script>alert('GESAMT: ".$gesamtzeit." DINGS: ".$type['MTIME2']." DIFF: ".$diff."');</script>";
			
			// Feiertag  
			// Fall 1: 100er und 200er Eintrag am selben Tag
			// Fall 2: 200er Eintrag am Feiertag ohne zugehörigen 100er Eintrag am selben Tag
			if($feiertag){
				if($akt_tag == $tag && $merk_feier == 1){
					$feierzeit += ($zeit_sek - $startzeit);
				}
				else{
					$feierzeit += $zeit_sek;
				}
				$merk_feier = 0;
			}
			// Fall 3: 100 Eintrag am Feiertag ohne darauffolgenden 200 Eintrag am selben Tag
			if($akt_tag !== $tag && $merk_feier == 1){
					$feierzeit += $timestamp_nacht - $startzeit;
					$merk_feier = 0;
			}
			
			
			
			// Startzeit vor 20 nach 6 und  Endzeit nach 20 Uhr für Nachtzeit Spätschicht: 
			if(($startzeit <= $timestamp_spaet && $startzeit > $timestamp_frueh) && ($zeit_sek >= $timestamp_spaet)){
				$nachtzeit = $nachtzeit + ($zeit_sek - $timestamp_spaet);
			}
			// Startzeit nach 20 Uhr Und Endzeit zwischen 20 und 23:59:59
			else if(($startzeit >= $timestamp_spaet) && ($zeit_sek <= $timestamp_nacht && $zeit_sek >= $timestamp_spaet)){
				$nachtzeit = $nachtzeit + ($zeit_sek - $startzeit);
				//echo "<script>alert('".$nachtzeit."');</script>";
			}
			// Startzeit vor 20 Uhr (und nach 06 Uhr [26.06. Nachtrag]) und Endzeit zw 0 und 6 Uhr
			else if(($startzeit <= $timestamp_spaet && $startzeit > $timestamp_frueh) && ($zeit_sek <= $timestamp_frueh)){
				$nachtzeit = $nachtzeit + ($timestamp_nacht - $timestamp_spaet) + $zeit_sek;
			}
			// Startzeit vor 20 nach 6 Uhr und Endzeit zw 6 u. 20 Uhr
			else if(($startzeit <= $timestamp_spaet && $startzeit > $timestamp_frueh) && ($zeit_sek > $timestamp_frueh && $zeit_sek < $timestamp_spaet)){
				//$nachtzeit = $nachtzeit + ($timestamp_nacht - $timestamp_spaet) + $timestamp_frueh;
			}
			// Startzeit nach 20 Uhr und Endzeit vor 6 Uhr
			else if(($startzeit >= $timestamp_spaet) && ($zeit_sek <= $timestamp_frueh)){
				$nachtzeit = $nachtzeit + ($timestamp_nacht - $startzeit) +  $zeit_sek;
				//echo "<script>alert('".$startzeit."');</script>";
				
			}
			//  Startzeit nach 20 Uhr und Endzeit zwischen 6 Uhr und 20 Uhr 
			else if(($startzeit >= $timestamp_spaet) && ($zeit_sek > $timestamp_frueh && $zeit_sek < $timestamp_spaet)){
				$nachtzeit = $nachtzeit + ($timestamp_nacht - $startzeit) + $timestamp_frueh;
			}
			// Startzeit vor 6 Uhr und Endzeit vor 6 Uhr
			else if(($startzeit <= $timestamp_frueh) && ($zeit_sek <= $timestamp_frueh)){
				$nachtzeit = $nachtzeit + ($zeit_sek - $startzeit);
			}
			// Startzeit vor 6 Uhr und Endzeit zw 6 und 20 Uhr
			else if(($startzeit <=$timestamp_frueh) && ($zeit_sek > $timestamp_frueh && $zeit_sek < $timestamp_spaet)){
				$nachtzeit = $nachtzeit + ($timestamp_frueh - $startzeit);
			}
			// Startzeit vor 6 Uhr und Endzeit nach 20 Uhr 
			else if(($startzeit <= $timestamp_frueh) && ($zeit_sek > $timestamp_spaet)){
				$nachtzeit = $nachtzeit + ($timestamp_frueh - $startzeit) + ($zeit_sek - $timestamp_spaet);
			}
			
			
			
				
			### Zurücksetzen der Merker: 
			### Es ist egal ob zwei Merker gleichzeitig gesetzt werden solange die Schichten gleich bleiben
			#### Änderung 02.05 timestamp_schicht jeweils um eine Schicht nach hinten verschoben
			#### UND jeweils den darauffolgenden Merker ebenfalls zurückgesetzt.
			#### Problem sind "SM" Springer die mal Schicht mal normal arbeiten
			if ($merk_frueh == 1 && $zeit_sek > $timestamp_spaetschicht) {
				$merk_frueh = 0;
				$merk_spaet = 0;
			}
			if ($merk_spaet == 1 && $zeit_sek > $timestamp_nachtschicht) {
				$merk_spaet = 0;
				$merk_nacht = 0;
			}
			if ($merk_nacht == 1 && $zeit_sek > $timestamp_fruehschicht) {
				$merk_nacht = 0;
				$merk_frueh = 0;
			}
			
			// Setzen der $tag Variable zur Merkerkontrolle bei Beginn der 100er Abfrage
			$tag = $akt_tag; 
			
			
			//array_push($nacht_array,"NACHT:".($nachtzeit)/3600 . " startzeit: " . $startzeit . " zeit_sek: ".$zeit_sek . " GESAMT: " . $gesamtzeit/3600);
		}
	
	
	
	
	
	}
	
	
	// // Normale Addition aller Zeiten die in den 200er Blöcken MTIME2 gespeichert sind
	// $gesamtzeit = $gesamtzeit + $type['MTIME2'];
	
	$persname = $type['PERSNAME'];
	
	
	// $datumakt = date('dmY',strtotime($type['MSTIME']));
	// $text = "";
	// if($type['STATUS']==100){
		// $text = "Kommt: ";
	// }
	// if($type['STATUS']==200){
		// $text = "Geht: ";
	// }
	// if($datum == $datumakt){
		// $return_arr['daten'][date('d.m.Y',strtotime($type['MSTIME']))][$t] =  $text . date(' G:i:s',strtotime($type['MSTIME']));
		// $datum = $datumakt;
		// $t++;
	// }
		
		
	// else {
		// $t=0;
		// $return_arr['daten'][date('d.m.Y',strtotime($type['MSTIME']))][$t] =  $text . date(' G:i:s',strtotime($type['MSTIME']));
		// $datum = $datumakt;
		// $t++;
	// }
	
	
	if($type['STATUS'] == 100){
		$zw_arr['start_tag'] = date('d.m.Y',strtotime($type['MSTIME']));
	}
 
    
    if($n == $i && $type['STATUS']==100){
        // Zeit bis 0 Uhr
        list($std,$min,$sek) = explode(':',date('G:i:s',strtotime($type['MSTIME'])));
        $startzeit = ($std * 3600) + ($min * 60) + $sek;
        if($sm)
            $startzeit = $timestamp_nachtschicht;
        $zeit_sek = $timestamp_nacht;
        $merk_letzter_tag = 1;  // Setzen um auch den letzten Tag bei Spätschicht korrekt anzuzeigen 
                                // Der Tag wurde bereits am Anfang der Funktion korrekt zur Gesamtzeit zugerechnet
                                // nachfolgend geht es nurnoch um die richtige Darstellung im PDF
            
    }  
	if($type['STATUS'] == 200 || $merk_letzter_tag){
			$now = date_create('now', new DateTimeZone('GMT'));
			$here = clone $now;
			$here->modify($startzeit.' seconds');
			$diff = $now->diff($here);

			$now2 = date_create('now', new DateTimeZone('GMT'));
			$here2 = clone $now2;
			$here2->modify($zeit_sek.' seconds');
			$diff2 = $now2->diff($here2);
			
			
							    
			$zw_arr['persname'] = $type['PERSNAME'];
			$zw_arr['pnr'] = $type['PERSNO'];
			$zw_arr['ende_tag'] = date('d.m.Y',strtotime($type['MSTIME']));
			$zw_arr['startzeit'] = $diff->format('%h:%i:%s');  
			$zw_arr['endezeit'] = $diff2->format('%h:%i:%s');  
			$zw_arr['gesamtzeit'] = round($gesamtzeit/3600,3);
			$zw_arr['feierzeit'] = round($feierzeit/3600,3);
			$zw_arr['nachtzeit'] = round($nachtzeit/3600,3);
			$zw_arr['teil_nachtzeit'] = round(($nachtzeit - $nachtzeit_merk)/3600,3);
			$zw_arr['teil_feierzeit'] = round(($feierzeit - $feierzeit_merk)/3600,3);
			$teilzeit = ($zeit_sek - $startzeit)/3600;
			if($teilzeit < 0)	
				$teilzeit = (($zeit_sek - $startzeit) + (3600 * 24))/3600;
			
			$zw_arr['teilzeit'] = round($teilzeit,3);
			
			$nachtzeit_merk = $nachtzeit;
			$feierzeit_merk = $feierzeit;
            
            
            $merk_letzter_tag = 0; 
			
			array_push($nacht_array,$zw_arr);
	}
	
	
	
		}
	}
	
	#TODO: Feiertagsüberprüfung und Schichtführer-Abhängigkeit
	
#### Rückgabe-Array bilden: 


// $return_arr['pnr'] = $pnr;
// $return_arr['persname'] = $persname;
$return_arr['gesamt'] = round($gesamtzeit/3600,3);
$return_arr['nacht'] = round($nachtzeit/3600,3);
$return_arr['feier'] = round($feierzeit/3600,3);

// Abrechnung mit allen relevaten Enddaten
if($art == 0){
	return $return_arr; 
}
// Tabellenform mit den einzelnen Zeiten
else{
	return $nacht_array;
}
// return "Gesamtzeit: " .$gesamtzeit/3600 . " Nachtzeit: ". $nachtzeit/3600 . " Feierzeit: " . $feierzeit/3600;

}
?>