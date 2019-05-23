<?php
namespace common\models;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Provinces;
class ProvincesSearch extends Provinces {
    public function rules() {
        return [
                [['title'], 'safe'],
        ];
    }
    public function scenarios() {
        return Model::scenarios();
    }
    public function search($params) {
        $query = Provinces::find();
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
        $query->andFilterWhere(['like', 'title', $this->title]);
        return $dataProvider;
    }
}