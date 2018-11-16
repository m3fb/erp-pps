<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "CU_COMP".
 *
 * @property string $CONO
 * @property string $NAME
 * @property string $ADDITION
 * @property string $ADDITION2
 * @property string $BITMAP
 * @property string $BOXCODE
 * @property string $BOXNO
 * @property string $CLEARANCE
 * @property string $CNTRYSIGN
 * @property string $COTYPNO
 * @property string $CREDITLIMIT
 * @property string $CUSTNO
 * @property string $CUSTOMERINFO
 * @property string $FAX
 * @property string $FKPLNO
 * @property string $FKPLNO1
 * @property string $FKPLNO2
 * @property string $FKPLNO3
 * @property string $INFO1
 * @property string $INFO2
 * @property string $LANCNTRY
 * @property string $LIEFERB
 * @property string $MODEM
 * @property string $NUMCOPIESINVOICE
 * @property string $PHONE
 * @property string $PHONE1
 * @property string $PHONE2
 * @property string $PHONE3
 * @property string $PHONE4
 * @property string $PHONE5
 * @property string $PHONE6
 * @property string $PLACE
 * @property string $PLACE2
 * @property string $POSTCODE
 * @property string $POSTCODE2
 * @property string $RABATT
 * @property string $SALESMAN
 * @property string $SAMMELRECH
 * @property string $SECPHONE
 * @property string $STATE
 * @property string $STATUS
 * @property string $STREET
 * @property string $STREET2
 * @property string $SUPPLIER
 * @property string $TYP0
 * @property string $TYP1
 * @property string $TYP2
 * @property string $UDATUM
 * @property string $UMSATZ0
 * @property string $UMSATZ1
 * @property string $UMSATZ2
 * @property string $UMSATZ3
 * @property string $UMSATZ4
 * @property string $UMSATZ5
 * @property string $UMSATZ6
 * @property string $UMSATZ7
 * @property string $UMSATZ8
 * @property string $UMSATZ9
 * @property string $UMSATZ10
 * @property string $UMSATZ11
 * @property string $UMSATZ12
 * @property string $VATIDNO
 * @property string $VERTID
 * @property string $VERTRNAME
 * @property string $VPROV
 * @property string $VRABATT
 * @property string $ZAHLUNGB
 * @property string $ZAHLUNGT
 * @property string $CNAME
 * @property string $CHNAME
 * @property string $CDATE
 * @property string $CHDATE
 * @property string $MANDANTNO
 * @property string $EXCHANGELMT
 * @property string $EXTWORKRES
 * @property string $EXCHANGEPHOTOLMT
 *
 * @property CUCNTRY $cNTRYSIGN
 * @property CUCOTYP $cOTYPNO
 * @property CUPERS[] $cUPERSs
 * @property CUVERS[] $cUVERSs
 * @property PAARTLIEF[] $pAARTLIEFs
 */
