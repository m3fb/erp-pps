<?php

namespace app\controllers;
use Yii;
use app\models\Fauserbuchungen;
use app\models\User;
use app\models\AccessRule;
use yii\web\Controller; 
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class FauserbuchungenController extends \yii\web\Controller
{
    public function actionLagereingang()
    {
        
        $model = new Fauserbuchungen();
        return $this->render('lagereingang', ['model' => $model]);
    }
    
    public function actionEinlagerung()
    {
        
        $model = new Fauserbuchungen();
        return $this->render('einlagerung', ['model' => $model]);
    }
    
    public function actionSchreib()
    {
        
        $model = new Fauserbuchungen();
        return $this->render('schreib', ['model' => $model]);
    }

}
