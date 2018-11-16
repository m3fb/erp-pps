<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use app\models\Bde;
use app\models\M3TmpRueckmeldung;

/**
 * BdeSearch represents the model behind the search form about `app\models\Bde`.
 */
class BdeSearch extends Bde
{
    public $ARTDESC;
    public $arch_time;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['LBNO', 'ADCCOUNT','ARTDESC'], 'required'],
            [['LBNO', 'ORNO', 'STATUS', 'WPLACE', 'PERSNO', 'OPNO', 'APARTS', 'GPARTS', 'BPARTS', 'ATE', 'ATR', 'ATP', 'arch_time',
            'ADCSTAT', 'ADCCOUNT', 'EXSTAT', 'MTIME0', 'MTIME1', 'MTIME2', 'MTIME3', 'OPOPNO', 'OUT', 'FNPK', 'MSGID', 'FKLBNO', 'ISINTERNAL', 'MANDANTNO'], 'number'],
            [['PERSNAME', 'NAME', 'MSTIME', 'MSINFO', 'ORNAME', 'ADCMESS', 'ADCWORK','ADCCOUNT', 'TERMINAL', 'CNAME', 'CHNAME', 'CDATE', 'CHDATE',], 'safe'],
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
        $query = Bde::find();

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
            'NO' => $this->NO,
            'OGNO' => $this->OGNO,
            'CONO' => $this->CONO,
            'SCNO' => $this->SCNO,
            'STATUS' => $this->STATUS,
            'CFLAG' => $this->CFLAG,
            'EINLAST' => $this->EINLAST,
            'CTIME' => $this->CTIME,
            'CHTIME' => $this->CHTIME,
            'RELOPCNT' => $this->RELOPCNT,
            'PSTIMEMIN' => $this->PSTIMEMIN,
            'PSTIMEMAX' => $this->PSTIMEMAX,
            'PETIMEMIN' => $this->PETIMEMIN,
            'PETIMEMAX' => $this->PETIMEMAX,
            'PTE' => $this->PTE,
            'PTR' => $this->PTR,
            'PTG' => $this->PTG,
            'PTH' => $this->PTH,
            'PPARTS' => $this->PPARTS,
            'PREJECTS' => $this->PREJECTS,
            'ORDDATE' => $this->ORDDATE,
            'DELIVERY' => $this->DELIVERY,
            'PRIO' => $this->PRIO,
            'SEQNO' => $this->SEQNO,
            'PREOP' => $this->PREOP,
            'POSTOP' => $this->POSTOP,
            'OVERLAP' => $this->OVERLAP,
            'OVERLAPDIFF' => $this->OVERLAPDIFF,
            'OVERLAPPERC' => $this->OVERLAPPERC,
            'PTRA' => $this->PTRA,
            'PTTRANS' => $this->PTTRANS,
            'PTWAIT' => $this->PTWAIT,
            'SPECIAL' => $this->SPECIAL,
            'SOURCE' => $this->SOURCE,
            'STIME' => $this->STIME,
            'ETIME' => $this->ETIME,
            'ACTIVE' => $this->ACTIVE,
            'SEQNUM' => $this->SEQNUM,
            'PRENO' => $this->PRENO,
            'POSTNO' => $this->POSTNO,
            'PROBLEM' => $this->PROBLEM,
            'ERROR' => $this->ERROR,
            'CPGETP' => $this->CPGETP,
            'CRGETP' => $this->CRGETP,
            'PREIS1' => $this->PREIS1,
            'PREIS2' => $this->PREIS2,
            'PREIS3' => $this->PREIS3,
            'PREIS4' => $this->PREIS4,
            'MENGE1' => $this->MENGE1,
            'MENGE2' => $this->MENGE2,
            'MENGE3' => $this->MENGE3,
            'MENGE4' => $this->MENGE4,
            'EINHEIT' => $this->EINHEIT,
            'ORSETP0' => $this->ORSETP0,
            'ORSETP1' => $this->ORSETP1,
            'ORSETP2' => $this->ORSETP2,
            'ORSETP3' => $this->ORSETP3,
            'ORPRT0' => $this->ORPRT0,
            'ORPRT1' => $this->ORPRT1,
            'ORPRT2' => $this->ORPRT2,
            'PRONO' => $this->PRONO,
            'GRPNO' => $this->GRPNO,
            'SPERC0' => $this->SPERC0,
            'SPERC1' => $this->SPERC1,
            'SPERC2' => $this->SPERC2,
            'SPERC3' => $this->SPERC3,
            'SPERC4' => $this->SPERC4,
            'SPERC5' => $this->SPERC5,
            'PREIS5' => $this->PREIS5,
            'PREIS6' => $this->PREIS6,
            'PREIS7' => $this->PREIS7,
            'PREIS8' => $this->PREIS8,
            'MENGE5' => $this->MENGE5,
            'MENGE6' => $this->MENGE6,
            'MENGE7' => $this->MENGE7,
            'MENGE8' => $this->MENGE8,
            'DATUM0' => $this->DATUM0,
            'DATUM1' => $this->DATUM1,
            'DATUM2' => $this->DATUM2,
            'DATUM3' => $this->DATUM3,
            'ASSART' => $this->ASSART,
            'ASSARTNO' => $this->ASSARTNO,
            'KCONO' => $this->KCONO,
            'KAVIT0' => $this->KAVIT0,
            'KAVIT1' => $this->KAVIT1,
            'KWEIG0' => $this->KWEIG0,
            'KWEIG1' => $this->KWEIG1,
            'TYPE' => $this->TYPE,
            'MUSTERNO' => $this->MUSTERNO,
            'PRINTDATE' => $this->PRINTDATE,
            'CLEARANCE' => $this->CLEARANCE,
            'SDEVPROD1' => $this->SDEVPROD1,
            'SDEVPROD2' => $this->SDEVPROD2,
            'SDEVPROD3' => $this->SDEVPROD3,
            'SDEVPROD4' => $this->SDEVPROD4,
            'SDEVPROD5' => $this->SDEVPROD5,
            'SDEVPROD6' => $this->SDEVPROD6,
            'MDIM1' => $this->MDIM1,
            'MDIM2' => $this->MDIM2,
            'MDIM3' => $this->MDIM3,
            'MWEIG1' => $this->MWEIG1,
            'MWEIG2' => $this->MWEIG2,
            'MWEIG3' => $this->MWEIG3,
            'FAKTOR1' => $this->FAKTOR1,
            'FAKTOR2' => $this->FAKTOR2,
            'FAKTOR3' => $this->FAKTOR3,
            'CDATE' => $this->CDATE,
            'CHDATE' => $this->CHDATE,
            'MANDANTNO' => $this->MANDANTNO,
        ]);

        $query->andFilterWhere(['like', 'NAME', $this->NAME])
            ->andFilterWhere(['like', 'ARTNO', $this->ARTNO])
            ->andFilterWhere(['like', 'DESCR', $this->DESCR])
            ->andFilterWhere(['like', 'HPGLFILE', $this->HPGLFILE])
            ->andFilterWhere(['like', 'BITMAP', $this->BITMAP])
            ->andFilterWhere(['like', 'COMMNO', $this->COMMNO])
            ->andFilterWhere(['like', 'CNAME', $this->CNAME])
            ->andFilterWhere(['like', 'CHNAME', $this->CHNAME])
            ->andFilterWhere(['like', 'USR', $this->USR])
            ->andFilterWhere(['like', 'RELORD', $this->RELORD])
            ->andFilterWhere(['like', 'COSTDEPT', $this->COSTDEPT])
            ->andFilterWhere(['like', 'DRAWNO', $this->DRAWNO])
            ->andFilterWhere(['like', 'IDENT', $this->IDENT])
            ->andFilterWhere(['like', 'INFO1', $this->INFO1])
            ->andFilterWhere(['like', 'INFO2', $this->INFO2])
            ->andFilterWhere(['like', 'INFO3', $this->INFO3])
            ->andFilterWhere(['like', 'MASSEINH', $this->MASSEINH])
            ->andFilterWhere(['like', 'DRAWIND', $this->DRAWIND])
            ->andFilterWhere(['like', 'ORDOC0', $this->ORDOC0])
            ->andFilterWhere(['like', 'ORDOC1', $this->ORDOC1])
            ->andFilterWhere(['like', 'ORDOC2', $this->ORDOC2])
            ->andFilterWhere(['like', 'ADTEXT', $this->ADTEXT])
            ->andFilterWhere(['like', 'FORMNA', $this->FORMNA])
            ->andFilterWhere(['like', 'FORMVA', $this->FORMVA])
            ->andFilterWhere(['like', 'IDEAL0', $this->IDEAL0])
            ->andFilterWhere(['like', 'IDEAL1', $this->IDEAL1])
            ->andFilterWhere(['like', 'IDEAL2', $this->IDEAL2])
            ->andFilterWhere(['like', 'GKN01', $this->GKN01])
            ->andFilterWhere(['like', 'GKN02', $this->GKN02])
            ->andFilterWhere(['like', 'REFOPNAME', $this->REFOPNAME]);

        return $dataProvider;
    }

    public function searchInd($params,$status,$arch_time)
    {
        $date= date('Y-m-d\TH:i:s', strtotime("-50 week")); #Ursprünglich Y-m-d; für SQL in Y-m-d\TH:i:s umgewandelt :-(
        $arch_date= date('Y-m-d\TH:i:s', strtotime("-".$arch_time." week"));

        //25.09.2018 deaktiviert wegen direkter Rückmeldung
        #$auftragsNummern = M3TmpRueckmeldung::find()->select('Auftrag')->where(['Status' => 0]);

        if ($status == 0) {
    			$query = (new Query())
    			->select('LB_DC.LBNO,LB_DC.STATUS,LB_DC.PERSNAME,LB_DC.NAME,LB_DC.MSTIME,
    							LB_DC.MSINFO,LB_DC.ORNAME,LB_DC.ADCCOUNT,LB_DC.ISINTERNAL,LB_DC.FKLBNO,
    							OR_OP.ORNO,OR_OP.PTE,OR_OP.NAME AS OR_OP_NAME,
    							OR_ORDER.NO,OR_ORDER.IDENT,OR_ORDER.DESCR,
    							PA_ARTPOS.ARTDESC,PA_ARTPOS.MASSEINH')
    				->from('LB_DC')

    				->where(['LB_DC.ISINTERNAL' => NULL])
    				->andWhere(['LB_DC.STATUS' => [400,500]])
    				->andWhere(['>', 'LB_DC.MSTIME', $date])
    				->andWhere(['>', 'LB_DC.ADCCOUNT', 0])
    				->andWhere(['>', 'OR_OP.PTE', 0])
    				->andWhere('LB_DC.NAME=OR_OP.NAME')
            //25.09.2018 deaktiviert wegen direkter Rückmeldung
            #->andWhere(['not in','LB_DC.ORNAME',$auftragsNummern])


    				->leftJoin('OR_OP', 'LB_DC.ORNO = OR_OP.ORNO')
    				->leftJoin('OR_ORDER', 'LB_DC.ORNO = OR_ORDER.NO')
    				->leftJoin('PA_ARTPOS', 'OR_ORDER.IDENT = PA_ARTPOS.ARTDESC');
    		}
		    elseif ($status == 1) {
    			$query = (new Query())
    			->select('LB_DC.LBNO,LB_DC.STATUS,LB_DC.PERSNAME,LB_DC.NAME,LB_DC.MSTIME,
    							LB_DC.MSINFO,LB_DC.ORNAME,LB_DC.ADCCOUNT,LB_DC.ISINTERNAL,LB_DC.FKLBNO,
    							OR_OP.ORNO,OR_OP.PTE,OR_OP.NAME AS OR_OP_NAME,
    							OR_ORDER.NO,OR_ORDER.IDENT,OR_ORDER.DESCR,
    							PA_ARTPOS.ARTDESC,PA_ARTPOS.MASSEINH')
    				->from('LB_DC')

    				->where(['LB_DC.ISINTERNAL' => 2])
    				->andWhere(['LB_DC.STATUS' => [400,500]])
    				->andWhere(['>', 'LB_DC.MSTIME', $arch_date])
    				->andWhere(['>', 'LB_DC.ADCCOUNT', 0])
    				->andWhere(['>', 'OR_OP.PTE', 0])
    				->andWhere('LB_DC.NAME=OR_OP.NAME')


    				->leftJoin('OR_OP', 'LB_DC.ORNO = OR_OP.ORNO')
    				->leftJoin('OR_ORDER', 'LB_DC.ORNO = OR_ORDER.NO')
    				->leftJoin('PA_ARTPOS', 'OR_ORDER.IDENT = PA_ARTPOS.ARTDESC')

    				->orderBy('LB_DC.MSTIME DESC');
    		}



        $this->load($params);

        #if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
           # return $dataProvider;
        #}


        $query->andFilterWhere([
            'LBNO' => $this->LBNO,
            'ORNO' => $this->ORNO,
            'STATUS' => $this->STATUS,
            'WPLACE' => $this->WPLACE,
            'PERSNO' => $this->PERSNO,
            'OPNO' => $this->OPNO,
            'MSTIME' => $this->MSTIME,
            'APARTS' => $this->APARTS,
            'GPARTS' => $this->GPARTS,
            'BPARTS' => $this->BPARTS,
            'ATE' => $this->ATE,
            'ATR' => $this->ATR,
            'ATP' => $this->ATP,
            'ADCSTAT' => $this->ADCSTAT,
            'ADCCOUNT' => $this->ADCCOUNT,
            'EXSTAT' => $this->EXSTAT,
            'MTIME0' => $this->MTIME0,
            'MTIME1' => $this->MTIME1,
            'MTIME2' => $this->MTIME2,
            'MTIME3' => $this->MTIME3,
            'OPOPNO' => $this->OPOPNO,
            'OUT' => $this->OUT,
            'FNPK' => $this->FNPK,
            'MSGID' => $this->MSGID,
            'FKLBNO' => $this->FKLBNO,
            'ISINTERNAL' => $this->ISINTERNAL,
            'CDATE' => $this->CDATE,
            'CHDATE' => $this->CHDATE,
            'MANDANTNO' => $this->MANDANTNO,
        ]);

        $query->andFilterWhere(['like', 'PERSNAME', $this->PERSNAME])
            ->andFilterWhere(['like', 'NAME', $this->NAME])
            ->andFilterWhere(['like', 'MSINFO', $this->MSINFO])
            ->andFilterWhere(['like', 'ORNAME', $this->ORNAME])
            ->andFilterWhere(['like', 'ADCMESS', $this->ADCMESS])
            ->andFilterWhere(['like', 'ADCWORK', $this->ADCWORK])
            ->andFilterWhere(['like', 'TERMINAL', $this->TERMINAL])
            ->andFilterWhere(['like', 'CNAME', $this->CNAME])
            ->andFilterWhere(['like', 'CHNAME', $this->CHNAME])
            ->andFilterWhere(['like','ARTDESC', $this->ARTDESC]);

        $model=$query->all();
        $dataProvider = new ArrayDataProvider([
			'allModels' => $model,
			'pagination' => [
				'pageSize' => 8,
			],
			'sort' => [
            'attributes' => ['ORNAME','ARTDESC','MSTIME'],
        ],
            'key' => 'LBNO',
        ]);

        return $dataProvider;
    }

    public static function getOneReport($LBNO)
			{

				$query = (new \yii\db\Query())
					->select('LB_DC.LBNO,LB_DC.STATUS,LB_DC.PERSNAME,LB_DC.PERSNO,LB_DC.NAME,LB_DC.MSTIME,
								LB_DC.MSINFO,LB_DC.ORNAME,LB_DC.ADCCOUNT,LB_DC.ISINTERNAL,
								OR_ORDER.NO, OR_ORDER.IDENT,OR_ORDER.DESCR, OR_ORDER.COMMNO,
								OR_ORDER.DRAWIND, OR_ORDER.DRAWNO, OR_ORDER.INFO1,OR_ORDER.INFO3,
								PA_ARTPOS.ARTDESC,PA_ARTPOS.MASSEINH,PA_ARTPOS.ARTNO,
								CU_COMP.NAME AS CU_NAME, CU_COMP.PLACE')
					->from('LB_DC')
					->where(['LB_DC.LBNO' => $LBNO])
					->leftJoin('OR_ORDER', 'LB_DC.ORNO = OR_ORDER.NO')
					->leftJoin('PA_ARTPOS', 'OR_ORDER.IDENT = PA_ARTPOS.ARTDESC')
					->leftJoin('CU_COMP', 'OR_ORDER.KCONO = CU_COMP.CONO');

				$report = $query->one();

				return $report;
				}
}
