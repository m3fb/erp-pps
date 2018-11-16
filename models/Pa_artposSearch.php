<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pa_artpos;

/**
 * Pa_artposSearch represents the model behind the search form of `app\models\Pa_artpos`.
 */
class Pa_artposSearch extends Pa_artpos
{
    //add public attrributes
    public $toolNo;
    public $grpNo;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ARTNO', 'GRPNO', 'FIND', 'FTYP', 'ARCHIVED', 'DISCONTINUED', 'ADDRNO0', 'ADDRNO1', 'ADDRNO2', 'ADDRNO3', 'ADDRNO4', 'ADDRNO5', 'ALAGER0', 'ALAGER1', 'ALAGER2', 'ALAGER3', 'ALAGER4', 'ALAGER5', 'AMENGE1', 'AMENGE2', 'AMENGE3', 'APLACEI', 'APREIS1', 'APREIS2', 'APREIS3', 'ARTADDR1', 'ARTADDR2', 'ARTADDR3', 'ARTPRT0', 'ARTPRT1', 'ARTPRT2', 'AUTOLEAVE', 'AUTORESERV', 'AVERAGEPRICE', 'BESTM0', 'BESTM1', 'BESTM2', 'CHARGE', 'DISCOUNT1', 'DISCOUNT2', 'DISCOUNT3', 'DISCOUNT4', 'DISCOUNT5', 'DISCOUNT6', 'DISDEMANDALL', 'DISDEMANDALLLEFT', 'DISDEMANDDIFF', 'DISDEMANDPACTIVE', 'DISDEMANDPACTIVELEFT', 'DISDEMANDPPASSIVE', 'DISDEMANDPPASSIVELEFT', 'DISPRODUCING', 'EINHEIT', 'EINHIN', 'EINHOUT', 'EINHST', 'EINKAUF0', 'EINKAUF1', 'EINKAUF2', 'EINKAUF3', 'EINKAUF4', 'EINKAUF5', 'EKPERC', 'EKPREIS', 'EPREIS0', 'EPREIS1', 'EPREIS2', 'EPREIS3', 'EPREIS4', 'EPREIS5', 'EPROZ0', 'EPROZ1', 'EPROZ2', 'EPROZ3', 'EPROZ4', 'EPROZ5', 'EXCLUDEINDISPO', 'FAKTOR1', 'FAKTOR2', 'FAKTOR3', 'ISCASTING', 'MATTYP', 'MCPERC', 'MCREAL', 'MDIM1', 'MDIM2', 'MDIM3', 'MDIM4', 'MENGE', 'MENGE1', 'MENGE2', 'MENGE3', 'MENGE4', 'MENGE5', 'MENGE6', 'MIDENT1', 'MIDENT2', 'MIDENT3', 'MIDENT4', 'MIDENT5', 'MIDENT6', 'MIDENT7', 'MIDENT8', 'MINBE3', 'MINBE4', 'MINBE5', 'MINPRICE', 'MWEIG1', 'MWEIG2', 'MWEIG3', 'NETPRICE1', 'NETPRICE2', 'NETPRICE3', 'NETPRICE4', 'NETPRICE5', 'NETPRICE6', 'ORDERED', 'PADDITION1', 'PADDITION2', 'PADDITION3', 'PADDITION4', 'PADDITION5', 'PADDITION6', 'PLATE', 'PPREIS', 'PREIS', 'PREIS1', 'PREIS2', 'PREIS3', 'PREIS4', 'PREIS5', 'PREIS6', 'PROVREADY', 'RABATT', 'RABATTREADY', 'SUPPLIED', 'SURFACE', 'VERTID', 'VKPERC', 'VKPREIS', 'VPE1', 'VPE2', 'VPE3', 'VPREIS0', 'VPREIS1', 'VPREIS2', 'VPREIS3', 'VPREIS4', 'VPREIS5', 'VPROV', 'VPROZ0', 'VPROZ1', 'VPROZ2', 'VPROZ3', 'VPROZ4', 'VPROZ5', 'VRABATT', 'MANDANTNO', 'ACCOUNT0', 'ACCOUNT1', 'ACCOUNT2', 'ACCOUNT3', 'DISCOUNT7', 'DISCOUNT8', 'DISCOUNT9', 'DISCOUNT10', 'DISCOUNT11', 'DISCOUNT12', 'DISCOUNT13', 'DISCOUNT14', 'DISCOUNT15', 'MENGE7', 'MENGE8', 'MENGE9', 'MENGE10', 'MENGE11', 'MENGE12', 'MENGE13', 'MENGE14', 'NETPRICE7', 'NETPRICE8', 'NETPRICE9', 'NETPRICE10', 'NETPRICE11', 'NETPRICE12', 'NETPRICE13', 'NETPRICE14', 'NETPRICE15', 'PADDITION7', 'PADDITION8', 'PADDITION9', 'PADDITION10', 'PADDITION11', 'PADDITION12', 'PADDITION13', 'PADDITION14', 'PADDITION15', 'PREIS7', 'PREIS8', 'PREIS9', 'PREIS10', 'PREIS11', 'PREIS12', 'PREIS13', 'PREIS14'], 'number'],
            [['ARTDESC', 'ARTNAME', 'FNUM', 'ADATUM1', 'ADATUM2', 'ADATUM3', 'AEINH1', 'AEINH2', 'AEINH3', 'ALAGERN', 'ARTDOC0', 'ARTDOC1', 'ARTDOC2', 'ARTINF1', 'BITMAPA', 'BITMAPB', 'DINNO1', 'DINNO2', 'DISCALCDATE', 'DISFIRSTDATEMINUS', 'DRAWNO', 'MASSEINH', 'MFAKT', 'PARTNO', 'SERIALNUMBERKEY', 'VERTRNAME', 'CNAME', 'CHNAME', 'CDATE', 'CHDATE','toolNo','grpNo'], 'safe'],
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
        $query = Pa_artpos::find();

