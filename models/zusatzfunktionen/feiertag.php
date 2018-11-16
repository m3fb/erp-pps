<?php 
function istfrei2($termin) {
		
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

    // Prüfen, ob Sontag
	// Version "Abrechnung"
    if($wochentag == 0) {
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
	$feiertage[] = "3110";
	
    // Bewegliche Feiertage berechnen  (Oster-/Pfingstsontag wird schon durch Prüfung Wochenende abgedeckt)
    $tage = 60 * 60 * 24;
    $ostersonntag = easter_date($jahr);
    $feiertage[] = date("dm", $ostersonntag - 2 * $tage);  // Karfreitagzzz
    $feiertage[] = date("dm", $ostersonntag + 1 * $tage);  // Ostermontag
    $feiertage[] = date("dm", $ostersonntag + 39 * $tage); // Himmelfahrt
    $feiertage[] = date("dm", $ostersonntag + 50 * $tage); // Pfingstmontag
    $feiertage[] = date("dm", $ostersonntag + 60 * $tage); // Fronleichnam

    // Prüfen, ob Feiertag
    $code = $tag.$monat;
    return in_array($code, $feiertage);  
	}	

	
?>