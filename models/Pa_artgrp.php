<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "PA_ARTGRP".
 *
 * @property string $GRPNO
 * @property string $GRPNAME
 * @property string $ACCOUNT0
 * @property string $ACCOUNT1
 * @property string $ACCOUNT2
 * @property string $ACCOUNT3
 * @property string $ADDRNO0
 * @property string $ADDRNO1
 * @property string $ADDRNO2
 * @property string $ADDRNO3
 * @property string $ADDRNO4
 * @property string $ADDRNO5
 * @property string $AGRINF1
 * @property string $AGRINF2
 * @property string $ALAGER0
 * @property string $ALAGER1
 * @property string $ALAGER2
 * @property string $ALAGER3
 * @property string $ALAGER4
 * @property string $ALAGER5
 * @property string $ALAGERN
 * @property string $APLACEI
 * @property string $ARTDOC0
 * @property string $ARTDOC1
 * @property string $ARTDOC2
 * @property string $ARTPRT0
 * @property string $ARTPRT1
 * @property string $ARTPRT2
 * @property string $BESTM0
 * @property string $BESTM1
 * @property string $BESTM2
 * @property string $BITMAPA
 * @property string $BITMAPB
 * @property string $EINHEIT
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
 * @property string $FAKTOR1
 * @property string $FAKTOR2
 * @property string $FAKTOR3
 * @property string $MASSEINH
 * @property string $MDIM1
 * @property string $MDIM2
 * @property string $MDIM3
 * @property string $MENGE
 * @property string $MENGE5
 * @property string $MENGE6
 * @property string $MIDENT1
 * @property string $MIDENT2
 * @property string $MIDENT3
 * @property string $MINBE3
 * @property string $MINBE4
 * @property string $MINBE5
 * @property string $MWEIG1
 * @property string $MWEIG2
 * @property string $MWEIG3
 * @property string $PREIS5
 * @property string $PREIS6
 * @property string $VKPERC
 * @property string $VKPREIS
 * @property string $VPREIS0
 * @property string $VPREIS1
 * @property string $VPREIS2
 * @property string $VPREIS3
 * @property string $VPREIS4
 * @property string $VPREIS5
 * @property string $VPROZ0
 * @property string $VPROZ1
 * @property string $VPROZ2
 * @property string $VPROZ3
 * @property string $VPROZ4
 * @property string $VPROZ5
 * @property string $CNAME
 * @property string $CHNAME
 * @property string $CDATE
 * @property string $CHDATE
 * @property string $MANDANTNO
 *
 * @property PAARTPOS[] $pAARTPOSs
 */
