<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use app\models\Planung;

/**
 * BdeSearch represents the model behind the search form about `app\models\Bde`.
 */
class PlanungSearch extends Planung
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ORNO'], 'required'],
            [['ORNO'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

public function findOpenOrders() {
	
		$dataProvider = $this->find()
		
		->select(['OR_OP.ORNO','OR_ORDER.NO','OR_ORDER.DELIVERY', 'OR_ORDER.NAME AS OR_ORDER_NAME','OR_ORDER.COMMNO','WP_MA1.NO AS WP_MA1_NO', 'WP_MA1.NAME','WP_MA1.STATUS','WP_MA1.TERMNO' ])
		->from('OR_OP')
		->leftJoin('OR_ORDER', 'OR_OP.ORNO = OR_ORDER.NO')
		->leftJoin('WP_MA1', 'OR_OP.PWPLACE = WP_MA1.NO')	
												
		->where(['in','OR_ORDER.STATUS',[0,1]])
		->andWhere(['like','OR_ORDER.NAME','LG-'])
		->andWhere(['WP_MA1.STATUS' => 0])
		->andWhere(['WP_MA1.TERMNO' => 0])
		
		->orderBy([
			'WP_MA1.NAME' => SORT_ASC,
			'OR_ORDER.DELIVERY' => SORT_ASC,
			])
			
		->groupBy(['OR_OP.ORNO','OR_ORDER.NO','OR_ORDER.DELIVERY', 'OR_ORDER.NAME','OR_ORDER.COMMNO','WP_MA1.NO', 'WP_MA1.NAME','WP_MA1.STATUS','WP_MA1.TERMNO' ])
		->asArray()->all();
		
		
		$i=0;
		$max=3
		;
		$tool='';
		$wno='';
		foreach ($dataProvider as $model) {
				if($wno != $model['WP_MA1_NO']){
					$wno = $model['WP_MA1_NO'];
					$i=0;
				}
				if ($wno = $model['WP_MA1_NO'] and $tool!=$model['COMMNO'] and $i < $max){
					$tool = $model['COMMNO'];
					$ar_index=$wno."_".$i;
					$orders[$ar_index] = $tool;
					$i++;
				}	
			}
		
		

        return $orders;
	}
    
 
	
public function findOpenProductionOrders() {
		
		$dataProvider = $this->find()
		
		->select(['PA_POSIT.PONO','PA_POSIT.POSART','PA_POSIT.POSTEXT'])
		
		->leftJoin('PA_PAPER', 'PA_POSIT.PANO = PA_PAPER.PANO')
		->leftJoin('PA_ARTPOS', 'PA_POSIT.POSART = PA_ARTPOS.ARTDESC')	
												
		->where(['PA_ARTPOS.FNUM' =>''])
		->andWhere(['PA_PAPER.IDENT' => 1])
		->andWhere(['between','PA_POSIT.POSART',100000,499999])
		
		->orderBy('POSART')
		->groupBy('POSART')->asArray()->all();
		

        return $dataProvider;
	}
	
public function findActiveMachines() {
		
		$dataProvider = $this->find()

		->select(['WP_MA1.NAME','WP_MA1.NO AS WP_MA1_NO', 'WP_MA1.CONTROL'])
		->from('WP_MA1')
												
		->where(['WP_MA1.STATUS' => 0])
		->andWhere(['WP_MA1.TERMNO' => 0])
		
		->orderBy('WP_MA1.NAME')->asArray()->all();
		

        return $dataProvider;
	}


}
