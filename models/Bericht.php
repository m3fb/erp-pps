<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Bericht extends ActiveRecord
{

	
	public static function tableName()
	{
		return 'PA_POSIT';
	}

  
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MENGE'], 'number'],
        ];
    } 
	
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'POSART' => 'Posart',
            
        ];
    }
}
?>
