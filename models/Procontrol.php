<?php
namespace app\models;
use yii\db\Query;
use yii\data\ArrayDataProvider;
use Yii;
use yii\db\ActiveRecord;
use app\models\Lb_dc;

class Procontrol extends ActiveRecord
{

	public $IDENT;
	public $COMMNO;
	public $Auftrag;
	public $log_ID;
	public $log_GESCHWINDIGKEIT;
	public $log_MSTIME;

	public static function tableName()
	{
		return 'OR_OP';
	}


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NO','IDENT','COMMNO','Auftrag'], 'required'],
            [['NO'], 'number'],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [


        ];
    }

  public function findOpenProcesses($params,$linie) {

		$query = (new Query())
		->select(['OR_OP.ORNO','OR_OP.PWPLACE','OR_ORDER.IDENT as IDENT','OR_ORDER.DESCR as Bezeichnung','OR_ORDER.NAME as Auftrag',
		'OR_ORDER.COMMNO','OR_ORDER.PPARTS','OR_ORDER.DELIVERY','OR_ORDER.PRIO',
		'OR_OP.NO','OR_OP.NAME as AG_Nr','OR_OP.DESCR as AG_Name','[OR_OP].[PTR] /60 as Ruestzeit','OR_OP.SEQNUM',
		'([OR_OP].[PTR] /60 +[OR_OP].[PTE] /60 *[OR_OP].[PPARTS]) / 60 as Laufzeit',
		'[OR_OP].[PTE] / 60 as Stueckzeit','OR_OP.OPINFO','OR_OP.APARTS as akt_Stueckzahl', '[OR_OP].[ATE] /3600 as Prod_zeit',
		'[OR_OP].[APARTS] / [OR_ORDER].[PPARTS] as akt_Stand',
		'WP_MA1.NAME as Maschine'])

		->from('OR_OP')

		->leftJoin('OR_ORDER', 'OR_ORDER.NO = OR_OP.ORNO')
		->leftJoin('WP_MA1', 'WP_MA1.NO = OR_OP.PWPLACE')

		->where(['OR_ORDER.SOURCE' => 0])
		->andWhere(['OR_ORDER.EINLAST'=>1])
		->andWhere(['<','OR_OP.STATUS',2])
		->andWhere(['<','OR_ORDER.STATUS',2])
		->andWhere(['WP_MA1.NO' => $linie])

		#->orderBy ('WP_MA1.NAME')
		->addOrderBy('OR_ORDER.DELIVERY')
		->addOrderBy('OR_ORDER.PRIO')
		->addOrderBy('OR_ORDER.NAME')
		->addOrderBy('OR_OP.NAME');

		$this->load($params);

		$query
		->andFilterWhere(['like','OR_ORDER.NAME', $this->Auftrag])
		->andFilterWhere(['like','OR_ORDER.COMMNO', $this->COMMNO])
		->andFilterWhere(['like','OR_ORDER.IDENT', $this->IDENT]);

		$model=$query->all();

		$dataProvider = new ArrayDataProvider([
			'allModels' => $model,
			'pagination' => [
				'pageSize' => 12,
			],
			#'sort' => [
            #'attributes' => ['OR_ORDER.DELIVERY' =>['default' => SORT_ASC]],
        #],
            'key' => 'ORNO',
        ]);

        return $dataProvider;
	}

public function getArtikel($orno) {
	$query = (new Query())

		->select(['OR_ART.ARTDESC','OR_ART.ARTNAME', 'OR_ART.PMENGE as Menge','OR_ART.MASSEINH as Masseinheit'])

		-> from ('OR_ART')

		->where(['OR_ART.ORDNO' => $orno]);

		$model=$query->all();

		$dataProvider = new ArrayDataProvider([
			'allModels' => $model,
			'pagination' => [
				'pageSize' => 0,
			],
        ]);


        return $dataProvider;

	}
