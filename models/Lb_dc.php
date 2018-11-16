<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "LB_DC".
 *
 * @property string $LBNO
 * @property string $NAME
 * @property string $OPNO
 * @property string $OPOPNO
 * @property string $ORNAME
 * @property string $ORNO
 * @property string $OUT
 * @property string $ADCCOUNT
 * @property string $ADCMESS
 * @property string $ADCSTAT
 * @property string $ADCWORK
 * @property string $APARTS
 * @property string $ARCHIVE
 * @property string $ATE
 * @property string $ATP
 * @property string $ATR
 * @property string $BPARTS
 * @property string $BPARTS2
 * @property string $CALTYP
 * @property string $DESCR
 * @property string $ERRNUM
 * @property string $EXSTAT
 * @property string $FKLBNO
 * @property string $FNPK
 * @property string $GPARTS
 * @property string $INPARTSDBL
 * @property string $ISINTERNAL
 * @property string $MSGID
 * @property string $MSINFO
 * @property string $MSTIME
 * @property string $MTIME0
 * @property string $MTIME1
 * @property string $MTIME2
 * @property string $MTIME3
 * @property string $OPMULTIMESSAGEGROUP
 * @property string $PERSNAME
 * @property string $PERSNO
 * @property string $STATUS
 * @property string $TERMINAL
 * @property string $WPLACE
 * @property string $MATCOST
 * @property string $CNAME
 * @property string $CHNAME
 * @property string $CDATE
 * @property string $CHDATE
 * @property string $MANDANTNO
 * @property string $TSTAMP
 */
class Lb_dc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'LB_DC';
    }

    public function init()

    {

        parent::init();

        $this->ADCCOUNT = 0;
        $this->ADCSTAT = 0;
        $this->APARTS = 0;
        $this->ATE = 0;
        $this->ATP = 0;
        $this->ATR = 0;
        $this->BPARTS = 0;
        $this->BPARTS2 = 0;
        $this->CALTYP = 0;
        $this->EXSTAT = 0;
        $this->FNPK = 0;
        $this->GPARTS = 0;
        $this->MTIME0 = 0;
        $this->MTIME2 = 0;
        $this->MANDANTNO = 0;

        $this->ADCWORK ='';
        $this->DESCR = '';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['LBNO', 'ORNO', 'PERSNAME','PERSNO'], 'required'],
            [['LBNO', 'OPNO', 'OPOPNO', 'ORNO', 'OUT', 'ADCCOUNT', 'ADCSTAT', 'APARTS', 'ARCHIVE', 'ATE', 'ATP', 'ATR', 'BPARTS', 'BPARTS2', 'CALTYP', 'ERRNUM', 'EXSTAT', 'FKLBNO', 'FNPK', 'GPARTS', 'INPARTSDBL', 'ISINTERNAL', 'MSGID', 'MTIME0', 'MTIME1', 'MTIME2', 'MTIME3', 'OPMULTIMESSAGEGROUP', 'PERSNO', 'STATUS', 'WPLACE', 'MATCOST', 'MANDANTNO'], 'number'],
            [['NAME', 'ORNAME', 'ADCMESS', 'ADCWORK', 'DESCR', 'MSINFO', 'PERSNAME', 'TERMINAL', 'CNAME', 'CHNAME'], 'string'],
            [
              [
                'ADCCOUNT','ADCSTAT','APARTS','ATE','ATP','ATR','BPARTS','BPARTS2','CALTYP','EXSTAT','FNPK','GPARTS',
                'MTIME0','MTIME2','MANDANTNO','MSTIME', 'CDATE', 'CHDATE', 'TSTAMP'
              ],
              'safe'
            ],
            [
              [
                'ADCCOUNT','ADCSTAT','APARTS','ATE','ATP','ATR','BPARTS','BPARTS2','CALTYP','EXSTAT','FNPK','GPARTS',
                'MTIME0','MTIME2','MANDANTNO',
              ],
            'default', 'value' => 0
          ],

            [['LBNO'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'LBNO' => 'Lbno',
            'NAME' => 'Name',
            'OPNO' => 'Opno',
            'OPOPNO' => 'Opopno',
            'ORNAME' => 'Orname',
            'ORNO' => 'Orno',
            'OUT' => 'Out',
            'ADCCOUNT' => 'Adccount',
            'ADCMESS' => 'Adcmess',
            'ADCSTAT' => 'Adcstat',
            'ADCWORK' => 'Adcwork',
            'APARTS' => 'Aparts',
            'ARCHIVE' => 'Archive',
            'ATE' => 'Ate',
            'ATP' => 'Atp',
            'ATR' => 'Atr',
            'BPARTS' => 'Bparts',
            'BPARTS2' => 'Bparts2',
            'CALTYP' => 'Caltyp',
            'DESCR' => 'Descr',
            'ERRNUM' => 'Errnum',
            'EXSTAT' => 'Exstat',
            'FKLBNO' => 'Fklbno',
            'FNPK' => 'Fnpk',
            'GPARTS' => 'Gparts',
            'INPARTSDBL' => 'Inpartsdbl',
            'ISINTERNAL' => 'Isinternal',
            'MSGID' => 'Msgid',
            'MSINFO' => 'Msinfo',
            'MSTIME' => 'Mstime',
            'MTIME0' => 'Mtime0',
            'MTIME1' => 'Mtime1',
            'MTIME2' => 'Mtime2',
            'MTIME3' => 'Mtime3',
            'OPMULTIMESSAGEGROUP' => 'Opmultimessagegroup',
            'PERSNAME' => 'Persname',
            'PERSNO' => 'Persno',
            'STATUS' => 'Status',
            'TERMINAL' => 'Terminal',
            'WPLACE' => 'Wplace',
            'MATCOST' => 'Matcost',
            'CNAME' => 'Cname',
            'CHNAME' => 'Chname',
            'CDATE' => 'Cdate',
            'CHDATE' => 'Chdate',
            'MANDANTNO' => 'Mandantno',
            'TSTAMP' => 'Tstamp',
        ];
    }
}
