<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\M3UrlaubStunden;

/**
 * M3UrlaubStundenSearch represents the model behind the search form about `app\models\M3UrlaubStunden`.
 */
class M3UrlaubStundenSearch extends M3UrlaubStunden
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID'], 'integer'],
            [['WORKID', 'JAHR', 'S1', 'S2', 'S3', 'S4', 'S5', 'S6', 'S7', 'S8', 'S9', 'S10', 'S11', 'S12', 'U1', 'U2', 'U3', 'U4', 'U5', 'U6', 'U7', 'U8', 'U9', 'U10', 'U11', 'U12'], 'number'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = M3UrlaubStunden::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID' => $this->ID,
            'WORKID' => $this->WORKID,
            'JAHR' => $this->JAHR,
            'S1' => $this->S1,
            'S2' => $this->S2,
            'S3' => $this->S3,
            'S4' => $this->S4,
            'S5' => $this->S5,
            'S6' => $this->S6,
            'S7' => $this->S7,
            'S8' => $this->S8,
            'S9' => $this->S9,
            'S10' => $this->S10,
            'S11' => $this->S11,
            'S12' => $this->S12,
            'U1' => $this->U1,
            'U2' => $this->U2,
            'U3' => $this->U3,
            'U4' => $this->U4,
            'U5' => $this->U5,
            'U6' => $this->U6,
            'U7' => $this->U7,
            'U8' => $this->U8,
            'U9' => $this->U9,
            'U10' => $this->U10,
            'U11' => $this->U11,
            'U12' => $this->U12,
        ]);

        return $dataProvider;
    }
    
    public function getPersUrlaubStunden($id)
    {
		$query = $this->find()->where(['WORKID' => $id])->orderBy(['JAHR' => SORT_ASC,])->asArray();
		
		$dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
		
	}
}