        $query->joinWith(['grpNo', 'toolNo']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['toolNo'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['OR_ORDER.COMMNO' => SORT_ASC],
            'desc' => ['OR_ORDER.COMMNO' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['grpNo'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['PA_ARTGRP.GRPNO' => SORT_ASC],
            'desc' => ['PA_ARTGRP.GRPNO' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ARTNO' => $this->ARTNO,
            'PA_ARTPOS.GRPNO' => $this->GRPNO,
            'FIND' => $this->FIND,
            'FTYP' => $this->FTYP,
            'ARCHIVED' => $this->ARCHIVED,
            'DISCONTINUED' => $this->DISCONTINUED,
            'ADATUM1' => $this->ADATUM1,
            'ADATUM2' => $this->ADATUM2,
            'ADATUM3' => $this->ADATUM3,
            'ADDRNO0' => $this->ADDRNO0,
            'ADDRNO1' => $this->ADDRNO1,
            'ADDRNO2' => $this->ADDRNO2,
            'ADDRNO3' => $this->ADDRNO3,
            'ADDRNO4' => $this->ADDRNO4,
            'ADDRNO5' => $this->ADDRNO5,
            'ALAGER0' => $this->ALAGER0,
            'ALAGER1' => $this->ALAGER1,
            'ALAGER2' => $this->ALAGER2,
            'ALAGER3' => $this->ALAGER3,
            'ALAGER4' => $this->ALAGER4,
            'ALAGER5' => $this->ALAGER5,
            'AMENGE1' => $this->AMENGE1,
            'AMENGE2' => $this->AMENGE2,
            'AMENGE3' => $this->AMENGE3,
            'APLACEI' => $this->APLACEI,
            'APREIS1' => $this->APREIS1,
            'APREIS2' => $this->APREIS2,
            'APREIS3' => $this->APREIS3,
            'ARTADDR1' => $this->ARTADDR1,
            'ARTADDR2' => $this->ARTADDR2,
            'ARTADDR3' => $this->ARTADDR3,
            'ARTPRT0' => $this->ARTPRT0,
            'ARTPRT1' => $this->ARTPRT1,
            'ARTPRT2' => $this->ARTPRT2,
            'AUTOLEAVE' => $this->AUTOLEAVE,
            'AUTORESERV' => $this->AUTORESERV,
            'AVERAGEPRICE' => $this->AVERAGEPRICE,
            'BESTM0' => $this->BESTM0,
            'BESTM1' => $this->BESTM1,
            'BESTM2' => $this->BESTM2,
            'CHARGE' => $this->CHARGE,
            'DISCALCDATE' => $this->DISCALCDATE,
            'DISCOUNT1' => $this->DISCOUNT1,
            'DISCOUNT2' => $this->DISCOUNT2,
            'DISCOUNT3' => $this->DISCOUNT3,
            'DISCOUNT4' => $this->DISCOUNT4,
            'DISCOUNT5' => $this->DISCOUNT5,
            'DISCOUNT6' => $this->DISCOUNT6,
            'DISDEMANDALL' => $this->DISDEMANDALL,
            'DISDEMANDALLLEFT' => $this->DISDEMANDALLLEFT,
            'DISDEMANDDIFF' => $this->DISDEMANDDIFF,
            'DISDEMANDPACTIVE' => $this->DISDEMANDPACTIVE,
            'DISDEMANDPACTIVELEFT' => $this->DISDEMANDPACTIVELEFT,
            'DISDEMANDPPASSIVE' => $this->DISDEMANDPPASSIVE,
            'DISDEMANDPPASSIVELEFT' => $this->DISDEMANDPPASSIVELEFT,
            'DISFIRSTDATEMINUS' => $this->DISFIRSTDATEMINUS,
            'DISPRODUCING' => $this->DISPRODUCING,
            'EINHEIT' => $this->EINHEIT,
            'EINHIN' => $this->EINHIN,
            'EINHOUT' => $this->EINHOUT,
            'EINHST' => $this->EINHST,
            'EINKAUF0' => $this->EINKAUF0,
            'EINKAUF1' => $this->EINKAUF1,
            'EINKAUF2' => $this->EINKAUF2,
            'EINKAUF3' => $this->EINKAUF3,
            'EINKAUF4' => $this->EINKAUF4,
            'EINKAUF5' => $this->EINKAUF5,
            'EKPERC' => $this->EKPERC,
            'EKPREIS' => $this->EKPREIS,
            'EPREIS0' => $this->EPREIS0,
            'EPREIS1' => $this->EPREIS1,
            'EPREIS2' => $this->EPREIS2,
            'EPREIS3' => $this->EPREIS3,
            'EPREIS4' => $this->EPREIS4,
            'EPREIS5' => $this->EPREIS5,
            'EPROZ0' => $this->EPROZ0,
            'EPROZ1' => $this->EPROZ1,
            'EPROZ2' => $this->EPROZ2,
            'EPROZ3' => $this->EPROZ3,
            'EPROZ4' => $this->EPROZ4,
            'EPROZ5' => $this->EPROZ5,
            'EXCLUDEINDISPO' => $this->EXCLUDEINDISPO,
            'FAKTOR1' => $this->FAKTOR1,
            'FAKTOR2' => $this->FAKTOR2,
            'FAKTOR3' => $this->FAKTOR3,
            'ISCASTING' => $this->ISCASTING,
            'MATTYP' => $this->MATTYP,
            'MCPERC' => $this->MCPERC,
            'MCREAL' => $this->MCREAL,
            'MDIM1' => $this->MDIM1,
            'MDIM2' => $this->MDIM2,
            'MDIM3' => $this->MDIM3,
            'MDIM4' => $this->MDIM4,
            'MENGE' => $this->MENGE,
            'MENGE1' => $this->MENGE1,
            'MENGE2' => $this->MENGE2,
            'MENGE3' => $this->MENGE3,
            'MENGE4' => $this->MENGE4,
            'MENGE5' => $this->MENGE5,
            'MENGE6' => $this->MENGE6,
            'MIDENT1' => $this->MIDENT1,
            'MIDENT2' => $this->MIDENT2,
            'MIDENT3' => $this->MIDENT3,
            'MIDENT4' => $this->MIDENT4,
            'MIDENT5' => $this->MIDENT5,
            'MIDENT6' => $this->MIDENT6,
            'MIDENT7' => $this->MIDENT7,
            'MIDENT8' => $this->MIDENT8,
            'MINBE3' => $this->MINBE3,
            'MINBE4' => $this->MINBE4,
            'MINBE5' => $this->MINBE5,
            'MINPRICE' => $this->MINPRICE,
            'MWEIG1' => $this->MWEIG1,
            'MWEIG2' => $this->MWEIG2,
            'MWEIG3' => $this->MWEIG3,
            'NETPRICE1' => $this->NETPRICE1,
            'NETPRICE2' => $this->NETPRICE2,
            'NETPRICE3' => $this->NETPRICE3,
            'NETPRICE4' => $this->NETPRICE4,
            'NETPRICE5' => $this->NETPRICE5,
            'NETPRICE6' => $this->NETPRICE6,
            'ORDERED' => $this->ORDERED,
            'PADDITION1' => $this->PADDITION1,
            'PADDITION2' => $this->PADDITION2,
            'PADDITION3' => $this->PADDITION3,
            'PADDITION4' => $this->PADDITION4,
            'PADDITION5' => $this->PADDITION5,
            'PADDITION6' => $this->PADDITION6,
            'PLATE' => $this->PLATE,
            'PPREIS' => $this->PPREIS,
            'PREIS' => $this->PREIS,
            'PREIS1' => $this->PREIS1,
            'PREIS2' => $this->PREIS2,
            'PREIS3' => $this->PREIS3,
            'PREIS4' => $this->PREIS4,
            'PREIS5' => $this->PREIS5,
            'PREIS6' => $this->PREIS6,
            'PROVREADY' => $this->PROVREADY,
            'RABATT' => $this->RABATT,
            'RABATTREADY' => $this->RABATTREADY,
            'SUPPLIED' => $this->SUPPLIED,
            'SURFACE' => $this->SURFACE,
            'VERTID' => $this->VERTID,
            'VKPERC' => $this->VKPERC,
            'VKPREIS' => $this->VKPREIS,
            'VPE1' => $this->VPE1,
            'VPE2' => $this->VPE2,
            'VPE3' => $this->VPE3,
            'VPREIS0' => $this->VPREIS0,
            'VPREIS1' => $this->VPREIS1,
            'VPREIS2' => $this->VPREIS2,
            'VPREIS3' => $this->VPREIS3,
            'VPREIS4' => $this->VPREIS4,
            'VPREIS5' => $this->VPREIS5,
            'VPROV' => $this->VPROV,
            'VPROZ0' => $this->VPROZ0,
            'VPROZ1' => $this->VPROZ1,
            'VPROZ2' => $this->VPROZ2,
            'VPROZ3' => $this->VPROZ3,
            'VPROZ4' => $this->VPROZ4,
            'VPROZ5' => $this->VPROZ5,
            'VRABATT' => $this->VRABATT,
            'CDATE' => $this->CDATE,
            'CHDATE' => $this->CHDATE,
            'MANDANTNO' => $this->MANDANTNO,
            'ACCOUNT0' => $this->ACCOUNT0,
            'ACCOUNT1' => $this->ACCOUNT1,
            'ACCOUNT2' => $this->ACCOUNT2,
            'ACCOUNT3' => $this->ACCOUNT3,
            'DISCOUNT7' => $this->DISCOUNT7,
            'DISCOUNT8' => $this->DISCOUNT8,
            'DISCOUNT9' => $this->DISCOUNT9,
            'DISCOUNT10' => $this->DISCOUNT10,
            'DISCOUNT11' => $this->DISCOUNT11,
            'DISCOUNT12' => $this->DISCOUNT12,
            'DISCOUNT13' => $this->DISCOUNT13,
            'DISCOUNT14' => $this->DISCOUNT14,
            'DISCOUNT15' => $this->DISCOUNT15,
            'MENGE7' => $this->MENGE7,
            'MENGE8' => $this->MENGE8,
            'MENGE9' => $this->MENGE9,
            'MENGE10' => $this->MENGE10,
            'MENGE11' => $this->MENGE11,
            'MENGE12' => $this->MENGE12,
            'MENGE13' => $this->MENGE13,
            'MENGE14' => $this->MENGE14,
            'NETPRICE7' => $this->NETPRICE7,
            'NETPRICE8' => $this->NETPRICE8,
            'NETPRICE9' => $this->NETPRICE9,
            'NETPRICE10' => $this->NETPRICE10,
            'NETPRICE11' => $this->NETPRICE11,
            'NETPRICE12' => $this->NETPRICE12,
            'NETPRICE13' => $this->NETPRICE13,
            'NETPRICE14' => $this->NETPRICE14,
            'NETPRICE15' => $this->NETPRICE15,
            'PADDITION7' => $this->PADDITION7,
            'PADDITION8' => $this->PADDITION8,
            'PADDITION9' => $this->PADDITION9,
            'PADDITION10' => $this->PADDITION10,
            'PADDITION11' => $this->PADDITION11,
            'PADDITION12' => $this->PADDITION12,
            'PADDITION13' => $this->PADDITION13,
            'PADDITION14' => $this->PADDITION14,
            'PADDITION15' => $this->PADDITION15,
            'PREIS7' => $this->PREIS7,
            'PREIS8' => $this->PREIS8,
            'PREIS9' => $this->PREIS9,
            'PREIS10' => $this->PREIS10,
            'PREIS11' => $this->PREIS11,
            'PREIS12' => $this->PREIS12,
            'PREIS13' => $this->PREIS13,
            'PREIS14' => $this->PREIS14,
        ]);

        $query->andFilterWhere(['like', 'ARTDESC', $this->ARTDESC])
            ->andFilterWhere(['like', 'ARTNAME', $this->ARTNAME])
            ->andFilterWhere(['like', 'FNUM', $this->FNUM])
            ->andFilterWhere(['like', 'AEINH1', $this->AEINH1])
            ->andFilterWhere(['like', 'AEINH2', $this->AEINH2])
            ->andFilterWhere(['like', 'AEINH3', $this->AEINH3])
            ->andFilterWhere(['like', 'ALAGERN', $this->ALAGERN])
            ->andFilterWhere(['like', 'ARTDOC0', $this->ARTDOC0])
            ->andFilterWhere(['like', 'ARTDOC1', $this->ARTDOC1])
            ->andFilterWhere(['like', 'ARTDOC2', $this->ARTDOC2])
            ->andFilterWhere(['like', 'ARTINF1', $this->ARTINF1])
            ->andFilterWhere(['like', 'BITMAPA', $this->BITMAPA])
            ->andFilterWhere(['like', 'BITMAPB', $this->BITMAPB])
            ->andFilterWhere(['like', 'DINNO1', $this->DINNO1])
            ->andFilterWhere(['like', 'DINNO2', $this->DINNO2])
            ->andFilterWhere(['like', 'DRAWNO', $this->DRAWNO])
            ->andFilterWhere(['like', 'MASSEINH', $this->MASSEINH])
            ->andFilterWhere(['like', 'MFAKT', $this->MFAKT])
            ->andFilterWhere(['like', 'PARTNO', $this->PARTNO])
            ->andFilterWhere(['like', 'SERIALNUMBERKEY', $this->SERIALNUMBERKEY])
            ->andFilterWhere(['like', 'VERTRNAME', $this->VERTRNAME])
            ->andFilterWhere(['like', 'CNAME', $this->CNAME])
            ->andFilterWhere(['like', 'CHNAME', $this->CHNAME])
            ->andFilterWhere(['like', 'OR_ORDER.COMMNO', $this->toolNo]);

        return $dataProvider;
    }
}
