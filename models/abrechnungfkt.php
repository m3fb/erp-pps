<?php
function abrechnungfkt($workid,$monat,$jahr,$saldo) {
	
	
	$saldo = $saldo; // Übergebener Wert an Überstunden aus Urlaub-Modell bzw Monatsdatenfkt
	$workid = $workid;
	
	$jahr = $jahr;
	$jahrneu = date("Y")+1;   // Wird im Alg. verwendet 
	$jahralt = date("Y")-1;  // Wird im Alg. verwendet
	$abrjahr = date("Y");

	######
	$monat = $monat;
	$vormonat = $monat -1;// <===
	
	if($monat == 0){ 
		return 0;
		$monat = 1;
		$abrjahr = $jahralt;
		}
	
	if($vormonat == 0){
		$vormonat = 12; 
		$abrjahr = $jahralt;
		}
	
	// if($vormonat == -1){
		// $vormonat = 11;
		// }
	$varS = "S".$monat; 
	$varU = "U".$monat;
	$varSV = "S".$vormonat;
	$varUV = "U".$vormonat;

	######
	// Prüfung ob aktuelles und nächstes Jahr vorhanden: 
	// Die Stunden werden nicht übernommen. Dies geschieht im Alg. der Stundenauswertung
	
	Yii::$app->db->CreateCommand (" 
	IF NOT EXISTS(SELECT * FROM m3_urlaub_stunden
				   WHERE JAHR = ".$jahr." AND WORKID = ".$workid.")

	BEGIN
	INSERT INTO m3_urlaub_stunden (
				   [WORKID]
				  ,[JAHR]
				  ,[".$varU."]
							  )
							  								  
				   SELECT ".$workid.", ".$jahr.", FAG_DETAIL.VAL01
				   FROM FAG_DETAIL 
				   WHERE FKNO = ".$workid."
	END

	
	IF NOT EXISTS(SELECT * FROM m3_urlaub_stunden
				   WHERE JAHR = ".$jahrneu." AND WORKID = ".$workid.")

	BEGIN
	INSERT INTO m3_urlaub_stunden (
				   [WORKID]
				  ,[JAHR]
				  ,[U1]
							  )
							  								  
				   SELECT ".$workid.", ".$jahrneu.", FAG_DETAIL.VAL01
				   FROM FAG_DETAIL
				   WHERE FKNO = ".$workid."
	END
				")
	->execute();
	
	
	
	

	// Übertragen des Monatswertes: 
	
	Yii::$app->db->CreateCommand ("
	IF ".$abrjahr." = ".$jahr."
	BEGIN
		UPDATE A 
				SET A.[".$varU."] = (B.[".$varUV."] + A.[".$varU."]),
					A.[".$varS."] = (B.[".$varSV."] + A.[".$varS."]) + ".$saldo."
					
					
				FROM m3_urlaub_stunden AS A
				INNER JOIN m3_urlaub_stunden AS B
				ON A.WORKID = B.WORKID
				WHERE A.JAHR = ".$jahr." AND B.JAHR = ".$abrjahr." AND A.WORKID = ".$workid."




	END
	ELSE
	BEGIN
		UPDATE m3_urlaub_stunden
				 SET [".$varU."] = ([".$varUV."] + [".$varU."]),
					 [".$varS."] = ([".$varSV."] + [".$varS."]) + ".$saldo."
					
				 FROM m3_urlaub_stunden 
				 
				 WHERE WORKID = ".$workid." AND JAHR = ".$jahr."		
	END
	")
	->execute();
	
	

	
	
	
	
	
	
	
	
	
	return true;
	
	
	
}
?>