<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Qsboard extends ActiveRecord
{

	public static function getDb()
{
    return Yii::$app->get('db2');
}
	
	public static function tableName()
	{
		return 'tbl_Reklamation_Position';
	}

  
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['OID', 'REK_ID'], 'required'],
            [['REK_ID'], 'number'],
        ];
    } 
	
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            
            
        ];
    }
    
    public function getOpenClaims ()
    {
		/*Select
			tbl_Reklamation_Position.OID, REK_ID, Problembeschreibung, Image_Fehlermeldung AS [Image],
			CRM_Geschaeftspartner.Firma,tbl_Artikel.Form_Nummer,tbl_Artikel.Teilenummer,tbl_Artikel.Langebzeichnung
			FROM tbl_Reklamation_Position 
			LEFT JOIN tbl_Reklamationen ON tbl_Reklamation_Position.REK_ID = tbl_Reklamationen.OID
			LEFT JOIN CRM_Geschaeftspartner ON tbl_Reklamationen.GP_ID = CRM_Geschaeftspartner.OID
			LEFT JOIN tbl_Artikel ON tbl_Reklamation_Position.ART_ID = tbl_Artikel.OID
			WHERE tbl_Reklamationen.Status <> 4
	union
	SELECT 
tbl_Reklamation_Lieferant_Position.OID, tbl_Reklamation_Lieferant_Position.REK_ID, tbl_Reklamation_Lieferant_Position.Fehlermeldung as Problembeschreibung, 
tbl_Reklamation_Lieferant_Position.Image as [Image],CRM_Geschaeftspartner.Firma,tbl_Artikel.Form_Nummer,tbl_Artikel.Teilenummer,tbl_Artikel.Langebzeichnung
			FROM tbl_Reklamation_Lieferant_Position 
			LEFT JOIN tbl_Reklamationen ON tbl_Reklamation_Lieferant_Position.REK_ID = tbl_Reklamationen.OID
			LEFT JOIN CRM_Geschaeftspartner ON tbl_Reklamationen.GP_ID = CRM_Geschaeftspartner.OID
			LEFT JOIN tbl_Artikel ON tbl_Reklamation_Lieferant_Position.ART_ID = tbl_Artikel.OID
			WHERE tbl_Reklamationen.Status <> 4*/
		
		$query1 = $this->find()
		->select([	
					'tbl_Reklamation_Position.OID as OID', 
					'tbl_Reklamation_Position.REK_ID as REK_ID',
					'tbl_Reklamation_Position.Problembeschreibung as Problembeschreibung', 
					'tbl_Reklamation_Position.Image_Fehlermeldung as Image',
					'tbl_Reklamationen.Reklamationsdatum as Reklamationsdatum',					 
					'CRM_Geschaeftspartner.Firma as Firma', 
					'tbl_Artikel.Form_Nummer as Form_Nummer', 
					'tbl_Artikel.Teilenummer as Teilenummer', 
					'tbl_Artikel.Langebzeichnung as Langebezeichnung'
					])
					
		->from('tbl_Reklamation_Position')
		
		
		->leftJoin('tbl_Reklamationen', 'tbl_Reklamation_Position.REK_ID = tbl_Reklamationen.OID')
		->leftJoin('CRM_Geschaeftspartner', 'tbl_Reklamationen.GP_ID = CRM_Geschaeftspartner.OID')
		->leftJoin('tbl_Artikel','tbl_Reklamation_Position.ART_ID = tbl_Artikel.OID')
		
		->where(['<>','tbl_Reklamationen.Status', 4])
		->andWhere(['not', ['tbl_Reklamation_Position.Problembeschreibung' => null]]);
		#->all();
		
		$query2 = $this->find()
		->select([
					'tbl_Reklamation_Lieferant_Position.OID',
					'tbl_Reklamation_Lieferant_Position.REK_ID as REK_ID',
					'tbl_Reklamation_Lieferant_Position.Fehlermeldung as Problembeschreibung',
					'tbl_Reklamation_Lieferant_Position.Image as Image',
					'tbl_Reklamationen.Reklamationsdatum as Reklamationsdatum',
					'CRM_Geschaeftspartner.Firma as Firma',
					'tbl_Artikel.Form_Nummer as Form_Nummer',
					'tbl_Artikel.Teilenummer as Teilenummer',
					'tbl_Artikel.Langebzeichnung as Langebezeichnung'
					])
					
		->from('tbl_Reklamation_Lieferant_Position')
		
		->leftJoin('tbl_Reklamationen', 'tbl_Reklamation_Lieferant_Position.REK_ID = tbl_Reklamationen.OID')
		->leftJoin('CRM_Geschaeftspartner', 'tbl_Reklamationen.GP_ID = CRM_Geschaeftspartner.OID')
		->leftJoin('tbl_Artikel', 'tbl_Reklamation_Lieferant_Position.ART_ID = tbl_Artikel.OID')
		
		->where(['<>','tbl_Reklamationen.Status', 4])
		->andWhere(['not', ['tbl_Reklamation_Lieferant_Position.Fehlermeldung' => null]]);
		#->all();
		
		#$dataProvider = $query1->union($query2)->asArray()->all();
		
		/* 24.05.2017:
		 * Yii2 BUG: union und orderBy funktionieren nicht. Deshalb wurde der obere SELECT
		 * in ein RAW-SQL umgewandelt und orderBy angefügt. */
		 
		$query1->union($query2);
		$sql = $query1->createCommand()->getRawSql();
		$sql .= ' ORDER BY Reklamationsdatum DESC';
		$sqlquery = $sql;
		
		$connection = $this->getDb();
		$command = $connection->createCommand($sqlquery);
		$dataProvider= $command->queryAll();
		
		return $dataProvider;
		
	}
    
    
}
?>
