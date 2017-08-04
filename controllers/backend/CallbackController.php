<?php

namespace app\controllers\backend;

use Yii;
use app\models\Callback;
use app\models\CallbackSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\controller\AppController;
date_default_timezone_set('Europe/Moscow');

class CallbackController extends Controller{
    public $layout = 'backend';

    public function behaviors(){
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'ghost-access'=> [
		'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl',
	    ],
        ];
    }

    public function actionIndex(){
        $searchModel = new CallbackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionTech(){
        $searchModel = new CallbackSearch();
        $dataProvider = $searchModel->searchTech(Yii::$app->request->queryParams);

        return $this->render('tech', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionShares(){
        $searchModel = new CallbackSearch();
        $dataProvider = $searchModel->searchShares(Yii::$app->request->queryParams);

        return $this->render('shares', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id){
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionAnswer($id){
        $model = $this->findModel($id);
        $model->date_a = date("Y-m-d H:i:s");
        $model->type = Yii::$app->request->post('type');
        $model->answer_author = 'admin';
        if($model->load(Yii::$app->request->post()) && $model->update()) {
            $email = $model->email;
            $message = 'Ваш вопрос: ' . $model->question . '<br>';
            $message .= 'Ответ: ' . $model->answer . '<br>';
            Yii::$app->mailer->compose()
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo($email)
                ->setSubject('Сообщение с сайта (Ответ на ваш вопрос)')
                ->setHtmlBody($message)
                ->send();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('answer', [
                'model' => $model,
            ]);
        }
    }


    public function actionDelete($id){
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }


    protected function findModel($id){
        if (($model = Callback::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
