<?php

namespace app\models;

use Yii;


class Maschine extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'WP_MA1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NO','CONTROL'], 'required'], #bei editable columns muss der entsprechende Wert hier aufgeführt sein!
            [['NO',], 'number'],
            ['CONTROL', 'integer','min'=>0, 'max' => 4,'message' => 'Der Wert war nicht korrekt.'],
            ['CONTROL', 'validatePrio'],
            [['NAME', ], 'string', 'max' => 64],          
            [['NO'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'NO' => 'Nummer',
            'NAME' => 'Name',
            
        ];
    }
    
    public function validatePrio($attribute, $params)
    {
        $countValues[1] = $this->find()->where(['CONTROL' =>1])->count();
        $countValues[2] = $this->find()->where(['CONTROL' =>2])->count();
        
        if ($this->$attribute == 1 and $countValues[1] > 0) {
            $this->addError($attribute, 'Prio 1 kann nur einmal vergeben werden.');
        }
        if ($this->$attribute == 2 and $countValues[2] > 0) {
            $this->addError($attribute, 'Prio 2 kann nur einmal vergeben werden.');
        }
    }
}
