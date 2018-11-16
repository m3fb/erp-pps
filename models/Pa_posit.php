<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "PA_POSIT".
 *
 * @property string $PONO
 * @property string $PANO
 * @property string $POSNO
 * @property string $POSART
 * @property string $POSTXTL
 * @property string $AUSGNO
 * @property string $VORGNO
 * @property string $ALTAUSGNO
 * @property string $ALTIDENT
 * @property string $ALTVORGNO
 * @property string $AMOUNTEXPORT
 * @property string $APOSDAT
 * @property string $BOOKSTATUS
 * @property string $CALSTATUS
 * @property string $DISCOUNT
 * @property string $DISCOUNTABS
 * @property string $EINHEIT
 * @property string $EPREIS
 * @property string $EPREIS1
 * @property string $FREMDWAEHRUNG
 * @property string $GPREIS
 * @property string $GPREIS1
 * @property string $GRUNDPREIS
 * @property string $INCOMING
 * @property string $LENGTH
 * @property string $LINKFK
 * @property string $MASSEINH
 * @property string $MENGE
 * @property string $MGRPNAME
 * @property string $OLDPOS
 * @property string $OLDPOS2
 * @property string $OLDPOS3
 * @property string $ORDERED
 * @property string $PACKAGINGFK
 * @property string $PACKAGINGSELL
 * @property string $PACKAGINGUNIT
 * @property string $PAYPERMISSION
 * @property string $PETIMEMAX
 * @property string $PLNO
 * @property string $POSDAT
 * @property string $POSDOC0
 * @property string $POSDOC1
 * @property string $POSDOC2
 * @property string $POSDOC3
 * @property string $POSIDENT
 * @property string $POSIDNAM
 * @property string $POSIDNO
 * @property string $POSINF
 * @property string $POSLIEF0
 * @property string $POSLIEF1
 * @property string $POSLIEF2
 * @property string $POSLIEF3
 * @property string $POSLIEF4
 * @property string $POSLIEF5
 * @property string $POSPRT0
 * @property string $POSPRT1
 * @property string $POSPRT2
 * @property string $POSTART
 * @property string $POSTEXT
 * @property string $POSTNAME
 * @property string $POSTNO
 * @property string $POSTYP
 * @property string $RPOSDAT
 * @property string $PRINTQUANTITY
 * @property string $PROJECT
 * @property string $PROJNAME
 * @property string $PSTIMEMIN
 * @property string $PTYP
 * @property string $RABATT
 * @property string $REVENUEACC
 * @property string $SEPARATESETUPCOSTS
 * @property string $VERTID
 * @property string $VERTRNAME
 * @property string $VKCNTRYSIGN
 * @property string $VKCNTRYSIGNF
 * @property string $VKUMRECHFAKT
 * @property string $VKUMRECHFAKTF
 * @property string $VKWAEHRUNG
 * @property string $VKWAEHRUNGF
 * @property string $VPROV
 * @property string $VPROVABS
 * @property string $VRABATT
 * @property string $VRABATTABS
 * @property string $CNAME
 * @property string $CHNAME
 * @property string $CDATE
 * @property string $CHDATE
 * @property string $MANDANTNO
 * @property string $VAT
 *
 * @property PAPAPER $pANO
 */
