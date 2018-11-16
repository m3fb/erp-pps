<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "OR_OP".
 *
 * @property string $NO
 * @property string $ORNO
 * @property string $NAME
 * @property string $DESCR
 * @property string $APARTS
 * @property string $ATE
 * @property string $ATOTAL
 * @property string $AWPLACE
 * @property string $BPARTS
 * @property string $CFLAG
 * @property string $CHTIME
 * @property string $CPCOST
 * @property string $CPPARTS
 * @property string $CPTIME
 * @property string $CRCOST
 * @property string $CRPARTS
 * @property string $CRTIME
 * @property string $CTIME
 * @property string $DCTIM00
 * @property string $DCTIM01
 * @property string $DCTIM02
 * @property string $DCTIM03
 * @property string $DCTIM04
 * @property string $DCTIM05
 * @property string $DCTIM06
 * @property string $DCTIM07
 * @property string $DCTIM08
 * @property string $DCTIM09
 * @property string $DCTIM10
 * @property string $DCTIM11
 * @property string $DCTIM12
 * @property string $DCTIM13
 * @property string $DCTIM14
 * @property string $DCTIM15
 * @property string $DIRECTIONZ
 * @property string $DIV1ETIME
 * @property string $DIV1MISSING
 * @property string $DIV1REMARK
 * @property string $DIV1STIME
 * @property string $DIV2ETIME
 * @property string $DIV2MISSING
 * @property string $DIV2REMARK
 * @property string $DIV2STIME
 * @property string $DRAWNO
 * @property string $EFFICIENCY
 * @property string $EFFICIENCY2
 * @property string $EINLAST
 * @property string $ENDESEC
 * @property string $ERROR
 * @property string $ETIME
 * @property string $FIXETIME
 * @property string $FIXMISSING
 * @property string $FIXREMARK
 * @property string $FIXSTIME
 * @property string $GCOST
 * @property string $HPGLFILE
 * @property string $INCOMING
 * @property string $KOPATE
 * @property string $KOPPTE
 * @property string $KOPPTR
 * @property string $MATERIAL
 * @property string $MATETIME
 * @property string $MATMISSING
 * @property string $MATREMARK
 * @property string $MATSTIME
 * @property string $MDCNOTREQUIRED
 * @property string $MENGE1
 * @property string $MENGE2
 * @property string $MENGE3
 * @property string $MENGE4
 * @property string $MENGE5
 * @property string $MENGE6
 * @property string $MINPRICE
 * @property string $MULTIMESSAGEGROUP
 * @property string $NCPROG
 * @property string $OPDOC0
 * @property string $OPDOC1
 * @property string $OPDOC2
 * @property string $OPINFO
 * @property string $OPPRT0
 * @property string $OPPRT1
 * @property string $OPPRT2
 * @property string $OPSETP0
 * @property string $OPSETP1
 * @property string $OPSETP2
 * @property string $OPSETP3
 * @property string $ORDERED
 * @property string $OUT
 * @property string $OUTARTICLE
 * @property string $OUTCONO
 * @property string $OUTDCONO
 * @property string $OUTDDAY1
 * @property string $OUTDDAY2
 * @property string $OUTDDAY3
 * @property string $OUTDDAY4
 * @property string $OUTDDAY5
 * @property string $OUTDDAY6
 * @property string $OUTDDAY7
 * @property string $OUTEINHEIT
 * @property string $OUTFAKTOR
 * @property string $OUTNAME
 * @property string $OUTORDERUNIT
 * @property string $OUTREMARK
 * @property string $OVERLAP
 * @property string $OVERLAPDIFF
 * @property string $OVERLAPDIST
 * @property string $OVERLAPPERC
 * @property string $PARTNO
 * @property string $PARTSPH
 * @property string $PETIMEMAX
 * @property string $PETIMEMIN
 * @property string $PLEND
 * @property string $PLSTART
 * @property string $PMA
 * @property string $PMAGRP
 * @property string $POSTNO
 * @property string $PPARTS
 * @property string $PPSEND
 * @property string $PPSSTART
 * @property string $PREIS1
 * @property string $PREIS2
 * @property string $PREIS3
 * @property string $PREIS4
 * @property string $PREIS5
 * @property string $PREIS6
 * @property string $PRENO
 * @property string $PREPETIME
 * @property string $PREPMISSING
 * @property string $PREPREMARK
 * @property string $PREPSTIME
 * @property string $PRIO
 * @property string $PRMTBNO
 * @property string $PRMVPE
 * @property string $PROBLEM
 * @property string $PRODUCTIONSTATE
 * @property string $PSETUP
 * @property string $PSTIMEMAX
 * @property string $PSTIMEMIN
 * @property string $PTE
 * @property string $PTFAULT
 * @property string $PTG
 * @property string $PTH
 * @property string $PTIME
 * @property string $PTPROD
 * @property string $PTR
 * @property string $PTRA
 * @property string $PTTRANS
 * @property string $PTWAIT
 * @property string $PWPLACE
 * @property string $RELOP
 * @property string $RELORD
 * @property string $REQUESTDATE
 * @property string $RLPRICE
 * @property string $ROTATIONZ
 * @property string $SCNO
 * @property string $SEQNUM
 * @property string $SETUPCOSTS
 * @property string $SOURCE
 * @property string $SPECIAL
 * @property string $SPLITSRC
 * @property string $SPLITSRCROOT
 * @property string $STARTSEC
 * @property string $STATUS
 * @property string $STIME
 * @property string $STNO
 * @property string $SUPPLIED
 * @property string $SURFACE
 * @property string $TECHNOLOGY
 * @property string $TGCOST
 * @property string $TOOLETIME
 * @property string $TOOLMISSING
 * @property string $TOOLREMARK
 * @property string $TOOLSTIME
 * @property string $USR
 * @property string $WEIGHT
 * @property string $CNAME
 * @property string $CHNAME
 * @property string $CDATE
 * @property string $CHDATE
 * @property string $MANDANTNO
 * @property string $TSTAMP
 * @property string $MENGE7
 * @property string $MENGE8
 * @property string $MENGE9
 * @property string $MENGE10
 * @property string $MENGE11
 * @property string $MENGE12
 * @property string $MENGE13
 * @property string $MENGE14
 * @property string $MENGE15
 * @property string $PREIS7
 * @property string $PREIS8
 * @property string $PREIS9
 * @property string $PREIS10
 * @property string $PREIS11
 * @property string $PREIS12
 * @property string $PREIS13
 * @property string $PREIS14
 * @property string $PREIS15
 * @property string $EXTWORKCAPACITYRESOURCE
 * @property string $ARDORGRESOURCE
 * @property string $SPEEDMODE
 * @property string $PALID
 *
 * @property ORORDER $oRNO
 */
