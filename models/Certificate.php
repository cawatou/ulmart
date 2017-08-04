<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;


/**
 * This is the model class for table "certificate".
 *
 * @property integer $id
 * @property string $promo_code
 * @property string $type
 * @property string $value
 * @property string $status
 * @property string $issume_date
 */
class Certificate extends ActiveRecord{

    public $count;

    public function getCode(){
        return $this->hasOne(Code::className(), ['promo_code' => 'promo_code']);
    }


    public static function tableName(){
        return 'certificate';
    }


    public function rules(){
        return [
            [['promo_code', 'type', 'value', 'status', 'issume_date'], 'required'],
            [['issume_date'], 'safe'],
            [['promo_code'], 'string', 'max' => 20],
            [['type', 'status'], 'string', 'max' => 1],
            [['value'], 'string', 'max' => 50],
            [['promo_code'], 'unique'],
        ];
    }


    public function attributeLabels(){
        return [
            'id' => 'ID',
            'promo_code' => 'Промо код',
            'type' => 'Тип сертификата',
            'value' => 'Название подарка или размер скидки',
            'status' => 'Статус',
            'issume_date' => 'Дата выдачи',
        ];
    }




    public function addPromocode($type, $code){
        $promo_code = (new \yii\db\Query())
            ->from('certificate')
            ->select(['id', 'promo_code'])
            ->where(['type' => $type, 'status' => ''])
            ->one();


        Certificate::updateCertificate($promo_code['id'], $code);
        return $promo_code['promo_code'];
    }

    public function updateCertificate($id, $code){
        $certificate = Certificate::findOne($id);
        $certificate->status = '1';
        $certificate->issume_date = date("Y-m-d H:i:s");
        $certificate->code = $code;
        $certificate->update();
    }


    /*================================= BACKEND =============================================*/

    public function searchType($params){
        $query = "SELECT type , COUNT(*) AS count, SUM(status=1) AS activeted FROM certificate GROUP BY type";
        $result = \Yii::$app->db->createCommand($query)->queryAll();
        return $result;
    }

    // Количество выигранной концелярии
    public function count_office(){
        $query = "SELECT COUNT(type) AS count FROM certificate WHERE type = 'A' AND status = '1'";
        $result = \Yii::$app->db->createCommand($query)->queryAll();
        return $result;
    }

    // Количество выигранных настольных игр
    public function count_game(){
        $query = "SELECT COUNT(type) AS count FROM certificate WHERE type = 'B' AND status = '1'";
        $result = \Yii::$app->db->createCommand($query)->queryAll();
        return $result;
    }

    // Количество выигранных ноутбуковЙ
    public function count_comp(){
        $query = "SELECT COUNT(type) AS count FROM certificate WHERE type = 'C' AND status = '1'";
        $result = \Yii::$app->db->createCommand($query)->queryAll();
        return $result;
    }
}
