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
class Pe_work extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'PE_WORK';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['NO'], 'required'],
            [['NO', 'CALNO', 'CONO', 'COSTNO', 'COSTPH1', 'COSTPH2', 'COSTPH3', 'DEPTNO', 'EFC', 'GROUPNO', 'INTMAIL1', 'SEX', 'SHIFTNO', 'STATUS1', 'STATUS2', 'STATUS3', 'WENDH', 'WSTARTH'], 'number'],
            [['PERSNO', 'FIRSTNAME', 'SURNAME', 'BITMAP', 'CNTRYSIGN', 'FAX', 'MODEM', 'PDAYINF1', 'PDAYINF2', 'PDAYINF3', 'PEINFO', 'PHONE1', 'PHONE2', 'PHONE3', 'PLACE', 'POSITION', 'POSTCODE', 'SALUTE', 'SBREAK', 'STREET', 'CNAME', 'CHNAME'], 'string'],
            [['PDAYDAT1', 'PDAYDAT2', 'PDAYDAT3', 'WENDT', 'WSTARTT', 'CDATE', 'CHDATE'], 'safe'],
            [['NO'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'NO' => 'N O',
            'PERSNO' => 'P E R S N O',
            'FIRSTNAME' => 'F I R S T N A M E',
            'SURNAME' => 'S U R N A M E',
            'BITMAP' => 'B I T M A P',
            'CALNO' => 'C A L N O',
            'CNTRYSIGN' => 'C N T R Y S I G N',
            'CONO' => 'C O N O',
            'COSTNO' => 'C O S T N O',
            'COSTPH1' => 'C O S T P H1',
            'COSTPH2' => 'C O S T P H2',
            'COSTPH3' => 'C O S T P H3',
            'DEPTNO' => 'D E P T N O',
            'EFC' => 'E F C',
            'FAX' => 'F A X',
            'GROUPNO' => 'G R O U P N O',
            'INTMAIL1' => 'I N T M A I L1',
            'MODEM' => 'M O D E M',
            'PDAYDAT1' => 'P D A Y D A T1',
            'PDAYDAT2' => 'P D A Y D A T2',
            'PDAYDAT3' => 'P D A Y D A T3',
            'PDAYINF1' => 'P D A Y I N F1',
            'PDAYINF2' => 'P D A Y I N F2',
            'PDAYINF3' => 'P D A Y I N F3',
            'PEINFO' => 'P E I N F O',
            'PHONE1' => 'P H O N E1',
            'PHONE2' => 'P H O N E2',
            'PHONE3' => 'P H O N E3',
            'PLACE' => 'P L A C E',
            'POSITION' => 'P O S I T I O N',
            'POSTCODE' => 'P O S T C O D E',
            'SALUTE' => 'S A L U T E',
            'SBREAK' => 'S B R E A K',
            'SEX' => 'S E X',
            'SHIFTNO' => 'S H I F T N O',
            'STATUS1' => 'S T A T U S1',
            'STATUS2' => 'S T A T U S2',
            'STATUS3' => 'S T A T U S3',
            'STREET' => 'S T R E E T',
            'WENDH' => 'W E N D H',
            'WENDT' => 'W E N D T',
            'WSTARTH' => 'W S T A R T H',
            'WSTARTT' => 'W S T A R T T',
            'CNAME' => 'C N A M E',
            'CHNAME' => 'C H N A M E',
            'CDATE' => 'C D A T E',
            'CHDATE' => 'C H D A T E',
        ];
    }
}