public function getMeldung($orno) {
	$query = (new Query())

		->select(['LB_DC.MSTIME','LB_DC.ADCCOUNT', 'LB_DC.APARTS', 'LB_DC.STATUS','LB_DC.PERSNAME','LB_DC.ORNO'])

		-> from ('LB_DC')

		->where(['LB_DC.ORNO' => $orno])
		->andWhere(['LB_DC.NAME' =>'20'])
		->andWhere(['>','LB_DC.ADCCOUNT',0])
		->andWhere(['in','LB_DC.STATUS',[400,500]]);

		$model=$query->all();

		$dataProvider = new ArrayDataProvider([
			'allModels' => $model,
			'pagination' => [
				'pageSize' => 0,
			],
        ]);


        return $dataProvider;

	}

public function findLastBde($linie) {
	$query = (new Query())

		->select(['LB_DC.MSTIME','LB_DC.ADCCOUNT', 'LB_DC.APARTS', 'LB_DC.STATUS','LB_DC.PERSNAME','LB_DC.ORNAME','LB_DC.NAME as AG_Nr'])

		-> from ('LB_DC')

		->where(['like','LB_DC.MSINFO', $linie])
		->andWhere(['in','LB_DC.STATUS',[300,400,500]])
		->limit(6)
		->orderBy ([('LB_DC.MSTIME')=> SORT_DESC]);

		$model=$query->all();

		$dataProvider = new ArrayDataProvider([
			'allModels' => $model,
			'pagination' => [
				'pageSize' => 0,
			],
        ]);


        return $dataProvider;

	}

public function getCurrentSpeed($linie) {

	$dataProvider = $this->find()
		->select('ID as log_ID, GESCHWINDIGKEIT as log_GESCHWINDIGKEIT, MSTIME as log_MSTIME')
		->from('m3_streckenlog')
		->limit(1)
		->where(['LINIE'=>$linie])
		->orderBy(['ID' => SORT_DESC])->one();

   return $dataProvider;

	}

public function getLastProcessChange($linie,$currentSpeed) {

	if ($currentSpeed > 0) {

		$dataProvider = $this->find()
			->select('ID as log_ID, GESCHWINDIGKEIT as log_GESCHWINDIGKEIT, MSTIME as log_MSTIME')
			->from('m3_streckenlog')
			->limit(1)
			->where(['LINIE'=>$linie])
			->andWhere(['GESCHWINDIGKEIT'=>0])
			->orderBy(['ID' => SORT_DESC])->one();
		}

	else {

		$dataProvider = $this->find()
			->select('ID as log_ID, GESCHWINDIGKEIT as log_GESCHWINDIGKEIT, MSTIME as log_MSTIME')
			->from('m3_streckenlog')
			->limit(1)
			->where(['LINIE'=>$linie])
			->andWhere(['>','GESCHWINDIGKEIT',0.1])
			->orderBy(['ID' => SORT_DESC])->one();
		}



   return $dataProvider;

	}
