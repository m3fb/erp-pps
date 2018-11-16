<?php 
 
function istsf($pnr,$datum){
	

// Tag in welcher KW?
$kw = date("W",strtotime($datum));
// Welcher Wochentag? 
$y = date("N",strtotime($datum));
switch($y) {
	case 1: 
	$x = "MO";
	break;  
	case 2:
	$x = "DI";
	break;
	case 3: 
	$x = "MI";
	break;
	case 4: 
	$x = "DO";
	break;
	case 5: 
	$x = "FR";
	break;
	case 6: 
	$x = "SA";
	break;
	case 7:
	$x = "SO";
	break;
	default: 
	break;
}
	

$tables = Yii::$app->db->createCommand(" 
	Select ".$x."_FRUEH as FRUEH,
		  ".$x."_SPAET as SPAET,
		  ".$x."_NACHT as NACHT


	   FROM   m3_schichtplanung WHERE KW=".$kw."
	")
	->queryAll();

	
$i = 0;	
if(!$tables[0]){
	return 0;
}
$frueh = "";
$spaet = "";
$nacht = "";

$liste_fr = explode(',',$tables[0]['FRUEH']);
if($liste_fr){
foreach($liste_fr as $type){
	if(strpos($liste_fr[$i], '(SF)')===false){
$i++;
	}
	else{
	$frueh = str_replace(' (SF)','',$liste_fr[$i]);
	}
}
}
$i = 0;	
$liste_sp = explode(',',$tables[0]['SPAET']);
if($liste_sp){
foreach($liste_sp as $type){
	if(strpos($liste_sp[$i], '(SF)')===false){
$i++;
	}
	else{
	$spaet = str_replace(' (SF)','',$liste_sp[$i]);
	}
}
}
$i = 0;	
$liste_na = explode(',',$tables[0]['NACHT']);
if($liste_na){
foreach($liste_na as $type){
	if(strpos($liste_na[$i], '(SF)')===false){
$i++;
	}
	else{
	$nacht = str_replace(' (SF)','',$liste_na[$i]);
	}
}	
}

$name = Yii::$app->db->CreateCommand("
	SELECT FIRSTNAME + ' ' + SURNAME as name
	FROM PE_WORK WHERE PERSNO = ".$pnr."
	")
	->queryOne();
// ist SF
if($name['name'] == $frueh || $name['name'] == $spaet || $name['name'] == $nacht){
	return 1; 
} 
// ist nicht SF
else {
	return 0;
}
}

?>