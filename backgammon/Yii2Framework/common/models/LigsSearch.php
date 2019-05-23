<?php
namespace common\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Ligs;
class LigsSearch extends Ligs {
    public function rules() {
        return [
                [['id', 'type_id', 'players_count', 'amount', 'total_amount'], 'integer'],
                [['start_date', 'start_time'], 'safe'],
        ];
    }
    public function scenarios() {
        return Model::scenarios();
    }
    public function search1($params) {
        $query = Ligs::find();
        $query->where(['status_id' => Yii::$app->params['ligs.statusWaitingForPlayer']]);
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
        $query->andFilterWhere(['type_id' => $this->type_id]);
        $query->andFilterWhere(['start_date' => $this->start_date]);
        $query->andFilterWhere(['start_time' => $this->start_time]);
        $query->andFilterWhere(['players_count' => $this->players_count]);
        $query->andFilterWhere(['amount' => $this->amount]);
        $query->andFilterWhere(['total_amount' => $this->total_amount]);
        return $dataProvider;
    }
    public function search2($params) {
        $query = Ligs::find();
        $query->where(['status_id' => Yii::$app->params['ligs.statusWaitingForStart']]);
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
        $query->andFilterWhere(['type_id' => $this->type_id]);
        $query->andFilterWhere(['start_date' => $this->start_date]);
        $query->andFilterWhere(['start_time' => $this->start_time]);
        $query->andFilterWhere(['players_count' => $this->players_count]);
        $query->andFilterWhere(['amount' => $this->amount]);
        $query->andFilterWhere(['total_amount' => $this->total_amount]);
        return $dataProvider;
    }
    public function search3($params) {
        $query = Ligs::find();
        $query->where(['status_id' => Yii::$app->params['ligs.statusPlaying']]);
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
        $query->andFilterWhere(['type_id' => $this->type_id]);
        $query->andFilterWhere(['start_date' => $this->start_date]);
        $query->andFilterWhere(['start_time' => $this->start_time]);
        $query->andFilterWhere(['players_count' => $this->players_count]);
        $query->andFilterWhere(['amount' => $this->amount]);
        $query->andFilterWhere(['total_amount' => $this->total_amount]);
        return $dataProvider;
    }
    public function search4($params) {
        $query = Ligs::find();
        $query->where(['status_id' => Yii::$app->params['ligs.statusFinish']]);
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
        $query->andFilterWhere(['type_id' => $this->type_id]);
        $query->andFilterWhere(['start_date' => $this->start_date]);
        $query->andFilterWhere(['start_time' => $this->start_time]);
        $query->andFilterWhere(['players_count' => $this->players_count]);
        $query->andFilterWhere(['amount' => $this->amount]);
        $query->andFilterWhere(['total_amount' => $this->total_amount]);
        return $dataProvider;
    }
}