class PA_POSIT extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'PA_POSIT';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['PONO', 'POSNO', 'AUSGNO', 'VORGNO'], 'required'],
            [['PONO', 'PANO', 'POSNO', 'AUSGNO', 'VORGNO', 'ALTAUSGNO', 'ALTIDENT', 'ALTVORGNO', 'AMOUNTEXPORT', 'BOOKSTATUS', 'CALSTATUS', 'DISCOUNT', 'DISCOUNTABS', 'EINHEIT', 'EPREIS', 'EPREIS1', 'FREMDWAEHRUNG', 'GPREIS', 'GPREIS1', 'GRUNDPREIS', 'INCOMING', 'LENGTH', 'LINKFK', 'MENGE', 'OLDPOS', 'OLDPOS2', 'OLDPOS3', 'ORDERED', 'PACKAGINGFK', 'PACKAGINGSELL', 'PACKAGINGUNIT', 'PAYPERMISSION', 'PLNO', 'POSIDENT', 'POSIDNO', 'POSLIEF0', 'POSLIEF1', 'POSLIEF2', 'POSLIEF3', 'POSLIEF4', 'POSLIEF5', 'POSPRT0', 'POSPRT1', 'POSPRT2', 'POSTNO', 'POSTYP', 'PRINTQUANTITY', 'PROJECT', 'PTYP', 'RABATT', 'SEPARATESETUPCOSTS', 'VERTID', 'VKUMRECHFAKT', 'VKUMRECHFAKTF', 'VPROV', 'VPROVABS', 'VRABATT', 'VRABATTABS', 'MANDANTNO', 'VAT'], 'number'],
            [['POSART', 'POSTXTL', 'MASSEINH', 'MGRPNAME', 'POSDOC0', 'POSDOC1', 'POSDOC2', 'POSDOC3', 'POSIDNAM', 'POSINF', 'POSTART', 'POSTEXT', 'POSTNAME', 'PROJNAME', 'REVENUEACC', 'VERTRNAME', 'VKCNTRYSIGN', 'VKCNTRYSIGNF', 'VKWAEHRUNG', 'VKWAEHRUNGF', 'CNAME', 'CHNAME'], 'string'],
            [['APOSDAT', 'PETIMEMAX', 'POSDAT', 'RPOSDAT', 'PSTIMEMIN', 'CDATE', 'CHDATE'], 'safe'],
            [['PONO'], 'unique'],
            [['PANO'], 'exist', 'skipOnError' => true, 'targetClass' => PA_PAPER::className(), 'targetAttribute' => ['PANO' => 'PANO']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'PONO' => 'P O N O',
            'PANO' => 'P A N O',
            'POSNO' => 'P O S N O',
            'POSART' => 'P O S A R T',
            'POSTXTL' => 'P O S T X T L',
            'AUSGNO' => 'A U S G N O',
            'VORGNO' => 'V O R G N O',
            'ALTAUSGNO' => 'A L T A U S G N O',
            'ALTIDENT' => 'A L T I D E N T',
            'ALTVORGNO' => 'A L T V O R G N O',
            'AMOUNTEXPORT' => 'A M O U N T E X P O R T',
            'APOSDAT' => 'A P O S D A T',
            'BOOKSTATUS' => 'B O O K S T A T U S',
            'CALSTATUS' => 'C A L S T A T U S',
            'DISCOUNT' => 'D I S C O U N T',
            'DISCOUNTABS' => 'D I S C O U N T A B S',
            'EINHEIT' => 'E I N H E I T',
            'EPREIS' => 'E P R E I S',
            'EPREIS1' => 'E P R E I S1',
            'FREMDWAEHRUNG' => 'F R E M D W A E H R U N G',
            'GPREIS' => 'G P R E I S',
            'GPREIS1' => 'G P R E I S1',
            'GRUNDPREIS' => 'G R U N D P R E I S',
            'INCOMING' => 'I N C O M I N G',
            'LENGTH' => 'L E N G T H',
            'LINKFK' => 'L I N K F K',
            'MASSEINH' => 'M A S S E I N H',
            'MENGE' => 'M E N G E',
            'MGRPNAME' => 'M G R P N A M E',
            'OLDPOS' => 'O L D P O S',
            'OLDPOS2' => 'O L D P O S2',
            'OLDPOS3' => 'O L D P O S3',
            'ORDERED' => 'O R D E R E D',
            'PACKAGINGFK' => 'P A C K A G I N G F K',
            'PACKAGINGSELL' => 'P A C K A G I N G S E L L',
            'PACKAGINGUNIT' => 'P A C K A G I N G U N I T',
            'PAYPERMISSION' => 'P A Y P E R M I S S I O N',
            'PETIMEMAX' => 'P E T I M E M A X',
            'PLNO' => 'P L N O',
            'POSDAT' => 'P O S D A T',
            'POSDOC0' => 'P O S D O C0',
            'POSDOC1' => 'P O S D O C1',
            'POSDOC2' => 'P O S D O C2',
            'POSDOC3' => 'P O S D O C3',
            'POSIDENT' => 'P O S I D E N T',
            'POSIDNAM' => 'P O S I D N A M',
            'POSIDNO' => 'P O S I D N O',
            'POSINF' => 'P O S I N F',
            'POSLIEF0' => 'P O S L I E F0',
            'POSLIEF1' => 'P O S L I E F1',
            'POSLIEF2' => 'P O S L I E F2',
            'POSLIEF3' => 'P O S L I E F3',
            'POSLIEF4' => 'P O S L I E F4',
            'POSLIEF5' => 'P O S L I E F5',
            'POSPRT0' => 'P O S P R T0',
            'POSPRT1' => 'P O S P R T1',
            'POSPRT2' => 'P O S P R T2',
            'POSTART' => 'P O S T A R T',
            'POSTEXT' => 'P O S T E X T',
            'POSTNAME' => 'P O S T N A M E',
            'POSTNO' => 'P O S T N O',
            'POSTYP' => 'P O S T Y P',
            'RPOSDAT' => 'R P O S D A T',
            'PRINTQUANTITY' => 'P R I N T Q U A N T I T Y',
            'PROJECT' => 'P R O J E C T',
            'PROJNAME' => 'P R O J N A M E',
            'PSTIMEMIN' => 'P S T I M E M I N',
            'PTYP' => 'P T Y P',
            'RABATT' => 'R A B A T T',
            'REVENUEACC' => 'R E V E N U E A C C',
            'SEPARATESETUPCOSTS' => 'S E P A R A T E S E T U P C O S T S',
            'VERTID' => 'V E R T I D',
            'VERTRNAME' => 'V E R T R N A M E',
            'VKCNTRYSIGN' => 'V K C N T R Y S I G N',
            'VKCNTRYSIGNF' => 'V K C N T R Y S I G N F',
            'VKUMRECHFAKT' => 'V K U M R E C H F A K T',
            'VKUMRECHFAKTF' => 'V K U M R E C H F A K T F',
            'VKWAEHRUNG' => 'V K W A E H R U N G',
            'VKWAEHRUNGF' => 'V K W A E H R U N G F',
            'VPROV' => 'V P R O V',
            'VPROVABS' => 'V P R O V A B S',
            'VRABATT' => 'V R A B A T T',
            'VRABATTABS' => 'V R A B A T T A B S',
            'CNAME' => 'C N A M E',
            'CHNAME' => 'C H N A M E',
            'CDATE' => 'C D A T E',
            'CHDATE' => 'C H D A T E',
            'MANDANTNO' => 'M A N D A N T N O',
            'VAT' => 'V A T',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPANO($id)
    {
        return Pa_posit::findOne($id)->PANO;
    }

    public function getPaperPosits($id)
    {
        $query = $this->find()->where(['PANO'=>$id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

				return $dataProvider;
    }
    public function getDocumentStatus($id)
    {
      // Belegstatus prüfen und zurückgeben.


      // Wenn alle bisher geliefert Werte gleich Null sind
      // und nirgends Teillieferung gespeichert wurde,
      // ist der BelegStatus offen = 0

      // Wenn alle bisher geliefert Werte größer Null sind
      // und nirgends Teillieferung gespeichert wurde,
      // ist der BelegStatus fertig = 2
      $countPositionen = Pa_posit::find()
        ->where(['PANO' => $id])
        ->andWhere(['not',['MENGE'=>0]])
        ->count();

      $countFertig = Pa_posit::find()
        ->where(['PANO' => $id])
        ->andWhere(['>','POSLIEF0',  0])
        ->andWhere(['POSPRT0' => 0 ])
        ->count();

      $countOffen = Pa_posit::find()
        ->where(['PANO' => $id])
        ->andWhere(['POSLIEF0' => 0])
        ->andWhere(['POSPRT0' => 0])
        ->count();

        $documentStatus = ($countPositionen == $countOffen) ? 0 : (($countPositionen == $countFertig) ? 2 : 1);
        return $documentStatus;
    }

    public function donePosition($id)
    {
      $paPositModel = Pa_posit::findOne($id);
      $paPositModel->POSLIEF0 = $paPositModel->MENGE;
      $paPositModel->POSPRT0 = 0;

      if($paPositModel->save(false)) return true;
    }


    public function doneAll($PANO)
    {
      $paPositModels = Pa_posit::find()->where(['PANO'=>$PANO])->all();
      foreach ($paPositModels as $key => $value) {
        if($value['MENGE'] != 0) Pa_posit::donePosition($value['PONO']);
      }
      return true;
    }

    public function beforeSave($insert)
    {

      // Wird ein "bisher geliefert"-Wert auf null gesetzt, muss auch
      // der dazugehörige Teillieferungswert auf null gesetzt werden;
      if ($this->POSLIEF0 == 0) $this->POSPRT0 = 0;
      $this->CHDATE = date('d.m.Y H:i:s');
      $this->CHNAME = Yii::$app->user->identity->firstname.' '.Yii::$app->user->identity->surename;

      return true;
    }

}
