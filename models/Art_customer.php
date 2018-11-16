<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ART_CUSTOMER".
 *
 * @property string $NO
 * @property string $ARTNO
 * @property string $CONO
 * @property string $CUSTADDITION
 * @property string $CUSTNAME
 * @property string $DESCR
 * @property string $EPROZ0
 * @property string $EPROZ1
 * @property string $EPROZ2
 * @property string $EPROZ3
 * @property string $EPROZ4
 * @property string $EPROZ5
 * @property string $INFO
 * @property string $NAME
 * @property string $STATUS0
 * @property string $STATUS1
 * @property string $STATUS2
 * @property string $STATUS3
 * @property string $STATUS4
 * @property string $STATUS5
 * @property string $VERSNO
 * @property string $VERTID
 * @property string $VERTRNAME
 * @property string $VKCNTRYSIGN
 * @property string $VKCNTRYSIGNF
 * @property string $VKMENGE0
 * @property string $VKMENGE1
 * @property string $VKMENGE2
 * @property string $VKMENGE3
 * @property string $VKMENGE4
 * @property string $VKMENGE5
 * @property string $VKPREIS0
 * @property string $VKPREIS1
 * @property string $VKPREIS2
 * @property string $VKPREIS3
 * @property string $VKPREIS4
 * @property string $VKPREIS5
 * @property string $VKPREISF0
 * @property string $VKPREISF1
 * @property string $VKPREISF2
 * @property string $VKPREISF3
 * @property string $VKPREISF4
 * @property string $VKPREISF5
 * @property string $VKWAEHRUNG
 * @property string $VKWAEHRUNGF
 * @property string $VPROV
 * @property string $VPROZ0
 * @property string $VPROZ1
 * @property string $VPROZ2
 * @property string $VPROZ3
 * @property string $VPROZ4
 * @property string $VPROZ5
 * @property string $VRABATT
 * @property string $CNAME
 * @property string $CHNAME
 * @property string $CDATE
 * @property string $CHDATE
 * @property string $MANDANTNO
 * @property string $VKMENGE6
 * @property string $VKMENGE7
 * @property string $VKMENGE8
 * @property string $VKMENGE9
 * @property string $VKMENGE10
 * @property string $VKMENGE11
 * @property string $VKMENGE12
 * @property string $VKMENGE13
 * @property string $VKMENGE14
 * @property string $VKPREIS6
 * @property string $VKPREIS7
 * @property string $VKPREIS8
 * @property string $VKPREIS9
 * @property string $VKPREIS10
 * @property string $VKPREIS11
 * @property string $VKPREIS12
 * @property string $VKPREIS13
 * @property string $VKPREIS14
 * @property string $VKPREISF6
 * @property string $VKPREISF7
 * @property string $VKPREISF8
 * @property string $VKPREISF9
 * @property string $VKPREISF10
 * @property string $VKPREISF11
 * @property string $VKPREISF12
 * @property string $VKPREISF13
 * @property string $VKPREISF14
 */
