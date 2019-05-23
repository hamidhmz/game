<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use common\models\Settings;
class SettingsController extends Controller {
    public function actionIndex() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }


        $model = Settings::findOne(1);
        $lastLogo = $model->site_logo;
        $lastFavicon = $model->site_favicon;

        if ($model->load(Yii::$app->request->post())) {

            $logo = UploadedFile::getInstance($model, 'site_logo');
            if ($logo) {
                $path = '../uploads/settings/logo/';
                $filename = uniqid(time(), true) . '.' . $logo->extension;
                $logo->saveAs($path . $filename);
                $model->site_logo = $filename;
            }
            else {
                $model->site_logo = $lastLogo;
            }

            $favicon = UploadedFile::getInstance($model, 'site_favicon');
            if ($favicon) {
                $path = '../uploads/settings/favicon/';
                $filename = uniqid(time(), true) . '.' . $favicon->extension;
                $favicon->saveAs($path . $filename);
                $model->site_favicon = $filename;
            }
            else {
                $model->site_favicon = $lastFavicon;
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('base', 'Information saved.'));
                return $this->refresh();
            }
        }

        return $this->render('index', [
                    'model' => $model,
        ]);
    }
}