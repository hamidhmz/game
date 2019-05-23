<?php
namespace frontend\models;
use Yii;
use yii\base\Model;
use common\models\Provinces;
use common\models\Cities;
class SignupForm extends Model {
    public $fullname;
    public $email;
    public $username;
    public $password;
    public function rules() {
        return [
                ['fullname', 'required'],
                ['fullname', 'string', 'min' => 6, 'max' => 255],

                ['email', 'trim'],
                ['email', 'required'],
                ['email', 'email'],
                ['email', 'string', 'max' => 255],
                [
                    'email',
                    'unique',
                    'targetClass' => Users::className(),
                    'message' => Yii::t('base', '1.')
                ],

                ['username', 'trim'],
                ['username', 'required'],
                ['username', 'string', 'min' => 6, 'max' => 15],
                [
                    'username',
                    'unique',
                    'targetClass' => Users::className(),
                    'message' => Yii::t('base', 'This username has already been taken.')
                ],

                ['password', 'required'],
                ['password', 'string', 'min' => 6, 'max' => 15],
        ];
    }
//    public function attributeLabels() {
//        return [
//            'fullname' => Yii::t('base', 'Fullname'),
//            'email' => Yii::t('base', 'Email'),
//            'username' => Yii::t('base', 'Username'),
//            'password' => Yii::t('base', 'Password'),
//        ];
//    }
    public function signup() {
        if (!$this->validate()) {
            return null;
        }
        $datetime = date('Y-m-d H:i:s');
        $user = new Users();
        $user->username = $this->username;
        $user->generateAuthKey();
        $user->setPassword($this->password);
        $user->email = $this->email;
        $user->group_id = Yii::$app->params['users.groupUser'];
        $user->status_id = Yii::$app->params['users.statusActive'];
        $user->created_at = $datetime;
        $user->updated_at = $datetime;
        $user->avatar = Yii::$app->params['users.defaultAvatar'];
        $user->fullname = $this->fullname;
        return $user->save() ? $user : null;
    }
}