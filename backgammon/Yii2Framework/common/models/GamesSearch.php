<?php
namespace common\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Games;
class GamesSearch extends Games {
    public function rules() {
        return [
                [['id', 'player_1', 'player_2', 'type_id', 'amount', 'status_id', 'total_amount', 'winner_id', 'loser_id'], 'integer'],
                [['started_at', 'finished_at'], 'safe'],
        ];
    }
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    public function search($params) {
        $query = Games::find();
        $query->where(['status_id' => Yii::$app->params['games.statusFinish']]);
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
            'id' => $this->id,
            'player_1' => $this->player_1,
            'player_2' => $this->player_2,
            'type_id' => $this->type_id,
            'amount' => $this->amount,
            'total_amount' => $this->total_amount,
            'winner_id' => $this->winner_id,
            'loser_id' => $this->loser_id,
            'started_at' => $this->started_at,
            'finished_at' => $this->finished_at,
        ]);
        return $dataProvider;
    }
    public function searchUser($params) {
        $query = Games::find()->where(['status_id' => Yii::$app->params['games.statusWaiting']]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);
        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'player_1' => $this->player_1,
            'player_2' => $this->player_2,
            'type_id' => $this->type_id,
            'amount' => $this->amount,
            'status_id' => $this->status_id,
            'total_amount' => $this->total_amount,
            'winner_id' => $this->winner_id,
            'loser_id' => $this->loser_id,
            'started_at' => $this->started_at,
            'finished_at' => $this->finished_at,
        ]);
        return $dataProvider;
    }
    public function searchUserHistory() {
        $query = Games::find();
        $query->where([
            'status_id' => Yii::$app->params['games.statusFinish'],
            'player_1' => Yii::$app->user->id
        ]);
        $query->orWhere([
            'status_id' => Yii::$app->params['games.statusFinish'],
            'player_2' => Yii::$app->user->id
        ]);
        $query->orderBy(['id' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
            'pagination' => false,
        ]);
        return $dataProvider;
    }
}