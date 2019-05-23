<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\Games;
use common\models\GamesSearch;
use common\models\Users;
use common\models\GamesTypes;
class GamesController extends Controller {
    public function actionIndex() {
        $searchModel = new GamesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $users = Users::find()
                ->where([
                    'group_id' => Yii::$app->params['users.groupUser'],
                    'status_id' => Yii::$app->params['users.statusActive'],
                ])
                ->orderBy(['fullname' => SORT_ASC])
                ->all();

        $types = GamesTypes::find()
                ->orderBy(['id' => SORT_ASC])
                ->all();

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'users' => $users,
                    'types' => $types,
        ]);
    }
    public function actionView($id) {
        $model = $this->findModel($id);
        return $this->render('view', [
                    'model' => $model,
        ]);
    }
    protected function findModel($id) {
        $game = Games::find();
        $game->where(['id' => $id]);
        $game->andWhere(['status_id' => Yii::$app->params['games.statusFinish']]);
        $model = $game->one();
        if ($model !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}