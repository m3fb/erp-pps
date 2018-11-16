<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "m3_Fahrten_Positionen".
 *
 * @property int $ID
 * @property int $Status
 * @property int $BelegID
 * @property string $erstellt_von
 * @property string $Erstelldatum
 * @property string $geaendert_von
 * @property string $Aenderungsdatum
 * @property string $von_Adresse1
 * @property string $von_Adresse2
 * @property string $von_Strasse
 * @property int $von_PLZ
 * @property string $von_Ort
 * @property string $nach_Adresse1
 * @property string $nach_Adresse2
 * @property string $nach_Strasse
 * @property int $nach_PLZ
 * @property string $nach_Ort
 * @property string $Entfernung
 * @property string $Verguetung
 * @property int $Typ
 * @property string $username
 */
class M3FahrtenPositionen extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm3_Fahrten_Positionen';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Status', 'BelegID', 'von_PLZ', 'nach_PLZ', 'Typ'], 'integer'],
            [['von_Adresse1', 'von_Strasse', 'von_Ort', 'nach_Adresse1', 'nach_Strasse', 'nach_Ort', 'username','Fahrtdatum', 'von_PLZ', 'nach_PLZ','Typ'], 'required'],
            [['erstellt_von', 'geaendert_von', 'von_Adresse1', 'von_Adresse2', 'von_Strasse', 'von_Ort', 'nach_Adresse1', 'nach_Adresse2', 'nach_Strasse', 'nach_Ort', 'username'], 'string'],
            [['Erstelldatum', 'Aenderungsdatum','Fahrtdatum'], 'safe'],
            [['Entfernung', 'Verguetung'], 'number','numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Status' => 'Status',
            'BelegID' => 'Beleg ID',
            'erstellt_von' => 'Erstellt von',
            'Erstelldatum' => 'Erstelldatum',
            'geaendert_von' => 'Geaendert von',
            'Aenderungsdatum' => 'Änderungsdatum',
            'Fahrtdatum' => 'Fahrtdatum',
            'von_Adresse1' => 'Adresse',
            'von_Adresse2' => 'Adresse2',
            'von_Strasse' => 'Strasse',
            'von_PLZ' => 'Plz',
            'von_Ort' => 'Ort',
            'nach_Adresse1' => 'Adresse',
            'nach_Adresse2' => 'Nach Adresse2',
            'nach_Strasse' => 'Strasse',
            'nach_PLZ' => 'Plz',
            'nach_Ort' => 'Ort',
            'Entfernung' => 'Entfernung in km',
            'Verguetung' => 'Verguetung',
            'Typ' => 'Typ',
            'username' => 'Username',
        ];
    }




     public function behaviors() {

		return [
			 [
				'class' => BlameableBehavior::className(),
				'createdByAttribute' => 'erstellt_von',
				'updatedByAttribute' => 'geaendert_von',
			 ],
			'timestamp' => [
				'class' => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => [ 'Erstelldatum'],
					ActiveRecord::EVENT_BEFORE_UPDATE => ['Aenderungsdatum'],
					],
				'value' => new Expression('getdate()'), #8.11.2016: NOW() geändert in getdate() weil NOW in MSSQL nicht funktioniert;
			  ],
		];


	}


	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'erstellt_von']); #Hier wird die BlameableID der Todo-Tabelle auf die User ID gemappt.
	}


	public function beforeSave($insert) {

        if (parent::beforeSave($insert)) {



			$number_vars =['Entfernung'];// kann erweiterter werden

			foreach ($number_vars as $var) {
				$this->{$var} = str_replace(",", ".", $this->{$var}); //Komma in Dezimalzahl zur Speicherung in Punkt umwandeln
			}
			if ($this->Entfernung > 0) $this->Verguetung = $this->Entfernung * 0.3;
            return true;
        } else {
            return false;
        }
    }

    public function afterFind() //Dezimalpunkt in Komma umwandeln
    {
        $number_vars =['Entfernung'];

		Yii::$app->controller->action->id !='view'? Yii::$app->formatter->thousandSeparator = '':''; // Tausendertrennzeichen muss leer sein; sonst wird der Wert im Formularfeld nicht als numerisch erkannt
													// Punkt als Tausendertrennzeichen führt außerdem zu Problemen bei der obenstehenden Komma zu Punkt-Umwandlung.
        foreach ($number_vars as $var) {

				 $this->{$var} = Yii::$app->formatter->asDecimal($this->{$var});
			}
        #parent::afterFind();
        return true;
    }


}
