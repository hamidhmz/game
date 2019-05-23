<?php
namespace frontend\models;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;
/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $group_id
 * @property integer $status_id
 * @property safe $created_at
 * @property safe $updated_at
 * @property string $fullname
 * @property string $avatart
 * @property integer $province_id
 * @property integer $city_id
 * @property string $password write-only password
 */
class Users extends ActiveRecord implements IdentityInterface {
    public static function tableName() {
        return 'users';
    }
    public static function findIdentity($id) {
        return static::findOne([
            'id' => $id,
            'group_id' => Yii::$app->params['users.groupUser'],
            'status_id' => Yii::$app->params['users.statusActive']
        ]);
    }
    public static function findByUsername($username) {
        return static::findOne([
            'username' => $username,
            'group_id' => Yii::$app->params['users.groupUser'],
            'status_id' => Yii::$app->params['users.statusActive']
        ]);
    }
    public static function findByEmail($email) {
        return static::findOne([
            'email' => $email,
            'group_id' => Yii::$app->params['users.groupUser'],
            'status_id' => Yii::$app->params['users.statusActive']
        ]);
    }
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }
        return static::findOne([
            'password_reset_token' => $token,
            'group_id' => Yii::$app->params['users.groupUser'],
            'status_id' => Yii::$app->params['users.statusActive']
        ]);
    }
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }
        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['users.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }
    public function getId() {
        return $this->getPrimaryKey();
    }
    public function getAuthKey() {
        return $this->auth_key;
    }
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }
}