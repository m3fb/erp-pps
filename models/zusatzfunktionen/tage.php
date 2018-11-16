<?php
function tage($pnr,$start,$ende){		
	
	
	
	
	
	
	// Zum Start bzw Endtermin werden jeweils 5 Wochen subtrahiert / addiert um einen größeren Zeitrahmen abzudecken in denen Start- und Endtermine fallen können.
	$startneu = date ("Y-d-m",strtotime($start."-15 week"));
	$endeneu = date ("Y-d-m",strtotime($ende."+15 week"));	
	$start = date("Y-d-m",strtotime($start));
	$ende = date("Y-d-m",strtotime($ende."+1 day"));
	
	
	$tables = Yii::$app->db->createCommand("WITH CTE AS
  (SELECT DISTINCT A.WORKID as FKNO,A.LBNO, A.STATUS, A.PERSNO AS PERSNO, A.MSTIME, A.MSTIME AS Datum,
                   DATEDIFF(dd,A.MSTIME,B.MSTIME) AS diff
   FROM m3_urlaubsplanung A
   INNER JOIN m3_urlaubsplanung B
   ON A.LBNO = B.LBNO -1 
   WHERE  (((A.STATUS = 800 AND (A.MSTIME BETWEEN '".$startneu."' AND '".$endeneu."') AND B.STATUS = 801)
   AND	  (B.STATUS = 801 AND (B.MSTIME BETWEEN '".$startneu."' AND '".$endeneu."') AND A.STATUS = 800))
   OR 	  ((A.STATUS = 802 AND (A.MSTIME BETWEEN '".$startneu."' AND '".$endeneu."') AND B.STATUS = 803)
   AND	  (B.STATUS = 803 AND (B.MSTIME BETWEEN '".$startneu."' AND '".$endeneu."') AND A.STATUS = 802))
   OR 	  ((A.STATUS = 804 AND (A.MSTIME BETWEEN '".$startneu."' AND '".$endeneu."') AND B.STATUS = 805)
   AND	  (B.STATUS = 805 AND (B.MSTIME BETWEEN '".$startneu."' AND '".$endeneu."') AND A.STATUS = 804))
   OR     ((A.STATUS = 806 AND (A.MSTIME BETWEEN '".$startneu."' AND '".$endeneu."') AND B.STATUS = 807)
   AND	  (B.STATUS = 807 AND (B.MSTIME BETWEEN '".$startneu."' AND '".$endeneu."') AND A.STATUS = 806)))
   AND 	   (A.BEST = 1 AND B.BEST = 1)
   AND A.PERSNO = ".$pnr."
 
   
   
   
   UNION ALL SELECT FKNO, A.LBNO as LBNO, A.STATUS as STATUS, A.PERSNO as PERSNO, A.MSTIME as MSTIME, Datum,
                    diff - 1 AS diff
   FROM CTE
   INNER JOIN m3_urlaubsplanung A
   ON A.LBNO = CTE.LBNO
   WHERE diff > 0)
   
SELECT username,firstname,surename,PNR,Datum,STATUS FROM (
SELECT DISTINCT [user].username as username,[user].firstname as firstname,[user].surename as surename, CTE.FKNO, LBNO, CTE.STATUS, CTE.PERSNO as PNR, MSTIME, DateAdd(dd,diff, Datum) AS Datum 
FROM CTE 
RIGHT JOIN [user] 
ON FKNO = [user].pe_work_id
LEFT JOIN FAG_DETAIL
ON [user].pe_work_id = FAG_DETAIL.FKNO)TE
WHERE PNR = ".$pnr."
AND DATUM  BETWEEN '".$start."' AND  '".$ende."' 
GROUP BY username,firstname,surename,PNR,Datum,STATUS

")
		->queryAll();	
		
		
return $tables;
	
## Aufhebung der Ergebnisgrenzen. Achtung!!: Hohe Systemauslastung möglich!!
//option(maxrecursion 0)
	
		
	}
?>