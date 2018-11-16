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


class ProjektCheckliste extends \yii\db\ActiveRecord
{
	public $Konst_Ende;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm3_Projekt_Checkliste';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['WerkzeugNr'], 'required'],
            
            [[ 'Einheit', 'Lieferbedingungen', 'Verp_stellt_Kunde', 'Verp_zahl_Kunde',
				'Termin_sonst1_Dauer','Termin_sonst2_Dauer', 'Termin_sonst3_Dauer', 'Termin_sonst4_Dauer', 'Termin_sonst5_Dauer',  
				'Termin_Konst_Dauer', 'Termin_WZBau_Dauer','Termin_Einfahren_Dauer', 'Termin_RM_Dauer', 'Termin_Linie_Dauer',
				'Termin_Vorrichtung_Dauer','Termin_Verpackung_Dauer', 'Termin_int_Bem_Dauer', 'Termin_ext_Bem_Dauer', 
				'Termin_Pruefber_Dauer'], 'integer'],
			
			[[ 'Termin_Pruefber_Dauer','Termin_Pruefber_Dauer_0'], 'default','value'=>1],
				
            [['WerkzeugNr', 'erstellt_von', 'geaendert_von', 'Kunde','Projektkoordinator',
				 'Artikelnummer', 'Profilbezeichnung', 'Vorgangsnummer',
				  'Zeichnungsnummer', 'Index', 'geplanterExtruder', 'RM1_Art_Nr',
				  'RM2_Art_Nr', 'RM3_Art_Nr', 'CU1_Art_Nr', 'CU2_Art_Nr',
				  'CU_3_Art_Nr', 'RM1_Bezeichnung', 'RM2_Bezeichnung',
				  'RM3_Bezeichnung', 'CU1_Bezeichnung', 'CU2_Bezeichnung',
				  'CU3_Bezeichnung', 'Peripherie', 'Versandadresse_Muster', 
				  'Kontaktperson', 'Mindestbestellmenge', 'Zahlungsbed_Werkzeug', 
				  'sonst_Info_Bemusterung', 'Verpackung_Muster', 'Verpackung_Serie', 
				  'Termin_sonst1_Label','Termin_sonst2_Label', 'Termin_sonst3_Label', 'Termin_sonst4_Label', 'Termin_sonst5_Label',
				  'Termin_WZBau_Info1','Termin_Linie_Info1', 'Termin_Vorrichtung_Info1', 'Termin_RM_Info1', 'Termin_Verpackung_Info1',
				  'Termin_sonst1_Info1','Termin_sonst2_Info1', 'Termin_sonst3_Info1', 'Termin_sonst4_Info1', 'Termin_sonst5_Info1',
				  'sonst_Info_allg'], 'string'],	  
                        
            [['Termin_Konst_Ende', 'Termin_WZBau_Ende','Termin_Einfahren_Ende', 'Termin_RM_Ende', 'Termin_Vorrichtung_Ende', 
				'Termin_Verpackung_Ende','Termin_Linie_Ende','Termin_int_Bem_Ende', 'Termin_ext_Bem_Ende', 'Termin_Pruefber_Ende','Konst_Ende',
				'Termin_sonst1_Ende','Termin_sonst2_Ende', 'Termin_sonst3_Ende', 'Termin_sonst4_Ende', 'Termin_sonst5_Ende',],
				'date','format' => 'php:Y-m-d'],#,'min'=>date('Y-m-d')],	  
                        
            [['WerkzeugNr','Erstelldatum', 'Aenderungsdatum', 'Termin_Konst_Ende', 'Termin_Einfahren_Ende',
				'Termin_WZBau_Ende', 'Termin_RM_Ende', 'Termin_Vorrichtung_Ende', 'Termin_Linie_Ende',
				'Termin_sonst1_Ende','Termin_sonst2_Ende', 'Termin_sonst3_Ende', 'Termin_sonst4_Ende', 'Termin_sonst5_Ende',
				'Termin_sonst1_Label','Termin_sonst2_Label', 'Termin_sonst3_Label', 'Termin_sonst4_Label', 'Termin_sonst5_Label',
				'Termin_sonst1_Info1','Termin_sonst2_Info1', 'Termin_sonst3_Info1', 'Termin_sonst4_Info1', 'Termin_sonst5_Info1',
				'Termin_int_Bem_Ende', 'Termin_ext_Bem_Ende', 'Termin_Pruefber_Ende'], 'safe'],
				
