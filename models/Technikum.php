<?php

namespace app\models;

use Yii;

class Technikum extends \yii\db\ActiveRecord
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
    
    
    
    

     
     
public function hol_status(){
    Yii::$app->db->CreateCommand("
    SELECT TOP 1 * FROM m3_pilog WHERE LINIE LIKE 'Linie 13' OR   ORDER BY LINIE DESC 
    ")
    ->queryAll();
    
    
}
   
   
   
### Abfrage über Qualitainer
public function reklamationen(){
    $tables = Yii::$app->db2->CreateCommand("
        SELECT tbl_Reklamationen.ErfasstAm as Reklamationsdatum, tbl_Reklamation_Position.Fehlermeldung as Fehlermeldung, (tbl_mUser.Vorname + ' ' + tbl_mUser.Nachname) as Name,
        tbl_Artikel.Form_Nummer as Werkzeug, tbl_Reklamationen.OID as oid
        FROM tbl_Reklamationen
        left JOIN tbl_Reklamation_Position
        ON tbl_Reklamationen.Reklamationsnummer = tbl_Reklamation_Position.OID
        left JOIN tbl_mUser
        ON tbl_Reklamationen.ErfasstVon = tbl_mUser.OID
        left JOIN tbl_Artikel
        ON tbl_Reklamation_Position.ART_ID = tbl_Artikel.OID
        WHERE tbl_Reklamationen.Status = 1 and tbl_Reklamationen.Reklamationstyp=2
    ")
    ->queryAll();
    
    $i=0;
    $rueck = array();
    foreach($tables as $type){
        $rueck[$i] = $type;
        $rueck[$i]['Reklamationsdatum'] = date("d.m.Y H:i",strtotime($type['Reklamationsdatum']));
    }
    
    return $rueck;
}
### 

public function tech_mitarbeiter(){

    $tables = Yii::$app->db->CreateCommand(" 
        SELECT FIRSTNAME+' '+SURNAME as PERSNAME, PERSNO FROM PE_WORK
        INNER JOIN FAG_DETAIL 
        ON PE_WORK.NO = FAG_DETAIL.FKNO 
        WHERE FAG_DETAIL.TYP = 26 AND FAG_DETAIL.TXT02 LIKE 'Technikum' 
        ")
        
    ->queryAll();

    return $tables;

}    
   
   
   
   
public function todo_liste(){
    $tables = Yii::$app->db->CreateCommand(" 
                SELECT * FROM m3_todo WHERE department LIKE 'Technikum' AND pruef <> 1 ORDER BY due_date ASC
                ") 
              ->queryAll(); 
          
    $i = 0;
    foreach($tables as $type){
        if((strtotime($type['due_date']) >= (strtotime('now')-691200)) && (strtotime($type['due_date']) <= (strtotime('now') + 691200))) {
            $rueck[$i] = $type;
            if(!$type['beauftragter']){
                $rueck[$i]['beauftragter'] = "Alle";
            }
            $rueck[$i]['due_date'] = date("d.m.Y",strtotime($type['due_date']));
            $i++;
        }
    }
    return $rueck;     
}


public function todo_loesch_zyklus($id){

    $tables = Yii::$app->db->CreateCommand(" SELECT * FROM m3_todo WHERE id = ".$id."")
    ->queryAll();
    
    if($tables[0]['zyklus'] !== ""){
        if($tables[0]['zyklus'] == "woechentlich"){
            $new_due_date = strtotime($tables[0]['due_date'] ."+1 weeks");
        }
        else if($tables[0]['zyklus'] == "monatlich"){
            $new_due_date = strtotime($tables[0]['due_date'] ."+1 months");
        }
        else if($tables[0]['zyklus'] == "halbjaehrlich"){
             $new_due_date = strtotime($tables[0]['due_date'] ."+6 months");
        }
        else if($tables[0]['zyklus'] == "jaehrlich"){
             $new_due_date = strtotime($tables[0]['due_date'] ."+1 year");
        }
        
        
        Yii::$app->db->CreateCommand(" UPDATE m3_todo 
                                        SET due_date = '".date("Y-d-m",$new_due_date)."',
                                            pruef = 0
                                        WHERE id = ".$id."")
        ->execute();
        
        return 1;
        
    }
    else{
        Yii::$app->db->CreateCommand(" DELETE FROM m3_todo WHERE id = ".$id." ")
        ->execute();
    }
    return 1; 
   
}
public function todo_zyklus_komplett(){
    $tables = Yii::$app->db->CreateCommand("SELECT * FROM m3_todo_zyklus")
    ->queryAll();
    return $tables;  
}





public function todo_pruef_anzeigen(){
    
    
    ### Der Zyklus wird in Tagen angegeben 
    
    
    $rueck = array();
    $tables = Yii::$app->db->CreateCommand(" 
                SELECT * FROM m3_todo WHERE pruef = 1 ORDER BY due_date
                ") 
                ->queryAll();
                
    $i = 0;
    foreach($tables as $type){
        ## 8tage vorher)
        // if((strtotime($type['due_date']) >= (strtotime('now')-691200)) && (strtotime($type['due_date']) <= (strtotime('now') + 691200))) {
                $rueck[$i] = $type;
                $rueck[$i]['due_date'] = date("d.m.Y",strtotime($type['due_date']));
                $i++;
        // }
        
    

    }    
    
                
    return $rueck; 
}
public function todo_best($id) {



}    
    
   
    
    
    
public function todo_eingabe($date,$ndate,$zyklus,$prio,$text,$beauftragter){
    
    Yii::$app->db->CreateCommand(" 
    INSERT INTO m3_todo_zyklus 
        (
        [DATE]
        ,[NDATE]
        ,[ZYKLUS]
        ,[PRIO]
        ,[TEXT]
        ,[BEAUFTRAGTER]
        )
    VALUES
        (
        '".$date."'
       ,'".$ndate."'
       ,".$zyklus."
       ,".$prio."
       ,'".$text."'
       ,'".$beauftragter."'
       )
       
       ")
       ->execute();
       
       return 1;
    
    
}
    
public function todo_erledigt($id,$start,$zyklus){

    // $neu_start = date("Y-d-m H:i:s", strtotime($start. " +" . (int)$zyklus ." days"));
    // $neu_ende = date("Y-d-m",strtotime($ende . " +" . (int)$zyklus ." days"));

    
    
    Yii::$app->db->CreateCommand("
        UPDATE m3_todo SET 
            pruef = 1
           
        WHERE id = ".$id."



    ")
    ->execute();
    return $id;
}    
    
    
public function todo_zurueck_zyklus($id){

    // $neu_start = date("Y-d-m H:i:s", strtotime($start. " +" . (int)$zyklus ." days"));
    // $neu_ende = date("Y-d-m",strtotime($ende . " +" . (int)$zyklus ." days"));

    
    
    Yii::$app->db->CreateCommand("
        UPDATE m3_todo SET 
            pruef = 0
           
        WHERE id = ".$id."



    ")
    ->execute();
    return 1;
}    
    
    
    
public function todo_pruef($id,$start,$zyklus){

    
    
    $neu_start = date("Y-d-m H:i:s", strtotime($start. " +" . (int)$zyklus ." days"));
    

    
    
    Yii::$app->db->CreateCommand("
        UPDATE m3_todo SET 
            due_date = '".$neu_start."'
           
        WHERE id = ".$id."



    ")
    ->execute();
    return 1;
}    
    
    
    
      
    
    
   
public function aktiv(){
    
    
   $now = date("Y-d-m H:i:s",strtotime('now -30days'));
   
   $tables = Yii::$app->db->CreateCommand(" 
        SELECT t.MSTIME, t.STATUS, t.ORNO, t.PERSNO, t.PERSNAME FROM LB_DC t
        INNER JOIN (
            SELECT max(LB_DC.STATUS) as maxstat, ORNO FROM LB_DC
            GROUP BY ORNO
            ) tm 
        ON t.ORNO = tm.ORNO AND tm.maxstat = 300 
        WHERE t.MSTIME > '2017-18-08 22:00:00'
            
    ")
    ->queryAll();
    
    
    return $tables;
    
    
    
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
