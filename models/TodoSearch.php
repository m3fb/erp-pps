<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Todo;

/**
 * TodoSearch represents the model behind the search form about `app\models\Todo`.
 */
class TodoSearch extends Todo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'department', 'beauftragter', 'due_date', 'create_name', 'change_name', 'create_date', 'change_date', 'due_date_option'], 'safe'],
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
    public function searchOpenTasks($params)
    {
        $query = Todo::find()
         ->orderBy('due_date');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'due_date' => $this->due_date,
            'create_date' => $this->create_date,
            'change_date' => $this->change_date,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'department', $this->department])
            ->andFilterWhere(['like', 'beauftragter', $this->beauftragter])
            ->andFilterWhere(['like', 'create_name', $this->create_name])
            ->andFilterWhere(['like', 'change_name', $this->change_name])
            ->andFilterWhere(['like', 'due_date_option', $this->due_date_option]);

        return $dataProvider;
        }

        public function search($params)
        {
            $query = Todo::find();
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);

            $this->load($params);

            if (!$this->validate()) {
                // uncomment the following line if you do not want to return any records when validation fails
                // $query->where('0=1');
                return $dataProvider;
            }
            $query->orderBy('due_date');

            $query->andFilterWhere([
                'id' => $this->id,
                'due_date' => $this->due_date,
                'create_date' => $this->create_date,
                'change_date' => $this->change_date,
            ]);

            $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'department', $this->department])
                ->andFilterWhere(['like', 'beauftragter', $this->beauftragter])
                ->andFilterWhere(['like', 'create_name', $this->create_name])
                ->andFilterWhere(['like', 'change_name', $this->change_name])
                ->andFilterWhere(['like', 'due_date_option', $this->due_date_option]);

            return $dataProvider;
        }
        public function konstruktionAufgaben($params)
        {
            $query = Todo::find();
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
            $query->where(['department'=>'Konstruktion'])
                ->orderBy('due_date');

            $this->load($params);

            if (!$this->validate()) {
                // uncomment the following line if you do not want to return any records when validation fails
                // $query->where('0=1');
                return $dataProvider;
            }

            $query->andFilterWhere([
                'id' => $this->id,
                'due_date' => $this->due_date,
                'create_date' => $this->create_date,
                'change_date' => $this->change_date,
            ]);

            $query->andFilterWhere(['like', 'name', $this->name])
                #->andFilterWhere(['like', 'department', $this->department])
                ->andFilterWhere(['like', 'beauftragter', $this->beauftragter])
                ->andFilterWhere(['like', 'create_name', $this->create_name])
                ->andFilterWhere(['like', 'change_name', $this->change_name])
                ->andFilterWhere(['like', 'due_date_option', $this->due_date_option]);

            return $dataProvider;
        }
}
