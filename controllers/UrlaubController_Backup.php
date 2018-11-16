<?php

namespace app\controllers;

use Yii;
use app\models\Urlaub;
use app\models\Event;
use app\models\UrlaubSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UrlaubController implements the CRUD actions for Urlaub model.
 */
class UrlaubController extends Controller
{
	// Layout mit Seitendarstellung zur Navigation
	public $layout = 'urlaub';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
	
// Tagerechner in Urlaub/Antrag
public function actionSample()
{
	$model = new Urlaub();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();
		$start= explode(":", $data['start']);
		$ende= explode(":", $data['ende']);
		$startdatum= $start[0];
		$endedatum= $ende[0];
		$urlaubstage = $model->tagerechner($startdatum,$endedatum);
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    return [
        'urlaub' => $urlaubstage,
        'code' => 100,
    ];
  }
}

// Übernehmen des Schichtplans
public function actionSchichteintrag()
{
	$model = new Urlaub();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();
		// CHECK: 0: Eintrag in DB, 1: Auslesen aus DB
		$check = $data['CHECK'];
		$KW= $data['KW'];
		$jahr = $data['JAHR'];
		$mo_frueh = str_replace('X', ',', $data['MO_FRUEH']);
		$mo_spaet = str_replace('X', ',', $data['MO_SPAET']);
		$mo_nacht = str_replace('X', ',', $data['MO_NACHT']);
		$di_frueh = str_replace('X', ',', $data['DI_FRUEH']);
		$di_spaet = str_replace('X', ',', $data['DI_SPAET']);
		$di_nacht = str_replace('X', ',', $data['DI_NACHT']);
		$mi_frueh = str_replace('X', ',', $data['MI_FRUEH']);
		$mi_spaet = str_replace('X', ',', $data['MI_SPAET']);
		$mi_nacht = str_replace('X', ',', $data['MI_NACHT']);
		$do_frueh = str_replace('X', ',', $data['DO_FRUEH']);
		$do_spaet = str_replace('X', ',', $data['DO_SPAET']);
		$do_nacht = str_replace('X', ',', $data['DO_NACHT']);
		$fr_frueh = str_replace('X', ',', $data['FR_FRUEH']);
		$fr_spaet = str_replace('X', ',', $data['FR_SPAET']);
		$fr_nacht = str_replace('X', ',', $data['FR_NACHT']);
		$sa_frueh = str_replace('X', ',', $data['SA_FRUEH']);
		$sa_spaet = str_replace('X', ',', $data['SA_SPAET']);
		$sa_nacht = str_replace('X', ',', $data['SA_NACHT']);
		$so_frueh = str_replace('X', ',', $data['SO_FRUEH']);
		$so_spaet = str_replace('X', ',', $data['SO_SPAET']);
		$so_nacht = str_replace('X', ',', $data['SO_NACHT']);
		$schichtplan = $model->schichtplaner($check,$KW,$jahr,$mo_frueh,$mo_spaet,$mo_nacht,$di_frueh,$di_spaet,$di_nacht,
											$mi_frueh,$mi_spaet,$mi_nacht,$do_frueh,$do_spaet,$do_nacht,$fr_frueh,$fr_spaet,$fr_nacht,
											$sa_frueh,$sa_spaet,$sa_nacht,$so_frueh,$so_spaet,$so_nacht);
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    return $schichtplan;
  }
}

