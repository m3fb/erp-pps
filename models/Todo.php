<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "m3_todo".
 *
 * @property integer $id
 * @property string $name
 * @property string $department
 * @property string $due_date
 * @property string $create_name
 * @property string $change_name
 * @property string $create_date
 * @property string $change_date
 * @property string $due_date_option
 */
class Todo extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    
    #public $src;
    
    public static function tableName()
    {
        return 'm3_todo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'due_date'], 'required'],
            [['department', 'beauftragter', 'src'], 'string'],
            [['zyklus', 'prio'], 'safe'],
            [['due_date', 'create_date', 'change_date'], 'safe'],
          #  [['src'], 'file', 'skipOnEmpty' => true],
            [['name', 'create_name', 'change_name'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
     
    # Yii Uploadfunktion (wird nicht verwendet)
    // public function upload()
    // {
        // if ($this->validate()) {
            // $this->src->saveAs('./PDFs/technikum/' . $this->src->baseName . '.' . $this->src->extension);
            // return true;
        // } else {
            // return false;
        // }
    // }
     
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Aufgabe',
            'department' => 'Abteilung',
            'beauftragter' => 'Beauftragter',
            'due_date' => 'Enddatum',
            'create_name' => 'Erstellt von',
            'change_name' => 'Change Name',
            'create_date' => 'Create Date',
            'change_date' => 'Change Date',
            'zyklus' => 'Zyklus',
            'prio' => 'Prio',
            'src' => 'Src',
        ];
    }
    
    public function behaviors() {
    return [
         [
			'class' => BlameableBehavior::className(),
			'createdByAttribute' => 'create_name',
			'updatedByAttribute' => 'change_name',
         ],
        'timestamp' => [
            'class' => TimestampBehavior::className(),
            'attributes' => [
                ActiveRecord::EVENT_BEFORE_INSERT => ['create_date', 'change_date'],
                ActiveRecord::EVENT_BEFORE_UPDATE => ['change_date'],
				],	
            'value' => new Expression('getdate()'), #8.11.2016: NOW() geändert in getdate() weil NOW in MSSQL nicht funktioniert;
          ],
    ];
    
        
	}
	
	public function getUser() 
	{ 
		return $this->hasOne(User::className(), ['id' => 'create_name']); #Hier wird die BlameableID der Todo-Tabelle auf die User ID gemappt.
	} 


}
