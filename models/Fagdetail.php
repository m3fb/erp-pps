<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "FAG_DETAIL".
 *
 * @property string $NO
 * @property string $FKNO
 * @property string $TYP
 * @property string $NAME
 * @property string $INTERNAL
 * @property string $TEMPLATE
 * @property string $SHOWONSTARTUP
 * @property string $TEXTLABEL
 * @property string $TEXTTEXT
 * @property string $LANGUAGE
 * @property string $DAT01
 * @property string $DAT02
 * @property string $DAT03
 * @property string $DAT04
 * @property string $DAT05
 * @property string $DAT06
 * @property string $DAT07
 * @property string $DAT08
 * @property string $DAT09
 * @property string $DAT10
 * @property string $DAT11
 * @property string $DAT12
 * @property string $DAT13
 * @property string $DAT14
 * @property string $DAT15
 * @property string $DAT16
 * @property string $DAT17
 * @property string $DAT18
 * @property string $DAT19
 * @property string $DAT20
 * @property string $DAT21
 * @property string $DAT22
 * @property string $DAT23
 * @property string $DAT24
 * @property string $DAT25
 * @property string $DAT26
 * @property string $DAT27
 * @property string $DAT28
 * @property string $DAT29
 * @property string $DAT30
 * @property string $DAT31
 * @property string $DAT32
 * @property string $DAT33
 * @property string $DAT34
 * @property string $DAT35
 * @property string $DAT36
 * @property string $DAT37
 * @property string $DAT38
 * @property string $DAT39
 * @property string $DAT40
 * @property string $DAT41
 * @property string $DAT42
 * @property string $DAT43
 * @property string $DAT44
 * @property string $DAT45
 * @property string $DAT46
 * @property string $DAT47
 * @property string $DAT48
 * @property string $DAT49
 * @property string $DAT50
 * @property string $DAT51
 * @property string $DAT52
 * @property string $DAT53
 * @property string $DAT54
 * @property string $DAT55
 * @property string $DAT56
 * @property string $DAT57
 * @property string $DAT58
 * @property string $DAT59
 * @property string $DAT60
 * @property string $DAT61
 * @property string $DAT62
 * @property string $DAT63
 * @property string $DAT64
 * @property string $DAT65
 * @property string $DAT66
 * @property string $DAT67
 * @property string $DAT68
 * @property string $DAT69
 * @property string $DAT70
 * @property string $DAT71
 * @property string $DAT72
 * @property string $DAT73
 * @property string $DAT74
 * @property string $DAT75
 * @property string $DAT76
 * @property string $DAT77
 * @property string $DAT78
 * @property string $DAT79
 * @property string $DAT80
 * @property string $DAT81
 * @property string $DAT82
 * @property string $DAT83
 * @property string $DAT84
 * @property string $DAT85
 * @property string $DAT86
 * @property string $DAT87
 * @property string $DAT88
 * @property string $DAT89
 * @property string $DAT90
 * @property string $DAT91
 * @property string $DAT92
 * @property string $DAT93
 * @property string $DAT94
 * @property string $DAT95
 * @property string $DAT96
 * @property string $DAT97
 * @property string $DAT98
 * @property string $DAT99
 * @property string $DAT100
 * @property string $TXT01
 * @property string $TXT02
 * @property string $TXT03
 * @property string $TXT04
 * @property string $TXT05
 * @property string $TXT06
 * @property string $TXT07
 * @property string $TXT08
 * @property string $TXT09
 * @property string $TXT10
 * @property string $TXT11
 * @property string $TXT12
 * @property string $TXT13
 * @property string $TXT14
 * @property string $TXT15
 * @property string $TXT16
 * @property string $TXT17
 * @property string $TXT18
 * @property string $TXT19
 * @property string $TXT20
 * @property string $TXT21
 * @property string $TXT22
 * @property string $TXT23
 * @property string $TXT24
 * @property string $TXT25
 * @property string $TXT26
 * @property string $TXT27
 * @property string $TXT28
 * @property string $TXT29
 * @property string $TXT30
 * @property string $TXT31
 * @property string $TXT32
 * @property string $TXT33
 * @property string $TXT34
 * @property string $TXT35
 * @property string $TXT36
 * @property string $TXT37
 * @property string $TXT38
 * @property string $TXT39
 * @property string $TXT40
 * @property string $TXT41
 * @property string $TXT42
 * @property string $TXT43
 * @property string $TXT44
 * @property string $TXT45
 * @property string $TXT46
 * @property string $TXT47
 * @property string $TXT48
 * @property string $TXT49
 * @property string $TXT50
 * @property string $TXT51
 * @property string $TXT52
 * @property string $TXT53
 * @property string $TXT54
 * @property string $TXT55
 * @property string $TXT56
 * @property string $TXT57
 * @property string $TXT58
 * @property string $TXT59
 * @property string $TXT60
 * @property string $TXT61
 * @property string $TXT62
 * @property string $TXT63
 * @property string $TXT64
 * @property string $TXT65
 * @property string $TXT66
 * @property string $TXT67
 * @property string $TXT68
 * @property string $TXT69
 * @property string $TXT70
 * @property string $TXT71
 * @property string $TXT72
 * @property string $TXT73
 * @property string $TXT74
 * @property string $TXT75
 * @property string $TXT76
 * @property string $TXT77
 * @property string $TXT78
 * @property string $TXT79
 * @property string $TXT80
 * @property string $TXT81
 * @property string $TXT82
 * @property string $TXT83
 * @property string $TXT84
 * @property string $TXT85
 * @property string $TXT86
 * @property string $TXT87
 * @property string $TXT88
 * @property string $TXT89
 * @property string $TXT90
 * @property string $TXT91
 * @property string $TXT92
 * @property string $TXT93
 * @property string $TXT94
 * @property string $TXT95
 * @property string $TXT96
 * @property string $TXT97
 * @property string $TXT98
 * @property string $TXT99
 * @property string $TXT100
 * @property string $VAL01
 * @property string $VAL02
 * @property string $VAL03
 * @property string $VAL04
 * @property string $VAL05
 * @property string $VAL06
 * @property string $VAL07
 * @property string $VAL08
 * @property string $VAL09
 * @property string $VAL10
 * @property string $VAL11
 * @property string $VAL12
 * @property string $VAL13
 * @property string $VAL14
 * @property string $VAL15
 * @property string $VAL16
 * @property string $VAL17
 * @property string $VAL18
 * @property string $VAL19
 * @property string $VAL20
 * @property string $VAL21
 * @property string $VAL22
 * @property string $VAL23
 * @property string $VAL24
 * @property string $VAL25
 * @property string $VAL26
 * @property string $VAL27
 * @property string $VAL28
 * @property string $VAL29
 * @property string $VAL30
 * @property string $VAL31
 * @property string $VAL32
 * @property string $VAL33
 * @property string $VAL34
 * @property string $VAL35
 * @property string $VAL36
 * @property string $VAL37
 * @property string $VAL38
 * @property string $VAL39
 * @property string $VAL40
 * @property string $VAL41
 * @property string $VAL42
 * @property string $VAL43
 * @property string $VAL44
 * @property string $VAL45
 * @property string $VAL46
 * @property string $VAL47
 * @property string $VAL48
 * @property string $VAL49
 * @property string $VAL50
 * @property string $VAL51
 * @property string $VAL52
 * @property string $VAL53
 * @property string $VAL54
 * @property string $VAL55
 * @property string $VAL56
 * @property string $VAL57
 * @property string $VAL58
 * @property string $VAL59
 * @property string $VAL60
 * @property string $VAL61
 * @property string $VAL62
 * @property string $VAL63
 * @property string $VAL64
 * @property string $VAL65
 * @property string $VAL66
 * @property string $VAL67
 * @property string $VAL68
 * @property string $VAL69
 * @property string $VAL70
 * @property string $VAL71
 * @property string $VAL72
 * @property string $VAL73
 * @property string $VAL74
 * @property string $VAL75
 * @property string $VAL76
 * @property string $VAL77
 * @property string $VAL78
 * @property string $VAL79
 * @property string $VAL80
 * @property string $VAL81
 * @property string $VAL82
 * @property string $VAL83
 * @property string $VAL84
 * @property string $VAL85
 * @property string $VAL86
 * @property string $VAL87
 * @property string $VAL88
 * @property string $VAL89
 * @property string $VAL90
 * @property string $VAL91
 * @property string $VAL92
 * @property string $VAL93
 * @property string $VAL94
 * @property string $VAL95
 * @property string $VAL96
 * @property string $VAL97
 * @property string $VAL98
 * @property string $VAL99
 * @property string $VAL100
 * @property string $CNAME
 * @property string $CHNAME
 * @property string $CDATE
 * @property string $CHDATE
 * @property string $MANDANTNO
 * @property string $TSTAMP
 */
class Fagdetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'FAG_DETAIL';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NO', 'FKNO', 'TYP', 'TSTAMP'], 'required'],
            [['NO', 'FKNO', 'TYP', 'INTERNAL', 'TEMPLATE', 'SHOWONSTARTUP', 'VAL01', 'VAL02', 'VAL03', 'VAL04', 'VAL05', 'VAL06', 'VAL07', 'VAL08', 'VAL09', 'VAL10', 'VAL11', 'VAL12', 'VAL13', 'VAL14', 'VAL15', 'VAL16', 'VAL17', 'VAL18', 'VAL19', 'VAL20', 'VAL21', 'VAL22', 'VAL23', 'VAL24', 'VAL25', 'VAL26', 'VAL27', 'VAL28', 'VAL29', 'VAL30', 'VAL31', 'VAL32', 'VAL33', 'VAL34', 'VAL35', 'VAL36', 'VAL37', 'VAL38', 'VAL39', 'VAL40', 'VAL41', 'VAL42', 'VAL43', 'VAL44', 'VAL45', 'VAL46', 'VAL47', 'VAL48', 'VAL49', 'VAL50', 'VAL51', 'VAL52', 'VAL53', 'VAL54', 'VAL55', 'VAL56', 'VAL57', 'VAL58', 'VAL59', 'VAL60', 'VAL61', 'VAL62', 'VAL63', 'VAL64', 'VAL65', 'VAL66', 'VAL67', 'VAL68', 'VAL69', 'VAL70', 'VAL71', 'VAL72', 'VAL73', 'VAL74', 'VAL75', 'VAL76', 'VAL77', 'VAL78', 'VAL79', 'VAL80', 'VAL81', 'VAL82', 'VAL83', 'VAL84', 'VAL85', 'VAL86', 'VAL87', 'VAL88', 'VAL89', 'VAL90', 'VAL91', 'VAL92', 'VAL93', 'VAL94', 'VAL95', 'VAL96', 'VAL97', 'VAL98', 'VAL99', 'VAL100', 'MANDANTNO'], 'number'],
            [['NAME', 'TEXTLABEL', 'TEXTTEXT', 'LANGUAGE', 'TXT01', 'TXT02', 'TXT03', 'TXT04', 'TXT05', 'TXT06', 'TXT07', 'TXT08', 'TXT09', 'TXT10', 'TXT11', 'TXT12', 'TXT13', 'TXT14', 'TXT15', 'TXT16', 'TXT17', 'TXT18', 'TXT19', 'TXT20', 'TXT21', 'TXT22', 'TXT23', 'TXT24', 'TXT25', 'TXT26', 'TXT27', 'TXT28', 'TXT29', 'TXT30', 'TXT31', 'TXT32', 'TXT33', 'TXT34', 'TXT35', 'TXT36', 'TXT37', 'TXT38', 'TXT39', 'TXT40', 'TXT41', 'TXT42', 'TXT43', 'TXT44', 'TXT45', 'TXT46', 'TXT47', 'TXT48', 'TXT49', 'TXT50', 'TXT51', 'TXT52', 'TXT53', 'TXT54', 'TXT55', 'TXT56', 'TXT57', 'TXT58', 'TXT59', 'TXT60', 'TXT61', 'TXT62', 'TXT63', 'TXT64', 'TXT65', 'TXT66', 'TXT67', 'TXT68', 'TXT69', 'TXT70', 'TXT71', 'TXT72', 'TXT73', 'TXT74', 'TXT75', 'TXT76', 'TXT77', 'TXT78', 'TXT79', 'TXT80', 'TXT81', 'TXT82', 'TXT83', 'TXT84', 'TXT85', 'TXT86', 'TXT87', 'TXT88', 'TXT89', 'TXT90', 'TXT91', 'TXT92', 'TXT93', 'TXT94', 'TXT95', 'TXT96', 'TXT97', 'TXT98', 'TXT99', 'TXT100', 'CNAME', 'CHNAME'], 'string'],
            [['DAT01', 'DAT02', 'DAT03', 'DAT04', 'DAT05', 'DAT06', 'DAT07', 'DAT08', 'DAT09', 'DAT10', 'DAT11', 'DAT12', 'DAT13', 'DAT14', 'DAT15', 'DAT16', 'DAT17', 'DAT18', 'DAT19', 'DAT20', 'DAT21', 'DAT22', 'DAT23', 'DAT24', 'DAT25', 'DAT26', 'DAT27', 'DAT28', 'DAT29', 'DAT30', 'DAT31', 'DAT32', 'DAT33', 'DAT34', 'DAT35', 'DAT36', 'DAT37', 'DAT38', 'DAT39', 'DAT40', 'DAT41', 'DAT42', 'DAT43', 'DAT44', 'DAT45', 'DAT46', 'DAT47', 'DAT48', 'DAT49', 'DAT50', 'DAT51', 'DAT52', 'DAT53', 'DAT54', 'DAT55', 'DAT56', 'DAT57', 'DAT58', 'DAT59', 'DAT60', 'DAT61', 'DAT62', 'DAT63', 'DAT64', 'DAT65', 'DAT66', 'DAT67', 'DAT68', 'DAT69', 'DAT70', 'DAT71', 'DAT72', 'DAT73', 'DAT74', 'DAT75', 'DAT76', 'DAT77', 'DAT78', 'DAT79', 'DAT80', 'DAT81', 'DAT82', 'DAT83', 'DAT84', 'DAT85', 'DAT86', 'DAT87', 'DAT88', 'DAT89', 'DAT90', 'DAT91', 'DAT92', 'DAT93', 'DAT94', 'DAT95', 'DAT96', 'DAT97', 'DAT98', 'DAT99', 'DAT100', 'CDATE', 'CHDATE', 'TSTAMP'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'NO' => 'No',
            'FKNO' => 'Fkno',
            'TYP' => 'Typ',
            'NAME' => 'Name',
            'INTERNAL' => 'Internal',
            'TEMPLATE' => 'Template',
            'SHOWONSTARTUP' => 'Showonstartup',
            'TEXTLABEL' => 'Textlabel',
            'TEXTTEXT' => 'Texttext',
            'LANGUAGE' => 'Language',
            'DAT01' => 'Dat01',
            'DAT02' => 'Dat02',
            'DAT03' => 'Dat03',
            'DAT04' => 'Dat04',
            'DAT05' => 'Dat05',
            'DAT06' => 'Dat06',
            'DAT07' => 'Dat07',
            'DAT08' => 'Dat08',
            'DAT09' => 'Dat09',
            'DAT10' => 'Dat10',
            'DAT11' => 'Dat11',
            'DAT12' => 'Dat12',
            'DAT13' => 'Dat13',
            'DAT14' => 'Dat14',
            'DAT15' => 'Dat15',
            'DAT16' => 'Dat16',
            'DAT17' => 'Dat17',
            'DAT18' => 'Dat18',
            'DAT19' => 'Dat19',
            'DAT20' => 'Dat20',
            'DAT21' => 'Dat21',
            'DAT22' => 'Dat22',
            'DAT23' => 'Dat23',
            'DAT24' => 'Dat24',
            'DAT25' => 'Dat25',
            'DAT26' => 'Dat26',
            'DAT27' => 'Dat27',
            'DAT28' => 'Dat28',
            'DAT29' => 'Dat29',
            'DAT30' => 'Dat30',
            'DAT31' => 'Dat31',
            'DAT32' => 'Dat32',
            'DAT33' => 'Dat33',
            'DAT34' => 'Dat34',
            'DAT35' => 'Dat35',
            'DAT36' => 'Dat36',
            'DAT37' => 'Dat37',
            'DAT38' => 'Dat38',
            'DAT39' => 'Dat39',
            'DAT40' => 'Dat40',
            'DAT41' => 'Dat41',
            'DAT42' => 'Dat42',
            'DAT43' => 'Dat43',
            'DAT44' => 'Dat44',
            'DAT45' => 'Dat45',
            'DAT46' => 'Dat46',
            'DAT47' => 'Dat47',
            'DAT48' => 'Dat48',
            'DAT49' => 'Dat49',
            'DAT50' => 'Dat50',
            'DAT51' => 'Dat51',
            'DAT52' => 'Dat52',
            'DAT53' => 'Dat53',
            'DAT54' => 'Dat54',
            'DAT55' => 'Dat55',
            'DAT56' => 'Dat56',
            'DAT57' => 'Dat57',
            'DAT58' => 'Dat58',
            'DAT59' => 'Dat59',
            'DAT60' => 'Dat60',
            'DAT61' => 'Dat61',
            'DAT62' => 'Dat62',
            'DAT63' => 'Dat63',
            'DAT64' => 'Dat64',
            'DAT65' => 'Dat65',
            'DAT66' => 'Dat66',
            'DAT67' => 'Dat67',
            'DAT68' => 'Dat68',
            'DAT69' => 'Dat69',
            'DAT70' => 'Dat70',
            'DAT71' => 'Dat71',
            'DAT72' => 'Dat72',
            'DAT73' => 'Dat73',
            'DAT74' => 'Dat74',
            'DAT75' => 'Dat75',
            'DAT76' => 'Dat76',
            'DAT77' => 'Dat77',
            'DAT78' => 'Dat78',
            'DAT79' => 'Dat79',
            'DAT80' => 'Dat80',
            'DAT81' => 'Dat81',
            'DAT82' => 'Dat82',
            'DAT83' => 'Dat83',
            'DAT84' => 'Dat84',
            'DAT85' => 'Dat85',
            'DAT86' => 'Dat86',
            'DAT87' => 'Dat87',
            'DAT88' => 'Dat88',
            'DAT89' => 'Dat89',
            'DAT90' => 'Dat90',
            'DAT91' => 'Dat91',
            'DAT92' => 'Dat92',
            'DAT93' => 'Dat93',
            'DAT94' => 'Dat94',
            'DAT95' => 'Dat95',
            'DAT96' => 'Dat96',
            'DAT97' => 'Dat97',
            'DAT98' => 'Dat98',
            'DAT99' => 'Dat99',
            'DAT100' => 'Dat100',
            'TXT01' => 'Txt01',
            'TXT02' => 'Txt02',
            'TXT03' => 'Txt03',
            'TXT04' => 'Txt04',
            'TXT05' => 'Txt05',
            'TXT06' => 'Txt06',
            'TXT07' => 'Txt07',
            'TXT08' => 'Txt08',
            'TXT09' => 'Txt09',
            'TXT10' => 'Txt10',
            'TXT11' => 'Txt11',
            'TXT12' => 'Txt12',
            'TXT13' => 'Txt13',
            'TXT14' => 'Txt14',
            'TXT15' => 'Txt15',
            'TXT16' => 'Txt16',
            'TXT17' => 'Txt17',
            'TXT18' => 'Txt18',
            'TXT19' => 'Txt19',
            'TXT20' => 'Txt20',
            'TXT21' => 'Txt21',
            'TXT22' => 'Txt22',
            'TXT23' => 'Txt23',
            'TXT24' => 'Txt24',
            'TXT25' => 'Txt25',
            'TXT26' => 'Txt26',
            'TXT27' => 'Txt27',
            'TXT28' => 'Txt28',
            'TXT29' => 'Txt29',
            'TXT30' => 'Txt30',
            'TXT31' => 'Txt31',
            'TXT32' => 'Txt32',
            'TXT33' => 'Txt33',
            'TXT34' => 'Txt34',
            'TXT35' => 'Txt35',
            'TXT36' => 'Txt36',
            'TXT37' => 'Txt37',
            'TXT38' => 'Txt38',
            'TXT39' => 'Txt39',
            'TXT40' => 'Txt40',
            'TXT41' => 'Txt41',
            'TXT42' => 'Txt42',
            'TXT43' => 'Txt43',
            'TXT44' => 'Txt44',
            'TXT45' => 'Txt45',
            'TXT46' => 'Txt46',
            'TXT47' => 'Txt47',
            'TXT48' => 'Txt48',
            'TXT49' => 'Txt49',
            'TXT50' => 'Txt50',
            'TXT51' => 'Txt51',
            'TXT52' => 'Txt52',
            'TXT53' => 'Txt53',
            'TXT54' => 'Txt54',
            'TXT55' => 'Txt55',
            'TXT56' => 'Txt56',
            'TXT57' => 'Txt57',
            'TXT58' => 'Txt58',
            'TXT59' => 'Txt59',
            'TXT60' => 'Txt60',
            'TXT61' => 'Txt61',
            'TXT62' => 'Txt62',
            'TXT63' => 'Txt63',
            'TXT64' => 'Txt64',
            'TXT65' => 'Txt65',
            'TXT66' => 'Txt66',
            'TXT67' => 'Txt67',
            'TXT68' => 'Txt68',
            'TXT69' => 'Txt69',
            'TXT70' => 'Txt70',
            'TXT71' => 'Txt71',
            'TXT72' => 'Txt72',
            'TXT73' => 'Txt73',
            'TXT74' => 'Txt74',
            'TXT75' => 'Txt75',
            'TXT76' => 'Txt76',
            'TXT77' => 'Txt77',
            'TXT78' => 'Txt78',
            'TXT79' => 'Txt79',
            'TXT80' => 'Txt80',
            'TXT81' => 'Txt81',
            'TXT82' => 'Txt82',
            'TXT83' => 'Txt83',
            'TXT84' => 'Txt84',
            'TXT85' => 'Txt85',
            'TXT86' => 'Txt86',
            'TXT87' => 'Txt87',
            'TXT88' => 'Txt88',
            'TXT89' => 'Txt89',
            'TXT90' => 'Txt90',
            'TXT91' => 'Txt91',
            'TXT92' => 'Txt92',
            'TXT93' => 'Txt93',
            'TXT94' => 'Txt94',
            'TXT95' => 'Txt95',
            'TXT96' => 'Txt96',
            'TXT97' => 'Txt97',
            'TXT98' => 'Txt98',
            'TXT99' => 'Txt99',
            'TXT100' => 'Txt100',
            'VAL01' => 'Val01',
            'VAL02' => 'Val02',
            'VAL03' => 'Val03',
            'VAL04' => 'Val04',
            'VAL05' => 'Val05',
            'VAL06' => 'Val06',
            'VAL07' => 'Val07',
            'VAL08' => 'Val08',
            'VAL09' => 'Val09',
            'VAL10' => 'Val10',
            'VAL11' => 'Val11',
            'VAL12' => 'Val12',
            'VAL13' => 'Val13',
            'VAL14' => 'Val14',
            'VAL15' => 'Val15',
            'VAL16' => 'Val16',
            'VAL17' => 'Val17',
            'VAL18' => 'Val18',
            'VAL19' => 'Val19',
            'VAL20' => 'Val20',
            'VAL21' => 'Val21',
            'VAL22' => 'Val22',
            'VAL23' => 'Val23',
            'VAL24' => 'Val24',
            'VAL25' => 'Val25',
            'VAL26' => 'Val26',
            'VAL27' => 'Val27',
            'VAL28' => 'Val28',
            'VAL29' => 'Val29',
            'VAL30' => 'Val30',
            'VAL31' => 'Val31',
            'VAL32' => 'Val32',
            'VAL33' => 'Val33',
            'VAL34' => 'Val34',
            'VAL35' => 'Val35',
            'VAL36' => 'Val36',
            'VAL37' => 'Val37',
            'VAL38' => 'Val38',
            'VAL39' => 'Val39',
            'VAL40' => 'Val40',
            'VAL41' => 'Val41',
            'VAL42' => 'Val42',
            'VAL43' => 'Val43',
            'VAL44' => 'Val44',
            'VAL45' => 'Val45',
            'VAL46' => 'Val46',
            'VAL47' => 'Val47',
            'VAL48' => 'Val48',
            'VAL49' => 'Val49',
            'VAL50' => 'Val50',
            'VAL51' => 'Val51',
            'VAL52' => 'Val52',
            'VAL53' => 'Val53',
            'VAL54' => 'Val54',
            'VAL55' => 'Val55',
            'VAL56' => 'Val56',
            'VAL57' => 'Val57',
            'VAL58' => 'Val58',
            'VAL59' => 'Val59',
            'VAL60' => 'Val60',
            'VAL61' => 'Val61',
            'VAL62' => 'Val62',
            'VAL63' => 'Val63',
            'VAL64' => 'Val64',
            'VAL65' => 'Val65',
            'VAL66' => 'Val66',
            'VAL67' => 'Val67',
            'VAL68' => 'Val68',
            'VAL69' => 'Val69',
            'VAL70' => 'Val70',
            'VAL71' => 'Val71',
            'VAL72' => 'Val72',
            'VAL73' => 'Val73',
            'VAL74' => 'Val74',
            'VAL75' => 'Val75',
            'VAL76' => 'Val76',
            'VAL77' => 'Val77',
            'VAL78' => 'Val78',
            'VAL79' => 'Val79',
            'VAL80' => 'Val80',
            'VAL81' => 'Val81',
            'VAL82' => 'Val82',
            'VAL83' => 'Val83',
            'VAL84' => 'Val84',
            'VAL85' => 'Val85',
            'VAL86' => 'Val86',
            'VAL87' => 'Val87',
            'VAL88' => 'Val88',
            'VAL89' => 'Val89',
            'VAL90' => 'Val90',
            'VAL91' => 'Val91',
            'VAL92' => 'Val92',
            'VAL93' => 'Val93',
            'VAL94' => 'Val94',
            'VAL95' => 'Val95',
            'VAL96' => 'Val96',
            'VAL97' => 'Val97',
            'VAL98' => 'Val98',
            'VAL99' => 'Val99',
            'VAL100' => 'Val100',
            'CNAME' => 'Cname',
            'CHNAME' => 'Chname',
            'CDATE' => 'Cdate',
            'CHDATE' => 'Chdate',
            'MANDANTNO' => 'Mandantno',
            'TSTAMP' => 'Tstamp',
        ];
    }

  
}
