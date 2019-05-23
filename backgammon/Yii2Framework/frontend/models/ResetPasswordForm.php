<?php
namespace frontend\models;
use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;
class ResetPasswordForm extends Model {
    public $password;
    private $_user = null;
    public function __construct($token, $config = []) {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException(Yii::t('base', 'Password reset token cannot be blank.'));
        }
        $this->_user = Users::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException(Yii::t('base', 'Wrong password reset token.'));
        }
        parent::__construct($config);
    }
    public function rules() {
        return [
                ['password', 'required'],
                ['password', 'string', 'min' => 6, 'max' => 255],
        ];
    }
    public function attributeLabels() {
        return [
            'password' => Yii::t('base', 'Password'),
        ];
    }
    public function resetPassword() {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();
        return $user->save(false);
    }
}