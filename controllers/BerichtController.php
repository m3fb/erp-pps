<?php

namespace app\controllers;

use Yii;
use app\models\Bericht;
use app\models\BerichtSearch;
use app\models\Maschine;
use app\models\Artikeldaten;
use app\models\Mehrfachlager;
use app\models\Pa_paper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use mPDF;
use yii\filters\AccessControl;

/**
 * BdeController implements the CRUD actions for Bde model.
 */
class BerichtController extends Controller
{
    #public $layout = 'bericht';
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
                'only' => ['index','rueckstand','planungsliste','kaufteile','spedverw'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','rueckstand','planungsliste','kaufteile','spedverw'],
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
        return $this->render('index');

    }



    public function actionRueckstand($type)
    {
        $searchModel = new BerichtSearch();
        $dataProvider = $searchModel->searchRueckstand(Yii::$app->request->queryParams,$type);

        return $this->render('rueckstand', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type' => $type,
        ]);
    }

        public function actionReklamationen($type)
    {
        $searchModel = new BerichtSearch();
        $dataProvider = $searchModel->searchReklamationen(Yii::$app->request->queryParams,$type);

        return $this->render('reklamationen', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type' => $type,
        ]);
    }
        public function actionSpedverw()
    {
        $searchModel = new BerichtSearch();
        $dataProvider = $searchModel->searchSpedauftr(Yii::$app->request->queryParams);

        return $this->render('spedverw', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

        public function actionBeleg()
    {
        $searchModel = new BerichtSearch();
        $dataProvider = $searchModel->searchBeleg(Yii::$app->request->queryParams);

        return $this->render('beleg', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionBelegquit($id)
    {
		$searchModel = new BerichtSearch();
        $dataProvider = $searchModel->find()->from('PA_POSIT')->where(['PANO'=>$id])->all();
        $cur_date = Yii::$app->formatter->asDateTime('now',"dd.MM.Y H:mm:ss");
        foreach( $dataProvider as $model){
    			$pono = $model['PONO'];
    			$menge =  $model['MENGE'];

    			#echo $pono . "<br>";
    			#echo $menge . "<br>";
    			#echo $cur_date. "<br>";
    			$model2 = Bericht::findOne($pono);
    			$model2->POSLIEF0 = $menge;
    			$model2->CHNAME = 'Zusatzanwendung';
    			$model2->CHDATE = $cur_date;
    			$model2->save();
		     }
		$model3 = Pa_paper::findOne($id);
		$model3->STATUS = 2;
		$model3->CHNAME = 'Zusatzanwendung';
		$model3->CHDATE = $cur_date;
		$model3->save();
		$dataProvider2 = $searchModel->searchSpedauftr(Yii::$app->request->queryParams);
			#print_r($model);
		return $this->render('spedverw', [
            'dataProvider' => $dataProvider2,
            'searchModel' => $searchModel,
        ]);
	}
        public function actionSelect_sped ($id)
    {
		$searchModel = new BerichtSearch();
        $dataProvider = $searchModel->findSped($id);

		$models = $dataProvider->getModels();
		if($models) {
			 $vorgangsnr = $models[0]['TXTNUMMER'];
			 }
			 else {
				  $model = Pa_paper::findOne($id);
				  $vorgangsnr =$model->TXTNUMMER.' --> Keine auswertbaren Daten vorhanden' ;
			  }

		$sumgpreis = $searchModel->getGpreisSum($id);

		return $this->render('sped_ausw', [
            'dataProvider' => $dataProvider,
            #'Speditionskosten' => $Speditionskosten,
            'vorgangsnr' => $vorgangsnr,
            'id' => $id,
            'sumgpreis' => $sumgpreis,
        ]);
	}

    public function actionPlanungsliste($wp_name,$plan_time)
    {
        $searchModel = new BerichtSearch();
        $dataProvider = $searchModel->searchPlanungsliste(Yii::$app->request->queryParams,$wp_name,$plan_time);
        $maschinenListe = Maschine::find()->select(['WP_MA1.NO','WP_MA1.NAME'])->where(['TERMNO' => 0])->orderBy('NAME')->asArray()->all();

        return $this->render('planungsliste', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'maschinenListe' => $maschinenListe,
            'plan_time' => $plan_time,
            'wp_name' => $wp_name,
        ]);
    }
    public function actionKaufteile($kaufteil_no)
    {
        $searchModel = new BerichtSearch();
        $dataProvider = $searchModel->searchKaufteile(Yii::$app->request->queryParams,$kaufteil_no);
        $kaufteileListeRaw = $searchModel->findKaufteile();

		foreach ($kaufteileListeRaw as $item){
			$artikelnr = $item['ARTDESC'];
			strlen($item['POSTEXT']) > 72 ? $artikeltext = substr($item['POSTEXT'],0,72) : $artikeltext=$item['POSTEXT'];
			$artikeltext_ausg = $artikelnr." ".$artikeltext;
			$item['POSTEXT'] = $artikeltext_ausg;
			$kaufteileListe[] = $item;
		}

        return $this->render('kaufteile', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'kaufteileListe' => $kaufteileListe,
            'kaufteil_no' => $kaufteil_no,
        ]);
    }

    public function actionBearbeiten($id,$type)
    {
		return $this->render('l_rekl_view', [
            'model' => $this->findModel($id),
            'type' => $type,
        ]);
	}
	 protected function findModel($id)
    {
        if (($model = Bericht::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionRekl_update($id,$type)
    {
		$model = Bericht::findOne($id);

		$model->POSLIEF0 = $model->MENGE;
        $model->save();

		return $this->redirect(['reklamationen','type'=>$type]);


	}



  }
