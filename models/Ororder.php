<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "OR_ORDER".
 *
 * @property string $NO
 * @property string $MUSTERNO
 * @property string $PRONO
 * @property string $GRPNO
 * @property string $NAME
 * @property string $DESCR
 * @property string $IDENT
 * @property string $PPARTS
 * @property string $SEQNO
 * @property string $SOURCE
 * @property string $STATUS
 * @property string $EINLAST
 * @property string $ACTIVE
 * @property string $ADTEXT
 * @property string $ARTNO
 * @property string $ASSART
 * @property string $ASSARTNO
 * @property string $BITMAP
 * @property string $CFLAG
 * @property string $CHTIME
 * @property string $CLEARANCE
 * @property string $COMMNO
 * @property string $CONO
 * @property string $COSTDEPT
 * @property string $CPGETP
 * @property string $CRGETP
 * @property string $CTIME
 * @property string $DATUM0
 * @property string $DATUM1
 * @property string $DATUM2
 * @property string $DATUM3
 * @property string $DELIVERY
 * @property string $DRAWIND
 * @property string $DRAWNO
 * @property string $EINHEIT
 * @property string $ERROR
 * @property string $ETIME
 * @property string $FAKTOR1
 * @property string $FAKTOR2
 * @property string $FAKTOR3
 * @property string $FORMNA
 * @property string $FORMVA
 * @property string $GKN01
 * @property string $GKN02
 * @property string $HPGLFILE
 * @property string $IDEAL0
 * @property string $IDEAL1
 * @property string $IDEAL2
 * @property string $INFO1
 * @property string $INFO2
 * @property string $INFO3
 * @property string $KAVIT0
 * @property string $KAVIT1
 * @property string $KCONO
 * @property string $KWEIG0
 * @property string $KWEIG1
 * @property string $MASSEINH
 * @property string $MDIM1
 * @property string $MDIM2
 * @property string $MDIM3
 * @property string $MENGE1
 * @property string $MENGE2
 * @property string $MENGE3
 * @property string $MENGE4
 * @property string $MENGE5
 * @property string $MENGE6
 * @property string $MENGE7
 * @property string $MENGE8
 * @property string $MINPRICE
 * @property string $MWEIG1
 * @property string $MWEIG2
 * @property string $MWEIG3
 * @property string $OGNO
 * @property string $ORDDATE
 * @property string $ORDOC0
 * @property string $ORDOC1
 * @property string $ORDOC2
 * @property string $ORPRT0
 * @property string $ORPRT1
 * @property string $ORPRT2
 * @property string $ORSETP0
 * @property string $ORSETP1
 * @property string $ORSETP2
 * @property string $ORSETP3
 * @property string $OVERLAP
 * @property string $OVERLAPDIFF
 * @property string $OVERLAPPERC
 * @property string $PETIMEMAX
 * @property string $PETIMEMIN
 * @property string $POSTNO
 * @property string $POSTOP
 * @property string $PREIS1
 * @property string $PREIS2
 * @property string $PREIS3
 * @property string $PREIS4
 * @property string $PREIS5
 * @property string $PREIS6
 * @property string $PREIS7
 * @property string $PREIS8
 * @property string $PREJECTS
 * @property string $PRENO
 * @property string $PREOP
 * @property string $PRICEINFO
 * @property string $PRINTDATE
 * @property string $PRIO
 * @property string $PROBLEM
 * @property string $PRODUCTIONSTATE
 * @property string $PSTIMEMAX
 * @property string $PSTIMEMIN
 * @property string $PTE
 * @property string $PTG
 * @property string $PTH
 * @property string $PTR
 * @property string $PTRA
 * @property string $PTTRANS
 * @property string $PTWAIT
 * @property string $REFOPNAME
 * @property string $RELOPCNT
 * @property string $RELORD
 * @property string $REPTIME
 * @property string $SAPUPDATESTATUS
 * @property string $SCNO
 * @property string $SDEVPROD1
 * @property string $SDEVPROD2
 * @property string $SDEVPROD3
 * @property string $SDEVPROD4
 * @property string $SDEVPROD5
 * @property string $SDEVPROD6
 * @property string $SEQNUM
 * @property string $SPECIAL
 * @property string $SPERC0
 * @property string $SPERC1
 * @property string $SPERC2
 * @property string $SPERC3
 * @property string $SPERC4
 * @property string $SPERC5
 * @property string $STIME
 * @property string $TYPE
 * @property string $USR
 * @property string $CNAME
 * @property string $CHNAME
 * @property string $CDATE
 * @property string $CHDATE
 * @property string $MANDANTNO
 * @property string $TSTAMP
 * @property string $MENGE9
 * @property string $MENGE10
 * @property string $MENGE11
 * @property string $MENGE12
 * @property string $MENGE13
 * @property string $MENGE14
 * @property string $MENGE15
 * @property string $PREIS9
 * @property string $PREIS10
 * @property string $PREIS11
 * @property string $PREIS12
 * @property string $PREIS13
 * @property string $PREIS14
 * @property string $PREIS15
 * @property string $SDEVPROD7
 * @property string $SDEVPROD8
 * @property string $SDEVPROD9
 * @property string $SDEVPROD10
 * @property string $SDEVPROD11
 * @property string $SDEVPROD12
 * @property string $SDEVPROD13
 * @property string $SDEVPROD14
 * @property string $SDEVPROD15
 *
 * @property ORART[] $oRARTs
 * @property OROP[] $oROPs
 */
