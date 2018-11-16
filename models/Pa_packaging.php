<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "PA_PACKAGING".
 *
 * @property string $PKNO
 * @property string $FKNO
 * @property string $GROUPNAME
 * @property string $GROUPPRIORITY
 * @property string $SEQNUM
 * @property string $FKNOPA
 * @property string $FILLQUANTITY
 * @property string $QUANTITY
 * @property string $SELL
 * @property string $PRINTQUANTITY
 * @property string $PRINTQTYABS
 * @property string $PARAMIDENT
 * @property string $CNAME
 * @property string $CHNAME
 * @property string $CDATE
 * @property string $CHDATE
 */
class Pa_packaging extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PA_PACKAGING';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PKNO'], 'required'],
            [['PKNO', 'FKNO', 'GROUPPRIORITY', 'SEQNUM', 'FKNOPA', 'FILLQUANTITY', 'QUANTITY', 'SELL', 'PRINTQUANTITY', 'PRINTQTYABS', 'PARAMIDENT'], 'number'],
            [['GROUPNAME', 'CNAME', 'CHNAME'], 'string'],
            [['CDATE', 'CHDATE'], 'safe'],
            [['PKNO'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PKNO' => 'Pkno',
            'FKNO' => 'Fkno',
            'GROUPNAME' => 'Groupname',
            'GROUPPRIORITY' => 'Grouppriority',
            'SEQNUM' => 'Seqnum',
            'FKNOPA' => 'Fknopa',
            'FILLQUANTITY' => 'Fillquantity',
            'QUANTITY' => 'Quantity',
            'SELL' => 'Sell',
            'PRINTQUANTITY' => 'Printquantity',
            'PRINTQTYABS' => 'Printqtyabs',
            'PARAMIDENT' => 'Paramident',
            'CNAME' => 'Cname',
            'CHNAME' => 'Chname',
            'CDATE' => 'Cdate',
            'CHDATE' => 'Chdate',
        ];
    }
}
