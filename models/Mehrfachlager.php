<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;



class Mehrfachlager extends ActiveRecord
{

	
	public static function tableName()
	{
		return 'ST_STOCK';
	}
    /**
     * @inheritdoc
     */
   public function rules()
    {
        return [
			[['PLACE'], 'required'],
            #[['PLACE'], 'save'], // 19.11.2015 TBD: Save verursacht Probleme beim Speichern von Editable Columns. Ursache nicht bekannt
            [['PLACE'], 'string', 'max' => 64],
        ];
    } 
    public function attributeLabels()
    {
        return [
           # 'POSART' => 'Posart',
            
        ];
    }
    
    public function getArtikeldaten()
    {
        return $this->hasOne(Artikeldaten::className(), ['ARTNO' => 'ARTNO']);
    }
    
    public function getStockplaces()
    {
        
		$query = Mehrfachlager::find()->where(['ARTNO'=>596]);
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
			'pageSize' => 10,
			],
		]
	);
        return $dataProvider;
    }
}


?>
