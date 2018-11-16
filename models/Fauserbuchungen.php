<?php

namespace app\models;

use Yii;

  
class Fauserbuchungen extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'PA_POSIT';
    }  
    
    
    public function eckdaten($porno){
        
        $tables = Yii::$app->db->CreateCommand("SELECT * FROM PA_POSIT WHERE PONO = ".$porno."")
        ->queryAll();
        
        return $tables;
        
        
    }
	
}
 