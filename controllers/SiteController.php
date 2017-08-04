<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\db\ActiveRecord;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Callback;
use app\models\Code;
use app\models\SuspectCode;
use app\models\Test;
use app\models\Certificate;
use kartik\mpdf\Pdf;


date_default_timezone_set('Europe/Moscow');

class SiteController extends AppController{

    public function behaviors(){
        return [            
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }


    public function actions(){
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


    public function actionIndex(){
        return $this->render('index');
    }


    public function actionCodesend(){

        $model = new Code();
        $result = $model->codeSend(Yii::$app->request->queryParams);

        if(isset(Yii::$app->session['code'])) $code = Yii::$app->session['code'];
        else $code = null;

        if($result=='resume') return $this->render('index', array('resume'=>true, 'code'=>$code));
        if($result=='suspect_code') return $this->render('index',['suspect_code'=>true]);
        if(isset($result['promo_code'])) return $this->render('index', array('certificate'=>true, 'promo_code' => $result['promo_code'], 'type' => $result['type']));
       
        if($result=='certificate_none') return $this->render('index',['certificate_none'=>true]);
        if($result=='blocked'){
            $unblock_time = $model->getBlocktime();
            return $this->render('index',['unblock_time'=>$unblock_time]);
        }   
        //return $result;
    }


    public function actionPdf(){
        if(isset(Yii::$app->session['code'])) $code = Yii::$app->session['code'];
        else $code = null;

        if(isset($_REQUEST['type'])) $type = $_REQUEST['type'];
        if(isset($_REQUEST['promo_code'])) $promo_code = $_REQUEST['promo_code'];
        if(isset($_REQUEST['email'])) $email = $_REQUEST['email'];
        if(isset($_REQUEST['download'])) $download = $_REQUEST['download'];

        if(isset($type) && isset($promo_code) && $download){
            if($type == 'A') $view = 'cert1';
            if($type == 'B') $view = 'cert2';
            if($type == 'C') $view = 'cert3';

            $content = $this->renderPartial($view, array('promo_code'=>$promo_code));
            $pdf = Yii::$app->pdf;

            // Распечатать
            if($download == 'undefined' && $email == 'undefined'){
                $pdf = new Pdf([
                    'content'=>$content,
                    'cssFile'=>'/css/styles.css'
                ]);
                return $pdf->render();
            }

            // Скачать
            if($download == 'true'){
                $mpdf = $pdf->api;
                $mpdf->WriteHtml($content);
                echo $mpdf->Output('ulmart_certificate', 'D');
            }

            // На почту
            if($email == 'true'){
                $email = Code::getEmail($code);

                $mpdf = $pdf->api;
                $mpdf->WriteHtml($content);
                $add_file = $mpdf->Output('', 'S');


                $message = Yii::$app->mailer->compose();
                $message->attachContent($add_file, ['fileName' => 'ulmart_certificate.pdf', 'contentType' => 'application/pdf']);
                $message->setFrom('no-replay@ulmart.ru')
                    ->setTo($email['email'])
                    ->setSubject('Сертификат')
                    //->setTextBody('Текст сообщения')
                    ->send();
            }
        }else{
            //echo $download;
            return false;
        }
    }


    public function actionResumesend(){
        $code = new Code();
        $result = $code->resumeSend(Yii::$app->request->queryParams);
        return $result;
    }


    public function actionQuestions(){
        if(isset(Yii::$app->session['code'])) $code = Yii::$app->session['code'];
        else $code = null;

        // Валидация 
        $data_code = new Code();
        $data_code = $data_code->checkCode($code, $step=2);
        if(!$data_code || !$code) $this->redirect ('/');
        $model = Code::findOne($data_code['id']);

        // Тестирование
        if(yii::$app->request->post('test')){
            // Выборка вопроса
            $question_num = $data_code['current_question'];
            if($question_num < 10) $question_num++; // Вопрос идет вперед ответа на 1 шаг (11 категории нет)
            elseif($question_num == 10) $last_question = true;
            $questions = (new \yii\db\Query())
                ->from('test')
                ->select(['id', 'question', 'a1', 'a2', 'a3', 'a4'])
                ->where(['category' => $question_num])
                ->all();
            $rand_key = array_rand($questions);
            $questions = $questions[$rand_key];

            

            // Таймер    
            if($model->activate_date == '0000-00-00 00:00:00'){
                $model->activate_date = date("Y-m-d H:i:s");
                $timer = 180;
            }else{
                $activate_date = strtotime($model->activate_date);
                $now = strtotime(date("Y-m-d H:i:s"));
                $timer = 180 - ($now - $activate_date);
                if($timer < 0){
                    $model->current_step = 3;
                    $model->update();
                    return $this->render('gift');
                }
            }
            
            
            // Фомирование строки назначеных вопросов    
            $q_string = $model->questions;
            if($q_string != '') $q_string = $q_string.','.$questions['id'];
            else $q_string = $questions['id'];

            
            // Запись ответа пользователя
            $answer_post = yii::$app->request->post('answer');
            $qid_post = yii::$app->request->post('qid');
            $answers_count = $model->answers_count;
            if($answer_post){
                $addanswer = new Code();
                $addanswer = $addanswer->addAnswer($qid_post, $answer_post);
                if($addanswer){
                    $answers_count++;
                    $model->answers_count = $answers_count;
                    $a_string = $model->answers;
                    if($a_string != '') $a_string = $a_string.','.$qid_post.'/'.$answer_post;
                    else $a_string = $qid_post.'/'.$answer_post;
                    $model->answers = $a_string;
                }
            }
            
            
            if(isset($last_question) || yii::$app->request->post('last_question')){
                $model->time_s3 = date("Y-m-d H:i:s");
                $model->current_step = 3;
                $model->update();
                if($model->answers_count >= 3) return $this->redirect('gift');
                else return $this->redirect('sorry');
            }else{           
                $model->questions = $q_string;
                $model->current_question = $question_num;
                $model->update();
            }                      

            return $this->render('questions', compact('code', 'questions', 'question_num', 'answers_count', 'timer'));

        }
        $continue = false;
        if($data_code['current_question'] > 0) $continue = true;
        return $this->render('questions', array('code' => $code, 'index' => true, 'continue' => $continue));

    }


    public function actionGift(){
        if(isset(Yii::$app->session['code'])) $code = Yii::$app->session['code'];
        else $code = null;

        // Проверка если уже был выбран подарок и есть сертификат
        $result = Code::checkPromocode($code);
        if($result['promo_code'] && $result['type']) return $this->redirect (array('index', 'certificate'=>true, 'promo_code' => $result['promo_code'], 'type' => $result['type']));

        // Валидация 
        $data_code = new Code();
        $data_code = $data_code->checkCode($code, $step=3);
        if(!$data_code || !$code) $this->redirect ('/');
        if($data_code['answers_count'] < 3) $this->redirect (array('sorry', 'dumb' => true));
        if($data_code['promo_code'] == 'none') $this->redirect ('sorry');
        return $this->render('gift', array('data_code' => $data_code));
    }


    public function actionFindgift(){
        if(isset(Yii::$app->session['code'])) $code = Yii::$app->session['code'];
        else $code = null;


        // Валидация
        $data_code = new Code();
        $data_code = $data_code->checkCode($code, $step=3);
        if($data_code['answers_count'] < 3) $this->redirect ('sorry');
        if($data_code['promo_code'] == 'none') return $this->redirect ('sorry');
        if($data_code['promo_code'] != '' && $data_code['promo_code'] != 'none'){
            $result = Code::checkPromocode($code);
            return $this->redirect (array('index', 'certificate'=>true, 'promo_code' => $result['promo_code'], 'type' => $result['type']));
        }
        $model = Code::findOne($data_code['id']);


        // Канцелярия
        if($data_code['answers_count'] >= 3 && $data_code['answers_count'] <= 5){
            if(mt_rand(1, 100) <= 7){
                $promo_code = Certificate::addPromocode('A', $code);
                $model->promo_code = $promo_code;
                $model->update();
                return json_encode(array('gift_count' => 1, 'success' => 1));
            }else{
                $model->promo_code = 'none';
                $model->update();
                return json_encode(array('gift_count' => 1, 'success' => 0));
            }
        }


        // Игры + Канцелярия
        if($data_code['answers_count'] >= 6 && $data_code['answers_count'] <= 8){
            if(mt_rand(1, 100) <= 12) {
                $promo_code = Certificate::addPromocode('B', $code);
                $model->promo_code = $promo_code;
                $model->update();
                return json_encode(array('gift_count' => 2, 'success' => 2));
            }
            if(mt_rand(1, 100) <= 14) {
                $promo_code = Certificate::addPromocode('A', $code);
                $model->promo_code = $promo_code;
                $model->update();
                return json_encode(array('gift_count' => 2, 'success' => 1));
            }else {
                $model->promo_code = 'none';
                $model->update();
                return json_encode(array('gift_count' => 2, 'success' => 0));
            }
        }


        // Ноутбук + Игры + Канцелярия
        if($data_code['answers_count'] >= 9){
            if(mt_rand(1, 1000) <= 30) {
                $promo_code = Certificate::addPromocode('C', $code);
                $model->promo_code = $promo_code;
                $model->update();
                return json_encode(array('gift_count' => 3, 'success' => 3));
            }elseif(mt_rand(1, 100) <= 12) {
                $promo_code = Certificate::addPromocode('B', $code);
                $model->promo_code = $promo_code;
                $model->update();
                return json_encode(array('gift_count' => 3, 'success' => 2));
            }elseif(mt_rand(1, 100) <= 14) {
                $promo_code = Certificate::addPromocode('A', $code);
                $model->promo_code = $promo_code;
                $model->update();
                return json_encode(array('gift_count' => 3, 'success' => 1));
            }else{
                $model->promo_code = 'none';
                $model->update();
                return json_encode(array('gift_count' => 3, 'success' => 0));
            }
        }

    }


    public function actionSorry(){
        if(isset(Yii::$app->session['code'])) $code = Yii::$app->session['code'];
        else $code = null;

        $data_code = new Code();
        $data_code = $data_code->checkCode($code, $step=3);
        if(!$data_code || !$code) $this->redirect ('/');
        if($data_code['answers_count'] < 3) return $this->render('sorry', array('dumb' => true));
        if($data_code['promo_code'] == 'none' || !$data_code['promo_code']) return $this->render('sorry', array('none' => true));
        return $this->render('sorry', array('promo_code' => '', 'data_code' => $data_code));
    }


    public function actionCertificate(){
        if(isset(Yii::$app->session['code'])) $code = Yii::$app->session['code'];
        else $code = null;

        $data_code = new Code();
        $result = $data_code->checkPromocode($code);
        if($result['promo_code']) return $this->render('index', array('certificate'=>true, 'promo_code' => $result['promo_code'], 'type' => $result['type']));
    }


    public function actionCallback(){
        return $this->render('callback');
    }


    public function actionCallbacksend(){
        //if(yii::$app->request->post('type') == 'T') $type = 'Технический';
        //if(yii::$app->request->post('type') == 'S') $type = 'Вопрос об акции';
        $message = 'От: ' . yii::$app->request->post('name') . '<br>';
        //$message .= 'Телефон: ' . yii::$app->request->post('phone') . '<br>';
        $message .= 'Email: ' . yii::$app->request->post('email') . '<br>';
        //$message .= 'Тип вопроса: ' . $type . '<br>';
        $message .= 'Сообщение: ' . yii::$app->request->post('msg') . '<br>';

        // Переписать в модель
        Yii::$app->mailer->compose()
            ->setFrom('no-replay@ulmart.ru')
            ->setTo(Yii::$app->params['adminEmail'])
            ->setSubject('Заявка с сайта')
            ->setHtmlBody($message)
            ->send();

        $callback = new Callback();
        $result = $callback->addCallback(Yii::$app->request->queryParams);
        if($result) return 'done';
        else return 'error';
    }

    public function actionCreatecsv(){
        $user = User::find()
            ->select('id')
            ->where('id = :user_id', ['user_id' => Yii::$app->user->id])
            ->one();

        if($user->id != 1) die(); 

        $data = "Пароль;Имя;Телефон;Email;Количество ответов;Дата;Промо код;Номер чека;Тип сертификата\r\n";

        $query = 'SELECT code.code, code.name, code.phone, code.email, code.answers_count, code.activate_date, code.promo_code, code.check_number, certificate.type FROM  `code`, `certificate` WHERE code.promo_code <> "" AND code.promo_code <> "none" AND certificate.promo_code=code.promo_code';
        $result = \Yii::$app->db->createCommand($query)->queryAll();

        //echo "<pre>".print_r($result, 1)."</pre>";
        foreach ($result as $value) {
            $data .= trim($value['code']).
                ';' . $value['name'] .
                ';' . $value['phone'] .
                ';' . $value['email'] .
                ';' . $value['answers_count'] .
                ';' . $value['activate_date'] .
                ';' . $value['promo_code'] .
                ';' . $value['check_number'] .
                ';' . $value['type'] .
                "\r\n";
        }
//        header('Content-type: text/csv');
//        header('Content-Disposition: attachment; filename="certificate.csv"');
        $data = iconv('utf-8', 'windows-1251', $data); //Если вдруг в Windows будут кракозябры


        $fp = fopen("certificate.csv", "w");
        fwrite($fp, $data);
        fclose($fp);
        return Yii::$app->response->sendFile(Yii::getAlias('certificate.csv'));
        //Yii::$app->end();
    }



    public function actionClear(){
        if($_SERVER['REMOTE_ADDR'] == '95.161.6.148'){
            $code = yii::$app->request->post("code");
            $code = "%".$code."%";
            $query = 'UPDATE code SET current_step =  "", time_s1 =  "0000-00-00 00:00:00", time_s2 =  "0000-00-00 00:00:00",time_s3 =  "0000-00-00 00:00:00", name =  "",phone =  "",email =  "", current_question =  "", questions =  "",answers =  "", answers_count =  "", activate_date = "0000-00-00 00:00:00", promo_code =  "", ip =  "", check_number =  "" WHERE code LIKE "'.$code.'"';
            $result = \Yii::$app->db->createCommand($query)->queryOne();
            if($result) return "done";
        }
    }
}