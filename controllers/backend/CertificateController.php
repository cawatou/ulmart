<?php

namespace app\controllers\backend;

use Yii;
use app\models\Certificate;
use app\models\CertificateSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class CertificateController extends Controller{
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
        $searchModel = new CertificateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionTypes(){            
        $model = new Certificate();
        $result = $model->searchType(Yii::$app->request->queryParams);

        return $this->render('types', array('result' => $result));
    }


    public function actionDownload(){
        return $this->render('download');
    }


    public function actionUpload(){
    	return $this->render('upload');
    }


    public function actionDelete($id){
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }


    protected function findModel($id){
        if (($model = Certificate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function createCsv(){
        $data = "Название товара;Артикль;Цена;Описание;Количество;Производитель\r\n";

        $query = 'SELECT code.code, code.name, code.phone, code.email, code.answers_count, code.activate_date, code.promo_code, code.check_number, certificate.type FROM  `code`, `certificate` WHERE code.promo_code <> "" AND code.promo_code <> "none" AND certificate.promo_code=code.promo_code';
        $result = \Yii::$app->db->createCommand($query)->queryAll();

        echo "<pre>".print_r($result, 1)."</pre>";

        /* $model = Goods::model()->findAll();
         foreach ($model as $value) {
             $data .= $value->name.
                 ';' . $value->article .
                 ';' . $value->cost .
                 ';' . $value->description .
                 ';' . $value->count .
                 ';' . $value->producer .
                 "\r\n";
         }
         header('Content-type: text/csv');
         header('Content-Disposition: attachment; filename="export_' . date('d.m.Y') . '.csv"');
         //echo iconv('utf-8', 'windows-1251', $data); //Если вдруг в Windows будут кракозябры
         Yii::app()->end();*/
    }
}