class Cucomp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CU_COMP';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CONO', 'NAME'], 'required'],
            [['CONO', 'CLEARANCE', 'COTYPNO', 'CREDITLIMIT', 'FKPLNO', 'FKPLNO1', 'FKPLNO2', 'FKPLNO3', 'NUMCOPIESINVOICE', 'RABATT', 'SAMMELRECH', 'STATUS', 'TYP0', 'TYP1', 'TYP2', 'UMSATZ0', 'UMSATZ1', 'UMSATZ2', 'UMSATZ3', 'UMSATZ4', 'UMSATZ5', 'UMSATZ6', 'UMSATZ7', 'UMSATZ8', 'UMSATZ9', 'UMSATZ10', 'UMSATZ11', 'UMSATZ12', 'VERTID', 'VPROV', 'VRABATT', 'ZAHLUNGT', 'MANDANTNO', 'EXTWORKRES'], 'number'],
            [['NAME', 'ADDITION', 'ADDITION2', 'BITMAP', 'BOXCODE', 'BOXNO', 'CNTRYSIGN', 'CUSTNO', 'CUSTOMERINFO', 'FAX', 'INFO1', 'INFO2', 'LANCNTRY', 'LIEFERB', 'MODEM', 'PHONE', 'PHONE1', 'PHONE2', 'PHONE3', 'PHONE4', 'PHONE5', 'PHONE6', 'PLACE', 'PLACE2', 'POSTCODE', 'POSTCODE2', 'SALESMAN', 'SECPHONE', 'STATE', 'STREET', 'STREET2', 'SUPPLIER', 'VATIDNO', 'VERTRNAME', 'ZAHLUNGB', 'CNAME', 'CHNAME'], 'string'],
            [['UDATUM', 'CDATE', 'CHDATE', 'EXCHANGELMT', 'EXCHANGEPHOTOLMT'], 'safe'],
            [['CONO'], 'unique'],
            [['CNTRYSIGN'], 'exist', 'skipOnError' => true, 'targetClass' => Cucntry::className(), 'targetAttribute' => ['CNTRYSIGN' => 'CNTRYSIGN']],
            [['COTYPNO'], 'exist', 'skipOnError' => true, 'targetClass' => CUCOTYP::className(), 'targetAttribute' => ['COTYPNO' => 'COTYPNO']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CONO' => 'Cono',
            'NAME' => 'Name',
            'ADDITION' => 'Addition',
            'ADDITION2' => 'Addition2',
            'BITMAP' => 'Bitmap',
            'BOXCODE' => 'Boxcode',
            'BOXNO' => 'Boxno',
            'CLEARANCE' => 'Clearance',
            'CNTRYSIGN' => 'Cntrysign',
            'COTYPNO' => 'Cotypno',
            'CREDITLIMIT' => 'Creditlimit',
            'CUSTNO' => 'Custno',
            'CUSTOMERINFO' => 'Customerinfo',
            'FAX' => 'Fax',
            'FKPLNO' => 'Fkplno',
            'FKPLNO1' => 'Fkplno1',
            'FKPLNO2' => 'Fkplno2',
            'FKPLNO3' => 'Fkplno3',
            'INFO1' => 'Info1',
            'INFO2' => 'Info2',
            'LANCNTRY' => 'Lancntry',
            'LIEFERB' => 'Lieferb',
            'MODEM' => 'Modem',
            'NUMCOPIESINVOICE' => 'Numcopiesinvoice',
            'PHONE' => 'Phone',
            'PHONE1' => 'Phone1',
            'PHONE2' => 'Phone2',
            'PHONE3' => 'Phone3',
            'PHONE4' => 'Phone4',
            'PHONE5' => 'Phone5',
            'PHONE6' => 'Phone6',
            'PLACE' => 'Place',
            'PLACE2' => 'Place2',
            'POSTCODE' => 'Postcode',
            'POSTCODE2' => 'Postcode2',
            'RABATT' => 'Rabatt',
            'SALESMAN' => 'Salesman',
            'SAMMELRECH' => 'Sammelrech',
            'SECPHONE' => 'Secphone',
            'STATE' => 'State',
            'STATUS' => 'Status',
            'STREET' => 'Street',
            'STREET2' => 'Street2',
            'SUPPLIER' => 'Supplier',
            'TYP0' => 'Typ0',
            'TYP1' => 'Typ1',
            'TYP2' => 'Typ2',
            'UDATUM' => 'Udatum',
            'UMSATZ0' => 'Umsatz0',
            'UMSATZ1' => 'Umsatz1',
            'UMSATZ2' => 'Umsatz2',
            'UMSATZ3' => 'Umsatz3',
            'UMSATZ4' => 'Umsatz4',
            'UMSATZ5' => 'Umsatz5',
            'UMSATZ6' => 'Umsatz6',
            'UMSATZ7' => 'Umsatz7',
            'UMSATZ8' => 'Umsatz8',
            'UMSATZ9' => 'Umsatz9',
            'UMSATZ10' => 'Umsatz10',
            'UMSATZ11' => 'Umsatz11',
            'UMSATZ12' => 'Umsatz12',
            'VATIDNO' => 'Vatidno',
            'VERTID' => 'Vertid',
            'VERTRNAME' => 'Vertrname',
            'VPROV' => 'Vprov',
            'VRABATT' => 'Vrabatt',
            'ZAHLUNGB' => 'Zahlungb',
            'ZAHLUNGT' => 'Zahlungt',
            'CNAME' => 'Cname',
            'CHNAME' => 'Chname',
            'CDATE' => 'Cdate',
            'CHDATE' => 'Chdate',
            'MANDANTNO' => 'Mandantno',
            'EXCHANGELMT' => 'Exchangelmt',
            'EXTWORKRES' => 'Extworkres',
            'EXCHANGEPHOTOLMT' => 'Exchangephotolmt',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCNTRYSIGN()
    {
        return $this->hasOne(Cucntry::className(), ['CNTRYSIGN' => 'CNTRYSIGN']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCOTYPNO()
    {
        return $this->hasOne(CUCOTYP::className(), ['COTYPNO' => 'COTYPNO']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCUPERSs()
    {
        return $this->hasMany(CUPERS::className(), ['CONO' => 'CONO']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCUVERSs()
    {
        return $this->hasMany(CUVERS::className(), ['CONO' => 'CONO']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPAARTLIEFs()
    {
        return $this->hasMany(PAARTLIEF::className(), ['CONO' => 'CONO']);
    }
}
