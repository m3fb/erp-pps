<?php

namespace app\controllers;

use Yii;
use app\models\M3UrlaubStunden;
use app\models\M3UrlaubStundenSearch;
use app\models\Personal;
use app\models\PersonalSearch;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\AccessRule;
/**
 * M3UrlaubStundenController implements the CRUD actions for M3UrlaubStunden model.
 */
class M3UrlaubStundenController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                       'class' => AccessRule::className(),
                   ],
                'rules' => [
                    [
                        'actions' => ['index','view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['create','update','delete'],
                        'allow' => true,
                        'roles' => [User::ROLE_ENTSCHEIDER,User::ROLE_ABRECHNER, User::ROLE_ADMIN],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all M3UrlaubStunden models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new M3UrlaubStundenSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single M3UrlaubStunden model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new M3UrlaubStunden model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new M3UrlaubStunden();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['personal/view', 'id' => $id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'id'=>$id,
                'name'=>Personal::findOne($id)->FIRSTNAME.' '. Personal::findOne($id)->SURNAME,
            ]);
        }
    }

    /**
     * Updates an existing M3UrlaubStunden model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $WORKID = $model->WORKID;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['personal/view', 'id' => $WORKID]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'id'=>$WORKID,
                'name'=>Personal::findOne($WORKID)->FIRSTNAME.' '. Personal::findOne($WORKID)->SURNAME,
            ]);
        }
    }

    /**
     * Deletes an existing M3UrlaubStunden model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $WORKID = $model->WORKID;
        $this->findModel($id)->delete();        

        return $this->redirect(['personal/view', 'id' => $WORKID]);
    }

    /**
     * Finds the M3UrlaubStunden model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return M3UrlaubStunden the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = M3UrlaubStunden::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
