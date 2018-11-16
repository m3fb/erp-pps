<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cucomp;

/**
 * CucompSearch represents the model behind the search form of `app\models\Cucomp`.
 */
class CucompSearch extends Cucomp
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CONO', 'CLEARANCE', 'COTYPNO', 'CREDITLIMIT', 'FKPLNO', 'FKPLNO1', 'FKPLNO2', 'FKPLNO3', 'NUMCOPIESINVOICE', 'RABATT', 'SAMMELRECH', 'STATUS', 'TYP0', 'TYP1', 'TYP2', 'UMSATZ0', 'UMSATZ1', 'UMSATZ2', 'UMSATZ3', 'UMSATZ4', 'UMSATZ5', 'UMSATZ6', 'UMSATZ7', 'UMSATZ8', 'UMSATZ9', 'UMSATZ10', 'UMSATZ11', 'UMSATZ12', 'VERTID', 'VPROV', 'VRABATT', 'ZAHLUNGT', 'MANDANTNO', 'EXTWORKRES'], 'number'],
            [['NAME', 'ADDITION', 'ADDITION2', 'BITMAP', 'BOXCODE', 'BOXNO', 'CNTRYSIGN', 'CUSTNO', 'CUSTOMERINFO', 'FAX', 'INFO1', 'INFO2', 'LANCNTRY', 'LIEFERB', 'MODEM', 'PHONE', 'PHONE1', 'PHONE2', 'PHONE3', 'PHONE4', 'PHONE5', 'PHONE6', 'PLACE', 'PLACE2', 'POSTCODE', 'POSTCODE2', 'SALESMAN', 'SECPHONE', 'STATE', 'STREET', 'STREET2', 'SUPPLIER', 'UDATUM', 'VATIDNO', 'VERTRNAME', 'ZAHLUNGB', 'CNAME', 'CHNAME', 'CDATE', 'CHDATE', 'EXCHANGELMT', 'EXCHANGEPHOTOLMT'], 'safe'],
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
        $query = Cucomp::find();

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
            'CONO' => $this->CONO,
            'CLEARANCE' => $this->CLEARANCE,
            'COTYPNO' => $this->COTYPNO,
            'CREDITLIMIT' => $this->CREDITLIMIT,
            'FKPLNO' => $this->FKPLNO,
            'FKPLNO1' => $this->FKPLNO1,
            'FKPLNO2' => $this->FKPLNO2,
            'FKPLNO3' => $this->FKPLNO3,
            'NUMCOPIESINVOICE' => $this->NUMCOPIESINVOICE,
            'RABATT' => $this->RABATT,
            'SAMMELRECH' => $this->SAMMELRECH,
            'STATUS' => $this->STATUS,
            'TYP0' => $this->TYP0,
            'TYP1' => $this->TYP1,
            'TYP2' => $this->TYP2,
            'UDATUM' => $this->UDATUM,
            'UMSATZ0' => $this->UMSATZ0,
            'UMSATZ1' => $this->UMSATZ1,
            'UMSATZ2' => $this->UMSATZ2,
            'UMSATZ3' => $this->UMSATZ3,
            'UMSATZ4' => $this->UMSATZ4,
            'UMSATZ5' => $this->UMSATZ5,
            'UMSATZ6' => $this->UMSATZ6,
            'UMSATZ7' => $this->UMSATZ7,
            'UMSATZ8' => $this->UMSATZ8,
            'UMSATZ9' => $this->UMSATZ9,
            'UMSATZ10' => $this->UMSATZ10,
            'UMSATZ11' => $this->UMSATZ11,
            'UMSATZ12' => $this->UMSATZ12,
            'VERTID' => $this->VERTID,
            'VPROV' => $this->VPROV,
            'VRABATT' => $this->VRABATT,
            'ZAHLUNGT' => $this->ZAHLUNGT,
            'CDATE' => $this->CDATE,
            'CHDATE' => $this->CHDATE,
            'MANDANTNO' => $this->MANDANTNO,
            'EXCHANGELMT' => $this->EXCHANGELMT,
            'EXTWORKRES' => $this->EXTWORKRES,
            'EXCHANGEPHOTOLMT' => $this->EXCHANGEPHOTOLMT,
        ]);

        $query->andFilterWhere(['like', 'NAME', $this->NAME])
            ->andFilterWhere(['like', 'ADDITION', $this->ADDITION])
            ->andFilterWhere(['like', 'ADDITION2', $this->ADDITION2])
            ->andFilterWhere(['like', 'BITMAP', $this->BITMAP])
            ->andFilterWhere(['like', 'BOXCODE', $this->BOXCODE])
            ->andFilterWhere(['like', 'BOXNO', $this->BOXNO])
            ->andFilterWhere(['like', 'CNTRYSIGN', $this->CNTRYSIGN])
            ->andFilterWhere(['like', 'CUSTNO', $this->CUSTNO])
            ->andFilterWhere(['like', 'CUSTOMERINFO', $this->CUSTOMERINFO])
            ->andFilterWhere(['like', 'FAX', $this->FAX])
            ->andFilterWhere(['like', 'INFO1', $this->INFO1])
            ->andFilterWhere(['like', 'INFO2', $this->INFO2])
            ->andFilterWhere(['like', 'LANCNTRY', $this->LANCNTRY])
            ->andFilterWhere(['like', 'LIEFERB', $this->LIEFERB])
            ->andFilterWhere(['like', 'MODEM', $this->MODEM])
            ->andFilterWhere(['like', 'PHONE', $this->PHONE])
            ->andFilterWhere(['like', 'PHONE1', $this->PHONE1])
            ->andFilterWhere(['like', 'PHONE2', $this->PHONE2])
            ->andFilterWhere(['like', 'PHONE3', $this->PHONE3])
            ->andFilterWhere(['like', 'PHONE4', $this->PHONE4])
            ->andFilterWhere(['like', 'PHONE5', $this->PHONE5])
            ->andFilterWhere(['like', 'PHONE6', $this->PHONE6])
            ->andFilterWhere(['like', 'PLACE', $this->PLACE])
            ->andFilterWhere(['like', 'PLACE2', $this->PLACE2])
            ->andFilterWhere(['like', 'POSTCODE', $this->POSTCODE])
            ->andFilterWhere(['like', 'POSTCODE2', $this->POSTCODE2])
            ->andFilterWhere(['like', 'SALESMAN', $this->SALESMAN])
            ->andFilterWhere(['like', 'SECPHONE', $this->SECPHONE])
            ->andFilterWhere(['like', 'STATE', $this->STATE])
            ->andFilterWhere(['like', 'STREET', $this->STREET])
            ->andFilterWhere(['like', 'STREET2', $this->STREET2])
            ->andFilterWhere(['like', 'SUPPLIER', $this->SUPPLIER])
            ->andFilterWhere(['like', 'VATIDNO', $this->VATIDNO])
            ->andFilterWhere(['like', 'VERTRNAME', $this->VERTRNAME])
            ->andFilterWhere(['like', 'ZAHLUNGB', $this->ZAHLUNGB])
            ->andFilterWhere(['like', 'CNAME', $this->CNAME])
            ->andFilterWhere(['like', 'CHNAME', $this->CHNAME]);

        return $dataProvider;
    }
}