class Art_customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ART_CUSTOMER';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NO', 'ARTNO', 'CONO'], 'required'],
            [['NO', 'ARTNO', 'CONO', 'EPROZ0', 'EPROZ1', 'EPROZ2', 'EPROZ3', 'EPROZ4', 'EPROZ5', 'STATUS0', 'STATUS1', 'STATUS2', 'STATUS3', 'STATUS4', 'STATUS5', 'VERSNO', 'VERTID', 'VKMENGE0', 'VKMENGE1', 'VKMENGE2', 'VKMENGE3', 'VKMENGE4', 'VKMENGE5', 'VKPREIS0', 'VKPREIS1', 'VKPREIS2', 'VKPREIS3', 'VKPREIS4', 'VKPREIS5', 'VKPREISF0', 'VKPREISF1', 'VKPREISF2', 'VKPREISF3', 'VKPREISF4', 'VKPREISF5', 'VPROV', 'VPROZ0', 'VPROZ1', 'VPROZ2', 'VPROZ3', 'VPROZ4', 'VPROZ5', 'VRABATT', 'MANDANTNO', 'VKMENGE6', 'VKMENGE7', 'VKMENGE8', 'VKMENGE9', 'VKMENGE10', 'VKMENGE11', 'VKMENGE12', 'VKMENGE13', 'VKMENGE14', 'VKPREIS6', 'VKPREIS7', 'VKPREIS8', 'VKPREIS9', 'VKPREIS10', 'VKPREIS11', 'VKPREIS12', 'VKPREIS13', 'VKPREIS14', 'VKPREISF6', 'VKPREISF7', 'VKPREISF8', 'VKPREISF9', 'VKPREISF10', 'VKPREISF11', 'VKPREISF12', 'VKPREISF13', 'VKPREISF14'], 'number'],
            [['CUSTADDITION', 'CUSTNAME', 'DESCR', 'INFO', 'NAME', 'VERTRNAME', 'VKCNTRYSIGN', 'VKCNTRYSIGNF', 'VKWAEHRUNG', 'VKWAEHRUNGF', 'CNAME', 'CHNAME'], 'string'],
            [['CDATE', 'CHDATE'], 'safe'],
            [['NO'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'NO' => 'No',
            'ARTNO' => 'Artno',
            'CONO' => 'Cono',
            'CUSTADDITION' => 'Custaddition',
            'CUSTNAME' => 'Custname',
            'DESCR' => 'Descr',
            'EPROZ0' => 'Eproz0',
            'EPROZ1' => 'Eproz1',
            'EPROZ2' => 'Eproz2',
            'EPROZ3' => 'Eproz3',
            'EPROZ4' => 'Eproz4',
            'EPROZ5' => 'Eproz5',
            'INFO' => 'Info',
            'NAME' => 'Name',
            'STATUS0' => 'Status0',
            'STATUS1' => 'Status1',
            'STATUS2' => 'Status2',
            'STATUS3' => 'Status3',
            'STATUS4' => 'Status4',
            'STATUS5' => 'Status5',
            'VERSNO' => 'Versno',
            'VERTID' => 'Vertid',
            'VERTRNAME' => 'Vertrname',
            'VKCNTRYSIGN' => 'Vkcntrysign',
            'VKCNTRYSIGNF' => 'Vkcntrysignf',
            'VKMENGE0' => 'Vkmenge0',
            'VKMENGE1' => 'Vkmenge1',
            'VKMENGE2' => 'Vkmenge2',
            'VKMENGE3' => 'Vkmenge3',
            'VKMENGE4' => 'Vkmenge4',
            'VKMENGE5' => 'Vkmenge5',
            'VKPREIS0' => 'Vkpreis0',
            'VKPREIS1' => 'Vkpreis1',
            'VKPREIS2' => 'Vkpreis2',
            'VKPREIS3' => 'Vkpreis3',
            'VKPREIS4' => 'Vkpreis4',
            'VKPREIS5' => 'Vkpreis5',
            'VKPREISF0' => 'Vkpreisf0',
            'VKPREISF1' => 'Vkpreisf1',
            'VKPREISF2' => 'Vkpreisf2',
            'VKPREISF3' => 'Vkpreisf3',
            'VKPREISF4' => 'Vkpreisf4',
            'VKPREISF5' => 'Vkpreisf5',
            'VKWAEHRUNG' => 'Vkwaehrung',
            'VKWAEHRUNGF' => 'Vkwaehrungf',
            'VPROV' => 'Vprov',
            'VPROZ0' => 'Vproz0',
            'VPROZ1' => 'Vproz1',
            'VPROZ2' => 'Vproz2',
            'VPROZ3' => 'Vproz3',
            'VPROZ4' => 'Vproz4',
            'VPROZ5' => 'Vproz5',
            'VRABATT' => 'Vrabatt',
            'CNAME' => 'Cname',
            'CHNAME' => 'Chname',
            'CDATE' => 'Cdate',
            'CHDATE' => 'Chdate',
            'MANDANTNO' => 'Mandantno',
            'VKMENGE6' => 'Vkmenge6',
            'VKMENGE7' => 'Vkmenge7',
            'VKMENGE8' => 'Vkmenge8',
            'VKMENGE9' => 'Vkmenge9',
            'VKMENGE10' => 'Vkmenge10',
            'VKMENGE11' => 'Vkmenge11',
            'VKMENGE12' => 'Vkmenge12',
            'VKMENGE13' => 'Vkmenge13',
            'VKMENGE14' => 'Vkmenge14',
            'VKPREIS6' => 'Vkpreis6',
            'VKPREIS7' => 'Vkpreis7',
            'VKPREIS8' => 'Vkpreis8',
            'VKPREIS9' => 'Vkpreis9',
            'VKPREIS10' => 'Vkpreis10',
            'VKPREIS11' => 'Vkpreis11',
            'VKPREIS12' => 'Vkpreis12',
            'VKPREIS13' => 'Vkpreis13',
            'VKPREIS14' => 'Vkpreis14',
            'VKPREISF6' => 'Vkpreisf6',
            'VKPREISF7' => 'Vkpreisf7',
            'VKPREISF8' => 'Vkpreisf8',
            'VKPREISF9' => 'Vkpreisf9',
            'VKPREISF10' => 'Vkpreisf10',
            'VKPREISF11' => 'Vkpreisf11',
            'VKPREISF12' => 'Vkpreisf12',
            'VKPREISF13' => 'Vkpreisf13',
            'VKPREISF14' => 'Vkpreisf14',
        ];
    }
}