class Pa_artgrp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PA_ARTGRP';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GRPNO', 'GRPNAME'], 'required'],
            [['GRPNO', 'ACCOUNT0', 'ACCOUNT1', 'ACCOUNT2', 'ACCOUNT3', 'ADDRNO0', 'ADDRNO1', 'ADDRNO2', 'ADDRNO3', 'ADDRNO4', 'ADDRNO5', 'ALAGER0', 'ALAGER1', 'ALAGER2', 'ALAGER3', 'ALAGER4', 'ALAGER5', 'APLACEI', 'ARTPRT0', 'ARTPRT1', 'ARTPRT2', 'BESTM0', 'BESTM1', 'BESTM2', 'EINHEIT', 'EINKAUF0', 'EINKAUF1', 'EINKAUF2', 'EINKAUF3', 'EINKAUF4', 'EINKAUF5', 'EKPERC', 'EKPREIS', 'EPREIS0', 'EPREIS1', 'EPREIS2', 'EPREIS3', 'EPREIS4', 'EPREIS5', 'EPROZ0', 'EPROZ1', 'EPROZ2', 'EPROZ3', 'EPROZ4', 'EPROZ5', 'FAKTOR1', 'FAKTOR2', 'FAKTOR3', 'MDIM1', 'MDIM2', 'MDIM3', 'MENGE', 'MENGE5', 'MENGE6', 'MIDENT1', 'MIDENT2', 'MIDENT3', 'MINBE3', 'MINBE4', 'MINBE5', 'MWEIG1', 'MWEIG2', 'MWEIG3', 'PREIS5', 'PREIS6', 'VKPERC', 'VKPREIS', 'VPREIS0', 'VPREIS1', 'VPREIS2', 'VPREIS3', 'VPREIS4', 'VPREIS5', 'VPROZ0', 'VPROZ1', 'VPROZ2', 'VPROZ3', 'VPROZ4', 'VPROZ5', 'MANDANTNO'], 'number'],
            [['GRPNAME', 'AGRINF1', 'AGRINF2', 'ALAGERN', 'ARTDOC0', 'ARTDOC1', 'ARTDOC2', 'BITMAPA', 'BITMAPB', 'MASSEINH', 'CNAME', 'CHNAME'], 'string'],
            [['CDATE', 'CHDATE'], 'safe'],
            [['GRPNO'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'GRPNO' => 'Grpno',
            'GRPNAME' => 'Grpname',
            'ACCOUNT0' => 'Account0',
            'ACCOUNT1' => 'Account1',
            'ACCOUNT2' => 'Account2',
            'ACCOUNT3' => 'Account3',
            'ADDRNO0' => 'Addrno0',
            'ADDRNO1' => 'Addrno1',
            'ADDRNO2' => 'Addrno2',
            'ADDRNO3' => 'Addrno3',
            'ADDRNO4' => 'Addrno4',
            'ADDRNO5' => 'Addrno5',
            'AGRINF1' => 'Agrinf1',
            'AGRINF2' => 'Agrinf2',
            'ALAGER0' => 'Alager0',
            'ALAGER1' => 'Alager1',
            'ALAGER2' => 'Alager2',
            'ALAGER3' => 'Alager3',
            'ALAGER4' => 'Alager4',
            'ALAGER5' => 'Alager5',
            'ALAGERN' => 'Alagern',
            'APLACEI' => 'Aplacei',
            'ARTDOC0' => 'Artdoc0',
            'ARTDOC1' => 'Artdoc1',
            'ARTDOC2' => 'Artdoc2',
            'ARTPRT0' => 'Artprt0',
            'ARTPRT1' => 'Artprt1',
            'ARTPRT2' => 'Artprt2',
            'BESTM0' => 'Bestm0',
            'BESTM1' => 'Bestm1',
            'BESTM2' => 'Bestm2',
            'BITMAPA' => 'Bitmapa',
            'BITMAPB' => 'Bitmapb',
            'EINHEIT' => 'Einheit',
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
            'FAKTOR1' => 'Faktor1',
            'FAKTOR2' => 'Faktor2',
            'FAKTOR3' => 'Faktor3',
            'MASSEINH' => 'Masseinh',
            'MDIM1' => 'Mdim1',
            'MDIM2' => 'Mdim2',
            'MDIM3' => 'Mdim3',
            'MENGE' => 'Menge',
            'MENGE5' => 'Menge5',
            'MENGE6' => 'Menge6',
            'MIDENT1' => 'Mident1',
            'MIDENT2' => 'Mident2',
            'MIDENT3' => 'Mident3',
            'MINBE3' => 'Minbe3',
            'MINBE4' => 'Minbe4',
            'MINBE5' => 'Minbe5',
            'MWEIG1' => 'Mweig1',
            'MWEIG2' => 'Mweig2',
            'MWEIG3' => 'Mweig3',
            'PREIS5' => 'Preis5',
            'PREIS6' => 'Preis6',
            'VKPERC' => 'Vkperc',
            'VKPREIS' => 'Vkpreis',
            'VPREIS0' => 'Vpreis0',
            'VPREIS1' => 'Vpreis1',
            'VPREIS2' => 'Vpreis2',
            'VPREIS3' => 'Vpreis3',
            'VPREIS4' => 'Vpreis4',
            'VPREIS5' => 'Vpreis5',
            'VPROZ0' => 'Vproz0',
            'VPROZ1' => 'Vproz1',
            'VPROZ2' => 'Vproz2',
            'VPROZ3' => 'Vproz3',
            'VPROZ4' => 'Vproz4',
            'VPROZ5' => 'Vproz5',
            'CNAME' => 'Cname',
            'CHNAME' => 'Chname',
            'CDATE' => 'Cdate',
            'CHDATE' => 'Chdate',
            'MANDANTNO' => 'Mandantno',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPAARTPOSs()
    {
        return $this->hasMany(PAARTPOS::className(), ['GRPNO' => 'GRPNO']);
    }
}
