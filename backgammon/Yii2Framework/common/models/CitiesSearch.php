<?php
namespace common\models;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Cities;
class CitiesSearch extends Cities {
    public function rules() {
        return [
                [['province_id'], 'integer'],
                [['title'], 'safe'],
        ];
    }
    public function scenarios() {
        return Model::scenarios();
    }
    public function search($params) {
        $query = Cities::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
            'pagination' => ['pageSize' => 10]
        ]);
        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'province_id' => $this->province_id,
        ]);
        $query->andFilterWhere(['like', 'title', $this->title]);
        return $dataProvider;
    }
}