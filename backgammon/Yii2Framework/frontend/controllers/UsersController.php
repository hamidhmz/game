<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use frontend\models\ChangePassword;
use common\models\Users;
use common\models\Provinces;
use common\models\Cities;
class UsersController extends Controller {
    public function actionView($id = null) {

        if (!$id && Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }

        /* @var $model \common\models\Users */
        $model = $this->findModel($id ? $id : Yii::$app->user->id);

        return $this->render('view', [
                    'model' => $model,
        ]);
    }
    public function actionUpdate() {
        /* @var $model \common\models\Users */
        $model = $this->findModel(Yii::$app->user->id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'اطلاعات شما با موفقیت ثبت گردید.');
            return $this->refresh();
        }

        $provinces = Provinces::find()->orderBy(['title' => SORT_ASC])->all();
        $cities = Cities::find()->where(['province_id' => $model->province_id])->orderBy(['title' => SORT_ASC])->all();

        return $this->render('update', [
                    'model' => $model,
                    'provinces' => $provinces,
                    'cities' => $cities,
        ]);
    }
    public function actionAvatar() {
        /* @var $model \common\models\Users */
        $model = $this->findModel(Yii::$app->user->id);
        $lastFile = $model->avatar;

        if ($model->load(Yii::$app->request->post())) {

            $file = UploadedFile::getInstance($model, 'avatar');
            if ($file) {
                $path = 'uploads/users/avatar/';
                $fileName = uniqid(time(), true) . '.' . $file->extension;
                $file->saveAs($path . $fileName);
                $model->avatar = $fileName;
            }
            else {
                $model->avatar = $lastFile;
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'اطلاعات شما با موفقیت ثبت گردید.');
                return $this->refresh();
            }
        }

        return $this->render('avatar', [
                    'model' => $model,
        ]);
    }
    public function actionCredit() {
        /* @var $model \common\models\Users */
        $model = $this->findModel(Yii::$app->user->id);
        $last_credit = $model->credit;

        if ($model->load(Yii::$app->request->post())) {
            $model->credit = $last_credit + $model->credit;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'اطلاعات شما با موفقیت ثبت گردید.');
                return $this->refresh();
            }
        }

        $model->credit = null;

        return $this->render('credit', [
                    'model' => $model,
                    'last_credit' => $last_credit,
        ]);
    }
    public function actionChangePassword() {
        /* @var $model \frontend\models\ChangePassword */
        $model = new ChangePassword(Yii::$app->user->id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->compare(1)) {
                if ($model->compare(2)) {
                    $model->setNewPassword();
                    Yii::$app->session->setFlash('success', 'رمز عبور جدید با موفقیت ثبت شد.');
                    return $this->refresh();
                }
                else {
                    Yii::$app->session->setFlash('warning', 'رمز عبور جدید با تکرار آن برابر نمی باشد.');
                }
            }
            else {
                Yii::$app->session->setFlash('warning', 'رمز عبور فعلی اشتباه می باشد.');
            }
        }

        return $this->render('change-password', [
                    'model' => $model,
        ]);
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
    protected function findModel($id) {
        $model = Users::find()
                ->where([
                    'id' => $id,
                    'status_id' => Yii::$app->params['users.statusActive'],
                    'group_id' => Yii::$app->params['users.groupUser'],
                ])
                ->one();
        if ($model !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}