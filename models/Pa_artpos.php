<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "PA_ARTPOS".
 *
 * @property string $ARTNO
 * @property string $GRPNO
 * @property string $ARTDESC
 * @property string $ARTNAME
 * @property string $FIND
 * @property string $FNUM
 * @property string $FTYP
 * @property string $ARCHIVED
 * @property string $DISCONTINUED
 * @property string $ADATUM1
 * @property string $ADATUM2
 * @property string $ADATUM3
 * @property string $ADDRNO0
 * @property string $ADDRNO1
 * @property string $ADDRNO2
 * @property string $ADDRNO3
 * @property string $ADDRNO4
 * @property string $ADDRNO5
 * @property string $AEINH1
 * @property string $AEINH2
 * @property string $AEINH3
 * @property string $ALAGER0
 * @property string $ALAGER1
 * @property string $ALAGER2
 * @property string $ALAGER3
 * @property string $ALAGER4
 * @property string $ALAGER5
 * @property string $ALAGERN
 * @property string $AMENGE1
 * @property string $AMENGE2
 * @property string $AMENGE3
 * @property string $APLACEI
 * @property string $APREIS1
 * @property string $APREIS2
 * @property string $APREIS3
 * @property string $ARTADDR1
 * @property string $ARTADDR2
 * @property string $ARTADDR3
 * @property string $ARTDOC0
 * @property string $ARTDOC1
 * @property string $ARTDOC2
 * @property string $ARTINF1
 * @property string $ARTPRT0
 * @property string $ARTPRT1
 * @property string $ARTPRT2
 * @property string $AUTOLEAVE
 * @property string $AUTORESERV
 * @property string $AVERAGEPRICE
 * @property string $BESTM0
 * @property string $BESTM1
 * @property string $BESTM2
 * @property string $BITMAPA
 * @property string $BITMAPB
 * @property string $CHARGE
 * @property string $DINNO1
 * @property string $DINNO2
 * @property string $DISCALCDATE
 * @property string $DISCOUNT1
 * @property string $DISCOUNT2
 * @property string $DISCOUNT3
 * @property string $DISCOUNT4
 * @property string $DISCOUNT5
 * @property string $DISCOUNT6
 * @property string $DISDEMANDALL
 * @property string $DISDEMANDALLLEFT
 * @property string $DISDEMANDDIFF
 * @property string $DISDEMANDPACTIVE
 * @property string $DISDEMANDPACTIVELEFT
 * @property string $DISDEMANDPPASSIVE
 * @property string $DISDEMANDPPASSIVELEFT
 * @property string $DISFIRSTDATEMINUS
 * @property string $DISPRODUCING
 * @property string $DRAWNO
 * @property string $EINHEIT
 * @property string $EINHIN
 * @property string $EINHOUT
 * @property string $EINHST
 * @property string $EINKAUF0
 * @property string $EINKAUF1
 * @property string $EINKAUF2
 * @property string $EINKAUF3
 * @property string $EINKAUF4
 * @property string $EINKAUF5
 * @property string $EKPERC
 * @property string $EKPREIS
 * @property string $EPREIS0
 * @property string $EPREIS1
 * @property string $EPREIS2
 * @property string $EPREIS3
 * @property string $EPREIS4
 * @property string $EPREIS5
 * @property string $EPROZ0
 * @property string $EPROZ1
 * @property string $EPROZ2
 * @property string $EPROZ3
 * @property string $EPROZ4
 * @property string $EPROZ5
 * @property string $EXCLUDEINDISPO
 * @property string $FAKTOR1
 * @property string $FAKTOR2
 * @property string $FAKTOR3
 * @property string $ISCASTING
 * @property string $MASSEINH
 * @property string $MATTYP
 * @property string $MCPERC
 * @property string $MCREAL
 * @property string $MDIM1
 * @property string $MDIM2
 * @property string $MDIM3
 * @property string $MDIM4
 * @property string $MENGE
 * @property string $MENGE1
 * @property string $MENGE2
 * @property string $MENGE3
 * @property string $MENGE4
 * @property string $MENGE5
 * @property string $MENGE6
 * @property string $MFAKT
 * @property string $MIDENT1
 * @property string $MIDENT2
 * @property string $MIDENT3
 * @property string $MIDENT4
 * @property string $MIDENT5
 * @property string $MIDENT6
 * @property string $MIDENT7
 * @property string $MIDENT8
 * @property string $MINBE3
 * @property string $MINBE4
 * @property string $MINBE5
 * @property string $MINPRICE
 * @property string $MWEIG1
 * @property string $MWEIG2
 * @property string $MWEIG3
 * @property string $NETPRICE1
 * @property string $NETPRICE2
 * @property string $NETPRICE3
 * @property string $NETPRICE4
 * @property string $NETPRICE5
 * @property string $NETPRICE6
 * @property string $ORDERED
 * @property string $PADDITION1
 * @property string $PADDITION2
 * @property string $PADDITION3
 * @property string $PADDITION4
 * @property string $PADDITION5
 * @property string $PADDITION6
 * @property string $PARTNO
 * @property string $PLATE
 * @property string $PPREIS
 * @property string $PREIS
 * @property string $PREIS1
 * @property string $PREIS2
 * @property string $PREIS3
 * @property string $PREIS4
 * @property string $PREIS5
 * @property string $PREIS6
 * @property string $PROVREADY
 * @property string $RABATT
 * @property string $RABATTREADY
 * @property string $SERIALNUMBERKEY
 * @property string $SUPPLIED
 * @property string $SURFACE
 * @property string $VERTID
 * @property string $VERTRNAME
 * @property string $VKPERC
 * @property string $VKPREIS
 * @property string $VPE1
 * @property string $VPE2
 * @property string $VPE3
 * @property string $VPREIS0
 * @property string $VPREIS1
 * @property string $VPREIS2
 * @property string $VPREIS3
 * @property string $VPREIS4
 * @property string $VPREIS5
 * @property string $VPROV
 * @property string $VPROZ0
 * @property string $VPROZ1
 * @property string $VPROZ2
 * @property string $VPROZ3
 * @property string $VPROZ4
 * @property string $VPROZ5
 * @property string $VRABATT
 * @property string $CNAME
 * @property string $CHNAME
 * @property string $CDATE
 * @property string $CHDATE
 * @property string $MANDANTNO
 * @property string $ACCOUNT0
 * @property string $ACCOUNT1
 * @property string $ACCOUNT2
 * @property string $ACCOUNT3
 * @property string $DISCOUNT7
 * @property string $DISCOUNT8
 * @property string $DISCOUNT9
 * @property string $DISCOUNT10
 * @property string $DISCOUNT11
 * @property string $DISCOUNT12
 * @property string $DISCOUNT13
 * @property string $DISCOUNT14
 * @property string $DISCOUNT15
 * @property string $MENGE7
 * @property string $MENGE8
 * @property string $MENGE9
 * @property string $MENGE10
 * @property string $MENGE11
 * @property string $MENGE12
 * @property string $MENGE13
 * @property string $MENGE14
 * @property string $NETPRICE7
 * @property string $NETPRICE8
 * @property string $NETPRICE9
 * @property string $NETPRICE10
 * @property string $NETPRICE11
 * @property string $NETPRICE12
 * @property string $NETPRICE13
 * @property string $NETPRICE14
 * @property string $NETPRICE15
 * @property string $PADDITION7
 * @property string $PADDITION8
 * @property string $PADDITION9
 * @property string $PADDITION10
 * @property string $PADDITION11
 * @property string $PADDITION12
 * @property string $PADDITION13
 * @property string $PADDITION14
 * @property string $PADDITION15
 * @property string $PREIS7
 * @property string $PREIS8
 * @property string $PREIS9
 * @property string $PREIS10
 * @property string $PREIS11
 * @property string $PREIS12
 * @property string $PREIS13
 * @property string $PREIS14
 *
 * @property PAARTGRP $gRPNO
 */
