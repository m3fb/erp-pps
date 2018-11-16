<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Planung extends ActiveRecord
{

	
	public static function tableName()
	{
		return 'OR_OP';
	}

  
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NO', 'ORNO'], 'required'],
            [['ORNO'], 'number'],
        ];
    } 
	
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ORNO' => 'Auftragsnummer',
            
        ];
    }
}
?>
