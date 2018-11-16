<?php

namespace app\models;


use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\db\Query;

/**
 * model tbl_Reklamationen
 *
 * @property int $OID
 * @property string $Reklamationstyp
 * @property string $Reklamationsdatum
 */
class Sqllog extends \yii\db\ActiveRecord
{

  public function getTables($date){
  $db_tables['changed'][]='';
  $db_tables['unchanged'][]='';
  $db_tables['other'][]='';
  $tables_ar = Yii::$app->db->Schema->getTableNames();
    foreach ($tables_ar as $tb){
      $table = Yii::$app->db->Schema->getTableSchema($tb);
      if(isset($table->columns['CDATE']) && isset($table->columns['CHDATE'])){
        $query = (new Query())
    		->select('CDATE','CHDATE')
        ->from($tb)
        ->where(['>','CDATE',$date])
        ->orWhere(['>','CDATE',$date])
        ->all();
        if(!empty($query)){
          $db_tables['changed'][] = $tb;
        }
        else {
          $db_tables['unchanged'][] = $tb;
        }
      }
      else {
        $db_tables['other'][] = $tb;
      }

    }
    return $db_tables;
  }

  public function getChangedTables($date){
    ####
    $changed_tables ='';
    $other_tables = '<div class="panel panel-danger">
                      <div class="panel-heading">Tabellen ohne CDATE oder CHDATE</div>
                      <div class="panel-body">';
    $tables_ar = Yii::$app->db->Schema->getTableNames();
    foreach ($tables_ar as $tb){
      $table = Yii::$app->db->Schema->getTableSchema($tb);
      if(isset($table->columns['CDATE']) && isset($table->columns['CHDATE'])){
        $spalten = Yii::$app->db->Schema->getTableSchema($tb)->getColumnNames();
        $query = (new Query())
    		->select('*')
        ->from($tb)
        ->where(['>','CDATE',$date])
        ->orWhere(['>','CHDATE',$date])
        ->all();
        if(!empty($query)){
          $changed_tables .= ' <span class="label label-primary">'.$tb.'</span>
                          <table class="table table-bordered">';
          foreach ($spalten as $sp){
            $changed_tables .= '<th>'.$sp.'</th>';
          }
          foreach ($query as $qvalue) {
            $changed_tables .= '<tr>';
            foreach ($spalten as $sp){
              $changed_tables .= '<td>'.$qvalue[$sp].'</td>';
            }
            $changed_tables .= '</tr>';
          }
          $changed_tables .=
                          '</table>';
        }
      }
      else{
        $other_tables .= '<span class="clearfix" >'.$tb.'</span>';
      }
    }
    $other_tables .= '</div></div>';
    $ausgabe = $changed_tables . $other_tables;
    return $ausgabe;
  }


}
