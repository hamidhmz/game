<?php
namespace backend\controllers;
use yii\web\Response;
use Yii;
use common\models\Users;
use common\models\Cities;
use common\models\Provinces;
use yii\web\UploadedFile;
use common\models\UsersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
class UsersController extends Controller {
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
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }

        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionView($id) {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }

        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }
    public function actionCreate() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }

        $model = new Users();

        if ($model->load(Yii::$app->request->post())) {

            $model->auth_key = Yii::$app->security->generateRandomString();
            $model->password_hash = Yii::$app->security->generatePasswordHash(Yii::$app->params['users.defaultPassword']);
            $model->status_id = Yii::$app->params['users.statusActive'];
            $model->avatar = Yii::$app->params['users.defaultAvatar'];
            $model->group_id = Yii::$app->params['users.groupUser'];

            $model->created_at = $model->updated_at = date('Y-m-d H:i:s');
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        $provinces = Provinces::find()->orderBy(['title' => SORT_ASC])->all();
        $cities = Cities::find()->where(['province_id' => $model->province_id])->orderBy(['title' => SORT_ASC])->all();

        return $this->render('create', [
                    'model' => $model,
                    'cities' => $cities,
                    'provinces' => $provinces,
        ]);
    }
    public function actionUpdate($id) {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $provinces = Provinces::find()->orderBy(['title' => SORT_ASC])->all();
        $cities = Cities::find()->where(['province_id' => $model->province_id])->orderBy(['title' => SORT_ASC])->all();

        return $this->render('update', [
                    'model' => $model,
                    'cities' => $cities,
                    'provinces' => $provinces,
        ]);
    }
    //------------------------------------------------
    public function actionChangeAvatar() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }

        $avatar = UploadedFile::getInstanceByName('user_avatar');
        if ($avatar && Yii::$app->request->post('user_id')) {
            $filename = uniqid(time(), true) . '.' . $avatar->extension;
            $model = $this->findModel(Yii::$app->request->post('user_id'));
            if ($avatar->saveAs(Yii::getAlias("@adminUserAvatarPath/$filename"))) {
                $model->avatar = $filename;
                $model->save();
                Yii::$app->session->setFlash('success', ' تصویر آواتار با موفقیت ثبت شد.');
            }
            else {
                Yii::$app->session->setFlash('danger', ' خطا در ذخیره تصویر آواتار!');
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->redirect(['index']);
    }
    public function actionDelete($id) {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }

        $model = $this->findModel($id);
        $model->status_id = Yii::$app->params['users.statusDelete'];
        $model->save();
        Yii::$app->session->setFlash('success', ' اطلاعات کاربر با موفقیت حذف شد.');
        return $this->redirect(['index']);
    }
    public function actionActive($id) {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }

        $model = $this->findModel($id);
        $model->status_id = Yii::$app->params['users.statusActive'];
        $model->save();
        Yii::$app->session->setFlash('success', ' کاربر فعال شد.');
        return $this->redirect(['view', 'id' => $model->id]);
    }
    public function actionDeActive($id) {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }

        $model = $this->findModel($id);
        $model->status_id = Yii::$app->params['users.statusInActive'];
        $model->save();
        Yii::$app->session->setFlash('success', ' کاربر غیر فعال شد.');
        return $this->redirect(['view', 'id' => $model->id]);
    }
    public function actionResetPassword($id) {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }

        $model = $this->findModel($id);
        $model->password_hash = Yii::$app->security->generatePasswordHash(Yii::$app->params['users.defaultPassword']);
        $model->save();
        Yii::$app->session->setFlash('success', ' رمزعبور بازیابی شد.');
        Yii::$app->session->setFlash('warning', ' رمز عبور جدید ' . Yii::$app->params['users.defaultPassword'] . ' میباشد.');
        return $this->redirect(['view', 'id' => $model->id]);
    }
    public function actionGetCities($province_id) {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }

        if (Yii::$app->request->isAjax && is_numeric($province_id)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $output = Cities::find()
                    ->where(['province_id' => $province_id])
                    ->orderBy(['title' => SORT_ASC])
                    ->all();
            return $output;
        }
        return $this->redirect(['index']);
    }
    //----------------------------------------------------
    protected function findModel($id) {
        $model = Users::find()->where(['id' => $id])
                ->andWhere('id <> ' . Yii::$app->user->id)
                ->andWhere(['not', ['status_id' => Yii::$app->params['users.statusDelete']]]);
        if (Yii::$app->user->identity->group_id == Yii::$app->params['users.groupAdmin']) {
            $model = $model->andWhere(['not', ['group_id' => Yii::$app->params['users.groupAdministrator']]]);
        }
        elseif (Yii::$app->user->identity->group_id == Yii::$app->params['users.groupDeputy']) {
            $model = $model->andWhere([
                'not', [
                    'group_id' => Yii::$app->params['users.groupAdministrator'],
                    'group_id' => Yii::$app->params['users.groupAdmin'],
                ]
            ]);
        }
        $model = $model->one();
        if ($model !== null) {
            return $model;
        }
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}