<?php

namespace app\controllers;

use Yii;
use app\models\Pa_posit;
use app\models\Pa_paper;
use app\models\User;
use app\models\AccessRule;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use kartik\grid\EditableColumnAction;

/**
 * BelegeController
 */
class BelegeController extends Controller
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
                   'only' => ['index','update'],
                   'rules' => [
                       [
                           'actions' => ['index','update'],
                           'allow' => true,

                           'roles' => [
                             User::ROLE_ADMIN,
              							 User::ROLE_VERWALTER,
              							 User::ROLE_ABRECHNER,
                             User::ROLE_ENTSCHEIDER
                           ],
                       ],
                     ],
                   ],
                 ];
             }

    /**
     * Vorauswahl aus Belegen mit noch nicht voll belieferten Positionen
     * Filter nach Belegart, Kunde oder Belegnummern
     * @return Form
     */
    public function actionIndex()
    {
        $belegtypen = ['Auftragsbestätigung','Kontrakt-Auftragsbestätigung','Lieferschein','Speditionsauftrag','Bestellung','Anfrage'];
        $paPaperModel = new Pa_paper();
        $dataProviderOffeneBelege =$paPaperModel->getOpenDocuments(Yii::$app->request->queryParams);
        $dataProviderOffeneBelege->query->andWhere(['in','TXTIDENT', $belegtypen]);
        $dataProviderOffeneBelege->query->orderBy([
                                      'STATUS' => SORT_ASC,
                                      'TXTIDENT' => SORT_ASC,
                                      'PANO' => SORT_ASC,
                                    ]);
        $belegtypen = ArrayHelper::map(Pa_paper::find()
                                        ->select(['TXTIDENT'])
                                        ->where(['in','TXTIDENT', $belegtypen])
                                        ->andWhere(['in','IDENT',[1,2,5,6,7]])
                                        ->asArray()->all(),
                                        'TXTIDENT', 'TXTIDENT');

        return $this->render('index', [
          'paPaperModel' => $paPaperModel,
          'dataProviderOffeneBelege' => $dataProviderOffeneBelege,
          'belegtypen' => $belegtypen,
        ]);
    }

    public function actionUpdate($id)
    {
      $paPositModel = new Pa_posit();
      $dataProviderPaPosit =$paPositModel->getPaperPosits($id);
      $paPaperModel = $this->findModel($id);

      $paPaperStatus = Pa_posit::getDocumentStatus($id);

      if ($paPaperModel->STATUS != $paPaperStatus){
        $paPaperModel->STATUS = $paPaperStatus;
        $paPaperModel->CHDATE = date('d.m.Y H:i:s');
        $paPaperModel->CHNAME = Yii::$app->user->identity->firstname.' '.Yii::$app->user->identity->surename;

        if ($paPaperModel->save()){
          return $this->redirect(['update', 'id'=>$id]);
        }
        else var_dump($paPaperModel->getErrors()); die;
      }
      else {
        return $this->render('update', [
            'dataProviderPaPosit' => $dataProviderPaPosit,
            'paPaperModel' => $paPaperModel,
        ]);
      }
    }

    // Belegposition als erledigt speichern
    // $id = PONO
    public function actionDonePosition($id)
    {
      if(Pa_posit::donePosition($id))
      {
        return $this->redirect(['update', 'id' => Pa_posit::getPANO($id)]);
      }
    }

    // alle Belegpositionen als erledigt speichern
    // $PANO = PANO
    public function actionDoneAll($PANO)
    {
      if(Pa_posit::doneAll($PANO))
      {
        return $this->redirect(['update', 'id' => $PANO]);
      }
    }

    protected function findModel($id)
    {
        if (($model = Pa_paper::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function belegStatus($pano){

      // Nach dem Speichern der "bisher geliefert"-Werte muss der
      // Belegstatus geprüft und gesetzt werden.


      // Wenn alle bisher geliefert Werte gleich Null sind
      // und nirgends Teillieferung gespeichert wurde,
      // ist der BelegStatus offen = 0

      // Wenn alle bisher geliefert Werte größer Null sind
      // und nirgends Teillieferung gespeichert wurde,
      // ist der BelegStatus fertig = 2
      $countPositionen = Pa_posit::find()
        ->where(['PANO' => $pano])
        ->count();

      $countFertig = Pa_posit::find()
        ->where(['PANO' => $pano])
        ->andWhere(['>','POSLIEF0',  0])
        ->andWhere(['POSPRT0' => 0 ])
        ->count();

      $countOffen = Pa_posit::find()
        ->where(['PANO' => $pano])
        ->andWhere(['POSLIEF0' => 0])
        ->andWhere(['POSPRT0' => 0])
        ->count();

        $paPaperStatus = ($countPositionen == $countOffen) ? 0 : (($countPositionen == $countFertig) ? 2 : 1);
        #echo 'Beleg-Status ' . $paPaperStatus; die;
        $paPaper = Pa_paper::findOne($pano);
        $paPaper->STATUS = $paPaperStatus;
        $paPaper->save();
      }

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'editbishergeliefert' => [                                       // identifier for your editable action
                'class' => EditableColumnAction::className(),     // action class name
                'modelClass' => Pa_posit::className(),                // the update model class
                 'outputValue' => function ($model, $attribute, $key, $index) {
                    $fmt = Yii::$app->formatter;
                    $value = $model->$attribute;                 // your attribute value
                    if ($attribute === 'POSLIEF0') {           // selective validation by attribute
                        return $value;       // return formatted value if desired
                    }
                    elseif ($attribute === 'POSPRT0') {           // selective validation by attribute
                        return $fmt->asInteger($value);       // return formatted value if desired
                    }
                    return '';                                   // empty is same as $value
               },
               'outputMessage' => function($model, $attribute, $key, $index) {
                     return '';                                  // any custom error after model save
               },
               'showModelErrors' => true,
               'errorOptions' => ['header' => '']
            ],
        ]);
    }
}
