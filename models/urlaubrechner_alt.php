<?php

   function urlaubrechner($idstart,$idende){
	// Wenn Resturlaub vom Vorjahr vorhanden -> dann von diesem abziehen bis 0 --> weiterer Rest von von aktuellem Jahr (/Folgejahr)
	
	// Falls noch kein Datensatz von nächsten Jahr vorhanden -> erstellen. Wert für DefaultUrlaub aus fag_detail.txt02
	

	
	$jahr = date("Y");
	$jahrneu = date("Y")+1;   // Wird im Alg. verwendet 
	$jahralt = date("Y")-1;  // Wird im Alg. verwendet
	######
	$monat = date("n")-1;  // <===
	if($monat == 0){ $monat = 1;}
	$varS = "S".$monat;
	$varU = "U".$monat;
	######
	// Prüfung ob aktuelles und nächstes Jahr vorhanden: 
	// Die Stunden werden nicht übernommen. Dies geschieht im Alg. der Stundenauswertung
	
	Yii::$app->db->CreateCommand (" 
					IF NOT EXISTS(SELECT * FROM m3_urlaub_stunden
				   INNER JOIN m3_urlaubsplanung 
				   ON WORKID = m3_urlaubsplanung.pe_work_id
				   WHERE JAHR = ".$jahr." AND m3_urlaubsplanung.ID = ".$idende.")

	BEGIN
	INSERT INTO m3_urlaub_stunden (
				   [WORKID]
				  ,[JAHR]
				  ,[".$varU."]
							  )
							  								  
				   SELECT m3_urlaubsplanung.pe_work_id, ".$jahr.", FAG_DETAIL.VAL01
				   FROM m3_urlaubsplanung
				   INNER JOIN FAG_DETAIL 
				   ON pe_work_id = FAG_DETAIL.FKNO 
				   WHERE m3_urlaubsplanung.ID = ".$idende."
	END

	IF NOT EXISTS(SELECT * FROM m3_urlaub_stunden
				   INNER JOIN m3_urlaubsplanung 
				   ON WORKID = m3_urlaubsplanung.pe_work_id
				   WHERE JAHR = ".$jahrneu." AND m3_urlaubsplanung.ID = ".$idende.")

	BEGIN
	INSERT INTO m3_urlaub_stunden (
				   [WORKID]
				  ,[JAHR]
				  ,[U1]
							  )
							  								  
				   SELECT m3_urlaubsplanung.pe_work_id, ".$jahrneu.", FAG_DETAIL.VAL01
				   FROM m3_urlaubsplanung
				   INNER JOIN FAG_DETAIL 
				   ON pe_work_id = FAG_DETAIL.FKNO
				   WHERE m3_urlaubsplanung.ID = ".$idende."
	END
				")
				->execute();
	
	
	
	
	// Rechenwerte-Abfrage
	
	##### Es werden immer zwei oder drei Zeilen an Daten zurückgegeben, je nachdem was angelegt ist.
	##### 2 Zeilen:: 0: Aktuelles Jahr   1: Nächstes Jahr
	##### 3 Zeilen:: 0: Vorheriges Jahr  1: Aktuelles Jahr  2: Nächstes Jahr
	
	
	$tables = Yii::$app->db->CreateCommand("SELECT 
		COALESCE(m3_urlaub_stunden.U12, m3_urlaub_stunden.U11, m3_urlaub_stunden.U10, m3_urlaub_stunden.U9, m3_urlaub_stunden.U8, 
					m3_urlaub_stunden.U7, m3_urlaub_stunden.U6, m3_urlaub_stunden.U5, m3_urlaub_stunden.U4, m3_urlaub_stunden.U3, m3_urlaub_stunden.U2, 
				    m3_urlaub_stunden.U1) as _tage,
	    COALESCE(m3_urlaub_stunden.S12, m3_urlaub_stunden.S11, m3_urlaub_stunden.S10, m3_urlaub_stunden.S9, m3_urlaub_stunden.S8, 
					m3_urlaub_stunden.S7, m3_urlaub_stunden.S6, m3_urlaub_stunden.S5, m3_urlaub_stunden.S4, m3_urlaub_stunden.S3, m3_urlaub_stunden.S2, 
				    m3_urlaub_stunden.S1) as _stunden,
					TAGE, STUNDEN, DATEPART(yyyy,TERMIN) as termin_jahr, m3_urlaub_stunden.JAHR as abr_jahr,pe_work_id, DATEPART(yyyy,CDATE) as CDATE
				    
					FROM m3_urlaubsplanung 
					INNER JOIN m3_urlaub_stunden 
					ON pe_work_id = m3_urlaub_stunden.WORKID
					INNER JOIN LB_DC 
					ON m3_urlaubsplanung.LBNO = LB_DC.LBNO
					WHERE (m3_urlaub_stunden.JAHR = DATEPART(yyyy,CDATE)-1
					OR m3_urlaub_stunden.JAHR = DATEPART(yyyy,CDATE)
					OR m3_urlaub_stunden.JAHR = DATEPART(yyyy,CDATE)+1)
					AND m3_urlaubsplanung.ID = ".$idende."
					ORDER BY abr_jahr")
					->queryALL();
					
					
					
	
	// TODO: 2 Datensätze auslesen für Vorjahr u akt. Jahr (Standpunkt Jahr des Endtermins)  
	$i = 0;
	$n = 0;
	$tage_aktjahr = 0;
	$tage_neujahr = 0;
	$tage_vorjahr = 0;
	$stunden_aktjahr = 0;
	$stunden_vorjahr = 0;
	$ben_tage = 0;
	$ben_stunden = 0;
	$abr_jahr = 0;
	$termin_jahr = 0;
	$workid = 0; 
	$wert = 0;

	foreach($tables as $type){$i++;}

	foreach($tables as $type) {
		if($i == 2){
			if($n == 1){
				$tage_neujahr = $type['_tage'];
			}
			else if($n == 0) {
				$tage_aktjahr = $type['_tage'];
				$stunden_aktjahr = $type['_stunden'];
				$ben_tage = $type['TAGE'];
				$ben_stunden = $type['STUNDEN'];
				$abr_jahr = $type['abr_jahr'];
				$termin_jahr = $type['termin_jahr'];
				$workid = $type['pe_work_id']; 
				$n++;
			}
		}
		else if($i == 3){
			if($n == 2){
			$tage_neujahr = $type['_tage'];
			}
			else if($n == 1) {
			$tage_aktjahr = $type['_tage'];
			$stunden_aktjahr = $type['_stunden'];
			$n++;
			}
			else if($n == 0) {
			$tage_vorjahr = $type['_tage'];
			$stunden_vorjahr = $type['_stunden'];
			$ben_tage = $type['TAGE'];
			$ben_stunden = $type['STUNDEN'];
			$abr_jahr = $type['abr_jahr'];
			$termin_jahr = $type['termin_jahr'];
		    $workid = $type['pe_work_id'];
			$n++;
			}
		}
	}
	
	// Prüfen ob Datensatz für nächstes / dieses Jahr bereits vorhanden. Stunden übernehmen und im vorherigen Kalenderjahr
	// nullen (Dopplung vermeiden). 

		
##### Fall: Aktuelles Jahr > Jahr im Enddatum falls Bestätigung auf sich warten lässt und ins nächste Jahr fällt: Würde zur 
##### Ausnahme führen, tritt aber nicht auf da der Urlaub für gewöhnlich bestätigt wird bevor er angetreten werden kann. . . 
// date("Y") beschreibt faktisch den Zeitpunkt des Antrags...  (TODO: Zur Fehlervorbeugung aus LB_DC (ADCMESS) auslesen
// Funktion würde trotzdem funktionieren - problematisch nur falls Resturlaub aus dem vorherigen Jahr des Antragsdatums vorhanden wäre.
// TODO!: Bei Änderung unbedingt die Variable $jahrneu im Alg. austauschen!!
// TODO: Abbruch bei nicht genügenden Urlaubstagen im nächsten Jahr
// TODO: Termin wird momentan noch eingetragen obwohl nicht genügend Urlaubstage vorhanden 

	if($termin_jahr > (int)date("Y")){
			if($tage_aktjahr > 0){
				$wert = $tage_aktjahr - $ben_tage;
				if($wert >= 0) {		
			
					// $wert als neuen Urlaubsstand in die Tabelle des aktuellen Jahres eintragen  (in U(aktueller Monat -1))
					Yii::$app->db->CreateCommand("UPDATE m3_urlaub_stunden		
								  SET ".$varU." = (".$wert.")
								  FROM m3_urlaub_stunden
								  WHERE WORKID = ".$workid." AND JAHR = ".$jahr."")
								  ->execute();
				}
				else{
					// Urlaubsstand des nächsten Jahres - $wert und als neuen Wert in U1 des nächsten Jahres eintragen 
					// Zusätzlich den U  Wert des aktuellen Jahres nullen
					// + Überprüfen ob Datensatz vorhanden und ggfs anlegen
					Yii::$app->db->CreateCommand("UPDATE m3_urlaub_stunden		
								  SET ".$varU." = (0)
								  FROM m3_urlaub_stunden
								  WHERE WORKID = ".$workid." AND JAHR = ".$jahr."")
								  ->execute();
					##
					// da der Wert bereits eine negative Zahl ist wird sie zu U1 addiert um eine Subtraktion zu bewirken
					//  TODO: Bei Änderung der Initialabfrage (date("Y")) auf das CDATE von LB_DC  $jahrneu mit ändern
					Yii::$app->db->CreateCommand("UPDATE m3_urlaub_stunden		
								  SET U1 = (U1 + ".$wert.")  
								  FROM m3_urlaub_stunden
								  WHERE WORKID = ".$workid." AND JAHR = ".$jahrneu."")
								  ->execute();
				}
			}
			else {
					// Abfrage nach Urlaub des $id_ende Jahres  bzw ob der Datensatz schon angelegt ist. 
					// Verrechnen des $wert
					// Eintragen des Wertes in U1 des nächsten Jahres
					
					Yii::$app->db->CreateCommand("UPDATE m3_urlaub_stunden		
								  SET U1 = (U1 - ".$ben_tage.")  
								  FROM m3_urlaub_stunden
								  WHERE WORKID = ".$workid." AND JAHR = ".$jahrneu."")
								  ->execute();
				}
		}
				
	
	
	
	else {
			if($tage_vorjahr > 0){
				$wert = $tage_vorjahr - $ben_tage;
				if($wert >= 0){
					// $wert als neuen Urlaubsstand in die Tabelle des vorherigen Jahres eintragen (in U12 des vorherigen Jahres)
					#####  Alternative: Wert zum aktuellen Urlaub dazurechnen.. So ist allerdings das Sammeln von Urlaubstagen über 
					#####  Jahre hinweg möglich und zwischen Resturlaub und aktuellem Urlaub nichtmehr zu unterscheiden. 
					#####  Momentaner Stand: Verfall des Resturlaubs nach einem Jahr
					Yii::$app->db->CreateCommand("UPDATE m3_urlaub_stunden		
								  SET U12 = (".$wert.")  
								  FROM m3_urlaub_stunden
								  WHERE WORKID = ".$workid." AND JAHR = ".$jahralt."")
								  ->execute();					
				}
				else {
					// Prüfen ob aktuelles Jahr als Datensatz angelegt ist
					// Restwert vom Urlaubsstand des aktuellen Jahres abziehen und eintragen 
					// Alten Urlaubs-Restbestand (U12) nullen
					Yii::$app->db->CreateCommand("UPDATE m3_urlaub_stunden		
								  SET U12 = (0)
								  FROM m3_urlaub_stunden
								  WHERE WORKID = ".$workid." AND JAHR = ".$jahralt."")
								  ->execute();
				
				
					// $wert ist negativ, deswegen zu $varU addieren
					Yii::$app->db->CreateCommand("UPDATE m3_urlaub_stunden		
								  SET ".$varU." = (".$varU." + ".$wert.")  
								  FROM m3_urlaub_stunden
								  WHERE WORKID = ".$workid." AND JAHR = ".$jahr."")
								  ->execute();
				
				}

			}
			else {
				if($tage_aktjahr < $ben_tage){
					// Prüfen ob aktuelles Jahr als Datensatz angelegt ist
					// Rückgabe einer Fehlermeldung da nichtmehr genügend Urlaubstage des aktuellen Jahres vorhanden sind
					return false;
					
					
				}
				else{
					$wert = $tage_aktjahr - $ben_tage;
					// Prüfen ob aktuelles Jahr als Datensatz angelegt ist
					// Eintragen des $wert als aktuellen Urlaubsstand des aktuellen Jahres
					Yii::$app->db->CreateCommand("UPDATE m3_urlaub_stunden		
								  SET ".$varU." = (".$wert.")  
								  FROM m3_urlaub_stunden
								  WHERE WORKID = ".$workid." AND JAHR = ".$jahr."")
								  ->execute();
				}	
			
			}
	}
		
		
		

		
		
		
######  Notiz an Stunden Alg.: 
######	Von aktuellem Jahr abhängig machen ob Stunden vom vorherigen Jahr übernommen werden oder nicht. 
######  => Stunden aus dem Vorjahr erst übernehmen wenn neues Jahr eingeleitet, da auch noch unter dem Jahr neue Stunden generiert werden können. 
###### 	Evtl mit Einlogg-Log. o.Ä. abfragen, damit die Stunden nicht erst mit dem nächsten Urlaubsantrag übernommen werden. 

######  Alternative: Stunden immer auf aktuellem und Vorjahr abfragen. (ggfs doch immer auf S1 des Folgejahres portieren und bei Abfrage addieren)


######  Möglichkeit 3: Da man Überstunden durchaus über Jahre hinweg sammeln kann muss über die letzten Jahre abgefragt werden. 
######  Vom niedrigsten Jahr werden verbrauchte Überstunden abgezogen. So muss nicht ständig das Überstundenkonto zu einem gewissen Zeitpunkt
######  mit in das neue Jahr übertragen werden sondern verbleibt jeweils bei S12 und wird auf Abfrage zusammenaddiert. 


######  Kompromiss: Wenn "neues Jahr" => Dann bei erstem eigehenden Urlaubsantrag in diesem Jahr (CDATE) Übernahme der Stunden aus dem Vorjahr
######  auf das Konto des neuen Jahres. Vorher wird bei Abfrage des Status immer das Vorjahr mitgezählt. (Falls besagter Urlaubsantrag erst im 
######  März o.Ä. eintrifft können im Jan / Feb schon wieder Überstunden angefallen sein die mitgezählt werden müssen) 




	
	// Überprüfen ob Datensatz vorhanden und
	// Anlegen eines neuen Datensatzes in m3_urlaub_stunden für das neue Jahr. 
	
####### 05.04. $jahrneu ist noch schlicht auf das aktuelle Jahr +1 ausgelegt 
#######		   => Abfrage um welches Jahr es in dem Urlaubsantrag geht -> Abzug von Resturlaub des aktuellen Jahres bzw Vorjahres
#######			  -> Abzug von Urlaub des Folgejahres falls Urlaubsantrag in diesem stattfindet und aktueller Urlaub gleich 0 
#######			  -> Bei Bedarf anlegen eines neuen Datensatzes
#######           -> Falls Urlaubszeitraum in aktuellen Jahr und Urlaubstagebestand = 0 -> Abbruch / Warnung


// Stundenabrechnung
// Vorraussetzung, dass die Stunden vom Vorjahr übertragen werden ist, dass der Mitarbeiter min. einmal pro Jahr Urlaub einträgt... 
// Ansonsten manuelle Nachbesserung 


	$wert = $stunden_aktjahr + $stunden_vorjahr - ($ben_stunden * 8);
	
	Yii::$app->db->CreateCommand("UPDATE m3_urlaub_stunden
				 				 SET ".$varS." = (".$wert.")
				 				 FROM m3_urlaub_stunden 
				 				 WHERE WORKID = ".$workid." AND JAHR = ".$jahr."")
				 ->execute();
	
	Yii::$app->db->CreateCommand("UPDATE m3_urlaub_stunden 
								  SET S12 = (0)
								  FROM m3_urlaub_stunden
								  WHERE WORKID = ".$workid." AND JAHR = ".$jahralt."")
				 ->execute();
	


return true; 	
}

	
?>