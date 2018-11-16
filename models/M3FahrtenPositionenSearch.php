<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\M3FahrtenPositionen;

/**
 * M3FahrtenPositionenSearch represents the model behind the search form of `app\models\M3FahrtenPositionen`.
 */
class M3FahrtenPositionenSearch extends M3FahrtenPositionen
{
    /**
     * @inheritdoc
     */
    public $FahrtdatumMonat;
    public $FahrdatumJahr;
    public function rules()
    {
        return [
            [['ID', 'Status', 'BelegID', 'von_PLZ', 'nach_PLZ', 'Typ'], 'integer'],
            [['erstellt_von', 'Erstelldatum', 'geaendert_von', 'Aenderungsdatum','Fahrtdatum', 'FahrtdatumMonat','FahrdatumJahr',
            'von_Adresse1', 'von_Adresse2', 'von_Strasse', 'von_Ort', 'nach_Adresse1', 'nach_Adresse2',
            'nach_Strasse', 'nach_Ort', 'username'], 'safe'],
            [['Entfernung', 'Verguetung'], 'number'],
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
        $query = M3FahrtenPositionen::find();

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
            'Status' => $this->Status,
            'BelegID' => $this->BelegID,
            'Erstelldatum' => $this->Erstelldatum,
            'Aenderungsdatum' => $this->Aenderungsdatum,
            #'Fahrtdatum' => $this->Fahrtdatum,
            'von_PLZ' => $this->von_PLZ,
            'nach_PLZ' => $this->nach_PLZ,
            'Entfernung' => $this->Entfernung,
            'Verguetung' => $this->Verguetung,
            'Typ' => $this->Typ,
        ]);

        $query->andFilterWhere(['like', 'erstellt_von', $this->erstellt_von])
            ->andFilterWhere(['like', 'geaendert_von', $this->geaendert_von])
            ->andFilterWhere(['like', 'von_Adresse1', $this->von_Adresse1])
            ->andFilterWhere(['like', 'von_Adresse2', $this->von_Adresse2])
            ->andFilterWhere(['like', 'von_Strasse', $this->von_Strasse])
            ->andFilterWhere(['like', 'von_Ort', $this->von_Ort])
            ->andFilterWhere(['like', 'nach_Adresse1', $this->nach_Adresse1])
            ->andFilterWhere(['like', 'nach_Adresse2', $this->nach_Adresse2])
            ->andFilterWhere(['like', 'nach_Strasse', $this->nach_Strasse])
            ->andFilterWhere(['like', 'nach_Ort', $this->nach_Ort])
            ->andFilterWhere(['like', 'username', $this->username]);

        $query->andFilterWhere(['MONTH(Fahrtdatum)' => $this->FahrtdatumMonat]);

        return $dataProvider;
    }
}
