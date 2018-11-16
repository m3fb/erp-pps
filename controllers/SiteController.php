<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\BadRequestHttpException;
use yii\base\InvalidParamException;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignupForm;
use app\models\Qsboard;
use app\models\Personal;
use app\models\Sqllog;



class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
			$this->layout = 'joomla';
			$link="http://192.168.1.22/m3intraV2/index.php";
			return $this->render('joomla', [
				'link' => $link,
				]);

    }


    public function actionLogin()
    {
       if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (Yii::$app->user->identity->pw_check()){

				return $this->goBack();
			}
			else {
				return $this->redirect(['user/pwchange', 'id'=>Yii::$app->user->identity->pe_work_id]);
			}

        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }



    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }


    public function actionSignup($id)
    {
        $model = new SignupForm();
        $pers_detail = Personal::findId($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                #if (Yii::$app->getUser()->login($user)) {
                    #return $this->goHome();
                    return $this->redirect(['personal/index']);
                #}
            }
        }

        return $this->render('signup', [
            'model' => $model,
            'pers_detail' => $pers_detail,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

	// public function actionTest()
    // {
        // $model = new UrlaubForm();
        // if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            // Yii::$app->session->setFlash('contactFormSubmitted');

            // return $this->refresh();
        // } else {
            // return $this->render('test', [
                // 'model' => $model,
            // ]);
        // }
    // }

    public function actionBericht()
    {
        $this->layout = 'bericht';
        return $this->render('about');
    }

        public function actionQsboard()
    {
		$this->layout = 'qsboard';
		$model = new Qsboard();
		$dataProvider = $model->getOpenClaims();



		return $this->render('qsboard', [
			'dataProvider' => $dataProvider,
        ] );
    }

    public function actionVorlagen()
    {
			$this->layout = 'joomla';
			$link="http://192.168.1.22/m3intraV2/index.php/vorlagen";
			return $this->render('joomla', [
				'link' => $link,
				]);

    }
   public function actionWichtigetelefon()
    {
			$this->layout = 'joomla';
			$link="http://192.168.1.22/m3intraV2/index.php/wichtige-nummern-ansicht";
			return $this->render('joomla', [
				'link' => $link,
				]);

    }
   public function actionOrganigramm()
    {
			$this->layout = 'joomla';
			$link="http://192.168.1.22/m3intraV2/index.php/organigramm";
			return $this->render('joomla', [
				'link' => $link,
				]);

    }
    public function actionQmhanbuch()
    {
			$this->layout = 'joomla';
			$link="http://192.168.1.22/m3intraV2/index.php/qualitaetsmanagement";
			return $this->render('joomla', [
				'link' => $link,
				]);

    }
    public function actionInformationen()
    {
			$this->layout = 'joomla';
			$link="http://192.168.1.22/m3intraV2/index.php?option=com_content&view=category&layout=blog&id=27&filter_tag[0]=";
			return $this->render('joomla', [
				'link' => $link,
				]);

    }
    public function actionArbeitsanweisungen()
    {
			$this->layout = 'joomla';
			$link="http://192.168.1.22/m3intraV2/index.php/arbeitsanweisungen";
			return $this->render('joomla', [
				'link' => $link,
				]);

    }
    public function actionVerfahrensanweisungen()
    {
			$this->layout = 'joomla';
			$link="http://192.168.1.22/m3intraV2/index.php/verfahrensanweisungen";
			return $this->render('joomla', [
				'link' => $link,
				]);

    }
    public function actionZertifikate()
    {
			$this->layout = 'joomla';
			$link="http://192.168.1.22/m3intraV2/index.php/zertifikate";
			return $this->render('joomla', [
				'link' => $link,
				]);

    }
	public function actionBootstraptest()
    {
        $this->view->params['containerClass'] = 'container-fluid';
        return $this->render('bootstraptest');
    }

    public function actionSqllogAuswahl()
        {
          return $this->render('sqllog_auswahl');
        }

  public function actionSqllog($dateTime)
      {
          $this->view->params['containerClass'] = 'container-fluid';
          $model = new Sqllog();
          #$dateTime = '15.07.2018 08:00:00';

          $tabellen = $model->getChangedTables($dateTime);
          return $this->render('sqllog', [
            'dateTime' => $dateTime,
            'tabellen' => $tabellen,
          ]
        );
      }
}
