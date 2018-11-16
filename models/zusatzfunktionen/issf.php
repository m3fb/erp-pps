<?php 

function istsf($pnr,$datum){
	
// Datum in welcher KW? 

// Wochentag

$kw = 13; 
$x = "MO";

$tables = Yii::$app->db->createCommand(" 
	SELECT dbo.Wordparser(".$x."_FRUEH, 1) as ".$x."_FRUEH, 
	   dbo.Wordparser(".$x."_FRUEH, 2) as ".$x."_FRUEH,
	   dbo.Wordparser(".$x."_FRUEH, 3) as ".$x."_FRUEH,
	   dbo.Wordparser(".$x."_FRUEH, 4) as ".$x."_FRUEH,
	   dbo.Wordparser(".$x."_FRUEH, 5) as ".$x."_FRUEH,
	   dbo.Wordparser(".$x."_FRUEH, 6) as ".$x."_FRUEH,
	   dbo.Wordparser(".$x."_FRUEH, 7) as ".$x."_FRUEH,
	   dbo.Wordparser(".$x."_FRUEH, 8) as ".$x."_FRUEH,
	   dbo.Wordparser(".$x."_FRUEH, 9) as ".$x."_FRUEH,
	   dbo.Wordparser(".$x."_FRUEH, 10) as ".$x."_FRUEH,
       dbo.Wordparser(".$x."_SPAET, 1) as ".$x."_SPAET,
	   dbo.Wordparser(".$x."_SPAET, 2) as ".$x."_SPAET,
	   dbo.Wordparser(".$x."_SPAET, 3) as ".$x."_SPAET,
	   dbo.Wordparser(".$x."_SPAET, 4) as ".$x."_SPAET,
	   dbo.Wordparser(".$x."_SPAET, 5) as ".$x."_SPAET,
	   dbo.Wordparser(".$x."_SPAET, 6) as ".$x."_SPAET,
	   dbo.Wordparser(".$x."_SPAET, 7) as ".$x."_SPAET,
	   dbo.Wordparser(".$x."_SPAET, 8) as ".$x."_SPAET,
	   dbo.Wordparser(".$x."_SPAET, 9) as ".$x."_SPAET,
	   dbo.Wordparser(".$x."_SPAET, 10) as ".$x."_SPAET,
       dbo.Wordparser(".$x."_NACHT, 1) as ".$x."_NACHT,
	   dbo.Wordparser(".$x."_NACHT, 2) as ".$x."_NACHT,
	   dbo.Wordparser(".$x."_NACHT, 3) as ".$x."_NACHT,
	   dbo.Wordparser(".$x."_NACHT, 4) as ".$x."_NACHT,
	   dbo.Wordparser(".$x."_NACHT, 5) as ".$x."_NACHT,
	   dbo.Wordparser(".$x."_NACHT, 6) as ".$x."_NACHT,
	   dbo.Wordparser(".$x."_NACHT, 7) as ".$x."_NACHT,
	   dbo.Wordparser(".$x."_NACHT, 8) as ".$x."_NACHT,
	   dbo.Wordparser(".$x."_NACHT, 9) as ".$x."_NACHT,
	   dbo.Wordparser(".$x."_NACHT, 10) as ".$x."_NACHT

	   FROM   m3_schichtplanung WHERE KW=".$kw."
	")
	->queryAll();
	
$key_frueh = array_search("(SF)", array_column($tables, 'MO_FRUEH'));	

echo "Früh: " . $key_frueh;
return $key_frueh; 
// Am Komma ausplitten und abfragen in welcher Spalte (SF) steht. 


// Schicht und Tag rausfinden. 
	
	
#geplanter Rückgabewert:
#für den jeweiligen Tag die PNR-Nr aller drei eingetragenen Schichtführer als Array. 
}

?>