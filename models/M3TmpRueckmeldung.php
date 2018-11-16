<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "m3_tmp_Rueckmeldung".
 *
 * @property int $ID
 * @property int $Status
 * @property string $Arbeitsplatz
 * @property string $Auftrag
 * @property int $Arbeitsgang
 * @property string $Stueckzahl
 * @property string $LBNO
 * @property string $Erstelldatum
 */
class M3TmpRueckmeldung extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'm3_tmp_Rueckmeldung';
    }

    public $name;
    public $persno;



    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name','persno','Stueckzahl'],'required'],
            [['Status', 'Arbeitsgang'], 'integer'],
            [['Arbeitsplatz', 'Auftrag','name'], 'string'],
            [[ 'LBNO'], 'number'],
            ['Stueckzahl', 'compare', 'compareValue' => 0, 'operator' => '>', 'type' => 'number'],
            [['Erstelldatum'], 'safe'],

            /*
            /* Wenn bereits ein Auftrag zur Rückmeldung vorbereitet wurde (Status=0), dann muss dieser erst
            /* verarbeitet werden. Die untenstehende Prüfung prüft nur offene Aufträge.
            */
            [['Auftrag'], 'unique', 'targetAttribute' => ['Auftrag', 'Status'],'when' => function ($model) {
                return $model->Status == 0;
            }, 'message'=>'Für diesen Auftrag ist bereits eine Rückmeldung vorhanden!'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Status' => 'Status',
            'Arbeitsplatz' => 'Arbeitsplatz',
            'Auftrag' => 'Auftrag',
            'Arbeitsgang' => 'Arbeitsgang',
            'Stueckzahl' => 'Stueckzahl',
            'LBNO' => 'LBNO',
            'Erstelldatum' => 'Erstelldatum',
        ];
    }

    public function search()
    {
      $query = $this->find();

      $dataProvider = new ActiveDataProvider([
          'query' => $query,
      ]);

      return $dataProvider;
    }
}
