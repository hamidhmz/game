<?php
namespace frontend\models;
use Yii;
use yii\base\Model;
use yii\captcha\captcha;
class LoginForm extends Model {
    public $username;
    public $password;
    public $rememberMe = true;
    private $_user;
    public $captcha;
    public function rules() {
        return [
            [['username', 'password','captcha'], 'required'],
            ['rememberMe', 'boolean'],
            ['captcha', 'captcha'],
            ['password', 'validatePassword'],
        ];
    }
//    public function attributeLabels() {
//        return [
//            'username' => Yii::t('base', 'Username'),
//            'password' => Yii::t('base', 'Password'),
//            'rememberMe' => Yii::t('base', 'Remember Me'),
//        ];
//    }
    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Yii::t('base', 'Incorrect username or password.'));
            }
        }
    }
    public function login() {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        else {
            return false;
        }
    }
    protected function getUser() {
        if ($this->_user === null) {
            $this->_user = Users::findByUsername($this->username);
        }
        return $this->_user;
    }
}