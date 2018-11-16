<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "m3_Projekt_Checkliste".
 */


class Projekt extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm3_Projekt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Projekt'], 'required'],
            [[ 'Termin_Konst_Dauer', 'Termin_WZBau_Dauer', 'Termin_RM_Dauer', 'Termin_Vorrichtung_Dauer', 'Termin_int_Bem_Dauer', 'Termin_ext_Bem_Dauer', 'Termin_Pruefber_Dauer'], 'integer'],
            [['Projekt', 'erstellt_von', 'geaendert_von', 'Kunde', 'Vorgangsnummer','sonst_Info_allg'], 'string'],
            [['Projekt','Erstelldatum', 'Aenderungsdatum', 'Termin_Konst_Ende', 'Termin_WZBau_Ende', 'Termin_RM_Ende', 'Termin_Vorrichtung_Ende', 'Termin_int_Bem_Ende', 'Termin_ext_Bem_Ende', 'Termin_Pruefber_Ende'], 'safe'],
            [['Projekt'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Projekt' => 'Projekt',
            'erstellt_von' => 'Erstellt Von',
            'Erstelldatum' => 'Erstelldatum',
            'geaendert_von' => 'Geaendert Von',
            'Aenderungsdatum' => 'Änderungsdatum',
            'Kunde' => 'Kunde',
            'Artikelnummer' => 'Artikelnummer',
            'Profilbezeichnung' => 'Profilbezeichnung',
            'Vorgangsnummer' => 'Vorgangsnummer',
            'Termin_Konst_Ende' => 'Termin  Konst  Ende',
            'Termin_Konst_Dauer' => 'Termin  Konst  Dauer',
            'Termin_WZBau_Ende' => 'Termin  Wzbau  Ende',
            'Termin_WZBau_Dauer' => 'Termin  Wzbau  Dauer',
            'Termin_RM_Ende' => 'Termin  Rm  Ende',
            'Termin_RM_Dauer' => 'Termin  Rm  Dauer',
            'Termin_Vorrichtung_Ende' => 'Termin  Vorrichtung  Ende',
            'Termin_Vorrichtung_Dauer' => 'Termin  Vorrichtung  Dauer',
            'Termin_int_Bem_Ende' => 'Termin Int  Bem  Ende',
            'Termin_int_Bem_Dauer' => 'Termin Int  Bem  Dauer',
            'Termin_ext_Bem_Ende' => 'Termin Ext  Bem  Ende',
            'Termin_ext_Bem_Dauer' => 'Termin Ext  Bem  Dauer',
            'Termin_Pruefber_Ende' => 'Termin  Pruefber  Ende',
            'Termin_Pruefber_Dauer' => 'Termin  Pruefber  Dauer',
            'sonst_Info_allg' => 'Sonst  Info Allg',
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
	public function getChanger() 
	{ 
		return $this->hasOne(User::className(), ['id' => 'geaendert_von']); #Hier wird die BlameableID der Todo-Tabelle auf die User ID gemappt.
	} 
	


   
}
