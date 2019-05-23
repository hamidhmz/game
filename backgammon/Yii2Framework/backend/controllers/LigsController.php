<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Ligs;
use common\models\LigsSearch;
use common\models\LigsTypes;
use common\models\LigsPlayers;
use common\models\LigsGames;
class LigsController extends Controller {
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    public function actionIndex1() {
        $searchModel = new LigsSearch();
        $dataProvider = $searchModel->search1(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionIndex2() {
        $searchModel = new LigsSearch();
        $dataProvider = $searchModel->search2(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionIndex3() {
        $searchModel = new LigsSearch();
        $dataProvider = $searchModel->search3(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionIndex4() {
        $searchModel = new LigsSearch();
        $dataProvider = $searchModel->search4(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionView($id) {
        $model = $this->findModel($id);
        $playersCount = $model->getLigsPlayers()->count();
        return $this->render('view', [
                    'model' => $model,
                    'playersCount' => $playersCount,
        ]);
    }
    public function actionCreate() {
        $model = new Ligs();
        if ($model->load(Yii::$app->request->post())) {
            $model->status_id = Yii::$app->params['ligs.statusWaitingForPlayer'];
            $model->datetime = date('Y-m-d H:i:s');
            if (array_search($model->players_count, Yii::$app->params['ligs.playersCount']) != FALSE) {
                if ($model->save()) {
                    for ($index = 0, $count = $model->players_count - 1; $index < $count; $index++) {
                        $ligsGames = new LigsGames;
                        $ligsGames->lig_id = $model->id;
                        $ligsGames->status_id = 1;
                        $ligsGames->save();
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            else {
                Yii::$app->session->setFlash('warning', Yii::t('app', 'Error'));
            }
        }

        $ligs_type = LigsTypes::find()
                ->orderBy(['id' => SORT_ASC])
                ->all();

        return $this->render('create', [
                    'model' => $model,
                    'ligs_type' => $ligs_type,
        ]);
    }
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $playersCount = $model->getLigsPlayers()->count();
        if ($playersCount == 0) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                LigsGames::deleteAll(['lig_id' => $model->id]);
                for ($index = 0, $count = $model->players_count - 1; $index < $count; $index++) {
                    $ligsGames = new LigsGames;
                    $ligsGames->lig_id = $model->id;
                    $ligsGames->status_id = 1;
                    $ligsGames->save();
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
            $ligs_type = LigsTypes::find()->all();
            return $this->render('update', [
                        'model' => $model,
                        'ligs_type' => $ligs_type,
            ]);
        }
        return $this->redirect(['view', 'id' => $model->id]);
    }
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $status = $model->status_id;
        if ($status == 1) {
            $model->delete();
        }
        return $this->redirect(['index' . $status]);
    }
    protected function findModel($id) {
        if (($model = Ligs::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}