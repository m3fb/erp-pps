<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "m3_zeiten".
 *
 * @property integer $ID
 * @property string $MSTIME
 * @property string $PERSNAME
 * @property string $PERSNO
 * @property string $STATUS
 * @property string $WORKID
 */
class M3_zeiten extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm3_zeiten';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MSTIME'], 'safe'],
            [['PERSNAME'], 'string'],
            [['PERSNO', 'STATUS', 'WORKID'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'MSTIME' => 'Zeit',
            'PERSNAME' => 'Name',
            'PERSNO' => 'Personalnummer',
            'STATUS' => 'Status',
            'WORKID' => 'Workid',
        ];
    }
}
