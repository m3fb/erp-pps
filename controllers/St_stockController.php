<?php

namespace app\controllers;

use Yii;
use app\models\St_stock;
use app\models\St_stockSearch;
use app\models\Art_customer;
use app\models\Cucomp;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * St_stockController implements the CRUD actions for St_stock model.
 */
class St_stockController extends Controller
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
     * Lists all St_stock models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new St_stockSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexList($artikelnr,$bezeichnung,$tool,$charge)
    {
        $searchModel = new St_stockSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single St_stock model.
     * @param string $id
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
     * Creates a new St_stock model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new St_stock();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->NO]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing St_stock model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->NO]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing St_stock model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionCustomerList($cu_no)
    {
      $partlist = Art_customer::find()->select(['ARTNO'])->where(['CONO'=>$cu_no]);
      $cu_list = Art_customer::find()->select(['CONO','CUSTNAME'])->orderBy('CUSTNAME')->all();
      $cu_infos = Cucomp::find()->select(['NAME','CNTRYSIGN'])->where(['CONO'=>$cu_no])->one();

      $searchModel = new St_stockSearch();
      $dataProvider = $searchModel->searchCustomerlist($partlist);
      $dataProvider->pagination->pageSize=0;

      return $this->render('customerlist', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'partlist' => $partlist,
          'cu_no' => $cu_no,
          'cu_list' => $cu_list,
          'cu_name' => $cu_infos['NAME'],
          'cu_cntrysign' => $cu_infos['CNTRYSIGN'],
      ]);
    }

    /**
     * Finds the St_stock model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return St_stock the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = St_stock::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
