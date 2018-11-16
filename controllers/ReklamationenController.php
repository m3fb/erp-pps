<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\qualitainer\Reklamationen;
use app\models\AccessRule;
use app\models\User;


/**
 * M3FahrtenPositionenController implements the CRUD actions for M3FahrtenPositionen model.
 */
class ReklamationenController extends Controller
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
            'access' => [
                   'class' => \yii\filters\AccessControl::className(),
                   // We will override the default rule config with the new AccessRule class
                   'ruleConfig' => [
                       'class' => AccessRule::className(),
                   ],
                   'only' =>['auswertung'],
                   'rules' => [
                       [
                           'actions' => ['auswertung'],
                           'allow' => true,

                           'roles' => [],
                       ],
                   ],
               ],
        ];
    }


    public function actionAuswertung($wirkungsfaktor,$month,$attribut,$env)
    {
      if ($env == 'qs') {
        $this->layout = 'dashboard';
        $this->view->params['containerClass'] = 'container';
        $this->view->params['nav_background'] = '#f2dede';
        $this->view->params['nav_color'] = '#a94442';
        $this->view->params['reload'] = 0; #Wert in Millisekunden#Wert in Millisekunden
        $this->view->params['nav_header']= 'QS-Informationen';
        $this->view->params['nav_URL'] = '/reklamationen/auswertung';
      }
        elseif ($env == 'tk') {
          $this->layout = 'dashboard';
          $this->view->params['containerClass'] = 'container';
          $this->view->params['nav_background'] = '#337ab7';
          $this->view->params['nav_color'] = '#fff';
          $this->view->params['reload'] = 0; #Wert in Millisekunden#Wert in Millisekunden
          $this->view->params['nav_header']= 'Techniscreen';
          $this->view->params['nav_URL'] = '/reklamationen/auswertung';
        }

        $searchModel = new Reklamationen();

        if ($wirkungsfaktor!='' && $month != ''){

          $groupedData = $searchModel->getGroupedDatas($wirkungsfaktor,$month,$attribut,$env);
        }
        else{
          $groupedData='';
        }

        if ($wirkungsfaktor!='' && $month != '' && $attribut!=''){

          $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$wirkungsfaktor,$month,$attribut);
        }
        else{
          $dataProvider='';
        }

        $statistischeWerte = $searchModel->getTrend();

        return $this->render('auswertung', [
            'searchModel' => $searchModel,
            'groupedData' => $groupedData,
            'statistischeWerte' => $statistischeWerte,
            'dataProvider' => $dataProvider,
            'wirkungsfaktor' => $wirkungsfaktor,
            'attribut' => $attribut,
            'month' => $month,
            'env' => $env,
        ]);
    }
    // interne Reklamationen auflisten um den aktuellen Stand bzw. die durchgeführten Aktionen aufzulisten
    public function actionInterneReklamationen($env)
    {
      if ($env == 'qs') {
        $this->layout = 'dashboard';
        $this->view->params['nav_background'] = '#f2dede';
        $this->view->params['nav_color'] = '#a94442';
        $this->view->params['reload'] = 0; #Wert in Millisekunden#Wert in Millisekunden
        $this->view->params['nav_header']= 'QS-Informationen';
        $this->view->params['nav_URL'] = '/reklamationen/auswertung';
      }
        elseif ($env == 'tk') {
          $this->layout = 'dashboard';
          $this->view->params['nav_background'] = '#337ab7';
          $this->view->params['nav_color'] = '#fff';
          $this->view->params['reload'] = 0; #Wert in Millisekunden#Wert in Millisekunden
          $this->view->params['nav_header']= 'Techniscreen';
          $this->view->params['nav_URL'] = '/reklamationen/auswertung';
        }

      $searchModel = new Reklamationen ();
      $dataProvider = $searchModel->getInterneReklamationen(Yii::$app->request->queryParams);
      $this->view->params['containerClass'] = 'container-fluid';

      return $this->render('interne_Reklamationen', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'env' => $env,
      ]);
    }

    protected function findModel($id)
    {
        if (($model = Reklamationen::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
