<?php
	
	// Funktion ob Feiertag oder Wochenende ja / nein
	 function istfrei($termin) {
		
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
    $feiertage[] = date("dm", $ostersonntag - 2 * $tage);  // Karfreitag
    $feiertage[] = date("dm", $ostersonntag + 1 * $tage);  // Ostermontag
    $feiertage[] = date("dm", $ostersonntag + 39 * $tage); // Himmelfahrt
    $feiertage[] = date("dm", $ostersonntag + 50 * $tage); // Pfingstmontag
    $feiertage[] = date("dm", $ostersonntag + 60 * $tage); // Fronleichnam

    // Prüfen, ob Feiertag
    $code = $tag.$monat;
    return in_array($code, $feiertage);  
	}	

	
	
	function tagerechner($start,$ende) {
        
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
		if(istfrei($start->format('d.m.Y'))){
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
	
	
	
	
function urlaubrechner($idstart,$idende,$typ){
    // Variablenwerte aus dem Antrag selbst holen: 
	$tables = Yii::$app->db->createCommand ("
		SELECT * 
		FROM m3_urlaubsplanung 
		WHERE LBNO=".$idstart." OR LBNO=".$idende."  
		ORDER BY LBNO
		")
	-> queryAll();
	
	$i=0;
	
	foreach($tables as $type){
		if($i==0){
			$datum_start = $type['MSTIME'];
			$tage_monat = $type['TAGE'];
			$stunden_monat = $type['STUNDEN'];
            if($type['WORKID']!==0){
                $pe_work_id = $type['WORKID'];
            }
			$i++;
		}
		else{
			$datum_ende = $type['MSTIME'];		
		}
	}  
    
    
    // Urlaub löschen
    if($typ == 0){
       return urlaub_ausrechne($datum_start,$datum_ende,$tage_monat,$stunden_monat,$pe_work_id,0);
    }
  
    // Urlaub eintragen
    else if($typ == 1){
       return urlaub_ausrechne($datum_start,$datum_ende,$tage_monat,$stunden_monat,$pe_work_id,1);
    }
    
    // Betriebsurlaub löschen: 
    else if($typ == 2){
        $mitarbeiter = Yii::$app->db->CreateCommand ("
			SELECT NO as WORKID FROM PE_WORK WHERE STATUS1 = 0
			") 
		->queryAll();
        foreach($mitarbeiter as $typ){
            $pe_work_id = $typ['WORKID'];
            urlaub_ausrechne($datum_start,$datum_ende,$tage_monat,$stunden_monat,$pe_work_id,0);
        }
        return 1;
    }
    
    // Betriebsurlaub eintragen: 
    else if($typ == 3){
        $mitarbeiter = Yii::$app->db->CreateCommand ("
			SELECT NO as WORKID FROM PE_WORK WHERE STATUS1 = 0
			") 
		->queryAll();
        foreach($mitarbeiter as $typ){
            $pe_work_id = $typ['WORKID'];
            urlaub_ausrechne($datum_start,$datum_ende,$tage_monat,$stunden_monat,$pe_work_id,1);
        }
        return 1;
    }   
    
    
}

function urlaub_ausrechne($datum_start,$datum_ende,$tage_monat,$stunden_monat,$pe_work_id,$art){
	###### Die übergebene Variable $art steht für:
	###### 0: Urlaub Löschen: Es wird ein bestehender Urlaubseintrag gelöscht und die Tage / Stunden wieder aufs Konto addiert
	###### 1: Urlaub Eintragen: Es wird ein neuer Urlaubsantrag eingetragen und die Tage / Stunden vom Konto subtrahiert
	

	
	// Überprüfen ob bereits ein Eintrag in m3_urlaub_stunden vorhanden ist. (Bei neuen Mitarbeiter die sofort Urlaub brauchen möglich)
	//abrechnungfkt($pe_work_id);
    //abrechnungfkt rechnet ab und legt nicht nur an!!!

	
	// Berechnen der anfallenden Urlaubstage für die jeweiligen Monate des Antrags
	
	// Letzten Tag des Monats ermitteln
	$tag_start = date('d',strtotime($datum_start));
	$monat_start = date('m',strtotime($datum_start));
	$jahr_start = date('Y',strtotime($datum_start));
	$letzter_start = date('t',strtotime($datum_start));

	$tag_ende = date('d',strtotime($datum_ende));
	$monat_ende = date('m',strtotime($datum_ende));
	$jahr_ende = date('Y',strtotime($datum_ende));
	
	$monat_mitte = 0;
	
	// Überprüfung ob Urlaub über 3 Monate geht und Setzen des mittleren Monats:
	# Nov - Jan
	if(($monat_ende - 1 !== $monat_start) && ($monat_start == 11)){
		$monat_mitte = 12;
		$jahr_mitte = $jahr_start;
	}
	# Dez - Feb
	if(($monat_ende - 1 !== $monat_start) && ($monat_ende == 2)){
		$monat_mitte = 1;
		$jahr_mitte = $jahr_ende;
	}
	# Restliches Jahr
	if(($monat_ende - 1 !== $monat_start) && ($monat_ende - 2 == $monat_start)){
		$monat_mitte = date('n',strtotime($datum_start))+1;
		$jahr_mitte = $jahr_start;
	}
	
    
    
        
    ### Rausfinden ob Halbtagskraft oder nicht (kann später auf genaue Abrechnung erweitert werden, momentan kritisch wegen fehlender Einträge zu den Wochenstunden in FAG_DETAIl (Val02)    
    $std_tag = Yii::$app->db->CreateCommand("
        SELECT VAL02 FROM FAG_DETAIL WHERE FKNO = ".$pe_work_id." AND TYP = 26 
    ")
    ->queryAll();
    
    if($std_tag == 20)
        $stundentag = 4;
    else 
        $stundentag = 8;

		
	$var_us = "U".date("n",strtotime($datum_start));
	$var_um = "U".$monat_mitte;
	$var_ue = "U".date("n",strtotime($datum_ende));
	
	$var_ss = "S".date("n",strtotime($datum_start));
	$var_sm = "S".$monat_mitte;
	$var_se = "S".date("n",strtotime($datum_ende));
	
	
	
	
	##########
	
	##### Unterscheidung mehrfache Einträge weil Betriebsurlaub oder einfacher Eintrag bei einzelner Urlaub
	// Eintrag bei unterschiedlichen Monaten 
	if($monat_start !== $monat_ende){
		$datum_start_ende = date('d.m.Y',strtotime($letzter_start."-".$monat_start."-".$jahr_start));
		$datum_ende_start = date('d.m.Y',strtotime("01-".$monat_ende."-".$jahr_ende));
		$datum_start = date('d.m.Y',strtotime($datum_start));
		$datum_ende = date('d.m.Y',strtotime($datum_ende));
		
		
		
		$tage_start_monat = tagerechner($datum_start,$datum_start_ende);	
		$tage_ende_monat = tagerechner($datum_ende_start,$datum_ende);	
		

		// Fall: Urlaub zieht sich über 3 Monate => Variable um 
		
	####	us / ss  = Tage / Stunden  Startmonat 
	####	um / sm  = Tage / Stunden  Mittlerer Monat
	####    ue / se  = Tage / Stunden  Schlussmonat
		
		
		

			if($tage_monat<=$tage_start_monat){
				$us = $tage_monat;
				$ue = 0;

				$ss = $tage_start_monat - $tage_monat;
				$se = $tage_ende_monat;
				
				$um = 0;
				$sm = $tage_monat + $stunden_monat - $tage_ende_monat - $tage_start_monat;
			}
			
			
			if($tage_monat>$tage_start_monat){
				$us = $tage_start_monat;
				$ss = 0;
				
				if($stunden_monat<=$tage_ende_monat){
					$ue = $tage_ende_monat - $stunden_monat;
					$se = $stunden_monat;
					
					$um = $tage_monat - $us - $ue;
					$sm = 0;
					}
				else{
					$ue = 0;
					$se = $tage_ende_monat;
					
					$um = $tage_monat - $tage_start_monat;
					$sm = $stunden_monat - $tage_ende_monat;
				}
			}
			
			
			 
	$ss = $ss * $stundentag;
	$sm = $sm * $stundentag;
	$se = $se * $stundentag;
	//	echo "<script>alert('".$datum_start_ende." ".$datum_ende_start."<br>".$datum_start." ".$datum_ende."<br>".$tage_start_monat." ".$tage_ende_monat."');</script>";
		
	
	// Jahreswechsel inklusive
############################## Urlaub eintragen:
if($art == 1){
	Yii::$app->db->createCommand ("
			UPDATE  m3_urlaub_stunden
			SET 
				[".$var_us."] = ([".$var_us."]-".$us."),
				[".$var_ss."] = ([".$var_ss."]-".$ss.")
			FROM m3_urlaub_stunden			
			WHERE WORKID = ".$pe_work_id." AND JAHR = ".$jahr_start."
			")
	->execute();		
	
	if($var_um !== "U0" || $var_sm !== "S0"){
	Yii::$app->db->createCommand ("
			UPDATE m3_urlaub_stunden
			SET
				[".$var_um."] = ([".$var_um."]-".$um."),
				[".$var_sm."] = ([".$var_sm."]-".$sm.")
			FROM m3_urlaub_stunden 
			WHERE WORKID = ".$pe_work_id." AND JAHR = ".$jahr_mitte."
			")
	->execute();
	}
	Yii::$app->db->createCommand ("
			UPDATE m3_urlaub_stunden
			SET
				[".$var_ue."] = ([".$var_ue."]-".$ue."),
				[".$var_se."] = ([".$var_se."]-".$se.")
			FROM m3_urlaub_stunden
			WHERE WORKID = ".$pe_work_id." AND JAHR = ".$jahr_ende." 
			")
	->execute();
	}

	
############################ URLAUB LÖSCHEN:	
else{
			Yii::$app->db->createCommand ("
			UPDATE  m3_urlaub_stunden
			SET 
				[".$var_us."] = ([".$var_us."]+".$us."),
				[".$var_ss."] = ([".$var_ss."]+".$ss.")
			FROM m3_urlaub_stunden			
			WHERE WORKID = ".$pe_work_id." AND JAHR = ".$jahr_start."
			")
	->execute();		
	
	if($var_um !== "U0" || $var_sm !== "S0"){
	Yii::$app->db->createCommand ("
			UPDATE m3_urlaub_stunden
			SET
				[".$var_um."] = ([".$var_um."]+".$um."),
				[".$var_sm."] = ([".$var_sm."]+".$sm.")
			FROM m3_urlaub_stunden 
			WHERE WORKID = ".$pe_work_id." AND JAHR = ".$jahr_mitte."
			")
	->execute();
	}
	Yii::$app->db->createCommand ("
			UPDATE m3_urlaub_stunden
			SET
				[".$var_ue."] = ([".$var_ue."]+".$ue."),
				[".$var_se."] = ([".$var_se."]+".$se.")
			FROM m3_urlaub_stunden
			WHERE WORKID = ".$pe_work_id." AND JAHR = ".$jahr_ende." 
			")
	->execute();
	
}
	}

	else {
	

	######   *8
	$us = $tage_monat;
	$ss = $stunden_monat * $stundentag;
	// falls Urlaubszeitraum im gleichen Monat:
	// ################# Urlaub Eintragen
	if($art == 1){
	Yii::$app->db->createCommand ("
			UPDATE  m3_urlaub_stunden
			SET 
				[".$var_us."] = ([".$var_us."] - ".$us."),
				[".$var_ss."] = ([".$var_ss."] - ".$ss.")
				
			FROM m3_urlaub_stunden 
			WHERE WORKID = ".$pe_work_id." AND JAHR = ".$jahr_start." 
			
	")
	->execute();	
	}
	##################### Urlaub Löschen
	else{
		Yii::$app->db->createCommand ("
			UPDATE  m3_urlaub_stunden
			SET 
				[".$var_us."] = ([".$var_us."] + ".$us."),
				[".$var_ss."] = ([".$var_ss."] + ".$ss.")
				
			FROM m3_urlaub_stunden 
			WHERE WORKID = ".$pe_work_id." AND JAHR = ".$jahr_start." 
			
	")
	->execute();	
		
	}	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	
	
	

	
	
	// wenn Startmonat nicht gleich Endmonat: 
	
	
	// Ermittlung des letzten Tages im Monat: 
	
	// Verechnen aller Urlaubstage dieses Monats
	
	// Wenn Urlaub über 3 Monate:: Ermittlung der Anzahl der Tage des letzten Monats 
	
	// Urlaub über Jahreswechsel berücksichtigen
	
	
	// Abziehen von der Gesamtzahl der benötigten Urlaubstage des Antrags 
	
	
	
	// SQL Befehl zum Eintrag der benötigten Urlaubstage der jeweiligen Monate

	
	
	
	
#### Stunden: 
	//  
	
	
	
	
	
	
	
	
	
####  Abrechnung: 
    // Überprüfung ob Datensatz für dieses Jahr und nächstes Jahr existent
	
	
	
	// Verechnen des Wertes aus dem Vormonat mit dem vorgemerkten Wert des vergangenen Monats
	// Bei Jahreswechsel: Verechnen des Resturlaubs mit dem Urlaub aus dem neuen Jahr. (Bereits angelegt, Standardwert)

	
	
	
	
	
	
####  Ausgabe Urlaubstage Anzahl:
	// Addieren aller Einträge aus U.  (/Stunden)
	




	
	
	
	return true; 	
}
?>