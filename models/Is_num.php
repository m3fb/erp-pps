<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "IS_NUM".
 *
 * @property string $NO
 * @property string $INTNO00
 * @property string $INTNO01
 * @property string $INTNO02
 * @property string $INTNO03
 * @property string $INTNO04
 * @property string $INTNO05
 * @property string $INTNO06
 * @property string $INTNO07
 * @property string $INTNO08
 * @property string $INTNO09
 * @property string $INTNO10
 * @property string $INTNO11
 * @property string $INTNO12
 * @property string $INTNO13
 * @property string $INTNO14
 * @property string $INTNO15
 * @property string $INTNO16
 * @property string $INTNO17
 * @property string $INTNO18
 * @property string $INTNO19
 * @property string $INTNO20
 * @property string $INTNO21
 * @property string $INTNO22
 * @property string $INTNO23
 * @property string $INTNO24
 * @property string $INTNO25
 * @property string $INTNO26
 * @property string $INTNO27
 * @property string $INTNO28
 * @property string $INTNO29
 * @property string $INTNO30
 * @property string $INTNO31
 * @property string $INTNO32
 * @property string $INTNO33
 * @property string $INTNO34
 * @property string $INTNO35
 * @property string $INTNO36
 * @property string $INTNO37
 * @property string $INTNO38
 * @property string $INTNO39
 * @property string $INTNO40
 * @property string $INTNO41
 * @property string $INTNO42
 * @property string $INTNO43
 * @property string $INTNO44
 * @property string $INTNO45
 * @property string $INTNO46
 * @property string $INTNO47
 * @property string $INTNO48
 * @property string $INTNO49
 * @property string $INTNO50
 * @property string $INTNO51
 * @property string $INTNO52
 * @property string $INTNO53
 * @property string $INTNO54
 * @property string $INTNO55
 * @property string $INTNO56
 * @property string $INTNO57
 * @property string $INTNO58
 * @property string $INTNO59
 * @property string $INTNO60
 * @property string $INTNO61
 * @property string $INTNO62
 * @property string $INTNO63
 * @property string $INTNO64
 * @property string $INTNO65
 * @property string $INTNO66
 * @property string $INTNO67
 * @property string $INTNO68
 * @property string $INTNO69
 * @property string $INTNO70
 * @property string $INTNO71
 * @property string $INTNO72
 * @property string $INTNO73
 * @property string $INTNO74
 * @property string $INTNO75
 * @property string $INTNO76
 * @property string $INTNO77
 * @property string $INTNO78
 * @property string $INTNO79
 * @property string $INTNO80
 * @property string $INTNO81
 * @property string $INTNO82
 * @property string $INTNO83
 * @property string $INTNO84
 * @property string $INTNO85
 * @property string $INTNO86
 * @property string $INTNO87
 * @property string $INTNO88
 * @property string $INTNO89
 * @property string $INTNO90
 * @property string $INTNO91
 * @property string $INTNO92
 * @property string $INTNO93
 * @property string $INTNO94
 * @property string $INTNO95
 * @property string $INTNO96
 * @property string $INTNO97
 * @property string $INTNO98
 * @property string $INTNO99
 * @property string $CNAME
 * @property string $CHNAME
 * @property string $CDATE
 * @property string $CHDATE
 * @property string $MANDANTNO
 */
