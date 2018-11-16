<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\M3Urlaubsplanung;

/**
 * M3UrlaubsplanungSearch represents the model behind the search form of `app\models\M3Urlaubsplanung`.
 */
class M3UrlaubsplanungSearch extends M3Urlaubsplanung
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['LBNO', 'BEST'], 'integer'],
            [['MSTIME', 'BESCHREIBUNG', 'PERSNAME', 'CNAME', 'CHNAME', 'CDATE', 'CHDATE'], 'safe'],
            [['GESAMT_TAGE', 'TAGE', 'STUNDEN', 'PERSNO', 'WORKID', 'STATUS'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
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
    public function search($params,$workid,$status)
    {
        ($status==0)? $endstatus= 810:$endstatus = $status + 1;
        $enddatum = date("t.m.Y"); // letzer Tag des Vormonats
        $startdatum = date('01.m.Y',strtotime(date('t.m.Y').' -1 year'));

        $query = M3Urlaubsplanung::find();
        $query->where(['WORKID'=>$workid])
              #->andWhere(['between','MSTIME',$startdatum,$enddatum])
              ->andWhere(['>','MSTIME',$startdatum])
              ->andWhere(['between','STATUS',$status,$endstatus])
              ->orderBy('LBNO');

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
            'LBNO' => $this->LBNO,
            'MSTIME' => $this->MSTIME,
            'GESAMT_TAGE' => $this->GESAMT_TAGE,
            'TAGE' => $this->TAGE,
            'STUNDEN' => $this->STUNDEN,
            'PERSNO' => $this->PERSNO,
            'WORKID' => $this->WORKID,
            'STATUS' => $this->STATUS,
            'CDATE' => $this->CDATE,
            'CHDATE' => $this->CHDATE,
            'BEST' => $this->BEST,
        ]);

        $query->andFilterWhere(['like', 'BESCHREIBUNG', $this->BESCHREIBUNG])
            ->andFilterWhere(['like', 'PERSNAME', $this->PERSNAME])
            ->andFilterWhere(['like', 'CNAME', $this->CNAME])
            ->andFilterWhere(['like', 'CHNAME', $this->CHNAME]);

        return $dataProvider;
    }
}
