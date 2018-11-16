<?php

namespace app\models\qualitainer;

use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\db\Query;

/**
 * This is the model class for table "{{%tbl_MM}}".
 *
 * @property int $OID
 * @property string $Titel
 * @property string $Beschreibung
 * @property int $Bearbeiter
 * @property string $Planbeginn
 * @property string $PlanEnde
 * @property string $IstEnde
 * @property string $Herkunft
 * @property string $Stand
 * @property int $Wirksamkeit
 * @property int $Status
 * @property int $Erledigungsgrad
 * @property int $AuftraggeberID
 * @property int $AuftragnehmerID
 * @property string $Kosten
 * @property string $Auftraggeber
 * @property string $Auftragnehmer
 * @property int $Überwachung
 * @property int $Priorität
 * @property string $Erstellt
 * @property int $HerkunftID
 * @property string $Typ
 * @property int $REK_ID
 * @property int $POS_ID
 * @property string $Bemerkung
 * @property string $IstBeginn
 * @property int $Gelesen
 * @property int $O_MM_ID
 * @property int $HasChildren
 * @property int $Struktur_ID
 * @property int $Wirksam
 * @property int $ErledigungBestätigt
 * @property string $ErledigungNotiz
 * @property string $UmsetzungNotiz
 * @property int $Projekt
 * @property string $MM_ID_EXT
 * @property string $Initiator
 * @property string $Initiator_Date
 * @property int $OptimisticLockField
 * @property int $GCRecord
 * @property string $ESK1_Timestamp
 * @property string $ESK2_Timestamp
 * @property string $ESK3_Timestamp
 * @property string $ESK4_Timestamp
 * @property string $Info1
 * @property string $Info2
 * @property string $Info3
 * @property string $Info4
 * @property string $Info5
 * @property string $Info6
 * @property string $Info7
 * @property string $Info8
 * @property string $Info9
 * @property string $Info10
 *
 * @property TblMMTodos[] $tblMMTodos
 */
class Massnahmen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_MM';
    }

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
    public function rules()
    {
        return [
            [['Titel', 'Beschreibung', 'Herkunft', 'Auftraggeber', 'Auftragnehmer', 'Typ', 'Bemerkung', 'ErledigungNotiz', 'UmsetzungNotiz', 'MM_ID_EXT', 'Initiator', 'Info1', 'Info2', 'Info3', 'Info4', 'Info5', 'Info6', 'Info7', 'Info8', 'Info9', 'Info10'], 'string'],
            [['Bearbeiter', 'Wirksamkeit', 'Status', 'Erledigungsgrad', 'AuftraggeberID', 'AuftragnehmerID', 'Überwachung', 'Priorität', 'HerkunftID', 'REK_ID', 'POS_ID', 'Gelesen', 'O_MM_ID', 'HasChildren', 'Struktur_ID', 'Wirksam', 'ErledigungBestätigt', 'Projekt', 'OptimisticLockField', 'GCRecord'], 'integer'],
            [['Planbeginn', 'PlanEnde', 'IstEnde', 'Stand', 'Erstellt', 'IstBeginn', 'Initiator_Date', 'ESK1_Timestamp', 'ESK2_Timestamp', 'ESK3_Timestamp', 'ESK4_Timestamp'], 'safe'],
            [['Kosten'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'OID' => 'O I D',
            'Titel' => 'Titel',
            'Beschreibung' => 'Beschreibung',
            'Bearbeiter' => 'Bearbeiter',
            'Planbeginn' => 'Planbeginn',
            'PlanEnde' => 'Plan Ende',
            'IstEnde' => 'Ist Ende',
            'Herkunft' => 'Herkunft',
            'Stand' => 'Stand',
            'Wirksamkeit' => 'Wirksamkeit',
            'Status' => 'Status',
            'Erledigungsgrad' => 'Erledigungsgrad',
            'AuftraggeberID' => 'Auftraggeber I D',
            'AuftragnehmerID' => 'Auftragnehmer I D',
            'Kosten' => 'Kosten',
            'Auftraggeber' => 'Auftraggeber',
            'Auftragnehmer' => 'Auftragnehmer',
            'Überwachung' => 'Überwachung',
            'Priorität' => 'Priorität',
            'Erstellt' => 'Erstellt',
            'HerkunftID' => 'Herkunft I D',
            'Typ' => 'Typ',
            'REK_ID' => 'R E K I D',
            'POS_ID' => 'P O S I D',
            'Bemerkung' => 'Bemerkung',
            'IstBeginn' => 'Ist Beginn',
            'Gelesen' => 'Gelesen',
            'O_MM_ID' => 'O M M I D',
            'HasChildren' => 'Has Children',
            'Struktur_ID' => 'Struktur I D',
            'Wirksam' => 'Wirksam',
            'ErledigungBestätigt' => 'Erledigung Bestätigt',
            'ErledigungNotiz' => 'Erledigung Notiz',
            'UmsetzungNotiz' => 'Umsetzung Notiz',
            'Projekt' => 'Projekt',
            'MM_ID_EXT' => 'M M I D E X T',
            'Initiator' => 'Initiator',
            'Initiator_Date' => 'Initiator Date',
            'OptimisticLockField' => 'Optimistic Lock Field',
            'GCRecord' => 'G C Record',
            'ESK1_Timestamp' => 'E S K1 Timestamp',
            'ESK2_Timestamp' => 'E S K2 Timestamp',
            'ESK3_Timestamp' => 'E S K3 Timestamp',
            'ESK4_Timestamp' => 'E S K4 Timestamp',
            'Info1' => 'Info1',
            'Info2' => 'Info2',
            'Info3' => 'Info3',
            'Info4' => 'Info4',
            'Info5' => 'Info5',
            'Info6' => 'Info6',
            'Info7' => 'Info7',
            'Info8' => 'Info8',
            'Info9' => 'Info9',
            'Info10' => 'Info10',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblMMTodos()
    {
        return $this->hasMany(TblMMTodos::className(), ['MM' => 'OID']);
    }

    public function getRekMassnahmen($OID)
    {
      $query = Massnahmen::find();
      $query->leftJoin('tbl_Reklamation_Position', 'tbl_Reklamation_Position.OID = tbl_MM.POS_ID')
            ->leftJoin('tbl_Reklamationen', 'tbl_Reklamationen.OID = tbl_Reklamation_Position.REK_ID');

      $query->where(['tbl_Reklamationen.OID'=>$OID]);
      $dataProvider = new ActiveDataProvider([
          'query' => $query,
      ]);
      return $dataProvider;
    }
}
