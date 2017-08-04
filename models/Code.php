<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;

class Code extends ActiveRecord{

  /*  public function getCertificate(){
        return $this->hasOne(Certificate::className(), ['promo_code' => 'promo_code']);
    }*/

    public static function tableName(){
        return 'code';
    }


    public function rules(){
        return [
            [['code', 'current_step', 'time_s1', 'time_s2', 'time_s3', 'current_question', 'activate_date'], 'required'],
            [['current_step', 'current_question'], 'integer'],
            [['code'], 'string', 'max' => 12],
            [['check_number', 'name', 'promo_code'], 'string', 'max' => 20],
            [['phone'], 'string', 'max' => 25],
            [['email'], 'string', 'max' => 50],
            [['ip'], 'string', 'max' => 15],
        ];
    }

    
    public function attributeLabels(){
        return [
            'id' => 'ID',
            'code' => 'Пароль',
            'current_step' => 'Текущий шаг',
            'time_s1' => 'Время первого шага',
            'time_s2' => 'Время второго шага',
            'time_s3' => 'Время третьего шага',
            'check_number' => 'Номер чека',
            'name' => 'Имя',
            'phone' => 'Телефон',
            'email' => 'Email',
            'current_question' => 'Текущий вопрос',
            'answers_count' => 'Количество ответов',
            'activate_date' => 'Дата активации',
            'promo_code' => 'Промо код',
            'ip' => 'Ip',
        ];
    }


    public function codeSend(){
        $code_value = yii::$app->request->post('code');


        if(!is_string($code_value) || strlen($code_value) != 10 || stristr($code_value, '%') || stristr($code_value, '_')){
            // Записываем подозрительный код
            $result = Code::addSuspectcode();
            return $result;
        }

       /* if(){
            // Записываем подозрительный код
            $result = Code::addSuspectcode();
            return $result;
        }*/


        if($code_value != '') $data_code = Code::checkCode($code_value);
        if($data_code){
            $code = Code::findOne($data_code['id']);
            if($data_code['current_step'] == 0){
                $code->time_s1 = date("Y-m-d H:i:s");
                $code->ip = $_SERVER['REMOTE_ADDR'];
                $code->current_step = 1;
                Code::addSessioncode($code->code);
                if($code->update() !== false) return 'resume';
                else echo 'error update';
            }
            // Шаг 1
            if($data_code['current_step'] == 1){
                Code::addSessioncode($code->code);
                return 'resume';
            }
            // Шаг 2
            if($data_code['current_step'] == 2){
                Code::addSessioncode($code->code);
                return Yii::$app->response->redirect('questions');
            }
            // Шаг 3
            if($data_code['current_step'] == 3){
                Code::addSessioncode($code->code);
                return Yii::$app->response->redirect('gift');
            }

        }

        $data_code = Code::checkPromocode($code_value);
        if($data_code){
            return $data_code;
        }else{
            // Записываем подозрительный код
            $result = Code::addSuspectcode();
            return $result;
        }
    }


    public function checkCode($code, $step=''){
        $code = "%".$code."%";
        $query = "SELECT id, current_step, current_question FROM code WHERE code LIKE '". $code ."' AND promo_code = '' ";
        if($step == 1) $query = "SELECT id FROM code WHERE code LIKE '". $code ."' AND current_step = 1 AND promo_code = ''";
        if($step == 2) $query = "SELECT id, current_question, answers  FROM code WHERE code LIKE '". $code ."' AND current_step = 2 AND promo_code = ''";
        if($step == 3) $query = "SELECT id, answers_count, promo_code FROM code WHERE code LIKE '". $code ."'";
        $result = \Yii::$app->db->createCommand($query)->queryOne();
        if($result['id']) return $result;
        else return false;       
    }


    public function checkPromocode($code){
        $code = "%".$code."%";
        $query = "SELECT promo_code FROM code WHERE code LIKE '". $code ."'";
        $result = \Yii::$app->db->createCommand($query)->queryOne();
        $res = $result;


        if($res['promo_code'] == 'none') return 'certificate_none';
        if($res['promo_code'] != ''){
            $query = "SELECT type FROM certificate WHERE promo_code LIKE '". $res['promo_code'] ."'";
            $result = \Yii::$app->db->createCommand($query)->queryOne();
            $res['type'] = $result['type'];
        }


        if(isset($res['promo_code'])) return $res;
        return false;
    }


    public function resumeSend(){
        $name = yii::$app->request->post('name');
        $phone = yii::$app->request->post('phone');
        $email = yii::$app->request->post('email');
        $email_conf = yii::$app->request->post('email_conf');
        $check_number = yii::$app->request->post('check_number');
        $accept = yii::$app->request->post('accept');
        $code_value = Yii::$app->session['code'];

        // Валидация на сервере
        if(!filter_var($email, FILTER_VALIDATE_EMAIL) || $email != $email_conf) return 'error_email';
        if(!$name || !$phone || $accept != 'on') return 'error_required';

        $data_code = Code::checkCode($code_value, $step=1);
        if($data_code){
            $code = Code::findOne($data_code['id']);
            $code->time_s2 = date("Y-m-d H:i:s");
            $code->name = $name;
            $code->phone = $phone;
            $code->email = $email;
            $code->check_number = $check_number;
            $code->current_step = 2;
            Code::addSessioncode($code->code);
            if($code->update() !== false) return Yii::$app->response->redirect('questions');
            else echo 'error update';
        }else{

            // РЕДИРЕКТ НА СЕРТИФИКАТ


            // Записываем подозрительный код
            Code::addSuspectcode();
        }
    }


