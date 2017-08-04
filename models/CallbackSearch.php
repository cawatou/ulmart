<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Callback;

class CallbackSearch extends Callback
{

    public function rules(){
        return [
            [['id'], 'integer'],
            [['name', 'phone', 'email', 'question', 'answer', 'date_q', 'date_a', 'answer_author', 'type', 'ip'], 'safe'],
        ];
    }

    public function scenarios(){
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params){
        $query = Callback::find()->orderBy(['date_q' => SORT_DESC]);

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
            'date_q' => $this->date_q,
            'date_a' => $this->date_a,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'question', $this->question])
            ->andFilterWhere(['like', 'answer', $this->answer])
            ->andFilterWhere(['like', 'answer_author', $this->answer_author])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'ip', $this->ip]);

        return $dataProvider;
    }
    
    public function searchTech($params){
        $query = Callback::find()->where(['type' => 'T']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);
        // add conditions that should always apply here

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'date_q' => $this->date_q,
            'date_a' => $this->date_a,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'question', $this->question])
            ->andFilterWhere(['like', 'answer', $this->answer])
            ->andFilterWhere(['like', 'answer_author', $this->answer_author])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'ip', $this->ip]);

        return $dataProvider;
    }
    
     public function searchShares($params){
        $query = Callback::find()->where(['type' => 'S']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);
        // add conditions that should always apply here

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'date_q' => $this->date_q,
            'date_a' => $this->date_a,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'question', $this->question])
            ->andFilterWhere(['like', 'answer', $this->answer])
            ->andFilterWhere(['like', 'answer_author', $this->answer_author])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'ip', $this->ip]);

        return $dataProvider;
    }
}
