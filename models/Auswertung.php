<?php

namespace app\models;


use Yii;

class Auswertung extends \yii\db\ActiveRecord
{
    
    
    public $start;
    public $ende;
    public $auftragsnr;
    public $werkzeugnr;
    public $input_lgnr;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'LB_DC';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['LBNO', 'ORNO', 'TSTAMP'], 'required'],
            [['LBNO', 'OPNO', 'OPOPNO', 'ORNO', 'OUT', 'ADCCOUNT', 'ADCSTAT', 'APARTS', 'ARCHIVE', 'ATE', 'ATP', 'ATR', 'BPARTS', 'BPARTS2', 'CALTYP', 'ERRNUM', 'EXSTAT', 'FKLBNO', 'FNPK', 'GPARTS', 'INPARTSDBL', 'ISINTERNAL', 'MSGID', 'MTIME0', 'MTIME1', 'MTIME2', 'MTIME3', 'OPMULTIMESSAGEGROUP', 'PERSNO', 'STATUS', 'WPLACE', 'MATCOST', 'MANDANTNO'], 'number'],
            [['NAME', 'ORNAME', 'ADCMESS', 'ADCWORK', 'DESCR', 'MSINFO', 'PERSNAME', 'TERMINAL', 'CNAME', 'CHNAME'], 'string'],
            [['MSTIME', 'CDATE', 'CHDATE', 'TSTAMP'], 'safe'],
        ];
    }
    
    