            [['geforderterMindestausstoss', 'kalkulierterAusschuss', 'RM1_Gewicht', 
				'RM2_Gewicht', 'RM3_Gewicht', 'CU1_Gewicht', 'CU2_Gewicht', 'CU3_Gewicht', 
				'RM_gesamt', 'CU_gesamt', 'Gewicht_gesamt', 'Muster_Kunde_Anz', 'Muster_Vermess_Anz', 
				'Muster_Verbleib_Anz', 'Muster_Kunde_Laenge', 'Muster_Vermess_Laenge', 
				'Muster_Verbleib_Laenge', 'erste_Serien_Menge'], 'number', 
				'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],
				
            ['Einheit', 'default', 'value' => 0],
            
            [['WerkzeugNr'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'WerkzeugNr' => 'Werkzeug Nr.',
            'erstellt_von' => 'Erstellt Von',
            'Erstelldatum' => 'Erstelldatum',
            'geaendert_von' => 'Geaendert Von',
            'Aenderungsdatum' => 'Änderungsdatum',
            'Kunde' => 'Kunde',
            'Artikelnummer' => 'Artikelnummer',
            'Profilbezeichnung' => 'Profilbezeichnung',
            'Vorgangsnummer' => 'Vorgangsnummer',
            'Zeichnungsnummer' => 'Zeichnungsnummer',
            'Index' => 'Index',
            'geforderterMindestausstoss' => 'Geforderter Mindestausstoß',
            'kalkulierterAusschuss' => 'Kalkulierter Ausschuss',
            'geplanterExtruder' => 'Geplanter Extruder',
            'Einheit' => 'Einheit',
            'RM1_Art_Nr' => 'Rm1  Art  Nr',
            'RM2_Art_Nr' => 'Rm2  Art  Nr',
            'RM3_Art_Nr' => 'Rm3  Art  Nr',
            'CU1_Art_Nr' => 'Cu1  Art  Nr',
            'CU2_Art_Nr' => 'Cu2  Art  Nr',
            'CU_3_Art_Nr' => 'Cu 3  Art  Nr',
            'RM1_Bezeichnung' => 'Rm1  Bezeichnung',
            'RM2_Bezeichnung' => 'Rm2  Bezeichnung',
            'RM3_Bezeichnung' => 'Rm3  Bezeichnung',
            'CU1_Bezeichnung' => 'Cu1  Bezeichnung',
            'CU2_Bezeichnung' => 'Cu2  Bezeichnung',
            'CU3_Bezeichnung' => 'Cu3  Bezeichnung',
            'RM1_Gewicht' => 'Rm1  Gewicht',
            'RM2_Gewicht' => 'Rm2  Gewicht',
            'RM3_Gewicht' => 'Rm3  Gewicht',
            'CU1_Gewicht' => 'CU1  Gewicht',
            'CU2_Gewicht' => 'CU2  Gewicht',
            'CU3_Gewicht' => 'CU3  Gewicht',
            'RM_gesamt' => 'Rm Gesamt',
            'CU_gesamt' => 'Cu Gesamt',
            'Gewicht_gesamt' => 'Gewicht Gesamt',
            'Peripherie' => 'Peripherie',
            'Versandadresse_Muster' => 'Versandadresse  Muster',
            'Kontaktperson' => 'Kontaktperson',
            'Mindestbestellmenge' => 'Mindestbestellmenge',
            'Lieferbedingungen' => 'Lieferbedingungen',
            'Zahlungsbed_Werkzeug' => 'Zahlungsbed  Werkzeug',
            'Muster_Kunde_Anz' => 'Muster  Kunde  Anz',
            'Muster_Vermess_Anz' => 'Muster  Vermess  Anz',
            'Muster_Verbleib_Anz' => 'Muster  Verbleib  Anz',
            'Muster_Kunde_Laenge' => 'Muster  Kunde  Laenge',
            'Muster_Vermess_Laenge' => 'Muster  Vermess  Laenge',
            'Muster_Verbleib_Laenge' => 'Muster  Verbleib  Laenge',
            'sonst_Info_Bemusterung' => 'Sonst  Info  Bemusterung',
            'Verpackung_Muster' => 'Verpackung  Muster',
            'Verpackung_Serie' => 'Verpackung  Serie',
            'Verp_stellt_Kunde' => 'Verp Stellt  Kunde',
            'Verp_zahl_Kunde' => 'Verp Zahl  Kunde',
            'erste_Serien_Menge' => 'Erste  Serien  Menge',
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
	

	public function beforeSave($insert) { 

        if (parent::beforeSave($insert)) { 
			
			$number_vars =['geforderterMindestausstoss', 'kalkulierterAusschuss', 'RM1_Gewicht', 'RM2_Gewicht', 'RM3_Gewicht',
							'CU1_Gewicht', 'CU2_Gewicht', 'CU3_Gewicht', 'RM_gesamt', 'CU_gesamt', 'Gewicht_gesamt', 
							'Muster_Kunde_Anz', 'Muster_Vermess_Anz', 'Muster_Verbleib_Anz', 'Muster_Kunde_Laenge',
							 'Muster_Vermess_Laenge', 'Muster_Verbleib_Laenge', 'erste_Serien_Menge'];
							 
			foreach ($number_vars as $var) {
				$this->{$var} = str_replace(",", ".", $this->{$var}); //Komma in Dezimalzahl zur Speicherung in Punkt umwandeln
			}
			
			
			$date_vars = ['Konst','WZBau','RM','Vorrichtung','Verpackung','Linie','int_Bem','ext_Bem','Pruefber',
							'Einfahren','sonst1','sonst2','sonst3','sonst4','sonst5'];
			foreach ($date_vars as $var) {
				if ($this->{'Termin_'.$var.'_Ende'} && !isset($this->{'Termin_'.$var.'_Ende_0'})) {
					$this->{'Termin_'.$var.'_Ende_0'} = $this->{'Termin_'.$var.'_Ende'}; // Prüfen ob Urtermin gesetzt und wenn nicht mit Termin_Ende setzen
				}
				if ($var !='Pruefber' && $this->{'Termin_'.$var.'_Dauer'} && !isset($this->{'Termin_'.$var.'_Dauer_0'})) {
					$this->{'Termin_'.$var.'_Dauer_0'} = $this->{'Termin_'.$var.'_Dauer'}; // Prüfen ob Urtermin gesetzt und wenn nicht mit Termin_Ende setzen
				}
			}
            return true;
        } else {
            return false;
        }
    }
   
    public function afterFind() //Dezimalpunkt in Komma umwandeln
    {
        $number_vars =['geforderterMindestausstoss', 'kalkulierterAusschuss', 'RM1_Gewicht', 'RM2_Gewicht', 'RM3_Gewicht',
         'CU1_Gewicht', 'CU2_Gewicht', 'CU3_Gewicht', 'RM_gesamt', 'CU_gesamt', 'Gewicht_gesamt', 
							'Muster_Kunde_Anz', 'Muster_Vermess_Anz', 'Muster_Verbleib_Anz', 'Muster_Kunde_Laenge', 
							'Muster_Vermess_Laenge', 'Muster_Verbleib_Laenge', 'erste_Serien_Menge'];
		
		Yii::$app->controller->action->id !='view'? Yii::$app->formatter->thousandSeparator = '':''; // Tausendertrennzeichen muss leer sein; sonst wird der Wert im Formularfeld nicht als numerisch erkannt
													// Punkt als Tausendertrennzeichen führt außerdem zu Problemen bei der obenstehenden Komma zu Punkt-Umwandlung.
        foreach ($number_vars as $var) {				
				
				 $this->{$var} = Yii::$app->formatter->asDecimal($this->{$var});
			} 
        #parent::afterFind(); 
        return true;
    }
    
    public function getIsoWeeksInYear($year) {
		$date = new \DateTime;
		$date->setISODate($year, 53);
		return ($date->format("W") === "53" ? 53 : 52);
	}
   
}