class Pa_artpos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PA_ARTPOS';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ARTNO', 'GRPNO', 'ARTNAME'], 'required'],
            [['ARTNO', 'GRPNO', 'FIND', 'FTYP', 'ARCHIVED', 'DISCONTINUED', 'ADDRNO0', 'ADDRNO1', 'ADDRNO2', 'ADDRNO3', 'ADDRNO4', 'ADDRNO5', 'ALAGER0', 'ALAGER1', 'ALAGER2', 'ALAGER3', 'ALAGER4', 'ALAGER5', 'AMENGE1', 'AMENGE2', 'AMENGE3', 'APLACEI', 'APREIS1', 'APREIS2', 'APREIS3', 'ARTADDR1', 'ARTADDR2', 'ARTADDR3', 'ARTPRT0', 'ARTPRT1', 'ARTPRT2', 'AUTOLEAVE', 'AUTORESERV', 'AVERAGEPRICE', 'BESTM0', 'BESTM1', 'BESTM2', 'CHARGE', 'DISCOUNT1', 'DISCOUNT2', 'DISCOUNT3', 'DISCOUNT4', 'DISCOUNT5', 'DISCOUNT6', 'DISDEMANDALL', 'DISDEMANDALLLEFT', 'DISDEMANDDIFF', 'DISDEMANDPACTIVE', 'DISDEMANDPACTIVELEFT', 'DISDEMANDPPASSIVE', 'DISDEMANDPPASSIVELEFT', 'DISPRODUCING', 'EINHEIT', 'EINHIN', 'EINHOUT', 'EINHST', 'EINKAUF0', 'EINKAUF1', 'EINKAUF2', 'EINKAUF3', 'EINKAUF4', 'EINKAUF5', 'EKPERC', 'EKPREIS', 'EPREIS0', 'EPREIS1', 'EPREIS2', 'EPREIS3', 'EPREIS4', 'EPREIS5', 'EPROZ0', 'EPROZ1', 'EPROZ2', 'EPROZ3', 'EPROZ4', 'EPROZ5', 'EXCLUDEINDISPO', 'FAKTOR1', 'FAKTOR2', 'FAKTOR3', 'ISCASTING', 'MATTYP', 'MCPERC', 'MCREAL', 'MDIM1', 'MDIM2', 'MDIM3', 'MDIM4', 'MENGE', 'MENGE1', 'MENGE2', 'MENGE3', 'MENGE4', 'MENGE5', 'MENGE6', 'MIDENT1', 'MIDENT2', 'MIDENT3', 'MIDENT4', 'MIDENT5', 'MIDENT6', 'MIDENT7', 'MIDENT8', 'MINBE3', 'MINBE4', 'MINBE5', 'MINPRICE', 'MWEIG1', 'MWEIG2', 'MWEIG3', 'NETPRICE1', 'NETPRICE2', 'NETPRICE3', 'NETPRICE4', 'NETPRICE5', 'NETPRICE6', 'ORDERED', 'PADDITION1', 'PADDITION2', 'PADDITION3', 'PADDITION4', 'PADDITION5', 'PADDITION6', 'PLATE', 'PPREIS', 'PREIS', 'PREIS1', 'PREIS2', 'PREIS3', 'PREIS4', 'PREIS5', 'PREIS6', 'PROVREADY', 'RABATT', 'RABATTREADY', 'SUPPLIED', 'SURFACE', 'VERTID', 'VKPERC', 'VKPREIS', 'VPE1', 'VPE2', 'VPE3', 'VPREIS0', 'VPREIS1', 'VPREIS2', 'VPREIS3', 'VPREIS4', 'VPREIS5', 'VPROV', 'VPROZ0', 'VPROZ1', 'VPROZ2', 'VPROZ3', 'VPROZ4', 'VPROZ5', 'VRABATT', 'MANDANTNO', 'ACCOUNT0', 'ACCOUNT1', 'ACCOUNT2', 'ACCOUNT3', 'DISCOUNT7', 'DISCOUNT8', 'DISCOUNT9', 'DISCOUNT10', 'DISCOUNT11', 'DISCOUNT12', 'DISCOUNT13', 'DISCOUNT14', 'DISCOUNT15', 'MENGE7', 'MENGE8', 'MENGE9', 'MENGE10', 'MENGE11', 'MENGE12', 'MENGE13', 'MENGE14', 'NETPRICE7', 'NETPRICE8', 'NETPRICE9', 'NETPRICE10', 'NETPRICE11', 'NETPRICE12', 'NETPRICE13', 'NETPRICE14', 'NETPRICE15', 'PADDITION7', 'PADDITION8', 'PADDITION9', 'PADDITION10', 'PADDITION11', 'PADDITION12', 'PADDITION13', 'PADDITION14', 'PADDITION15', 'PREIS7', 'PREIS8', 'PREIS9', 'PREIS10', 'PREIS11', 'PREIS12', 'PREIS13', 'PREIS14'], 'number'],
            [['ARTDESC', 'ARTNAME', 'FNUM', 'AEINH1', 'AEINH2', 'AEINH3', 'ALAGERN', 'ARTDOC0', 'ARTDOC1', 'ARTDOC2', 'ARTINF1', 'BITMAPA', 'BITMAPB', 'DINNO1', 'DINNO2', 'DRAWNO', 'MASSEINH', 'MFAKT', 'PARTNO', 'SERIALNUMBERKEY', 'VERTRNAME', 'CNAME', 'CHNAME'], 'string'],
            [['ADATUM1', 'ADATUM2', 'ADATUM3', 'DISCALCDATE', 'DISFIRSTDATEMINUS', 'CDATE', 'CHDATE','toolNo','grpNo'], 'safe'],
            [['ARTNO'], 'unique'],
            [['GRPNO'], 'exist', 'skipOnError' => true, 'targetClass' => Pa_artgrp::className(), 'targetAttribute' => ['GRPNO' => 'GRPNO']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ARTNO' => 'Artno',
            'GRPNO' => 'Grpno',
            'ARTDESC' => 'Artikel-Nr.',
            'ARTNAME' => 'Beschreibung',
            'FIND' => 'Find',
            'FNUM' => 'Stückliste',
            'FTYP' => 'Typ',
            'ARCHIVED' => 'Archived',
            'DISCONTINUED' => 'Discontinued',
            'ADATUM1' => 'Adatum1',
            'ADATUM2' => 'Adatum2',
            'ADATUM3' => 'Adatum3',
            'ADDRNO0' => 'Addrno0',
            'ADDRNO1' => 'Addrno1',
            'ADDRNO2' => 'Addrno2',
            'ADDRNO3' => 'Addrno3',
            'ADDRNO4' => 'Addrno4',
            'ADDRNO5' => 'Addrno5',
            'AEINH1' => 'Aeinh1',
            'AEINH2' => 'Aeinh2',
            'AEINH3' => 'Aeinh3',
            'ALAGER0' => 'Mindestbestand',
            'ALAGER1' => 'Bestellbestand',
            'ALAGER2' => 'Reservierter Bestand',
            'ALAGER3' => 'Effektivbestand',
            'ALAGER4' => 'Alager4',
            'ALAGER5' => 'Alager5',
            'ALAGERN' => 'Alagern',
            'AMENGE1' => 'Amenge1',
            'AMENGE2' => 'Amenge2',
            'AMENGE3' => 'Amenge3',
            'APLACEI' => 'Aplacei',
            'APREIS1' => 'Apreis1',
            'APREIS2' => 'Apreis2',
            'APREIS3' => 'Apreis3',
            'ARTADDR1' => 'Artaddr1',
            'ARTADDR2' => 'Artaddr2',
            'ARTADDR3' => 'Artaddr3',
            'ARTDOC0' => 'Artdoc0',
            'ARTDOC1' => 'Artdoc1',
            'ARTDOC2' => 'Artdoc2',
            'ARTINF1' => 'Artinf1',
            'ARTPRT0' => 'Artprt0',
            'ARTPRT1' => 'Artprt1',
            'ARTPRT2' => 'Artprt2',
            'AUTOLEAVE' => 'Autoleave',
            'AUTORESERV' => 'Autoreserv',
            'AVERAGEPRICE' => 'Averageprice',
            'BESTM0' => 'Bestm0',
            'BESTM1' => 'Bestm1',
            'BESTM2' => 'Bestm2',
            'BITMAPA' => 'Bitmapa',
            'BITMAPB' => 'Bitmapb',
            'CHARGE' => 'Charge',
            'DINNO1' => 'Dinno1',
            'DINNO2' => 'Dinno2',
            'DISCALCDATE' => 'Discalcdate',
            'DISCOUNT1' => 'Discount1',
            'DISCOUNT2' => 'Discount2',
            'DISCOUNT3' => 'Discount3',
            'DISCOUNT4' => 'Discount4',
            'DISCOUNT5' => 'Discount5',
            'DISCOUNT6' => 'Discount6',
            'DISDEMANDALL' => 'Disdemandall',
            'DISDEMANDALLLEFT' => 'Disdemandallleft',
            'DISDEMANDDIFF' => 'Disdemanddiff',
            'DISDEMANDPACTIVE' => 'Disdemandpactive',
            'DISDEMANDPACTIVELEFT' => 'Disdemandpactiveleft',
            'DISDEMANDPPASSIVE' => 'Disdemandppassive',
            'DISDEMANDPPASSIVELEFT' => 'Disdemandppassiveleft',
            'DISFIRSTDATEMINUS' => 'Disfirstdateminus',
            'DISPRODUCING' => 'Disproducing',
            'DRAWNO' => 'Zeichnungsnummer',
            'EINHEIT' => 'Mengen-Einheit',
            'EINHIN' => 'Einhin',
            'EINHOUT' => 'Einhout',
            'EINHST' => 'Einh.',
            'EINKAUF0' => 'Einkauf0',
            'EINKAUF1' => 'Einkauf1',
            'EINKAUF2' => 'Einkauf2',
            'EINKAUF3' => 'Einkauf3',
            'EINKAUF4' => 'Einkauf4',
            'EINKAUF5' => 'Einkauf5',
            'EKPERC' => 'Ekperc',
            'EKPREIS' => 'Ekpreis',
            'EPREIS0' => 'Epreis0',
            'EPREIS1' => 'Epreis1',
            'EPREIS2' => 'Epreis2',
            'EPREIS3' => 'Epreis3',
            'EPREIS4' => 'Epreis4',
            'EPREIS5' => 'Epreis5',
            'EPROZ0' => 'Eproz0',
            'EPROZ1' => 'Eproz1',
            'EPROZ2' => 'Eproz2',
            'EPROZ3' => 'Eproz3',
            'EPROZ4' => 'Eproz4',
            'EPROZ5' => 'Eproz5',
            'EXCLUDEINDISPO' => 'Excludeindispo',
            'FAKTOR1' => 'Faktor1',
            'FAKTOR2' => 'Faktor2',
            'FAKTOR3' => 'Faktor3',
            'ISCASTING' => 'Iscasting',
            'MASSEINH' => 'Masseinheit',
            'MATTYP' => 'Mattyp',
            'MCPERC' => 'Mcperc',
            'MCREAL' => 'Mcreal',
            'MDIM1' => 'Länge',
            'MDIM2' => 'Mdim2',
            'MDIM3' => 'Mdim3',
            'MDIM4' => 'Mdim4',
            'MENGE' => 'Menge',
            'MENGE1' => 'Menge1',
            'MENGE2' => 'Menge2',
            'MENGE3' => 'Menge3',
            'MENGE4' => 'Menge4',
            'MENGE5' => 'Menge5',
            'MENGE6' => 'Menge6',
            'MFAKT' => 'Mfakt',
            'MIDENT1' => 'Mident1',
            'MIDENT2' => 'Mident2',
            'MIDENT3' => 'Mident3',
            'MIDENT4' => 'Mident4',
            'MIDENT5' => 'Mident5',
            'MIDENT6' => 'Mident6',
            'MIDENT7' => 'Mident7',
            'MIDENT8' => 'Mident8',
            'MINBE3' => 'Minbe3',
            'MINBE4' => 'Minbe4',
            'MINBE5' => 'Minbe5',
            'MINPRICE' => 'Minprice',
            'MWEIG1' => 'Gew. / Art. [kg]',
            'MWEIG2' => 'Mweig2',
            'MWEIG3' => 'Mweig3',
            'NETPRICE1' => 'Netprice1',
            'NETPRICE2' => 'Netprice2',
            'NETPRICE3' => 'Netprice3',
            'NETPRICE4' => 'Netprice4',
            'NETPRICE5' => 'Netprice5',
            'NETPRICE6' => 'Netprice6',
            'ORDERED' => 'Ordered',
            'PADDITION1' => 'Paddition1',
            'PADDITION2' => 'Paddition2',
            'PADDITION3' => 'Paddition3',
            'PADDITION4' => 'Paddition4',
            'PADDITION5' => 'Paddition5',
            'PADDITION6' => 'Paddition6',
            'PARTNO' => 'Kunden Art. Nr.',
            'PLATE' => 'Plate',
            'PPREIS' => 'Ppreis',
            'PREIS' => 'Preis',
            'PREIS1' => 'Preis1',
            'PREIS2' => 'Preis2',
            'PREIS3' => 'Preis3',
            'PREIS4' => 'Preis4',
            'PREIS5' => 'Preis5',
            'PREIS6' => 'Preis6',
            'PROVREADY' => 'Provready',
            'RABATT' => 'Rabatt',
            'RABATTREADY' => 'Rabattready',
            'SERIALNUMBERKEY' => 'Serialnumberkey',
            'SUPPLIED' => 'Supplied',
            'SURFACE' => 'Surface',
            'VERTID' => 'Vertid',
            'VERTRNAME' => 'Vertrname',
            'VKPERC' => 'Vkperc',
            'VKPREIS' => 'Vkpreis',
            'VPE1' => 'Vpe1',
            'VPE2' => 'Vpe2',
            'VPE3' => 'Vpe3',
            'VPREIS0' => 'Vpreis0',
            'VPREIS1' => 'Vpreis1',
            'VPREIS2' => 'Vpreis2',
            'VPREIS3' => 'Vpreis3',
            'VPREIS4' => 'Vpreis4',
            'VPREIS5' => 'Vpreis5',
            'VPROV' => 'Vprov',
            'VPROZ0' => 'Vproz0',
            'VPROZ1' => 'Vproz1',
            'VPROZ2' => 'Vproz2',
            'VPROZ3' => 'Vproz3',
            'VPROZ4' => 'Vproz4',
            'VPROZ5' => 'Vproz5',
            'VRABATT' => 'Vrabatt',
            'CNAME' => 'Cname',
            'CHNAME' => 'Chname',
            'CDATE' => 'Cdate',
            'CHDATE' => 'Chdate',
            'MANDANTNO' => 'Mandantno',
            'ACCOUNT0' => 'Account0',
            'ACCOUNT1' => 'Account1',
            'ACCOUNT2' => 'Account2',
            'ACCOUNT3' => 'Account3',
            'DISCOUNT7' => 'Discount7',
            'DISCOUNT8' => 'Discount8',
            'DISCOUNT9' => 'Discount9',
            'DISCOUNT10' => 'Discount10',
            'DISCOUNT11' => 'Discount11',
            'DISCOUNT12' => 'Discount12',
            'DISCOUNT13' => 'Discount13',
            'DISCOUNT14' => 'Discount14',
            'DISCOUNT15' => 'Discount15',
            'MENGE7' => 'Menge7',
            'MENGE8' => 'Menge8',
            'MENGE9' => 'Menge9',
            'MENGE10' => 'Menge10',
            'MENGE11' => 'Menge11',
            'MENGE12' => 'Menge12',
            'MENGE13' => 'Menge13',
            'MENGE14' => 'Menge14',
            'NETPRICE7' => 'Netprice7',
            'NETPRICE8' => 'Netprice8',
            'NETPRICE9' => 'Netprice9',
            'NETPRICE10' => 'Netprice10',
            'NETPRICE11' => 'Netprice11',
            'NETPRICE12' => 'Netprice12',
            'NETPRICE13' => 'Netprice13',
            'NETPRICE14' => 'Netprice14',
            'NETPRICE15' => 'Netprice15',
            'PADDITION7' => 'Paddition7',
            'PADDITION8' => 'Paddition8',
            'PADDITION9' => 'Paddition9',
            'PADDITION10' => 'Paddition10',
            'PADDITION11' => 'Paddition11',
            'PADDITION12' => 'Paddition12',
            'PADDITION13' => 'Paddition13',
            'PADDITION14' => 'Paddition14',
            'PADDITION15' => 'Paddition15',
            'PREIS7' => 'Preis7',
            'PREIS8' => 'Preis8',
            'PREIS9' => 'Preis9',
            'PREIS10' => 'Preis10',
            'PREIS11' => 'Preis11',
            'PREIS12' => 'Preis12',
            'PREIS13' => 'Preis13',
            'PREIS14' => 'Preis14',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrpNo()
    {
        return $this->hasOne(Pa_artgrp::className(), ['GRPNO' => 'GRPNO']);
    }

    public function getToolNo()
    {
        return $this->hasOne(Ororder::className(), ['NAME' => 'FNUM']);
    }

}
