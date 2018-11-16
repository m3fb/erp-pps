<?php

namespace app\controllers;

use Yii;
use app\models\ProjektCheckliste;
use app\models\ProjektChecklisteSearch;
use app\models\Projekt;
use app\models\ProjektSearch;
use app\models\Pa_paper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Sort;

/**
 * ProjektController implements the CRUD actions for M3ProjektCheckliste model.
 */
class ProjektController extends Controller
{
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

    /**
     * Lists all M3ProjektCheckliste models.
     * @return mixed
     */
    public function actionIndex()
    {

        return $this->render('index');
    }

    public function actionCheckliste_index()
    {
        $searchModel = new ProjektChecklisteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('checkliste_index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUebersicht_index()
    {
        $searchModel = new ProjektSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('uebersicht_index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionProjektplan()
    {

  		$searchModel = new ProjektChecklisteSearch();
          $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
          $dataProvider->query->where(['Status'=>NULL]);
          $weeks_of_cur_year = ProjektCheckliste::getIsoWeeksInYear(\date( "Y"));

          $this->view->params['nav_header']= '';
          $this->view->params['containerClass'] = 'container-fluid';
          $this->view->params['reload'] = 600000;

  		$sort = new Sort([
  			'attributes' => [
  				'WerkzeugNr',
  				'Termin_Pruefber_Ende'=>['label' => 'Endtermin'],
  			],
  		]);

          return $this->render('projektplan', [
  			'dataProvider' => $dataProvider,
  			'searchModel' => $searchModel,
  			'sort' => $sort,
  			'weeks_of_cur_year' => $weeks_of_cur_year,
  			]);
    }

    public function actionProjektplanDash()
    {

		$searchModel = new ProjektChecklisteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $weeks_of_cur_year = ProjektCheckliste::getIsoWeeksInYear(\date( "Y"));

        #Yii::$app->user->identity->role=0;

		$this->view->params['containerClass'] = 'container-fluid';

		$this->layout = 'dashboard';
		$this->view->params['nav_background'] = '#337ab7';
		$this->view->params['nav_color'] = '#fff';
		$this->view->params['reload'] = 360000; #Wert in Millisekunden
		$this->view->params['nav_header']= 'Techniscreen';
		$this->view->params['nav_URL'] = '';

        return $this->render('projektplan', [
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
			'weeks_of_cur_year' => $weeks_of_cur_year,
			]);
    }
    /**
     * Displays a single M3ProjektCheckliste model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Neue Checkliste anlegen.
     * Wenn das erfolgreich funktioniert, wird direkt zur Update Action weitergeleitet.
     */
    public function actionCreate()
    {
        $model = new ProjektCheckliste();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->ID]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }



    /**
     * Updates an existing M3ProjektCheckliste model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $this->view->params['containerClass'] = 'container';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['update', 'id' => $model->ID]);
        }

		$openProjects = Pa_paper::find()
						->select(['TXTNUMMER',"[TXTNUMMER] + ' '+ LEFT([ADDRTEXT],20 ) +'...' as Orderinfo"])
						->where(['not',['STATUS'=>2]])
						->andWhere(['IDENT'=>1])
						->andWhere(['TXTIDENT'=>'Auftragsbestätigung Werkzeug'])
						->orderBy('TXTNUMMER')
						->asArray()
						->all();
		array_unshift($openProjects,['TXTNUMMER'=>'','Orderinfo'=>'-']); // leeren Eintrag an das Array-Anfang einfügen
        return $this->render('update', [
            'model' => $model,
            'openProjects' => $openProjects,
        ]);
    }

    public function actionFinish($id)
    {
        $model = ProjektCheckliste::findOne($id);
        $model->Status = 1;
        $model->save();

        return $this->redirect(['projekt/projektplan']);
    }

    public function actionUrterminReset($id)
    {
        $model = ProjektCheckliste::findOne($id);
        $date_vars = ['Konst','WZBau','RM','Vorrichtung','Verpackung','Linie','int_Bem','ext_Bem','Pruefber',
  							'Einfahren','sonst1','sonst2','sonst3','sonst4','sonst5'];
  			foreach ($date_vars as $var) {
  				if ($model->{'Termin_'.$var.'_Ende'} ) {
  					$model->{'Termin_'.$var.'_Ende_0'} = $model->{'Termin_'.$var.'_Ende'}; // Prüfen ob Urtermin gesetzt und wenn nicht mit Termin_Ende setzen
  				}
  				if ($var !='Pruefber' && $model->{'Termin_'.$var.'_Dauer'} ) {
  					$model->{'Termin_'.$var.'_Dauer_0'} = $model->{'Termin_'.$var.'_Dauer'}; // Prüfen ob Urtermin gesetzt und wenn nicht mit Termin_Ende setzen
  				}
      }
      $model->save();
      return $this->redirect(['update', 'id' => $model->ID]);
    }

    /**
     * Deletes an existing M3ProjektCheckliste model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['projekt/projektplan']);
    }


    /**
     * Finds the M3ProjektCheckliste model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return M3ProjektCheckliste the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProjektCheckliste::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGantt()
    {
      return $this->render('gantt');
    }


}
