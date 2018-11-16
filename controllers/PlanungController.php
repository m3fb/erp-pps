<?php

namespace app\controllers;

use Yii;
use app\models\Planung;
use app\models\PlanungSearch;
use app\models\Todo;
use app\models\TodoSearch;
use app\models\Maschine;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use mPDF;
use yii\filters\AccessControl;
use yii\data\ArrayDataProvider;

/**
 * BdeController implements the CRUD actions for Bde model.
 */
class PlanungController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','lieferrueckstand','planungsliste','kaufteile'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['plantafel'],
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Bde models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PlanungSearch();
        $activeMachines = $searchModel->findActiveMachines();
        return $this->render('index', [
			'activeMachines' => $activeMachines
        ]);

    }


    /**
    * 6.07.2018 $env hinzugefügt.
    * $env steuert die Umgebung in der die Plantafel aufgerufen wird.
    * norm = Standardumgebung
    * prod = Produktionsdashboard (wie bisher)
    * tk = Technikumsdashboard
    **/
    public function actionPlantafel($env)
    {
      if ($env == 'prod' || $env=='') {
        $this->layout = 'dashboard';
        $this->view->params['nav_background'] = '#dff0d8';
        $this->view->params['nav_color'] = '#3c763d';
        $this->view->params['reload'] = 60000; #Wert in Millisekunden
        $this->view->params['nav_header']= 'Plantafel und Informationen';
        $this->view->params['nav_URL'] = '/procontrol/index';
      }
      elseif ($env == 'tk'){
        $this->layout = 'dashboard';
    		$this->view->params['nav_background'] = '#337ab7';
    		$this->view->params['nav_color'] = '#fff';
    		$this->view->params['reload'] = 60000; #Wert in Millisekunden
    		$this->view->params['nav_header']= 'Techniscreen';
    		$this->view->params['nav_URL'] = '';
      }
      else{
        $this->layout = 'main';
        $this->view->params['nav_header']= '';
        $this->view->params['containerClass'] = 'container-fluid';
      }


  		$searchModel = new PlanungSearch();
      $activeMachines = $searchModel->findActiveMachines();
      $nextOrders =  $searchModel->findOpenOrders();

      $searchModel1 = new TodoSearch();
      $openTasks = $searchModel1->searchOpenTasks(Yii::$app->request->queryParams);



  		return $this->render('plantafel', [
  			'activeMachines' => $activeMachines,
  			'nextOrders' => $nextOrders,
  			'openTasks'=> $openTasks,
          ]);
    }
    public function actionMplanung()
    {
		$searchModel = new PlanungSearch();
        $activeMachines = $searchModel->findActiveMachines(Yii::$app->request->queryParams); #hier wird ein ARRAY zurückgegeben daher ....
        $provider = new ArrayDataProvider( ['allModels' => $activeMachines,'key' => 'WP_MA1_NO',]); #Array in dataprovider umwandeln

        $countValues[1] = Maschine::find()->where(['CONTROL' =>1])->count();
        $countValues[2] = Maschine::find()->where(['CONTROL' =>2])->count();

			 // validate if there is a editable input saved via AJAX
    if (Yii::$app->request->post('hasEditable')) {
        // instantiate your model for saving
        $_id = Yii::$app->request->post('editableKey');
		$model = Maschine::findOne($_id);

        // store a default json response as desired by editable
        $out = Json::encode(['output'=>'', 'message'=>'']);

        // fetch the first entry in posted data (there should
        // only be one entry anyway in this array for an
        // editable submission)
        // - $posted is the posted data for Book without any indexes
        // - $post is the converted array for single model validation
        $post = [];
        $posted = current($_POST['Maschine']);
		$post['Maschine'] = $posted;

        // load model like any single model validation
        if ($model->load($post)) {
            // can save model or do something before saving model
            $model->save();
            // custom output to return to be displayed as the editable grid cell
            // data. Normally this is empty - whereby whatever value is edited by
            // in the input by user is updated automatically.
            $output = '';

            // specific use case where you need to validate a specific
            // editable column posted when you have more than one
            // EditableColumn in the grid view. We evaluate here a
            // check to see if buy_amount was posted for the Book model
            if (isset($posted['CONTROL']) ) {
               $output =  Yii::$app->formatter->asDecimal($model->CONTROL, 0);
            }

            // similarly you can check if the name attribute was posted as well
            // if (isset($posted['name'])) {
            //   $output =  ''; // process as you need
            // }
            if (in_array($output,[0,1,2,3,4])) {
				if($output == 1 and $countValues[1] > 0){
					$out = Json::encode(['output'=>'', 'message'=>'Prio 1 darf nur einmal vergeben werden']);
				} elseif($output == 2 and $countValues[2] > 0) {
					$out = Json::encode(['output'=>'', 'message'=>'Prio 2 darf nur einmal vergeben werden']);
				} elseif($output == 2 and $countValues[2] == 0 or $output == 1 and $countValues[1] == 0 or $output > 2 or $output == 0)  {
					$out = Json::encode(['output'=>$output, 'message'=>'']);
				}
				else {
					$out = Json::encode(['output'=>'', 'message'=>'Fehler']);
				}
			} else {
				$out = Json::encode(['output'=>'', 'message'=>'Wert nicht korrekt. Wert muss zwischen 0 und 4 liegen']);
			}

        }
        // return ajax json encoded response and exit
        echo $out;
        return;
    }

		return $this->render('mplanung', [
			'searchModel' => $searchModel,
			'activeMachines' => $provider]);
	}



  }
