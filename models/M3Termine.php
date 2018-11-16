<?php

namespace app\models;


use Yii;
use yii\data\ActiveDataProvider;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "m3_termine".
 *
 * @property integer $ID
 * @property string $START
 * @property string $ENDE
 * @property string $TITEL
 * @property string $BESCHREIBUNG
 * @property string $ZUSATZ
 * @property string $CNAME
 * @property string $CHNAME
 * @property string $CDATE
 * @property string $CHDATE
 * @property string $pruef wenn 1 dann wird Termin im Betriebskalender angezeigt
 */
class M3Termine extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm3_termine';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['START', 'ENDE', 'CDATE', 'CHDATE'], 'safe'],
            [['TITEL', 'BESCHREIBUNG', 'ZUSATZ', 'CNAME', 'CHNAME'], 'string'],
            [['pruef'], 'number'],
            ['START','validateDates','message' => 'Das Enddatum muss nach dem Startdatum sein'],
        ];
    }

    public function behaviors() {
    return [
         [
			'class' => BlameableBehavior::className(),
			'createdByAttribute' => 'CNAME',
			'updatedByAttribute' => 'CHNAME',
         ],
        'timestamp' => [
            'class' => TimestampBehavior::className(),
            'attributes' => [
                ActiveRecord::EVENT_BEFORE_INSERT => ['CDATE', 'CHDATE'],
                ActiveRecord::EVENT_BEFORE_UPDATE => ['CHDATE'],
				],
            'value' => new Expression('getdate()'), #8.11.2016: NOW() geändert in getdate() weil NOW in MSSQL nicht funktioniert;
          ],
    ];
	}

    public function getuser()
	{
		return $this->hasOne(User::className(), ['id' => 'CNAME']); #Hier wird die BlameableID der Todo-Tabelle auf die User ID gemappt.
	}

    public function validateDates(){
		if(strtotime($this->ENDE) <= strtotime($this->START)){
			$this->addError('START','Please give correct Start and End dates');
			$this->addError('ENDE','Please give correct Start and End dates');
		}
	}

	/*Kundentermine finden (pruef=99) bei denen das Enddatum größer als das Startdatum ist. Danach wird gepüft
	 * ob das Startdatum kleiner als das aktuelle Datum ist. Wenn beides zutrifft wird der Wert 1 zurückgegeben.
	 */
	public function getCustomerDateCheck()
	{
		$currentDate = date('d.m.Y H:i:s');
		$customerDates = M3Termine::find()->where(['>','ENDE',$currentDate])->andWhere(['pruef'=>99])->all();
		if(!empty($customerDates)) {
			foreach ($customerDates as $cd) {
				#$start=
  				if (Yii::$app->formatter->asTimestamp($cd['START']) <= Yii::$app->formatter->asTimestamp($currentDate)){
  					return 1;
  					break;
  				}
          else
      		{
      			return 0;
      		}
			}
		}

		#return $customerDates;
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'START' => 'Start',
            'ENDE' => 'Ende',
            'TITEL' => 'Titel',
            'BESCHREIBUNG' => 'Beschreibung',
            'ZUSATZ' => 'Zusatz',
            'CNAME' => 'Cname',
            'CHNAME' => 'Chname',
            'CDATE' => 'Cdate',
            'CHDATE' => 'Chdate',
            'pruef' => 'Pruef',
        ];
    }

    public function search($params,$pruef)
    {
        $query = M3Termine::find();
        $query->where([
			'pruef' => $pruef
			]);

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
            'ID' => $this->ID,
            'START' => $this->START,
            'ENDE' => $this->ENDE,
            'CDATE' => $this->CDATE,
            'CHDATE' => $this->CHDATE,
            'pruef' => $this->pruef,
        ]);

        $query->andFilterWhere(['like', 'TITEL', $this->TITEL])
            ->andFilterWhere(['like', 'BESCHREIBUNG', $this->BESCHREIBUNG])
            ->andFilterWhere(['like', 'ZUSATZ', $this->ZUSATZ])
            ->andFilterWhere(['like', 'CNAME', $this->CNAME])
            ->andFilterWhere(['like', 'CHNAME', $this->CHNAME]);

        return $dataProvider;
    }
}
