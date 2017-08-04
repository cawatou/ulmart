<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Code;

/**
 * CodeSearch represents the model behind the search form about `app\models\Code`.
 */
class CodeSearch extends Code
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'current_step'], 'integer'],
            [['code', 'time_s1', 'time_s2', 'time_s3', 'check_number', 'name', 'phone', 'email', 'activate_date', 'promo_code', 'ip'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Code::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'current_step' => $this->current_step,
            'time_s1' => $this->time_s1,
            'time_s2' => $this->time_s2,
            'time_s3' => $this->time_s3,
            'activate_date' => $this->activate_date,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'check_number', $this->check_number])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'promo_code', $this->promo_code])
            ->andFilterWhere(['like', 'ip', $this->ip]);

        return $dataProvider;
    }
}
