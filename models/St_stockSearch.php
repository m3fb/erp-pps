<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use app\models\St_stock;
use app\models\St_place;
use app\models\Fagdetail;

/**
 * St_stockSearch represents the model behind the search form of `app\models\St_stock`.
 */
class St_stockSearch extends St_stock
{
    public $COMMNO;
    public $ARTDESC;
    public $ARTNAME;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NO', 'ARTNO', 'MENGE', 'OPNO', 'WAREHOUSE', 'MANDANTNO', 'REF_TMP_ISQUARANTINESTORE'], 'number'],
            [['INCDATE', 'PLACE', 'INFO1', 'INFO2', 'INFO3', 'CNAME', 'CHNAME', 'CDATE', 'CHDATE', 'INFO4', 'INFO5', 'INFO6','ARTDESC','COMMNO','ARTNAME'], 'safe'],
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
        $query = St_stock::find();
        $query = (new Query())
          ->select(['ST_STOCK.PLACE', 'ST_STOCK.MENGE', 'ST_STOCK.INFO1',
                    'PA_ARTPOS.ARTDESC', 'PA_ARTPOS.ARTNAME',
                    'OR_ORDER.COMMNO',
                  'LB_DC.MSTIME'])
          ->from('ST_STOCK')
          ->leftJoin('PA_ARTPOS', 'PA_ARTPOS.ARTNO = ST_STOCK.ARTNO')
          ->leftJoin('OR_ORDER', 'OR_ORDER.NAME = PA_ARTPOS.FNUM')
          ->leftJoin('LB_DC', 'CAST(LB_DC.LBNO as NVARCHAR(10)) = ST_STOCK.INFO1')
          ->orderBy([ 'PLACE' => SORT_ASC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
             //$query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'NO' => $this->NO,
            'ARTNO' => $this->ARTNO,
            'INCDATE' => $this->INCDATE,
            'MENGE' => $this->MENGE,
            'OPNO' => $this->OPNO,
            'WAREHOUSE' => $this->WAREHOUSE,
            'CDATE' => $this->CDATE,
            'CHDATE' => $this->CHDATE,
            'MANDANTNO' => $this->MANDANTNO,
            'REF_TMP_ISQUARANTINESTORE' => $this->REF_TMP_ISQUARANTINESTORE,
        ]);

        $query->andFilterWhere(['like', 'PLACE', $this->PLACE])
            ->andFilterWhere(['like', 'ST_STOCK.INFO1', $this->INFO1])
            ->andFilterWhere(['like', 'INFO2', $this->INFO2])
            ->andFilterWhere(['like', 'INFO3', $this->INFO3])
            ->andFilterWhere(['like', 'CNAME', $this->CNAME])
            ->andFilterWhere(['like', 'CHNAME', $this->CHNAME])
            ->andFilterWhere(['like', 'INFO4', $this->INFO4])
            ->andFilterWhere(['like', 'INFO5', $this->INFO5])
            ->andFilterWhere(['like', 'INFO6', $this->INFO6])
            ->andFilterWhere(['like', 'PA_ARTPOS.ARTDESC', $this->ARTDESC])
            ->andFilterWhere(['like', 'PA_ARTPOS.ARTNAME', $this->ARTNAME])
            ->andFilterWhere(['like', 'OR_ORDER.COMMNO', $this->COMMNO]);
        return $dataProvider;
    }

    public function searchCustomerlist($partlist)
    {
        $query = St_stock::find();
        $subQuery1 = Fagdetail::find()->select(['FKNO','VAL02'])->where(['TYP'=>5]); //Variante in sonstige Infos suchen
        $subQuery2 = Pa_packaging::find()->select(['FKNO','FILLQUANTITY'])->distinct(); //Packeinheit in Packaging-Tabelle suchen
        $query = (new Query())
          ->select(['ST_STOCK.PLACE', 'ST_STOCK.MENGE', 'ST_STOCK.INFO1',
                    'PA_ARTPOS.ARTDESC', 'PA_ARTPOS.ARTNAME','PA_ARTPOS.MDIM1 as length',
                    'PA_ARTPOS.ALAGER2', 'PA_ARTPOS.ALAGER3','PA_ARTPOS.MASSEINH','PA_ARTPOS.PARTNO',
                    'OR_ORDER.COMMNO',
                  'LB_DC.MSTIME',
                  'T.VAL02','P.FILLQUANTITY'])
          ->from('ST_STOCK')
          ->leftJoin('PA_ARTPOS', 'PA_ARTPOS.ARTNO = ST_STOCK.ARTNO')
          ->leftJoin('PA_PACKAGING', 'PA_PACKAGING.FKNO = ST_STOCK.ARTNO')
          ->leftJoin('OR_ORDER', 'OR_ORDER.NAME = PA_ARTPOS.FNUM')
          ->leftJoin('LB_DC', 'CAST(LB_DC.LBNO as NVARCHAR(10)) = ST_STOCK.INFO1')
          ->leftJoin(['T' => $subQuery1], 'T.FKNO = ST_STOCK.ARTNO')
          ->leftJoin(['P' => $subQuery2], 'P.FKNO = ST_STOCK.ARTNO')
          ->where(['ST_STOCK.ARTNO'=>$partlist])
          ->andWhere(['not',['ST_STOCK.REF_TMP_ISQUARANTINESTORE'=>1]])
          ->orderBy(['VAL02' => SORT_ASC, 'ARTDESC' => SORT_ASC])->distinct();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        #$this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
             //$query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }
}
