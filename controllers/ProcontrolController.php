<?php

namespace app\controllers;

use Yii;
use app\models\Procontrol;
use app\models\Maschine;
use app\models\Order;
use app\models\Or_op;
use app\models\M3Termine;
use app\models\M3TmpRueckmeldung;
use app\models\Fagdetail;
use app\models\Pa_artpos;
use app\models\Is_num;
use app\models\Lb_dc;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\filters\AccessControl;
use yii\data\ArrayDataProvider;
use kartik\grid\EditableColumnAction;
use yii\helpers\ArrayHelper;

/**
 * BdeController implements the CRUD actions for Bde model.
 */
class ProcontrolController extends Controller
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
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $this->layout = 'procontrol';

        return $this->render('index'
			);

    }
    public function actionTasks($linie)
    {
      $startedTasks = Procontrol::getStartedTasks($linie);
      var_dump($startedTasks); die;
    }


    public function actionAuswahl($linie)
    {
        $this->layout = 'procontrol';
        $searchModel = new Procontrol();
        $dataProvider = $searchModel->findOpenProcesses(Yii::$app->request->queryParams,$linie);
        $maschine = Maschine::findOne($linie);
        $dataBde = $searchModel->findLastBde($maschine->NAME);

        $userInfo = Procontrol::getUserInfo();


        $startedTasks = Procontrol::getStartedTasks($linie);
        if ($startedTasks > 1) Yii::$app->session->setFlash('msg', '
            <div class="alert alert-danger alert-dismissable" id="task_fehler">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <strong>Mehere Aufträge gestarted! </strong> Keine Aktion möglich. Bitte im BDE System korrigieren!</div>
            <div><button class ="btn btn-danger" id="error_refresh"><i class="glyphicon glyphicon-refresh"></i></button></div>'
         );

        /*Prüfe ob aktuelles Datum im Bereich eines eingetragenen Kundentermin liegt. Startdatum muss kleiner als aktuelles Datum sein und Enddatum muss größer als aktuelles Datum sein.
         * Wenn dies zutrifft wird der werd 1 zurückgegeben ansonsten 0.
         */
        $kundentermin = M3Termine::getCustomerDateCheck();

        if ($currentSpeed = $searchModel->getCurrentSpeed($maschine->NAME)) {

				#$currentSpeed = $searchModel->getCurrentSpeed($maschine->NAME);
				$lastProcessChange = $searchModel->getlastProcessChange($maschine->NAME,$currentSpeed->log_GESCHWINDIGKEIT);
				$date1 = new \DateTime('NOW');
				$date2 = new \DateTime($lastProcessChange->log_MSTIME);
				$interval = $date1->diff($date2);

				return $this->render('auswahl',[
					'searchModel' =>$searchModel,
					'dataProvider' =>$dataProvider,
					'linie' => $linie,
					'maschine' => $maschine,
					'dataBde' => $dataBde,
					'currentSpeed' =>$currentSpeed,
					'lastProcessChange' => $lastProcessChange,
					'interval' => $interval,
					'kundentermin' => $kundentermin,
          'startedTasks' => $startedTasks,
          'userInfo' => $userInfo,
					]);
		}
		else {

				return $this->render('auswahl',[
					'searchModel' =>$searchModel,
					'dataProvider' =>$dataProvider,
					'linie' => $linie,
					'maschine' => $maschine,
					'dataBde' => $dataBde,
					'currentSpeed' =>NULL,
					'kundentermin' => $kundentermin,
          'startedTasks' => $startedTasks,
          'userInfo' => $userInfo,
					]);
		}



    }

    public function actionProconplanung($maschine)
    {
        $searchModel = new Procontrol();
        $dataProvider = $searchModel->findOpenOrders(Yii::$app->request->queryParams,$maschine);
        $maschine = Maschine::findOne($maschine);

        return $this->render('proconplanung',[
  			'searchModel' =>$searchModel,
  			'dataProvider' =>$dataProvider,
  			'maschine' => $maschine,
			]);

    }

    public function actionShowCustomerDates()
    {
  		$searchModel = new M3Termine();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams,99);
      $kundentermin = M3Termine::getCustomerDateCheck();

        return $this->render('customerdates',[
    			'searchModel' => $searchModel,
    			'dataProvider' =>$dataProvider,
          'kundentermin' => $kundentermin,
    			]);

    }
    public function actionCreateCustomerDates()
    {
        $model = new M3Termine();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['show-customer-dates']);
        } else {
            return $this->render('createcustomerdates', [
                'model' => $model,
            ]);
        }
    }
    public function actionTestId()
    {
      $userInfo = Procontrol::getUserInfo();
      echo 'm3IdentTest:<br>';
      var_dump($userInfo);
    }

    /**
    * Diese Funktion ändert den Status eines Arbeitsgangs ohne Rückmeldung
    * Es wird die AG-Id, der gewünschte Status und die Produktionslinie benötigt.
    */
    public function actionStatusAg($id,$status,$linie)
    {
      /**
      * Benutzererkennung bzw. Benutzerinformationen
      */
      $userInfo = Procontrol::getUserInfo();

      if($userInfo['persno'] != 0){
        $vorname = $userInfo['vorname'];
        $nachname = $userInfo['nachname'];
        $persno = $userInfo['persno'];

        //Datum für alle Einträge
        $cur_date = date('d.m.Y H:i:s');

        $stueckzahl=0;
        $dateDiff = 1;
        $this->createLbdc($id, $status,$userInfo, $stueckzahl, $cur_date);

        return $this->redirect(['auswahl',
              'linie'=>$linie,
              'userInfo'=>$userInfo]);
      }
      else {
        Yii::$app->session->setFlash('msg', '
            <div class="alert alert-danger alert-dismissable" id="benutzer_fehler">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <strong>Benutzererkennung fehlgeschlagen! </strong> Keine Aktion möglich</div>'
         );
         $userInfo = [];
         $vorname = '';
         $nachname = '';
         $persno = '';
         return $this->redirect(['auswahl',
               'linie'=>$linie,
               'userInfo'=>$userInfo]);
      }


    }

    /**
    * Diese Funktion ändert den Status eines Arbeitsgangs MIT Rückmeldung
    * Es wird die AG-Id und die Produktionslinie benötigt.
    */
    public function actionCreateRueckmeldung($id,$linie)
    {
        $this->layout = 'procontrol';
        /**
        * Benutzererkennung bzw. Benutzerinformationen
        */
        $userInfo = Procontrol::getUserInfo();

        if($userInfo['persno'] != 0){
          $vorname = $userInfo['vorname'];
          $nachname = $userInfo['nachname'];
          $persno = $userInfo['persno'];
        }
        else {
          Yii::$app->session->setFlash('msg', '
              <div class="alert alert-danger alert-dismissable" id="benutzer_fehler">
              <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
              <strong>Benutzererkennung fehlgeschlagen! </strong> Keine Aktion möglich</div>'
           );
           $vorname = '';
           $nachname = '';
           $persno = '';
        }

        /**
        * benötigte Werte
        */
        $or_op = Or_op::findOne($id);
        $order = Order::find()->where(['NO'=>$or_op['ORNO']])->one();
        // Infos werden wegen der VE benötigt
        $artikelNr = Pa_artpos::find()->select(['ARTNO'])->where(['ARTDESC'=>$order['IDENT']])->one();
        $fagdetails = Fagdetail::find()->limit(1)->where(['FKNO' => $artikelNr])->andWhere(['TYP' => 5])->one();
        Yii::$app->formatter->thousandSeparator = '';
        $VE= Yii::$app->formatter->asInteger($fagdetails['VAL03']);

        /**
        * Werte werden über eine tempräres Model (M3TmpRueckmeldung) geprüft und generiert
        * und an die Funktion zum Speichern und Ändern der Datenbanken übergeben.
        **/
        $model = new M3TmpRueckmeldung();
        $model->Arbeitsplatz = $or_op->PWPLACE;
        $model->Auftrag = $order->NAME;
        $model->Arbeitsgang = $or_op->NAME;
        ($VE>0) ? $model->Stueckzahl = $VE : $model->Stueckzahl = $order->PPARTS;
        $model->name = $vorname.' '.$nachname;
        $model->persno = $persno;

        /**
        * Wenn eine Rückmeldung erstellt wird hat man verschiedene Möglichkeiten
        * 1. Es wird ein Gebinde zurückgemeldet und der aktuelle Arbeitsgang fortgesetzt
        */
        if ($model->load(Yii::$app->request->post())) {
          // Unterbrechungs- oder Endmeldung
          (isset($_POST['button_continue']) || isset($_POST['button_pause']) || isset($_POST['button_pause_or'])) ? $status=400 : $status=500;
          (isset($_POST['button_pause_or']) || isset($_POST['button_end_or'])) ? $stueckzahl=0 : $stueckzahl=$model->Stueckzahl;

          $cur_date = date('d.m.Y H:i:s');
          $this->createLbdc($id, $status, $userInfo, $stueckzahl, $cur_date);

            if (isset($_POST['button_continue'])) {
              //Datumswerte dürfen nicht gleich sein; deshalb 1s Pause
              sleep(1);

              $cur_date = date('d.m.Y H:i:s');
              //erneuter Start des AG
              $status=300;
              $stueckzahl = 0;
              $this->createLbdc($id, $status,$userInfo, $stueckzahl, $cur_date);
            }

          return $this->redirect(['auswahl','linie'=>$linie]);

        } else {

            ($or_op->APARTS < $order['PPARTS']) ?
              $message = '
                          Arbeitsgang beenden obwohl die Auftragsmenge nicht erreicht wurde?

                          Auftragsmenge = '.$order['PPARTS'].'
                          Rückgemdeldete Menge = '.$or_op->APARTS.'

                          Der Arbeitsgang erscheint danach nicht mehr in der Auftragsliste!' :

              $message = 'Der Arbeitsgang wird beendet und erscheint danach nicht mehr in der Auftragsliste!';
            return $this->render('createrueckmeldung', [
                'model' => $model,
                'maschine'=>Maschine::findOne($linie),
                'PN'=>$order['IDENT'],
                'BZ'=>$order['DESCR'],
                'message' => $message,
            ]);
        }
    }
    public function actionDeleteCustomerDates($id)
    {
        M3Termine::findOne($id)->delete();

        return $this->redirect(['show-customer-dates']);
    }


    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'editorder' => [                                       // identifier for your editable action
                'class' => EditableColumnAction::className(),     // action class name
                'modelClass' => Order::className(),                // the update model class
                 'outputValue' => function ($model, $attribute, $key, $index) {
                    $fmt = Yii::$app->formatter;
                    $value = $model->$attribute;                 // your attribute value
                    if ($attribute === 'DELIVERY') {           // selective validation by attribute
                        return $fmt->asDate($value, ' d.m.Y');       // return formatted value if desired
                    }
                    return '';                                   // empty is same as $value
               },
               'outputMessage' => function($model, $attribute, $key, $index) {
                     return '';                                  // any custom error after model save
               },
               // 'showModelErrors' => true,                     // show model errors after save
               // 'errorOptions' => ['header' => '']             // error summary HTML options
               // 'postOnly' => true,
               // 'ajaxOnly' => true,
               // 'findModel' => function($id, $action) {},
               // 'checkAccess' => function($action, $model) {}


            ],
             'editcustomerdate' => [                                       // identifier for your editable action
                'class' => EditableColumnAction::className(),     // action class name
                'modelClass' => M3Termine::className(),                // the update model class
                 'outputValue' => function ($model, $attribute, $key, $index) {
                    $fmt = Yii::$app->formatter;
                    $value = $model->$attribute;                 // your attribute value
                    if ( in_array($attribute, ['START', 'ENDE'])) {           // selective validation by attribute
                        return $fmt->asDate($value, ' d.m.Y H:i:s');       // return formatted value if desired
                    }
                    return '';                                   // empty is same as $value
               },
               'outputMessage' => function($model, $attribute, $key, $index) {
                     return '';                                  // any custom error after model save
               },
            ],

        ]);
    }

    /**
     * @param int $id
     * @param int $status
     * @param int $stueckzahl
     * @param array $userInfo
     *
     * Eintrag in die LB_DC Datenbank wird erstellt.
     * Zählerstand in IS_NUM genändert
     */
    protected function createLbdc ($id, $status,$userInfo, $stueckzahl, $cur_date)
    {
      $or_op = Or_op::findOne($id);
      $order = Order::find()->where(['NO'=>$or_op['ORNO']])->one();

      $maschine = Maschine::findOne($or_op['PWPLACE']);

      //AG starten
      if ($status ==300) {
        //AG Status auf 1 setzen und die aktuelle Zeit in PSTIMEMAX eintragen
        $or_op->STATUS = 1;

        $dateDiff = 1;
        //Auftragsstatus prüfen. Wenn dieser 0 ist , dann auf 1 setzen
        if ($order->STATUS == 0) {
          $order->STATUS =1;
        }
      }

      //AG unterbrechen oder Beenden
      if ($status == 400 || $status == 500) {

        $dateDiff = dateDiffTotal(Yii::$app->formatter->asDateTime($or_op->PSTIMEMAX),$cur_date,'s');
        $or_op->APARTS += $stueckzahl;
        $or_op->ATE += $dateDiff;

        //Beenden
        if ($status == 500) {
          //Status des Auftrags beenden (2)
          $or_op->STATUS = 2;
          //Prüfen ob es noch weitere offene AGs vom Auftrag gibt. Wenn nicht muss der Auftrag ebenfalls geschlossen werden
          if (Procontrol::getOpenAgs($order->NO) == 1){
            $order->STATUS = 2;
            $order->EINLAST = 0;
          }
        }
      }

      // AG Zeit aktualisieren
      $or_op->PSTIMEMAX = $cur_date;

      // Counter INTNO19 in der Tabell IS_NUM um +1 erhöhen und Änderung dokumentieren
      $isnum = Is_num::findOne(0);
      $isnum->CHNAME = $userInfo['vorname'].' '.$userInfo['nachname'];
      $isnum->CHDATE = $cur_date;
      $isnum->updateCounters(['INTNO19' => 1]);
      $isnum->save();

      $model = new Lb_dc();
      $model->LBNO = $isnum->INTNO19;
      $model->NAME = (string)$or_op->NAME;
      $model->OPNO = $or_op->SEQNUM;
      $model->ORNAME = $order->NAME;
      $model->ORNO = $order->NO;
      $model->ADCCOUNT =$stueckzahl;
      $model->ADCMESS = $cur_date;
      $model->ATP = 10;
      $model->MSINFO = $maschine->NAME;
      $model->MSTIME = $cur_date;
      $model->MTIME3 = $dateDiff;
      $model->PERSNAME = $userInfo['nachname'].' '.$userInfo['vorname'];
      $model->PERSNO = $userInfo['persno'];
      $model->STATUS = $status;
      $model->WPLACE = $or_op['PWPLACE'];
      $model->CNAME = $userInfo['vorname'].' '.$userInfo['nachname'];
      $model->CDATE = $cur_date;

      //
      //Beim (erneuten) Starten wird CHDATE und CHNAME bei der Voherigen Unterbrechung beschrieben
      // Alle zum AG gehörenden Unterbrechungsmeldungen aktualisieren
      //Beim Beenden und Unterbrechen eines AGs wird das CHDATE und der CHNAME ebenfalls beschrieben
      Lb_dc::updateAll(['CHDATE' => $cur_date, 'CHNAME'=>$userInfo['vorname'].' '.$userInfo['nachname']],
            ['and',['ORNO'=>$order->NO],['in','STATUS',[400,500]],['NAME'=>$or_op->NAME]]);

      if ($model->save())
      {
        $or_op->update();
        $order->update();
      }
    }

  }
