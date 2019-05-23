<?php
namespace common\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Users;
class UsersSearch extends Users {
    public function rules() {
        return [
                [['id', 'status_id', 'province_id', 'city_id', 'credit'], 'integer'],
                [['username', 'email', 'fullname'], 'safe'],
        ];
    }
    public function scenarios() {
        return Model::scenarios();
    }
    public function search($params) {
        $query = Users::find();
        $query->where(['group_id' => Yii::$app->params['users.groupUser']]);
        $query->andWhere(['<>', 'status_id', Yii::$app->params['users.statusDelete']]);
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
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['status_id' => $this->status_id]);
        $query->andFilterWhere(['province_id' => $this->province_id]);
        $query->andFilterWhere(['city_id' => $this->city_id]);
        $query->andFilterWhere(['credit' => $this->credit]);
        $query->andFilterWhere(['like', 'username', $this->username]);
        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['like', 'fullname', $this->fullname]);
        return $dataProvider;
    }
}