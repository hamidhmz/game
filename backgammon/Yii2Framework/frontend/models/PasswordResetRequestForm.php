<?php
namespace frontend\models;
use Yii;
use yii\base\Model;
use common\models\Settings;
use common\config\components\EMAIL;
class PasswordResetRequestForm extends Model {
    public $email;
    public function rules() {
        return [
                ['email', 'trim'],
                ['email', 'required'],
                ['email', 'email'],
                [
                    'email',
                    'exist',
                    'targetClass' => Users::className(),
                    'filter' => [
                        'group_id' => Yii::$app->params['users.groupUser'],
                        'status_id' => Yii::$app->params['users.statusActive'],
                    ],
                    'message' => Yii::t('base', 'There is no user with this email address.')
                ],
        ];
    }
    public function attributeLabels() {
        return [
            'email' => Yii::t('base', 'Email'),
        ];
    }
    public function sendEmail() {
        $user = Users::findByEmail($this->email);
        if (!$user) {
            return false;
        }
        if (!Users::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }
        $settings = Settings::findOne(1);
        return EMAIL::sendResetPassword($settings, $user);
    }
}