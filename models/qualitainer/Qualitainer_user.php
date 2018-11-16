<?php

namespace app\models\qualitainer;

use Yii;

/**
 * This is the model class for table "{{%tbl_mUser}}".
 *
 * @property int $OID
 * @property int $Color
 * @property string $Benutzername
 * @property string $Passwort
 * @property string $Vorname
 * @property string $Nachname
 * @property string $Email
 * @property string $Abteilung
 * @property string $Anrede
 * @property string $Titel
 * @property string $Position
 * @property string $Telefon
 * @property string $Telefax
 * @property string $Mobil
 * @property string $Bemerkung
 * @property int $Admin
 * @property int $NurView
 * @property int $DashBoardDesigner
 * @property int $REK
 * @property int $MM
 * @property int $AUDIT
 * @property int $PMV
 * @property int $FMEA
 * @property int $CRM
 * @property int $Kosten
 * @property int $Auditrial
 * @property int $DMS
 * @property string $USER_ID_EXT
 * @property int $ReportDesigner
 * @property int $AnalyseCenter
 * @property int $ResourceID
 * @property int $EMPB
 * @property int $PPL
 * @property int $Import
 * @property int $SnapReport
 * @property int $ReportServer
 * @property resource $Sign
 * @property int $Inaktiv
 * @property string $pin
 * @property int $Neues_Passwort_erforderlich
 * @property int $RolleID
 * @property int $SingleSignOn
 * @property string $WindowsUser
 * @property int $OptimisticLockField
 * @property int $GCRecord
 * @property int $Werk
 * @property resource $Image
 * @property int $ChangePassword
 * @property string $Vorgesetzter_Email
 * @property int $VorgesetzterID
 * @property int $Messwerterfassung
 *
 * @property TblReklamationPositionTeam[] $tblReklamationPositionTeams
 */
class qualitainer_user extends \yii\db\ActiveRecord
{
    public $Name;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_mUser';
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
            [['Color', 'Admin', 'NurView', 'DashBoardDesigner', 'REK', 'MM', 'AUDIT', 'PMV', 'FMEA', 'CRM', 'Kosten', 'Auditrial', 'DMS', 'ReportDesigner', 'AnalyseCenter', 'ResourceID', 'EMPB', 'PPL', 'Import', 'SnapReport', 'ReportServer', 'Inaktiv', 'Neues_Passwort_erforderlich', 'RolleID', 'SingleSignOn', 'OptimisticLockField', 'GCRecord', 'Werk', 'ChangePassword', 'VorgesetzterID', 'Messwerterfassung'], 'integer'],
            [['Benutzername', 'Passwort', 'Vorname', 'Nachname', 'Email', 'Abteilung', 'Anrede', 'Titel', 'Position', 'Telefon', 'Telefax', 'Mobil', 'Bemerkung', 'USER_ID_EXT', 'Sign', 'pin', 'WindowsUser', 'Image', 'Vorgesetzter_Email','Name'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'OID' => 'O I D',
            'Color' => 'Color',
            'Benutzername' => 'Benutzername',
            'Passwort' => 'Passwort',
            'Vorname' => 'Vorname',
            'Nachname' => 'Nachname',
            'Email' => 'Email',
            'Abteilung' => 'Abteilung',
            'Anrede' => 'Anrede',
            'Titel' => 'Titel',
            'Position' => 'Position',
            'Telefon' => 'Telefon',
            'Telefax' => 'Telefax',
            'Mobil' => 'Mobil',
            'Bemerkung' => 'Bemerkung',
            'Admin' => 'Admin',
            'NurView' => 'Nur View',
            'DashBoardDesigner' => 'Dash Board Designer',
            'REK' => 'R E K',
            'MM' => 'M M',
            'AUDIT' => 'A U D I T',
            'PMV' => 'P M V',
            'FMEA' => 'F M E A',
            'CRM' => 'C R M',
            'Kosten' => 'Kosten',
            'Auditrial' => 'Auditrial',
            'DMS' => 'D M S',
            'USER_ID_EXT' => 'U S E R I D E X T',
            'ReportDesigner' => 'Report Designer',
            'AnalyseCenter' => 'Analyse Center',
            'ResourceID' => 'Resource I D',
            'EMPB' => 'E M P B',
            'PPL' => 'P P L',
            'Import' => 'Import',
            'SnapReport' => 'Snap Report',
            'ReportServer' => 'Report Server',
            'Sign' => 'Sign',
            'Inaktiv' => 'Inaktiv',
            'pin' => 'Pin',
            'Neues_Passwort_erforderlich' => 'Neues Passwort Erforderlich',
            'RolleID' => 'Rolle I D',
            'SingleSignOn' => 'Single Sign On',
            'WindowsUser' => 'Windows User',
            'OptimisticLockField' => 'Optimistic Lock Field',
            'GCRecord' => 'G C Record',
            'Werk' => 'Werk',
            'Image' => 'Image',
            'ChangePassword' => 'Change Password',
            'Vorgesetzter_Email' => 'Vorgesetzter Email',
            'VorgesetzterID' => 'Vorgesetzter I D',
            'Messwerterfassung' => 'Messwerterfassung',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblReklamationPositionTeams()
    {
        return $this->hasMany(TblReklamationPositionTeam::className(), ['Teammitglied' => 'OID']);
    }
}
