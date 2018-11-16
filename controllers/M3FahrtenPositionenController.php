<?php

namespace app\controllers;

use Yii;
use app\models\M3FahrtenPositionen;
use app\models\M3FahrtenPositionenSearch;
use app\models\Cucomp;
use app\models\Personal;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\AccessRule;
use kartik\mpdf\Pdf;

/**
 * M3FahrtenPositionenController implements the CRUD actions for M3FahrtenPositionen model.
 */
class M3FahrtenPositionenController extends Controller
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
                   'only' => ['index','create','update','delete','index-verwaltung','export','umweg-bearbeiten','umweg-erledigt'],
                   'rules' => [
                       [
                           'actions' => ['index','create','update','delete'],
                           'allow' => true,

                           'roles' => [
                             User::ROLE_ADMIN,
              							 User::ROLE_USER,
              							 User::ROLE_VERWALTER,
              							 User::ROLE_ABRECHNER
                           ],
                       ],
                       [
                           'actions' => ['manager','schicht','abrechnung','index-verwaltung','umweg-bearbeiten','umweg-erledigt'],
                           'allow' => true,

                           'roles' => [
                               User::ROLE_ADMIN,
              							   User::ROLE_ENTSCHEIDER,
              							   User::ROLE_ABRECHNER
                           ],
                       ],
                   ],
               ],
        ];
    }

    /**
     * Lists all M3FahrtenPositionen models.
     * @return mixed http://m3mssql/m3adminV3_dev/web/index.php?M3FahrtenPositionenSearch%5BID%
     */
    public function actionIndex()
    {
        $searchModelUmweg = new M3FahrtenPositionenSearch();
        $dataProviderUmweg = $searchModelUmweg->search(Yii::$app->request->queryParams);
        $dataProviderUmweg->query->andWhere(['username'=>Yii::$app->user->identity->username]);
        $dataProviderUmweg->query->andWhere(['Typ'=>0]);

        $searchModelStandard = new M3FahrtenPositionenSearch();
        $dataProviderStandard = $searchModelStandard->search(Yii::$app->request->queryParams);
        $dataProviderStandard->query->andWhere(['username'=>Yii::$app->user->identity->username]);
        $dataProviderStandard->query->andWhere(['Typ'=>1]);

        return $this->render('index', [
            'searchModelUmweg' => $searchModelUmweg,
            'dataProviderUmweg' => $dataProviderUmweg,
            'searchModelStandard' => $searchModelStandard,
            'dataProviderStandard' => $dataProviderStandard,
        ]);
    }
    public function actionIndexVerwaltung()
    {
        $searchModelUmweg = new M3FahrtenPositionenSearch();
        $dataProviderUmweg = $searchModelUmweg->search(Yii::$app->request->queryParams);
        $dataProviderUmweg->query
          ->andWhere(['Typ'=>0])
          ->andWhere(['<','Status',2])
          ->addOrderBy('username ASC');

        $searchModelStandard = new M3FahrtenPositionenSearch();
        $dataProviderStandard = $searchModelStandard->search(Yii::$app->request->queryParams);
        $dataProviderStandard->query
          ->andWhere(['Typ'=>1])
          ->andWhere(['<','Status',2])
          ->addOrderBy('username ASC');

        return $this->render('index_verwaltung', [
          'searchModelUmweg' => $searchModelUmweg,
          'dataProviderUmweg' => $dataProviderUmweg,
          'searchModelStandard' => $searchModelStandard,
          'dataProviderStandard' => $dataProviderStandard,
        ]);
    }

    public function actionUmwegBearbeiten($FahrtdatumMonat,$FahrtdatumJahr)
    {
        $searchModelUmweg = new M3FahrtenPositionenSearch();
        $dataProviderUmweg = $searchModelUmweg->search(Yii::$app->request->queryParams);
        $dataProviderUmweg->query
          ->andWhere(['Typ'=>0])
          ->andWhere(['<','Status',2])
          ->andWhere(['MONTH(Fahrtdatum)' => $FahrtdatumMonat])
          ->andWhere(['YEAR(Fahrtdatum)' => $FahrtdatumJahr])
          ->addOrderBy('username ASC');
          // All 'aktiven' Jahreszahlen, die in der Datenbank vorkommen,
          //  auswählen. Diese werden dem Filterarry übergeben
          $jahresliste = $searchModelUmweg->find()
              ->select('YEAR(Fahrtdatum) as jahreswert')
              ->where(['Typ'=>0])
              ->andWhere(['<','Status',2])
              ->asArray()
              ->distinct()
              ->all();


        return $this->render('umweg_bearbeiten', [
          'searchModelUmweg' => $searchModelUmweg,
          'dataProviderUmweg' => $dataProviderUmweg,
          'FahrtdatumMonat' =>$FahrtdatumMonat,
          'FahrtdatumJahr' =>$FahrtdatumJahr,
          'jahresliste' => $jahresliste,
        ]);
    }

    /**
     * Displays a single M3FahrtenPositionen model.
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
     * Creates a new M3FahrtenPositionen model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new M3FahrtenPositionen();
        $model->username = $request->get('username', Yii::$app->user->identity->username);
		    $model->Status = 0;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing M3FahrtenPositionen model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $model->Fahrtdatum = Yii::$app->formatter->format($model->Fahrtdatum, 'datetime');
		    $model->username = $request->get('username', Yii::$app->user->identity->username);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    // Funktion wird vom Javascript aufgerufen und dient zur Befüllung der Adressefelder.
    // Privatadressen müssen unterschiedlich zu Firmenadressen behandelt.
    public function actionGetLocationAddress($CONO)
  	{
  		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
  		if (substr($CONO,0,4) == '9999'){     //Privatadressen werden mit dem Prefix 9999 gekennzeichnet
        $id = substr($CONO,4);              //Personal ID extrahieren
  			return Personal::find()->where(['NO'=>$id])->one();
  		}
  		else {
  			return Cucomp::find()->where('CONO = :CONO', [':CONO' => $CONO])->one();
  		}

  	}

    public function actionFinish($id)
    {
        $model = $this->findModel($id);
        $model->Status = 2;
        $model->save();

        return $this->redirect(['index-verwaltung']);
    }

    //Funktion ist noch nicht aktiv. Kann für die Erstellung der Standardfahrtenbelege benutzt werden.
    public function actionExport()
    {
      $searchModel = new M3FahrtenPositionenSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
     # $dataProviderStandard->query->andWhere(['username'=>Yii::$app->user->identity->username]);

      $dataProvider->query
        ->andWhere(['Status'=>0])
        ->andWhere(['Typ'=>0])
        ->orderby('Typ DESC')
        ->addOrderBy('username ASC');

      #$content = $this->renderPartial('_export_umwegfahrten', [
      #      'dataProvider' => $dataProvider,
    #    ]);
    /*  $pdf = new Pdf([
          // set to use core fonts only
          'mode' => Pdf::MODE_UTF8,
          // A4 paper format
          'format' => Pdf::FORMAT_A4,
          #'defaultFontSize' => 10,
          'marginLeft' => 2,
          'marginRight' => 2,
          'marginTop' => 2,
          'marginBottom' => 2,
          // portrait orientation
          'orientation' => Pdf::ORIENT_LANDSCAPE,
          // stream to browser inline
          'destination' => Pdf::DEST_BROWSER,
          // your html content input
          'content' => $content,
          // format content from your own css file if needed or use the
          // enhanced bootstrap css built by Krajee for mPDF formatting
          'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
          #'cssFile' => 'css/etikett2.css',
          // any css to be embedded if required
          'cssInline' => '.kv-wrap{padding:20px;}' .
              '.kv-align-center{text-align:center;}' .
              '.kv-align-left{text-align:left;}' .
              '.kv-align-right{text-align:right;}' .
              '.kv-align-top{vertical-align:top!important;}' .
              '.kv-align-bottom{vertical-align:bottom!important;}' .
              '.kv-align-middle{vertical-align:middle!important;}' .
              '.kv-page-summary{border-top:4px double #ddd;font-weight: bold;}' .
              '.kv-table-footer{border-top:4px double #ddd;font-weight: bold;}' .
              '.kv-table-caption{font-size:1.5em;padding:8px;border:1px solid #ddd;border-bottom:none;}',
          #'cssInline' => '.kv-heading-1{font-size:18px}',
           // set mPDF properties on the fly
          'options' => ['title' => 'm3-Export-Umwegfahrten'],
           // call mPDF methods on the fly
          'methods' => [
              //'SetHeader'=>['Krajee Report Header'],
              //'SetFooter'=>['{PAGENO}'],
          ]
      ]);*/

      // return the pdf output as per the destination setting
      #return $pdf->render();

      return $this->render('_export_umwegfahrten', [
          'dataProvider' => $dataProvider,
      ]);
    }

    public function actionUmwegErledigt($FahrtdatumMonat,$FahrtdatumJahr)
    {
      M3FahrtenPositionen::updateAll(['Status' => 2], 'Status=0 and Typ=0 and MONTH(Fahrtdatum)='.$FahrtdatumMonat.' and YEAR(Fahrtdatum)='.$FahrtdatumJahr);
      //Nach der Verarbeitung Umleitung auf die Verwaltungsübersicht
      return $this->redirect(['index-verwaltung']);
    }

    /**
     * Deletes an existing M3FahrtenPositionen model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the M3FahrtenPositionen model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return M3FahrtenPositionen the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = M3FahrtenPositionen::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
