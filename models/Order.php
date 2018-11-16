<?php

namespace app\models;

use Yii;


class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'OR_ORDER';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NO','PRIO','DELIVERY'], 'required'], #bei editable columns muss der entsprechende Wert hier aufgeführt sein!
            [['NO','PRIO'], 'number'],
            [['PRIO','DELIVERY'], 'safe'],         
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
            'PRIO' => 'Sortierung',
            'DELIVERY' => 'Liefertermin',
            
        ];
    }
    
   
}
