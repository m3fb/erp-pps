<?php
function tage_betriebsurlaub($pnr,$start,$ende){		
	// $pnr/$abt = 0  => Alle
	
	
	
	
	
	// Zum Start bzw Endtermin werden jeweils 5 Wochen subtrahiert / addiert um einen größeren Zeitrahmen abzudecken in denen Start- und Endtermine fallen können.
	$startneu = date ("Y-d-m",strtotime($start."-5 week"));
	$endeneu = date ("Y-d-m",strtotime($ende."+5 week"));	
	$start = date("Y-d-m",strtotime($start));
	$ende = date("Y-d-m",strtotime($ende."+1 day"));
	// "SF" wird ebenfalls abgefragt
	### In der Query sind zwei Ausdrücke markiert, die beim Umzug auf vom Test- auf das richtige System (Cut der Urlaubsanträge und diesbezügl. richtige 
	### Formatierung vorausgesetzt) wegfallen können. (Potenzielle Fehlerquelle)
	$tables = Yii::$app->db->createCommand("WITH CTE AS
  (SELECT DISTINCT A.WORKID as FKNO,A.LBNO, A.STATUS, A.PERSNO AS PERSNO, A.MSTIME, A.MSTIME AS Datum,
                   DATEDIFF(dd,A.MSTIME,B.MSTIME) AS diff
   FROM m3_urlaubsplanung A
   INNER JOIN m3_urlaubsplanung B
   ON A.LBNO = B.LBNO -1 
   WHERE  (((A.STATUS = 800 AND (A.MSTIME BETWEEN '".$startneu."' AND '".$endeneu."') AND B.STATUS = 801)-- Achtung: letzter Ausdruck nur während Testphase!
   AND	  (B.STATUS = 801 AND (B.MSTIME BETWEEN '".$startneu."' AND '".$endeneu."') AND A.STATUS = 800)))-- Achtung: letzter Ausdruck nur während Testphase!
   AND 	   (A.BEST = 1 AND B.BEST = 1)
   AND A.PERSNO = ".$pnr."
 
   
   
   
   UNION ALL SELECT FKNO, A.LBNO as LBNO, A.STATUS as STATUS, A.PERSNO as PERSNO, A.MSTIME as MSTIME, Datum,
                    diff - 1 AS diff
   FROM CTE
   INNER JOIN m3_urlaubsplanung A
   ON A.LBNO = CTE.LBNO
   WHERE diff > 0)
   
SELECT Datum FROM (
SELECT DISTINCT CTE.PERSNO as PNR, MSTIME, DateAdd(dd,diff, Datum) AS Datum 
FROM CTE)TE
WHERE PNR = ".$pnr."
AND DATUM  BETWEEN '".$start."' AND  '".$ende."' 
GROUP BY PNR,Datum
")
		->queryAll();	
		
		
return $tables;
	
//option(maxrecursion 0)
	
		
	}
?>