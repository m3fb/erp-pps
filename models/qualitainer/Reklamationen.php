<?php

namespace app\models\qualitainer;


use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\db\Query;

/**
 * model tbl_Reklamationen
 *
 * @property int $OID
 * @property string $Reklamationstyp
 * @property string $Reklamationsdatum
 */
class Reklamationen extends \yii\db\ActiveRecord
{

    public $Wirkungsfaktor;
    public $wfaktor;
    public $ges;
    public $m12;
    public $m6;
    public $m3;
    public $Form_Nummer;
    public $Teilenummer;
    public $Kurzbezeichnung;
    public $ParentElement;
    public $Fehler;
    public $Ursachentheorie;
    public $attribut;
    public $count;
    public $Verursacher;
    public $Vorname;
    public $Nachname;
    public $Langebzeichnung;
    public $Problembeschreibung;
    public $ErfasstVon;
    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db2');
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_Reklamationen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['GP_ID', 'AP_ID','Status'], 'integer'],
            [['Reklamationstyp', 'Reklamationsnummer','Wirkungsfaktor','Form_Nummer','attribut','count','ErfasstVon'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Reklamationstyp' => 'Reklamationstyp',
            'Reklamationsnummer' => 'Reklamationsnummer',
        ];
    }

    public function search($params,$Wirkungsfaktor,$month,$attribut)
    {
        $query = $this->find();

        if ($month!=0){
          $time = strtotime("-".$month." months", time());
          $date = date("d.m.Y", $time);
        }
        else $date = 0;

        /**
        *Wenn die Teilenummer nicht numerisch ist, die Form_Nummer = NULL ist und die Artikelgruppe "Werkzeuge und Zuberhör" ist dann ist die Artikelnummer = auswertungsAttribut
        *wenn die Form_Nummer nicht null ist
        **/
        $query
              ->select([
                        'tbl_Reklamationen.Reklamationstyp',
                        'tbl_Reklamationen.Reklamationsnummer',
                        'tbl_Reklamationen.Reklamationsdatum',
                        'tbl_Reklamationen.GP_ID',
                        'tbl_Reklamationen.AP_ID',
                        'tbl_Reklamationen.Priorität',
                        'tbl_Reklamationen.Status',
                        'tbl_Reklamation_Position_Fehler.ParentElement',
                        'tbl_Reklamation_Position_Fehler.Fehler',
                        'tbl_Reklamation_Position_Fehler.OID as F_OID',
                        'tbl_Reklamation_Position_IshikawaDiagramm.Wirkungsfaktor',
                        'tbl_Reklamation_Position_IshikawaDiagramm.Ursachentheorie',
                        'case
                      		when isnumeric(tbl_Artikel.Teilenummer)=0 and tbl_Artikel.Form_Nummer is null and tbl_Artikel.Produktgruppe like \'Werkzeuge und Zubehör\'
                      			then tbl_Artikel.Teilenummer
                      		 when isnumeric(tbl_Artikel.Teilenummer)=1 and tbl_Artikel.Form_Nummer is not null
                      			then tbl_Artikel.Form_Nummer
                          when tbl_Artikel.Teilenummer is not null or tbl_Artikel.Teilenummer <>\'\'
                      			then tbl_Artikel.Teilenummer
                      		else \'ohne Zuordnung\'
                      	  end as attribut',
                        'case
                              when [tbl_Versursacher].[Verursacher] is not null or [tbl_Versursacher].[Verursacher] <>\'\'
                                then [tbl_Versursacher].[Verursacher]
                              else \'ohne Zuordnung\'
                            end as Verursacher',
                        'tbl_Artikel.Teilenummer',
                    	  'tbl_Artikel.Kurzbezeichnung',
                    	  'tbl_Artikel.Form_Nummer',
                    ])

              ->from('tbl_Reklamationen')

              ->leftJoin('tbl_Reklamation_Position_Fehler', 'tbl_Reklamation_Position_Fehler.REK_ID = tbl_Reklamationen.Reklamationsnummer')
              ->leftJoin('tbl_Reklamation_Position_IshikawaDiagramm', 'tbl_Reklamation_Position_IshikawaDiagramm.POS_ID = tbl_Reklamation_Position_Fehler.POS_ID')
              ->leftJoin('tbl_Artikel', 'tbl_Artikel.OID = tbl_Reklamation_Position_Fehler.ART_ID')
              ->leftJoin('tbl_Versursacher', 'tbl_Versursacher.OID = tbl_Reklamation_Position_IshikawaDiagramm.Verursacher')

              ->where(['in','Reklamationstyp',[1,2]])
              ->andWhere(['>','Reklamationsdatum',$date])
              ->andWhere(['Wirkungsfaktor'=>$Wirkungsfaktor]);

        $this->load($params);


        $query->andFilterWhere(['Reklamationsnummer' => $this->Reklamationsnummer])
              ->andFilterWhere(['like', 'Wirkungsfaktor', $this->Wirkungsfaktor]);

        $tmp_model = $query->all();

        // Wirkungsfaktor 'Mensch' wird nicht mit Attribut sortiert, sondern mit Verursacher
        ($Wirkungsfaktor=='Mensch') ?  $spalte ='Verursacher': $spalte = 'attribut';

        $model = array_filter($tmp_model,function ($var) use ($spalte,$attribut){
              return($var[$spalte] == $attribut);
            }
          );
        $dataProvider = new ArrayDataProvider([
            'allModels' => $model,
            'pagination' => [
                'pageSize' => 0,
            ],
          ]
        );

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }
    /**
    * Gruppierte Daten zum Darstellen Anzahl Reklamationen je Attribut (=Form_Nummer, Teilnummer usw.)
    * Problematik: Gruppierung kann nicht in SQL Abfrage erfolgen, da nach dem "virtuellen" Element Attribut gruppiert werden muss.
    * Beim Wirkungsfaktor 'Mensch' wird nicht mit Attribut sortiert, sondern mit Verursacher
    **/
    public function getGroupedDatas($Wirkungsfaktor,$month,$attribut,$env)
    {
        $query = $this->find();

        //Aktuelles Datum minus Monatsdifferenz
        if ($month!=0){
          $time = strtotime("-".$month." months", time());
          $date = date("d.m.Y", $time);
        }
        else $date = 0;

        $query
              ->select([
                        'tbl_Reklamationen.Reklamationstyp',
                        'tbl_Reklamation_Position_Fehler.OID as F_OID',
                        'tbl_Reklamation_Position_IshikawaDiagramm.Wirkungsfaktor',
                        'case
                      		when isnumeric(tbl_Artikel.Teilenummer)=0 and tbl_Artikel.Form_Nummer is null and tbl_Artikel.Produktgruppe like \'Werkzeuge und Zubehör\'
                      			then tbl_Artikel.Teilenummer
                      		 when isnumeric(tbl_Artikel.Teilenummer)=1 and tbl_Artikel.Form_Nummer is not null
                      			then tbl_Artikel.Form_Nummer
                          when tbl_Artikel.Teilenummer is not null or tbl_Artikel.Teilenummer <>\'\'
                      			then tbl_Artikel.Teilenummer
                      		else \'ohne Zuordnung\'
                      	  end as attribut',
                        'case
                            when [tbl_Versursacher].[Verursacher] is not null or [tbl_Versursacher].[Verursacher] <>\'\'
                              then [tbl_Versursacher].[Verursacher]
                            else \'ohne Zuordnung\'
                          end as Verursacher',
                        'tbl_Artikel.Teilenummer',
                    	  'tbl_Artikel.Form_Nummer',

                    ])

              ->from('tbl_Reklamationen')

              ->leftJoin('tbl_Reklamation_Position_Fehler', 'tbl_Reklamation_Position_Fehler.REK_ID = tbl_Reklamationen.Reklamationsnummer')
              ->leftJoin('tbl_Reklamation_Position_IshikawaDiagramm', 'tbl_Reklamation_Position_IshikawaDiagramm.POS_ID = tbl_Reklamation_Position_Fehler.POS_ID')
              ->leftJoin('tbl_Artikel', 'tbl_Artikel.OID = tbl_Reklamation_Position_Fehler.ART_ID')
              ->leftJoin('tbl_Versursacher', 'tbl_Versursacher.OID = tbl_Reklamation_Position_IshikawaDiagramm.Verursacher')

              ->where(['in','Reklamationstyp',[1,2]])
              ->andWhere(['>','Reklamationsdatum',$date])
              ->andWhere(['Wirkungsfaktor'=>$Wirkungsfaktor]);

        /**
        * Hier werden die Vorkommnisse von 'attribut' oder 'Verursacher' gezählt und einem Array hinzugefügt um diese dann
        * dem jeweiligen Datensatz hinzugefügt.
        **/
        $model = $query->all(); //Array erzeugen
        $counts = array();

        //Prüfen ob der Wirkungsfaktor 'Mensch' ist
        ($Wirkungsfaktor=='Mensch') ?  $spalte ='Verursacher': $spalte = 'attribut';

        foreach ($model as $key=>$subarr) {
          // attribut zählen falls es existiert
          if (isset($counts[$subarr[$spalte]])) {
            $counts[$subarr[$spalte]]++;
          }

          else $counts[$subarr[$spalte]] = 1;

          $counts[$subarr[$spalte]] = isset($counts[$subarr[$spalte]]) ? $counts[$subarr[$spalte]]++ : 1;

        }
        //Den Summenwert von Attribut zum aktuellen Datensatz hinzuzufügen
        foreach ($model as $key=>$subarr) {
          $model[$key]['count'] = $counts[$subarr[$spalte]];
        }
        // Den Array nach den hinzugefügten Summenwert sortieren
        ArrayHelper::multisort($model, ['count', $spalte], [SORT_DESC, SORT_ASC]);
        //...und danach gruppieren
        $groupedModel = array();
        foreach ($model as $key) {
            $groupedModel[$key[$spalte]] = $key;
        }
        //Ausgabe in einen Panel in Listenform
        $groupedDataContent = '<ul class="list-group">';
        $z='';
        $i=0;
        foreach($groupedModel as $gm){
          ($gm [$spalte] == $attribut) ? $labelOption = 'success': $labelOption ='default';
          $attributLabel = '<span class="label label-'.$labelOption.'" style="margin-right:5px;font-size:80%;">'.$gm[$spalte].'</span>';
          $attributLabelLink = Html::a($attributLabel,
                ['auswertung', 'wirkungsfaktor'=>$Wirkungsfaktor,'month'=>$month, 'attribut'=>$gm[$spalte],'env'=>$env]
              );
          //Erste Zeile;
          if ($i == 0) {
            $groupedDataContent .='<li class="list-group-item">'. $gm['count'].' Fehler:&nbsp;'. $attributLabelLink; $z = $gm['count'];
            $i++;
              }
          //neue Zeile
          elseif ($i != 0 && $z != $gm['count']){
            $groupedDataContent .='</li><li class="list-group-item">'. $gm['count'].' Fehler:&nbsp;'. $attributLabelLink;
            $z = $gm['count'];
            $i++;
          }
          else{
            $groupedDataContent .= $attributLabelLink;
            $i++;
          }

        }
        $groupedDataContent .= '</li></ul>';
        $groupedData =
          '<div class="panel panel-danger">
            <div class="panel-heading"><h3 class="panel-title">Wirkunsfaktor: <b>'.$Wirkungsfaktor .' </b>/ '.$month.' Monate</h3></div>
              <div class="panel-body">'
                .$groupedDataContent.
              '</div>
          </div>';
        return $groupedData;
    }

    /**
    *Datensätze für eine Trenddarstellung generieren.
    *Für jeden Wirkungsfaktor wird ein 12-Monats, 6-Monats und ein 3-Monats Wert berechnet.
    *Als Trendindex werden Reklamationen je Monat berechnet und somit ein Trend ermittelt,
    *Die Daten werden in einem mehrdimensionalen Array weitergegeben.
    * $werte[]=[
    *    'wfaktor' => $wf,      //Wirkungsfaktor,
    *    'ges' => $w['ges'],     // Anzahl der gesamten Reklamationen
    *    'm12' => $w[12],      // Anzahl der Reklamationen in den letzten 12 Monaten
    *    'm6' => $w[6],
    *    'm3' => $w[3],
    * ];
    *
    **/
    public function getTrend ()
    {
      $Wirkungsfaktoren = ['Mensch','Maschine','Material','Methode','Mitwelt','Management'];
      $werte = [];
      $months = [12,6,3];

      foreach($Wirkungsfaktoren as $wf)
      {
        $w['ges'] =$this->getTotalSum($wf);
        foreach($months as $m)
        {
          $w[$m] =$this->getSum($wf,$m);
        }
        //Index ausrechnen
        //6 Monats Index
        //Beide Werte nicht 0
        if($w[12]!=0 && $w[6] !=0){
          $m6i = round(( (($w[6] / 6) / ($w[12] / 12))  * 100 ) -100 );
        }
        elseif($w[12]==0 && $w[6] ==0){
          $m6i=0;
        }
        else {
          ($w[12] == 0)? $m6i=101 : $m6i =-101;
        }
        //3 Monats Index
        //Beide Werte nicht 0
        if($w[6]!=0 && $w[3] !=0){
          $m3i = round(( (($w[3] / 3) / ($w[6] / 6))  * 100 ) -100 );
        }
        elseif($w[6]==0 && $w[3] ==0){
          $m3i=0;
        }
        else {
          ($w[6] == 0)? $m3i=101 : $m3i =-101;
        }
        $werte[]=[
          'wfaktor' => $wf,
          'ges' => $w['ges'],
          'm12' => $w[12],
          'm6' => $w[6],
          'm3' => $w[3],
          'm6i' => $m6i,
          'm3i' => $m3i,
        ];
      }
      $provider = new ArrayDataProvider([
          'allModels' => $werte,
          'sort' => [
              'defaultOrder' => ['m12'=>['default' => SORT_DESC]],
              'attributes' => [
                'ges'=>['default' => SORT_DESC],
                'm12'=>['default' => SORT_DESC],
                'm6'=>['default' => SORT_DESC],
                'm3'=>['default' => SORT_DESC]
              ],
          ],

      ]);

      return $provider;
    }

    public function getSum($Wirkungsfaktor,$month)
    {
      $time = strtotime("-".$month." months", time());
      $date = date("d.m.Y", $time);

      $sum = $this->find()
          ->leftJoin('tbl_Reklamation_Position_Fehler', 'tbl_Reklamation_Position_Fehler.REK_ID = tbl_Reklamationen.Reklamationsnummer')
          ->leftJoin('tbl_Reklamation_Position_IshikawaDiagramm', 'tbl_Reklamation_Position_IshikawaDiagramm.POS_ID = tbl_Reklamation_Position_Fehler.POS_ID')
          ->where(['in','Reklamationstyp',[1,2]])
          ->andWhere(['>','Reklamationsdatum',$date])
          ->andWhere(['Wirkungsfaktor'=> $Wirkungsfaktor])
          ->count();

      return $sum;
    }



    public function getTotalSum($Wirkungsfaktor)
    {
      $sum = $this->find()
          ->leftJoin('tbl_Reklamation_Position_Fehler', 'tbl_Reklamation_Position_Fehler.REK_ID = tbl_Reklamationen.Reklamationsnummer')
          ->leftJoin('tbl_Reklamation_Position_IshikawaDiagramm', 'tbl_Reklamation_Position_IshikawaDiagramm.POS_ID = tbl_Reklamation_Position_Fehler.POS_ID')
          ->where(['in','Reklamationstyp',[1,2]])
          ->andWhere(['Wirkungsfaktor'=> $Wirkungsfaktor])
          ->count();

          return $sum;
    }

    public function getInterneReklamationen($params)
    {
      $query = $this->find();
      // Reklamationen der letzen 12 Monate berücksichtigen
      $time = strtotime("-12 months", time());
      $date = date("d.m.Y", $time);


      $query
            ->select([
              'tbl_Reklamationen.Reklamationsnummer',
              'tbl_Reklamationen.OID',
              'tbl_Reklamationen.Bearbeitungsstand',
              'tbl_Reklamationen.Status',
              'tbl_Reklamation_Typen.Typ', 'tbl_Reklamationen.ErfasstAm',
              'tbl_Reklamationen.ErfasstVon',
              'tbl_Reklamation_Position.Problembeschreibung',
              'tbl_Artikel.Form_Nummer', 'tbl_Artikel.Langebzeichnung',
              'tbl_Artikel.Teilenummer', 'tbl_mUser.Vorname',
              'tbl_mUser.Nachname',
              'tbl_Reklamation_Position.Reklamiert',
              'tbl_Reklamation_Position.Reklamiert_Einheit',
              'tbl_Reklamation_Position.OID as tbl_Reklamation_Position_OID'
                  ])

            ->from('tbl_Reklamationen')

            ->leftJoin('tbl_Reklamation_Typen', 'tbl_Reklamation_Typen.OID = tbl_Reklamationen.Reklamationstyp')
            ->leftJoin('tbl_Reklamation_Position', 'tbl_Reklamation_Position.REK_ID = tbl_Reklamationen.OID')
            ->leftJoin('tbl_Artikel', 'tbl_Artikel.OID = tbl_Reklamation_Position.ART_ID')
            ->leftJoin('tbl_mUser', 'tbl_mUser.OID = tbl_Reklamationen.ErfasstVon')

            ->where(['Reklamationstyp'=> 2])
            ->andWhere(['<>','tbl_Reklamationen.Status',4])

            ->orWhere(['Reklamationstyp'=> 2])
            ->andWhere(['>','Reklamationsdatum',$date])

            ->orderBy(['tbl_Reklamationen.Status' => SORT_ASC,'tbl_Reklamationen.ErfasstAm'=>SORT_DESC]);


      $this->load($params);


      $query->andFilterWhere(['Reklamationsnummer' => $this->Reklamationsnummer])
            ->andFilterWhere(['Status' => $this->Status])
            ->andFilterWhere(['like', 'ErfasstVon', $this->ErfasstVon]);

      $model = $query->all();

      $dataProvider = new ArrayDataProvider([
          'allModels' => $model,
          'pagination' => [
              'pageSize' => 10,
          ],
        ]
      );

      if (!$this->validate()) {
          // uncomment the following line if you do not want to return any records when validation fails
          // $query->where('0=1');
          return $dataProvider;
      }

      return $dataProvider;
    }

    public function getMassnahme($oid)
    {
      return "1";
    }



}
