<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Personal;

/**
 * PersonalSearch represents the model behind the search form about `app\models\Personal`.
 */
class PersonalSearch extends Personal
{
    public $ABTEILUNG;
    public $Geburtstag;
    public $Buchungsnummer;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NO', 'CALNO', 'CONO', 'COSTNO', 'COSTPH1', 'COSTPH2', 'COSTPH3', 'DEPTNO', 'EFC', 'GROUPNO', 'INTMAIL1', 'SEX', 'SHIFTNO', 'STATUS1', 'STATUS2', 'STATUS3', 'WENDH', 'WSTARTH','Buchungsnummer'], 'number'],
            [['ABTEILUNG', 'Geburtstag', 'PERSNO', 'FIRSTNAME', 'SURNAME', 'BITMAP', 'CNTRYSIGN', 'FAX', 'MODEM', 'PDAYDAT1', 'PDAYDAT2', 'PDAYDAT3', 'PDAYINF1', 'PDAYINF2', 'PDAYINF3', 'PEINFO', 'PHONE1', 'PHONE2', 'PHONE3', 'PLACE', 'POSITION', 'POSTCODE', 'SALUTE', 'SBREAK', 'STREET', 'WENDT', 'WSTARTT', 'CNAME', 'CHNAME', 'CDATE', 'CHDATE'], 'safe'],
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
        $query = Personal::find();
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
            'NO' => $this->NO,
            'CALNO' => $this->CALNO,
            'CONO' => $this->CONO,
            'COSTNO' => $this->COSTNO,
            'COSTPH1' => $this->COSTPH1,
            'COSTPH2' => $this->COSTPH2,
            'COSTPH3' => $this->COSTPH3,
            'DEPTNO' => $this->DEPTNO,
            'EFC' => $this->EFC,
            'GROUPNO' => $this->GROUPNO,
            'INTMAIL1' => $this->INTMAIL1,
            'PDAYDAT1' => $this->PDAYDAT1,
            'PDAYDAT2' => $this->PDAYDAT2,
            'PDAYDAT3' => $this->PDAYDAT3,
            'SEX' => $this->SEX,
            'SHIFTNO' => $this->SHIFTNO,
            'STATUS1' => 0,
            'STATUS2' => $this->STATUS2,
            'STATUS3' => $this->STATUS3,
            'WENDH' => $this->WENDH,
            'WENDT' => $this->WENDT,
            'WSTARTH' => $this->WSTARTH,
            'WSTARTT' => $this->WSTARTT,
            'CDATE' => $this->CDATE,
            'CHDATE' => $this->CHDATE,
        ]);

        $query->andFilterWhere(['like', 'PE_WORK.PERSNO', $this->PERSNO])
            ->andFilterWhere(['like', 'FIRSTNAME', $this->FIRSTNAME])
            ->andFilterWhere(['like', 'SURNAME', $this->SURNAME])
            ->andFilterWhere(['like', 'BITMAP', $this->BITMAP])
            ->andFilterWhere(['like', 'CNTRYSIGN', $this->CNTRYSIGN])
            ->andFilterWhere(['like', 'FAX', $this->FAX])
            ->andFilterWhere(['like', 'MODEM', $this->MODEM])
            ->andFilterWhere(['like', 'PDAYINF1', $this->PDAYINF1])
            ->andFilterWhere(['like', 'PDAYINF2', $this->PDAYINF2])
            ->andFilterWhere(['like', 'PDAYINF3', $this->PDAYINF3])
            ->andFilterWhere(['like', 'PEINFO', $this->PEINFO])
            ->andFilterWhere(['like', 'PHONE1', $this->PHONE1])
            ->andFilterWhere(['like', 'PHONE2', $this->PHONE2])
            ->andFilterWhere(['like', 'PHONE3', $this->PHONE3])
            ->andFilterWhere(['like', 'PLACE', $this->PLACE])
            ->andFilterWhere(['like', 'POSITION', $this->POSITION])
            ->andFilterWhere(['like', 'POSTCODE', $this->POSTCODE])
            ->andFilterWhere(['like', 'SALUTE', $this->SALUTE])
            ->andFilterWhere(['like', 'SBREAK', $this->SBREAK])
            ->andFilterWhere(['like', 'STREET', $this->STREET])
            ->andFilterWhere(['like', 'CNAME', $this->CNAME])
            ->andFilterWhere(['like', 'CHNAME', $this->CHNAME]);



        return $dataProvider;
    }



	public function getPersonalListe($params)
	{
		$query = $this->find()

		->select(['PE_WORK.NO','PE_WORK.PERSNO','PE_WORK.FIRSTNAME','SURNAME','PHONE1','PHONE2','PHONE3','MODEM','user.username as username',
					'FAG_DETAIL.DAT01 as Geburtstag', 'FAG_DETAIL.TXT02 as ABTEILUNG', 'FAG_DETAIL.TXT03 as EMAILURLAUB','FAG_DETAIL.VAL03 as Buchungsnummer']) #FAG_DETAIL.TXT01, TXT02 usw. muss ggf. angepasst werden
		->from('PE_WORK')
		->leftJoin('[user]', 'PE_WORK.NO = [user].[pe_work_id]') # user muss in eckige Klammern gesetzt werden, da sonst der SQL-Befehl nicht ausgeführt werden kann. user = Schlüsselnamen
		->leftJoin('FAG_DETAIL', 'PE_WORK.NO = FAG_DETAIL.FKNO') # Verknüpfung mit den zusätzlichen Informationen (Geburtstag, Abteilung...)

		->where(['STATUS1'=> 0])
		->andWhere(['FAG_DETAIL.TYP' => 26]) #26 = Typnr. für Personaldetails
		->asArray();

		$dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['SURNAME'=>SORT_ASC]]
        ]);

    $dataProvider->sort->attributes['ABTEILUNG'] = [
  				'asc' => ['convert(nvarchar(100),FAG_DETAIL.TXT02)' => SORT_ASC],
  				'desc' => ['convert(nvarchar(100),FAG_DETAIL.TXT02)' => SORT_DESC],
  			];
		$dataProvider->sort->attributes['Geburtstag'] = [
  				'asc' => ['convert(nvarchar(100),FAG_DETAIL.DAT01)' => SORT_ASC],
  				'desc' => ['convert(nvarchar(100),FAG_DETAIL.DAT01)' => SORT_DESC],
  			];
    $dataProvider->sort->attributes['Buchungsnummer'] = [
      		'asc' => ['FAG_DETAIL.VAL03' => SORT_ASC],
      		'desc' => ['FAG_DETAIL.VAL03' => SORT_DESC],
      	];

        $this->load($params);

        $query->andFilterWhere(['like', 'PE_WORK.PERSNO', $this->PERSNO])
            ->andFilterWhere(['like', 'PE_WORK.FIRSTNAME', $this->FIRSTNAME])
            ->andFilterWhere(['like', 'SURNAME', $this->SURNAME])
            ->andFilterWhere(['like', 'PHONE1', $this->PHONE1])
            ->andFilterWhere(['MONTH(FAG_DETAIL.DAT01)' => $this->Geburtstag])
            ->andFilterWhere(['like', 'FAG_DETAIL.TXT02', $this->ABTEILUNG])
            ->andFilterWhere(['like','FAG_DETAIL.VAL03', $this->Buchungsnummer]);

		return $dataProvider;
	}




}