    public function addSuspectcode(){
        // Проверка на блокировку по ip
        $now = date("Y-m-d H:i:s");
        $query = "SELECT COUNT(*) AS count FROM suspect_ip WHERE date >= DATE_SUB('".$now."', INTERVAL 1 HOUR) AND ip = '".$_SERVER['REMOTE_ADDR']."'";
        $result = \Yii::$app->db->createCommand($query)->queryAll();
        $result = array_pop($result);

        if($result['count'] >= 1){
            return 'blocked';
        }else{
            // Проверка на блокировку по количеству неверных кодов
            $query = "SELECT COUNT(*) as count FROM suspect_code WHERE date >= DATE_SUB('".$now."', INTERVAL 1 HOUR) AND ip = '".$_SERVER['REMOTE_ADDR']."'";
            $result = \Yii::$app->db->createCommand($query)->queryAll();
            $result = array_pop($result);
            if($result['count'] >= 20){
                $suspect_ip = new SuspectIp();
                $suspect_ip->ip = $_SERVER['REMOTE_ADDR'];
                $suspect_ip->date = date("Y-m-d H:i:s");
                $suspect_ip->save();
                return 'blocked';
            }else{
                $suspect_code = new SuspectCode();
                $suspect_code->code = yii::$app->request->post('code');
                $suspect_code->date = date("Y-m-d H:i:s");
                $suspect_code->url = $_SERVER['REQUEST_URI'];
                $suspect_code->ip = $_SERVER['REMOTE_ADDR'];
                $suspect_code->save();
                return 'suspect_code';                
            }
        }
    }

    public function getBlocktime(){
        $query = "SELECT date FROM suspect_ip WHERE ip = '".$_SERVER['REMOTE_ADDR']."'";
        $result = \Yii::$app->db->createCommand($query)->queryAll();
        $block_time = array_pop($result);
        $block_time = strtotime($block_time['date']);
        $now = strtotime(date("Y-m-d H:i:s"));
        $unblock_time = 3600 - ($now - $block_time);
        $unblock_time = ceil($unblock_time/60);
        //$unblock_time = 'час';
        return $unblock_time;
    }


    public function addSessioncode($code){
        if(!Yii::$app->session->getIsActive()) Yii::$app->session->open();
        Yii::$app->session['code'] = $code;
        Yii::$app->session->close();
    }


    public function addAnswer($qid_post, $answer_post){
        $true_answer = (new \yii\db\Query())
            ->from('test')
            ->select(['answer'])
            ->where(['id' => $qid_post])
            ->one();

        if($true_answer['answer'] == $answer_post) return true;
        else return false;
    }

    // Выборка email'a пользователя по коду
    public function getEmail($code){
        $query = "SELECT email FROM code WHERE code = '".$code."'";
        $result = \Yii::$app->db->createCommand($query)->queryOne();
        return $result;
    }


    /*================================= BACKEND =============================================*/

    // Выборка уникальных пользователей принявших участие в акции
    public function clients(){
        $query = "SELECT COUNT(DISTINCT email) AS count FROM code";
        $result = \Yii::$app->db->createCommand($query)->queryAll();
        return $result;
    }

    // Выборка чеков принявших участие в акции
    public function count_check(){
        $query = "SELECT COUNT(check_number) AS count FROM code WHERE check_number <> ''";
        $result = \Yii::$app->db->createCommand($query)->queryAll();
        return $result;
    }

    // Количество пользователей ответивших на 1-2 вопроса
    public function count1_2(){
        $query = "SELECT COUNT(answers_count) AS count FROM code WHERE answers_count < 3";
        $result = \Yii::$app->db->createCommand($query)->queryAll();
        return $result;
    }

    // Количество пользователей ответивших на 3-5 вопроса
    public function count3_5(){
        $query = "SELECT COUNT(answers_count) AS count FROM code WHERE answers_count > 2 AND answers_count < 6";
        $result = \Yii::$app->db->createCommand($query)->queryAll();

        return $result;
    }

    // Количество пользователей ответивших на 6-8 вопроса
    public function count6_8(){
        $query = "SELECT COUNT(answers_count) AS count FROM code WHERE answers_count > 5 AND answers_count < 9";
        $result = \Yii::$app->db->createCommand($query)->queryAll();

        return $result;
    }

    // Количество пользователей ответивших на 9-10 вопроса
    public function count9_10(){
        $query = "SELECT COUNT(answers_count) AS count FROM code WHERE answers_count > 8";
        $result = \Yii::$app->db->createCommand($query)->queryAll();

        return $result;
    }
}
