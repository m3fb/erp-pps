<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProjektCheckliste;

/**
 * ProjektChecklisteSearch represents the model behind the search form of `app\models\M3ProjektCheckliste`.
 */
class ProjektChecklisteSearch extends ProjektCheckliste
{
	
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'Einheit', 'Lieferbedingungen', 'Verp_stellt_Kunde', 'Verp_zahl_Kunde', 'Termin_Konst_Dauer', 
				'Termin_WZBau_Dauer', 'Termin_RM_Dauer','Termin_Linie_Dauer', 'Termin_Vorrichtung_Dauer', 'Termin_int_Bem_Dauer', 
				'Termin_ext_Bem_Dauer', 'Termin_Pruefber_Dauer'], 'integer'],
				
            [['WerkzeugNr', 'erstellt_von', 'Erstelldatum', 'geaendert_von', 'Aenderungsdatum', 'Projektkoordinator',
				'Kunde', 'Artikelnummer', 'Profilbezeichnung', 'Vorgangsnummer', 'Zeichnungsnummer',
				'Index', 'geplanterExtruder', 'RM1_Art_Nr', 'RM2_Art_Nr', 'RM3_Art_Nr', 'CU1_Art_Nr',
				 'CU2_Art_Nr', 'CU_3_Art_Nr', 'RM1_Bezeichnung', 'RM2_Bezeichnung', 'RM3_Bezeichnung',
				 'CU1_Bezeichnung', 'CU2_Bezeichnung', 'CU3_Bezeichnung', 'Peripherie', 'Versandadresse_Muster',
				 'Kontaktperson', 'Mindestbestellmenge', 'Zahlungsbed_Werkzeug', 'sonst_Info_Bemusterung', 
				 'Verpackung_Muster', 'Verpackung_Serie', 'Termin_Konst_Ende', 'Termin_WZBau_Ende', 'Termin_RM_Ende','Termin_Linie_Ende',
				 'Termin_Einfahren_Ende','Termin_Einfahren_Dauer', 
				 'Termin_Vorrichtung_Ende', 'Termin_int_Bem_Ende', 'Termin_ext_Bem_Ende', 'Termin_Pruefber_Ende', 'sonst_Info_allg'], 'safe'],
				 
            [['geforderterMindestausstoss', 'kalkulierterAusschuss', 'RM1_Gewicht', 'RM2_Gewicht', 'RM3_Gewicht', 
				'RM_gesamt', 'CU_gesamt', 'Gewicht_gesamt', 'Muster_Kunde_Anz', 'Muster_Vermess_Anz', 
				'Muster_Verbleib_Anz', 'Muster_Kunde_Laenge', 'Muster_Vermess_Laenge', 'Muster_Verbleib_Laenge', 
				'erste_Serien_Menge'], 'number'],
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
        $query = ProjektCheckliste::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['Termin_Pruefber_Ende'=>SORT_ASC]]
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
            'geforderterMindestausstoss' => $this->geforderterMindestausstoss,
            'kalkulierterAusschuss' => $this->kalkulierterAusschuss,
            'Einheit' => $this->Einheit,
            'RM1_Gewicht' => $this->RM1_Gewicht,
            'RM2_Gewicht' => $this->RM2_Gewicht,
            'RM3_Gewicht' => $this->RM3_Gewicht,
            'RM_gesamt' => $this->RM_gesamt,
            'CU_gesamt' => $this->CU_gesamt,
            'Gewicht_gesamt' => $this->Gewicht_gesamt,
            'Lieferbedingungen' => $this->Lieferbedingungen,
            'Muster_Kunde_Anz' => $this->Muster_Kunde_Anz,
            'Muster_Vermess_Anz' => $this->Muster_Vermess_Anz,
            'Muster_Verbleib_Anz' => $this->Muster_Verbleib_Anz,
            'Muster_Kunde_Laenge' => $this->Muster_Kunde_Laenge,
            'Muster_Vermess_Laenge' => $this->Muster_Vermess_Laenge,
            'Muster_Verbleib_Laenge' => $this->Muster_Verbleib_Laenge,
            'Verp_stellt_Kunde' => $this->Verp_stellt_Kunde,
            'Verp_zahl_Kunde' => $this->Verp_zahl_Kunde,
            'erste_Serien_Menge' => $this->erste_Serien_Menge,
            'Termin_Konst_Ende' => $this->Termin_Konst_Ende,
            'Termin_Konst_Dauer' => $this->Termin_Konst_Dauer,
            'Termin_WZBau_Ende' => $this->Termin_WZBau_Ende,
            'Termin_WZBau_Dauer' => $this->Termin_WZBau_Dauer,
            'Termin_Einfahren_Ende' => $this->Termin_Einfahren_Ende,
            'Termin_Einfahren_Dauer' => $this->Termin_Einfahren_Dauer,
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

        $query->andFilterWhere(['like', 'WerkzeugNr', $this->WerkzeugNr])
            ->andFilterWhere(['like', 'erstellt_von', $this->erstellt_von])
            ->andFilterWhere(['like', 'geaendert_von', $this->geaendert_von])
            ->andFilterWhere(['like', 'Kunde', $this->Kunde])
            ->andFilterWhere(['like', 'Artikelnummer', $this->Artikelnummer])
            ->andFilterWhere(['like', 'Profilbezeichnung', $this->Profilbezeichnung])
            ->andFilterWhere(['like', 'Vorgangsnummer', $this->Vorgangsnummer])
            ->andFilterWhere(['like', 'Zeichnungsnummer', $this->Zeichnungsnummer])
            ->andFilterWhere(['like', 'Index', $this->Index])
            ->andFilterWhere(['like', 'geplanterExtruder', $this->geplanterExtruder])
            ->andFilterWhere(['like', 'RM1_Art_Nr', $this->RM1_Art_Nr])
            ->andFilterWhere(['like', 'RM2_Art_Nr', $this->RM2_Art_Nr])
            ->andFilterWhere(['like', 'RM3_Art_Nr', $this->RM3_Art_Nr])
            ->andFilterWhere(['like', 'CU1_Art_Nr', $this->CU1_Art_Nr])
            ->andFilterWhere(['like', 'CU2_Art_Nr', $this->CU2_Art_Nr])
            ->andFilterWhere(['like', 'CU_3_Art_Nr', $this->CU_3_Art_Nr])
            ->andFilterWhere(['like', 'RM1_Bezeichnung', $this->RM1_Bezeichnung])
            ->andFilterWhere(['like', 'RM2_Bezeichnung', $this->RM2_Bezeichnung])
            ->andFilterWhere(['like', 'RM3_Bezeichnung', $this->RM3_Bezeichnung])
            ->andFilterWhere(['like', 'CU1_Bezeichnung', $this->CU1_Bezeichnung])
            ->andFilterWhere(['like', 'CU2_Bezeichnung', $this->CU2_Bezeichnung])
            ->andFilterWhere(['like', 'CU3_Bezeichnung', $this->CU3_Bezeichnung])
            ->andFilterWhere(['like', 'Peripherie', $this->Peripherie])
            ->andFilterWhere(['like', 'Versandadresse_Muster', $this->Versandadresse_Muster])
            ->andFilterWhere(['like', 'Kontaktperson', $this->Kontaktperson])
            ->andFilterWhere(['like', 'Mindestbestellmenge', $this->Mindestbestellmenge])
            ->andFilterWhere(['like', 'Zahlungsbed_Werkzeug', $this->Zahlungsbed_Werkzeug])
            ->andFilterWhere(['like', 'sonst_Info_Bemusterung', $this->sonst_Info_Bemusterung])
            ->andFilterWhere(['like', 'Verpackung_Muster', $this->Verpackung_Muster])
            ->andFilterWhere(['like', 'Verpackung_Serie', $this->Verpackung_Serie])
            ->andFilterWhere(['like', 'sonst_Info_allg', $this->sonst_Info_allg]);

        return $dataProvider;
    }
}
