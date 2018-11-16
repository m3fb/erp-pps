<?php

namespace app\controllers;

use Yii;
use app\models\FahrtenPositionen;
use app\models\FahrtenBelege;
use app\models\User;
use app\models\AccessRule;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;

/**
 * UrlaubController implements the CRUD actions for Urlaub model.
 */
class FahrtenController extends Controller
{


### Zugriffsrechte für einzelne Usergruppen
// Die individuelle Anzeige für Navbar etc findet sich in den Layouts
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
                   'class' => \yii\filters\AccessControl::className(),
                   // We will override the default rule config with the new AccessRule class
                   'ruleConfig' => [
                       'class' => AccessRule::className(),
                   ],
                   'only' => ['index','abrechnung','antrag', 'manager', 'schicht','verwaltung'],
                   'rules' => [
                       [
                           'actions' => ['index','antrag'],
                           'allow' => true,

                           'roles' => [
                             User::ROLE_ADMIN,
              							 User::ROLE_USER,
              							 User::ROLE_VERWALTER,
              							 User::ROLE_ABRECHNER
                           ],
                       ],
                       [
                           'actions' => ['manager','schicht','abrechnung','verwaltung'],
                           'allow' => true,

                           'roles' => [
                               User::ROLE_ADMIN,
              							   User::ROLE_ENTSCHEIDER,
              							   User::ROLE_ABRECHNER

                           ],
                       ],
					   [
                           'actions' => ['abrechnung'],
                           'allow' => true,

                           'roles' => [
                               User::ROLE_ADMIN,
							   User::ROLE_ABRECHNER

                           ],
                       ],
                   ],
               ],
           ];
       }





    /**
     * Lists all Urlaub models.
     * @return mixed
     */
    public function actionIndex()
    {
        $umwegfahrten = Fahrtenpositionen::find()
						->where(['Status'=>0])
						->andWhere(['Typ'=>0])
						->andWhere(['username'=>Yii::$app->user->identity->username])
						->all();
        $standardfahrten = Fahrtenpositionen::find()
						->where(['Status'=>0])
						->andWhere(['Typ'=>1])
						->andWhere(['username'=>Yii::$app->user->identity->username])
						->all();

        return $this->render('index', [
            'umwegfahrten' => $umwegfahrten,
            'standardfahrten' => $standardfahrten,
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
        $model = new FahrtenPositionen();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
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
