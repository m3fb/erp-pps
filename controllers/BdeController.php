<?php

namespace app\controllers;

use Yii;
use app\models\Bde;
use app\models\BdeSearch;
use app\models\Personal;
use app\models\Fagdetail;
use app\models\M3TmpRueckmeldung;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
#use mPDF;
use kartik\mpdf\Pdf;
use yii\db\Query;

use yii\filters\AccessControl;

/**
 * BdeController implements the CRUD actions for Bde model.
 */
class BdeController extends Controller
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
                'only' => ['restore', 'archiv'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['restore', 'archiv'],
                        'roles' => ['@'],
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
        //25.09.2018 deaktiviert wegen direkter Rückmeldung
        /*$reuckmeldeModel = new M3TmpRueckmeldung;
        $rueckmeldeDataProvider = $reuckmeldeModel->search();
        $rueckmeldeDataProvider->query
          ->where(['Status'=>0]);*/

        $searchModel = new BdeSearch();
        $status = 0;
        $dataProvider = $searchModel->searchInd(Yii::$app->request->queryParams,$status,2);

        #$personalListe =Personal::find()->where(['STATUS1' => 0])->orderBy('SURNAME')->asArray()->all();


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            #'personalListe' => $personalListe,
            
            //25.09.2018 deaktiviert wegen direkter Rückmeldung
            #'rueckmeldeDataProvider' => $rueckmeldeDataProvider,
        ]);
    }

    public function actionArchiv($arch_time)
    {
        $searchModel = new BdeSearch();
        $dataProvider = $searchModel->searchInd(Yii::$app->request->queryParams,1,$arch_time);
        $personalListe =Personal::find()->where(['STATUS1' => 0])->orderBy('SURNAME')->asArray()->all();

          // validate if there is a editable input saved via AJAX
    if (Yii::$app->request->post('hasEditable')) {
        // instantiate your book model for saving
        $_id = Yii::$app->request->post('editableKey');
        $model = $this->findModel($_id);
        // store a default json response as desired by editable
        $out = Json::encode(['output'=>'', 'message'=>'']);

        // fetch the first entry in posted data (there should
        // only be one entry anyway in this array for an
        // editable submission)
        // - $posted is the posted data for Book without any indexes
        // - $post is the converted array for single model validation
        $post = [];
        $posted = current($_POST['Bde']);
		$post['Bde'] = $posted;

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
            if (isset($posted['ADCCOUNT']) ) {
               $output =  Yii::$app->formatter->asDecimal($model->ADCCOUNT, 0);
            }

            // similarly you can check if the name attribute was posted as well
            // if (isset($posted['name'])) {
            //   $output =  ''; // process as you need
            // }
            $out = Json::encode(['output'=>$output, 'message'=>'']);
        }
        // return ajax json encoded response and exit
        echo $out;
        return;
    }


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'personalListe' => $personalListe,
            'arch_time' => $arch_time,
            'rueckmeldeDataProvider' => NULL,
        ]);
    }

    /**
     * Displays a single Bde model.
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
     * Creates a new Bde model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Bde();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->LBNO]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Bde model.
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
     * Deletes an existing Bde model.
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
     * Finds the Bde model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Bde the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bde::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDemo()
	{


        $model = new Bde();

            return $this->render('view1', [
                'model' => $model,
            ]);

    }
    //5.08.2015: Etikett_1 wird nicht mehr benötigt und ist deaktiviert.
    public function actionEtikett1($id)
    {
        $model = BdeSearch::getOneReport($id);
        $model2 = Bde::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException;
        }
        #$this->layout = 'etikett';
        $content = $this->renderPartial('_etikett', ['model' => $model]);
		$stylesheet = file_get_contents('css/etikett.css');

		$model2->ISINTERNAL == NULL ? $isinternal = 0 : $isinternal = 2;
        $model2->ISINTERNAL = $isinternal;
        $model2->save();


        $mpdf = new PDF;
        $mpdf->SetTitle('m3-Pal_Etikett');
        $mpdf->AddPage('L'); //Ausrichtung Querformat (Landscape)
        $mpdf->WriteHTML($stylesheet,1);
        $mpdf->WriteHTML($content);
        $mpdf->Output();
        exit;


    }

    public function actionEtikett2($id)
    {
        $model = BdeSearch::getOneReport($id);

        $part_detail = Fagdetail::find()->where(['FKNO' => $model['ARTNO']])->andWhere(['TYP' => 5])->one();
        $part_tool_no = $part_detail['TXT05'];

        if ($model === null) {
            throw new NotFoundHttpException;
        }
        $model2 = Bde::findOne($id);
        $model2->ISINTERNAL = 2;
        $model2->save();

        if($model3 = M3TmpRueckmeldung::find()->where(['Auftrag'=>$model['ORNAME']])->andWhere(['Status'=>1])->orderBy('ID DESC')->one())
        {
          $model3->LBNO = $id;
          $model3->Status = 2;
          $model3->save();
        }

        #$this->layout = 'etikett';
        $content = $this->renderPartial('_etikett2', ['model' => $model,'part_tool_no'=>$part_tool_no]);
		    $stylesheet = file_get_contents('css/etikett2.css');


        $pdf = new Pdf([
        // set to use core fonts only
        'mode' => Pdf::MODE_UTF8,
        // A4 paper format
        'format' => [150,62],
        #'defaultFontSize' => 10,
        'marginLeft' => 2,
        'marginRight' => 2,
        'marginTop' => 2,
        'marginBottom' => 2,
        // portrait orientation
        'orientation' => Pdf::ORIENT_PORTRAIT,
        // stream to browser inline
        'destination' => Pdf::DEST_BROWSER,
        // your html content input
        'content' => $content,
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting
        'cssFile' => 'css/etikett2.css',
        // any css to be embedded if required
        //'cssInline' => '.kv-heading-1{font-size:18px}',
         // set mPDF properties on the fly
        'options' => ['title' => 'm3-Pal_Etikett2'],
         // call mPDF methods on the fly
        'methods' => [
            //'SetHeader'=>['Krajee Report Header'],
            //'SetFooter'=>['{PAGENO}'],
        ]
    ]);

    // return the pdf output as per the destination setting
    return $pdf->render();


    }



    public function actionRestore($id)
    {
        $model = Bde::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException;
        }
        $model->ISINTERNAL = NULL;
        $model->save();
        return $this->redirect(['index']);

    }

    public function actionManual()
    {
        return $this->render('manual');
    }

    public function actionBdeErledigt($id)
    {
        $model = M3TmpRueckmeldung::findOne($id);
        $model->Status = 1;
        $model->save();

        return $this->redirect(['index']);
    }

  }
