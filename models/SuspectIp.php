<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "suspect_ip".
 *
 * @property integer $id
 * @property string $ip
 * @property string $date
 * @property string $lock_type
 */
class SuspectIp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'suspect_ip';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip', 'date'], 'required'],
            [['date'], 'safe'],
            [['ip'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ip',
            'date' => 'Date',
        ];
    }
}
