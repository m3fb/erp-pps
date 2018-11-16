<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

/**
 * This is the model class for table "m3_urlaubsplanung".
 *
 * @property int $LBNO
 * @property string $MSTIME
 * @property string $MSTIME2
 * @property string $BESCHREIBUNG
 * @property string $GESAMT_TAGE
 * @property string $TAGE
 * @property string $STUNDEN
 * @property string $PERSNAME
 * @property string $PERSNO
 * @property string $WORKID
 * @property string $STATUS
 * @property string $CNAME
 * @property string $CHNAME
 * @property string $CDATE
 * @property string $CHDATE
 * @property int $BEST
 */
class M3Urlaubsplanung extends \yii\db\ActiveRecord
{
    #public $MSTIME1;
    #public $MSTIME2;

    /**
     * {@inheritdoc}
     */

    public static function tableName()
    {
        return 'm3_urlaubsplanung';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['WORKID','STATUS','MSTIME','MSTIME2'], 'required'],
            [['MSTIME','MSTIME2', 'CDATE', 'CHDATE'], 'safe'],
            [['BESCHREIBUNG', 'PERSNAME', 'CNAME', 'CHNAME'], 'string'],
            [['GESAMT_TAGE', 'TAGE', 'STUNDEN', 'PERSNO', 'WORKID', 'STATUS'], 'number'],
            [['BEST'], 'integer'],
        ];
    }

    /**
    * MSTIME 2 soll im Formular zum Erstellen von Abwesenheitstagen geprüft werden. Wenn aber
    * das Model im GRID aktualisiert wird und es sich um einen "alten" Datensatz handelt, ist
    * MSTIME2 NULL und ein Fehler wird zurückgegeben. Die untenstehende Funktion prüft vor der
    * Standardvaledierung ob der Wert NULL ist und ersetzt diesen ggf. mit dem Wert von MSTIME.
    */
    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            if (!$this->MSTIME2) $this->MSTIME2 = $this->MSTIME;
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'LBNO' => 'L B N O',
            'MSTIME' => 'Startdatum',
            'MSTIME2' => 'Enddatum',
            'BESCHREIBUNG' => 'B E S C H R E I B U N G',
            'GESAMT_TAGE' => 'G E S A M T T A G E',
            'TAGE' => 'Tage',
            'STUNDEN' => 'Stunden',
            'PERSNAME' => 'Name',
            'PERSNO' => 'P E R S N O',
            'WORKID' => 'W O R K I D',
            'STATUS' => 'Status',
            'CNAME' => 'C N A M E',
            'CHNAME' => 'C H N A M E',
            'CDATE' => 'C D A T E',
            'CHDATE' => 'C H D A T E',
            'BEST' => 'B E S T',
        ];
    }


    //Funktion für die Seite: Persönliche Daten.
    public function krankPersoenlicheDaten($id){
      $startdatum = date('01.01.Y',strtotime(date('t.m.Y').' -1 year'));
      $enddatum = date('d.m.Y');
      $jahr = date('Y');
      $startstatus = 802;
      $endstatus = 803;

      $abwesenheitswerte = $this->getOffDates($id,$startdatum,$enddatum,$startstatus,$endstatus);
      $abwesnheit=[];
      //ArrayDataProvider aufbauen; eine Zeile = WORKID / Jahr / Jan / Feb / ..../Dez
      foreach ([$jahr-1,$jahr] as $j) {
        $jahresSumme = 0;
        $abwesnheit_tmp['Jahr'] = $j;
        for ($i=1; $i <=12 ; $i++) {
          $monatsnummer = sprintf('%02d',$i);
          $jahrMonat = $j.$monatsnummer;
          if ($abwesenheitswerte!=0 && isset($abwesenheitswerte[$jahrMonat])) {
             $abwesnheit_tmp[$monatsnummer]=$abwesenheitswerte[$jahrMonat];
             $jahresSumme += $abwesenheitswerte[$jahrMonat];
           }
           else{
             $abwesnheit_tmp[$monatsnummer]=0;
           }
        }

        $abwesnheit_tmp['Summe'] = $jahresSumme;
        $abwesnheit[]=$abwesnheit_tmp;
      }
      $provider = new ArrayDataProvider([
          'allModels' => $abwesnheit,
      ]);

      return $provider;

    }


    public function getOffDates($id,$startdatum,$enddatum,$startstatus,$endstatus)
    {
        $query = $this->find()
        ->select(['CONVERT(date,m3_urlaubsplanung.MSTIME)as MSTIME1','m3_urlaubsplanung.LBNO',
                  'm3_urlaubsplanung.MSTIME','m3_urlaubsplanung.BESCHREIBUNG',
                  'm3_urlaubsplanung.PERSNAME','m3_urlaubsplanung.STATUS','m3_urlaubsplanung.CNAME'])
        ->from('m3_urlaubsplanung')
        ->where(['WORKID'=>$id])
        ->andWhere(['in','STATUS',[$startstatus,$endstatus]])
        ->andWhere(['between','MSTIME',$startdatum,$enddatum])
        ->orderBy('LBNO')
        ->asArray()->all();
        #echo $id .' / '.$startdatum .' / '.$enddatum .' / '.$startstatus .' / '.$endstatus ;

        if (empty($query)) {return 0; exit;}
        //Prüfen ob der erste Eintrag ein Startdatum enthält; wenn nicht wird das Auswertungs-start-datum als Startdum eingesetzt
        if($query[0]['STATUS']!=$startstatus){
          $new_first_arr = [
            'MSTIME1'=>Yii::$app->formatter->asDate($startdatum, 'yyyy-MM-dd'),
            'LBNO'=>$query[0]['LBNO'] -1,
            'MSTIME'=>Yii::$app->formatter->asDate($startdatum, 'yyyy-MM-dd'),
            'BESCHREIBUNG'=>'manueller Start_Eintrag',
            'PERSNAME'=>$query[0]['PERSNAME'],
            'STATUS'=>$startstatus,
            'CNAME' => 'm3-Intranet'
          ];
          array_unshift($query,$new_first_arr);
        }

        //Prüfen ob der letze Eintrag ein Enddatum enthält; wenn nicht, wird das Auswertungs-end-datum als Enddatum eingesetzt
        if($query[count($query) -1]['STATUS']!=$endstatus){
          $new_last_arr = [
            'MSTIME1'=>Yii::$app->formatter->asDate($enddatum, 'yyyy-MM-dd'),
            'LBNO'=>$query[count($query) -1]['LBNO'] +1,
            'MSTIME'=>Yii::$app->formatter->asDate($enddatum, 'yyyy-MM-dd'),
            'BESCHREIBUNG'=>'manueller End_Eintrag',
            'PERSNAME'=>$query[0]['PERSNAME'],
            'STATUS'=>$endstatus,
            'CNAME' => 'm3-Intranet'
          ];
          array_push($query,$new_last_arr);
        }
        $startwerte=[];
        $endwerte=[];
        //Array mit allen Startdaten erstellen
        foreach ($query as $key => $value) {
          if($value['STATUS']==$startstatus) {
            $startwerte[]=$query[$key];
          }
          elseif($value['STATUS']==$endstatus) {
            $endwerte[]=$query[$key];
          }
        }
        // Array bereinigen.
        //Problematik: Es können für einen Abwesenheistszeitraum mehere Einträge existieren. Daher muss geprüft werden
        // ob ein Start-,Enddatum zweimal vorhanden ist. Wenn ja, dann muss das Eintragspärchen mit dem größeren Enddatum
        // oder dem kleineren Startdatum für die Ausertung gewählt werden.

        //Prüfen ob Startdatum doppelt vorhanden und wenn ja die restlichen Startdatums löschen,
        // das höchste Enddatum finden und die restlichen Enddatums löschen
        $doppeltesStartdatum=[];
        $doppeltesEnddatum=[];
        $startdatum=[];
        $enddatum=[];
        foreach ($startwerte as $key => $value){
            $skey = array_keys(array_column($startwerte, 'MSTIME1'),$value['MSTIME1']);
              if(count($skey)>1) {
                foreach ($skey as $v) {
                  if(!in_array($startwerte[$v]['LBNO'],$doppeltesStartdatum)){
                    $doppeltesStartdatum[]=$startwerte[$v]['LBNO'];
                    $querykey=array_search($startwerte[$v]['LBNO'],array_column($query, 'LBNO'));
                    $enddatum[$querykey+1]=$query[$querykey+1]['MSTIME1'];
                  }
                }
              }
        }
        foreach ($endwerte as $key => $value){
            $skey = array_keys(array_column($endwerte, 'MSTIME1'),$value['MSTIME1']);
              if(count($skey)>1) {
                foreach ($skey as $v) {
                  if(!in_array($endwerte[$v]['LBNO'],$doppeltesEnddatum)){
                    $doppeltesEnddatum[]=$endwerte[$v]['LBNO'];
                    $querykey=array_search($endwerte[$v]['LBNO'],array_column($query, 'LBNO'));
                    $startdatum[$querykey-1]=$query[$querykey-1]['MSTIME1'];
                  }
                }
              }
        }
        foreach ($enddatum as $key => $value) {
          //wenn mehrere Enddatums vorhanden sind und der Werk kleiner oder gleich dem max. Enddatum entspricht,
          // wird der Wert aus dem Enddatumsarray und das Wertepaar ($key & $key-1) aus dem Hauptarray gelöscht.
          if (count($enddatum)>1 && $value<=max($enddatum)) {
            unset($enddatum[$key]);
            unset($query[$key]);
            unset($query[$key-1]);
          }
        }
        foreach ($startdatum as $key => $value) {
          //wenn mehrere Enddatums vorhanden sind und der Werk kleiner oder gleich dem max. Enddatum entspricht,
          // wird der Wert aus dem Enddatumsarray und das Wertepaar ($key & $key-1) aus dem Hauptarray gelöscht.
          if (count($startdatum)>1 && $value>=min($startdatum)) {
            unset($startdatum[$key]);
            unset($query[$key]);
            unset($query[$key+1]);
          }
        }

        //Paare bilden und Funktionen übergeben
        $i=0;
        $startwert;
        $endwert;
        foreach($query as $key=>$value){


          if($value['STATUS']==$startstatus && !isset($startwert)){
            $startwert = $value['MSTIME1'];
          }
          elseif ($value['STATUS']==$endstatus && !isset($endwert)){
            $endwert = $value['MSTIME1'];
            $intervall = dateDiffTotal($startwert,$endwert,'d'); // da der Starttag mitberechnet wird muss bei der Zeitdifferenzrechnung ein Tag dazuaddiert werden
            $abwesendJeMonat[] = abwesenheitMonatsaufteilung($startwert,$intervall); //Array mit JahresMonats=>Abwesenheitstagen je Datenpaar
            $startwert=NULL;
            $endwert=NULL;
          }
          $i++;
        }
        //Monatswerte summieren Ergebnis: JahresMonats=>SUMME der Abwesenheitstagen
        $abwesendJeMonatGruppiert=[];
        foreach($abwesendJeMonat as $group) {
            foreach($group as $key => $value) {
                if(!isset($abwesendJeMonatGruppiert[$key])) $abwesendJeMonatGruppiert[$key] = $value;
                else $abwesendJeMonatGruppiert[$key] += $value;
            }
        }

        return $abwesendJeMonatGruppiert;
    }

    public function getOffDatesOverview($aktivesPersonal,$startdatum,$enddatum,$startstatus,$endstatus)
    {
      $aktivesPersonal2 = [0=>['NO'=>307421,'SURNAME'=>'Zakaryan','FIRSTNAME'=>'Arthur']];
      list ($starttag, $startmonat, $startjahr) = explode('.', $startdatum);
      list ($endtag, $endmonat, $endjahr) = explode('.', $enddatum);
      $startindex=$startjahr.$startmonat;
      $endindex=$endjahr.$endmonat;
      $abwesnheit=[];
      foreach ($aktivesPersonal as $pers_id) {
        $summe = 0;
        $abwesenheitswerte = $this->getOffDates($pers_id['NO'],$startdatum,$enddatum,$startstatus,$endstatus);
        for ($i=$startindex; $i <=$endindex ; $i++) {
          #$monatsnummer = sprintf('%02d',$i);
          #$jahrMonat = $j.$monatsnummer;
          if ($abwesenheitswerte!=0 && isset($abwesenheitswerte[$i])) {
             $abwesnheit_tmp[$i]=$abwesenheitswerte[$i];
             $summe += $abwesenheitswerte[$i];
           }
           else{
             $abwesnheit_tmp[$i]=0;
           }
           if (substr($i , -2) == 12) $i=$i+88; //Wenn der JahresMonatsIndex = Jahr12 dann wird umm 88 auf das nächste Jahr erhöht.
        }
        $abwesnheit_tmp['Summe'] = $summe;
        $abwesnheit_tmp['ID'] = $pers_id['NO'];
        #$abwesnheit_tmp['PERSNO'] = $pers_id['PERSNO'];echo 3; die;
        $abwesnheit_tmp['Name'] = $pers_id['SURNAME'].', '. $pers_id['FIRSTNAME'];
        $abwesnheit[]=$abwesnheit_tmp;
        #echo $pers_id['NO'].' '.$pers_id['SURNAME'].', '. $pers_id['FIRSTNAME'].'<br>';
      }

      $provider = new ArrayDataProvider([
          'allModels' => $abwesnheit,
          'sort' => [
              'attributes' => ['Summe', 'Name'],
              'defaultOrder' => ['Name'=>SORT_ASC]
          ],
          'pagination' => [
              'pageSize' => 0,
          ],

      ]);

      return $provider;
    }
}
