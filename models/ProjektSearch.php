<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Projekt;

/**
 * ProjektChecklisteSearch represents the model behind the search form of `app\models\M3ProjektCheckliste`.
 */
class ProjektSearch extends Projekt
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'Termin_Konst_Dauer', 'Termin_WZBau_Dauer', 'Termin_RM_Dauer', 'Termin_Vorrichtung_Dauer', 'Termin_int_Bem_Dauer', 'Termin_ext_Bem_Dauer', 'Termin_Pruefber_Dauer'], 'integer'],
            
            [['Projekt','Kunde', 'erstellt_von', 'Erstelldatum', 'geaendert_von', 'Aenderungsdatum',  'Vorgangsnummer', 
				 'Termin_Konst_Ende', 'Termin_WZBau_Ende','Termin_RM_Ende', 'Termin_Vorrichtung_Ende', 'Termin_int_Bem_Ende',
				  'Termin_ext_Bem_Ende', 'Termin_Pruefber_Ende', 'sonst_Info_allg'], 'safe'],
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
        $query = Projekt::find();

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
            'Erstelldatum' => $this->Erstelldatum,
            'Aenderungsdatum' => $this->Aenderungsdatum,
            'Termin_Konst_Ende' => $this->Termin_Konst_Ende,
            'Termin_Konst_Dauer' => $this->Termin_Konst_Dauer,
            'Termin_WZBau_Ende' => $this->Termin_WZBau_Ende,
            'Termin_WZBau_Dauer' => $this->Termin_WZBau_Dauer,
            'Termin_RM_Ende' => $this->Termin_RM_Ende,
            'Termin_RM_Dauer' => $this->Termin_RM_Dauer,
            'Termin_Vorrichtung_Ende' => $this->Termin_Vorrichtung_Ende,
            'Termin_Vorrichtung_Dauer' => $this->Termin_Vorrichtung_Dauer,
            'Termin_int_Bem_Ende' => $this->Termin_int_Bem_Ende,
            'Termin_int_Bem_Dauer' => $this->Termin_int_Bem_Dauer,
            'Termin_ext_Bem_Ende' => $this->Termin_ext_Bem_Ende,
            'Termin_ext_Bem_Dauer' => $this->Termin_ext_Bem_Dauer,
            'Termin_Pruefber_Ende' => $this->Termin_Pruefber_Ende,
            'Termin_Pruefber_Dauer' => $this->Termin_Pruefber_Dauer,
        ]);

        $query->andFilterWhere(['like', 'Projekt', $this->Projekt])
            ->andFilterWhere(['like', 'erstellt_von', $this->erstellt_von])
            ->andFilterWhere(['like', 'geaendert_von', $this->geaendert_von])
            ->andFilterWhere(['like', 'Kunde', $this->Kunde])
            ->andFilterWhere(['like', 'Vorgangsnummer', $this->Vorgangsnummer])
            ->andFilterWhere(['like', 'sonst_Info_allg', $this->sonst_Info_allg]);

        return $dataProvider;
    }
}
