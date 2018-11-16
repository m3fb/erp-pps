<?php

namespace app\controllers;
use app\models\Technikum;
use Yii;



class TechnikumController extends \yii\web\Controller
{
    public $layout = 'technikum';


    public function actionIndex()
    {

        $this->layout = 'dashboard';
    		$this->view->params['nav_background'] = '#337ab7';
    		$this->view->params['nav_color'] = '#fff';
    		$this->view->params['reload'] = 0; #Wert in Millisekunden
    		$this->view->params['nav_header']= 'Techniscreen';
    		$this->view->params['nav_URL'] = '';

        $model = new Technikum();
        return $this->render('index');
    }



    public function actionEingabe()
    {
        $model = new Technikum();
        return $this->render('eingabe');
    }




public function actionTodoliste()
{
    $model = new Technikum();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();

        // $linie= explode(":", $data['linie']);
		// $linie= $linie[0];


        $todos = $model->todo_liste();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $todos;


    }
    // return $this->render('auftrag');
}



public function actionReklamationen()
{
    $model = new Technikum();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();

        // $linie= explode(":", $data['linie']);
		// $linie= $linie[0];


        $todos = $model->reklamationen();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $todos;


    }
    // return $this->render('auftrag');
}




public function actionTodozyklus()
{
    $model = new Technikum();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();

        // $linie= explode(":", $data['linie']);
		// $linie= $linie[0];


        $todos = $model->todo_pruef_anzeigen();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $todos;


    }
    // return $this->render('auftrag');
}

public function actionTodo_loesch_zyklus()
{
    $model = new Technikum();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();

        $id= explode(":", $data['id']);
		$id= $id[0];


        $todos = $model->todo_loesch_zyklus($id);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $todos;


    }
    // return $this->render('auftrag');
}

public function actionTodo_zurueck_zyklus()
{
    $model = new Technikum();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();

        $id= explode(":", $data['id']);
		$id= $id[0];


        $todos = $model->todo_zurueck_zyklus($id);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $todos;


    }
    // return $this->render('auftrag');
}


public function actionTodoerledigt()
{
    $model = new Technikum();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();

         $id= explode(":", $data['id']);
		 $id= $id[0];
         $start= explode("=", $data['start']);
		 $start= $start[0];

         $zyklus= explode(":", $data['zyklus']);
		 $zyklus= $zyklus[0];

        $todos = $model->todo_erledigt($id,$start,$zyklus);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $todos;


    }
    // return $this->render('auftrag');
}


public function actionTodoeingabe()
{
    $model = new Technikum();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();

        $text= explode(":", $data['todo_text']);
		$text = $text[0];
        $start= explode(":", $data['input_start']);
		$start = $start[0];
        $ende= explode(":", $data['input_ende']);
		$ende = $ende[0];
        $beauftragter= explode(":", $data['beauftragter']);
		$beauftragter = $beauftragter[0];
        $zyklus= explode(":", $data['todo_zyklus']);
		$zyklus = $zyklus[0];
        $prio= explode(":", $data['todo_prio']);
		$prio = $prio[0];



        $todos = $model->todo_eingabe($start,$ende,$zyklus,$prio,$text,$beauftragter);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $todos;


    }
    // return $this->render('auftrag');
}
}
