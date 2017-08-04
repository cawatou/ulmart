<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "callback".
 *
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $question
 * @property string $answer
 * @property string $date_q
 * @property string $date_a
 * @property string $answer_author
 * @property string $type
 * @property string $ip
 */
class Callback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'callback';
    }

    /**
     * @inheritdoc
     */
    public function rules(){
        return [
            [['name', 'email', 'question', 'date_q', 'ip'], 'required'],
            [['date_q', 'date_a'], 'safe'],
            [['name', 'email', 'answer_author'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 25],
            [['question', 'answer'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 1],
            [['ip'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(){
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'phone' => 'Телефон',
            'email' => 'Email',
            'question' => 'Вопрос',
            'answer' => 'Ответ',
            'date_q' => 'Дата вопроса',
            'date_a' => 'Дата ответа',
            'answer_author' => 'Автор ответа',
            'type' => 'Тип обращения',
            'ip' => 'IP адрес',
        ];
    }


    public function addCallback($params){
        $callback = new Callback();
        $callback->name = yii::$app->request->post('name');
        //$callback->phone = yii::$app->request->post('phone');
        $callback->email = yii::$app->request->post('email');
        $callback->question = yii::$app->request->post('msg');
        $callback->date_q = date("Y-m-d H:i:s");
        //$callback->type = yii::$app->request->post('type');
        $callback->ip = $_SERVER["REMOTE_ADDR"];
        return ($callback->save())?'done':'error';
    }
}
