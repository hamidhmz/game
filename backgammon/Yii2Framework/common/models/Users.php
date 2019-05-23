<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $group_id
 * @property integer $status_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $fullname
 * @property string $avatar
 * @property integer $credit
 * @property string $address
 * @property string $phone
 * @property string $mobile
 * @property integer $province_id
 * @property integer $city_id
 *
 * @property Games[] $games
 * @property Games[] $games0
 * @property Games[] $games1
 * @property Games[] $games2
 * @property GamesBoards[] $gamesBoards
 * @property GamesBoardsDices[] $gamesBoardsDices
 * @property LigsGames[] $ligsGames
 * @property LigsGames[] $ligsGames0
 * @property LigsGames[] $ligsGames1
 * @property LigsGames[] $ligsGames2
 * @property LigsGamesBoards[] $ligsGamesBoards
 * @property LigsGamesBoardsDices[] $ligsGamesBoardsDices
 * @property LigsPlayers[] $ligsPlayers
 * @property UsersGroups $group
 * @property UsersStatus $status
 * @property Provinces $province
 * @property Cities $city
 * @property UsersFollowers[] $usersFollowers
 * @property UsersFollowers[] $usersFollowers0
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'group_id', 'status_id', 'created_at', 'updated_at', 'fullname', 'avatar'], 'required'],
            [['group_id', 'status_id', 'province_id', 'city_id'], 'integer'],
            [['credit'], 'integer', 'max' => 2000000],
            [['created_at', 'updated_at'], 'safe'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'fullname', 'avatar', 'address', 'phone', 'mobile'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => UsersGroups::className(), 'targetAttribute' => ['group_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => UsersStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => Provinces::className(), 'targetAttribute' => ['province_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('base', 'ID'),
            'username' => Yii::t('base', 'Username'),
            'auth_key' => Yii::t('base', 'Auth Key'),
            'password_hash' => Yii::t('base', 'Password Hash'),
            'password_reset_token' => Yii::t('base', 'Password Reset Token'),
            'email' => Yii::t('base', 'Email'),
            'group_id' => Yii::t('base', 'Group ID'),
            'status_id' => Yii::t('base', 'Status ID'),
            'created_at' => Yii::t('base', 'Created At'),
            'updated_at' => Yii::t('base', 'Updated At'),
            'fullname' => Yii::t('base', 'Fullname'),
            'avatar' => Yii::t('base', 'Avatar'),
            'credit' => Yii::t('base', 'Credit'),
            'address' => Yii::t('base', 'Address'),
            'phone' => Yii::t('base', 'Phone'),
            'mobile' => Yii::t('base', 'Mobile'),
            'province_id' => Yii::t('base', 'Province ID'),
            'city_id' => Yii::t('base', 'City ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGames()
    {
        return $this->hasMany(Games::className(), ['player_1' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGames0()
    {
        return $this->hasMany(Games::className(), ['player_2' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGames1()
    {
        return $this->hasMany(Games::className(), ['winner_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGames2()
    {
        return $this->hasMany(Games::className(), ['loser_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGamesBoards()
    {
        return $this->hasMany(GamesBoards::className(), ['winner_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGamesBoardsDices()
    {
        return $this->hasMany(GamesBoardsDices::className(), ['player_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLigsGames()
    {
        return $this->hasMany(LigsGames::className(), ['player_1' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLigsGames0()
    {
        return $this->hasMany(LigsGames::className(), ['player_2' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLigsGames1()
    {
        return $this->hasMany(LigsGames::className(), ['winner_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLigsGames2()
    {
        return $this->hasMany(LigsGames::className(), ['loser_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLigsGamesBoards()
    {
        return $this->hasMany(LigsGamesBoards::className(), ['winner_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLigsGamesBoardsDices()
    {
        return $this->hasMany(LigsGamesBoardsDices::className(), ['player_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLigsPlayers()
    {
        return $this->hasMany(LigsPlayers::className(), ['player_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(UsersGroups::className(), ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(UsersStatus::className(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Provinces::className(), ['id' => 'province_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersFollowers()
    {
        return $this->hasMany(UsersFollowers::className(), ['follower_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersFollowers0()
    {
        return $this->hasMany(UsersFollowers::className(), ['follow_up_id' => 'id']);
    }
}
