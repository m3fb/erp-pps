<?php

namespace app\controllers;
use app\models\Auswertung;
use Yii;



class AuswertungController extends \yii\web\Controller
{
    public $layout = 'auswertung';


public function actionPruef_unterbrechung()
{
    $model = new Auswertung();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();
		$linie= explode(":", $data['linie']);
		$linie= $linie[0];


        $id = $model->pruef_unterbrechung($linie);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $id;


    }
    // return $this->render('auftrag');
}



public function actionSchreib_unterbrechung()
{
    $model = new Auswertung();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();
		$linie= explode(":", $data['linie']);
		$linie= $linie[0];


        $id = $model->schreib_unterbrechung($linie);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $id;


    }
    // return $this->render('auftrag');
}


public function actionBez_unterbrechung()
{
    $model = new Auswertung();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();
        $id= explode(":", $data['id']);
		$id= $id[0];
		$pnr= explode(":", $data['pnr']);
		$pnr= $pnr[0];
        $grund= explode(":", $data['grund']);
		$grund= $grund[0];


        $rueck = $model->bez_unterbrechung($id,$pnr,$grund);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $rueck;


    }
    // return $this->render('auftrag');
}


public function actionBeende_unterbrechung()
{
    $model = new Auswertung();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();
        $id= explode(":", $data['id']);
		$id= $id[0];



        $rueck = $model->beende_unterbrechung($id);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $rueck;


    }
    // return $this->render('auftrag');
}













public function actionAuftrag_such()
{
    $model = new Auswertung();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();
		$artnr= explode(":", $data['artnr']);
		$artnr= $artnr[0];
        $werkzeug= explode(":", $data['werkzeug']);
		$werkzeug= $werkzeug[0];
        $start= explode(":", $data['start']);
		$start= $start[0];
        $ende= explode(":", $data['ende']);
		$ende= $ende[0];

        $auftraege = $model->artnr($artnr,$werkzeug,$start,$ende);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $auftraege;


    }
    // return $this->render('auftrag');
}


public function actionLinie_such()
{
    $model = new Auswertung();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();

        $linie= explode(":", $data['linie']);
		$linie= $linie[0];


        $auftraege = $model->linie_such($linie);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $auftraege;


    }
    // return $this->render('auftrag');
}




public function actionStreckenlog_daten()
{
    $model = new Auswertung();
	if (Yii::$app->request->isAjax) {
		$data = Yii::$app->request->post();
        $linie= explode(":", $data['linie']);
		$linie= $linie[0];
        $logs = $model->linien2($linie);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $logs;


    }
    // return $this->render('auftrag');
}







    public function actionIndex()
    {
        $model = new Auswertung();
        return $this->render('index');
    }
    public function actionAuswertung()
    {
        $model = new Auswertung();
        return $this->render('auswertung');
    }

    public function actionLinien2()
    {
        $model = new Auswertung();
        return $this->render('linien2');
    }
    public function actionLinien3()
    {
        $model = new Auswertung();
        return $this->render('linien3');
    }

    public function actionLinien3Dash()
        {
            $this->view->params['containerClass'] = 'container-fluid';

    		$this->layout = 'dashboard';
    		$this->view->params['nav_background'] = '#337ab7';
    		$this->view->params['nav_color'] = '#fff';
    		$this->view->params['reload'] = 0; #Wert in Millisekunden
    		$this->view->params['nav_header']= 'Techniscreen';
    		$this->view->params['nav_URL'] = '';

            $model = new Auswertung();
            return $this->render('linien3');
        }
    public function actionLinien3QsDash()
      {
          $this->layout = 'dashboard';
          #$this->view->params['containerClass'] = 'container';
          $this->view->params['nav_background'] = '#f2dede';
          $this->view->params['nav_color'] = '#a94442';
          $this->view->params['reload'] = 3600000; #Wert in Millisekunden#Wert in Millisekunden
          $this->view->params['nav_header']= 'Linienübersicht';
          $this->view->params['nav_URL'] = '/reklamationen/auswertung';

          $model = new Auswertung();
          return $this->render('linien3');
      }

    public function actionLinie13()
    {
        $model = new Auswertung();
        return $this->render('linie13');
    }

    public function actionWerkzeug()
    {
        $model = new Auswertung();
        return $this->render('werkzeug');
    }



    public function actionLinien()
    {
        $model = new Auswertung();
        if (Yii::$app->request->post()) {
           // $this->redirect(yii\helpers\Url::toRoute(['auswertung/auftrag',['input_lgnr'=>$model->input_lgnr]]));
           // $this->render("auftrag",["input_lgnr" => $model->input_lgnr]);
           if(!array_key_exists('input_lgnr',$_POST))
               $lgnr = "";
           else
               $lgnr = $_POST['input_lgnr'];

           if(!array_key_exists('input_artnr',$_POST))
               $artnr = "";
           else
               $artnr = $_POST['input_artnr'];

           if(!array_key_exists('input_orno',$_POST))
               $orno = "";
           else
               $orno = $_POST['input_orno'];

           Yii::$app->response->redirect(['auswertung/auftrag','input_lgnr' => $lgnr, 'input_artnr' => $artnr, 'input_orno' => $orno]);
        }
        else{
            return $this->render('linien', ['model' => $model]);
        }
    }





    public function actionLinie()
    {
        $model = new Auswertung();
        return $this->render('linie');
    }

    public function actionPilog()
    {
        $model = new Auswertung();
        return $this->render('pilog');
    }
    public function actionAuftrag()
    {
        $model = new Auswertung();
        return $this->render('auftrag');
    }


    public function actionVergleich()
    {
        $model = new Auswertung();
        return $this->render('vergleich');
    }

    public function actionAuftrag2()
    {
        $model = new Auswertung();
        return $this->render('auftrag2');
    }
}
