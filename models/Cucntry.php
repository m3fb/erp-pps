<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "CU_CNTRY".
 *
 * @property string $CNTRYSIGN
 * @property string $ADDRDTEXT
 * @property string $ADDRTEXT
 * @property string $ADDRTYPE
 * @property string $BITMAP
 * @property string $ECONOMICAREA
 * @property string $GMTINDEX
 * @property string $ISO2CC
 * @property string $ISO3CC
 * @property string $NAME
 * @property string $CNAME
 * @property string $CHNAME
 * @property string $CDATE
 * @property string $CHDATE
 * @property string $MANDANTNO
 *
 * @property CUCOMP[] $cUCOMPs
 */
class Cucntry extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CU_CNTRY';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CNTRYSIGN', 'NAME'], 'required'],
            [['CNTRYSIGN', 'ADDRDTEXT', 'ADDRTEXT', 'BITMAP', 'ISO2CC', 'ISO3CC', 'NAME', 'CNAME', 'CHNAME'], 'string'],
            [['ADDRTYPE', 'ECONOMICAREA', 'GMTINDEX', 'MANDANTNO'], 'number'],
            [['CDATE', 'CHDATE'], 'safe'],
            [['CNTRYSIGN'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CNTRYSIGN' => 'Cntrysign',
            'ADDRDTEXT' => 'Addrdtext',
            'ADDRTEXT' => 'Addrtext',
            'ADDRTYPE' => 'Addrtype',
            'BITMAP' => 'Bitmap',
            'ECONOMICAREA' => 'Economicarea',
            'GMTINDEX' => 'Gmtindex',
            'ISO2CC' => 'Iso2 Cc',
            'ISO3CC' => 'Iso3 Cc',
            'NAME' => 'Name',
            'CNAME' => 'Cname',
            'CHNAME' => 'Chname',
            'CDATE' => 'Cdate',
            'CHDATE' => 'Chdate',
            'MANDANTNO' => 'Mandantno',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCUCOMPs()
    {
        return $this->hasMany(CUCOMP::className(), ['CNTRYSIGN' => 'CNTRYSIGN']);
    }
}
