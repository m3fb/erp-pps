<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Urlaub;

/**
 * UrlaubSearch represents the model behind the search form about `app\models\Urlaub`.
 */
class UrlaubSearch extends Urlaub
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['LBNO', 'OPNO', 'OPOPNO', 'ORNO', 'OUT', 'ADCCOUNT', 'ADCSTAT', 'APARTS', 'ARCHIVE', 'ATE', 'ATP', 'ATR', 'BPARTS', 'BPARTS2', 'CALTYP', 'ERRNUM', 'EXSTAT', 'FKLBNO', 'FNPK', 'GPARTS', 'INPARTSDBL', 'ISINTERNAL', 'MSGID', 'MTIME0', 'MTIME1', 'MTIME2', 'MTIME3', 'OPMULTIMESSAGEGROUP', 'PERSNO', 'STATUS', 'WPLACE', 'MATCOST', 'MANDANTNO'], 'number'],
            [['NAME', 'ORNAME', 'ADCMESS', 'ADCWORK', 'DESCR', 'MSINFO', 'MSTIME', 'PERSNAME', 'TERMINAL', 'CNAME', 'CHNAME', 'CDATE', 'CHDATE', 'TSTAMP'], 'safe'],
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
        $query = Urlaub::find();

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
            'OPNO' => $this->OPNO,
            'OPOPNO' => $this->OPOPNO,
            'ORNO' => $this->ORNO,
            'OUT' => $this->OUT,
            'ADCCOUNT' => $this->ADCCOUNT,
            'ADCSTAT' => $this->ADCSTAT,
            'APARTS' => $this->APARTS,
            'ARCHIVE' => $this->ARCHIVE,
            'ATE' => $this->ATE,
            'ATP' => $this->ATP,
            'ATR' => $this->ATR,
            'BPARTS' => $this->BPARTS,
            'BPARTS2' => $this->BPARTS2,
            'CALTYP' => $this->CALTYP,
            'ERRNUM' => $this->ERRNUM,
            'EXSTAT' => $this->EXSTAT,
            'FKLBNO' => $this->FKLBNO,
            'FNPK' => $this->FNPK,
            'GPARTS' => $this->GPARTS,
            'INPARTSDBL' => $this->INPARTSDBL,
            'ISINTERNAL' => $this->ISINTERNAL,
            'MSGID' => $this->MSGID,
            'MSTIME' => $this->MSTIME,
            'MTIME0' => $this->MTIME0,
            'MTIME1' => $this->MTIME1,
            'MTIME2' => $this->MTIME2,
            'MTIME3' => $this->MTIME3,
            'OPMULTIMESSAGEGROUP' => $this->OPMULTIMESSAGEGROUP,
            'PERSNO' => $this->PERSNO,
            'STATUS' => $this->STATUS,
            'WPLACE' => $this->WPLACE,
            'MATCOST' => $this->MATCOST,
            'CDATE' => $this->CDATE,
            'CHDATE' => $this->CHDATE,
            'MANDANTNO' => $this->MANDANTNO,
            'TSTAMP' => $this->TSTAMP,
        ]);

        $query->andFilterWhere(['like', 'NAME', $this->NAME])
            ->andFilterWhere(['like', 'ORNAME', $this->ORNAME])
            ->andFilterWhere(['like', 'ADCMESS', $this->ADCMESS])
            ->andFilterWhere(['like', 'ADCWORK', $this->ADCWORK])
            ->andFilterWhere(['like', 'DESCR', $this->DESCR])
            ->andFilterWhere(['like', 'MSINFO', $this->MSINFO])
            ->andFilterWhere(['like', 'PERSNAME', $this->PERSNAME])
            ->andFilterWhere(['like', 'TERMINAL', $this->TERMINAL])
            ->andFilterWhere(['like', 'CNAME', $this->CNAME])
            ->andFilterWhere(['like', 'CHNAME', $this->CHNAME]);

        return $dataProvider;
    }
}