class Or_op extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'OR_OP';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['NO', 'ORNO', 'CFLAG', 'STATUS', 'TSTAMP'], 'required'],
            [['NO', 'ORNO', 'APARTS', 'ATE', 'ATOTAL', 'AWPLACE', 'BPARTS', 'CFLAG', 'CPCOST', 'CPPARTS', 'CPTIME', 'CRCOST', 'CRPARTS', 'CRTIME', 'DCTIM00', 'DCTIM01', 'DCTIM02', 'DCTIM03', 'DCTIM04', 'DCTIM05', 'DCTIM06', 'DCTIM07', 'DCTIM08', 'DCTIM09', 'DCTIM10', 'DCTIM11', 'DCTIM12', 'DCTIM13', 'DCTIM14', 'DCTIM15', 'DIRECTIONZ', 'DIV1MISSING', 'DIV2MISSING', 'EFFICIENCY', 'EFFICIENCY2', 'EINLAST', 'ENDESEC', 'ERROR', 'FIXMISSING', 'GCOST', 'INCOMING', 'KOPATE', 'KOPPTE', 'KOPPTR', 'MATMISSING', 'MDCNOTREQUIRED', 'MENGE1', 'MENGE2', 'MENGE3', 'MENGE4', 'MENGE5', 'MENGE6', 'MINPRICE', 'MULTIMESSAGEGROUP', 'OPPRT0', 'OPPRT1', 'OPPRT2', 'OPSETP0', 'OPSETP1', 'OPSETP2', 'OPSETP3', 'ORDERED', 'OUT', 'OUTARTICLE', 'OUTCONO', 'OUTDCONO', 'OUTDDAY1', 'OUTDDAY2', 'OUTDDAY3', 'OUTDDAY4', 'OUTDDAY5', 'OUTDDAY6', 'OUTDDAY7', 'OUTEINHEIT', 'OUTFAKTOR', 'OUTORDERUNIT', 'OVERLAP', 'OVERLAPDIFF', 'OVERLAPDIST', 'OVERLAPPERC', 'PARTSPH', 'PLEND', 'PLSTART', 'PMA', 'PMAGRP', 'POSTNO', 'PPARTS', 'PREIS1', 'PREIS2', 'PREIS3', 'PREIS4', 'PREIS5', 'PREIS6', 'PRENO', 'PREPMISSING', 'PRIO', 'PRMTBNO', 'PRMVPE', 'PROBLEM', 'PRODUCTIONSTATE', 'PSETUP', 'PTE', 'PTFAULT', 'PTG', 'PTH', 'PTPROD', 'PTR', 'PTRA', 'PTTRANS', 'PTWAIT', 'PWPLACE', 'RLPRICE', 'ROTATIONZ', 'SCNO', 'SEQNUM', 'SETUPCOSTS', 'SOURCE', 'SPECIAL', 'SPLITSRC', 'SPLITSRCROOT', 'STARTSEC', 'STATUS', 'STNO', 'SUPPLIED', 'SURFACE', 'TECHNOLOGY', 'TGCOST', 'TOOLMISSING', 'WEIGHT', 'MANDANTNO', 'MENGE7', 'MENGE8', 'MENGE9', 'MENGE10', 'MENGE11', 'MENGE12', 'MENGE13', 'MENGE14', 'MENGE15', 'PREIS7', 'PREIS8', 'PREIS9', 'PREIS10', 'PREIS11', 'PREIS12', 'PREIS13', 'PREIS14', 'PREIS15', 'SPEEDMODE'], 'number'],
            [['NAME', 'DESCR', 'DIV1REMARK', 'DIV2REMARK', 'DRAWNO', 'FIXREMARK', 'HPGLFILE', 'MATERIAL', 'MATREMARK', 'NCPROG', 'OPDOC0', 'OPDOC1', 'OPDOC2', 'OPINFO', 'OUTNAME', 'OUTREMARK', 'PARTNO', 'PREPREMARK', 'RELOP', 'RELORD', 'TOOLREMARK', 'USR', 'CNAME', 'CHNAME', 'EXTWORKCAPACITYRESOURCE', 'ARDORGRESOURCE', 'PALID'], 'string'],
            [['CHTIME', 'CTIME', 'DIV1ETIME', 'DIV1STIME', 'DIV2ETIME', 'DIV2STIME', 'ETIME', 'FIXETIME', 'FIXSTIME', 'MATETIME', 'MATSTIME', 'PETIMEMAX', 'PETIMEMIN', 'PPSEND', 'PPSSTART', 'PREPETIME', 'PREPSTIME', 'PSTIMEMAX', 'PSTIMEMIN', 'PTIME', 'REQUESTDATE', 'STIME', 'TOOLETIME', 'TOOLSTIME', 'CDATE', 'CHDATE', 'TSTAMP'], 'safe'],
            [['NAME', 'ORNO'], 'unique', 'targetAttribute' => ['NAME', 'ORNO']],
            [['NO'], 'unique'],
            [['ORNO'], 'exist', 'skipOnError' => true, 'targetClass' => ORORDER::className(), 'targetAttribute' => ['ORNO' => 'NO']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'NO' => 'N O',
            'ORNO' => 'O R N O',
            'NAME' => 'N A M E',
            'DESCR' => 'D E S C R',
            'APARTS' => 'A P A R T S',
            'ATE' => 'A T E',
            'ATOTAL' => 'A T O T A L',
            'AWPLACE' => 'A W P L A C E',
            'BPARTS' => 'B P A R T S',
            'CFLAG' => 'C F L A G',
            'CHTIME' => 'C H T I M E',
            'CPCOST' => 'C P C O S T',
            'CPPARTS' => 'C P P A R T S',
            'CPTIME' => 'C P T I M E',
            'CRCOST' => 'C R C O S T',
            'CRPARTS' => 'C R P A R T S',
            'CRTIME' => 'C R T I M E',
            'CTIME' => 'C T I M E',
            'DCTIM00' => 'D C T I M00',
            'DCTIM01' => 'D C T I M01',
            'DCTIM02' => 'D C T I M02',
            'DCTIM03' => 'D C T I M03',
            'DCTIM04' => 'D C T I M04',
            'DCTIM05' => 'D C T I M05',
            'DCTIM06' => 'D C T I M06',
            'DCTIM07' => 'D C T I M07',
            'DCTIM08' => 'D C T I M08',
            'DCTIM09' => 'D C T I M09',
            'DCTIM10' => 'D C T I M10',
            'DCTIM11' => 'D C T I M11',
            'DCTIM12' => 'D C T I M12',
            'DCTIM13' => 'D C T I M13',
            'DCTIM14' => 'D C T I M14',
            'DCTIM15' => 'D C T I M15',
            'DIRECTIONZ' => 'D I R E C T I O N Z',
            'DIV1ETIME' => 'D I V1 E T I M E',
            'DIV1MISSING' => 'D I V1 M I S S I N G',
            'DIV1REMARK' => 'D I V1 R E M A R K',
            'DIV1STIME' => 'D I V1 S T I M E',
            'DIV2ETIME' => 'D I V2 E T I M E',
            'DIV2MISSING' => 'D I V2 M I S S I N G',
            'DIV2REMARK' => 'D I V2 R E M A R K',
            'DIV2STIME' => 'D I V2 S T I M E',
            'DRAWNO' => 'D R A W N O',
            'EFFICIENCY' => 'E F F I C I E N C Y',
            'EFFICIENCY2' => 'E F F I C I E N C Y2',
            'EINLAST' => 'E I N L A S T',
            'ENDESEC' => 'E N D E S E C',
            'ERROR' => 'E R R O R',
            'ETIME' => 'E T I M E',
            'FIXETIME' => 'F I X E T I M E',
            'FIXMISSING' => 'F I X M I S S I N G',
            'FIXREMARK' => 'F I X R E M A R K',
            'FIXSTIME' => 'F I X S T I M E',
            'GCOST' => 'G C O S T',
            'HPGLFILE' => 'H P G L F I L E',
            'INCOMING' => 'I N C O M I N G',
            'KOPATE' => 'K O P A T E',
            'KOPPTE' => 'K O P P T E',
            'KOPPTR' => 'K O P P T R',
            'MATERIAL' => 'M A T E R I A L',
            'MATETIME' => 'M A T E T I M E',
            'MATMISSING' => 'M A T M I S S I N G',
            'MATREMARK' => 'M A T R E M A R K',
            'MATSTIME' => 'M A T S T I M E',
            'MDCNOTREQUIRED' => 'M D C N O T R E Q U I R E D',
            'MENGE1' => 'M E N G E1',
            'MENGE2' => 'M E N G E2',
            'MENGE3' => 'M E N G E3',
            'MENGE4' => 'M E N G E4',
            'MENGE5' => 'M E N G E5',
            'MENGE6' => 'M E N G E6',
            'MINPRICE' => 'M I N P R I C E',
            'MULTIMESSAGEGROUP' => 'M U L T I M E S S A G E G R O U P',
            'NCPROG' => 'N C P R O G',
            'OPDOC0' => 'O P D O C0',
            'OPDOC1' => 'O P D O C1',
            'OPDOC2' => 'O P D O C2',
            'OPINFO' => 'O P I N F O',
            'OPPRT0' => 'O P P R T0',
            'OPPRT1' => 'O P P R T1',
            'OPPRT2' => 'O P P R T2',
            'OPSETP0' => 'O P S E T P0',
            'OPSETP1' => 'O P S E T P1',
            'OPSETP2' => 'O P S E T P2',
            'OPSETP3' => 'O P S E T P3',
            'ORDERED' => 'O R D E R E D',
            'OUT' => 'O U T',
            'OUTARTICLE' => 'O U T A R T I C L E',
            'OUTCONO' => 'O U T C O N O',
            'OUTDCONO' => 'O U T D C O N O',
            'OUTDDAY1' => 'O U T D D A Y1',
            'OUTDDAY2' => 'O U T D D A Y2',
            'OUTDDAY3' => 'O U T D D A Y3',
            'OUTDDAY4' => 'O U T D D A Y4',
            'OUTDDAY5' => 'O U T D D A Y5',
            'OUTDDAY6' => 'O U T D D A Y6',
            'OUTDDAY7' => 'O U T D D A Y7',
            'OUTEINHEIT' => 'O U T E I N H E I T',
            'OUTFAKTOR' => 'O U T F A K T O R',
            'OUTNAME' => 'O U T N A M E',
            'OUTORDERUNIT' => 'O U T O R D E R U N I T',
            'OUTREMARK' => 'O U T R E M A R K',
            'OVERLAP' => 'O V E R L A P',
            'OVERLAPDIFF' => 'O V E R L A P D I F F',
            'OVERLAPDIST' => 'O V E R L A P D I S T',
            'OVERLAPPERC' => 'O V E R L A P P E R C',
            'PARTNO' => 'P A R T N O',
            'PARTSPH' => 'P A R T S P H',
            'PETIMEMAX' => 'P E T I M E M A X',
            'PETIMEMIN' => 'P E T I M E M I N',
            'PLEND' => 'P L E N D',
            'PLSTART' => 'P L S T A R T',
            'PMA' => 'P M A',
            'PMAGRP' => 'P M A G R P',
            'POSTNO' => 'P O S T N O',
            'PPARTS' => 'P P A R T S',
            'PPSEND' => 'P P S E N D',
            'PPSSTART' => 'P P S S T A R T',
            'PREIS1' => 'P R E I S1',
            'PREIS2' => 'P R E I S2',
            'PREIS3' => 'P R E I S3',
            'PREIS4' => 'P R E I S4',
            'PREIS5' => 'P R E I S5',
            'PREIS6' => 'P R E I S6',
            'PRENO' => 'P R E N O',
            'PREPETIME' => 'P R E P E T I M E',
            'PREPMISSING' => 'P R E P M I S S I N G',
            'PREPREMARK' => 'P R E P R E M A R K',
            'PREPSTIME' => 'P R E P S T I M E',
            'PRIO' => 'P R I O',
            'PRMTBNO' => 'P R M T B N O',
            'PRMVPE' => 'P R M V P E',
            'PROBLEM' => 'P R O B L E M',
            'PRODUCTIONSTATE' => 'P R O D U C T I O N S T A T E',
            'PSETUP' => 'P S E T U P',
            'PSTIMEMAX' => 'P S T I M E M A X',
            'PSTIMEMIN' => 'P S T I M E M I N',
            'PTE' => 'P T E',
            'PTFAULT' => 'P T F A U L T',
            'PTG' => 'P T G',
            'PTH' => 'P T H',
            'PTIME' => 'P T I M E',
            'PTPROD' => 'P T P R O D',
            'PTR' => 'P T R',
            'PTRA' => 'P T R A',
            'PTTRANS' => 'P T T R A N S',
            'PTWAIT' => 'P T W A I T',
            'PWPLACE' => 'P W P L A C E',
            'RELOP' => 'R E L O P',
            'RELORD' => 'R E L O R D',
            'REQUESTDATE' => 'R E Q U E S T D A T E',
            'RLPRICE' => 'R L P R I C E',
            'ROTATIONZ' => 'R O T A T I O N Z',
            'SCNO' => 'S C N O',
            'SEQNUM' => 'S E Q N U M',
            'SETUPCOSTS' => 'S E T U P C O S T S',
            'SOURCE' => 'S O U R C E',
            'SPECIAL' => 'S P E C I A L',
            'SPLITSRC' => 'S P L I T S R C',
            'SPLITSRCROOT' => 'S P L I T S R C R O O T',
            'STARTSEC' => 'S T A R T S E C',
            'STATUS' => 'S T A T U S',
            'STIME' => 'S T I M E',
            'STNO' => 'S T N O',
            'SUPPLIED' => 'S U P P L I E D',
            'SURFACE' => 'S U R F A C E',
            'TECHNOLOGY' => 'T E C H N O L O G Y',
            'TGCOST' => 'T G C O S T',
            'TOOLETIME' => 'T O O L E T I M E',
            'TOOLMISSING' => 'T O O L M I S S I N G',
            'TOOLREMARK' => 'T O O L R E M A R K',
            'TOOLSTIME' => 'T O O L S T I M E',
            'USR' => 'U S R',
            'WEIGHT' => 'W E I G H T',
            'CNAME' => 'C N A M E',
            'CHNAME' => 'C H N A M E',
            'CDATE' => 'C D A T E',
            'CHDATE' => 'C H D A T E',
            'MANDANTNO' => 'M A N D A N T N O',
            'TSTAMP' => 'T S T A M P',
            'MENGE7' => 'M E N G E7',
            'MENGE8' => 'M E N G E8',
            'MENGE9' => 'M E N G E9',
            'MENGE10' => 'M E N G E10',
            'MENGE11' => 'M E N G E11',
            'MENGE12' => 'M E N G E12',
            'MENGE13' => 'M E N G E13',
            'MENGE14' => 'M E N G E14',
            'MENGE15' => 'M E N G E15',
            'PREIS7' => 'P R E I S7',
            'PREIS8' => 'P R E I S8',
            'PREIS9' => 'P R E I S9',
            'PREIS10' => 'P R E I S10',
            'PREIS11' => 'P R E I S11',
            'PREIS12' => 'P R E I S12',
            'PREIS13' => 'P R E I S13',
            'PREIS14' => 'P R E I S14',
            'PREIS15' => 'P R E I S15',
            'EXTWORKCAPACITYRESOURCE' => 'E X T W O R K C A P A C I T Y R E S O U R C E',
            'ARDORGRESOURCE' => 'A R D O R G R E S O U R C E',
            'SPEEDMODE' => 'S P E E D M O D E',
            'PALID' => 'P A L I D',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getORNO()
    {
        return $this->hasOne(ORORDER::className(), ['NO' => 'ORNO']);
    }
}
