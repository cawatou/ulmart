<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "suspect_code".
 *
 * @property integer $id
 * @property string $code
 * @property string $date
 * @property string $ip
 */
class SuspectCode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'suspect_code';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'date', 'ip'], 'required'],
            [['date'], 'safe'],
            [['code'], 'string', 'max' => 12],
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
            'code' => 'Code',
            'date' => 'Date',
            'ip' => 'Ip',
        ];
    }
}
