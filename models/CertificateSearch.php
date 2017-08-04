<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Certificate;

/**
 * CertificateSearch represents the model behind the search form about `app\models\Certificate`.
 */
class CertificateSearch extends Certificate{

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['promo_code', 'type', 'value', 'status', 'issume_date'], 'safe'],
        ];
    }


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
        //$query = Certificate::find()->orderBy(['issume_date'=> SORT_DESC])->with('code');
        $query = Certificate::find()->with('code');
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
            'issume_date' => $this->issume_date,
        ]);

        $query->andFilterWhere(['like', 'promo_code', $this->promo_code])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }

}
