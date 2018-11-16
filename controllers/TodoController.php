<?php

namespace app\controllers;

use Yii;
use app\models\Todo;
use app\models\TodoSearch;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use app\models\AccessRule;

/**
 * TodoController implements the CRUD actions for Todo model.
 */
class TodoController extends Controller
{


    public function behaviors()
    {
        return [
          'access' => [
                    'class' => AccessControl::className(),
                    'only' => ['index','create','update','delete','aufgaben-konstruktion','aufgaben-konstruktion-quickview'],
                    'ruleConfig' => [
                        'class' => AccessRule::className(),
                    ],
                    'rules' => [
                        [
                            'actions' => ['index','create','update','delete','aufgaben-konstruktion','aufgaben-konstruktion-quickview'],
                            'allow' => true,
                            'roles' => [
                              User::ROLE_VERWALTER,
                              User::ROLE_ENTSCHEIDER,
                            	User::ROLE_ABRECHNER,
                            	User::ROLE_ADMIN
                          ],
                        ],
                    ],
                ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Todo models.
     * @return mixed
     */
    public function actionIndex($env)
    {
        $searchModel = new TodoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'env' => $env,
        ]);
    }

    public function actionAufgabenKonstruktion($env)
    {
        $searchModel = new TodoSearch();
        $dataProvider = $searchModel->konstruktionAufgaben(Yii::$app->request->queryParams);

        return $this->render('konstruktion_todo', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'env' => $env,
        ]);
    }

    public function actionAufgabenKonstruktionQuickview($env)
    {

        #Yii::$app->request->setQueryParams(['beauftragter'=>'Fabian Braun']);
        $searchModel = new TodoSearch();
        if (!isset(Yii::$app->request->queryParams['TodoSearch']['beauftragter'])){
              $searchModel->beauftragter = Yii::$app->user->identity->firstname.' '.Yii::$app->user->identity->surename;
        }
        $dataProvider = $searchModel->konstruktionAufgaben(Yii::$app->request->queryParams);
        $this->layout = 'quickview';
        $this->view->params['reload'] = 120000;
        return $this->render('konstruktion_todo_quickview', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'env' => $env,
        ]);
    }

    /**
     * Displays a single Todo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id,$env)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'env' => $env,
        ]);
    }

    /**
     * Creates a new Todo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($env)
    {
        $model = new Todo();
        //19.07.2018 Fileupload wird nicht mehr benötigt.
        /*$file = UploadedFile::getInstance($model, 'src');
        if (Yii::$app->request->post()){
            $model->load(Yii::$app->request->post());
            if($file)
                $model->src = "../PDFs/technikum/". $file->baseName . '.' . $file->extension;
            $model->save();*/

        if ($model->load(Yii::$app->request->post()) && $model->save()){

            if($env=='konstruktion'){
              return $this->redirect(['aufgaben-konstruktion','env'=>$env]);
            }
            elseif($env=='konstruktion_qv'){
                return $this->redirect(['aufgaben-konstruktion-quickview','env'=>$env]);
              } else{
              return $this->redirect(['index','env'=>$env]);
            }

        } else {
            if($env=='konstruktion_qv'){
              $this->layout = 'quickview';
              $this->view->params['reload'] = 0;
            }
            return $this->render('create', [
                'model' => $model,
                'env' => $env,
            ]);
        }
    }

    /**
     * Updates an existing Todo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id,$env)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
          if($env=='konstruktion'){
              return $this->redirect(['aufgaben-konstruktion','env'=>$env]);
            }
            elseif($env=='konstruktion_qv'){
                return $this->redirect(['aufgaben-konstruktion-quickview','env'=>$env]);
              } else{
              return $this->redirect(['index','env'=>$env]);
            }

        } else {
          if($env=='konstruktion_qv'){
              $this->layout = 'quickview';
              $this->view->params['reload'] = 0;
            }
            return $this->render('update', [
                'model' => $model,
                'env' => $env,
            ]);
        }
    }

    /**
     * Deletes an existing Todo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id,$env)
    {
        $this->findModel($id)->delete();

        if($env=='konstruktion'){
            return $this->redirect(['aufgaben-konstruktion','env'=>$env]);
          }
          elseif($env=='konstruktion_qv'){
              return $this->redirect(['aufgaben-konstruktion-quickview','env'=>$env]);
            } else{
            return $this->redirect(['index','env'=>$env]);
          }
    }

    /**
     * Finds the Todo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Todo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Todo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
