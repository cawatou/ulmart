<?php

namespace app\controllers\backend;

use Yii;
use app\models\Code;
use app\models\Certificate;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ClearController extends Controller{

    public $layout = "backend";

    public function actionIndex(){
        return $this->render("index");
    }

    
}