public function findOpenOrders($params,$maschine) {

		$query = (new Query())
		->select(['OR_ORDER.NO','OR_ORDER.IDENT as IDENT','OR_ORDER.DESCR as Bezeichnung','OR_ORDER.NAME as Auftrag',
		'OR_ORDER.COMMNO','OR_ORDER.PPARTS','OR_ORDER.DELIVERY','OR_ORDER.PRIO','OR_ORDER.RELORD',
		#'([OR_OP].[PTR] /60 +[OR_OP].[PTE] /60 *[OR_OP].[PPARTS]) / 60 as Laufzeit',

		'WP_MA1.NAME as Maschine'])

		->from('OR_ORDER')

		->leftJoin('OR_OP', 'OR_ORDER.NO = OR_OP.ORNO')
		->leftJoin('WP_MA1', 'WP_MA1.NO = OR_OP.PWPLACE')

		->where(['OR_ORDER.SOURCE' => 0])
		->andWhere(['OR_ORDER.EINLAST'=>1])
		->andWhere(['<','OR_ORDER.STATUS',2])
		->andWhere(['WP_MA1.NO' => $maschine])
		#->andWhere(['>','OR_OP.PTE',0])

		->addOrderBy('OR_ORDER.DELIVERY')
		->addOrderBy('OR_ORDER.PRIO')
		->distinct();

		$this->load($params);

		$query
		->andFilterWhere(['like','OR_ORDER.NAME', $this->Auftrag])
		->andFilterWhere(['like','OR_ORDER.COMMNO', $this->COMMNO])
		->andFilterWhere(['like','OR_ORDER.IDENT', $this->IDENT]);

		$model=$query->all();

		$dataProvider = new ArrayDataProvider([
			'allModels' => $model,
			'pagination' => [
				'pageSize' => 12,
			],
			#'sort' => [
            #'attributes' => ['OR_ORDER.DELIVERY' =>['default' => SORT_ASC]],
        #],
            'key' => 'NO',
        ]);

        return $dataProvider;
	}

	// Funktion prüft den letzen Status eines Auftrags.
	public function getTaskState($orno)
	{
		//Subquery zum Prüfen des letzten Eintrags in der LB_DC Tabelle
		$last_lbdc = Lb_dc::find()->select(['ORNO','STATUS'])->limit(1)->where(['ORNO'=>$orno])->orderBy(['LBNO'=>SORT_DESC])->one();
		#var_dump($last_lbdc->STATUS); die;
		return $last_lbdc['STATUS'];
	}

	// Funktion prüft den letzen Status eines Arbeitsgangs.
	public function getOperationState($orno,$opno)
	{
		//Subquery zum Prüfen des letzten Eintrags in der LB_DC Tabelle
		$last_lbdc = Lb_dc::find()->select(['ORNO','STATUS','OPNO'])->limit(1)->where(['ORNO'=>$orno])->andWhere(['OPNO'=>$opno])->orderBy(['LBNO'=>SORT_DESC])->one();
		#var_dump($last_lbdc->STATUS); die;
		return $last_lbdc['STATUS'];
	}

	public function getStartedTasks($linie)
	{
		//Subquery zum Prüfen des letzten Eintrags in der LB_DC Tabelle
		#$subQuery = Lb_dc::find()->select(['LBNO','ORNO','STATUS'])->orderBy(['LBNO'=>SORT_DESC])->limit(1);

		$query = (new Query())
		->select('OR_OP.ORNO')
		->from('OR_OP')
		->leftJoin('OR_ORDER', 'OR_ORDER.NO = OR_OP.ORNO')
		->leftJoin('WP_MA1', 'WP_MA1.NO = OR_OP.PWPLACE')
		#->leftJoin(['T' => $subQuery], 'T.ORNO = OR_OP.ORNO')

		->where(['OR_ORDER.SOURCE' => 0])
		->andWhere(['OR_ORDER.EINLAST'=>1])
		->andWhere(['<','OR_ORDER.STATUS',2])
		->andWhere(['WP_MA1.NO' => $linie])
		#->andWhere(['T.STATUS'=>300])
		->andWhere(['OR_OP.NAME'=>'20'])
		->all();

		$count_query=0;

		foreach ($query as $key => $value) {
			if (Procontrol::getTaskState($value['ORNO'])==300) $count_query++;
		}

		return $count_query;
	}

	// Gibt die Anzahl der Arbeitsgänge eines Aufgtags zurück, die noch nicht abgeschlossen sind
	public function getOpenAgs ($id)
	 {
		 $query = (new Query())
 		->from('OR_OP')

 		->where(['OR_OP.ORNO' => $id])
 		->andWhere(['<','OR_OP.STATUS',2])
 		->count();

 		return $query;
	}

	/**
	*@return array $userInfo['vorname'],$userInfo['nachname'],$userInfo['persno']
	*/
	public function getUserInfo()
	{
		if (Yii::$app->user->identity){
			$userInfo=[];
			$userInfo['vorname']=Yii::$app->user->identity->firstname;
			$userInfo['nachname']=Yii::$app->user->identity->surename;
			$userInfo['persno']=Yii::$app->user->identity->persno;
			return $userInfo;
		}
		elseif (m3_ident()){
			#Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			$m3Ident = \yii\helpers\Json::decode(m3_ident());
			$userInfo=[];
			$userInfo['vorname']=$m3Ident['vorname'];
			$userInfo['nachname']=$m3Ident['nachname'];
			$userInfo['persno']=$m3Ident['pnr'];
			return $userInfo;
		}
		else {
			$userInfo=[];
			$userInfo['persno']=0;
			$userInfo['vorname']='keine';
			$userInfo['nachname']='Anmeldung';
			return $userInfo;
		}
	}
}
?>