// Anzeige der Urlaubsanträge im Kalender
public function actionAntraege()
{
	$model = new Urlaub();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();
		$start= explode(":", $data['start']);
		$ende= explode(":", $data['end']);
		$startdatum= $start[0];
		$endedatum= $ende[0];
		$pnr = $data['pnra'];
		$urlaubstage = $model->abfrage(0);
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		
		$return_arr = array();
		$row_arr = array();
		$i = 0;
		foreach ($urlaubstage as $type) {
			
		if($i == 0) {
			$row_array['start'] = $type['TERMIN'];
			$row_array['allDay'] = 'true';
			$i++;
			
		}
		else{
			$row_array['end'] = $type['TERMIN'];
			$row_array['title'] = $type['PERSNAME'] . " (Urlaubsantrag)";
			$i = 0;
			array_push($return_arr,$row_array);
		}
		
		
		}
		
		return $return_arr;
}
}
// Anzeige der bestätigten Urlaube im Kalender
public function actionTermine()
{
	$model = new Urlaub();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();
		$start= explode(":", $data['start']);
		$ende= explode(":", $data['end']);
		$startdatum= $start[0];
		$endedatum= $ende[0];
		$pnr = $data['pnra'];
		$urlaubstage = $model->abfragelb($pnr,$startdatum,$endedatum);
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		
		$return_arr = array();
		$row_arr = array();
		$i = 0;
		foreach ($urlaubstage as $type) {
			
		if($i == 0) {
			
			#$row_array['allDay'] = true; 
			#date("Y-m-d", strtotime($type['MSTIME']))
		// Bei datumabhängigen Abfragen kann es sein, dass ein Eintrag "Urlaub Ende" zuerst erscheint
		// Momentan wird in diesem Fall das Enddatum als einzelner Termin gesetzt. Durch das Addieren von jeweils
		// 2 Monaten im Abfragefenster sollte der Fall nicht auftreten   (auf TODO Liste)
			if($type['STATUS']==801){
			$row_array['end'] = $type['MSTIME'];
			$row_array['title'] = $type['PERSNAME'];
			$i++;
			}
			else{
			$row_array['start'] = $type['MSTIME']; //<== Zeit noch wegformatieren
			$row_array['title'] = $type['PERSNAME'];
			$i++;
			}
		}
		else{
			// Da es in der DB vorkommt, dass ein 800er Eintrag zweimal hintereinander kommt, muss hier nochmal geprüft werden
			if($type['STATUS']==801) {  // Überprüfen ob vorheriger Status gleich 
			$row_array['end'] = $type['MSTIME'];
			if($row_array['title']==$type['PERSNAME']){
			array_push($return_arr,$row_array);
			}
			}
			if($row_array['title']==$type['PERSNAME']){
			$row_array['start'] = $type['MSTIME'];
			$row_array['end'] = $row_array['end'];   // Durch vorherigen Durchgang gesetzt -> muss nach 'start' folgen
			array_push($return_arr,$row_array);
			}
			$i = 0;
		}
		
		
		}
		
		return $return_arr;
}
}




