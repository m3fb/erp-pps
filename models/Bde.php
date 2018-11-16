<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Bde extends ActiveRecord
{
	public $ORNO;
	public $ARDESC;
	
	public static function tableName()
	{
		return 'LB_DC';
	}

  
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['LBNO', 'ADCCOUNT'], 'required'],
            [['LBNO', 'ORNO', 'STATUS', 'WPLACE', 'PERSNO', 'OPNO', 'APARTS', 
				'GPARTS', 'BPARTS', 'ATE', 'ATR', 'ATP', 'ADCSTAT', 'ADCCOUNT', 
				'EXSTAT', 'MTIME0', 'MTIME1', 'MTIME2', 'MTIME3', 'OPOPNO', 'OUT', 
				'FNPK', 'MSGID', 'FKLBNO', 'ISINTERNAL', 'MANDANTNO'], 'number'],
            [['MSTIME', 'CDATE', 'CHDATE','ADCCOUNT'], 'safe'],
            [['PERSNAME', 'MSINFO', 'CNAME', 'CHNAME'], 'string', 'max' => 64],
            [['NAME', 'ORNAME', 'TERMINAL'], 'string', 'max' => 24],
            [['ADCMESS'], 'string', 'max' => 94],
            [['ADCWORK'], 'string', 'max' => 254],
            [['LBNO'], 'unique']
        ];
    } 
	
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'LBNO' => 'Lbno',
            'ORNO' => 'Orno',
            'STATUS' => 'Status',
            'WPLACE' => 'Wplace',
            'PERSNO' => 'Persno',
            'PERSNAME' => 'Persname',
            'OPNO' => 'Opno',
            'NAME' => 'Name',
            'MSTIME' => 'Mstime',
            'MSINFO' => 'Msinfo',
            'ORNAME' => 'Orname',
            'APARTS' => 'Aparts',
            'GPARTS' => 'Gparts',
            'BPARTS' => 'Bparts',
            'ATE' => 'Ate',
            'ATR' => 'Atr',
            'ATP' => 'Atp',
            'ADCSTAT' => 'Adcstat',
            'ADCCOUNT' => 'Menge',
            'ADCMESS' => 'Adcmess',
            'ADCWORK' => 'Adcwork',
            'EXSTAT' => 'Exstat',
            'MTIME0' => 'Mtime0',
            'MTIME1' => 'Mtime1',
            'MTIME2' => 'Mtime2',
            'MTIME3' => 'Mtime3',
            'OPOPNO' => 'Opopno',
            'OUT' => 'Out',
            'FNPK' => 'Fnpk',
            'MSGID' => 'Msgid',
            'FKLBNO' => 'Fklbno',
            'TERMINAL' => 'Terminal',
            'ISINTERNAL' => 'Isinternal',
            'CNAME' => 'Cname',
            'CHNAME' => 'Chname',
            'CDATE' => 'Cdate',
            'CHDATE' => 'Chdate',
            'MANDANTNO' => 'Mandantno',
        ];
    }
}
?>
