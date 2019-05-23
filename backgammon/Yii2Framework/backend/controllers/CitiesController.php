<?php
namespace backend\controllers;
use Yii;
use common\models\Cities;
use common\models\Provinces;
use common\models\CitiesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
class CitiesController extends Controller {
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
    public function actionIndex() {
        $searchModel = new CitiesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $provinces = Provinces::find()->orderBy(['title' => SORT_ASC])->all();
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'provinces' => $provinces,
        ]);
    }
    public function actionView($id) {
        $model = $this->findModel($id);
        return $this->render('view', [
                    'model' => $model,
        ]);
    }
    public function actionCreate() {
        $model = new Cities();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $provinces = Provinces::find()->orderBy(['title' => SORT_ASC])->all();
        return $this->render('create', [
                    'model' => $model,
                    'provinces' => $provinces,
        ]);
    }
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $provinces = Provinces::find()->orderBy(['title' => SORT_ASC])->all();
        return $this->render('update', [
                    'model' => $model,
                    'provinces' => $provinces,
        ]);
    }
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->delete();
        return $this->redirect(['index']);
    }
    protected function findModel($id) {
        $model = Cities::findOne($id);
        if ($model !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}