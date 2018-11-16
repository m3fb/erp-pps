<?php

namespace app\controllers;

use Yii;
use app\models\Personal;
use app\models\PersonalSearch;
use app\models\Fagdetail;
use app\models\M3UrlaubStunden;
use app\models\M3UrlaubStundenSearch;
use app\models\User;
use app\models\M3Urlaubsplanung;
use app\models\M3UrlaubsplanungSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\AccessRule;
use kartik\grid\EditableColumnAction;
use yii\helpers\ArrayHelper;

/**
 * PersonalController implements the CRUD actions for Personal model.
 */
class PersonalController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
			'access' => [
                'class' => AccessControl::className(),
                'only' => [
                  'index',
                  'create',
                  'update',
                  'delete',
                  'view',
                  'wlanantrag',
                  'wlan-verwaltung',
                  'abwesenheit',
                  'krank',
                  'create-abwesenheit',
                  'krank-uebersicht',
                ],
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'actions' => ['index','view','wlanantrag'],
                        'allow' => true,
                        'roles' => [User::ROLE_USER],
                    ],
                    [
                        'actions' => ['create-abwesenheit','krank-uebersicht','abwesenheit'],
                        'allow' => true,
                        'roles' => [User::ROLE_VERWALTER, User::ROLE_ABRECHNER, User::ROLE_ENTSCHEIDER],
                    ],
                    [
                        'actions' => ['create','update','delete','wlan-verwaltung','abwesenheit','krank','create-abwesenheit','krank-uebersicht',],
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN],
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
     * Lists all Personal models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PersonalSearch();
        #$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->getPersonalListe(Yii::$app->request->queryParams);
        #$monthslist = $searchModel->getMonthsList();


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Personal model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
      $urlStdSearchModel = new M3UrlaubStundenSearch();
      $urlStdDataProvider = $urlStdSearchModel->getPersUrlaubStunden($id);
      $personalModel = Personal::findOne($id);
      $userModel = User::find()->where(['pe_work_id'=>$id])->one();
      $zusInfo = Fagdetail::findOne(['FKNO' =>$id],['TYP'=>26]);

      $enddatum = date("31.12.Y");
      $startdatum = date('01.01.Y');
      $startstatus = 802; // 802 = krank Start
      $endstatus = 803; // 803 = krank Ende
      $krank_searchModel = new M3Urlaubsplanung();
      $krank = $krank_searchModel->krankPersoenlicheDaten($id);


      #Änderungen werden per Email versendet. Hier werden die ursprünglichen Werte gepuffert um die Aktualisierung zu zeigen.
      $oldPhone2 = $personalModel->PHONE2; // mobile Telefonnummer
      $oldPhone3 = $personalModel->PHONE3; // private Telefonnummer
      $oldStreet = $personalModel->STREET;
      $oldPostcode = $personalModel->POSTCODE;
      $oldPlace = $personalModel->PLACE;
      $oldEmail = $personalModel->MODEM;

      $personalModel->CHNAME = Yii::$app->user->identity->firstname.' '.Yii::$app->user->identity->surename;
      $personalModel->CHDATE = date('d.m.Y H:i:s');

       if ($personalModel->load(Yii::$app->request->post()) && $personalModel->save()) {
           Yii::$app->session->setFlash('kv-detail-success', 'Änderung wurde übernommen');

           if (
                 $oldPhone2 != $personalModel->PHONE2 or // mobile Telefonnummer
                 $oldPhone3 != $personalModel->PHONE3 or // private Telefonnummer
                 $oldStreet != $personalModel->STREET or
                 $oldPostcode != $personalModel->POSTCODE or
                 $oldPlace != $personalModel->PLACE or
                 $oldEmail != $personalModel->MODEM
               ){
                    $aenderungen =  '<b>Alte Daten:</b> <br>
                                    Name: '.$personalModel->FIRSTNAME.' '.$personalModel->SURNAME.'<br>
                                    Straße: '.$oldStreet.'<br>
                                    PLZ Ort: '.$oldPostcode.' '.$oldPlace.'<br>
                                    Mobil: '.$oldPhone2.'<br>
                                    priv. Tel.: '.$oldPhone3.'<br>
                                    Email: '.$oldEmail.'<br>
                                    -----------------------------<br>
                                    <b>Neue Daten:</b> <br>
                                    Name: '.$personalModel->FIRSTNAME.' '.$personalModel->SURNAME.'<br>
                                    Straße: '.$personalModel->STREET.'<br>
                                    PLZ Ort: '.$personalModel->POSTCODE.' '.$personalModel->PLACE.'<br>
                                    Mobil: '.$personalModel->PHONE2.'<br>
                                    priv. Tel.: '.$personalModel->PHONE3.'<br>
                                    Email: '.$personalModel->MODEM.'<br>
                                    ';
                   // Email mit den Änderungen
                  Yii::$app->mailer->compose()
                     ->setFrom('m3intra@m3profile.com')
                     ->setTo('n.rotter@m3profile.com')
                     ->setCc('m.rotter@m3profile.com')
                     ->setSubject('Adressdaten von  '. $personalModel->FIRSTNAME.' '.$personalModel->SURNAME.' wurden geändert')
                     ->setTextBody('')
                     ->setHtmlBody($aenderungen)
                 ->send();
                //Zum Testen des Emailinhalts kann dieser per Flash ausgegeben werden
                # Yii::$app->session->setFlash('kv-detail-success', $aenderungen);
            }
           return $this->redirect(['view','id'=>$id]);
       }
       elseif ($userModel->load(Yii::$app->request->post()) && $userModel->save()) {
           Yii::$app->session->setFlash('kv-detail-success', 'Änderung wurde übernommen');
           return $this->redirect(['view','id'=>$id]);
       }
       else {
           return $this->render('view', [
             'model' => $personalModel,
             'zusInfo' => $zusInfo,
             'urlStdDataProvider'=> $urlStdDataProvider,
             'id'=>$id,
             'userModel'=>$userModel,
             'krank' =>$krank,
           ]);
       }



        return $this->render('view', [
            'model' => $personalModel,
            'zusInfo' => $zusInfo,
            'ulrStdDataProvider'=> $urlStdDataProvider,
            'id'=>$id,

        ]);
    }

    /**
     * Creates a new Personal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Personal();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->NO]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreateAbwesenheit($workid,$status)
    {
        $model = new M3Urlaubsplanung();
        $statusBeschreibung = [800=>'Urlaub', 802=>'Krank',804=>'Elternzeit',806=>'unbezahlter Urlaub', 808=>'Berufsschule'];
        if (Yii::$app->request->isPost) {
          #$model->load(Yii::$app->request->post());
          $post = Yii::$app->request->post('M3Urlaubsplanung');
          $datum = [$post['MSTIME'],$post['MSTIME2']];
          $endDate = explode(' ',$datum[1]);
          $endDateTime = $endDate[0].' 23:59:00';
          $wid = $post['WORKID'];
          $stat = [$post['STATUS'], $post['STATUS']+1];
          $beschreibung = [$statusBeschreibung[$post['STATUS']].' Start', $statusBeschreibung[$post['STATUS']].' Ende'];
          ($stat[0]==800) ? $bestaetigt = 0 : $bestaetigt = 1;
          $urlaubstage = $post['TAGE'];
          $ueberstunden = $post['STUNDEN'];
          $gesamttage = $post['GESAMT_TAGE'];

          $personalModel = $searchModelPersonal = new PersonalSearch();
          $personalInfo = $personalModel->find()
                ->select(['NO',"[FIRSTNAME]+' '+[SURNAME] as NAME",'PERSNO'])
                ->where(['NO'=> $wid])
                ->one();
          $persname = $personalInfo['NAME'];
          $persno = $personalInfo['PERSNO'];

          $cname = Yii::$app->user->identity->firstname.' '.Yii::$app->user->identity->surename;

          $mod1 = new M3Urlaubsplanung();
          $mod1->PERSNAME = $persname;
          $mod1->PERSNO = $persno;
          $mod1->WORKID = $wid;
          $mod1->TAGE = $urlaubstage;
          $mod1->STUNDEN = $ueberstunden;
          $mod1->GESAMT_TAGE = $gesamttage;
          $mod1->MSTIME = $datum[0];
          $mod1->MSTIME2 = $endDateTime;
          $mod1->STATUS = $stat[0];
          $mod1->BESCHREIBUNG = $beschreibung[0];
          $mod1->BEST = $bestaetigt;
          $mod1->CNAME = $cname;
          $mod1->CDATE = date('d.m.Y H:i:s');
          $mod1->save();

          $mod2 = new M3Urlaubsplanung();
          $mod2->PERSNAME = $persname;
          $mod2->PERSNO = $persno;
          $mod2->WORKID = $wid;
          $mod2->TAGE = $urlaubstage;
          $mod2->STUNDEN = $ueberstunden;
          $mod2->GESAMT_TAGE = $gesamttage;
          $mod2->MSTIME = $endDateTime;
          $mod2->MSTIME2 = $endDateTime;
          $mod2->STATUS = $stat[1];
          $mod2->BESCHREIBUNG = $beschreibung[1];
          $mod2->BEST = $bestaetigt;
          $mod2->CNAME = $cname;
          $mod2->CDATE = date('d.m.Y H:i:s');
          $mod2->save();

          return $this->redirect(['abwesenheit','workid'=>$workid,'status'=>$status]);
        } else {

          $searchModelPersonal = new PersonalSearch();
          $aktivesPersonal = $searchModelPersonal->find()
                ->select(['NO',"[FIRSTNAME]+' '+[SURNAME] as NAME"])
                ->where(['STATUS1'=> 0])
                ->orderBy('SURNAME')
                ->asArray()
                ->all();//PersId vom aktiven Personal

          return $this->render('createAbwesenheit', [
              'model' => $model,
              'aktivesPersonal' => $aktivesPersonal,
              'workid' => $workid,
          ]);
        }
    }

    /**
     * Updates an existing Personal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->NO]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Personal model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = user::findOne(['pe_work_id' =>$id]);
        $model->delete();
        return $this->redirect(['index']);
    }

    public function actionDeleteAbwesenheit($id,$workid,$status)
    {
        $model = M3Urlaubsplanung::findOne(['LBNO' =>$id]);
        $model->delete();
        return $this->redirect(['abwesenheit','workid'=>$workid,'status'=>$status]);
    }

    public function actionWlanantrag($id)
    {
      $model = user::findOne(['id' =>$id]);
      $pe_work_id = $model->pe_work_id;
      $model->wlan_username = '-';
      $model->wlan_expiration = date('Y-m-d H:i:s');
      $model->save();

      Yii::$app->mailer->compose()
        ->setFrom('m3intra@m3profile.com')
        ->setTo('m.rotter@m3profile.com')
        ->setCc('f.bogenreuther@m3profile.com')
        ->setSubject('Wlanzugang für '. $model->firstname.' '.$model->surename)
        ->setTextBody('')
        ->setHtmlBody('<b>Neuer Wlan-Antrag</b> <br> Eingereicht von: '.$model->firstname.' '.$model->surename.'<br>
                        <a href="http://m3mssql/m3adminV3/web/index.php?r=personal%2Fwlan-verwaltung">Link zu den Wlan-Anträgen</a>')
    ->send();

    return $this->redirect(['view','id'=>$pe_work_id]);
    }

    public function actionWlanVerwaltung()
    {
      $model = new user();
      $dataProvider = $model->search();
      $dataProvider->query->where(['NOT','wlan_username=NULL'])->orWhere(['<','wlan_expiration', date('Y-m-d H:i:s')]);

      return $this->render('wlanverwaltung',[
        'dataProvider' => $dataProvider,
      ]);
    }



    public function actionAbwesenheit($workid,$status)
    {
      if($workid=='') $workid=0;
      if($status=='') $status=0;
      $searchModelPersonal = new PersonalSearch();
      $aktivesPersonal = $searchModelPersonal->find()
            ->select(['NO',"[FIRSTNAME]+' '+[SURNAME] as NAME"])
            ->where(['STATUS1'=> 0])
            ->orderBy('SURNAME')
            ->asArray()
            ->all();//PersId vom aktiven Personal

      $searchModel = new M3UrlaubsplanungSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$workid,$status);
      $dataProvider->pagination->pageSize=0;

      return $this->render('abwesenheit',[
        'aktivesPersonal' => $aktivesPersonal,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'workid' => $workid,
        'status' => $status,
      ]);

    }

    //Actions für die editierbaren Felder
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'editwlanverwaltung' => [                                       // identifier for your editable action
                'class' => EditableColumnAction::className(),     // action class name
                'modelClass' => User::className(),                // the update model class
                 'outputValue' => function ($model, $attribute, $key, $index) {
                    $fmt = Yii::$app->formatter;
                    $value = $model->$attribute;                 // your attribute value
                    if ($attribute === 'wlan_expiration') {           // selective validation by attribute
                        return $fmt->asDate($value, ' d.m.Y H:i:s');       // return formatted value if desired
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
            'editabwesenheitsdatum' => [                                       // identifier for your editable action
                'class' => EditableColumnAction::className(),     // action class name
                'modelClass' => M3Urlaubsplanung::className(),                // the update model class
                 'outputValue' => function ($model, $attribute, $key, $index) {
                    $fmt = Yii::$app->formatter;
                    $value = $model->$attribute;                 // your attribute value
                    if ($attribute === 'MSTIME') {           // selective validation by attribute
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

    //Übersicht über der Abwesenheitstage (krank und Urlaub) der letzten 12 Monate
    public function actionAbwesendUebersicht($status)
    {
      /*
      * Die aktiven Mitarbeiter werden aus der Personalliste ausgelesen. Für jeden Mitarbeiter wird ein Abwesenheitsdatensatz generiert.
      * Krank und Urlaub werden aus der Tabelle m3_urlaubsplanung ausgelesen. Die Bereiche werden mit Start- und Endeintrag begrenzt.
      */
      $searchModelPersonal = new PersonalSearch();
      $aktivesPersonal = $searchModelPersonal->find()->select(['NO','FIRSTNAME','SURNAME'])->where(['STATUS1'=> 0])->asArray()->all();//PersId vom aktiven Personal

      $enddatum = date("t.m.Y", strtotime("last month")); // letzer Tag des Vormonats
      $startdatum = date('01.m.Y',strtotime(date('t.m.Y').' -1 year')); //erster Tag des Monats minus 1 Jahr
      $startstatus = $status; // 802 = krank Start / 800 = Urlaub start
      $endstatus = $status + 1; // 803 = krank Ende / 801 = Urlaub ende
      $searchModel = new M3Urlaubsplanung();
      $dataProvider = $searchModel->getOffDatesOverview($aktivesPersonal,$startdatum,$enddatum,$startstatus,$endstatus);
      return $this->render('abwesend',[
        'dataProvider' => $dataProvider,
        'startdatum' => $startdatum,
        'enddatum' => $enddatum,
        'status' => $status,
       ]);
    }

    //Übersicht Urlaub und Überstunden der letzten 12 Monate
    public function actionUrlaubStundenUebersicht()
    {
      /*
      * Die aktiven Mitarbeiter werden aus der Personalliste ausgelesen.
      */
      $searchModelPersonal = new PersonalSearch();
      $aktivesPersonal = $searchModelPersonal->find()->select(['NO','FIRSTNAME','SURNAME'])->where(['STATUS1'=> 0])->asArray()->all();//PersId vom aktiven Personal

      $enddatum = date("t.m.Y", strtotime("last month")); // letzer Tag des Vormonats
      $startdatum = date('01.m.Y',strtotime(date('t.m.Y').' -1 year')); //erster Tag des Monats minus 1 Jahr

      $searchModel = new M3UrlaubStunden();
      $dataProvider = $searchModel->getUrlaubStundenUebersicht($aktivesPersonal,$startdatum,$enddatum);

      return $this->render('urlaub_stunden',[
        'dataProvider' => $dataProvider,
        'startdatum' => $startdatum,
        'enddatum' => $enddatum,
       ]);
    }


    /**
     * Finds the Personal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Personal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Personal::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