class Is_num extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'IS_NUM';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['NO'], 'required'],
            [['NO', 'INTNO00', 'INTNO01', 'INTNO02', 'INTNO03', 'INTNO04', 'INTNO05', 'INTNO06', 'INTNO07', 'INTNO08', 'INTNO09', 'INTNO10', 'INTNO11', 'INTNO12', 'INTNO13', 'INTNO14', 'INTNO15', 'INTNO16', 'INTNO17', 'INTNO18', 'INTNO19', 'INTNO20', 'INTNO21', 'INTNO22', 'INTNO23', 'INTNO24', 'INTNO25', 'INTNO26', 'INTNO27', 'INTNO28', 'INTNO29', 'INTNO30', 'INTNO31', 'INTNO32', 'INTNO33', 'INTNO34', 'INTNO35', 'INTNO36', 'INTNO37', 'INTNO38', 'INTNO39', 'INTNO40', 'INTNO41', 'INTNO42', 'INTNO43', 'INTNO44', 'INTNO45', 'INTNO46', 'INTNO47', 'INTNO48', 'INTNO49', 'INTNO50', 'INTNO51', 'INTNO52', 'INTNO53', 'INTNO54', 'INTNO55', 'INTNO56', 'INTNO57', 'INTNO58', 'INTNO59', 'INTNO60', 'INTNO61', 'INTNO62', 'INTNO63', 'INTNO64', 'INTNO65', 'INTNO66', 'INTNO67', 'INTNO68', 'INTNO69', 'INTNO70', 'INTNO71', 'INTNO72', 'INTNO73', 'INTNO74', 'INTNO75', 'INTNO76', 'INTNO77', 'INTNO78', 'INTNO79', 'INTNO80', 'INTNO81', 'INTNO82', 'INTNO83', 'INTNO84', 'INTNO85', 'INTNO86', 'INTNO87', 'INTNO88', 'INTNO89', 'INTNO90', 'INTNO91', 'INTNO92', 'INTNO93', 'INTNO94', 'INTNO95', 'INTNO96', 'INTNO97', 'INTNO98', 'INTNO99', 'MANDANTNO'], 'number'],
            [['CNAME', 'CHNAME'], 'string'],
            [['CDATE', 'CHDATE'], 'safe'],
            [['NO'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'NO' => 'N O',
            'INTNO00' => 'I N T N O00',
            'INTNO01' => 'I N T N O01',
            'INTNO02' => 'I N T N O02',
            'INTNO03' => 'I N T N O03',
            'INTNO04' => 'I N T N O04',
            'INTNO05' => 'I N T N O05',
            'INTNO06' => 'I N T N O06',
            'INTNO07' => 'I N T N O07',
            'INTNO08' => 'I N T N O08',
            'INTNO09' => 'I N T N O09',
            'INTNO10' => 'I N T N O10',
            'INTNO11' => 'I N T N O11',
            'INTNO12' => 'I N T N O12',
            'INTNO13' => 'I N T N O13',
            'INTNO14' => 'I N T N O14',
            'INTNO15' => 'I N T N O15',
            'INTNO16' => 'I N T N O16',
            'INTNO17' => 'I N T N O17',
            'INTNO18' => 'I N T N O18',
            'INTNO19' => 'I N T N O19',
            'INTNO20' => 'I N T N O20',
            'INTNO21' => 'I N T N O21',
            'INTNO22' => 'I N T N O22',
            'INTNO23' => 'I N T N O23',
            'INTNO24' => 'I N T N O24',
            'INTNO25' => 'I N T N O25',
            'INTNO26' => 'I N T N O26',
            'INTNO27' => 'I N T N O27',
            'INTNO28' => 'I N T N O28',
            'INTNO29' => 'I N T N O29',
            'INTNO30' => 'I N T N O30',
            'INTNO31' => 'I N T N O31',
            'INTNO32' => 'I N T N O32',
            'INTNO33' => 'I N T N O33',
            'INTNO34' => 'I N T N O34',
            'INTNO35' => 'I N T N O35',
            'INTNO36' => 'I N T N O36',
            'INTNO37' => 'I N T N O37',
            'INTNO38' => 'I N T N O38',
            'INTNO39' => 'I N T N O39',
            'INTNO40' => 'I N T N O40',
            'INTNO41' => 'I N T N O41',
            'INTNO42' => 'I N T N O42',
            'INTNO43' => 'I N T N O43',
            'INTNO44' => 'I N T N O44',
            'INTNO45' => 'I N T N O45',
            'INTNO46' => 'I N T N O46',
            'INTNO47' => 'I N T N O47',
            'INTNO48' => 'I N T N O48',
            'INTNO49' => 'I N T N O49',
            'INTNO50' => 'I N T N O50',
            'INTNO51' => 'I N T N O51',
            'INTNO52' => 'I N T N O52',
            'INTNO53' => 'I N T N O53',
            'INTNO54' => 'I N T N O54',
            'INTNO55' => 'I N T N O55',
            'INTNO56' => 'I N T N O56',
            'INTNO57' => 'I N T N O57',
            'INTNO58' => 'I N T N O58',
            'INTNO59' => 'I N T N O59',
            'INTNO60' => 'I N T N O60',
            'INTNO61' => 'I N T N O61',
            'INTNO62' => 'I N T N O62',
            'INTNO63' => 'I N T N O63',
            'INTNO64' => 'I N T N O64',
            'INTNO65' => 'I N T N O65',
            'INTNO66' => 'I N T N O66',
            'INTNO67' => 'I N T N O67',
            'INTNO68' => 'I N T N O68',
            'INTNO69' => 'I N T N O69',
            'INTNO70' => 'I N T N O70',
            'INTNO71' => 'I N T N O71',
            'INTNO72' => 'I N T N O72',
            'INTNO73' => 'I N T N O73',
            'INTNO74' => 'I N T N O74',
            'INTNO75' => 'I N T N O75',
            'INTNO76' => 'I N T N O76',
            'INTNO77' => 'I N T N O77',
            'INTNO78' => 'I N T N O78',
            'INTNO79' => 'I N T N O79',
            'INTNO80' => 'I N T N O80',
            'INTNO81' => 'I N T N O81',
            'INTNO82' => 'I N T N O82',
            'INTNO83' => 'I N T N O83',
            'INTNO84' => 'I N T N O84',
            'INTNO85' => 'I N T N O85',
            'INTNO86' => 'I N T N O86',
            'INTNO87' => 'I N T N O87',
            'INTNO88' => 'I N T N O88',
            'INTNO89' => 'I N T N O89',
            'INTNO90' => 'I N T N O90',
            'INTNO91' => 'I N T N O91',
            'INTNO92' => 'I N T N O92',
            'INTNO93' => 'I N T N O93',
            'INTNO94' => 'I N T N O94',
            'INTNO95' => 'I N T N O95',
            'INTNO96' => 'I N T N O96',
            'INTNO97' => 'I N T N O97',
            'INTNO98' => 'I N T N O98',
            'INTNO99' => 'I N T N O99',
            'CNAME' => 'C N A M E',
            'CHNAME' => 'C H N A M E',
            'CDATE' => 'C D A T E',
            'CHDATE' => 'C H D A T E',
            'MANDANTNO' => 'M A N D A N T N O',
        ];
    }
}