public function actionSchichtzukalender()
{
	$model = new Urlaub();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();
		$start= explode(":", $data['start']);
		$ende= explode(":", $data['end']);
		$startdatum= $start[0];
		$endedatum= $ende[0];
		$kw = $model->schichtzukalender($startdatum,$endedatum);
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		
		$return_arr = array();
		$row_arr = array();
		foreach ($kw as $type) {
			$datum = new \DateTime();
			$datum->setISODate($type['JAHR'], $type['KW']);
			$row_arr['start'] = $datum->format('Y-m-d 06:00');
			$row_arr['end'] = $datum->format('Y-m-d 14:00');
			$row_arr['title'] = "Frühschicht: ".$type['MO_FRUEH'];
			array_push($return_arr,$row_arr);
			$row_arr['start'] = $datum->format('Y-m-d 14:00');
			$row_arr['end'] = $datum->format('Y-m-d 22:00');
			$row_arr['title'] = "Spätschicht: ".$type['MO_SPAET'];
			array_push($return_arr,$row_arr);
			$row_arr['start'] = $datum->format('Y-m-d 22:00');
			$datum->modify('+1 days');
			$row_arr['end'] = $datum->format('Y-m-d 06:00');
			$row_arr['title'] = "Nachtschicht: ".$type['MO_NACHT'];
			array_push($return_arr,$row_arr);

			
			$row_arr['start'] = $datum->format('Y-m-d 06:00');
			$row_arr['end'] = $datum->format('Y-m-d 14:00');
			$row_arr['title'] = "Frühschicht: ".$type['DI_FRUEH'];
			array_push($return_arr,$row_arr);
			$row_arr['start'] = $datum->format('Y-m-d 14:00');
			$row_arr['end'] = $datum->format('Y-m-d 22:00');
			$row_arr['title'] = "Spätschicht: ".$type['DI_SPAET'];
			array_push($return_arr,$row_arr);
			$row_arr['start'] = $datum->format('Y-m-d 22:00');
			$datum->modify('+1 days');
			$row_arr['end'] = $datum->format('Y-m-d 06:00');
			$row_arr['title'] = "Nachtschicht: ".$type['DI_NACHT'];
			array_push($return_arr,$row_arr);

			
			$row_arr['start'] = $datum->format('Y-m-d 06:00');
			$row_arr['end'] = $datum->format('Y-m-d 14:00');
			$row_arr['title'] = "Frühschicht: ".$type['MI_FRUEH'];
			array_push($return_arr,$row_arr);
			$row_arr['start'] = $datum->format('Y-m-d 14:00');
			$row_arr['end'] = $datum->format('Y-m-d 22:00');
			$row_arr['title'] = "Spätschicht: ".$type['MI_SPAET'];
			array_push($return_arr,$row_arr);
			$row_arr['start'] = $datum->format('Y-m-d 22:00');
			$datum->modify('+1 days');
			$row_arr['end'] = $datum->format('Y-m-d 06:00');
			$row_arr['title'] = "Nachtschicht: ".$type['MI_NACHT'];
			array_push($return_arr,$row_arr);

			
			$row_arr['start'] = $datum->format('Y-m-d 06:00');
			$row_arr['end'] = $datum->format('Y-m-d 14:00');
			$row_arr['title'] = "Frühschicht: ".$type['DO_FRUEH'];
			array_push($return_arr,$row_arr);
			$row_arr['start'] = $datum->format('Y-m-d 14:00');
			$row_arr['end'] = $datum->format('Y-m-d 22:00');
			$row_arr['title'] = "Spätschicht: ".$type['DO_SPAET'];
			array_push($return_arr,$row_arr);
			$row_arr['start'] = $datum->format('Y-m-d 22:00');
			$datum->modify('+1 days');
			$row_arr['end'] = $datum->format('Y-m-d 06:00');
			$row_arr['title'] = "Nachtschicht: ".$type['DO_NACHT'];
			array_push($return_arr,$row_arr);

			
			$row_arr['start'] = $datum->format('Y-m-d 06:00');
			$row_arr['end'] = $datum->format('Y-m-d 14:00');
			$row_arr['title'] = "Frühschicht: ".$type['FR_FRUEH'];
			array_push($return_arr,$row_arr);
			$row_arr['start'] = $datum->format('Y-m-d 14:00');
			$row_arr['end'] = $datum->format('Y-m-d 22:00');
			$row_arr['title'] = "Spätschicht: ".$type['FR_SPAET'];
			array_push($return_arr,$row_arr);
			$row_arr['start'] = $datum->format('Y-m-d 22:00');
			$datum->modify('+1 days');
			$row_arr['end'] = $datum->format('Y-m-d 06:00');
			$row_arr['title'] = "Nachtschicht: ".$type['FR_NACHT'];
			array_push($return_arr,$row_arr);

			
			$row_arr['start'] = $datum->format('Y-m-d 06:00');
			$row_arr['end'] = $datum->format('Y-m-d 14:00');
			$row_arr['title'] = "Frühschicht: ".$type['SA_FRUEH'];
			array_push($return_arr,$row_arr);
			$row_arr['start'] = $datum->format('Y-m-d 14:00');
			$row_arr['end'] = $datum->format('Y-m-d 22:00');
			$row_arr['title'] = "Spätschicht: ".$type['SA_SPAET'];
			array_push($return_arr,$row_arr);
			$row_arr['start'] = $datum->format('Y-m-d 22:00');
			$datum->modify('+1 days');
			$row_arr['end'] = $datum->format('Y-m-d 06:00');
			$row_arr['title'] = "Nachtschicht: ".$type['SA_NACHT'];
			array_push($return_arr,$row_arr);

			
			$row_arr['start'] = $datum->format('Y-m-d 06:00');
			$row_arr['end'] = $datum->format('Y-m-d 14:00');
			$row_arr['title'] = "Frühschicht: ".$type['SO_FRUEH'];
			array_push($return_arr,$row_arr);
			$row_arr['start'] = $datum->format('Y-m-d 14:00');
			$row_arr['end'] = $datum->format('Y-m-d 22:00');
			$row_arr['title'] = "Spätschicht: ".$type['SO_SPAET'];
			array_push($return_arr,$row_arr);
			$row_arr['start'] = $datum->format('Y-m-d 22:00');
			$datum->modify('+1 days');
			$row_arr['end'] = $datum->format('Y-m-d 06:00');
			$row_arr['title'] = "Nachtschicht: ".$type['SO_NACHT'];
			array_push($return_arr,$row_arr);
		
		}
			return $return_arr;
		
}
		
}
















    public function actionAntrag()
    {
        $model = new Urlaub();
     			
		if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->tagepruef($model->tagerechner($model->start,$model->ende),$model->tage,$model->stunden)) {
			if ( isset( $_POST[ 'btnAbschicken' ] )) 
			{
			$model->eintragen($model->pnr,$model->start,$model->ende,$model->name,$model->tage,$model->stunden); 
			Yii::$app->getSession()->setFlash('urlaubgest', '<u>Urlaubsantrag gestellt!</u><br />');	
			}
			// elseif ( isset( $_POST[ 'btnBerechnen' ] ) ) 
			// {
			// $urlaubstage = $model->tagerechner($model->start,$model->ende); 		
			// Yii::$app->getSession()->setFlash('benTage', 'Es werden ' . $urlaubstage . ' Tage benötigt');		
			// }
			return $this->render('antrag', ['model' => $model]);   
            } 
		else {   
			if($model->tagepruef($model->tagerechner($model->start,$model->ende),$model->tage,$model->stunden)){
			Yii::$app->getSession()->setFlash('benTage', 'Die anzahl der aufzuwendenden Tage/Stunden stimmt nicht überein. <br> Bitte überprüfen!<br>');	
            }
			
			// either the page is initially displayed or there is some validation error   
            return $this->render('antrag', ['model' => $model]);   
            }   
    }
	
	
    public function actionKalender($start=NULL,$end=NULL,$_=NULL)
    {
	   $model = new Urlaub();
	
        return $this->render('kalender', [
            'model' => $model
        ]);
  }
 
	
	
    public function actionSchicht($start=NULL,$end=NULL,$_=NULL)
    {
	   $model = new Urlaub();
	
        return $this->render('schicht', [
            'model' => $model
        ]);
  }
 
   
	
	
	
    public function actionManager()
    {
        $model = new Urlaub();
		if ($model->load(Yii::$app->request->post())) {

			if ( isset( $_POST[ 'btnAnnehmen' ] ) ) 
			{
				//Yii::$app->request->post('name')
				
				$model->bestaetigen($_POST['Urlaub']['idstart'],$_POST['Urlaub']['idende']); 
				$this->refresh();
			}
			
			elseif ( isset( $_POST[ 'btnAblehnen' ] ) ) 
			{	
			
				//Yii::$app->request->post('name')
	
				$model->ablehnen($_POST['Urlaub']['idstart'],$_POST['Urlaub']['idende']); 
				$this->refresh();
			}
			
			
			
			
			
			$model->abfrage($model->pnra); 
			return $this->render('manager', ['model' => $model]);  
		}
		else{
			
			
            return $this->render('manager', [
                'model' => $model,
            ]);
		}
        
    }
	
	
    /**
     * Lists all Urlaub models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UrlaubSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Urlaub model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Urlaub model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Urlaub();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->LBNO]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Urlaub model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->LBNO]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Urlaub model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Urlaub model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Urlaub the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Urlaub::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
