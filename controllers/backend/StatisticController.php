<?php

namespace app\controllers\backend;

use Yii;
use app\models\Code;
use app\models\Certificate;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class StatisticController extends Controller{

    public $layout = 'backend';

    public function actionIndex(){
        $codeModel = new Code();
        $clients =  $codeModel->clients();
        $count_check =  $codeModel->count_check();
        $count1_2 =  $codeModel->count1_2();
        $count3_5 =  $codeModel->count3_5();
        $count6_8 =  $codeModel->count6_8();
        $count9_10 =  $codeModel->count9_10();

        $certificateModel = new Certificate();
        $count_office =  $certificateModel->count_office();
        $count_game =  $certificateModel->count_game();
        $count_comp =  $certificateModel->count_comp();


	    return $this->render('index', compact('clients', 'count_check', 'count1_2', 'count3_5', 'count6_8', 'count9_10', 'count_office', 'count_game', 'count_comp'));

    }
}
