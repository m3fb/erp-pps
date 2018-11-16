<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;

class Pa_paper extends ActiveRecord
{


	public static function tableName()
	{
		return 'PA_PAPER';
	}


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PANO'], 'required'],
            [['PANO'], 'number'],
						[['STATUS'], 'number'],
						[['TXTNUMMER','ADDRTEXT','TXTIDENT','STATUS','CHDATE','CHNAME'],'safe']
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PANO' => 'Beleg-Id',

        ];
    }
    public function getOpenProjects()
    {
        $query = $this->find()
						->select(['PANO','TXTNUMMER','ADDRTEXT'])
						->where(['not',['STATUS'=>2]])
						->andWhere(['IDENT'=>1])
						->andWhere(['TXTIDENT'=>'Auftragsbestätigung Werkzeug'])
						->orderBy('PANO');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


				return $dataProvider;
    }

		/**
		*
		*/
		public function getOpenDocuments($params)
    {
        $query = $this->find()
						->select(['PANO','TXTNUMMER','ADDRTEXT','TXTIDENT','ANLAGEZEIT','STATUS'])
						->where(['in','IDENT',[1,2,5,6,7]]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

				$this->load($params);

				$query->andFilterWhere(['like', 'PA_PAPER.TXTNUMMER', $this->TXTNUMMER])
							->andFilterWhere(['like', 'PA_PAPER.ADDRTEXT', $this->ADDRTEXT])
							->andFilterWhere(['like', 'PA_PAPER.TXTIDENT', $this->TXTIDENT]);


				return $dataProvider;
    }

    public function getProject($id)
    {
		  $query = $this->find()
			->select(['POSNO','POSART','POSTXTL','MENGE','MASSEINH'])
			->from ('PA_POSIT')
			->join('LEFT JOIN', 'PA_PAPER', 'PA_PAAER.PANO = PA_POSIT.PANO')
			->where(['PANO'=>$id])
			->orderBy('POSNO');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

		return $dataProvider;
	}
}
?>
