<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
use backend\models\LoginForm;
use common\models\Users;
use common\models\Games;
use common\models\Settings;
class SiteController extends Controller {
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    public function actionIndex() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['login']);
        }

        $user = Yii::$app->user->identity;
        $total_users = Users::find()
                ->where([
                    'group_id' => Yii::$app->params['users.groupUser'],
                    'status_id' => Yii::$app->params['users.statusActive'],
                ])
                ->count();
        $total_games = Games::find()
                ->where([
                    'status_id' => Yii::$app->params['games.statusFinish']
                ])
                ->count();

        return $this->render('index', [
                    'user' => $user,
                    'total_users' => $total_users,
                    'total_games' => $total_games,
        ]);
    }
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['index']);
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['index']);
        }
        $settings = Settings::findOne(1);
        return $this->render('login', [
                    'model' => $model,
                    'settings' => $settings,
        ]);
    }
    public function actionLogout() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['login']);
        }
        Yii::$app->user->logout();
        return $this->redirect(['login']);
    }
}