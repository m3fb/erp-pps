<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "PE_WORK".
 *
 * @property string $NO
 * @property string $PERSNO
 * @property string $FIRSTNAME
 * @property string $SURNAME
 * @property string $BITMAP
 * @property string $CALNO
 * @property string $CNTRYSIGN
 * @property string $CONO
 * @property string $COSTNO
 * @property string $COSTPH1
 * @property string $COSTPH2
 * @property string $COSTPH3
 * @property string $DEPTNO
 * @property string $EFC
 * @property string $FAX
 * @property string $GROUPNO
 * @property string $INTMAIL1
 * @property string $MODEM
 * @property string $PDAYDAT1
 * @property string $PDAYDAT2
 * @property string $PDAYDAT3
 * @property string $PDAYINF1
 * @property string $PDAYINF2
 * @property string $PDAYINF3
 * @property string $PEINFO
 * @property string $PHONE1
 * @property string $PHONE2
 * @property string $PHONE3
 * @property string $PLACE
 * @property string $POSITION
 * @property string $POSTCODE
 * @property string $SALUTE
 * @property string $SBREAK
 * @property string $SEX
 * @property string $SHIFTNO
 * @property string $STATUS1
 * @property string $STATUS2
 * @property string $STATUS3
 * @property string $STREET
 * @property string $WENDH
 * @property string $WENDT
 * @property string $WSTARTH
 * @property string $WSTARTT
 * @property string $CNAME
 * @property string $CHNAME
 * @property string $CDATE
 * @property string $CHDATE
 */
class Personal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
     public $NAME;

    public static function tableName()
    {
        return 'PE_WORK';
    }

    public $VAL02;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NO'], 'required'],
            [['NO', 'CALNO', 'CONO', 'COSTNO', 'COSTPH1', 'COSTPH2', 'COSTPH3', 'DEPTNO', 'EFC', 'GROUPNO', 'INTMAIL1', 'SEX', 'SHIFTNO', 'STATUS1', 'STATUS2', 'STATUS3', 'WENDH', 'WSTARTH'], 'number'],
            [['PERSNO', 'FIRSTNAME', 'SURNAME', 'BITMAP', 'CNTRYSIGN', 'FAX', 'MODEM', 'PDAYINF1', 'PDAYINF2', 'PDAYINF3', 'PEINFO', 'PHONE1', 'PHONE2', 'PHONE3', 'PLACE', 'POSITION', 'SALUTE', 'SBREAK', 'STREET', 'CNAME', 'CHNAME'], 'string'],
            [['PDAYDAT1', 'PDAYDAT2', 'PDAYDAT3', 'WENDT', 'WSTARTT', 'CDATE', 'CHDATE'], 'safe'],
            [['PLACE','STREET','POSTCODE'], 'required'],
            ['MODEM', 'email'],
            [['POSTCODE'], 'integer'],
            [['POSTCODE'], 'string', 'min' => 5,'max' => 5],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'NO' => 'No',
            'PERSNO' => 'Personal-Nr.',
            'FIRSTNAME' => 'Vorname',
            'SURNAME' => 'Nachname',
            'BITMAP' => 'Bitmap',
            'CALNO' => 'Calno',
            'CNTRYSIGN' => 'Länderzeichen',
            'CONO' => 'Cono',
            'COSTNO' => 'Costno',
            'COSTPH1' => 'Costph1',
            'COSTPH2' => 'Costph2',
            'COSTPH3' => 'Costph3',
            'DEPTNO' => 'Deptno',
            'EFC' => 'Efc',
            'FAX' => 'Fax',
            'GROUPNO' => 'Groupno',
            'INTMAIL1' => 'Intmail1',
            'MODEM' => 'Email',
            'PDAYDAT1' => 'Pdaydat1',
            'PDAYDAT2' => 'Pdaydat2',
            'PDAYDAT3' => 'Pdaydat3',
            'PDAYINF1' => 'Pdayinf1',
            'PDAYINF2' => 'Pdayinf2',
            'PDAYINF3' => 'Pdayinf3',
            'PEINFO' => 'Peinfo',
            'PHONE1' => 'Durchwahl',
            'PHONE2' => 'Mobil',
            'PHONE3' => 'Tel. priv.',
            'PLACE' => 'Ort',
            'POSITION' => 'Position',
            'POSTCODE' => 'PLZ',
            'SALUTE' => 'Salute',
            'SBREAK' => 'Sbreak',
            'SEX' => 'Sex',
            'SHIFTNO' => 'Shiftno',
            'STATUS1' => 'Status1',
            'STATUS2' => 'Status2',
            'STATUS3' => 'Status3',
            'STREET' => 'Straße',
            'WENDH' => 'Wendh',
            'WENDT' => 'Wendt',
            'WSTARTH' => 'Wstarth',
            'WSTARTT' => 'Wstartt',
            'CNAME' => 'erstellt',
            'CHNAME' => 'geändert',
            'CDATE' => 'Erstelldatum',
            'CHDATE' => 'Änderungsdatum',
            'username' => 'Benutzername',
            'TXT02' => 'Abteilung'
        ];
    }


    public static function findId($id)
    {
        return static::findOne(['NO' => $id]);
    }



}
