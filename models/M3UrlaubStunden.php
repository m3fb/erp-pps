<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "m3_urlaub_stunden".
 *
 * @property integer $ID
 * @property string $WORKID
 * @property string $JAHR
 * @property string $S1
 * @property string $S2
 * @property string $S3
 * @property string $S4
 * @property string $S5
 * @property string $S6
 * @property string $S7
 * @property string $S8
 * @property string $S9
 * @property string $S10
 * @property string $S11
 * @property string $S12
 * @property string $U1
 * @property string $U2
 * @property string $U3
 * @property string $U4
 * @property string $U5
 * @property string $U6
 * @property string $U7
 * @property string $U8
 * @property string $U9
 * @property string $U10
 * @property string $U11
 * @property string $U12
 *
 * @property PEWORK $wORK
 * @property PEWORK $wORK0
 */
class M3UrlaubStunden extends \yii\db\ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm3_urlaub_stunden';
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        $currentYear = date("Y");
        return [
            [['WORKID', 'JAHR'], 'required'],
            [['WORKID', 'JAHR'], 'unique', 'targetAttribute' => ['WORKID', 'JAHR']],
            [['WORKID'], 'integer'],
            ['JAHR', 'integer','min'=>$currentYear-1, 'max' => $currentYear+1],
            [['S1', 'S2', 'S3', 'S4', 'S5', 'S6', 'S7', 'S8', 'S9', 'S10', 'S11', 'S12', 'U1', 'U2', 'U3', 'U4', 'U5', 'U6', 'U7', 'U8', 'U9', 'U10', 'U11', 'U12'], 'number','numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],
            [['S1', 'S2', 'S3', 'S4', 'S5', 'S6', 'S7', 'S8', 'S9', 'S10', 'S11', 'S12', 'U1', 'U2', 'U3', 'U4', 'U5', 'U6', 'U7', 'U8', 'U9', 'U10', 'U11', 'U12'], 'default', 'value' => 0],
            [['WORKID'], 'exist', 'skipOnError' => true, 'targetClass' => Personal::className(), 'targetAttribute' => ['WORKID' => 'NO']],
            [['WORKID'], 'exist', 'skipOnError' => true, 'targetClass' => Personal::className(), 'targetAttribute' => ['WORKID' => 'NO']],
        ];
    }
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
			for ($i = 1; $i <= 12; $i++) {

				 $this->{"S".$i} = str_replace(",", ".", $this->{"S".$i});
				 $this->{"U".$i} = str_replace(",", ".", $this->{"U".$i});
			}
            return true;
        } else {
            return false;
        }
    }

    public function afterFind()
    {
        for ($i = 1; $i <= 12; $i++) {

				 $this->{"S".$i} = Yii::$app->formatter->asDecimal($this->{"S".$i});
				 $this->{"U".$i} = Yii::$app->formatter->asDecimal($this->{"U".$i});
			}
        #parent::afterFind();
        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'WORKID' => 'Workid',
            'JAHR' => 'Jahr',
            'S1' => 'Std. Jan.',
            'S2' => 'Std. Feb.',
            'S3' => 'Std. Mrz.',
            'S4' => 'Std. Apr.',
            'S5' => 'Std. Mai.',
            'S6' => 'Std. Jun.',
            'S7' => 'Std. Jul.',
            'S8' => 'Std. Aug.',
            'S9' => 'Std. Sep.',
            'S10' => 'Std. Okt.',
            'S11' => 'Std. Nov.',
            'S12' => 'Std. Dez.',
            'U1' => 'Url. Jan.',
            'U2' => 'Url. Feb.',
            'U3' => 'Url. Mrz.',
            'U4' => 'Url. Apr.',
            'U5' => 'Url. Mai.',
            'U6' => 'Url. Jun.',
            'U7' => 'Url. Jul.',
            'U8' => 'Url. Aug.',
            'U9' => 'Url. Sep.',
            'U10' => 'Url. Okt.',
            'U11' => 'Url. Nov.',
            'U12' => 'Url. Dez.',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWORK()
    {
        return $this->hasOne(PEWORK::className(), ['NO' => 'WORKID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWORK0()
    {
        return $this->hasOne(PEWORK::className(), ['NO' => 'WORKID']);
    }

    public function getUrlaubStundenUebersicht($aktivesPersonal,$startdatum,$enddatum)
    {
      echo 
    }


}
