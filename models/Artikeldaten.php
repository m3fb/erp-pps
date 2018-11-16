<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;

class Artikeldaten extends ActiveRecord
{

	
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
			[['ARTDESC'], 'required'],
            [['ARTDESC'], 'number'],
        ];
    } 
	
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'POSART' => 'Posart',
            'ARTDESC' => 'Artikelnummer',
            
        ];
    }
    public function getStockplaces()
    {
        
		$query = $this->hasMany(Mehrfachlager::className(), ['ARTNO' => 'ARTNO'])->indexBy('NO')->orderBy('PLACE');
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
			'pageSize' => -1,
			],
			'sort' => [
            'attributes' => ['ST_STOCK.PLACE'],
        ],
		]
	);
        return $dataProvider;
    }
    
}



?>
