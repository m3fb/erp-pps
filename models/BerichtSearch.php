<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use app\models\Bericht;

/**
 * BdeSearch represents the model behind the search form about `app\models\Bde`.
 */
class BerichtSearch extends Bericht
{
	public $TXTNUMMER;
	public $wp_name;
	public $plan_time;
	public $CustName;
	public $kaufteil_no;
	public $COMMNO;
	public $ARTDESC;
	public $type;
	public $ADDRTEXT;
	public $TXTVORGANG3;
	public $VNAME;
	public $VPLACE;
	public $Speditionskosten;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['POSART','TXTNUMMER','CNAME','POSTEXT','COMMNO','ARTDESC','ADDRTEXT','TXTVORGANG3','VNAME','VPLACE','CustName'], 'required'],
            [['Menge','wp_name','kaufteil_no'], 'number'],
            [['plan_time'], 'date'],
        ];
    }

    public function attributeLabels()
    {
        return [
           # 'mehrfachlager_artno' => 'Artikelnr.',

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



    public function searchRueckstand($params,$type)
    {

		$type == 'delivery' ? $paperident = 1 : $paperident = 6;
		$type == 'delivery' ? $txtident = array('Auftragsbestätigung','Änderung unserer AB','Lieferabruf'): $txtident = array('Bestellung','Änderung unserer Bestellung','');

		$query = (new Query())
		->select('PA_POSIT.PONO,PA_POSIT.POSART,PA_POSIT.POSTEXT, PA_POSIT.MENGE,PA_POSIT.POSLIEF0,PA_POSIT.POSDAT,PA_POSIT.POSPRT0,
					PA_PAPER.ADDRTEXT,PA_PAPER.TXTNUMMER,PA_PAPER.ORDERNO,PA_PAPER.ADDRPERS,
					PA_ARTPOS.ALAGER3, PA_ARTPOS.ARTDESC,
					OR_ORDER.COMMNO,
					CU_COMP.NAME as CNAME, CU_COMP.ADDITION as CADDITION,CU_COMP.STREET as CSTREET,CU_COMP.CNTRYSIGN as CCNTRYSIGN,
					CU_COMP.POSTCODE as CPOSTCODE,CU_COMP.PLACE as CPLACE, CU_COMP.PHONE, CU_COMP.CONO AS kdnr,
					CU_PERS.FIRSTNAME,CU_PERS.SURNAME, CU_PERS.SEX, CU_PERS.PHONE1,CU_PERS.PHONE2,CU_PERS.PHONE5,
					CU_VERS.VNAME,CU_VERS.VADDIT,CU_VERS.VSTREET,CU_VERS.VCSIGN,CU_VERS.VPOSTCD,CU_VERS.VPLACE,
					CU_COMP_1.CUSTNO,CU_COMP_1.NAME as SNAME,CU_COMP_1.CUSTNO as SCUSTNO,CU_COMP_1.PHONE as SPHONE,CU_COMP_1.FAX as SFAX')

		->from('PA_POSIT')
		->where(['PA_PAPER.IDENT' => $paperident])
		->andWhere(['PA_PAPER.TXTIDENT' =>[$txtident[0], $txtident[1],$txtident[2]]])
		->andWhere(['>','PA_POSIT.MENGE',0])
		->andWhere(['PA_POSIT.POSLIEF0'=> 0])
		->andWhere(['PA_POSIT.POSPRT0'=> 0])

		->orWhere(['PA_POSIT.POSPRT0'=> 1])
		->andWhere(['PA_PAPER.IDENT' => $paperident])
		->andWhere(['PA_PAPER.TXTIDENT' =>[$txtident[0], $txtident[1],$txtident[2]]])
		->andWhere('PA_POSIT.MENGE-PA_POSIT.POSLIEF0 > 0')


		->leftJoin('PA_PAPER', 'PA_POSIT.PANO = PA_PAPER.PANO')
		->leftJoin('PA_ARTPOS', 'PA_POSIT.POSTNO = PA_ARTPOS.ARTNO')
		->leftJoin('OR_ORDER', 'PA_ARTPOS.FNUM = OR_ORDER.NAME')
		->leftJoin('CU_COMP', 'PA_PAPER.ADDRNO = CU_COMP.CONO')
		->leftJoin('CU_VERS', 'PA_PAPER.VERSNO = CU_VERS.VERSNO' )
		->leftJoin('CU_PERS', 'PA_PAPER.ADDRPERS = CU_PERS.PERSNO' )
		->leftJoin('CU_COMP as CU_COMP_1', 'CU_COMP.SECPHONE = CU_COMP_1.CUSTNO')

		->distinct();

        $this->load($params);

        #if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
           # return $dataProvider;
        #}


        $query
			->andFilterWhere(['like','TXTNUMMER', $this->TXTNUMMER])
            ->andFilterWhere(['like', 'CU_COMP.NAME', $this->CNAME])
            ->andFilterWhere(['like', 'OR_ORDER.COMMNO', $this->COMMNO])
            ->andFilterWhere(['like', 'POSTEXT', $this->POSTEXT])
            ->andFilterWhere(['like','ARTDESC', $this->ARTDESC]);

        $model=$query->all();

        # Bei Auslandslieferungen muss die Transitzeit abgezogen werden; Diese ist unter FAG_DETAILS.VAL02 Typ =0 zu finden.
        foreach($model as $k=>$m) {
				$fagdetails = Fagdetail::find()->where(['FKNO' => $m['kdnr']])->andWhere(['TYP' => 0])->one();
				$transit_time = $fagdetails['VAL02'];

				$model[$k]['VAL02'] = $transit_time; #Transitzeit wird dem Model hinzugefügt

			if ($transit_time > 0) {

				$date_diff = $this->manipulateDeliveryDate($m['POSDAT'],$transit_time);
				$model[$k]['POSDAT'] = $date_diff;
			}

		}
		ArrayHelper::multisort($model, ['POSDAT', 'TXTNUMMER'], [SORT_ASC, SORT_ASC]);
		#array_sort($model, 'POSDAT', SORT_ASC); #Sortierung nach Datumsberechnung

        $dataProvider = new ArrayDataProvider([
			'allModels' => $model,
			'pagination' => [
				'pageSize' => 8,
			],
			'sort' => [
            'attributes' => ['PA_POSIT.POSDAT,TXTNUMMER,CNAME'],
            'defaultOrder'=>'PA_POSIT.POSDAT desc'
        ],
            'key' => 'PONO',
        ]);

        return $dataProvider;
    }


	public function searchPlanungsliste($params,$wp_name,$plan_time) {

		$query = (new Query())
		->select('PA_POSIT.PONO,PA_POSIT.POSART,PA_POSIT.POSTEXT, PA_POSIT.MENGE,PA_POSIT.POSLIEF0,PA_POSIT.POSDAT,PA_POSIT.POSPRT0,
					PA_PAPER.ADDRTEXT,PA_PAPER.TXTNUMMER,PA_PAPER.ORDERNO, PA_PAPER.TXTIDENT, PA_PAPER.IDENT,
					PA_ARTPOS.ALAGER3, PA_ARTPOS.ARTDESC,
					OR_ORDER.COMMNO,
					OR_OP.PTE,
					CU_COMP.NAME as CustName,CU_COMP.CONO AS kdnr,
					WP_MA1.NO as WP_MA1_NO, WP_MA1.NAME as WP_MA1_NAME')

		->from('PA_POSIT')

		->where(['PA_PAPER.IDENT' => 1])
		->andWhere(['PA_PAPER.TXTIDENT' =>['Auftragsbestätigung','Änderung unserer AB','Lieferabruf']])
		->andWhere(['>','PA_POSIT.MENGE',0])
		->andWhere(['PA_POSIT.POSLIEF0'=> 0])
		->andWhere(['PA_POSIT.POSPRT0'=> 0])
		->andWhere(['WP_MA1.TERMNO'=> 0])
		->andWhere(['>','OR_OP.PTE',0])

		->orWhere(['PA_POSIT.POSPRT0'=> 1])
		->andWhere(['PA_PAPER.IDENT' => 1])
		->andWhere(['PA_PAPER.TXTIDENT' =>['Auftragsbestätigung','Änderung unserer AB','Lieferabruf']])
		->andWhere('PA_POSIT.MENGE-PA_POSIT.POSLIEF0 > 0')
		->andWhere(['WP_MA1.TERMNO'=> 0])
		->andWhere(['>','OR_OP.PTE',0])


		->leftJoin('PA_PAPER', 'PA_POSIT.PANO = PA_PAPER.PANO')
		->leftJoin('PA_ARTPOS', 'PA_POSIT.POSTNO = PA_ARTPOS.ARTNO')
		->leftJoin('OR_ORDER', 'PA_ARTPOS.FNUM = OR_ORDER.NAME')
		->leftJoin('OR_OP', 'OR_ORDER.NO = OR_OP.ORNO')
		->leftJoin('WP_MA1', 'OR_OP.PWPLACE = WP_MA1.NO')
		->leftJoin('CU_COMP', 'PA_PAPER.ADDRNO = CU_COMP.CONO')

		->distinct();

		$this->load($params);

		$query->andFilterWhere([
            'WP_MA1.NO' => $wp_name,

        ]);

		$query->andFilterWhere(['like', 'POSART', $this->POSART])
				->andFilterWhere(['like', 'POSTEXT', $this->POSTEXT])
				->andFilterWhere(['like', 'TXTNUMMER', $this->TXTNUMMER])
				->andFilterWhere(['like', 'OR_ORDER.COMMNO', $this->COMMNO])
				->andFilterWhere(['like', 'CU_COMP.NAME', $this->CustName])
				->andFilterWhere(['<', 'PA_POSIT.POSDAT', $plan_time]);

		$model=$query->all();

		# Bei Auslandslieferungen muss die Transitzeit abgezogen werden; Diese ist unter FAG_DETAILS.VAL02 Typ =0 zu finden.
        foreach($model as $k=>$m) {
				$fagdetails = Fagdetail::find()->where(['FKNO' => $m['kdnr']])->andWhere(['TYP' => 0])->one();
				$transit_time = $fagdetails['VAL02'];

				$model[$k]['VAL02'] = $transit_time; #Transitzeit wird dem Model hinzugefügt

			if ($transit_time > 0) {

				$date_diff = $this->manipulateDeliveryDate($m['POSDAT'],$transit_time);
				$model[$k]['POSDAT'] = $date_diff;
			}

		}
		ArrayHelper::multisort($model, ['WP_MA1.NAME','POSDAT'], [SORT_ASC, SORT_ASC]);


        $dataProvider = new ArrayDataProvider([
			'allModels' => $model,
			'pagination' => [
				'pageSize' => 10,
			],
			'sort' => [
            'attributes' => ['WP_MA1.NO'],
        ],
            'key' => 'PONO',
        ]);

        return $dataProvider;
	}
	public function searchKaufteile($params,$kaufteil_no) {

		$kaufteileListeRaw = $this->findKaufteile();
		$kaufteileListe[]='';
		foreach ($kaufteileListeRaw as $item){
			$kaufteileListe[]= $item['ARTDESC'];
		}

		$query = (new Query())


		->select('PA_POSIT.PONO,PA_POSIT.POSART,PA_POSIT.POSTEXT, PA_POSIT.MENGE,PA_POSIT.POSLIEF0,PA_POSIT.POSDAT,PA_POSIT.POSPRT0,
					PA_PAPER.ADDRTEXT,PA_PAPER.TXTNUMMER,PA_PAPER.ORDERNO, PA_PAPER.TXTIDENT, PA_PAPER.IDENT,
					PA_ARTPOS.ALAGER3, PA_ARTPOS.FNUM, PA_ARTPOS.ARTNAME, PA_ARTPOS.MASSEINH, PA_ARTPOS.ARTDESC' )

		->from('PA_POSIT')

		->where(['PA_PAPER.IDENT' => [1,6]])
		->andWhere(['PA_PAPER.TXTIDENT' =>['Auftragsbestätigung','Änderung unserer AB','Lieferabruf','Bestellung']])
		->andWhere(['in','PA_ARTPOS.ARTDESC',$kaufteileListe])
		->andWhere(['PA_ARTPOS.FNUM' =>''])
		->andWhere(['PA_POSIT.POSLIEF0'=> 0])
		->andWhere(['PA_POSIT.POSPRT0'=> 0])

		->orWhere(['PA_POSIT.POSPRT0'=> 1])
		->andWhere(['PA_PAPER.IDENT' => [1,6]])
		->andWhere(['in','PA_ARTPOS.ARTDESC',$kaufteileListe])
		->andWhere(['PA_PAPER.TXTIDENT' =>['Auftragsbestätigung','Änderung unserer AB','Lieferabruf','Bestellung']])
		->andWhere('PA_POSIT.MENGE-PA_POSIT.POSLIEF0 > 0')
		->andWhere(['PA_ARTPOS.FNUM' =>''])

		->leftJoin('PA_PAPER', 'PA_POSIT.PANO = PA_PAPER.PANO')
		->leftJoin('PA_ARTPOS', 'PA_POSIT.POSTNO = PA_ARTPOS.ARTNO')



		->orderBy('PA_ARTPOS.ARTDESC')
		->addOrderBy('PA_PAPER.IDENT')
		->addOrderBy('PA_POSIT.POSDAT ASC');

		$this->load($params);

		$query->andFilterWhere([
            'PA_ARTPOS.ARTDESC' => $kaufteil_no,

        ]);

		#$query->andFilterWhere(['like', 'POSTEXT', $this->POSTEXT]);

		$model=$query->all();
        $dataProvider = new ArrayDataProvider([
			'allModels' => $model,
			'pagination' => [
				'pageSize' => -1,
			],
			'sort' => [
            'attributes' => ['PA_POSIT.POSART','PA_PAPER.IDENT', 'PA_POSIT.POSDAT'],
        ],
            'key' => 'PONO',
        ]);

        return $dataProvider;
	}


	public function findKaufteile() {

		$dataProvider = $this->find()

		->select(['PA_POSIT.PONO','PA_POSIT.POSART','PA_POSIT.POSTEXT','PA_ARTPOS.ARTDESC'])

		->leftJoin('PA_PAPER', 'PA_POSIT.PANO = PA_PAPER.PANO')
		->leftJoin('PA_ARTPOS', 'PA_POSIT.POSTNO = PA_ARTPOS.ARTNO')

		->where(['PA_ARTPOS.FNUM' =>''])
		->andWhere(['PA_PAPER.IDENT' => 1])
		->andWhere(['not like','PA_ARTPOS.ARTDESC','[^0-9]'])

		->orderBy('ARTDESC')
		->groupBy(['ARTDESC','PA_POSIT.PONO','PA_POSIT.POSART','PA_POSIT.POSTEXT','PA_ARTPOS.ARTDESC'])->asArray()->all();


        return $dataProvider;
	}

		public function findSperrlager() {

		$dataProvider = $this->find()

		->select(['PA_POSIT.PONO','PA_POSIT.POSART','PA_POSIT.POSTEXT','PA_ARTPOS.ARTDESC'])

		->leftJoin('PA_PAPER', 'PA_POSIT.PANO = PA_PAPER.PANO')
		->leftJoin('PA_ARTPOS', 'PA_POSIT.POSTNO = PA_ARTPOS.ARTNO')

		->where(['PA_ARTPOS.FNUM' =>''])
		->andWhere(['PA_PAPER.IDENT' => 1])
		->andWhere(['between','PA_ARTPOS.ARTDESC',100000,499999])

		->orderBy('ARTDESC')
		->groupBy('ARTDESC')->asArray()->all();


        return $dataProvider;
	}

		public function searchSpedauftr($params) {

        $query = (new Query())
		->select(' PA_PAPER.PANO,PA_PAPER.TXTNUMMER,PA_PAPER.ADDRTEXT,PA_PAPER.CDATE,PA_PAPER.TXTVORGANG3,
		CU_VERS.VNAME,CU_VERS.VPLACE,PA_PAPER.LIEFERB')

		->from('PA_PAPER')

		->leftJoin('CU_VERS', 'PA_PAPER.VERSNO = CU_VERS.VERSNO')

		->where(['PA_PAPER.IDENT' => 7])
		->andWhere('PA_PAPER.STATUS < 2')
		->andWhere (['not like', 'PA_PAPER.LIEFERB','exw'])

		->orderBy('PA_PAPER.CDATE ASC')
		->addOrderBy('PA_PAPER.TXTNUMMER ASC');

        $this->load($params);



        $query
			->andFilterWhere(['like','TXTNUMMER', $this->TXTNUMMER])
            ->andFilterWhere(['like', 'PA_PAPER.ADDRTEXT', $this->ADDRTEXT])
            ->andFilterWhere(['like', 'PA_PAPER.CDATE', $this->CDATE])
            ->andFilterWhere(['like', 'PA_PAPER.TXTVORGANG3', $this->TXTVORGANG3])
            ->andFilterWhere(['like', 'CU_VERS.VNAME', $this->VNAME])
            ->andFilterWhere(['like', 'CU_VERS.VPLACE', $this->VPLACE]);


        $model=$query->all();
        $dataProvider = new ArrayDataProvider([
			'allModels' => $model,
			'pagination' => [
				'pageSize' => 8,
			],
			'sort' => [
            'attributes' => ['PA_PAPER.CDATE,TXTNUMMER,CNAME'],
        ],
            'key' => 'PANO',
        ]);
        return $dataProvider;

	}
	public function findSped($id) {

        $query = (new Query())
		->select('PA_POSIT.PONO,PA_POSIT.PANO,PA_POSIT.POSNO,PA_POSIT.POSART,PA_POSIT.POSTXTL,PA_POSIT.MENGE,
					PA_POSIT.GPREIS,PA_POSIT.POSLIEF0,
					PA_PAPER.PANO,PA_PAPER.TXTNUMMER,PA_PAPER.ADDRTEXT,PA_PAPER.CDATE,PA_PAPER.TXTVORGANG3,PA_ARTPOS.FNUM,
					OR_ORDER.NAME, OR_ORDER.COMMNO,
					CU_VERS.VNAME,CU_VERS.VPLACE,PA_PAPER.LIEFERB')

		->from('PA_POSIT')

		->leftJoin('PA_ARTPOS', 'PA_POSIT.POSART = PA_ARTPOS.ARTDESC')
		->leftJoin('OR_ORDER', 'PA_ARTPOS.FNUM = OR_ORDER.NAME')
		->leftJoin('PA_PAPER', 'PA_POSIT.PANO = PA_PAPER.PANO')
		->leftJoin('CU_VERS', 'PA_PAPER.VERSNO = CU_VERS.VERSNO')

		->where(['PA_PAPER.PANO' => $id])
		->andWhere(['<>','PA_POSIT.POSART',''])
		->andWhere(['<','PA_ARTPOS.ARTDESC',299999])

		->orderBy('OR_ORDER.COMMNO ASC');

        $model=$query->all();
        $dataProvider = new ArrayDataProvider([
			'allModels' => $model,
			'pagination' => [
				'pageSize' => -1,
			],
			'sort' => [
            'attributes' => ['PA_POSIT.POSNO'],
        ],
            'key' => 'PONO',
        ]);
        return $dataProvider;

	}
	public function getGpreisSum($id) {
		$query = $query = (new Query())

		->from('PA_POSIT')

		->leftJoin('PA_PAPER', 'PA_POSIT.PANO = PA_PAPER.PANO')

		->where(['PA_PAPER.PANO' => $id])
		->andWhere(['<>','PA_POSIT.POSART',''])
		->andWhere(['<','PA_POSIT.POSART',299999]);
		$sum = $query->sum('GPREIS');

		return $sum;
	}

	public function searchReklamationen($params,$type)
    {

		$type == 'supplier' ? $paperident = 6 : $paperident = 7;
		$type == 'supplier' ? $txtident = 'Reklamation' : $txtident = 'Kunden-Reklamation';
		$query = (new Query())
		->select('PA_POSIT.PONO,PA_POSIT.POSART,PA_POSIT.POSTEXT, PA_POSIT.MENGE,PA_POSIT.POSLIEF0,PA_POSIT.POSDAT,PA_POSIT.POSPRT0,PA_POSIT.APOSDAT,PA_POSIT.MASSEINH,
					PA_PAPER.ADDRTEXT,PA_PAPER.TXTNUMMER,PA_PAPER.ORDERNO,PA_PAPER.CDATE,
					PA_ARTPOS.ALAGER3,
					OR_ORDER.COMMNO,
					CU_COMP.NAME as CNAME, CU_COMP.ADDITION as CADDITION,CU_COMP.STREET as CSTREET,CU_COMP.CNTRYSIGN as CCNTRYSIGN,
					CU_COMP.POSTCODE as CPOSTCODE,CU_COMP.PLACE as CPLACE,
					')

		->from('PA_POSIT')
		->where(['PA_PAPER.IDENT' => $paperident])
		->andWhere(['PA_PAPER.TXTIDENT' =>[$txtident]])
		->andWhere(['>','PA_POSIT.MENGE',0])
		->andWhere(['PA_POSIT.POSLIEF0'=> 0])
		->andWhere(['PA_POSIT.POSPRT0'=> 0])

		->orWhere(['PA_POSIT.POSPRT0'=> 1])
		->andWhere(['PA_PAPER.IDENT' => $paperident])
		->andWhere(['PA_PAPER.TXTIDENT' =>[$txtident]])
		->andWhere('PA_POSIT.MENGE-PA_POSIT.POSLIEF0 > 0')


		->leftJoin('PA_PAPER', 'PA_POSIT.PANO = PA_PAPER.PANO')
		->leftJoin('PA_ARTPOS', 'PA_POSIT.POSART = PA_ARTPOS.ARTDESC')
		->leftJoin('OR_ORDER', 'PA_ARTPOS.FNUM = OR_ORDER.NAME')
		->leftJoin('CU_COMP', 'PA_PAPER.ADDRNO = CU_COMP.CONO')

		->orderBy('PA_PAPER.CDATE ASC')
		->addOrderBy('PA_PAPER.TXTNUMMER ASC');

        $this->load($params);



        $query->andFilterWhere(['like', 'POSART', $this->POSART])
			->andFilterWhere(['like','TXTNUMMER', $this->TXTNUMMER])
            ->andFilterWhere(['like', 'CU_COMP.NAME', $this->CNAME])
            ->andFilterWhere(['like', 'OR_ORDER.COMMNO', $this->COMMNO])
            ->andFilterWhere(['like', 'POSTEXT', $this->POSTEXT]);


        $model=$query->all();
        $dataProvider = new ArrayDataProvider([
			'allModels' => $model,
			'pagination' => [
				'pageSize' => 8,
			],
			'sort' => [
            'attributes' => ['PA_PAPER.CDATE,TXTNUMMER,CNAME'],
        ],
            'key' => 'PONO',
        ]);

        return $dataProvider;
    }

    function manipulateDeliveryDate ($date,$transit_raw) {
		$datum = Yii::$app->formatter->asDate($date,'medium');
		$transitTime = Yii::$app->formatter->asInteger($transit_raw);
		$datediff =  date('Y-m-d', strtotime("$datum - $transitTime week"));
		return $datediff;
	}

}