public function get_linie ($ip){
    $linie = "";
    $rueck = $_SERVER['REMOTE_ADDR'];
    ### Absatz in der SQL Abfrage weil irgendein Sonderzeichen im String enthalten ist (Problem: IP Adresse 192.168.1.79 der Linie 8 wurde nicht erkannt
    $linie = Yii::$app->db->CreateCommand(" 
        SELECT TOP 1 * FROM m3_pilog WHERE IP LIKE '%".$ip."%
' ORDER BY ID DESC
    ")
    ->queryAll();
    foreach($linie as $lin){
        $rueck = $lin['LINIE'];
    }
    # $test = "Linie 13";
    return $rueck;
}


public function pruef_unterbrechung($linie){
    #$fehler = array();
    #$fehler[0] = array();
    ## Alternative: Auf Endzeit is NULL abfragen => möglicherweise aber fehleranfälliger. 
    
    
    $fehler = Yii::$app->db->CreateCommand("
        SELECT TOP 1 m3_bde.ID,STARTZEIT,ENDZEIT,BEZEICHNUNG,GRUND,LINIE FROM m3_bde LEFT JOIN m3_bezeichnungen ON m3_bde.GRUND = m3_bezeichnungen.REFNR WHERE LINIE LIKE '%".$linie."%' 
        ORDER BY ID DESC
    ")
    ->queryAll();
    
    foreach($fehler as $type){
        if(!$type['ENDZEIT'] || !$type['GRUND']){            
           # echo "<script>alert('hier');</script>";
           # $fehler[0]['GRUND'] = 100;
           if($type['STARTZEIT'])
               $fehler[0]['STARTZEIT'] = date("d.m. H:i",strtotime($type['STARTZEIT']));
           if($type['ENDZEIT'])
               $fehler[0]['ENDZEIT'] = date("d.m. H:i",strtotime($type['ENDZEIT']));
           
            return $fehler;
            
        }
        else{
           
            #echo "<script>alert('ho');</script>";
              #$fehler[0]['GRUND'] = 109;
            return 0;
        }
    }
    
}
    
    
public function schreib_unterbrechung($linie){
    
    $start = date("Y-d-m H:i:s", strtotime('now'));
    
    // $fehler = Yii::$app->db->CreateCommand("
        // SELECT TOP 1 ID,STARTZEIT,ENDZEIT,GRUND FROM m3_bde WHERE LINIE LIKE '".$linie."' 
        // ORDER BY ID DESC
    // ")
    // ->queryAll();
     // foreach($fehler as $type){
        // if(!$type['ENDZEIT'] || !$type['GRUND']){            
            // return $id;
        // }
        // else{
           
            Yii::$app->db->CreateCommand("
                INSERT INTO m3_bde (
                        STARTZEIT,
                        LINIE
                        )
                        VALUES (
                        '".$start."',
                        '".$linie."'
                        )
                ")
            ->execute();
            
            $id = Yii::$app->db->CreateCommand("
                    
                SELECT TOP 1(ID) FROM m3_bde 
                    WHERE LINIE LIKE '".$linie."' ORDER BY ID DESC
                ")
            ->queryOne();
            
            return $id['ID'];
        // }
    // }
    
    
   
}
    
public function bez_unterbrechung($id,$pnr,$grund){
        
    Yii::$app->db->CreateCommand("
        UPDATE m3_bde SET 
            PERSNO = ".$pnr.",
            GRUND = ".$grund."
        WHERE ID = ".$id." 
        
        UPDATE m3_streckenlog SET
            UNT_GRUND = ".$grund."
        WHERE UNT_ID = ".$id."
     ")
    ->execute();
    
    $rueck = "";
    if($grund == 100)
        $rueck = "geplante Unterbrechung";
    else if($grund == 101)
        $rueck = "Abriss";
    else if($grund == 102)
        $rueck = "Sensor defekt";
    else if($grund == 103)
        $rueck = "Qualitätsproblem";
    else if($grund == 104) 
        $rueck = "Bedienpersonal";
    else if($grund == 105) 
        $rueck = "Wartung / Reinigung"; 
    
    
    return $rueck;
}


    
public function beende_unterbrechung($id){
        
    $ende = date("Y-d-m H:i:s",strtotime('now'));    
        
    Yii::$app->db->CreateCommand("
        UPDATE m3_bde SET 
            ENDZEIT = '".$ende."' 
            
        WHERE ID = ".$id."
     ")
    ->execute();
    
    return 1;
}

    
    
public function pilog(){
    
    $tables = Yii::$app->db->CreateCommand("
            SELECT DISTINCT t1.[ID]
              ,t1.[MSTIME]
              ,t1.[LINIE]
              ,t1.[TEMP]
              ,t1.[UPTIME]
              ,t1.[REBOOT]
              ,t1.[RAM]
              ,t1.[IP]
            FROM m3_pilog t1
            JOIN (SELECT MAX(MSTIME) MSLETZT, LINIE
                  FROM m3_pilog
                 GROUP BY LINIE) t2
            ON t1.MSTIME = t2.MSLETZT WHERE t1.LINIE LIKE 'Linie%' ORDER BY LINIE
            ")
  ->queryAll();
    
    
      
    $strecken = Yii::$app->db->CreateCommand("
        SELECT 
           t1.[MSTIME] 
          ,t1.[GESCHWINDIGKEIT]
          ,t1.[STRECKE]
          ,t1.[AUFTRAG]
          ,t1.[LINIE]
        FROM m3_streckenlog t1
        JOIN (SELECT MAX(MSTIME) MSLETZT, LINIE
              FROM m3_streckenlog
             GROUP BY LINIE) t2
        ON t1.MSTIME = t2.MSLETZT ORDER BY LINIE
        ")
    ->queryAll();
    
    
    $i = 0;
    foreach($tables as $type){
        $rueck[$i]['GESCHWINDIGKEIT'] =  round($strecken[$i]['GESCHWINDIGKEIT'],2);
        $rueck[$i]['STRECKE'] = round($strecken[$i]['STRECKE'],2);
        $rueck[$i]['AUFTRAG'] = $strecken[$i]['AUFTRAG'];
        $rueck[$i]['MSLETZT'] =  date("d.m.Y H:i:s",strtotime($strecken[$i]['MSTIME']));
        $rueck[$i]['MSTIME'] = date("d.m.Y H:i:s",strtotime($type['MSTIME']));
        $rueck[$i]['LINIE'] = $type['LINIE'];
        $rueck[$i]['TEMP'] = round($type['TEMP'],2);
        $rueck[$i]['UPTIME'] = $type['UPTIME'];
        $rueck[$i]['REBOOT'] = $type['REBOOT'];
        $rueck[$i]['RAM'] = $type['RAM'];
        $rueck[$i]['IP'] = $type['IP'];
        
        
        
        $akt = strtotime('now') - strtotime($rueck[$i]['MSLETZT']);
        if($akt < 120)
            $rueck[$i]['AKTUELL'] = "green";
        else if ($akt > 180) 
            $rueck[$i]['AKTUELL'] = "red";
        else
             $rueck[$i]['AKTUELL'] = "yellow";
         
        $i++;
    }
        
    
    return $rueck;
}
    
    
    
    
    
    
    
    
    
    
public function artnr($artnr,$werkzeug,$start,$ende) {     
        
    $start_datum = date("Y-d-m 00:00:00", strtotime($start));
    $end_datum = date("Y-d-m 23:59:59", strtotime($ende));

    $sql = "";
    $sql_zeit = "";
    
    if($werkzeug)
        $sql = "COMMNO LIKE '".$werkzeug."' ";
    if($artnr)
        $sql = "IDENT LIKE '".$artnr."' ";
    if($start && !$ende)
        $sql_zeit = "AND CDATE > '".$start_datum."' ";
    if($start && $ende)
        $sql_zeit = "AND CDATE BETWEEN '".$start_datum."' AND '".$end_datum."' ";
    
    
    $auftraege = Yii::$app->db->createCommand("SELECT * FROM OR_ORDER WHERE ".$sql." ".$sql_zeit." ")
    ->queryAll();

    if(!$auftraege)
        $auftraege[0] = "Keine Aufträge vorhanden";

    return $auftraege; 
}

    
public function linie_such($linie) {     
        
   
    $datum = date("Y-d-m H:i:s", strtotime('now - 2 month'));
    $auftraege = Yii::$app->db->createCommand(" SELECT DISTINCT LB_DC.ORNAME as ORNAME,OR_ORDER.DESCR as DESCR, convert(varchar, OR_ORDER.CDATE, 104) as CDATE, OR_ORDER.COMMNO as COMMNO, OR_ORDER.IDENT as IDENT FROM LB_DC 
                                                INNER JOIN OR_ORDER 
                                                ON LB_DC.ORNO = OR_ORDER.NO WHERE LB_DC.MSINFO LIKE '".$linie."' AND LB_DC.MSTIME > '".$datum."' ")
    ->queryAll();

    if(!$auftraege)
        $auftraege[0] = "Keine Aufträge vorhanden";

    return $auftraege; 
}



public function auftrag($orno,$lgnr,$artnr) {
$abfrage = "";
if($orno)   
    $abfrage = "LB_DC.ORNO = ".$orno;
else if($lgnr) 
    $abfrage = "LB_DC.ORNAME LIKE '".$lgnr."'";
else if($artnr) 
    $abfrage = "OR_ORDER.IDENT LIKE '".$artnr."'";
else {
    $rueck[0] = 0;
    $rueck[1] = "Keine Daten / Nichts gefunden";
    return $rueck;
}
   

#### auftrag
$op = Yii::$app->db->createCommand("SELECT OR_OP.PPARTS as PPARTS, OR_OP.PTE as PTE, OR_OP.PTR as PTR, OR_OP.DESCR as DESCR,
                                    LB_DC.MSTIME as MSTIME, LB_DC.STATUS as STATUS, LB_DC.ADCCOUNT as ADCCOUNT, LB_DC.MSINFO as MSINFO, LB_DC.ORNAME as ORNAME, LB_DC.NAME as NAME,LB_DC.ORNO,
                                    OR_ORDER.STATUS as STATUS2, OR_ORDER.DELIVERY as DELIVERY, OR_ORDER.COMMNO as COMMNO, OR_ORDER.INFO2 as INFO2, OR_ORDER.DESCR as ORDER_DESCR, OR_ORDER.IDENT as IDENT,
                                    PA_ARTPOS.AEINH2 as AEINH2
                                    FROM LB_DC 
                                    RIGHT JOIN OR_ORDER ON LB_DC.ORNO = OR_ORDER.NO 
                                    RIGHT JOIN OR_OP ON LB_DC.ORNO = OR_OP.ORNO 
                                    RIGHT JOIN PA_ARTPOS ON OR_ORDER.IDENT = PA_ARTPOS.ARTDESC
                                    WHERE ".$abfrage." AND OR_OP.NAME = 20
                                    ")
->queryAll();    
$pt = Yii::$app->db->CreateCommand("SELECT PTR FROM OR_OP WHERE NAME = 10 AND ORNO = ".$orno."")
->queryOne();
 
     
$i = 0;
$n = 0;  ### Die Arbeitsschritte werden ab $rueck[2] aufgelistet
$c = 0;
$merk_ruest = 0; ## Um im 0er Teil zu informieren ob eine Rüstzeit dabei ist oder nicht
$merk_anfahr = 0; ## Falls Anfahrzeit zählt nur die erste => Merker wird gesetzt (doppelte Funktion gegenüber Rüstmerker)
$merk_strecke = 0; ## Um den Ersten Wert nach der Endzeit eines Eintrages einzufangen (Strecke)
foreach($op as $or){
    ### Es wird hier bereits die End- u. Startzeit definiert (letzter Eintrag beschreibt)  um die richtigen Streckendaten rechtzeitig auslesen zu können (nächster Schritt) 
    ### Außerdem für die Graphenauswertung
    if($i == 0)
        $rueck[0]['auftrag_startzeit'] = strtotime($or['MSTIME']);
    
    $rueck[0]['auftrag_endzeit'] = strtotime($or['MSTIME']);    
    $i++;
}

### Falls noch keine Unterbrechung gestempelt wurde:  (Und $i hochgezählt == Stempelungen vorhanden)
if($i){
    if(($rueck[0]['auftrag_startzeit'] == $rueck[0]['auftrag_endzeit']))
        $rueck[0]['auftrag_endzeit'] = strtotime("now");
}

 try{      
### Erst auf 0 setzen, wird ggfs noch geändert im weiteren Verlauf
$rueck[0]['merk_ruest'] = 0;
$rueck[0]['merk_anfahr'] = 0;
$rueck[0]['merk_abruest'] = 0;

   
foreach($op as $or){
  
    ### Die Eckdaten des Auftrags werden im 0er Teil des Arrays gespeichert, danach folgt die chronologische Auflistung der Arbeitsschritte
    if($n==0){
        $rueck[0]['linie'] = $or['MSINFO'];
        $rueck[0]['werkzeug'] = $or['COMMNO'];
        $rueck[0]['liefertermin'] = $or['DELIVERY'];
        $rueck[0]['einzeldauer'] = $or['PTE'];
        $rueck[0]['menge'] = $or['PPARTS'];
        $rueck[0]['gepl_produktions_dauer'] = $or['PTE'] * $or['PPARTS'];
        $rueck[0]['auftrag_status'] = $or['STATUS2']; 
        $rueck[0]['auftrag'] = $or['ORNAME'];
        $rueck[0]['teile_zaehler'] = 0;
        $rueck[0]['bezeichnung'] = $or['ORDER_DESCR'];
        $rueck[0]['art_no'] = $or['IDENT'];
        $rueck[0]['pte'] = $or['PTE'];
        $rueck[0]['orno'] = $orno;
        
        
        // Ergänzung 13.11.2017: Fehlerprävention:
        $rueck[0]['ruestzeit'] = 0;
        $rueck[0]['gepl_ruestzeit'] = 0;
        $rueck[0]['anfahrzeit'] = 0;
        $rueck[0]['gepl_anfahrzeit'] = 0;
        
        
        $rueck[0]['produktions_zeit'] = 0;
        $rueck[0]['mess_strecke_start'] = 0;
        $rueck[0]['mess_strecke_ende'] = 0;
        $rueck[0]['messdaten_check'] = 0;
        // Länge:
        if($or['INFO2'] && is_numeric ($or['INFO2'])){
            $rueck[0]['laenge'] = $or['INFO2'];
        }
        else{
            $rueck[0]['laenge'] = $or['AEINH2'];
        }
        $rueck[0]['gesamt_laenge'] = ($or['PPARTS'] * $rueck[0]['laenge']) / 1000;
        $rueck[0]['gepl_geschwindigkeit'] = $rueck[0]['gesamt_laenge'] / $rueck[0]['gepl_produktions_dauer'] * 60;
        $rueck[0]['vdurchschnitt'] = 0; 

        
        
        ###
        ### Holen der Streckendaten!
            #$zeitlog = Yii::$app->db->createCommand(" SELECT * FROM m3_streckenlog WHERE MSTIME > '".date("Y.d.m H:i:s",$rueck[0]['auftrag_startzeit']-62)."' AND MSTIME < '". date("Y.d.m H:i:s",$rueck[0]['auftrag_endzeit']+62) . "' AND LINIE LIKE '".$rueck[0]['linie']."'")
            #->queryAll();
        $zeitlog = Yii::$app->db->createCommand(" SELECT * FROM m3_streckenlog WHERE AUFTRAG = ".$orno."")
        ->queryAll();
        $k = 0;
        foreach($zeitlog as $log){
            $rueck[1][$k]['zeit'] = strtotime($log['MSTIME']);
            $rueck[1][$k]['strecke'] = $log['STRECKE'];
            $rueck[1][$k]['geschwindigkeit'] = $log['GESCHWINDIGKEIT'];
            $rueck[0]['vdurchschnitt'] += $log['GESCHWINDIGKEIT'];
            $k++;
            
            $rueck[0]['messdaten_check'] = 1; 
        }       
        if($k)
            $rueck[0]['vdurchschnitt'] = $rueck[0]['vdurchschnitt'] / $k;
    
    }
    
    
    ###### Allgemeine Definitionen; noch keine Auflistung der Arbeitsschritte! 
    ###### Die Merker für Rüst- und Anfahrzeit werden außerdem ins Array übernommen um die Auswertung zu erleichtern
    ## Falls Rüstzeit vorhanden: 
    if($or['NAME'] == 10 && $or['STATUS'] == 300){
        $merk_ruest = 1;
        $rueck[0]['merk_ruest'] = 1;
        $rueck[0]['ruestzeit_start'] = strtotime($or['MSTIME']);

    }
    else if($or['NAME'] == 10 && ($or['STATUS'] == 500 || $or['STATUS'] == 400)){
        $rueck[0]['ruestzeit_ende'] = strtotime($or['MSTIME']);
        $rueck[0]['ruestzeit'] = ($rueck[0]['ruestzeit_ende'] - $rueck[0]['ruestzeit_start']);
        $rueck[0]['gepl_ruestzeit'] = $pt['PTR']/3600;
        $rueck[0]['ruest_differenz'] = ($rueck[0]['ruestzeit'] - $rueck[0]['gepl_ruestzeit']);
        
        
    }
    
    ## Falls Anfahrzeit vorhanden: 
    if($or['NAME'] == 15 && $or['STATUS'] == 300 && $merk_anfahr == 0){
        $rueck[0]['anfahrzeit_start'] = strtotime($or['MSTIME']);
    }
    else if($or['NAME'] == 15 && $or['STATUS'] == 500 && $merk_anfahr == 0){
        $rueck[0]['anfahrzeit_ende'] = strtotime($or['MSTIME']);
        $rueck[0]['merk_anfahr'] = 1;
        $merk_anfahr = 1;
        $rueck[0]['anfahrzeit'] = ($rueck[0]['anfahrzeit_ende'] - $rueck[0]['anfahrzeit_start']);
        $rueck[0]['gepl_anfahrzeit'] = 3600;
        $rueck[0]['anfahr_differenz'] = ($rueck[0]['anfahrzeit'] - $rueck[0]['gepl_anfahrzeit']);
    }

     ## Falls Abrüstzeit vorhanden: 
    if($or['NAME'] == 40 && $or['STATUS'] == 300){
        $rueck[0]['merk_abruest'] = 1;
        $rueck[0]['abruestzeit_start'] = strtotime($or['MSTIME']);
    }
    else if($or['NAME'] == 40 && $or['STATUS'] == 500){
        $rueck[0]['abruestzeit_ende'] = strtotime($or['MSTIME']);
        $rueck[0]['abruestzeit'] = ($rueck[0]['abruestzeit_ende'] - $rueck[0]['abruestzeit_start']);   
    }
   

    #### Ab hier Auflistung der Arbeitsschritte: (Ab Array(1)) 
    if($or['STATUS'] == 300){
        $rueck[2][$n]['startzeit'] = strtotime($or['MSTIME']);
        
        ## art muss hier schon definiert werden bei fehlenden 400//500 Einträgen
        $rueck[2][$n]['art'] = $or['NAME'];
      
    }
    else if($or['STATUS'] == 400 || $or['STATUS'] == 500){
        $rueck[2][$n]['endzeit'] = strtotime($or['MSTIME']);
        $rueck[2][$n]['laufzeit'] = ($rueck[2][$n]['endzeit'] - $rueck[2][$n]['startzeit']);
        $rueck[2][$n]['status'] = $or['STATUS'];
        $rueck[2][$n]['teile'] = $or['ADCCOUNT'];
        if($or['NAME'] == 20){
            $rueck[0]['teile_zaehler'] += $or['ADCCOUNT'];
            $rueck[0]['produktions_zeit'] += $rueck[2][$n]['laufzeit'];
        }
        ### Streckendaten zuordnen (falls vorhanden)
        if($rueck[0]['messdaten_check']){
            foreach($rueck[1] as $slog){
                if($slog['zeit'] < $rueck[2][$n]['startzeit']){
                    $rueck[2][$n]['strecke_start'] = $slog['strecke'];
                }
                if($slog['zeit'] > $rueck[2][$n]['endzeit'] && $merk_strecke == 0){
                    $rueck[2][$n]['strecke_ende'] = $slog['strecke'];
                    $merk_strecke = 1;
                }
            }
            $merk_strecke = 0;
        }
        $n++;
    
    }
    
    
    $c++;
    ###########################
    #### Letzter Eintrag:. Die Dauer des Auftrags wird ohne die Rüstzeit berechnet, die Gesamtstrecke wird als Info hinzugefügt
    if($c==$i){
        
       
        
        if($merk_anfahr == 1){
            $rueck[0]['auftrag_gesamt_dauer'] = ($rueck[0]['auftrag_endzeit'] - $rueck[0]['anfahrzeit_start']);
            $rueck[0]['gepl_gesamt_dauer'] = $rueck[0]['gepl_produktions_dauer'] + $rueck[0]['gepl_anfahrzeit'];
        }
        else{
            $rueck[0]['auftrag_gesamt_dauer'] = ($rueck[0]['auftrag_endzeit'] - $rueck[0]['auftrag_startzeit']);
            $rueck[0]['gepl_gesamt_dauer'] = $rueck[0]['gepl_produktions_dauer'];
        }
        
        $rueck[0]['auftrag_gesamt_dauer_mrue'] = ($rueck[0]['auftrag_endzeit'] - $rueck[0]['auftrag_startzeit']);
        
        $rueck[0]['zeit_unterbrechnungen'] = ($rueck[0]['auftrag_gesamt_dauer'] - $rueck[0]['produktions_zeit']);
        $rueck[0]['auftrag_dauer_differenz'] = ($rueck[0]['auftrag_gesamt_dauer'] - $rueck[0]['gepl_gesamt_dauer']);
        $rueck[0]['produktions_zeit_differenz'] = $rueck[0]['produktions_zeit'] - $rueck[0]['gepl_produktions_dauer']; 
        
        
         ### Gesamt-Streckendaten zuordnen (falls vorhanden)
        if($rueck[0]['messdaten_check']){
            $qp = 0;
            foreach($rueck[1] as $slog){
                $qp++;
                if($qp==1)
                    #$rueck[0]['mess_strecke_start'] = $slog['strecke'];
                    $rueck[0]['mess_strecke_start'] = 0;
                
                if($qp==$k)
                    $rueck[0]['mess_strecke_ende'] = $slog['strecke'];
                    
                
            }
        
        $rueck[0]['mess_strecke_gesamt'] = ($rueck[0]['mess_strecke_ende'] - $rueck[0]['mess_strecke_start'])/100;
        $rueck[0]['mess_ausschuss'] = $rueck[0]['mess_strecke_gesamt'] - $rueck[0]['gesamt_laenge']; 
        $rueck[0]['ausschuss_prozent'] = ($rueck[0]['mess_ausschuss'] / $rueck[0]['gesamt_laenge']) * 100;
        $rueck[0]['vdifferenz'] = $rueck[0]['vdurchschnitt'] - $rueck[0]['gepl_geschwindigkeit'];
        
        }
        
        ### Prüfen ob Streckendaten valide oder nicht 
        if(($rueck[0]['mess_strecke_start'] < $rueck[0]['mess_strecke_ende']) && $rueck[0]['mess_strecke_start'] && $rueck[0]['mess_strecke_ende'])
            $rueck[0]['mess_valide'] = 1;
        else    
            $rueck[0]['mess_valide'] = 0;
    
    
        $rueck[0]['n'] = $n;
        $rueck[0]['k'] = $k;
    
    }
    
    
    
    }
   
            
    
} catch(Exception $e){
        $rueck[0] = 0;
        $rueck[1] = "Datenfehler: " . $e;
        return $rueck;
    }
    finally{
        if(!array_key_exists('auftrag_gesamt_dauer_mrue',$rueck[0])){
            $rueck[0] = 0;
            $rueck[1] = "Datenfehler";
        }
        return $rueck;
    }
}    
    
    
    
public function vergleich_alt($werkzeug,$start,$ende,$modus){
    ### Werkzeugnr auswählen und dann auf Monatsbasis (später verschiedene Zeiträume)  // respektive angebbaren Zeitraum auswerten. 
    ### Hierzu alle Aufträge auswählen, die in diesen Zeitraum fallen. 
    ### 2 unterschiedliche Modi: Einmal werden Aufträge, die den Start bzw das Ende ind em jeweiligen AUftragszeitraum beinhalten, mit vollständig erfasst.
    ### Der andere Modi schneidet die Aufträge ab und macht einen Hardcut am Anfang und am Ende des Zeitraums. 
    
    
    /*
    Werkzeug 1: 
                    Woche1  Woche2  Woche3  Woche4  Woche5  Woche6
    Produktion:     Zeit1   Zeit2   Zeit3   ... 
    Anfahr:         Zeit1   Zeit2   Zeit3
    Ausschuss:      Zeit1   Zeit2   Zeit3
    Messstrecke:
    Geschwindig:
    usw.:
    
    */
    
    ### Auswählen aller Auftragsdaten die im entsprechenden Zeitraum in Frage kommen: 
    $op = Yii::$app->db->createCommand("SELECT LB_DC.ORNO FROM OR_ORDER
                                        RIGHT JOIN LB_DC
                                        ON OR_ORDER.NO = LB_DC.ORNO 
                                        WHERE OR_ORDER.COMMNO LIKE '".$werkzeug."'
                                        GROUP BY LB_DC.ORNO
                                    ")
    ->queryAll();    
    
    $i = 0;
    $vergleich = array();
    $laufzeiten = array();
    // foreach($op as $or){
        // $vergleich[$i] = auftrag($or['ORNO']);
        
        
        // ## Alle Laufzeitbeiträge in einem Array zusammenfassen:
        // array_push($laufzeiten,$vergleich[$i][2]);
        // $i++;
    // }
    
    ### Definieren der einzelnen Wochen als Start/Ende Wx per Timestamp 
    
    
    $ts_start = strtotime($start);
    $ts_ende = strtotime($ende);
    
    
    ## Woche1 
    $kw_start = date("W",strtotime($start));
    $kw_ende = date("W",strtotime($ende));
    
    
    ### Neuberechnung am Jahresende (29/30/31 kann schon kw1 sein)
    $wochenanzahl = ($kw_ende - $kw_start)+1;
    
    $jahr_start = date("Y",strtotime($start));
    $jahr_ende = date("Y",strotime($ende));
    
    $kw_start_son = strtotime("{$jahr_start}-W{$kw_start}-7");
    $kw_ende_son = strtotime("{$jahr_ende}-W{$kw_ende}-7");
    
    
    
    
    
    ## Rausfinden in welcher Woche Starttermin - daraufhin rausfinden wecher Tag der Sontag ist vom Starttermin
    $w1_start = $ts_start;
    $w1_ende = $ke_start_son;
    $w2_start = ($w1_start + 604800);
    $w2_ende = ($w1_ende + 604800);
    $w3_start = ($w2_start + 604800);
    $w3_ende = ($w2_ende +604800);
    $w4_start = ($w3_start + 604800);
    $w4_ende = ($w3_ende +604800);
    if($wochenanzahl == 4){
        $w4_start = ($w3_start + 604800);
        $w4_ende = $ts_ende;
    }
    if($wochenanzahl == 5){
        $w5_start = ($w4_start + 604800);
        $w5_ende = $ts_ende;
    }
    if($wochenanzahl == 6){
        $w5_start = ($w4_start + 604800);
        $w5_ende = ($w4_ende + 604800);
        $w6_start = ($w5_start + 604800);
        $w6_ende = $ts_ende;
    }
    
    
    
    
    ## Ermitteln des Timestamps für Wochenanfang und Wochenende für jede einzelne Woche im Monat
   
   
    $woche1 = array();
    $woche2 = array();
    $woche3 = array();
    $woche4 = array(); 
    $woche5 = array(); 
    $woche6 = array();

    $n = 0;
    $k = 0; 
    
    
    $laufzeiten = eintraege($werkzeug,$start,$ende,$modus);
    
    
    ## Unterteilung in Wochen + Fehlerkorrektur 
    foreach($laufzeiten[2] as $eintrag){
    ## Als Ausnahme muss definiert werden falls die Laufzeit länger als eine Woche andauert   
     if(array_key_exists('startzeit',$eintrag) && array_key_exists('endzeit',$eintrag)){
        if($eintrag['startzeit'] <= $w1_start && $eintrag['endzeit'] > $w1_start){
            $woche1[$n]['startzeit'] = $w1_start;
            $woche1[$n]['endzeit'] = $w1_ende;
            $n++;
        }
        else if($eintrag['startzeit'] > $w1_start && $eintrag['endzeit'] < $w1_ende){
            $woche1[$n]['startzeit'] = $eintrag['startzeit'];
            $woche1[$n]['endzeit'] = $eintrag['endzeit']; 
            $n++;
        }
        else if($eintrag['startzeit'] > $w1_start && $eintrag['endzeit'] > $w1_ende){
            $woche1[$n]['startzeit'] = $eintrag['startzeit'];
            $woche1[$n]['endzeit'] = $w1_ende; 
            $n = 0;
                
        }
        
        
        
   
   
   
     }
    }
    
    ### Zusammenfassen aller Laufzeitbeiträge um diese dann in die jeweiligen Wochen aufzuteilen. 
    
    
    
    
    
    
    
    ### Auswerten und Berechnen der einzelnen Ergebnisse... Aufteilung in Wochen etc.:
    
    

   
    
    
    
}    




public function eintraege($werkzeug,$start,$ende,$modus){
  
    $startzeitpunkt_ts = strtotime($start);
    
    $startzeitpunkt = date("Y-d-m H:i:s",$startzeitpunkt_ts);
    $rueck[0]['startzeitpunkt'] = $startzeitpunkt;
    $rueck[0]['endzeitpunkt'] = $ende;
    $rueck[0]['startzeitpunkt_ts'] = $startzeitpunkt_ts;
    
    $erst_eintrag = Yii::$app->db->createCommand(" SELECT TOP(1) LB_DC.* FROM LB_DC 
                                                   INNER JOIN OR_ORDER 
                                                   ON LB_DC.ORNO = OR_ORDER.NO
                                                   WHERE MSTIME < '".$startzeitpunkt."' AND OR_ORDER.COMMNO LIKE '".$werkzeug."' ORDER BY LBNO DESC ")
                    ->queryAll();
    $reihe = Yii::$app->db->createCommand("SELECT LB_DC.* FROM LB_DC 
                                            INNER JOIN OR_ORDER
                                            ON LB_DC.ORNO = OR_ORDER.NO
                                            WHERE MSTIME BETWEEN '".$start."' AND '".$ende."' AND OR_ORDER.COMMNO LIKE '".$werkzeug."'")
                    ->queryAll();
                        
                        
    $n = 1;
    $i = 0;
    $k = 0;
    
    
    ## Fehlerkennung auf 0 setzen  -  wird auf 1 gesetzt bei falscher Stempelung: 
    $rueck[0]['fehler'] = 0;
    
    foreach($reihe as $zaehl){$i++;}
    
    // Neuauflage 05.09.:
    
    ## Erster Eintrag: Beschreibt den Zustand vom letzten Eintrag vor dem Startzeitpunkt und darüber hinaus bis zum nächsten Eintrag in LB_DC.
    ## Der Eintrag wird zu einem normalen Ablauf formatiert vom Startzeitpunkt bis zum nächsten Eintrag. 
    
    ## Abfrage des Statusses:         
    if($erst_eintrag[0]['NAME'] == 20)
        $art = 'produktion';
    else if($erst_eintrag[0]['NAME'] == 10)
        $art = 'ruest';
    else if($erst_eintrag[0]['NAME'] == 15)
        $art = 'anfahr';
    else if($erst_eintrag[0]['NAME'] == 30)
        $art = 'abruest';
    else 
        $art = 'fehler';
        
    
    ## ['typ'] == 1  = Arbeitsgang läuft,  0 ist Unterbrechung. 
    if($erst_eintrag[0]['STATUS'] == 300){
        $rueck[2][0]['startzeit'] = $startzeitpunkt_ts;
        $rueck[2][0]['art'] = $art;
        $rueck[2][0]['typ'] = 1;
        $rueck[2][0]['i'] = $i;
        ## Falls es keine weiteren Einträge gibt: 
        if($i == 0){
            $rueck[2][0]['endzeit'] = strtotime('now');
        }
        
    }
    else if($erst_eintrag[0]['STATUS'] == 400 || $erst_eintrag[0]['STATUS'] == 500){
        $rueck[2][0]['startzeit'] = $startzeitpunkt_ts;
        $rueck[2][0]['typ'] = 0;
        $rueck[2][0]['i'] = $i;
        $rueck[2][0]['art'] = 'unterbrechung';
         ## Falls es keine weiteren Einträge gibt: 
        if($i == 0){
            $rueck[2][0]['endzeit'] = strtotime('now');
        }
        
    }
  
    
    $merk_status = 0;
    $rueck[0]['bezeichnung'] = $erst_eintrag[0]['ORNAME'];
    $rueck[0]['orno'] = $erst_eintrag[0]['ORNO'];
    
    foreach($reihe as $eintrag){
        if($eintrag['NAME'] == 20)
            $art = 'produktion';
        else if($eintrag['NAME'] == 10)
            $art = 'ruest';
        else if($eintrag['NAME'] == 15)
            $art = 'anfahr';
        else if($eintrag['NAME'] == 40)
            $art = 'abruest';
        else if($eintrag['NAME'] == 30)
            $art = 'sonstige';
        else 
            $art = 'fehler';
        
        
        
        ## Verknüpfung mit erst_eintrag:
        if($k == 0 && ($eintrag['STATUS'] == 400 || $eintrag['STATUS'] == 500)){
            $rueck[2][0]['endzeit'] = strtotime($eintrag['MSTIME']);
            
            
            
            $rueck[2][($n+1)]['startzeit'] = strtotime($eintrag['MSTIME']);
            $rueck[2][($n+1)]['typ'] = 0;
            $rueck[2][($n+1)]['art'] = "unterbrechung";
            #$rueck[2][0]['laufzeit'] = $rueck[2][0]['endzeit'] - $startzeitpunkt_ts;       

             
            ### Falls Eintrag der letzte Eintrag - Ergänzung:
            if($k == ($i-1)){
                $rueck[2][($n+1)]['endzeit'] = strtotime('now');
            }
            
            
            $n+=2;
        }
        else if($k == 0 && $eintrag['STATUS'] == 300){
            $rueck[2][0]['endzeit'] = strtotime($eintrag['MSTIME']);
            $rueck[2][$n]['startzeit'] = strtotime($eintrag['MSTIME']);
            $rueck[2][$n]['art'] = $art;
            $rueck[2][$n]['typ'] = 1;
            
             ### Falls der Eintrag der letzte Eintrag - Ergänzung: 
            if($k == ($i-1)){
                $rueck[2][$n]['endzeit'] = strtotime('now');
            }
        }
    
    
    
        #### Normale Abfolge:
        if($k != 0 && $eintrag['STATUS'] == 300){
            ## Fertigstellung des Unterbrechungseintrags: 
            $rueck[2][($n-1)]['endzeit'] = strtotime($eintrag['MSTIME']);
            
            ## Beginn des normalen Laufeintrags:           
            $rueck[2][$n]['startzeit'] = strtotime($eintrag['MSTIME']);
            $rueck[2][$n]['art'] = $art;
            $rueck[2][$n]['typ'] = 1;
            
            
            
            
            ### Falls der Eintrag der letzte Eintrag - Ergänzung: 
            if($k == ($i-1)){
                $rueck[2][$n]['endzeit'] = strtotime('now');
            }
            
            
            
        }
        
        
        else if($k != 0 && ($eintrag['STATUS'] == 400 || $eintrag['STATUS'] == 500)){
            $rueck[2][$n]['endzeit'] = strtotime($eintrag['MSTIME']);
            
            
            ## Beginn des Unterbrechungseintrags: 
            $rueck[2][($n+1)]['startzeit'] = strtotime($eintrag['MSTIME']);
            $rueck[2][($n+1)]['typ'] = 0;
            $rueck[2][($n+1)]['art'] = "unterbrechung";
            
            
            ### Falls Eintrag der letzte Eintrag - Ergänzung:
            if($k == ($i-1)){
                $rueck[2][($n+1)]['endzeit'] = strtotime('now');
            }
            
            $n+=2;
        }
        
        
        
        ### Fehlerkennung: 
        if($eintrag['STATUS'] == $merk_status){
            $rueck[0]['fehler'] = 1;
            $rueck[0]['fehlermeldung'] = "Doppelte Auftragsstempelung (".$eintrag['STATUS']."): ".date("d.m. H:i:s",strtotime($eintrag['MSTIME']));
        }
        if($merk_status == 500 && $eintrag['STATUS'] == 400){
            $rueck[0]['fehler'] = 1;
            $rueck[0]['fehlermeldung'] = "Stempelfehler (400 auf 500, Doppelter Auftrag): ".date("d.m. H:i:s",strtotime($eintrag['MSTIME']));
        }
        if($merk_status == 400 && $eintrag['STATUS'] == 500){
            $rueck[0]['fehler'] = 1;
            $rueck[0]['fehlermeldung'] = "Stempelfehler (500 auf 400, Doppelter Auftrag): ".date("d.m. H:i:s",strtotime($eintrag['MSTIME']));
        }
        $merk_status = $eintrag['STATUS'];
        $k++;
        $rueck[0]['bezeichnung'] = $eintrag['ORNAME'];
        $rueck[0]['orno'] = $eintrag['ORNO'];
        
    }
    
    
    #### Für Details in der Linienansicht und genauere Auftragsdaten wird hier nochmal eine Abfrage gestartet (um komplette Auftragsauswertung zu vermeiden) 
    $details = Yii::$app->db->createCommand("  SELECT OR_OP.PPARTS as PPARTS, OR_OP.PTE as PTE, OR_OP.PTR as PTR, OR_OP.DESCR as DESCR,
                                    OR_ORDER.STATUS as STATUS2, OR_ORDER.DELIVERY as DELIVERY, OR_ORDER.COMMNO as COMMNO, OR_ORDER.INFO2 as INFO2, OR_ORDER.DESCR as ORDER_DESCR, OR_ORDER.IDENT as IDENT,
                                    PA_ARTPOS.AEINH2 as AEINH2
                                    FROM OR_ORDER  
                                    RIGHT JOIN OR_OP ON OR_ORDER.NO = OR_OP.ORNO 
                                    RIGHT JOIN PA_ARTPOS ON OR_ORDER.IDENT = PA_ARTPOS.ARTDESC
                                    WHERE OR_ORDER.NO = ".$rueck[0]['orno']."    
    ") 
    ->queryAll();
    
    
    $rueck[0]['werkzeug'] = "Keine Information";
    $rueck[0]['laenge'] = "Keine Information";
     
    foreach($details as $detail){
        if(array_key_exists('INFO2',$detail)&& is_numeric ($detail['INFO2']))
            $rueck[0]['laenge'] = $detail['INFO2'];
        else if (array_key_exists('AEINH2',$detail) && is_numeric ($detail['AEINH2']))
            $rueck[0]['laenge'] = $detail['AEINH2'];
        else 
            $rueck[0]['laenge'] = "Keine Information";
        
        if(array_key_exists('COMMNO',$detail))
            $rueck[0]['werkzeug'] = $detail['COMMNO'];
        else 
            $rueck[0]['werkzeug'] = "Keine Information"; 
    }
    
    #$rueck[1] = Yii::$app->db->createCommand(" SELECT TOP(1) * FROM m3_streckenlog WHERE LINIE LIKE 'Linie ".$linie."' ORDER BY ID DESC  ") -> queryAll();        
    return $rueck;
} 




    
    
    
    
public function linien($linie){                    
    ### 24h Ausgabe: 
    
    $startzeitpunkt_ts = strtotime("now -1days");
    $startzeitpunkt = date("Y-d-m H:i:s",$startzeitpunkt_ts);
    $rueck[0]['startzeitpunkt'] = $startzeitpunkt;
    $rueck[0]['startzeitpunkt_ts'] = $startzeitpunkt_ts;
    
    $erst_eintrag = Yii::$app->db->createCommand(" SELECT TOP(1) * FROM LB_DC WHERE MSTIME < '".$startzeitpunkt."' AND MSINFO LIKE 'Linie ".$linie."' ORDER BY LBNO DESC ")
                    ->queryAll();
    $reihe = Yii::$app->db->createCommand("SELECT * FROM LB_DC WHERE MSTIME > '".$startzeitpunkt."' AND MSINFO LIKE 'Linie ".$linie."'")
                    ->queryAll();
                        
                        
    $n = 1;
    $i = 0;
    $k = 0;
     
    
    ## Fehlerkennung auf 0 setzen  -  wird auf 1 gesetzt bei falscher Stempelung: 
    $rueck[0]['fehler'] = 0;
    
    foreach($reihe as $zaehl){$i++;}
    
    // Neuauflage 05.09.:
    
    ## Erster Eintrag: Beschreibt den Zustand vom letzten Eintrag vor dem Startzeitpunkt und darüber hinaus bis zum nächsten Eintrag in LB_DC.
    ## Der Eintrag wird zu einem normalen Ablauf formatiert vom Startzeitpunkt bis zum nächsten Eintrag. 
    
    ## Abfrage des Statusses:         
    if($erst_eintrag[0]['NAME'] == 20)
        $art = 'produktion';
    else if($erst_eintrag[0]['NAME'] == 10)
        $art = 'ruest';
    else if($erst_eintrag[0]['NAME'] == 15)
        $art = 'anfahr';
    else if($erst_eintrag[0]['NAME'] == 30)
        $art = 'abruest';
    else 
        $art = 'fehler';
        
    
    ## ['typ'] == 1  = Arbeitsgang läuft,  0 ist Unterbrechung. 
    if($erst_eintrag[0]['STATUS'] == 300){
        $rueck[2][0]['startzeit'] = $startzeitpunkt_ts;
        $rueck[2][0]['art'] = $art;
        $rueck[2][0]['typ'] = 1;
        $rueck[2][0]['i'] = $i;
        ## Falls es keine weiteren Einträge gibt: 
        if($i == 0){
            $rueck[2][0]['endzeit'] = strtotime('now');
        }
        
    }
    else if($erst_eintrag[0]['STATUS'] == 400 || $erst_eintrag[0]['STATUS'] == 500){
        $rueck[2][0]['startzeit'] = $startzeitpunkt_ts;
        $rueck[2][0]['typ'] = 0;
        $rueck[2][0]['i'] = $i;
        $rueck[2][0]['art'] = 'unterbrechung';
         ## Falls es keine weiteren Einträge gibt: 
        if($i == 0){
            $rueck[2][0]['endzeit'] = strtotime('now');
        }
        
    }
  
    
    $merk_status = 0;
    $rueck[0]['bezeichnung'] = $erst_eintrag[0]['ORNAME'];
    $rueck[0]['orno'] = $erst_eintrag[0]['ORNO'];
    
    foreach($reihe as $eintrag){
        if($eintrag['NAME'] == 20)
            $art = 'produktion';
        else if($eintrag['NAME'] == 10)
            $art = 'ruest';
        else if($eintrag['NAME'] == 15)
            $art = 'anfahr';
        else if($eintrag['NAME'] == 40)
            $art = 'abruest';
        else if($eintrag['NAME'] == 30)
            $art = 'sonstige';
        else 
            $art = 'fehler';
        
        
        
        ## Verknüpfung mit erst_eintrag:
        if($k == 0 && ($eintrag['STATUS'] == 400 || $eintrag['STATUS'] == 500)){
            $rueck[2][0]['endzeit'] = strtotime($eintrag['MSTIME']);
            
            
            
            $rueck[2][($n+1)]['startzeit'] = strtotime($eintrag['MSTIME']);
            $rueck[2][($n+1)]['typ'] = 0;
            $rueck[2][($n+1)]['art'] = "unterbrechung";
            #$rueck[2][0]['laufzeit'] = $rueck[2][0]['endzeit'] - $startzeitpunkt_ts;       

             
            ### Falls Eintrag der letzte Eintrag - Ergänzung:
            if($k == ($i-1)){
                $rueck[2][($n+1)]['endzeit'] = strtotime('now');
            }
            
            
            $n+=2;
        }
        else if($k == 0 && $eintrag['STATUS'] == 300){
            $rueck[2][0]['endzeit'] = strtotime($eintrag['MSTIME']);
            $rueck[2][$n]['startzeit'] = strtotime($eintrag['MSTIME']);
            $rueck[2][$n]['art'] = $art;
            $rueck[2][$n]['typ'] = 1;
            
             ### Falls der Eintrag der letzte Eintrag - Ergänzung: 
            if($k == ($i-1)){
                $rueck[2][$n]['endzeit'] = strtotime('now');
            }
        }
    
    
    
        #### Normale Abfolge:
        if($k != 0 && $eintrag['STATUS'] == 300){
            ## Fertigstellung des Unterbrechungseintrags: 
            $rueck[2][($n-1)]['endzeit'] = strtotime($eintrag['MSTIME']);
            
            ## Beginn des normalen Laufeintrags:           
            $rueck[2][$n]['startzeit'] = strtotime($eintrag['MSTIME']);
            $rueck[2][$n]['art'] = $art;
            $rueck[2][$n]['typ'] = 1;
            
            
            
            
            ### Falls der Eintrag der letzte Eintrag - Ergänzung: 
            if($k == ($i-1)){
                $rueck[2][$n]['endzeit'] = strtotime('now');
            }
            
            
            
        }
        
        
        else if($k != 0 && ($eintrag['STATUS'] == 400 || $eintrag['STATUS'] == 500)){
            $rueck[2][$n]['endzeit'] = strtotime($eintrag['MSTIME']);
            
            
            ## Beginn des Unterbrechungseintrags: 
            $rueck[2][($n+1)]['startzeit'] = strtotime($eintrag['MSTIME']);
            $rueck[2][($n+1)]['typ'] = 0;
            $rueck[2][($n+1)]['art'] = "unterbrechung";
            
            
            ### Falls Eintrag der letzte Eintrag - Ergänzung:
            if($k == ($i-1)){
                $rueck[2][($n+1)]['endzeit'] = strtotime('now');
            }
            
            $n+=2;
        }
        
        
        
        ### Fehlerkennung: 
        if($eintrag['STATUS'] == $merk_status){
            $rueck[0]['fehler'] = 1;
            $rueck[0]['fehlermeldung'] = "Doppelter Auftragsstempelung (".$eintrag['STATUS']."): ".date("d.m. H:i:s",strtotime($eintrag['MSTIME']));
        }
        if($merk_status == 500 && $eintrag['STATUS'] == 400){
            $rueck[0]['fehler'] = 1;
            $rueck[0]['fehlermeldung'] = "Stempelfehler (400 auf 500, Doppelter Auftrag): ".date("d.m. H:i:s",strtotime($eintrag['MSTIME']));
        }
        if($merk_status == 400 && $eintrag['STATUS'] == 500){
            $rueck[0]['fehler'] = 1;
            $rueck[0]['fehlermeldung'] = "Stempelfehler (500 auf 400, Doppelter Auftrag): ".date("d.m. H:i:s",strtotime($eintrag['MSTIME']));
        }
        $merk_status = $eintrag['STATUS'];
        $k++;
        $rueck[0]['bezeichnung'] = $eintrag['ORNAME'];
        $rueck[0]['orno'] = $eintrag['ORNO'];
        
    }
    
    
    #### Für Details in der Linienansicht und genauere Auftragsdaten wird hier nochmal eine Abfrage gestartet (um komplette Auftragsauswertung zu vermeiden) 
    $details = Yii::$app->db->createCommand("  SELECT OR_OP.PPARTS as PPARTS, OR_OP.PTE as PTE, OR_OP.PTR as PTR, OR_OP.DESCR as DESCR,
                                    OR_ORDER.STATUS as STATUS2, OR_ORDER.DELIVERY as DELIVERY, OR_ORDER.COMMNO as COMMNO, OR_ORDER.INFO2 as INFO2, OR_ORDER.DESCR as ORDER_DESCR, OR_ORDER.IDENT as IDENT,
                                    PA_ARTPOS.AEINH2 as AEINH2
                                    FROM OR_ORDER  
                                    RIGHT JOIN OR_OP ON OR_ORDER.NO = OR_OP.ORNO 
                                    RIGHT JOIN PA_ARTPOS ON OR_ORDER.IDENT = PA_ARTPOS.ARTDESC
                                    WHERE OR_ORDER.NO = ".$rueck[0]['orno']."    
    ") 
    ->queryAll();
    
    
    $rueck[0]['werkzeug'] = "Keine Information";
    $rueck[0]['laenge'] = "Keine Information";
     
    foreach($details as $detail){
        if(array_key_exists('INFO2',$detail)&& is_numeric ($detail['INFO2']))
            $rueck[0]['laenge'] = $detail['INFO2'];
        else if (array_key_exists('AEINH2',$detail) && is_numeric ($detail['AEINH2']))
            $rueck[0]['laenge'] = $detail['AEINH2'];
        else 
            $rueck[0]['laenge'] = "Keine Information";
        
        if(array_key_exists('COMMNO',$detail))
            $rueck[0]['werkzeug'] = $detail['COMMNO'];
        else 
            $rueck[0]['werkzeug'] = "Keine Information"; 
    }
    
    $rueck[1] = Yii::$app->db->createCommand(" SELECT TOP(1) * FROM m3_streckenlog WHERE LINIE LIKE 'Linie ".$linie."' ORDER BY ID DESC  ") -> queryAll();
    
    
    return $rueck;
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    /*
    
    
    if($erst_eintrag[0]['STATUS'] == 300){       
        $rueck[2][0]['startzeit'] = strtotime($erst_eintrag[0]['MSTIME']);
        $rueck[2][0]['art'] = $erst_eintrag[0]['NAME'];
    }
    else if($erst_eintrag[0]['STATUS'] == 400){
        $rueck[2][0]['startzeit'] =  strtotime($erst_eintrag[0]['MSTIME']);
        $rueck[2][0]['endzeit'] = $rueck[0]['startzeitpunkt_ts'];
        $rueck[2][0]['art'] = $erst_eintrag[0]['NAME'];
        $rueck[2][0]['laufzeit'] = $rueck[2][0]['endzeit'] - strtotime($startzeitpunkt);
    }
    
    ### Wird bei jedem nachfolgenden Eintrag neu geschrieben -> der letzte zählt
    $rueck[0]['bezeichnung'] = $erst_eintrag[0]['ORNAME'];
    
    foreach($reihe as $or){
        if($or['STATUS'] == 400 && $n == 1){
             $rueck[2][$n]['startzeit'] = $rueck[0]['startzeitpunkt_ts'];
        }
      
        
        if($or['STATUS'] == 300){
            $rueck[2][$n]['startzeit'] = strtotime($or['MSTIME']);
            ## art muss hier schon definiert werden bei fehlenden 400//500 Einträgen
            $rueck[2][$n]['art'] = $or['NAME'];
        }
       
        else if($or['STATUS'] == 400 || $or['STATUS'] == 500){
            $rueck[2][$n]['endzeit'] = strtotime($or['MSTIME']);
                                   
            $rueck[2][$n]['art'] = $or['NAME'];
            
             
        if(!array_key_exists('startzeit',$rueck[2][$n])){
            $rueck[2][$n]['startzeit'] =  strtotime($or['MSTIME']) - 3600;
            $rueck[2][$n]['fehler'] = "fehlerhafte Stempelzeiten";
            
        }
            
            
            
            
            
            ### Wird bei jedem Eintrag neu geschrieben -> der letzte zählt
            $rueck[0]['bezeichnung'] = $or['ORNAME'];
            
            
            $rueck[2][$n]['laufzeit'] = ($rueck[2][$n]['endzeit'] - $rueck[2][$n]['startzeit']);
            $rueck[2][$n]['status'] = $or['STATUS'];
            $rueck[2][$n]['teile'] = $or['ADCCOUNT'];
            // if($or['NAME'] == 20){
                // $rueck[0]['teile_zaehler'] += $or['ADCCOUNT'];
                // $rueck[0]['produktions_zeit'] += $rueck[2][$n]['laufzeit'];
            // }
            // ### Streckendaten zuordnen (falls vorhanden)
            // if($rueck[0]['messdaten_check']){
                // foreach($rueck[1] as $slog){
                    // if($slog['zeit'] < $rueck[2][$n]['startzeit']){
                        // $rueck[2][$n]['strecke_start'] = $slog['strecke'];
                    // }
                    // if($slog['zeit'] > $rueck[2][$n]['endzeit'] && $merk_strecke == 0){
                        // $rueck[2][$n]['strecke_ende'] = $slog['strecke'];
                        // $merk_strecke = 1;
                    // }
                // }
                // $merk_strecke = 0;
            // }
            $n++;
    
        }
            
        
        
        
        
        
    }
    
    // $rueck = array();
    // $tables = Yii::$app->db->createCommand(" 
    // SELECT TOP 1 * FROM LB_DC WHERE MSINFO LIKE 'Linie ".$linie."'  ORDER BY LBNO DESC 
    // ")
    // ->queryAll();
      
    // $orname = "";
   
    // $orno = 0;
    // foreach($tables as $type){
        // $orname = $type['ORNAME'];
        // $linie = $type['MSINFO'];
        // $orno = $type['ORNO'];
    // }
    // $rueck = $this->auftrag($orno,0,0);*/
}
     

    
   
   
   
   
   
public function ornos($startzeit,$endzeit,$linie,$werkzeug){
    ### Finden der letzten Ruest / Abruestperiode... 
    ### Aufträge sammeln   
    ### Neue Unterbrechungsmeldungen mit einbeziehen  ...   -> Auswertung der Unterbrechungen darüber (lin13 only) 
    
    ### Streckendaten sammeln: 
    ### Alle eingetragenen Auftragsnummern seit Datum X auslesen (notwendig, da sich die ORNO nicht zuverlässig automatisch geändert hat seitdem... bei Reboot Rücksetzen auf 0 wenn andere ORNO)
    ### Jeweils letzter Eintrag der ORNO Nr im streckenlog verwenden. 
     
    // $ornos = Yii::$app->db->CreateCommand(" 
        // SELECT DISTINCT AUFTRAG FROM m3_streckenlog WHERE MSTIME BETWEEN '".$startzeit."' AND '".$endzeit."' AND LINIE LIKE '".$linie."'")
    // ->queryAll();
          
    $sql = ""; 
        
    if($linie && !$werkzeug)      
        $sql = "AND LINIE LIKE '".$linie."'";
    else if(!$linie && $werkzeug)
        $sql = "AND WERKZEUG LIKE '".$werkzeug."'";
    else if($linie && $werkzeug)
        $sql = "AND LINIE LIKE '".$linie."' AND WERKZEUG LIKE '".$werkzeug."'";
    
    $ornos = Yii::$app->db->CreateCommand(" 
        SELECT DISTINCT t.AUFTRAG as AUFTRAG, t.max_STRECKE as STRECKE, t.ORNAME as ORNAME FROM
            (SELECT AUFTRAG, m3_streckenlog.MSTIME as MSTIME, LINIE, MAX(STRECKE) OVER (PARTITION BY AUFTRAG) max_STRECKE, ORNAME 
             FROM m3_streckenlog  
             INNER JOIN LB_DC ON m3_streckenlog.AUFTRAG = LB_DC.ORNO
             WHERE m3_streckenlog.MSTIME BETWEEN '".$startzeit."' AND '".$endzeit."' ".$sql." ) t    
        ")
    ->queryAll();   
    return $ornos;        
}
   
   
public function werkzeuge(){
## Gibt eine Liste aller verfügbaren Werkzeuge zurück
return Yii::$app->db->CreateCommand("SELECT DISTINCT COMMNO FROM OR_ORDER WHERE COMMNO LIKE 'W%'")->queryAll();

}    
 
 
public function auswertung_zeitraum($startzeit,$endzeit,$linie,$werkzeug){
    ## Manuell das Zeitlimit für die Funktion setzen (Standard 30 war teils zu wenig)
        set_time_limit(60);
    // $startzeit = date("Y-d-m",strtotime($startzeit));
    // $endzeit = date("Y-d-m",strtotime($endzeit));
    
    
    $ornos = $this->ornos($startzeit,$endzeit,$linie,$werkzeug);
    $rueck = array();
    $rueck[2] = array();
    $rueck[0]['fehlermeldungen'] = array();
    $rueck[0]['auftraege'] = array();
    $rueck[0]['hinweise'] = array();
    
    $rueck[0]['fehler'] = 0;
    
  
    $rueck[0]['messdaten_check'] = 0;
    $rueck[0]['vdurchschnitt'] = 0; 

    
    
    
    ### SQL String für Streckendaten bilden und Gesamtstrecke ausrechnen:
    $sql_string = "WHERE ";
    $mess_strecke_gesamt = 0;
    $n = 0;  ### Wird später bei Detailszuweisung nochmal benötigt!
    foreach($ornos as $orno){
        if(substr($orno['ORNAME'], 0, 2) !== 'OR'){  
            if($n == 0)
                $sql_string = $sql_string . " AUFTRAG LIKE '".$orno['AUFTRAG']."'"; 
            else
                $sql_string = $sql_string . " OR AUFTRAG LIKE '".$orno['AUFTRAG']."'"; 
            
            $mess_strecke_gesamt += $orno['STRECKE'];
            $n++;
        }
    }
    if($n == 0){
        array_push($rueck[0]['fehlermeldungen'],"Keine verwertbaren Aufträge in diesem Zeitraum vorhanden");
        $rueck[0]['fehler'] = 1;
        
        return $rueck;
    }
        
    $sql_string = $sql_string . " ORDER BY ID";
    
    $messwerte = Yii::$app->db->CreateCommand("  
        SELECT m3_streckenlog.[ID]
          ,[MSTIME]
          ,[LINIE]
          ,[STRECKE]
          ,[GESCHWINDIGKEIT]
          ,[AUFTRAG]
          ,[ARBEITSSCHRITT]
          ,[UNT_ID]
          ,[UNT_GRUND]
          ,[WERKZEUG]
          ,[BEZEICHNUNG]
        FROM [fauser_v6].[dbo].[m3_streckenlog] LEFT JOIN [dbo].[m3_bezeichnungen] ON m3_streckenlog.UNT_GRUND = m3_bezeichnungen.REFNR
        ".$sql_string."")
                ->queryAll();
                
    $k = 0;          
    $unterbrechungen = 0;
    $gesamt = 0;
    $geschw = 0;
    $unt100=0;
    $unt101=0;
    $unt102=0;
    $unt103=0;
    $unt104=0;
    $unt105=0;
    foreach($messwerte as $log){
        $rueck[1][$k]['zeit'] = strtotime($log['MSTIME']);
        $rueck[1][$k]['strecke'] = $log['STRECKE'];
        $rueck[1][$k]['geschwindigkeit'] = $log['GESCHWINDIGKEIT'];
        $rueck[1][$k]['auftrag'] = $log['AUFTRAG'];
        $rueck[1][$k]['arbeitsschritt'] = $log['ARBEITSSCHRITT'];
        if($log['ARBEITSSCHRITT'] == 20 && $log['GESCHWINDIGKEIT'] < 0.2)
             $rueck[1][$k]['arbeitsschritt'] = 5;
        $rueck[1][$k]['unt_id'] = $log['UNT_ID'];
        $rueck[1][$k]['unt_grund'] = $log['BEZEICHNUNG'];
        $rueck[0]['vdurchschnitt'] += $log['GESCHWINDIGKEIT'];
        $k++;
        
        $rueck[0]['messdaten_check'] = 1; 
        
 
        if($log['GESCHWINDIGKEIT'] < 0.5){
            $unterbrechungen++;        
        }
        else{
            $geschw += $log['GESCHWINDIGKEIT'];
        }
        
        
        switch($log['UNT_GRUND']) {
              case 100:
                $unt100++;
              break; 
                   
              case 101:
                $unt101++;
              break;
               
              case 102:
                $unt102++;
              break;
              
              case 103:
                $unt103++;
              break;
              
              case 104:
                $unt104++;
              break;
              
              case 105:
                $unt105++;
              break;
              
              default:
                 //Anweisung;
              break;
        }
        
        
        
        
    }       
    
    if($k){
        $unt_proz =  round(($unterbrechungen / $k) * 100,2);
        $lauf_proz = 100 - $unt_proz;
        $rueck[0]['vdurchschnitt']  = round($geschw / ($k - $unterbrechungen),2);

        $rueck[0]['unterbrechungen_stunden'] = round($unterbrechungen / 60,2);  
        $rueck[0]['produktion_stunden']  = round(($k - $unterbrechungen) / 60,2);
        $rueck[0]['gesamt_dauer'] = round($k  / 60,2);
     
    }
    $rueck[0]['k'] = $k; 
    
    $rueck[0]['zeit_unt100'] = round($unt100 / 60,2);
    $rueck[0]['zeit_unt101'] = round($unt101 / 60,2);
    $rueck[0]['zeit_unt102'] = round($unt102 / 60,2);
    $rueck[0]['zeit_unt103'] = round($unt103 / 60,2);
    $rueck[0]['zeit_unt104'] = round($unt104 / 60,2);
    $rueck[0]['zeit_unt105'] = round($unt105 / 60,2);
    
    $rueck[0]['prozent_unt100'] = round(($unt100 / $unterbrechungen) * 100,2);
    $rueck[0]['prozent_unt101'] = round(($unt101 / $unterbrechungen) * 100,2);
    $rueck[0]['prozent_unt102'] = round(($unt102 / $unterbrechungen) * 100,2);
    $rueck[0]['prozent_unt103'] = round(($unt103 / $unterbrechungen) * 100,2);
    $rueck[0]['prozent_unt104'] = round(($unt104 / $unterbrechungen) * 100,2);
    $rueck[0]['prozent_unt105'] = round(($unt105 / $unterbrechungen) * 100,2);
   
      
    
 
                              
                                               
    ### Abfragen auf Produktion Start  -> und auf letzten Eintrag Produktion (500) 
    ### Unterbrechungen nurnoch über m3_bde oder m3_streckenlog
    ### 
    ### Zeitstrahl aufglieder in Blöcke (Abgleich mit Auflösung bei Geschwindigkeitszeitrahl
    ### Zeitstrahl resultiert aus Anfang Ende Auftrag?
    ###
    ### Berechnung der Blöcke mit strtotime(+ x sek)  oder timestamp
    ###
    ### Für jeden Block Abfrage: Unterbrechung vorhanden ja/ nein? -> Nein: Produktion (oder rüsten/anfahren) 
    ### Zeiträume vordefinieren und Nurnoch danach abfragen. 
    ### Daten für Zeitstrahl evtl schon in Funktion bilden
    ### Wenn keine Messdaten zu diesem Block => Wochenende (extra Markierung im Zeitstrahl? Schwarz?) 
    
    ### Großer Hintergrund evtl Farbe des Arbeitsgangs (blass) und Vordergrund Geschwindigkeitsdaten wie gewohnt)
    ### Unter Geschwindigkeitsstrahl direkt grün für läuft und rot für Produktion 
    ### => Schwarz für keine Messdaten -> We / Feiertag 
    
    ### Trotzdem noch Vergleichsaufteilung Produktion / Unterbrechung
    
    ### Auswertung der Blöcke + zukünftiges Erfassen von Anfahrzeiten: Auswertung über m3_bde um Unterbrechungen / Anfahrtszeiten unterscheiden zu können
    ### Evtl Ergänzung im Streckenlog: Nicht nur aktueller Auftrag sondern auch aktueller Arbeitsgang
    ###
    ###
    
    ### Zeitraum Produktion: Erster & Letzter Eintrag 20  (evtl doch 500 - testen!)
    
    
    ### Voraussichtliches Fertigungsdatum / Berechnen aktueller Aufträge: 
    ### Gepl_Gesamt_Dauer -> mit bereits verstrichener Dauer verechnen (Daten aus streckenlog) 
    ### Auf Gesamtlänge reflektieren => Momentanen Stand abschätzen ... 
    ### Hinweis, dass ein aktueller Auftrag mit verechnet wurde 
    ### Fehlerkorrekturen und Hinweise auf mögliche Fehler.
    ### Eigene 24 Stunden od. Aktueller Auftragsansicht um die aktuelle Effiziens hervorzuheben. 
    
    
    
    
    $zeitraum_produktion_start = 0;
    $zeitraum_produktion_ende = 0;
    
    
    
    
    // ### SQL-Strang für LBDC - Abfrage erstellen: 
    // $sql_lbdc = "WHERE"; 
    // $s = 0;
    // foreach($ornos as $orno){
       // if($s == 0){
           // $sql_lbdc = $sql_lbdc . " ORNO = ".$orno['AUFTRAG']." ";
       // }
       // else{
           // $sql_lbdc = $sql_lbdc . " OR ORNO = ".$orno['AUFTRAG']. " ";
       // }
    // $s++;
    // }
    
    // $arbeitsschritte = Yii::$app->db->CreateCommand(" SELECT NAME,ORNAME,STATUS,PERSNAME,PERSNO,MSTIME,MSINFO,ADCCOUNT FROM LB_DC ".$sql_lbdc." ORDER BY LBNO")
                       // ->queryAll();
                     
    // $a = 0;
    // $merk_a = 0;
    // foreach($arbeitsschritte as $schritt){
        // ### Produktionszeitraum definieren 
        // if($schritt['STATUS'] == 20 && $merk_a == 0){
            // $zeitraum_produktion_start = strtotime($schritt['MSTIME']);
        // }
        // else if($schritt['STATUS'] == 20){
            // $zeitraum_produktion_ende = strtotime($schritt['MSTIME']);
        // }
        




        
    // }
    

    
   
   
   
   
   
   
   
   
   
   
   #### Eckdaten der einzelnen Aufträge 
    // $op = array();
    // $op = Yii::$app->db->CreateCommand("SELECT OR_OP.PPARTS as PPARTS, OR_OP.PTE as PTE, OR_OP.DESCR as DESCR,
                                    // OR_ORDER.STATUS as STATUS2, OR_ORDER.DELIVERY as DELIVERY, OR_ORDER.COMMNO as COMMNO, OR_ORDER.INFO2 as INFO2, OR_ORDER.DESCR as ORDER_DESCR, OR_ORDER.IDENT as IDENT,
                                    // PA_ARTPOS.AEINH2 as AEINH2,
                                    // (SELECT PTR FROM OR_OP WHERE ORNO = 14131 AND OR_OP.NAME = 10) as PTR,
                                    // FROM OR_OP
                                    // RIGHT JOIN OR_ORDER ON OR_OP.ORNO = OR_ORDER.NO 
                                    // RIGHT JOIN PA_ARTPOS ON OR_ORDER.IDENT = PA_ARTPOS.ARTDESC
                                    // ".$sql_lbdc."")
                // ->queryAll();       
    
    
    
    
    
    $o = 0;
    
    $fehler = 0;
    $rueck[0]['gepl_produktions_dauer'] = 0;
    $rueck[0]['menge'] = 0;
    $rueck[0]['pte'] = 0;
    $rueck[0]['menge'] = 0;
    $rueck[0]['laenge'] = 0;
    $rueck[0]['gesamt_laenge'] = 0; 
    $rueck[0]['anfahrzeit'] = 0;
    $rueck[0]['gepl_anfahrzeit'] = 0;
    $rueck[0]['ruestzeit'] = 0;
    $rueck[0]['gepl_ruestzeit'] = 0;
    $rueck[0]['produktions_zeit'] = 0;
    $rueck[0]['gepl_gesamt_dauer'] = 0;
    // $rueck[0]['mess_strecke_gesamt'] = ($mess_strecke_gesamt / 100);
    $rueck[0]['mess_strecke_gesamt'] = 0;
    $rueck[0]['gepl_vdurchschnitt'] = 0;
    $rueck[0]['auswertung_startzeit'] = 0;
    $rueck[0]['auswertung_endzeit'] = 0;
    #### Zusammenfassung aller Eckdaten der einzelnen Aufträge
    foreach($ornos as $orno){ 
        if(substr($orno['ORNAME'], 0, 2) !== 'OR'){    
            $or = $this->auftrag($orno['AUFTRAG'].".0",0,0);
        if( $or[0]['auftrag_status'] == 2){
            
            
                
            ### Fehlermeldungen:
            if(!$or[0]['auftrag']){
                array_push($rueck[0]['fehlermeldungen'], $orno['ORNAME']. ": Keine Angaben zu diesem Auftrag");
                $fehler = 1;
            }
            if(!$or[0]['menge']){
                array_push($rueck[0]['fehlermeldungen'], $orno['ORNAME']. ": Mengenangabe fehlt im Auftrag");
                $fehler = 1;
            }
            if(!$or[0]['laenge']){
                array_push($rueck[0]['fehlermeldungen'], $orno['ORNAME']. ": (Einzel)-Längenangabe fehlt im Auftrag");
                $fehler = 1;
            }
            if($or[0]['teile_zaehler'] != $or[0]['menge']){
                array_push($rueck[0]['fehlermeldungen'], $orno['ORNAME']. ": Zurückgemeldete Teile stimmen nicht mit Auftragsmenge überein! - Auftrag mit Rückmeldebestand gewertet");
                
            }
            if($or[0]['mess_ausschuss'] < 0){
                array_push($rueck[0]['hinweise'], $orno['ORNAME']. ": Gemessene Strecke niedriger als Sollstrecke! (<a href='http://virtwinsrv01/m3adminV3/web/index.php?r=auswertung%2Fauftrag&input_lgnr=&input_orno=".(int)$or[0]['orno']."' target='_blank'>".(int)$or[0]['orno']."</a>)");
            }
            if($or[0]['produktions_zeit'] < 1000){
                 array_push($rueck[0]['hinweise'], $orno['ORNAME']. ": Produktionszeit sehr niedrig! (".round($or[0]['produktions_zeit']/3600,2)."Std - aus FauserDB) (<a href='http://virtwinsrv01/m3adminV3/web/index.php?r=auswertung%2Fauftrag&input_lgnr=&input_orno=".(int)$or[0]['orno']."' target='_blank'>".(int)$or[0]['orno']."</a>)");
            }
            
            
            
            ### Bei Erkennung eines Fehlers wird der Auftrag nicht gewertet: 
            if(!$fehler){
            
                
                ### Die Eckdaten des Auftrags werden im 0er Teil des Arrays gespeichert, danach folgt die chronologische Auflistung der Arbeitsschritte       
                // $rueck[0]['linie'] = $or[0]['MSINFO'];
                // $rueck[0]['werkzeug'] = $or[0]['COMMNO'];
                // $rueck[0]['liefertermin'] = $or[0]['DELIVERY'];
                // $rueck[0]['einzeldauer'] = $or[0]['PTE'];
                $rueck[0]['menge'] += $or[0]['menge'];
                $rueck[0]['gepl_produktions_dauer'] += ($or[0]['pte'] * $or[0]['menge']);
                $rueck[0]['ruestzeit'] += $or[0]['ruestzeit']; 
                $rueck[0]['gepl_ruestzeit'] += $or[0]['gepl_ruestzeit']; 
                // $rueck[0]['auftrag_status'] = $or[0]['STATUS2']; 
                // $rueck[0]['auftrag'] = $or[0]['ORNAME'];
                // $rueck[0]['teile_zaehler'] = 0;
                // $rueck[0]['bezeichnung'] = $or[0]['ORDER_DESCR'];
                // $rueck[0]['art_no'] = $or[0]['IDENT'];
                $rueck[0]['pte'] += $or[0]['pte'];
                $rueck[0]['laenge'] += $or[0]['laenge'];
                
                ### Workaround: Zurückgemeldete Menge stimmt nicht immer mit SOllbestand überein => Zurückgemedete Menge wird bewertet:
                #$rueck[0]['gesamt_laenge'] += ($or[0]['menge'] * $or[0]['laenge']) / 1000;
                $rueck[0]['gesamt_laenge'] += ($or[0]['teile_zaehler'] * $or[0]['laenge']) / 1000;
                
                
                
                $rueck[0]['anfahrzeit'] += $or[0]['anfahrzeit'];
                $rueck[0]['gepl_anfahrzeit'] += $or[0]['gepl_anfahrzeit'];
                $rueck[0]['mess_strecke_gesamt'] += $or[0]['mess_strecke_gesamt'];
                $rueck[0]['gepl_gesamt_dauer'] += $or[0]['gepl_gesamt_dauer'];
                
                $rueck[0]['auftraege'][$o]['auftrag'] = $or[0]['auftrag'];
                $rueck[0]['auftraege'][$o]['bezeichnung'] = $or[0]['bezeichnung'];
                $rueck[0]['auftraege'][$o]['auftrag_startzeit'] = $or[0]['auftrag_startzeit'];
                $rueck[0]['auftraege'][$o]['auftrag_endzeit'] = $or[0]['auftrag_endzeit'];
                $rueck[0]['auftraege'][$o]['orno'] = $or[0]['orno'];
                $rueck[0]['auftraege'][$o]['teile_zaehler'] = $or[0]['teile_zaehler'];
                $rueck[0]['auftraege'][$o]['ausschuss_prozent'] = round($or[0]['ausschuss_prozent'],0);
                
                
                
                $rueck[0]['gepl_vdurchschnitt'] += $or[0]['gepl_geschwindigkeit'];
                
                // if($or[0]['INFO2'] && is_numeric ($or[0]['INFO2'])){
                    // $rueck[0]['laenge'] = $or[0]['INFO2'];
                // }
                // else{
                    // $rueck[0]['laenge'] = $or[0]['AEINH2'];
                // }
                // $rueck[0]['gesamt_laenge'] = ($or[0]['PPARTS'] * $rueck[0]['laenge']) / 1000;
                // #$rueck[0]['gepl_geschwindigkeit'] = $rueck[0]['gesamt_laenge'] / $rueck[0]['gepl_produktions_dauer'] * 60;
                
                if(array_key_exists('2',$or))
                    array_push($rueck[2],$or[2]);
                
                
                if($o == 0)
                    $rueck[0]['auswertung_startzeit'] = $or[0]['auftrag_startzeit'];
                $rueck[0]['auswertung_endzeit'] = $or[0]['auftrag_endzeit'];
                
                     
                   
            
                
                
                
                
                
                
                $o++;
                
                
                  
                ### Aktueller Stand bei Auswertung eines aktuell laufenden Auftrags: 
                if( $or[0]['auftrag_status'] != 2){
                    $bisher_zeit = $or[0]['k'] / 60;
                    $diff_zeit = $or[0]['gepl_gesamt_dauer'];
                    
                    ### Ausschussauswertung nur von zurückgemeldeten Teilen? 
                    
                    array_push($rueck[0]['hinweise'],"Es wurde ein aktueller Auftrag verrechnet. (".$orno['ORNAME'].") Die Zahlen beruhen auf Hochrechnungen");
                }
            }
            $fehler = 0;
        }
        }
    }
    
    ### Fehlerkorrekturen: 
    
    
    if($o == 0){
        $rueck[0]['fehler'] = 1;
        $rueck[0]['fehlermeldung'][0] = "Keine verwertbaren Aufträge in diesem Zeitraum";
        return $rueck;
    }
    
   
    if($rueck[0]['gesamt_laenge'] == 0)
        $rueck[0]['gesamt_laenge'] = 1;
    
    // Nachbesserungen: 
    $rueck[0]['gepl_vdurchschnitt'] = round(($rueck[0]['gepl_vdurchschnitt'] / $o),2);
    $rueck[0]['vdurchschnitt_differenz'] = round($rueck[0]['vdurchschnitt'] - $rueck[0]['gepl_vdurchschnitt'],2);
    $rueck[0]['ruestzeit'] = round($rueck[0]['ruestzeit']/3600,2);
    $rueck[0]['anfahrzeit'] = round($rueck[0]['anfahrzeit']/3600,2);
    
    $rueck[0]['gepl_produktions_dauer'] = round($rueck[0]['gepl_produktions_dauer']/3600,2);
    $rueck[0]['gepl_anfahrzeit'] = round($rueck[0]['gepl_anfahrzeit']/3600,2);
    $rueck[0]['gepl_gesamt_dauer'] = round($rueck[0]['gepl_gesamt_dauer']/3600,2);
    
    $rueck[0]['gesamt_dauer_differenz'] = round($rueck[0]['gesamt_dauer'] - $rueck[0]['gepl_gesamt_dauer'],2);
    $rueck[0]['anfahrzeit_differenz'] = round($rueck[0]['anfahrzeit'] - $rueck[0]['gepl_anfahrzeit'],2);
    $rueck[0]['produktion_zeit_differenz'] = round($rueck[0]['produktion_stunden'] - $rueck[0]['gepl_produktions_dauer'],2);
    $rueck[0]['ruestzeit_differenz'] = round($rueck[0]['ruestzeit'] - $rueck[0]['gepl_ruestzeit'],2);

    
  
    
    $rueck[0]['mess_strecke_gesamt'] = round($rueck[0]['mess_strecke_gesamt'],2);
    $rueck[0]['ausschuss'] = round($rueck[0]['mess_strecke_gesamt'] - $rueck[0]['gesamt_laenge'],2);
    $rueck[0]['ausschuss_prozent'] = round((($rueck[0]['ausschuss'] / $rueck[0]['gesamt_laenge']) * 100),2);
    $rueck[0]['ausschuss_prozent_differenz'] = round($rueck[0]['ausschuss_prozent'] - 6,2);
   
    // $i = 0;
    // $mess_strecke_gesamt = 0;
    // foreach($ornos as $orno){
       // $daten[$i] = $this->auftrag($orno['AUFTRAG'],0,0); 
       // // if($daten[$i][1]){
            // // $rueck[1] += $daten[$i][1];
       // // }
       
       // $i++;
    // }
    
    
    return $rueck;  
}
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   #### Alte Auftragsfunktion
    // public function auftrag($auftragsnr){
    // ### Infos zum Auftrag: 
    // ### Wieviel soll produziert werden? 
    // ### In welcher geplanten Zeit? 
    // ### Wann Lieferdatum? 
    // ### Restzeit zum Lieferdatum verbleibend (...-> Kalkulation mit geplanter Produktionszeit -> Dringlichkeit berechnen) 
    // ### Wieviel bereits produziert? (Zwischenstand) 
    // ### Verbleibende zu produzierende Teile + geplante Zeit dafür
    // ### Liefertermin haltbar? 
    // ### Gesamtzahl Meter 
    // ### Zeit vergangen (Zwischenstände zwischen einzelnen Rückmeldungen -> Durchschnittszeit berechnen -> + / - vom Durchschnitt / bzw geplanter Dauer pro Stück) 
    // // $auftragsnr = "LG-12037-01-001";

    // $rueck = array(); 

    // $auftrag = Yii::$app->db->createCommand(" SELECT * FROM OR_ORDER WHERE NAME LIKE '".$auftragsnr."' ")
    // ->queryAll();

    // $tables = Yii::$app->db->createCommand(" 
    // SELECT * FROM LB_DC WHERE ORNAME LIKE '".$auftragsnr."' ")
    // ->queryAll();

    // $gesamt_zeit = 0;
    // $gesamt_zahl = 0;
    // $endtermin = "--"; 
    // $n = 0;
    // $i = 0;
    // foreach ($tables as $rechne){$i++;}
    // foreach ($tables as $rechne){
        // $n++;
        // if($n == 1){
            // $startzeitpunkt = strtotime($rechne['MSTIME']);
        // }
        // if($n == $i){
           // $endzeitpunkt = strtotime($rechne['MSTIME']);
           // $interval = $endzeitpunkt - $startzeitpunkt;  // Vergangene Zeit in Sekunden
           // $gesamt_zeit = round($interval/3600,2);
           // $rueck[0]['gesamt_zeit'] = $gesamt_zeit;
           // return $rueck; 
            
            
        // }
        
        // if($rechne['STATUS'] == 400 || $rechne['STATUS'] == 500){
            // $gesamt_zahl += $rechne['ADCCOUNT'];
        // }
        // if($rechne['STATUS'] == 500){
            // $endtermin = date("d.m.Y  H:i:s",strtotime($rechne['MSTIME']));
        // }
        
    // } 
    // foreach($auftrag as $auft){
        // $orno = $auft['NO'];
        // if($auft['STATUS'] == 0){
            // $auftrags_status = "<x style='background-color:red;color:white;'>Nocht nicht gestartet</x>";
        // }
        // else if($auft['STATUS'] == 1){
            // $auftrags_status = "<x style='background-color:yellow;color:black;'>In Arbeit</x>";
        // }
        // else if($auft['STATUS'] == 2){
            // $auftrags_status = "<x style='background-color:green;color:white;'>Fertig</x>";
        // }        

    // }

    // $op = Yii::$app->db->createCommand(" 
    // SELECT * FROM OR_OP WHERE ORNO = ".$orno."")
    // ->queryAll();

    // foreach($op as $or){
        // $stückzahl = $or['PPARTS'];
        // $pte = $or['PTE'];
        // $ptr = $or['PTR'];
        // $gesamt_dauer = (($stückzahl * $pte) + $ptr) / 3600;  // in Stunden
       
    // }


    // $merk_start = 0;

    // // foreach($tables as $type){
       // // $laufzeit = 0;
       // // $gepl = 0;

       // // if($type['STATUS'] == 300){
           // // $status = "Start";
       // // }
       // // else if ($type['STATUS'] == 400){
           // // $status = "Unterbrechung";
       // // }
       // // else if ($type['STATUS'] == 500){
           // // $status = "Ende";
       // // }
       
       // // if($merk_start==0 && $type['STATUS'] == 300){
           // // $startzeit = $type['MSTIME'];
           // // $merk_start = 1;
       // // }
       // // if($merk_start==1 && ($type['STATUS'] == 400 || $type['STATUS'] == 500) && $type['ADCCOUNT'] != 0){
           // // $datetime1 = new DateTime($startzeit);
           // // $datetime2 = new DateTime($type['MSTIME']);
           // // $interval = $datetime1->diff($datetime2);
           // // $laufzeit = $interval->format('%d Tage %h Std %i Min');
           // // $merk_start = 0 ; 
           // // $gepl = $type['ADCCOUNT'] / $pte; 
           // // $gepl = (int)($gesamt_dauer * 60 / $stückzahl * $type['ADCCOUNT']);
           
           // // $now = date_create('now', new DateTimeZone('GMT'));
           // // $here = clone $now;
           // // $here->modify($gepl.' minutes');
           // // $gepl = $now->diff($here);
           // // $gepl = $gepl->format('%d Tage %h Std %i Min');  
       // // }
       
       
      
// // }
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
    // }
   
   
   
   
   
   
   #### alte Linienfunktion 
   /*
   
    $op = Yii::$app->db->createCommand("SELECT OR_OP.PPARTS as PPARTS, OR_OP.PTE as PTE, OR_OP.PTR as PTR,
                                        LB_DC.MSTIME as MSTIME, LB_DC.STATUS as STATUS, LB_DC.ADCCOUNT as ADCCOUNT,
                                        OR_ORDER.STATUS as STATUS2, OR_ORDER.DELIVERY as DELIVERY, OR_ORDER.COMMNO as COMMNO
                                        FROM LB_DC 
                                        RIGHT JOIN OR_ORDER ON LB_DC.ORNO = OR_ORDER.NO 
                                        RIGHT JOIN OR_OP ON LB_DC.ORNO = OR_OP.ORNO 
                                        WHERE LB_DC.ORNO = ".$orno." AND LB_DC.NAME = 20 AND OR_OP.NAME = 20
                                        ")
    ->queryAll();
    
    
    
    
     $anf = Yii::$app->db->createCommand("SELECT OR_OP.PPARTS as PPARTS, OR_OP.PTE as PTE, OR_OP.PTR as PTR, OR_OP.DESCR as DESCR,
                                        LB_DC.MSTIME as MSTIME, LB_DC.STATUS as STATUS, LB_DC.ADCCOUNT as ADCCOUNT, LB_DC.MSINFO as MSINFO, LB_DC.ORNAME as ORNAME,
                                        OR_ORDER.STATUS as STATUS2, OR_ORDER.DELIVERY as DELIVERY, OR_ORDER.COMMNO as COMMNO
                                        FROM LB_DC 
                                        RIGHT JOIN OR_ORDER ON LB_DC.ORNO = OR_ORDER.NO 
                                        RIGHT JOIN OR_OP ON LB_DC.ORNO = OR_OP.ORNO 
                                        WHERE LB_DC.ORNO = ".$orno." AND ((LB_DC.NAME = 10 AND OR_OP.NAME = 10) OR (LB_DC.NAME = 15 AND OR_OP.NAME = 15))
                                        ")
    ->queryAll();
    
    
    
    $n = 0;
    $i = 0;
    $gesamt_zeit = 0;
    $gesamt_zahl = 0;
    $stückzahl = 0;
    $gesamt_dauer = 0;
    $endtermin = 0; 
    $auftrags_status = ""; 
    $endzeitpunkt = 0;
    $liefertermin = "";
    
    $rueck = array();
    
    foreach($anf as $an){$i++;}
    foreach($anf as $an){
        $n++;
        if($n == 1){
            $rueck[0]['linie'] = $an['MSINFO'];
            $rueck[0]['orname'] = $an['ORNAME']; 
            $rueck[0]['startzeitpunkt'] = strtotime($an['MSTIME']);
            $rueck[0]['werkzeug'] = $an['COMMNO'];
            $rueck[0]['descr'] = $an['DESCR'];
        }
        if($n == $i){
            $rueck[0]['endzeitpunkt'] = $an['MSTIME'];
        }
    }
    
    
    $i = 0;
    $n = 0;
    
    foreach($op as $or){$i++;}
    foreach($op as $or){
        $n++;
        $stückzahl = $or['PPARTS'];
        $pte = $or['PTE'];
        $ptr = $or['PTR'];
        $gesamt_dauer = (($stückzahl * $pte) + $ptr) / 3600;  // in Stunden
   
       
        if($n == 1){
           $startzeitpunkt = strtotime($or['MSTIME']);
        }
        if($n == $i){
           $endzeitpunkt = strtotime($or['MSTIME']);
           $interval = $endzeitpunkt - $startzeitpunkt;  // Vergangene Zeit in Sekunden
           $gesamt_zeit = round($interval/3600,2);                      
        }
        
        if($or['STATUS'] == 400 || $or['STATUS'] == 500){
            $gesamt_zahl += $or['ADCCOUNT'];
        }
        if($or['STATUS'] == 500){
            $endtermin = date("d.m.Y  H:i:s",strtotime($or['MSTIME']));
        }
        else if($or['STATUS'] == 400){
            $endtermin = date("d.m.Y  H:i:s",strtotime($or['MSTIME'].'-' . $gesamt_dauer . ' hour'));
        }
  
        if($or['STATUS2'] == 0){
            $auftrags_status = "<x style='background-color:red;color:white;'>Nocht nicht gestartet</x>";
        }
        else if($or['STATUS2'] == 1){
            $auftrags_status = "<x style='background-color:yellow;color:black;'>In Arbeit</x>";
        }
        else if($or['STATUS2'] == 2){
            $auftrags_status = "<x style='background-color:green;color:white;'>Fertig</x>";
        }
            
        $liefertermin = date("d.m.Y",strtotime($or['DELIVERY'])); 
        $werkzeug = $or['COMMNO'];
        $prozent = round($gesamt_zahl / $stückzahl * 100,2);
    
     
        $rueck[$n]["linie"] = $linie;
        $rueck[$n]["orname"] = $orname;
        $rueck[$n]["auftrags_status"] = $auftrags_status; 
        $rueck[$n]["liefertermin"] = $liefertermin; 
        $rueck[$n]["endtermin"] = $endtermin; 
        $rueck[$n]["gesamt_zahl"] = $gesamt_zahl;
        $rueck[$n]["gesamt_zeit"] = $gesamt_zeit; 
        $rueck[$n]["endzeitpunkt"] = $endzeitpunkt;
        $rueck[$n]["startzeitpunkt"] = $startzeitpunkt;
        $rueck[$n]["gesamt_dauer"] = $gesamt_dauer;
        $rueck[$n]["stückzahl"] = $stückzahl;
        $rueck[$n]["prozent"] = $prozent;
        $rueck[$n]["werkzeug"] = $werkzeug;    
        
        }
    
    return $rueck; 
    */
   
   
   
   
   
   public function linien2($linie){
        $rueck = array();
        $rueck[0] = array();
        $rueck[1] = array();
        
        $rueck[0]['messdaten_check'] = 1;
        
        $start = date("Y-d-m H:i:s",strtotime('now -24hours'));
        
        
        $messwerte = Yii::$app->db->CreateCommand("  
        SELECT * FROM (
            SELECT TOP 1850 m3_streckenlog.[ID]
              ,[MSTIME]
              ,[LINIE]
              ,[STRECKE]
              ,[GESCHWINDIGKEIT]
              ,[AUFTRAG]
              ,[ARBEITSSCHRITT]
              ,[UNT_ID]
              ,[UNT_GRUND]
              ,[WERKZEUG]
              ,[BEZEICHNUNG]
            FROM [fauser_v6].[dbo].[m3_streckenlog] LEFT JOIN [dbo].[m3_bezeichnungen] ON m3_streckenlog.UNT_GRUND = m3_bezeichnungen.REFNR
           WHERE LINIE LIKE '".$linie."' ORDER BY ID DESC
                    ) a
            ORDER BY ID ASC")
                    ->queryAll();
                    
        $k = 0;          
        $unterbrechungen = 0;
        $gesamt = 0;
        $geschw = 0;
        $unt100=0;
        $unt101=0;
        $unt102=0;
        $unt103=0;
        $unt104=0;
        $unt105=0;
        $merk_geschwindigkeit = 0;
        foreach($messwerte as $log){
            $rueck[1][$k]['zeit'] = strtotime($log['MSTIME']);
            $rueck[1][$k]['strecke'] = $log['STRECKE'];
           
            ### Geschwindigkeitspeaks in den Messdaten - Probleme bei Geschwindigkeitsberechnung in gesamt.py bei Auftragsumstellung
            if($log['GESCHWINDIGKEIT'] > 10)
                $rueck[1][$k]['geschwindigkeit'] = $merk_geschwindigkeit;
            else{
                $rueck[1][$k]['geschwindigkeit'] = $log['GESCHWINDIGKEIT'];
                $merk_geschwindigkeit = $log['GESCHWINDIGKEIT']; 
            }
            $rueck[1][$k]['auftrag'] = $log['AUFTRAG'];
            $rueck[1][$k]['arbeitsschritt'] = $log['ARBEITSSCHRITT'];
            if($log['ARBEITSSCHRITT'] == 20 && $log['GESCHWINDIGKEIT'] < 0.2)
                 $rueck[1][$k]['arbeitsschritt'] = 5;
            $rueck[1][$k]['unt_id'] = $log['UNT_ID'];
            $rueck[1][$k]['unt_grund'] = $log['BEZEICHNUNG'];
          
            $k++;
            
            $rueck[0]['messdaten_check'] = 1; 
            
     
            if($log['GESCHWINDIGKEIT'] < 0.5){
                $unterbrechungen++;        
            }
            else{
                $geschw += $log['GESCHWINDIGKEIT'];
            }
            
            
            switch($log['UNT_GRUND']) {
                  case 100:
                    $unt100++;
                  break;
                       
                  case 101:
                    $unt101++;
                  break;
                   
                  case 102:
                    $unt102++;
                  break;
                  
                  case 103:
                    $unt103++;
                  break;
                  
                  case 104:
                    $unt104++;
                  break;
                  
                  case 105:
                    $unt105++;
                  break;
                  
                  default:
                     //Anweisung;
                  break;
            }
            
            
            
            
            
            #### Aktuelle Werte werden mit dem letzten Eintrag bestimmt: 
            
            $rueck[0]['v_akut'] = round($log['GESCHWINDIGKEIT'],2);
            $rueck[0]['unt_akut'] = $log['BEZEICHNUNG'];
            $rueck[0]['orno'] = $log['AUFTRAG'];
            $rueck[0]['werkzeug'] = $log['WERKZEUG'];
        }
        
        
        #$or = $this->auftrag($rueck[0]['orno'].".0",0,0);
        $rueck[0]['k'] = $k;
        
        
        $lbdc = $this->auftrag2($rueck[0]['orno']);
        #$strlog = $this->streckenlog($rueck[0]['orno']);
    return $rueck;
   }
   
   
   
    
    ### Notizen: 
    # Auswertung aus streckenlog in eigene Funktion... 
    
 
 
 
 
    
    
    
    
public function auftrag2($orno){
$abfrage = "";

### Eckdaten abfragen: 
#### auftrag
$op = Yii::$app->db->createCommand("SELECT OR_OP.PPARTS as PPARTS, OR_OP.PTE as PTE, OR_OP.PTR as PTR, OR_OP.DESCR as DESCR,
                                    LB_DC.MSTIME as MSTIME, LB_DC.STATUS as STATUS, LB_DC.ADCCOUNT as ADCCOUNT, LB_DC.MSINFO as MSINFO, LB_DC.ORNAME as ORNAME, LB_DC.NAME as NAME,LB_DC.ORNO,
                                    OR_ORDER.STATUS as STATUS2, OR_ORDER.DELIVERY as DELIVERY, OR_ORDER.COMMNO as COMMNO, OR_ORDER.INFO2 as INFO2, OR_ORDER.DESCR as ORDER_DESCR, OR_ORDER.IDENT as IDENT,
                                    PA_ARTPOS.AEINH2 as AEINH2
                                    FROM LB_DC 
                                    RIGHT JOIN OR_ORDER ON LB_DC.ORNO = OR_ORDER.NO 
                                    RIGHT JOIN OR_OP ON LB_DC.ORNO = OR_OP.ORNO 
                                    RIGHT JOIN PA_ARTPOS ON OR_ORDER.IDENT = PA_ARTPOS.ARTDESC
                                    WHERE LB_DC.ORNO = ".$orno." AND OR_OP.NAME = 20
                                    ")
->queryAll();    

if($op == 0) {
    $rueck[0] = 0;
    $rueck[1] = "Keine Daten / Nichts gefunden";
    return $rueck;
}
   
$pt = Yii::$app->db->CreateCommand("SELECT PTR FROM OR_OP WHERE NAME = 10 AND ORNO = ".$orno."")
->queryOne();
 
     
     
     
     
$i = 0;
$n = 0;  ### Die Arbeitsschritte werden ab $rueck[2] aufgelistet
$c = 0;
$merk_ruest = 0; ## Um im 0er Teil zu informieren ob eine Rüstzeit dabei ist oder nicht
$merk_anfahr = 0; ## Falls Anfahrzeit zählt nur die erste => Merker wird gesetzt (doppelte Funktion gegenüber Rüstmerker)
$merk_strecke = 0; ## Um den Ersten Wert nach der Endzeit eines Eintrages einzufangen (Strecke)
foreach($op as $or){
    ### Es wird hier bereits die End- u. Startzeit definiert (letzter Eintrag beschreibt)  um die richtigen Streckendaten rechtzeitig auslesen zu können (nächster Schritt) 
    ### Außerdem für die Graphenauswertung
    if($i == 0)
        $rueck[0]['auftrag_startzeit'] = strtotime($or['MSTIME']);
    
    $rueck[0]['auftrag_endzeit'] = strtotime($or['MSTIME']);    
    $i++;
}

### Falls noch keine Unterbrechung gestempelt wurde:  (Und $i hochgezählt == Stempelungen vorhanden)
if($i){
    if(($rueck[0]['auftrag_startzeit'] == $rueck[0]['auftrag_endzeit']))
        $rueck[0]['auftrag_endzeit'] = strtotime("now");
}

 try{      
### Erst auf 0 setzen, wird ggfs noch geändert im weiteren Verlauf
$rueck[0]['merk_ruest'] = 0;
$rueck[0]['merk_anfahr'] = 0;
$rueck[0]['merk_abruest'] = 0;

   
foreach($op as $or){ 
    ### Die Eckdaten des Auftrags werden im 0er Teil des Arrays gespeichert, danach folgt die chronologische Auflistung der Arbeitsschritte
    if($n==0){
        $rueck[0]['linie'] = $or['MSINFO'];
        $rueck[0]['werkzeug'] = $or['COMMNO'];
        $rueck[0]['liefertermin'] = $or['DELIVERY'];
        $rueck[0]['einzeldauer'] = $or['PTE'];
        $rueck[0]['menge'] = $or['PPARTS'];
        $rueck[0]['gepl_produktions_dauer'] = $or['PTE'] * $or['PPARTS'];
        $rueck[0]['auftrag_status'] = $or['STATUS2']; 
        $rueck[0]['auftrag'] = $or['ORNAME'];
        $rueck[0]['teile_zaehler'] = 0;
        $rueck[0]['bezeichnung'] = $or['ORDER_DESCR'];
        $rueck[0]['art_no'] = $or['IDENT'];
        $rueck[0]['pte'] = $or['PTE'];
        $rueck[0]['orno'] = $orno;
        
        
        // Ergänzung 13.11.2017: Fehlerprävention:
        $rueck[0]['ruestzeit'] = 0;
        $rueck[0]['gepl_ruestzeit'] = 0;
        $rueck[0]['anfahrzeit'] = 0;
        $rueck[0]['gepl_anfahrzeit'] = 0;
        
        
        $rueck[0]['produktions_zeit'] = 0;
        $rueck[0]['mess_strecke_start'] = 0;
        $rueck[0]['mess_strecke_ende'] = 0;
        $rueck[0]['messdaten_check'] = 0;
        // Länge:
        if($or['INFO2'] && is_numeric ($or['INFO2'])){
            $rueck[0]['laenge'] = $or['INFO2'];
        }
        else{
            $rueck[0]['laenge'] = $or['AEINH2'];
        }
        $rueck[0]['gesamt_laenge'] = ($or['PPARTS'] * $rueck[0]['laenge']) / 1000;
        $rueck[0]['gepl_geschwindigkeit'] = $rueck[0]['gesamt_laenge'] / $rueck[0]['gepl_produktions_dauer'] * 60;
        $rueck[0]['vdurchschnitt'] = 0; 

        
       
    }
    
    
    ###### Allgemeine Definitionen; noch keine Auflistung der Arbeitsschritte! 
    ###### Die Merker für Rüst- und Anfahrzeit werden außerdem ins Array übernommen um die Auswertung zu erleichtern
    ## Falls Rüstzeit vorhanden: 
    if($or['NAME'] == 10 && $or['STATUS'] == 300){
        $merk_ruest = 1;
        $rueck[0]['merk_ruest'] = 1;
        $rueck[0]['ruestzeit_start'] = strtotime($or['MSTIME']);

    }
    else if($or['NAME'] == 10 && ($or['STATUS'] == 500 || $or['STATUS'] == 400)){
        $rueck[0]['ruestzeit_ende'] = strtotime($or['MSTIME']);
        $rueck[0]['ruestzeit'] = ($rueck[0]['ruestzeit_ende'] - $rueck[0]['ruestzeit_start']);
        $rueck[0]['gepl_ruestzeit'] = $pt['PTR']/3600;
        $rueck[0]['ruest_differenz'] = ($rueck[0]['ruestzeit'] - $rueck[0]['gepl_ruestzeit']);
        
        
    }
    
    ## Falls Anfahrzeit vorhanden: 
    if($or['NAME'] == 15 && $or['STATUS'] == 300 && $merk_anfahr == 0){
        $rueck[0]['anfahrzeit_start'] = strtotime($or['MSTIME']);
    }
    else if($or['NAME'] == 15 && $or['STATUS'] == 500 && $merk_anfahr == 0){
        $rueck[0]['anfahrzeit_ende'] = strtotime($or['MSTIME']);
        $rueck[0]['merk_anfahr'] = 1;
        $merk_anfahr = 1;
        $rueck[0]['anfahrzeit'] = ($rueck[0]['anfahrzeit_ende'] - $rueck[0]['anfahrzeit_start']);
        $rueck[0]['gepl_anfahrzeit'] = 3600;
        $rueck[0]['anfahr_differenz'] = ($rueck[0]['anfahrzeit'] - $rueck[0]['gepl_anfahrzeit']);
    }

     ## Falls Abrüstzeit vorhanden: 
    if($or['NAME'] == 40 && $or['STATUS'] == 300){
        $rueck[0]['merk_abruest'] = 1;
        $rueck[0]['abruestzeit_start'] = strtotime($or['MSTIME']);
    }
    else if($or['NAME'] == 40 && $or['STATUS'] == 500){
        $rueck[0]['abruestzeit_ende'] = strtotime($or['MSTIME']);
        $rueck[0]['abruestzeit'] = ($rueck[0]['abruestzeit_ende'] - $rueck[0]['abruestzeit_start']);   
    }
   
   
   
    #####
    #####
    #####
    #####

    #### Ab hier Auflistung der Arbeitsschritte: (Ab Array(1)) 
    if($or['STATUS'] == 300){
        $rueck[2][$n]['startzeit'] = strtotime($or['MSTIME']);       
        ## art muss hier schon definiert werden bei fehlenden 400//500 Einträgen
        $rueck[2][$n]['art'] = $or['NAME'];
      
    }
    else if($or['STATUS'] == 400 || $or['STATUS'] == 500){
        $rueck[2][$n]['endzeit'] = strtotime($or['MSTIME']);
        $rueck[2][$n]['laufzeit'] = ($rueck[2][$n]['endzeit'] - $rueck[2][$n]['startzeit']);
        $rueck[2][$n]['status'] = $or['STATUS'];
        $rueck[2][$n]['teile'] = $or['ADCCOUNT'];
        if($or['NAME'] == 20){
            $rueck[0]['teile_zaehler'] += $or['ADCCOUNT'];
            $rueck[0]['produktions_zeit'] += $rueck[2][$n]['laufzeit'];
        }
       
        $n++;
    
    }   
    $c++;
    ###########################
    #### Letzter Eintrag:. Die Dauer des Auftrags wird ohne die Rüstzeit berechnet, die Gesamtstrecke wird als Info hinzugefügt
    if($c==$i){      
        if($merk_anfahr == 1){
            $rueck[0]['auftrag_gesamt_dauer'] = ($rueck[0]['auftrag_endzeit'] - $rueck[0]['anfahrzeit_start']);
            $rueck[0]['gepl_gesamt_dauer'] = $rueck[0]['gepl_produktions_dauer'] + $rueck[0]['gepl_anfahrzeit'];
        }
        else{
            $rueck[0]['auftrag_gesamt_dauer'] = ($rueck[0]['auftrag_endzeit'] - $rueck[0]['auftrag_startzeit']);
            $rueck[0]['gepl_gesamt_dauer'] = $rueck[0]['gepl_produktions_dauer'];
        }
        
        $rueck[0]['auftrag_gesamt_dauer_mrue'] = ($rueck[0]['auftrag_endzeit'] - $rueck[0]['auftrag_startzeit']);
        
        $rueck[0]['zeit_unterbrechnungen'] = ($rueck[0]['auftrag_gesamt_dauer'] - $rueck[0]['produktions_zeit']);
        $rueck[0]['auftrag_dauer_differenz'] = ($rueck[0]['auftrag_gesamt_dauer'] - $rueck[0]['gepl_gesamt_dauer']);
        $rueck[0]['produktions_zeit_differenz'] = $rueck[0]['produktions_zeit'] - $rueck[0]['gepl_produktions_dauer'];    
    }
    
    
    
    }
   
            
    
} catch(Exception $e){
        $rueck[0] = 0;
        $rueck[1] = "Datenfehler: " . $e;
        return $rueck;
    }
    finally{
        if(!array_key_exists('auftrag_gesamt_dauer_mrue',$rueck[0])){
            $rueck[0] = 0;
            $rueck[1] = "Datenfehler";
        }
        return $rueck;
    }
}    
    
 
 
 
 public function streckenlog($orno){
    $rueck = array();
    $rueck[0] = array();
    $rueck[1] =  array(); 
     
    $messwerte = Yii::$app->db->CreateCommand("  
        SELECT m3_streckenlog.[ID]
          ,[MSTIME]
          ,[LINIE]
          ,[STRECKE]
          ,[GESCHWINDIGKEIT]
          ,[AUFTRAG]
          ,[ARBEITSSCHRITT]
          ,[UNT_ID]
          ,[UNT_GRUND]
          ,[WERKZEUG]
          ,[BEZEICHNUNG]
        FROM [fauser_v6].[dbo].[m3_streckenlog] LEFT JOIN [dbo].[m3_bezeichnungen] ON m3_streckenlog.UNT_GRUND = m3_bezeichnungen.REFNR
        WHERE AUFTRAG LIKE '".$orno."'")
                ->queryAll();
                
    $k = 0;          
    $unterbrechungen = 0;
    $gesamt = 0;
    $geschw = 0;
    $unt100=0;
    $unt101=0;
    $unt102=0;
    $unt103=0;
    $unt104=0;
    $unt105=0;
    foreach($messwerte as $log){
        $rueck[1][$k]['zeit'] = strtotime($log['MSTIME']);
        $rueck[1][$k]['strecke'] = $log['STRECKE'];
        $rueck[1][$k]['geschwindigkeit'] = $log['GESCHWINDIGKEIT'];
        $rueck[1][$k]['auftrag'] = $log['AUFTRAG'];
        $rueck[1][$k]['arbeitsschritt'] = $log['ARBEITSSCHRITT'];
        if($log['ARBEITSSCHRITT'] == 20 && $log['GESCHWINDIGKEIT'] < 0.2)
             $rueck[1][$k]['arbeitsschritt'] = 5;
        $rueck[1][$k]['unt_id'] = $log['UNT_ID'];
        $rueck[1][$k]['unt_grund'] = $log['BEZEICHNUNG'];
        
        $k++; 
        
        $rueck[0]['messdaten_check'] = 1; 
        
 
        if($log['GESCHWINDIGKEIT'] < 0.5){
            $unterbrechungen++;        
        }
        else{
            $geschw += $log['GESCHWINDIGKEIT'];
        }
        
        
        switch($log['UNT_GRUND']) {
              case 100:
                $unt100++;
              break; 
                   
              case 101:
                $unt101++;
              break;
               
              case 102:
                $unt102++;
              break;
              
              case 103:
                $unt103++;
              break;
              
              case 104:
                $unt104++;
              break;
              
              case 105:
                $unt105++;
              break;
              
              default:
                 //Anweisung;
              break;
        }
        
        
        
        
    }       
    
    if($k){
        $unt_proz =  round(($unterbrechungen / $k) * 100,2);
        $lauf_proz = 100 - $unt_proz;
        $rueck[0]['vdurchschnitt']  = round($geschw / ($k - $unterbrechungen),2);

        $rueck[0]['unterbrechungen_stunden'] = round($unterbrechungen / 60,2);  
        $rueck[0]['produktion_stunden']  = round(($k - $unterbrechungen) / 60,2);
        $rueck[0]['gesamt_dauer'] = round($k  / 60,2);
     
    }
    $rueck[0]['k'] = $k; 
    
    $rueck[0]['zeit_unt100'] = round($unt100 / 60,2);
    $rueck[0]['zeit_unt101'] = round($unt101 / 60,2);
    $rueck[0]['zeit_unt102'] = round($unt102 / 60,2);
    $rueck[0]['zeit_unt103'] = round($unt103 / 60,2);
    $rueck[0]['zeit_unt104'] = round($unt104 / 60,2);
    $rueck[0]['zeit_unt105'] = round($unt105 / 60,2);
    
    $rueck[0]['prozent_unt100'] = round(($unt100 / $unterbrechungen) * 100,2);
    $rueck[0]['prozent_unt101'] = round(($unt101 / $unterbrechungen) * 100,2);
    $rueck[0]['prozent_unt102'] = round(($unt102 / $unterbrechungen) * 100,2);
    $rueck[0]['prozent_unt103'] = round(($unt103 / $unterbrechungen) * 100,2);
    $rueck[0]['prozent_unt104'] = round(($unt104 / $unterbrechungen) * 100,2);
    $rueck[0]['prozent_unt105'] = round(($unt105 / $unterbrechungen) * 100,2);
     
     
    return $rueck;
}
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'LBNO' => 'Lbno',
            'NAME' => 'Name',
            'OPNO' => 'Opno',
            'OPOPNO' => 'Opopno',
            'ORNAME' => 'Orname',
            'ORNO' => 'Orno',
            'OUT' => 'Out',
            'ADCCOUNT' => 'Adccount',
            'ADCMESS' => 'Adcmess',
            'ADCSTAT' => 'Adcstat',
            'ADCWORK' => 'Adcwork',
            'APARTS' => 'Aparts',
            'ARCHIVE' => 'Archive',
            'ATE' => 'Ate',
            'ATP' => 'Atp', 
            'ATR' => 'Atr',
            'BPARTS' => 'Bparts',
            'BPARTS2' => 'Bparts2',
            'CALTYP' => 'Caltyp',
            'DESCR' => 'Descr',
            'ERRNUM' => 'Errnum',
            'EXSTAT' => 'Exstat',
            'FKLBNO' => 'Fklbno',
            'FNPK' => 'Fnpk',
            'GPARTS' => 'Gparts',
            'INPARTSDBL' => 'Inpartsdbl',
            'ISINTERNAL' => 'Isinternal',
            'MSGID' => 'Msgid',
            'MSINFO' => 'Msinfo',
            'MSTIME' => 'Mstime',
            'MTIME0' => 'Mtime0',
            'MTIME1' => 'Mtime1',
            'MTIME2' => 'Mtime2',
            'MTIME3' => 'Mtime3',
            'OPMULTIMESSAGEGROUP' => 'Opmultimessagegroup',
            'PERSNAME' => 'Persname',
            'PERSNO' => 'Persno',
            'STATUS' => 'Status',
            'TERMINAL' => 'Terminal',
            'WPLACE' => 'Wplace',
            'MATCOST' => 'Matcost',
            'CNAME' => 'Cname',
            'CHNAME' => 'Chname',
            'CDATE' => 'Cdate',
            'CHDATE' => 'Chdate',
            'MANDANTNO' => 'Mandantno',
            'TSTAMP' => 'Tstamp',
        ];
    }
}
