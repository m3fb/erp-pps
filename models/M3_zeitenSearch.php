<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\M3_zeiten;

/**
 * M3_zeitenSearch represents the model behind the search form about `app\models\M3_zeiten`.
 */
class M3_zeitenSearch extends M3_zeiten
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID'], 'integer'],
            [['MSTIME', 'PERSNAME'], 'safe'],
            [['PERSNO', 'STATUS', 'WORKID'], 'number'],
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
        $query = M3_zeiten::find();

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
            'MSTIME' => $this->MSTIME,
            'PERSNO' => $this->PERSNO,
            'STATUS' => $this->STATUS,
            'WORKID' => $this->WORKID,
            'Personalnummer' => $this->PERSNO,
        ]);

        $query->andFilterWhere(['like', 'PERSNAME', $this->PERSNAME]);

        return $dataProvider;
    }
}