class Ororder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'OR_ORDER';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NO', 'NAME', 'STATUS', 'CFLAG', 'TSTAMP'], 'required'],
            [['NO', 'MUSTERNO', 'PRONO', 'GRPNO', 'PPARTS', 'SEQNO', 'SOURCE', 'STATUS', 'EINLAST', 'ACTIVE', 'ASSART', 'ASSARTNO', 'CFLAG', 'CLEARANCE', 'CONO', 'CPGETP', 'CRGETP', 'EINHEIT', 'ERROR', 'FAKTOR1', 'FAKTOR2', 'FAKTOR3', 'KAVIT0', 'KAVIT1', 'KCONO', 'KWEIG0', 'KWEIG1', 'MDIM1', 'MDIM2', 'MDIM3', 'MENGE1', 'MENGE2', 'MENGE3', 'MENGE4', 'MENGE5', 'MENGE6', 'MENGE7', 'MENGE8', 'MINPRICE', 'MWEIG1', 'MWEIG2', 'MWEIG3', 'OGNO', 'ORPRT0', 'ORPRT1', 'ORPRT2', 'ORSETP0', 'ORSETP1', 'ORSETP2', 'ORSETP3', 'OVERLAP', 'OVERLAPDIFF', 'OVERLAPPERC', 'POSTNO', 'POSTOP', 'PREIS1', 'PREIS2', 'PREIS3', 'PREIS4', 'PREIS5', 'PREIS6', 'PREIS7', 'PREIS8', 'PREJECTS', 'PRENO', 'PREOP', 'PRIO', 'PROBLEM', 'PRODUCTIONSTATE', 'PTE', 'PTG', 'PTH', 'PTR', 'PTRA', 'PTTRANS', 'PTWAIT', 'RELOPCNT', 'REPTIME', 'SAPUPDATESTATUS', 'SCNO', 'SDEVPROD1', 'SDEVPROD2', 'SDEVPROD3', 'SDEVPROD4', 'SDEVPROD5', 'SDEVPROD6', 'SEQNUM', 'SPECIAL', 'SPERC0', 'SPERC1', 'SPERC2', 'SPERC3', 'SPERC4', 'SPERC5', 'TYPE', 'MANDANTNO', 'MENGE9', 'MENGE10', 'MENGE11', 'MENGE12', 'MENGE13', 'MENGE14', 'MENGE15', 'PREIS9', 'PREIS10', 'PREIS11', 'PREIS12', 'PREIS13', 'PREIS14', 'PREIS15', 'SDEVPROD7', 'SDEVPROD8', 'SDEVPROD9', 'SDEVPROD10', 'SDEVPROD11', 'SDEVPROD12', 'SDEVPROD13', 'SDEVPROD14', 'SDEVPROD15'], 'number'],
            [['NAME', 'DESCR', 'IDENT', 'ADTEXT', 'ARTNO', 'BITMAP', 'COMMNO', 'COSTDEPT', 'DRAWIND', 'DRAWNO', 'FORMNA', 'FORMVA', 'GKN01', 'GKN02', 'HPGLFILE', 'IDEAL0', 'IDEAL1', 'IDEAL2', 'INFO1', 'INFO2', 'INFO3', 'MASSEINH', 'ORDOC0', 'ORDOC1', 'ORDOC2', 'PRICEINFO', 'REFOPNAME', 'RELORD', 'USR', 'CNAME', 'CHNAME'], 'string'],
            [['CHTIME', 'CTIME', 'DATUM0', 'DATUM1', 'DATUM2', 'DATUM3', 'DELIVERY', 'ETIME', 'ORDDATE', 'PETIMEMAX', 'PETIMEMIN', 'PRINTDATE', 'PSTIMEMAX', 'PSTIMEMIN', 'STIME', 'CDATE', 'CHDATE', 'TSTAMP'], 'safe'],
            [['NO'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'NO' => 'No',
            'MUSTERNO' => 'Musterno',
            'PRONO' => 'Prono',
            'GRPNO' => 'Grpno',
            'NAME' => 'Name',
            'DESCR' => 'Descr',
            'IDENT' => 'Ident',
            'PPARTS' => 'Pparts',
            'SEQNO' => 'Seqno',
            'SOURCE' => 'Source',
            'STATUS' => 'Status',
            'EINLAST' => 'Einlast',
            'ACTIVE' => 'Active',
            'ADTEXT' => 'Adtext',
            'ARTNO' => 'Artno',
            'ASSART' => 'Assart',
            'ASSARTNO' => 'Assartno',
            'BITMAP' => 'Bitmap',
            'CFLAG' => 'Cflag',
            'CHTIME' => 'Chtime',
            'CLEARANCE' => 'Clearance',
            'COMMNO' => 'Commno',
            'CONO' => 'Cono',
            'COSTDEPT' => 'Costdept',
            'CPGETP' => 'Cpgetp',
            'CRGETP' => 'Crgetp',
            'CTIME' => 'Ctime',
            'DATUM0' => 'Datum0',
            'DATUM1' => 'Datum1',
            'DATUM2' => 'Datum2',
            'DATUM3' => 'Datum3',
            'DELIVERY' => 'Delivery',
            'DRAWIND' => 'Drawind',
            'DRAWNO' => 'Drawno',
            'EINHEIT' => 'Einheit',
            'ERROR' => 'Error',
            'ETIME' => 'Etime',
            'FAKTOR1' => 'Faktor1',
            'FAKTOR2' => 'Faktor2',
            'FAKTOR3' => 'Faktor3',
            'FORMNA' => 'Formna',
            'FORMVA' => 'Formva',
            'GKN01' => 'Gkn01',
            'GKN02' => 'Gkn02',
            'HPGLFILE' => 'Hpglfile',
            'IDEAL0' => 'Ideal0',
            'IDEAL1' => 'Ideal1',
            'IDEAL2' => 'Ideal2',
            'INFO1' => 'Info1',
            'INFO2' => 'Info2',
            'INFO3' => 'Info3',
            'KAVIT0' => 'Kavit0',
            'KAVIT1' => 'Kavit1',
            'KCONO' => 'Kcono',
            'KWEIG0' => 'Kweig0',
            'KWEIG1' => 'Kweig1',
            'MASSEINH' => 'Masseinh',
            'MDIM1' => 'Mdim1',
            'MDIM2' => 'Mdim2',
            'MDIM3' => 'Mdim3',
            'MENGE1' => 'Menge1',
            'MENGE2' => 'Menge2',
            'MENGE3' => 'Menge3',
            'MENGE4' => 'Menge4',
            'MENGE5' => 'Menge5',
            'MENGE6' => 'Menge6',
            'MENGE7' => 'Menge7',
            'MENGE8' => 'Menge8',
            'MINPRICE' => 'Minprice',
            'MWEIG1' => 'Mweig1',
            'MWEIG2' => 'Mweig2',
            'MWEIG3' => 'Mweig3',
            'OGNO' => 'Ogno',
            'ORDDATE' => 'Orddate',
            'ORDOC0' => 'Ordoc0',
            'ORDOC1' => 'Ordoc1',
            'ORDOC2' => 'Ordoc2',
            'ORPRT0' => 'Orprt0',
            'ORPRT1' => 'Orprt1',
            'ORPRT2' => 'Orprt2',
            'ORSETP0' => 'Orsetp0',
            'ORSETP1' => 'Orsetp1',
            'ORSETP2' => 'Orsetp2',
            'ORSETP3' => 'Orsetp3',
            'OVERLAP' => 'Overlap',
            'OVERLAPDIFF' => 'Overlapdiff',
            'OVERLAPPERC' => 'Overlapperc',
            'PETIMEMAX' => 'Petimemax',
            'PETIMEMIN' => 'Petimemin',
            'POSTNO' => 'Postno',
            'POSTOP' => 'Postop',
            'PREIS1' => 'Preis1',
            'PREIS2' => 'Preis2',
            'PREIS3' => 'Preis3',
            'PREIS4' => 'Preis4',
            'PREIS5' => 'Preis5',
            'PREIS6' => 'Preis6',
            'PREIS7' => 'Preis7',
            'PREIS8' => 'Preis8',
            'PREJECTS' => 'Prejects',
            'PRENO' => 'Preno',
            'PREOP' => 'Preop',
            'PRICEINFO' => 'Priceinfo',
            'PRINTDATE' => 'Printdate',
            'PRIO' => 'Prio',
            'PROBLEM' => 'Problem',
            'PRODUCTIONSTATE' => 'Productionstate',
            'PSTIMEMAX' => 'Pstimemax',
            'PSTIMEMIN' => 'Pstimemin',
            'PTE' => 'Pte',
            'PTG' => 'Ptg',
            'PTH' => 'Pth',
            'PTR' => 'Ptr',
            'PTRA' => 'Ptra',
            'PTTRANS' => 'Pttrans',
            'PTWAIT' => 'Ptwait',
            'REFOPNAME' => 'Refopname',
            'RELOPCNT' => 'Relopcnt',
            'RELORD' => 'Relord',
            'REPTIME' => 'Reptime',
            'SAPUPDATESTATUS' => 'Sapupdatestatus',
            'SCNO' => 'Scno',
            'SDEVPROD1' => 'Sdevprod1',
            'SDEVPROD2' => 'Sdevprod2',
            'SDEVPROD3' => 'Sdevprod3',
            'SDEVPROD4' => 'Sdevprod4',
            'SDEVPROD5' => 'Sdevprod5',
            'SDEVPROD6' => 'Sdevprod6',
            'SEQNUM' => 'Seqnum',
            'SPECIAL' => 'Special',
            'SPERC0' => 'Sperc0',
            'SPERC1' => 'Sperc1',
            'SPERC2' => 'Sperc2',
            'SPERC3' => 'Sperc3',
            'SPERC4' => 'Sperc4',
            'SPERC5' => 'Sperc5',
            'STIME' => 'Stime',
            'TYPE' => 'Type',
            'USR' => 'Usr',
            'CNAME' => 'Cname',
            'CHNAME' => 'Chname',
            'CDATE' => 'Cdate',
            'CHDATE' => 'Chdate',
            'MANDANTNO' => 'Mandantno',
            'TSTAMP' => 'Tstamp',
            'MENGE9' => 'Menge9',
            'MENGE10' => 'Menge10',
            'MENGE11' => 'Menge11',
            'MENGE12' => 'Menge12',
            'MENGE13' => 'Menge13',
            'MENGE14' => 'Menge14',
            'MENGE15' => 'Menge15',
            'PREIS9' => 'Preis9',
            'PREIS10' => 'Preis10',
            'PREIS11' => 'Preis11',
            'PREIS12' => 'Preis12',
            'PREIS13' => 'Preis13',
            'PREIS14' => 'Preis14',
            'PREIS15' => 'Preis15',
            'SDEVPROD7' => 'Sdevprod7',
            'SDEVPROD8' => 'Sdevprod8',
            'SDEVPROD9' => 'Sdevprod9',
            'SDEVPROD10' => 'Sdevprod10',
            'SDEVPROD11' => 'Sdevprod11',
            'SDEVPROD12' => 'Sdevprod12',
            'SDEVPROD13' => 'Sdevprod13',
            'SDEVPROD14' => 'Sdevprod14',
            'SDEVPROD15' => 'Sdevprod15',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getORARTs()
    {
        return $this->hasMany(ORART::className(), ['ORDNO' => 'NO']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOROPs()
    {
        return $this->hasMany(OROP::className(), ['ORNO' => 'NO']);
    }
}
