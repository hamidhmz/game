<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use common\models\Games;
use common\models\GamesSearch;
use common\models\Users;
use common\models\Settings;
use common\models\GamesTypes;
class GamesController extends Controller {
    public function actionIndex() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }

        $user = Users::findOne(Yii::$app->user->id);

        $gamesPlay = Games::find()
                ->where(['player_1' => $user->id, 'status_id' => 1])
                ->orWhere(['player_2' => $user->id, 'status_id' => 1])
                ->orWhere(['player_1' => $user->id, 'status_id' => 2])
                ->orWhere(['player_2' => $user->id, 'status_id' => 2])
                ->one();

        if ($gamesPlay) {
            if ($gamesPlay->status_id == 1) {
                return $this->redirect(['view', 'id' => $gamesPlay->id]);
            }
            return $this->redirect(['play', 'id' => $gamesPlay->id]);
        }


        return $this->render('index', [
                    'user' => $user,
        ]);
    }
    public function actionCreate() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }

        $user = Users::findOne(Yii::$app->user->id);

        $gamesPlay = Games::find()
                ->where(['player_1' => $user->id, 'status_id' => 1])
                ->orWhere(['player_2' => $user->id, 'status_id' => 1])
                ->orWhere(['player_1' => $user->id, 'status_id' => 2])
                ->orWhere(['player_2' => $user->id, 'status_id' => 2])
                ->one();

        if ($gamesPlay) {
            if ($gamesPlay->status_id == 1) {
                return $this->redirect(['view', 'id' => $gamesPlay->id]);
            }
            return $this->redirect(['play', 'id' => $gamesPlay->id]);
        }

        $model = new Games();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->amount > $user->credit) {
                Yii::$app->session->setFlash('warning', 'موجودی شما برای شروع بازی کافی نمی باشد!');
            }
            else {
                $settings = Settings::findOne(1);
                $model->player_1 = Yii::$app->user->id;
                $model->status_id = Yii::$app->params['games.statusWaiting'];
                $model->datetime = date('Y-m-d H:i:s');
                $model->total_amount = ($model->amount * 2) - ((($model->amount * 2) * $settings->game_percent) / 100);
                $model->save();
                $user->credit = $user->credit - $model->amount;
                $user->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        $games_type = GamesTypes::find()->orderBy(['id' => SORT_ASC])->all();

        return $this->render('create', [
                    'user' => $user,
                    'model' => $model,
                    'games_type' => $games_type,
        ]);
    }
    public function actionView($id) {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }

        $user = Users::findOne(Yii::$app->user->id);
        $model = Games::findOne(['id' => $id, 'status_id' => 1, 'player_1' => $user->id]);
        if ($model === null) {
            return $this->redirect(['index']);
        }

        return $this->render('view', [
                    'user' => $user,
                    'model' => $model,
        ]);
    }
    public function actionPlay($id) {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }

        $user = Users::findOne(Yii::$app->user->id);
        $model = Games::find()
                ->where(['id' => $id, 'status_id' => 2, 'player_2' => $user->id])
                ->orWhere(['id' => $id, 'status_id' => 2, 'player_1' => $user->id])
                ->one();
        if ($model === null) {
            return $this->redirect(['index']);
        }

        return $this->render('play', [
                    'user' => $user,
                    'model' => $model,
        ]);
    }
    public function actionHistory() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }

        $user = Users::findOne(Yii::$app->user->id);
        $searchModel = new GamesSearch();
        $dataProvider = $searchModel->searchUserHistory();

        return $this->render('history', [
                    'user' => $user,
                    'dataProvider' => $dataProvider,
        ]);
    }
}