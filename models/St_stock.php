<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ST_STOCK".
 *
 * @property string $NO
 * @property string $ARTNO
 * @property string $INCDATE
 * @property string $MENGE
 * @property string $OPNO
 * @property string $PLACE
 * @property string $WAREHOUSE
 * @property string $INFO1
 * @property string $INFO2
 * @property string $INFO3
 * @property string $CNAME
 * @property string $CHNAME
 * @property string $CDATE
 * @property string $CHDATE
 * @property string $MANDANTNO
 * @property string $REF_TMP_ISQUARANTINESTORE
 * @property string $INFO4
 * @property string $INFO5
 * @property string $INFO6
 */
class St_stock extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ST_STOCK';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NO'], 'required'],
            [['NO', 'ARTNO', 'MENGE', 'OPNO', 'WAREHOUSE', 'MANDANTNO', 'REF_TMP_ISQUARANTINESTORE'], 'number'],
            [['INCDATE', 'CDATE', 'CHDATE','ARTDESC','ARTNAME'], 'safe'],
            [['PLACE', 'INFO1', 'INFO2', 'INFO3', 'CNAME', 'CHNAME', 'INFO4', 'INFO5', 'INFO6'], 'string'],
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
            'INCDATE' => 'Incdate',
            'MENGE' => 'Menge',
            'OPNO' => 'Opno',
            'PLACE' => 'Lagerort',
            'WAREHOUSE' => 'Warehouse',
            'INFO1' => 'Pal-ID / Charge',
            'INFO2' => 'Info2',
            'INFO3' => 'Info3',
            'CNAME' => 'Cname',
            'CHNAME' => 'Chname',
            'CDATE' => 'Cdate',
            'CHDATE' => 'Chdate',
            'MANDANTNO' => 'Mandantno',
            'REF_TMP_ISQUARANTINESTORE' => 'Ref  Tmp  Isquarantinestore',
            'INFO4' => 'Info4',
            'INFO5' => 'Info5',
            'INFO6' => 'Info6',
            'COMMNO' => 'Werkzeug Nr.',
            'ARTDESC' => 'Artikel Nr.',
            'ARTNAME' => 'Bezeichnung',
        ];
    }

    public function getPaArtPos()
    {
        return $this->hasOne(Pa_artpos::className(), ['ARTNO' => 'ARTNO']);
    }

    public function getToolNo() {
      return $this->hasOne(Ororder::className(), ['NAME' => 'FNUM'])
                  ->via('paArtPos');
  }

    public function getLbDc()
    {
        return $this->hasOne(Lb_dc::className(), ['LBNO' =>'INFO1']);
    }

    public function maxLagerzeit($art_no)
    {
        $maxLagerZeit = [
                '104006' => 12,
                '104106' => 12,
                '104008' => 12,
                '104108' => 12,
                '104012' => 12,
                '104112' => 12,
                '104206' => 24,
                '104208' => 24,
                '104212' => 24
            ];
        return (isset($maxLagerZeit[$art_no]))?$maxLagerZeit[$art_no]:0;
    }

}
