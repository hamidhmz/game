<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use common\models\Ligs;
use common\models\LigsPlayers;
use common\models\LigsGames;
use common\models\Users;
class LigsController extends Controller {
    public function actionIndex() {

        /* @var $user Users */
        $user = Users::findOne(Yii::$app->user->id);

        /* @var $lig Ligs */
        $lig = Ligs::find()
                ->innerJoin('ligs_players', 'ligs.id=ligs_players.lig_id')
                ->where(['<>', 'ligs.status_id', 4])
                ->andWhere(['ligs_players.player_id' => $user->id])
                ->one();

        if ($lig) {
            if ($lig->status_id == 3) {
                /* @var $game LigsGames */
                $game = $lig->getLigsGames()
                        ->where(['status_id' => 3, 'player_1' => $user->id])
                        ->orWhere(['status_id' => 3, 'player_2' => $user->id])
                        ->one();
                if ($game) {
                    return $this->redirect(['play']);
                }
            }
            return $this->redirect(['view']);
        }

        /* @var $ligs Ligs */
        $ligs = Ligs::find()
                ->where(['status_id' => 1])
                ->andWhere(['>=', "concat(start_date, ' ', start_time)", date('Y-m-d H:i:s')])
                ->andWhere('(SELECT COUNT(ligs_players.id) FROM ligs_players WHERE ligs_players.lig_id = ligs.id) < players_count')
                ->orderBy(['start_date' => SORT_ASC, 'start_time' => SORT_ASC])
                ->all();

        return $this->render('index', [
                    'ligs' => $ligs,
                    'user' => $user,
        ]);
    }
    public function actionJoin($id) {

        /* @var $user Users */
        $user = Users::findOne(Yii::$app->user->id);

        /* @var $lig Ligs */
        $lig = Ligs::find()
                ->innerJoin('ligs_players', 'ligs.id=ligs_players.lig_id')
                ->where(['<>', 'ligs.status_id', 4])
                ->andWhere(['ligs_players.player_id' => $user->id])
                ->one();

        if ($lig) {
            if ($lig->status_id == 3) {
                /* @var $game LigsGames */
                $game = $lig->getLigsGames()
                        ->where(['status_id' => 3, 'player_1' => $user->id])
                        ->orWhere(['status_id' => 3, 'player_2' => $user->id])
                        ->one();
                if ($game) {
                    return $this->redirect(['play']);
                }
            }
            return $this->redirect(['view']);
        }

        /* @var $lig Ligs */
        $lig = Ligs::find()
                ->where(['status_id' => 1, 'id' => $id])
                ->andWhere(['>', "concat(start_date, ' ', start_time)", date('Y-m-d H:i:s')])
                ->andWhere('(SELECT COUNT(ligs_players.id) FROM ligs_players WHERE ligs_players.lig_id = ligs.id) < players_count')
                ->one();

        if (!$lig) {
            return $this->redirect(['index']);
        }

        if ($user->credit < $lig->amount) {
            return $this->redirect(['index']);
        }

        $user->credit -= $lig->amount;
        $user->save();

        $model = new LigsPlayers;
        $model->lig_id = $lig->id;
        $model->player_id = $user->id;
        $model->datetime = date('Y-m-d H:i:s');
        $model->save();

        if ($lig->players_count == $lig->getLigsPlayers()->count()) {
            
            $lig->status_id = 2;
            $lig->save();
            
            $i = 0;
            $games = LigsGames::find()->where(['lig_id' => $lig->id])->orderBy(['id' => SORT_ASC])->limit($lig->players_count / 2)->all();
            $players = LigsPlayers::find()->where(['lig_id' => $lig->id])->orderBy(['id' => SORT_ASC])->all();
            foreach ($games as $game) {
                /* @var $game LigsGames */
                $game->player_1 = $players[$i]->player_id;
                $game->player_2 = $players[$i + 1]->player_id;
                $game->status_id = 2;
                $game->save();
                $i += 2;
            }
        }

        return $this->redirect(['view']);
    }
    public function actionView() {

        /* @var $user Users */
        $user = Users::findOne(Yii::$app->user->id);

        /* @var $lig Ligs */
        $lig = Ligs::find()
                ->innerJoin('ligs_players', 'ligs.id=ligs_players.lig_id')
                ->where(['<>', 'ligs.status_id', 4])
                ->andWhere(['ligs_players.player_id' => $user->id])
                ->one();

        if (!$lig) {
            return $this->redirect(['index']);
        }

        /* @var $game LigsGames */
        $game = $lig->getLigsGames()
                ->where(['player_1' => $user->id])
                ->orWhere(['player_2' => $user->id])
                ->one();

        return $this->render('view', [
                    'lig' => $lig,
                    'game' => $game,
                    'user' => $user,
        ]);
    }
    public function actionPlay() {

        /* @var $user Users */
        $user = Users::findOne(Yii::$app->user->id);

        /* @var $lig Ligs */
        $lig = Ligs::find()
                ->innerJoin('ligs_players', 'ligs.id=ligs_players.lig_id')
                ->where(['<>', 'ligs.status_id', 4])
                ->andWhere(['ligs_players.player_id' => $user->id])
                ->one();

        if (!$lig) {
            return $this->redirect(['index']);
        }

        /* @var $game LigsGames */
        $game = $lig->getLigsGames()
                ->where(['status_id' => 3, 'player_1' => $user->id])
                ->orWhere(['status_id' => 3, 'player_2' => $user->id])
                ->one();

        if (!$game) {
            return $this->redirect(['view']);
        }

        return $this->render('play', [
                    'user' => $user,
                    'model' => $game,
        ]);
    }
}