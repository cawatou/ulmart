<?php

namespace app\controllers\backend;

use Yii;
use app\models\SuspectIp;
use app\models\SuspectIpSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class SuspectipController extends Controller{
    public $layout = 'backend';

    public function behaviors()
    {
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
        $searchModel = new SuspectIpSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id){
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionCreate(){
        $model = new SuspectIp();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }


    public function actionUpdate($id){
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    public function actionDelete($id){
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }


    protected function findModel($id){
        if (($model = SuspectIp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
