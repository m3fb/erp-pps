<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ST_PLACE".
 *
 * @property string $NAME
 * @property string $PONO
 * @property string $CNAME
 * @property string $CHNAME
 * @property string $CDATE
 * @property string $CHDATE
 * @property string $MANDANTNO
 * @property string $ISQUARANTINESTORE
 */
class St_place extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ST_PLACE';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NAME'], 'required'],
            [['NAME', 'CNAME', 'CHNAME'], 'string'],
            [['PONO', 'MANDANTNO', 'ISQUARANTINESTORE'], 'number'],
            [['CDATE', 'CHDATE'], 'safe'],
            [['NAME'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'NAME' => 'Name',
            'PONO' => 'Pono',
            'CNAME' => 'Cname',
            'CHNAME' => 'Chname',
            'CDATE' => 'Cdate',
            'CHDATE' => 'Chdate',
            'MANDANTNO' => 'Mandantno',
            'ISQUARANTINESTORE' => 'Isquarantinestore',
        ];
    }
}
